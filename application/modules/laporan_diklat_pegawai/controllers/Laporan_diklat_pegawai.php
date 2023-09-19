<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";
require_once APPPATH . "third_party/fpdf/fpdf.php";

class Laporan_diklat_pegawai extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('laporan_diklat_pegawai/laporan_diklat_pegawai_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = ['assets/plugins/select2/js/select2.full.min.js'];
        $this->data['custom_js'] = ['laporan_diklat_pegawai/js', 'system/unitkerja_form-horizontal_filter_js'];
        $this->data['title_utama'] = 'Diklat Pegawai';
    }

    public function index() {
        $this->data['content'] = 'laporan_diklat_pegawai/index';
        $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat();
        $this->data['list_eselon_struktural'] = $this->list_model->list_eselon_struktural();
        $this->data['list_bulan'] = $this->list_model->list_bulan();
        $this->load->view('layouts/main', $this->data);
    }

    public function pencarian_proses() {
        $lokasi_id = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? trim($this->input->post('trlokasi_id', TRUE)) : '2';
        $kdu1 = (isset($_POST['kdu1_id']) && !empty($_POST['kdu1_id']) && $_POST['kdu1_id'] != -1) ? trim($this->input->post('kdu1_id', TRUE)) : '00';
        $kdu2 = (isset($_POST['kdu2_id']) && !empty($_POST['kdu2_id']) && $_POST['kdu2_id'] != -1) ? trim($this->input->post('kdu2_id', TRUE)) : '00';
        $kdu3 = (isset($_POST['kdu3_id']) && !empty($_POST['kdu3_id']) && $_POST['kdu3_id'] != -1) ? trim($this->input->post('kdu3_id', TRUE)) : '000';
        $kdu4 = (isset($_POST['kdu4_id']) && !empty($_POST['kdu4_id']) && $_POST['kdu4_id'] != -1) ? trim($this->input->post('kdu4_id', TRUE)) : '000';
        $kdu5 = (isset($_POST['kdu5_id']) && !empty($_POST['kdu5_id']) && $_POST['kdu5_id'] != -1) ? trim($this->input->post('kdu5_id', TRUE)) : '00';

        $this->data['model'] = $this->laporan_diklat_pegawai_model->get_data($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $this->data['struktur'] = $this->laporan_diklat_pegawai_model->get_struktur($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);

        $this->load->view("laporan_diklat_pegawai/_hasil", $this->data);
    }

    public function export_excel() {
        $lokasi_id = (isset($_GET['trlokasi_id']) && !empty($_GET['trlokasi_id'])) ? trim($this->input->get('trlokasi_id', TRUE)) : '2';
        $kdu1 = (isset($_GET['kdu1_id']) && !empty($_GET['kdu1_id']) && $_GET['kdu1_id'] != -1) ? trim($this->input->get('kdu1_id', TRUE)) : '00';
        $kdu2 = (isset($_GET['kdu2_id']) && !empty($_GET['kdu2_id']) && $_GET['kdu2_id'] != -1) ? trim($this->input->get('kdu2_id', TRUE)) : '00';
        $kdu3 = (isset($_GET['kdu3_id']) && !empty($_GET['kdu3_id']) && $_GET['kdu3_id'] != -1) ? trim($this->input->get('kdu3_id', TRUE)) : '000';
        $kdu4 = (isset($_GET['kdu4_id']) && !empty($_GET['kdu4_id']) && $_GET['kdu4_id'] != -1) ? trim($this->input->get('kdu4_id', TRUE)) : '000';
        $kdu5 = (isset($_GET['kdu5_id']) && !empty($_GET['kdu5_id']) && $_GET['kdu5_id'] != -1) ? trim($this->input->get('kdu5_id', TRUE)) : '00';

        $model = $this->laporan_diklat_pegawai_model->get_data($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $struktur = $this->laporan_diklat_pegawai_model->get_struktur($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Laporan Diklat Pegawai');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');

        $judul = 2;
        if (isset($struktur['NMSTRUKTUR']) && !empty($struktur['NMSTRUKTUR'])):
            $nmstruktur = '';
            $pecah = explode(", ", $struktur['NMSTRUKTUR']);
            if ($pecah > 0) {
                $awal = 0;
                foreach ($pecah as $val) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $pecah[$awal]);
                    $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':H' . $judul);
                    $judul++;
                    $awal++;
                }
            }
        endif;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':H' . $judul);

        $masihjudul = $judul + 1;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':H' . $masihjudul);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getStyle('A1:H' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:H' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $judultabel = $masihjudul + 2;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $judultabel, "No")
                ->setCellValue('B' . $judultabel, "NIP")
                ->setCellValue('C' . $judultabel, "Nama")
                ->setCellValue('D' . $judultabel, "Pendidikan")
                ->setCellValue('E' . $judultabel, "Diklat PIM / Tahun")
                ->setCellValue('F' . $judultabel, "Diklat Fungsional")
                ->setCellValue('G' . $judultabel, "Diklat Teknis")
                ->setCellValue('H' . $judultabel, "Diklat Lain");
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':H' . ($judultabel + $jumlah))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':H' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':H' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        unset($styleArray);
        $width = 100;
        $height = 50;
        $j = $judultabel + 1;
        $no_detail = 1;
        if ($model) {
            foreach ($model as $val) {
                $nama = ((!empty($val['GELAR_DEPAN'])) ? $val['GELAR_DEPAN'] . " " : "") . ($val['NAMA']) . ((!empty($val['GELAR_BLKG'])) ? ", " . $val['GELAR_BLKG'] : '');

                $diklat_pim = '';
                if ($val['diklat_pim']):
                    $k = 1;
                    foreach ($val['diklat_pim'] as $isi):
                        $diklat_pim .= $k . ". " . $isi['NAMA_JENJANG'] . "\n" . $isi['THN_DIKLAT'] . "\n";
                        $k++;
                    endforeach;
                endif;
                $diklat_fungsional = '';
                if ($val['diklat_fungsional']):
                    $k = 1;
                    foreach ($val['diklat_fungsional'] as $isi):
                        $diklat_fungsional .= $k . ". " . $isi['JENIS_DIKLAT_FUNGSIONAL'] . "\n" . $isi['KELOMPOK_FUNGSIONAL'] . " " . $isi['PENJENJANGAN_FUNGSIONAL'] . " " . $isi['NAMA_PENJENJANGAN'] . "\n";
                        $k++;
                    endforeach;
                endif;
                $diklat_teknis = '';
                if ($val['diklat_teknis']):
                    $k = 1;
                    foreach ($val['diklat_teknis'] as $isi):
                        $diklat_teknis .= $k . ". " . $isi['KETERANGAN'] . "\n";
                        $k++;
                    endforeach;
                endif;
                $diklat_lain = '';
                if ($val['diklat_lain']):
                    $k = 1;
                    foreach ($val['diklat_lain'] as $isi):
                        $diklat_lain .= $k.". ".$isi['NAMA_DIKLAT'] . "\n";
                        $k++;
                    endforeach;
                endif;
                $pendidikan = '';
                if ($val['pendidikan']):
                    $k = 1;
                    foreach ($val['pendidikan'] as $isi):
                        $pendidikan .= $k.". ".$isi['TINGKAT_PENDIDIKAN']." ".$isi['NAMA_JURUSAN'] . "\n";
                        $k++;
                    endforeach;
                endif;

                $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':H' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('F' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(120);
                
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $no_detail)
                        ->setCellValue('B' . $j, "`".$val['NIPNEW'])
                        ->setCellValue('C' . $j, $nama)
                        ->setCellValue('D' . $j, $pendidikan)
                        ->setCellValue('E' . $j, $diklat_pim)
                        ->setCellValue('F' . $j, $diklat_fungsional)
                        ->setCellValue('G' . $j, $diklat_teknis)
                        ->setCellValue('H' . $j, $diklat_lain);

                $no_detail++;
                $j++;
            }
        }
        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HLAPORAN DIKLAT PEGAWAI' . $this->config->item('instansi_panjang'));
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

    public function export_pdf() {
        $lokasi_id = (isset($_GET['trlokasi_id']) && !empty($_GET['trlokasi_id'])) ? trim($this->input->get('trlokasi_id', TRUE)) : '2';
        $kdu1 = (isset($_GET['kdu1_id']) && !empty($_GET['kdu1_id']) && $_GET['kdu1_id'] != -1) ? trim($this->input->get('kdu1_id', TRUE)) : '00';
        $kdu2 = (isset($_GET['kdu2_id']) && !empty($_GET['kdu2_id']) && $_GET['kdu2_id'] != -1) ? trim($this->input->get('kdu2_id', TRUE)) : '00';
        $kdu3 = (isset($_GET['kdu3_id']) && !empty($_GET['kdu3_id']) && $_GET['kdu3_id'] != -1) ? trim($this->input->get('kdu3_id', TRUE)) : '000';
        $kdu4 = (isset($_GET['kdu4_id']) && !empty($_GET['kdu4_id']) && $_GET['kdu4_id'] != -1) ? trim($this->input->get('kdu4_id', TRUE)) : '000';
        $kdu5 = (isset($_GET['kdu5_id']) && !empty($_GET['kdu5_id']) && $_GET['kdu5_id'] != -1) ? trim($this->input->get('kdu5_id', TRUE)) : '00';

        $this->data['model'] = $this->laporan_diklat_pegawai_model->get_data($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $this->data['struktur'] = $this->laporan_diklat_pegawai_model->get_struktur($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $this->data['content'] = 'laporan_diklat_pegawai/pdf';

        $this->load->view("layouts/print", $this->data);
    }

}
