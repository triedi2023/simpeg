<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Struktural_monitoring_kp extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('struktural_monitoring_kp/struktural_monitoring_kp_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = ['assets/plugins/select2/js/select2.full.min.js'];
        $this->data['custom_js'] = ['struktural_monitoring_kp/js', 'system/unitkerja_form-horizontal_filter_js'];
        $this->data['title_utama'] = 'Monitoring Kenaikan Pangkat';
    }

    public function index() {
        $this->data['content'] = 'struktural_monitoring_kp/index';
        $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat();
        $this->data['list_eselon_struktural'] = $this->list_model->list_eselon_struktural();
        $this->load->view('layouts/main', $this->data);
    }

    public function pencarian_proses() {
        $lokasi_id = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? trim($this->input->post('trlokasi_id', TRUE)) : '2';
        $kdu1 = (isset($_POST['kdu1_id']) && !empty($_POST['kdu1_id']) && $_POST['kdu1_id'] != -1) ? trim($this->input->post('kdu1_id', TRUE)) : '00';
        $kdu2 = (isset($_POST['kdu2_id']) && !empty($_POST['kdu2_id']) && $_POST['kdu2_id'] != -1) ? trim($this->input->post('kdu2_id', TRUE)) : '00';
        $kdu3 = (isset($_POST['kdu3_id']) && !empty($_POST['kdu3_id']) && $_POST['kdu3_id'] != -1) ? trim($this->input->post('kdu3_id', TRUE)) : '000';
        $kdu4 = (isset($_POST['kdu4_id']) && !empty($_POST['kdu4_id']) && $_POST['kdu4_id'] != -1) ? trim($this->input->post('kdu4_id', TRUE)) : '000';
        $kdu5 = (isset($_POST['kdu5_id']) && !empty($_POST['kdu5_id']) && $_POST['kdu5_id'] != -1) ? trim($this->input->post('kdu5_id', TRUE)) : '00';
        $jenis_pangkat = (isset($_POST['jenis_pangkat']) && !empty($_POST['jenis_pangkat'])) ? trim($this->input->post('jenis_pangkat', TRUE)) : 1;
        $gol_pangkat = (isset($_POST['gol_pangkat']) && !empty($_POST['gol_pangkat'])) ? trim($this->input->post('gol_pangkat', TRUE)) : '';
        $eselon_id = (isset($_POST['eselon_id']) && !empty($_POST['eselon_id'])) ? trim($this->input->post('eselon_id', TRUE)) : '';
        $bulan = (isset($_POST['bulan']) && !empty($_POST['bulan'])) ? trim($this->input->post('bulan', TRUE)) : '04';
        $tahun = (isset($_POST['tahun']) && !empty($_POST['tahun'])) ? trim($this->input->post('tahun', TRUE)) : date('Y');
        
        $this->data['model'] = $this->struktural_monitoring_kp_model->get_data($lokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5,$jenis_pangkat,$gol_pangkat,$eselon_id,$bulan,$tahun);
        $this->data['struktur'] = $this->struktural_monitoring_kp_model->get_struktur($lokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5);
        
        $this->load->view("struktural_monitoring_kp/_hasil", $this->data);
    }
    
    public function export_excel() {
        $lokasi_id = (isset($_GET['trlokasi_id']) && !empty($_GET['trlokasi_id'])) ? trim($this->input->get('trlokasi_id', TRUE)) : '2';
        $kdu1 = (isset($_GET['kdu1_id']) && !empty($_GET['kdu1_id']) && $_GET['kdu1_id'] != -1) ? trim($this->input->get('kdu1_id', TRUE)) : '00';
        $kdu2 = (isset($_GET['kdu2_id']) && !empty($_GET['kdu2_id']) && $_GET['kdu2_id'] != -1) ? trim($this->input->get('kdu2_id', TRUE)) : '00';
        $kdu3 = (isset($_GET['kdu3_id']) && !empty($_GET['kdu3_id']) && $_GET['kdu3_id'] != -1) ? trim($this->input->get('kdu3_id', TRUE)) : '000';
        $kdu4 = (isset($_GET['kdu4_id']) && !empty($_GET['kdu4_id']) && $_GET['kdu4_id'] != -1) ? trim($this->input->get('kdu4_id', TRUE)) : '000';
        $kdu5 = (isset($_GET['kdu5_id']) && !empty($_GET['kdu5_id']) && $_GET['kdu5_id'] != -1) ? trim($this->input->get('kdu5_id', TRUE)) : '00';
        $jenis_pangkat = (isset($_GET['jenis_pangkat']) && !empty($_GET['jenis_pangkat'])) ? trim($this->input->get('jenis_pangkat', TRUE)) : 1;
        $gol_pangkat = (isset($_GET['gol_pangkat']) && !empty($_GET['gol_pangkat'])) ? trim($this->input->get('gol_pangkat', TRUE)) : '';
        $eselon_id = (isset($_GET['eselon_id']) && !empty($_GET['eselon_id'])) ? trim($this->input->get('eselon_id', TRUE)) : '';
        $bulan = (isset($_GET['bulan']) && !empty($_GET['bulan'])) ? trim($this->input->get('bulan', TRUE)) : '04';
        $tahun = (isset($_GET['tahun']) && !empty($_GET['tahun'])) ? trim($this->input->get('tahun', TRUE)) : date('Y');

        $model = $this->struktural_monitoring_kp_model->get_data($lokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5,$jenis_pangkat,$gol_pangkat,$eselon_id,$bulan,$tahun);
        $struktur = $this->struktural_monitoring_kp_model->get_struktur($lokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5);
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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Proyeksi Kenaikan Pangkat');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');

        $judul = 2;
        if (isset($struktur['NMSTRUKTUR']) && !empty($struktur['NMSTRUKTUR'])):
            $nmstruktur = '';
            $pecah = explode(", ", $struktur['NMSTRUKTUR']);
            if ($pecah > 0) {
                $awal = 0;
                foreach ($pecah as $val) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $pecah[$awal]);
                    $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':G' . $judul);
                    $judul++;
                    $awal++;
                }
            }
        endif;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':G' . $judul);

        $masihjudul = $judul + 1;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':G' . $masihjudul);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(100);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getStyle('A1:G' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:G' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $judultabellagi = $masihjudul + 2;
        $judultabel = $masihjudul + 3;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $judultabellagi, "No")
                ->setCellValue('B' . $judultabellagi, "Nama / NIP / Lahir")
                ->setCellValue('C' . $judultabellagi, "Jabatan\na. TMT Jabatan")
                ->setCellValue('D' . $judultabellagi, "Pendidikan")
                ->setCellValue('E' . $judultabellagi, "Gol. Ruang & TMT")
                ->setCellValue('G' . $judultabellagi, "Keterangan");
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':G' . ($judultabel + $jumlah))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':G' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':G' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $judultabellagi . ':F' . $judultabellagi);
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('E' . $judultabel, "Lama")
                ->setCellValue('F' . $judultabel, "Baru");
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judultabellagi . ':A' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $judultabellagi . ':B' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $judultabellagi . ':C' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('D' . $judultabellagi . ':D' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $judultabellagi . ':G' . $judultabel);

        unset($styleArray);
        $width=100;
        $height=50;
        $j = $judultabel + 1;
        $no_detail = 1;
        if ($model) {
            foreach ($model as $val) {
                $nama = ((!empty($val['GELAR_DEPAN'])) ? $val['GELAR_DEPAN'] . " " : "") . ($val['NAMA']) . ((!empty($val['GELAR_BLKG'])) ? ", " . $val['GELAR_BLKG'] : '');
                
                $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':J' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(50);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$j)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $no_detail)
                        ->setCellValue('B' . $j, $nama."\n"."NIP. ".$val['NIPNEW']."\n".$val['TGL_LAHIR']."\n"."(".$val['UMUR'].")")
                        ->setCellValue('C' . $j, $val['N_JABATAN']."\n"."a. ".$val['TMT_JABATAN'])
                        ->setCellValue('D' . $j, $val['TINGKAT_PENDIDIKAN'])
                        ->setCellValue('E' . $j, $val['TRGOLONGAN']."\n".$val['TMT_GOL_ASLI'])
                        ->setCellValue('F' . $j, $val['GOLONGAN_LAMA']."\n".$val['NEXT_TMT_KP_CHAR'])
                        ->setCellValue('G' . $j, '');

                $no_detail++;
                $j++;
            }
        }

        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HDAFTAR PROYEKSI MONITORING KP ' . $this->config->item('instansi_panjang'));
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
        $jenis_pangkat = (isset($_GET['jenis_pangkat']) && !empty($_GET['jenis_pangkat'])) ? trim($this->input->get('jenis_pangkat', TRUE)) : 1;
        $gol_pangkat = (isset($_GET['gol_pangkat']) && !empty($_GET['gol_pangkat'])) ? trim($this->input->get('gol_pangkat', TRUE)) : '';
        $eselon_id = (isset($_GET['eselon_id']) && !empty($_GET['eselon_id'])) ? trim($this->input->get('eselon_id', TRUE)) : '';
        $bulan = (isset($_GET['bulan']) && !empty($_GET['bulan'])) ? trim($this->input->get('bulan', TRUE)) : '04';
        $tahun = (isset($_GET['tahun']) && !empty($_GET['tahun'])) ? trim($this->input->get('tahun', TRUE)) : date('Y');
        
        $this->data['model'] = $this->struktural_monitoring_kp_model->get_data($lokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5,$jenis_pangkat,$gol_pangkat,$eselon_id,$bulan,$tahun);
        $this->data['struktur'] = $this->struktural_monitoring_kp_model->get_struktur($lokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5);
        $this->data['content'] = 'struktural_monitoring_kp/pdf';
        
        $this->load->library('M_pdf');
        $this->m_pdf->set_paper('a4', 'landscape');
        $this->m_pdf->load_view("layouts/print", $this->data);
        $this->m_pdf->render();
        $this->m_pdf->stream($this->data['title_utama'] . " " . 'Periode ' . month_indo(date('m')) . " " . date("Y"));
    }

}
