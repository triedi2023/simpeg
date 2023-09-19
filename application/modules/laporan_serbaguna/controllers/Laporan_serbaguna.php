<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Laporan_serbaguna extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('laporan_serbaguna/laporan_serbaguna_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = array_merge(['assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js',
            'assets/plugins/select2/js/select2.full.min.js', 'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'assets/plugins/jquery-multi-select/js/jquery.multi-select.js', 'assets/plugins/bootstrap-select/js/bootstrap-select.min.js'], list_js_datatable());
        $this->data['custom_js'] = ['laporan_serbaguna/js', 'system/unitkerja_form-horizontal_filter_js'];
        $this->data['plugin_css'] = ['assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
            'assets/plugins/bootstrap-select/css/bootstrap-select.css', 'assets/plugins/jquery-multi-select/css/multi-select.css'];
        $this->data['title_utama'] = 'Serbaguna';
    }

    public function index() {
        $this->data['content'] = 'laporan_serbaguna/index';
        $this->data['list_jk'] = $this->config->item('list_jk');
        $this->data['list_gol_darah'] = $this->list_model->list_gol_darah();
        $this->data['list_bulan'] = $this->list_model->list_bulan();
        $this->data['list_agama'] = $this->list_model->list_agama();
        $this->data['list_pendidikan'] = $this->list_model->list_pendidikan();
        $this->data['list_fakultas'] = $this->list_model->list_fakultas();
        $this->data['list_eselon'] = $this->list_model->list_eselon();
        $this->data['list_kelompok_diklat_teknis'] = $this->list_model->list_kelompok_diklat_teknis();
        $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat();
        $this->data['list_tingkat_diklat_kepemimpinan'] = $this->list_model->list_tingkat_diklat_kepemimpinan();
        $this->data['list_provinsi'] = $this->list_model->list_provinsi();
        $this->data['list_jabatan'] = array_merge(array(array('ID'=>'0000','NAMA'=>'Jabatan ABK')),$this->list_model->list_jabatan());
        $this->data['list_kelompok_fungsional'] = $this->list_model->list_kelompok_fungsional();
        $this->data['list_sts_nikah'] = $this->list_model->list_sts_nikah();
        $this->data['list_diklat_teknis'] = $this->list_model->list_diklat_teknis();
        $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        $this->data['colSelect'] = $this->laporan_serbaguna_model->getSelectColumn();
        $this->data['jmlpegawai'] = $this->laporan_serbaguna_model->jmlpegawai()['JML'];
        $this->load->view('layouts/main', $this->data);
    }

    public function pencarian_proses() {
        $this->data['data_grid'] = $this->laporan_serbaguna_model->get_data($_POST['params']);
        $this->data['params'] = $_POST['params'];
        $this->data['colSelect'] = $this->laporan_serbaguna_model->getSelectColumn();

        $this->load->view("laporan_serbaguna/_hasil", $this->data);
    }

    public function export_excel() {
        $pa = json_decode($_GET['params'], true);
        $data_grid = $this->laporan_serbaguna_model->get_data($pa, 'excel');
        $colSelect = $this->laporan_serbaguna_model->getSelectColumn();
        $params = $pa;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_serbaguna.xls"');
        header('Cache-Control: max-age=0');

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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", $params['judul']);
        $r = array();
        $i = 1;
        $col = array('1' => 'A', '2' => 'B', '3' => 'C', '4' => 'D', '5' => 'E', '6' => 'F', '7' => 'G', '8' => 'H', '9' => 'I', '10' => 'J', '11' => 'K', '12' => 'L',
            '13' => 'M', '14' => 'N', '15' => 'O', '16' => 'P', '17' => 'Q', '18' => 'R', '19' => 'S', '20' => 'T', '21' => 'U', '22' => 'V', '23' => 'W', '24' => 'X',
            '25' => 'Y', '26' => 'Z', '27' => 'AA', '28' => 'AB', '29' => 'AC', '30' => 'AD', '31' => 'AE', '32' => 'AF', '33' => 'AG', '34' => 'AH', '35' => 'AI', '36' => 'AJ',
            '37' => 'AK', '38' => 'AL', '39' => 'AM', '40' => 'AN', '41' => 'AO', '42' => 'AP', '43' => 'AQ', '44' => 'AR', '45' => 'AS', '46' => 'AT', '47' => 'AU', '48' => 'AV');
        foreach ($data_grid as $row) {
            $r = $row;
            break;
        }
        $row = 2;
        foreach ($r as $key => $val) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col[$i] . $row, $colSelect[strtolower($key)]);
            $objPHPExcel->getActiveSheet()->getStyle($col[$i] . $row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle($col[$i] . $row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle($col[$i] . $row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle($col[$i] . $row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getColumnDimension($col[$i])->setAutoSize(true);
            $i++;
        }
        $row++;
        foreach ($data_grid as $record) {
            $colIdx = 1;
            foreach ($record as $key => $val) {
                if ($key == "FOTO") {
                    $foto = "./_uploads/photo_pegawai/thumbs/" . $val;
                    if (file_exists($foto)) {
                        $objDrawing = new PHPExcel_Worksheet_Drawing();
                        $objDrawing->setName('Foto');
                        $objDrawing->setDescription('Foto');
                        $foto = "./_uploads/photo_pegawai/thumbs/".$val;
                        $objDrawing->setPath($foto);
                        $objDrawing->setCoordinates($col[$colIdx] . $row);
                        $objDrawing->setWidthAndHeight(200,80);
                        $objDrawing->setResizeProportional(false);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col[$colIdx] . $row, '                      ');
                        $objPHPExcel->getActiveSheet()->getStyle($col[$colIdx] . $row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyle($col[$colIdx] . $row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(100);
                    }
                } else {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col[$colIdx] . $row, $val);
                    $objPHPExcel->getActiveSheet()->getStyle($col[$colIdx] . $row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyle($col[$colIdx] . $row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($col[$colIdx])->setAutoSize(true);
                }
                $colIdx++;
            }
            $row++;
        }
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->setTitle('Printing');
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}
