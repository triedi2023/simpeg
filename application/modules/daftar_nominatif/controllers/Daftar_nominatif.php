<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Daftar_nominatif extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('daftar_nominatif/daftar_nominatif_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = ['assets/plugins/select2/js/select2.full.min.js'];
        $this->data['custom_js'] = ['daftar_nominatif/js', 'system/unitkerja_form-horizontal_filter_js'];
        $this->data['title_utama'] = 'Eselon';
    }

    public function index() {
        $this->data['content'] = 'daftar_nominatif/index';
        $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        $this->data['list_kelompok_fungsional'] = $this->list_model->list_kelompok_fungsional();
        $this->data['list_status_fungsional'] = $this->list_model->list_status_fungsional();
        $this->load->view('layouts/main', $this->data);
    }

    public function pencarian_proses() {
        $lokasi_id = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? trim($this->input->post('trlokasi_id', TRUE)) : '2';
        $kdu1 = (isset($_POST['kdu1_id']) && !empty($_POST['kdu1_id']) && $_POST['kdu1_id'] != -1) ? trim($this->input->post('kdu1_id', TRUE)) : '00';
        $kdu2 = (isset($_POST['kdu2_id']) && !empty($_POST['kdu2_id']) && $_POST['kdu2_id'] != -1) ? trim($this->input->post('kdu2_id', TRUE)) : '00';
        $kdu3 = (isset($_POST['kdu3_id']) && !empty($_POST['kdu3_id']) && $_POST['kdu3_id'] != -1) ? trim($this->input->post('kdu3_id', TRUE)) : '000';
        $kdu4 = (isset($_POST['kdu4_id']) && !empty($_POST['kdu4_id']) && $_POST['kdu4_id'] != -1) ? trim($this->input->post('kdu4_id', TRUE)) : '000';
        $kdu5 = (isset($_POST['kdu5_id']) && !empty($_POST['kdu5_id']) && $_POST['kdu5_id'] != -1) ? trim($this->input->post('kdu5_id', TRUE)) : '00';

        $this->data['model'] = $this->daftar_nominatif_model->get_data($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $this->data['struktur'] = $this->daftar_nominatif_model->get_struktur($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);

        $this->load->view("daftar_nominatif/_hasil", $this->data);
    }

    public function export_excel() {
        $lokasi_id = (isset($_GET['trlokasi_id']) && !empty($_GET['trlokasi_id'])) ? trim($this->input->get('trlokasi_id', TRUE)) : '2';
        $kdu1 = (isset($_GET['kdu1_id']) && !empty($_GET['kdu1_id']) && $_GET['kdu1_id'] != -1) ? trim($this->input->get('kdu1_id', TRUE)) : '00';
        $kdu2 = (isset($_GET['kdu2_id']) && !empty($_GET['kdu2_id']) && $_GET['kdu2_id'] != -1) ? trim($this->input->get('kdu2_id', TRUE)) : '00';
        $kdu3 = (isset($_GET['kdu3_id']) && !empty($_GET['kdu3_id']) && $_GET['kdu3_id'] != -1) ? trim($this->input->get('kdu3_id', TRUE)) : '000';
        $kdu4 = (isset($_GET['kdu4_id']) && !empty($_GET['kdu4_id']) && $_GET['kdu4_id'] != -1) ? trim($this->input->get('kdu4_id', TRUE)) : '000';
        $kdu5 = (isset($_GET['kdu5_id']) && !empty($_GET['kdu5_id']) && $_GET['kdu5_id'] != -1) ? trim($this->input->get('kdu5_id', TRUE)) : '00';
        $gol_pangkat = (isset($_GET['gol_pangkat']) && !empty($_GET['gol_pangkat'])) ? trim($this->input->get('gol_pangkat', TRUE)) : '';
        $eselon_id = (isset($_GET['eselon_id']) && !empty($_GET['eselon_id'])) ? trim($this->input->get('eselon_id', TRUE)) : '';
        $bulan1 = (isset($_GET['bulan1']) && !empty($_GET['bulan1'])) ? trim($this->input->get('bulan1', TRUE)) : date('m');
        $tahun1 = (isset($_GET['tahun1']) && !empty($_GET['tahun1'])) ? trim($this->input->get('tahun1', TRUE)) : date('Y');
        $bulan2 = (isset($_GET['bulan2']) && !empty($_GET['bulan2'])) ? trim($this->input->get('bulan2', TRUE)) : date('m');
        $tahun2 = (isset($_GET['tahun2']) && !empty($_GET['tahun2'])) ? trim($this->input->get('tahun2', TRUE)) : date('Y') + 1;

        $model = $this->daftar_nominatif_model->get_data($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5, $gol_pangkat, $eselon_id, $bulan1, $tahun1, $bulan2, $tahun2);
        $struktur = $this->daftar_nominatif_model->get_struktur($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $jumlah = count($model);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Kepegawaian")
                ->setLastModifiedBy("Kepegawaian")
                ->setTitle($this->config->item('instansi_panjang'))
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription($this->data['title_utama'])
                ->setKeywords($this->data['title_utama'])
                ->setCategory($this->data['title_utama']);

        $styleArray = array(
            'font' => array(
                'bold' => false,
                'size' => 9
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'getStartColor' => array(
                    'argb' => '000000'
                )
            ),
        );
        $style = array(
            'font' => array(
                'bold'  => true
        ));

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Daftar Nominatif');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');

        $judul = 2;
        if (isset($struktur['NMSTRUKTUR']) && !empty($struktur['NMSTRUKTUR'])):
            $nmstruktur = '';
            $pecah = explode(", ", $struktur['NMSTRUKTUR']);
            if ($pecah > 0) {
                $awal = 0;
                foreach ($pecah as $val) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $pecah[$awal]);
                    $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':F' . $judul);
                    $judul++;
                    $awal++;
                }
            }
        endif;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':F' . $judul);

        $masihjudul = $judul + 1;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':F' . $masihjudul);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(100);
        $objPHPExcel->getActiveSheet()->getStyle('A1:F' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:F' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $judultabel = $masihjudul + 2;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $judultabel, "No")
                ->setCellValue('C' . $judultabel, "NIP")
                ->setCellValue('D' . $judultabel, "Nama")
                ->setCellValue('E' . $judultabel, "Pangkat / Gol")
                ->setCellValue('F' . $judultabel, "Jabatan");
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':F' . ($judultabel + $jumlah))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':F' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':F' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judultabel . ':B' . $judultabel);

        unset($styleArray);
        $width = 100;
        $height = 50;
        $j = $judultabel + 1;
        $no_detail = 1;
        if ($model) {
            $urutanunitkerja = '';
            foreach ($model as $val) {
                if ($val['TKTESELON'] == '1') {
                    $urutanunitkerja = ($val['KDU1']);
                } elseif ($val['TKTESELON'] == '2') {
                    $urutanunitkerja = ($val['KDU2']);
                } elseif ($val['TKTESELON'] == '3') {
                    $urutanunitkerja = ($val['KDU3']);
                } elseif ($val['TKTESELON'] == '4') {
                    $urutanunitkerja = ($val['KDU4']);
                } elseif ($val['TKTESELON'] == '5') {
                    $urutanunitkerja = ($val['KDU5']);
                }

                if (!empty($val['NMUNIT'])) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $j, Romawi($urutanunitkerja) . ". " . $val['NMUNIT']);
                    $objPHPExcel->getActiveSheet()->mergeCells('A' . $j . ':F' . $j);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j)->getFill()->getStartColor()->setRGB('fbe1e3');
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$j)->applyFromArray($style);
                } else {
                    $nama = ((!empty($val['GELAR_DEPAN'])) ? $val['GELAR_DEPAN'] . " " : "") . ($val['NAMA']) . ((!empty($val['GELAR_BLKG'])) ? ", " . $val['GELAR_BLKG'] : '');
//
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':F' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $j, $val['NUMBERDUA'])
                            ->setCellValue('B' . $j, $val['NUMBERTIGA'])
                            ->setCellValue('C' . $j, "`" . $val['NIPNEW'])
                            ->setCellValue('D' . $j, $nama)
                            ->setCellValue('E' . $j, ($val['TRSTATUSKEPEGAWAIAN_ID'] == '1') ? $val['PANGKAT'] . " (" . $val['GOLONGAN'] . ") " : $val['PANGKAT'])
                            ->setCellValue('F' . $j, $val['JABATAN']);
                }
                $no_detail++;
                $j++;
            }
        }

        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HDAFTAR NOMINATIF ESELON ' . $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        // Set page orientation and size
        //echo date('H:i:s') . " Set page orientation and size\n";
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        // Rename sheet
        //echo date('H:i:s') . " Rename sheet\n";
        $objPHPExcel->getActiveSheet()->setTitle($this->data['title_utama']);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $this->data['title_utama'] . " " . 'Periode ' . month_indo(date('m')) . " " . date("Y") . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}
