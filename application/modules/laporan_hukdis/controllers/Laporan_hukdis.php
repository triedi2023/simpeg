<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";
require_once APPPATH . "third_party/fpdf/fpdf.php";

class Laporan_hukdis extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('laporan_hukdis/laporan_hukdis_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = ['assets/plugins/select2/js/select2.full.min.js'];
        $this->data['custom_js'] = ['laporan_hukdis/js'];
        $this->data['title_utama'] = 'Laporan Hukdis &sol; Sanksi';
    }

    public function index() {
        $this->data['content'] = 'laporan_hukdis/index';
        $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        $this->data['list_tkt_hukdis'] = $this->list_model->list_tkt_hukdis();
        $this->load->view('layouts/main', $this->data);
    }

    public function pencarian_proses() {
        $tingkat_hukdis = (isset($_POST['tingkat_hukdis']) && !empty($_POST['tingkat_hukdis'])) ? trim($this->input->post('tingkat_hukdis', TRUE)) : '';
        $bentuk_laporan = (isset($_POST['bentuk_laporan']) && !empty($_POST['bentuk_laporan'])) ? trim($this->input->post('bentuk_laporan', TRUE)) : '';

        $this->data['title'] = $this->laporan_hukdis_model->get_tkt_hukdis($tingkat_hukdis);
        if ($bentuk_laporan == "true") {
            $this->data['model'] = $this->laporan_hukdis_model->get_data_komposisi($tingkat_hukdis);
            $this->load->view("laporan_hukdis/_komposisi", $this->data);
        } else {
            $this->data['model'] = $this->laporan_hukdis_model->get_data($tingkat_hukdis);
            $this->load->view("laporan_hukdis/_hasil", $this->data);
        }
    }

    public function export_excel() {
        $tingkat_hukdis = (isset($_GET['tingkat_hukdis']) && !empty($_GET['tingkat_hukdis'])) ? trim($this->input->get('tingkat_hukdis', TRUE)) : '';
        $bentuk_laporan = (isset($_GET['bentuk_laporan']) && !empty($_GET['bentuk_laporan'])) ? trim($this->input->get('bentuk_laporan', TRUE)) : '';

        $title = $this->laporan_hukdis_model->get_tkt_hukdis($tingkat_hukdis);
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
        if ($bentuk_laporan == "true") {
            $model = $this->laporan_hukdis_model->get_data_komposisi($tingkat_hukdis);
            $jumlah = count($model);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Komposisi Daftar Hukuman Disiplin / Sanksi');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Dengan Tingkat Hukuman Disiplin / Sanksi '.$title['TKT_HUKUMAN_DISIPLIN']);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:C2');

            $judul = 3;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':C' . $judul);

            $masihjudul = $judul + 1;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Sampai Dengan ' . month_indo(date('m')) . " " . date("Y"));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':C' . $masihjudul);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getStyle('A1:C' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:C' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

            $judultabel = $masihjudul + 2;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $judultabel, "No")
                    ->setCellValue('B' . $judultabel, "Jenis Hukuman")
                    ->setCellValue('C' . $judultabel, "Jumlah");
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':C' . ($judultabel + $jumlah))->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':C' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':C' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            unset($styleArray);
            $width = 100;
            $height = 50;
            $j = $judultabel + 1;
            $no_detail = 1;
            if ($model) {
                foreach ($model as $val) {
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':C' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(50);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $j)->getAlignment()->setWrapText(true);
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $j, $no_detail)
                            ->setCellValue('B' . $j, $val['JENIS_HUKDIS'])
                            ->setCellValue('C' . $j, $val['JML']);

                    $no_detail++;
                    $j++;
                }
            }
        } else {
            $model = $this->laporan_hukdis_model->get_data($tingkat_hukdis);
            $jumlah = count($model);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Daftar Hukuman Disiplin / Sanksi');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Dengan Tingkat Hukuman Disiplin / Sanksi '.$title['TKT_HUKUMAN_DISIPLIN']);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');

            $judul = 3;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':I' . $judul);

            $masihjudul = $judul + 1;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Sampai Dengan ' . month_indo(date('m')) . " " . date("Y"));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':I' . $masihjudul);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getStyle('A1:I' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:I' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

            $judultabel = $masihjudul + 2;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $judultabel, "No")
                    ->setCellValue('B' . $judultabel, "NIP")
                    ->setCellValue('C' . $judultabel, "Nama")
                    ->setCellValue('D' . $judultabel, "Tingkat Hukuman")
                    ->setCellValue('E' . $judultabel, "Jenis Hukuman")
                    ->setCellValue('F' . $judultabel, "Alasan Hukuman")
                    ->setCellValue('G' . $judultabel, "TMT Hukuman")
                    ->setCellValue('H' . $judultabel, "Nomor / Tanggal SK")
                    ->setCellValue('I' . $judultabel, "Unit Kerja");
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':I' . ($judultabel + $jumlah))->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':I' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':I' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
            unset($styleArray);
            $width = 100;
            $height = 50;
            $j = $judultabel + 1;
            $no_detail = 1;
            if ($model) {
                foreach ($model as $val) {
                    $nama = ((!empty($val['GELAR_DEPAN'])) ? $val['GELAR_DEPAN'] . " " : "") . ($val['NAMA']) . ((!empty($val['GELAR_BLKG'])) ? ", " . $val['GELAR_BLKG'] : '');

                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':I' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(50);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $j)->getAlignment()->setWrapText(true);
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $j, $no_detail)
                            ->setCellValue('B' . $j, $val['NIPNEW'])
                            ->setCellValue('C' . $j, $nama)
                            ->setCellValue('D' . $j, $val['TKT_HUKUMAN_DISIPLIN'])
                            ->setCellValue('E' . $j, $val['JENIS_HUKDIS'])
                            ->setCellValue('F' . $j, $val['ALASAN_HKMN'])
                            ->setCellValue('G' . $j, $val['TMT_HKMN2']." S/D ".$val['AKHIR_HKMN2'])
                            ->setCellValue('H' . $j, $val['NO_SK']." ".$val['TGL_SK2'])
                            ->setCellValue('I' . $j, $val['NAMA_UNIT_KERJA']);

                    $no_detail++;
                    $j++;
                }
            }
        }

        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HDAFTAR HUKUMAN DISIPLIN ' . $this->config->item('instansi_panjang'));
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
        $tingkat_hukdis = (isset($_GET['tingkat_hukdis']) && !empty($_GET['tingkat_hukdis'])) ? trim($this->input->get('tingkat_hukdis', TRUE)) : '';
        $bentuk_laporan = (isset($_GET['bentuk_laporan']) && !empty($_GET['bentuk_laporan'])) ? trim($this->input->get('bentuk_laporan', TRUE)) : '';
        
        $this->data['title'] = $this->laporan_hukdis_model->get_tkt_hukdis($tingkat_hukdis);
        if ($bentuk_laporan == "true") {
            $this->data['model'] = $this->laporan_hukdis_model->get_data_komposisi($tingkat_hukdis);
            $this->data['content'] = 'laporan_hukdis/_komposisipdf';
        } else {
            $this->data['model'] = $this->laporan_hukdis_model->get_data($tingkat_hukdis);
            $this->data['content'] = 'laporan_hukdis/_hasilpdf';
        }
        
        $this->load->view("layouts/print", $this->data);
    }

}
