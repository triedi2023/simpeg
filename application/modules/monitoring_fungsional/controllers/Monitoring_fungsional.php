<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Monitoring_fungsional extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('monitoring_fungsional/monitoring_fungsional_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = ['assets/plugins/select2/js/select2.full.min.js'];
        $this->data['custom_js'] = ['monitoring_fungsional/js', 'system/unitkerja_form-horizontal_filter_js'];
        $this->data['title_utama'] = 'Monitoring Fungsional';
    }

    public function index() {
        $this->data['content'] = 'monitoring_fungsional/index';
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
        $kelompok_jabatan = (isset($_POST['kelompok_jabatan']) && !empty($_POST['kelompok_jabatan'])) ? trim($this->input->post('kelompok_jabatan', TRUE)) : '';
        $status = (isset($_POST['status']) && !empty($_POST['status'])) ? trim($this->input->post('status', TRUE)) : '';
        
        $this->data['model'] = $this->monitoring_fungsional_model->get_data($lokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5,$kelompok_jabatan,$status);
        $this->data['struktur'] = $this->monitoring_fungsional_model->get_struktur($lokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5);
        
        $this->load->view("monitoring_fungsional/_hasil", $this->data);
    }
    
    public function export_excel() {
        $lokasi_id = (isset($_GET['trlokasi_id']) && !empty($_GET['trlokasi_id'])) ? trim($this->input->get('trlokasi_id', TRUE)) : '2';
        $kdu1 = (isset($_GET['kdu1_id']) && !empty($_GET['kdu1_id']) && $_GET['kdu1_id'] != -1) ? trim($this->input->get('kdu1_id', TRUE)) : '00';
        $kdu2 = (isset($_GET['kdu2_id']) && !empty($_GET['kdu2_id']) && $_GET['kdu2_id'] != -1) ? trim($this->input->get('kdu2_id', TRUE)) : '00';
        $kdu3 = (isset($_GET['kdu3_id']) && !empty($_GET['kdu3_id']) && $_GET['kdu3_id'] != -1) ? trim($this->input->get('kdu3_id', TRUE)) : '000';
        $kdu4 = (isset($_GET['kdu4_id']) && !empty($_GET['kdu4_id']) && $_GET['kdu4_id'] != -1) ? trim($this->input->get('kdu4_id', TRUE)) : '000';
        $kdu5 = (isset($_GET['kdu5_id']) && !empty($_GET['kdu5_id']) && $_GET['kdu5_id'] != -1) ? trim($this->input->get('kdu5_id', TRUE)) : '00';
        $kelompok_jabatan = (isset($_GET['kelompok_jabatan']) && !empty($_GET['kelompok_jabatan'])) ? trim($this->input->get('kelompok_jabatan', TRUE)) : '';
        $status = (isset($_GET['status']) && !empty($_GET['status'])) ? trim($this->input->get('status', TRUE)) : '';

        $model = $this->monitoring_fungsional_model->get_data($lokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5,$kelompok_jabatan,$status);
        $struktur = $this->monitoring_fungsional_model->get_struktur($lokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5);
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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Monitoring Jabatan Fungsional');
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(100);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A1:F' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:F' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $judultabel = $masihjudul + 2;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $judultabel, "No")
                ->setCellValue('B' . $judultabel, "Nama / NIP")
                ->setCellValue('C' . $judultabel, "Gol / Ruang")
                ->setCellValue('D' . $judultabel, "Jabatan / a. TMT Jabatan")
                ->setCellValue('E' . $judultabel, "Masa Kerja (Tahun / Bulan)")
                ->setCellValue('F' . $judultabel, "Status");
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':F' . ($judultabel + $jumlah))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':F' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':F' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        unset($styleArray);
        $width=100;
        $height=30;
        $j = $judultabel + 1;
        $no_detail = 1;
        if ($model) {
            foreach ($model as $val) {
                $nama = ((!empty($val['GELAR_DEPAN'])) ? $val['GELAR_DEPAN'] . " " : "") . ($val['NAMA']) . ((!empty($val['GELAR_BLKG'])) ? ", " . $val['GELAR_BLKG'] : '');
                
                $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':J' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(50);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$j)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $no_detail)
                        ->setCellValue('B' . $j, $nama."\n"."NIP. ".$val['NIPNEW'])
                        ->setCellValue('C' . $j, $val['PANGKAT']." (".$val['GOLONGAN'].")")
                        ->setCellValue('D' . $j, $val['JABATAN']."\n"."a. ".$val['TMT_JABATAN'])
                        ->setCellValue('E' . $j, $val['MK_THN_TOTAL']." Tahun ".$val['MK_BLN_TOTAL']." Bulan")
                        ->setCellValue('F' . $j, $val['STATUS_FUNGSIONAL']);

                $no_detail++;
                $j++;
            }
        }

        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HDAFTAR MONITORING FUNGSIONAL ' . $this->config->item('instansi_panjang'));
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
        $kelompok_jabatan = (isset($_GET['kelompok_jabatan']) && !empty($_GET['kelompok_jabatan'])) ? trim($this->input->get('kelompok_jabatan', TRUE)) : '';
        $status = (isset($_GET['status']) && !empty($_GET['status'])) ? trim($this->input->get('status', TRUE)) : '';

        $this->data['model'] = $this->monitoring_fungsional_model->get_data($lokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5,$kelompok_jabatan,$status);
        $this->data['struktur'] = $this->monitoring_fungsional_model->get_struktur($lokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5);
        $this->data['content'] = 'monitoring_fungsional/pdf';
        
        $this->load->library('M_pdf');
        $this->m_pdf->set_paper('a4', 'landscape');
        $this->m_pdf->load_view("layouts/print", $this->data);
        $this->m_pdf->render();
        $this->m_pdf->stream($this->data['title_utama'] . " " . 'Periode ' . month_indo(date('m')) . " " . date("Y"));
    }

}
