<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";
require_once APPPATH . "third_party/fpdf/fpdf.php";

class Statistik_diklat_pim extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('statistik_diklat_pim/statistik_diklat_pim_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = ['assets/plugins/select2/js/select2.full.min.js', 'assets/plugins/amcharts/amcharts.js?v=' . uniqid(), 'assets/plugins/amcharts/pie.js?v=' . uniqid()];
        $this->data['custom_js'] = ['statistik_diklat_pim/js', 'system/unitkerja_form-horizontal_filter_js'];
        $this->data['title_utama'] = 'PIM';
    }

    public function index() {
        $this->data['content'] = 'statistik_diklat_pim/index';
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
        $jenis_keluaran = (isset($_POST['jenis_keluaran']) && !empty($_POST['jenis_keluaran'])) ? trim($this->input->post('jenis_keluaran', TRUE)) : 1;
        $bentuk_keluaran = (isset($_POST['bentuk']) && !empty($_POST['bentuk'])) ? trim($this->input->post('bentuk', TRUE)) : '';

        $this->data['struktur'] = $this->statistik_diklat_pim_model->get_struktur($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        if ($jenis_keluaran == 2) {
            $jml = json_encode($this->statistik_diklat_pim_model->get_data_chart($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5));
            $this->data['model'] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $jml);
            $this->load->view("statistik_diklat_pim/_hasil_chart", $this->data);
        } else {
            if ($bentuk_keluaran == 1) {
                $this->data['model'] = $this->statistik_diklat_pim_model->get_data_matrix($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
                $this->load->view("statistik_diklat_pim/_hasil", $this->data);
            } else {
                $this->data['model'] = $this->statistik_diklat_pim_model->get_data($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5, $bentuk_keluaran);
                $this->load->view("statistik_diklat_pim/_hasil_2", $this->data);
            }
        }
    }

    public function export_excel_1() {
        $lokasi_id = (isset($_GET['trlokasi_id']) && !empty($_GET['trlokasi_id'])) ? trim($this->input->get('trlokasi_id', TRUE)) : '2';
        $kdu1 = (isset($_GET['kdu1_id']) && !empty($_GET['kdu1_id']) && $_GET['kdu1_id'] != -1) ? trim($this->input->get('kdu1_id', TRUE)) : '00';
        $kdu2 = (isset($_GET['kdu2_id']) && !empty($_GET['kdu2_id']) && $_GET['kdu2_id'] != -1) ? trim($this->input->get('kdu2_id', TRUE)) : '00';
        $kdu3 = (isset($_GET['kdu3_id']) && !empty($_GET['kdu3_id']) && $_GET['kdu3_id'] != -1) ? trim($this->input->get('kdu3_id', TRUE)) : '000';
        $kdu4 = (isset($_GET['kdu4_id']) && !empty($_GET['kdu4_id']) && $_GET['kdu4_id'] != -1) ? trim($this->input->get('kdu4_id', TRUE)) : '000';
        $kdu5 = (isset($_GET['kdu5_id']) && !empty($_GET['kdu5_id']) && $_GET['kdu5_id'] != -1) ? trim($this->input->get('kdu5_id', TRUE)) : '00';
        $jenis_keluaran = (isset($_GET['jenis_keluaran']) && !empty($_GET['jenis_keluaran'])) ? trim($this->input->get('jenis_keluaran', TRUE)) : 2;
        $bentuk_keluaran = (isset($_GET['bentuk']) && !empty($_GET['bentuk'])) ? trim($this->input->get('bentuk', TRUE)) : '';

        $model = $this->statistik_diklat_pim_model->get_data_matrix($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $struktur = $this->statistik_diklat_pim_model->get_struktur($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
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
                'bold' => true
        ));

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'KOMPOSISI PEGAWAI');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:N1');

        $judul = 2;
        if (isset($struktur['NMSTRUKTUR']) && !empty($struktur['NMSTRUKTUR'])):
            $nmstruktur = '';
            $pecah = explode(", ", $struktur['NMSTRUKTUR']);
            if ($pecah > 0) {
                $awal = 0;
                foreach ($pecah as $val) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $pecah[$awal]);
                    $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':N' . $judul);
                    $judul++;
                    $awal++;
                }
            }
        endif;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':N' . $judul);

        $masihjudul = $judul + 1;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':N' . $masihjudul);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getStyle('A1:N' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:N' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $judultabel = $masihjudul + 2;
        $judultabellagi = $masihjudul + 3;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $judultabel, 'No')
                ->setCellValue('B' . $judultabel, 'Unit Kerja')
                ->setCellValue('C' . $judultabel, 'PIM IV')
                ->setCellValue('E' . $judultabel, 'PIM III')
                ->setCellValue('G' . $judultabel, 'PIM II')
                ->setCellValue('I' . $judultabel, 'PIM I')
                ->setCellValue('K' . $judultabel, 'Lemhanas')
                ->setCellValue('M' . $judultabel, 'Jumlah')
                ->setCellValue('C' . $judultabellagi, '(L)')
                ->setCellValue('D' . $judultabellagi, '(P)')
                ->setCellValue('E' . $judultabellagi, '(L)')
                ->setCellValue('F' . $judultabellagi, '(P)')
                ->setCellValue('G' . $judultabellagi, '(L)')
                ->setCellValue('H' . $judultabellagi, '(P)')
                ->setCellValue('I' . $judultabellagi, '(L)')
                ->setCellValue('J' . $judultabellagi, '(P)')
                ->setCellValue('K' . $judultabellagi, '(L)')
                ->setCellValue('L' . $judultabellagi, '(P)')
                ->setCellValue('M' . $judultabellagi, '(L)')
                ->setCellValue('N' . $judultabellagi, '(P)');

        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':N' . ($judultabel + $jumlah + 1))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':N' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':N' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $judultabel . ':D' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $judultabel . ':F' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $judultabel . ':H' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('I' . $judultabel . ':J' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('K' . $judultabel . ':L' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('M' . $judultabel . ':N' . $judultabel);

        unset($styleArray);
        $width = 100;
        $height = 50;
        $j = $judultabel + 1;
        $no_detail = 1;
        $no_parent = 1;
        $total_es4l = 0;
        $total_es4p = 0;
        $total_es3l = 0;
        $total_es3p = 0;
        $total_es2l = 0;
        $total_es2p = 0;
        $total_es1l = 0;
        $total_es1p = 0;
        $total_es1_fk_l = 0;
        $total_es1_fk_p = 0;
        $total_es1_fu_l = 0;
        $total_es1_fu_p = 0;
        $sum_l = 0;
        $sum_p = 0;
        $sum = 0;
        $pim_tk4_l = 0;
        $pim_tk4_p = 0;
        $pim_tk3_l = 0;
        $pim_tk3_p = 0;
        $pim_tk2_l = 0;
        $pim_tk2_p = 0;
        $pim_tk1_l = 0;
        $pim_tk1_p = 0;
        $lemhanas_l = 0;
        $lemhanas_p = 0;
        $es1_fu_l = 0;
        $es1_fu_p = 0;
        $tot_sum_l = 0;
        $tot_sum_p = 0;
        $tot_sum = 0;
        $tot_sum_l_all = 0;
        $tot_sum_p_all = 0;
        $tot_sum_all = 0;
        if ($model) {
            foreach ($model as $r1) {
                $sum_l_all = $r1['PIM_TK4_L'] + $r1['PIM_TK3_L'] + $r1['PIM_TK2_L'] + $r1['PIM_TK1_L'] + $r1['LEMHANAS_L'];
                $sum_p_all = $r1['PIM_TK4_P'] + $r1['PIM_TK3_P'] + $r1['PIM_TK2_P'] + $r1['PIM_TK1_P'] + $r1['LEMHANAS_P'];
                $sum_l = $r1['PIM_TK4_L'] + $r1['PIM_TK3_L'] + $r1['PIM_TK2_L'] + $r1['PIM_TK1_L'] + $r1['LEMHANAS_L'];
                $sum_p = $r1['PIM_TK4_P'] + $r1['PIM_TK3_P'] + $r1['PIM_TK2_P'] + $r1['PIM_TK1_P'] + $r1['LEMHANAS_P'];
                $sum_all = $r1['PIM_TK4_P'] + $r1['PIM_TK3_P'] + $r1['PIM_TK2_P'] + $r1['PIM_TK1_P'] + $r1['LEMHANAS_P'] + $r1['PIM_TK4_L'] + $r1['PIM_TK3_L'] + $r1['PIM_TK2_L'] + $r1['PIM_TK1_L'] + $r1['LEMHANAS_L'];
                $sum = $sum_l + $sum_p;
                $total_es4l = $total_es4l + $r1['PIM_TK4_L'];
                $total_es4p = $total_es4p + $r1['PIM_TK4_P'];
                $total_es3l = $total_es3l + $r1['PIM_TK3_L'];
                $total_es3p = $total_es3p + $r1['PIM_TK3_P'];
                $total_es2l = $total_es2l + $r1['PIM_TK2_L'];
                $total_es2p = $total_es2p + $r1['PIM_TK2_P'];
                $total_es1l = $total_es1l + $r1['PIM_TK1_L'];
                $total_es1p = $total_es1p + $r1['PIM_TK1_P'];
                $total_es1_fk_l = $total_es1_fk_l + $r1['LEMHANAS_L'];
                $total_es1_fk_p = $total_es1_fk_p + $r1['LEMHANAS_P'];

                $pim_tk4_l = $pim_tk4_l + $r1['PIM_TK4_L'];
                $pim_tk4_p = $pim_tk4_p + $r1['PIM_TK4_P'];
                $pim_tk3_l = $pim_tk3_l + $r1['PIM_TK3_L'];
                $pim_tk3_p = $pim_tk3_p + $r1['PIM_TK3_P'];
                $pim_tk2_l = $pim_tk2_l + $r1['PIM_TK2_L'];
                $pim_tk2_p = $pim_tk2_p + $r1['PIM_TK2_P'];
                $pim_tk1_l = $pim_tk1_l + $r1['PIM_TK1_L'];
                $pim_tk1_p = $pim_tk1_p + $r1['PIM_TK1_P'];
                $lemhanas_l = $lemhanas_l + $r1['LEMHANAS_L'];
                $lemhanas_p = $lemhanas_p + $r1['LEMHANAS_P'];

                $tot_sum_l = $tot_sum_l + $sum_l;
                $tot_sum_l_all = $tot_sum_l_all + $sum_l_all;
                $tot_sum_p_all = $tot_sum_p_all + $sum_p_all;
                $tot_sum_all = $tot_sum_all + $sum_all;
                $tot_sum_p = $tot_sum_p + $sum_p;
                $tot_sum = $tot_sum + $sum;

                $objPHPExcel->getActiveSheet()->getStyle('B' . $j)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':O' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $no_detail)
                        ->setCellValue('B' . $j, $r1['LOKASI_UNIT'])
                        ->setCellValue('C' . $j, $r1['PIM_TK4_L'])
                        ->setCellValue('D' . $j, $r1['PIM_TK4_P'])
                        ->setCellValue('E' . $j, $r1['PIM_TK3_L'])
                        ->setCellValue('F' . $j, $r1['PIM_TK3_P'])
                        ->setCellValue('G' . $j, $r1['PIM_TK2_L'])
                        ->setCellValue('H' . $j, $r1['PIM_TK2_P'])
                        ->setCellValue('I' . $j, $r1['PIM_TK1_L'])
                        ->setCellValue('J' . $j, $r1['PIM_TK1_P'])
                        ->setCellValue('K' . $j, $r1['LEMHANAS_L'])
                        ->setCellValue('L' . $j, $r1['LEMHANAS_P'])
                        ->setCellValue('M' . $j, $sum_l)
                        ->setCellValue('N' . $j, $sum_p);

                $no_detail++;
                $j++;
            }
        }

        $bawah = $j;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B' . $bawah, 'jumlah keseluruhan')
                ->setCellValue('C' . $bawah, $total_es4l)
                ->setCellValue('D' . $bawah, $total_es4p)
                ->setCellValue('E' . $bawah, $total_es3l)
                ->setCellValue('F' . $bawah, $total_es3p)
                ->setCellValue('G' . $bawah, $total_es2l)
                ->setCellValue('H' . $bawah, $total_es2p)
                ->setCellValue('I' . $bawah, $total_es1l)
                ->setCellValue('J' . $bawah, $total_es1p)
                ->setCellValue('K' . $bawah, $total_es1_fk_l)
                ->setCellValue('L' . $bawah, $total_es1_fk_p)
                ->setCellValue('M' . $bawah, $tot_sum_l_all)
                ->setCellValue('N' . $bawah, $tot_sum_p_all);

        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&H Komposisi Pegawai Diklat Pim Eselon ' . $this->config->item('instansi_panjang'));
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

    public function print_pdf_1() {
        $lokasi_id = (isset($_GET['trlokasi_id']) && !empty($_GET['trlokasi_id'])) ? trim($this->input->get('trlokasi_id', TRUE)) : '2';
        $kdu1 = (isset($_GET['kdu1_id']) && !empty($_GET['kdu1_id']) && $_GET['kdu1_id'] != -1) ? trim($this->input->get('kdu1_id', TRUE)) : '00';
        $kdu2 = (isset($_GET['kdu2_id']) && !empty($_GET['kdu2_id']) && $_GET['kdu2_id'] != -1) ? trim($this->input->get('kdu2_id', TRUE)) : '00';
        $kdu3 = (isset($_GET['kdu3_id']) && !empty($_GET['kdu3_id']) && $_GET['kdu3_id'] != -1) ? trim($this->input->get('kdu3_id', TRUE)) : '000';
        $kdu4 = (isset($_GET['kdu4_id']) && !empty($_GET['kdu4_id']) && $_GET['kdu4_id'] != -1) ? trim($this->input->get('kdu4_id', TRUE)) : '000';
        $kdu5 = (isset($_GET['kdu5_id']) && !empty($_GET['kdu5_id']) && $_GET['kdu5_id'] != -1) ? trim($this->input->get('kdu5_id', TRUE)) : '00';
        $jenis_keluaran = (isset($_GET['jenis_keluaran']) && !empty($_GET['jenis_keluaran'])) ? trim($this->input->get('jenis_keluaran', TRUE)) : 2;
        $bentuk_keluaran = (isset($_GET['bentuk']) && !empty($_GET['bentuk'])) ? trim($this->input->get('bentuk', TRUE)) : '';

        $this->data['data_pdf'] = $this->statistik_diklat_pim_model->get_data_matrix($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $this->load->view('statistik_diklat_pim/print_pdf_1', $this->data);
    }

    public function export_excel_2() {
        $lokasi_id = (isset($_GET['trlokasi_id']) && !empty($_GET['trlokasi_id'])) ? trim($this->input->get('trlokasi_id', TRUE)) : '2';
        $kdu1 = (isset($_GET['kdu1_id']) && !empty($_GET['kdu1_id']) && $_GET['kdu1_id'] != -1) ? trim($this->input->get('kdu1_id', TRUE)) : '00';
        $kdu2 = (isset($_GET['kdu2_id']) && !empty($_GET['kdu2_id']) && $_GET['kdu2_id'] != -1) ? trim($this->input->get('kdu2_id', TRUE)) : '00';
        $kdu3 = (isset($_GET['kdu3_id']) && !empty($_GET['kdu3_id']) && $_GET['kdu3_id'] != -1) ? trim($this->input->get('kdu3_id', TRUE)) : '000';
        $kdu4 = (isset($_GET['kdu4_id']) && !empty($_GET['kdu4_id']) && $_GET['kdu4_id'] != -1) ? trim($this->input->get('kdu4_id', TRUE)) : '000';
        $kdu5 = (isset($_GET['kdu5_id']) && !empty($_GET['kdu5_id']) && $_GET['kdu5_id'] != -1) ? trim($this->input->get('kdu5_id', TRUE)) : '00';
        $jenis_keluaran = (isset($_GET['jenis_keluaran']) && !empty($_GET['jenis_keluaran'])) ? trim($this->input->get('jenis_keluaran', TRUE)) : 2;
        $bentuk_keluaran = (isset($_GET['bentuk']) && !empty($_GET['bentuk'])) ? trim($this->input->get('bentuk', TRUE)) : '';

        $model = $this->statistik_diklat_pim_model->get_data($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5, $bentuk_keluaran);
        $struktur = $this->statistik_diklat_pim_model->get_struktur($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
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
                'bold' => true
        ));

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'KOMPOSISI PEGAWAI');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:N1');

        $judul = 2;
        if (isset($struktur['NMSTRUKTUR']) && !empty($struktur['NMSTRUKTUR'])):
            $nmstruktur = '';
            $pecah = explode(", ", $struktur['NMSTRUKTUR']);
            if ($pecah > 0) {
                $awal = 0;
                foreach ($pecah as $val) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $pecah[$awal]);
                    $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':N' . $judul);
                    $judul++;
                    $awal++;
                }
            }
        endif;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':N' . $judul);

        $masihjudul = $judul + 1;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':N' . $masihjudul);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getStyle('A1:N' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:N' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $judultabel = $masihjudul + 2;
        $judultabellagi = $masihjudul + 3;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $judultabel, 'No')
                ->setCellValue('B' . $judultabel, 'Unit Kerja')
                ->setCellValue('C' . $judultabel, 'PIM IV')
                ->setCellValue('E' . $judultabel, 'PIM III')
                ->setCellValue('G' . $judultabel, 'PIM II')
                ->setCellValue('I' . $judultabel, 'PIM I')
                ->setCellValue('K' . $judultabel, 'Lemhanas')
                ->setCellValue('M' . $judultabel, 'Jumlah')
                ->setCellValue('C' . $judultabellagi, '(L)')
                ->setCellValue('D' . $judultabellagi, '(P)')
                ->setCellValue('E' . $judultabellagi, '(L)')
                ->setCellValue('F' . $judultabellagi, '(P)')
                ->setCellValue('G' . $judultabellagi, '(L)')
                ->setCellValue('H' . $judultabellagi, '(P)')
                ->setCellValue('I' . $judultabellagi, '(L)')
                ->setCellValue('J' . $judultabellagi, '(P)')
                ->setCellValue('K' . $judultabellagi, '(L)')
                ->setCellValue('L' . $judultabellagi, '(P)')
                ->setCellValue('M' . $judultabellagi, '(L)')
                ->setCellValue('N' . $judultabellagi, '(P)');

        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':N' . ($judultabel + $jumlah + 1))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':N' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':N' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $judultabel . ':D' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('E' . $judultabel . ':F' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('G' . $judultabel . ':H' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('I' . $judultabel . ':J' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('K' . $judultabel . ':L' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('M' . $judultabel . ':N' . $judultabel);

        unset($styleArray);
        $j = $judultabel + 1;
        $i = $judultabel + 1;
        $no_parent = 1;
        $total_es4l = 0;
        $total_es4p = 0;
        $total_es3l = 0;
        $total_es3p = 0;
        $total_es2l = 0;
        $total_es2p = 0;
        $total_es1l = 0;
        $total_es1p = 0;
        $total_es1_fk_l = 0;
        $total_es1_fk_p = 0;
        $total_es1_fu_l = 0;
        $total_es1_fu_p = 0;
        foreach ($model as $row) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $i, $row['parent_lokasi']);
            $tot_detail = count($row['detail_lokasi']);
            $no_detail = 1;
            $j = $i + 1;
            $sum_l = 0;
            $sum_p = 0;
            $sum = 0;
            $es4l = 0;
            $es4p = 0;
            $es3l = 0;
            $es3p = 0;
            $es2l = 0;
            $es2p = 0;
            $es1l = 0;
            $es1p = 0;
            $es1_fk_l = 0;
            $es1_fk_p = 0;
            $tot_sum_l = 0;
            $tot_sum_p = 0;
            $tot_sum = 0;
            $tot_sum_l_all = 0;
            $tot_sum_p_all = 0;
            $tot_sum_all = 0;
            foreach ($row['detail_lokasi'] as $r2) {
                $sum_l_all = $r2['ES4L'] + $r2['ES3L'] + $r2['ES2L'] + $r2['ES1L'] + $r2['ES1_FK_L'];
                $sum_p_all = $r2['ES4P'] + $r2['ES3P'] + $r2['ES2P'] + $r2['ES1P'] + $r2['ES1_FK_P'];
                $sum_l = $r2['ES4L'] + $r2['ES3L'] + $r2['ES2L'] + $r2['ES1L'] + $r2['ES1_FK_L'];
                $sum_p = $r2['ES4P'] + $r2['ES3P'] + $r2['ES2P'] + $r2['ES1P'] + $r2['ES1_FK_P'];
                $sum_all = $r2['ES4P'] + $r2['ES3P'] + $r2['ES2P'] + $r2['ES1P'] + $r2['ES1_FK_P'] + $r2['ES4L'] + $r2['ES3L'] + $r2['ES2L'] + $r2['ES1L'] + $r2['ES1_FK_L'];
                $sum = $sum_l + $sum_p;
                $total_es4l = $total_es4l + $r2['ES4L'];
                $total_es4p = $total_es4p + $r2['ES4P'];
                $total_es3l = $total_es3l + $r2['ES3L'];
                $total_es3p = $total_es3p + $r2['ES3P'];
                $total_es2l = $total_es2l + $r2['ES2L'];
                $total_ES2P = $total_es2p + $r2['ES2P'];
                $total_es1l = $total_es1l + $r2['ES1L'];
                $total_es1p = $total_es1p + $r2['ES1P'];
                $total_es1_fk_l = $total_es1_fk_l + $r2['ES1_FK_L'];
                $total_es1_fk_p = $total_es1_fk_p + $r2['ES1_FK_P'];
                $es4l = $es4l + $r2['ES4L'];
                $es4p = $es4p + $r2['ES4P'];
                $es3l = $es3l + $r2['ES3L'];
                $es3p = $es3p + $r2['ES3P'];
                $es2l = $es2l + $r2['ES2L'];
                $es2p = $es2p + $r2['ES2P'];
                $es1l = $es1l + $r2['ES1L'];
                $es1p = $es1p + $r2['ES1P'];
                $es1_fk_l = $es1_fk_l + $r2['ES1_FK_L'];
                $es1_fk_p = $es1_fk_p + $r2['ES1_FK_P'];
                $tot_sum_l = $tot_sum_l + $sum_l;
                $tot_sum_l_all = $tot_sum_l_all + $sum_l_all;
                $tot_sum_p_all = $tot_sum_p_all + $sum_p_all;
                $tot_sum_all = $tot_sum_all + $sum_all;
                $tot_sum_p = $tot_sum_p + $sum_p;
                $tot_sum = $tot_sum + $sum;

                $objPHPExcel->getActiveSheet()->getStyle('B' . $j)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':O' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $no_detail)
                        ->setCellValue('B' . $j, $r2['NM_LOKASI'])
                        ->setCellValue('C' . $j, $r2['ES4L'])
                        ->setCellValue('D' . $j, $r2['ES4P'])
                        ->setCellValue('E' . $j, $r2['ES3L'])
                        ->setCellValue('F' . $j, $r2['ES3P'])
                        ->setCellValue('G' . $j, $r2['ES2L'])
                        ->setCellValue('H' . $j, $r2['ES2P'])
                        ->setCellValue('I' . $j, $r2['ES1L'])
                        ->setCellValue('J' . $j, $r2['ES1P'])
                        ->setCellValue('K' . $j, $r2['ES1_FK_L'])
                        ->setCellValue('L' . $j, $r2['ES1_FK_P'])
                        ->setCellValue('M' . $j, $sum_l)
                        ->setCellValue('N' . $j, $sum_p);
                $no_detail++;
                $jtot = $i + (count($row['detail_lokasi']) + 1);
                $j++;
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B' . $jtot, 'jumlah')
                        ->setCellValue('C' . $jtot, $es4l)
                        ->setCellValue('D' . $jtot, $es4p)
                        ->setCellValue('E' . $jtot, $es3l)
                        ->setCellValue('F' . $jtot, $es3p)
                        ->setCellValue('G' . $jtot, $es2l)
                        ->setCellValue('H' . $jtot, $es2p)
                        ->setCellValue('I' . $jtot, $es1l)
                        ->setCellValue('J' . $jtot, $es1p)
                        ->setCellValue('K' . $jtot, $es1_fk_l)
                        ->setCellValue('L' . $jtot, $es1_fk_p)
                        ->setCellValue('M' . $jtot, $tot_sum_l)
                        ->setCellValue('N' . $jtot, $tot_sum_p);
            }

            $i = $i + $tot_detail + 2;
            $no_parent++;
        }
        $bawah = $jtot + 1;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B' . $bawah, 'jumlah keseluruhan')
                ->setCellValue('C' . $bawah, $total_es4l)
                ->setCellValue('D' . $bawah, $total_es4p)
                ->setCellValue('E' . $bawah, $total_es3l)
                ->setCellValue('F' . $bawah, $total_es3p)
                ->setCellValue('G' . $bawah, $total_es2l)
                ->setCellValue('H' . $bawah, $total_es2p)
                ->setCellValue('I' . $bawah, $total_es1l)
                ->setCellValue('J' . $bawah, $total_es1p)
                ->setCellValue('K' . $bawah, $total_es1_fk_l)
                ->setCellValue('L' . $bawah, $total_es1_fk_p)
                ->setCellValue('M' . $bawah, $tot_sum_l_all)
                ->setCellValue('N' . $bawah, $tot_sum_p_all);

        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&H Komposisi Pegawai Diklat Pim Unit Kerja ' . $this->config->item('instansi_panjang'));
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
    
    public function print_pdf_2() {
        $lokasi_id = (isset($_GET['trlokasi_id']) && !empty($_GET['trlokasi_id'])) ? trim($this->input->get('trlokasi_id', TRUE)) : '2';
        $kdu1 = (isset($_GET['kdu1_id']) && !empty($_GET['kdu1_id']) && $_GET['kdu1_id'] != -1) ? trim($this->input->get('kdu1_id', TRUE)) : '00';
        $kdu2 = (isset($_GET['kdu2_id']) && !empty($_GET['kdu2_id']) && $_GET['kdu2_id'] != -1) ? trim($this->input->get('kdu2_id', TRUE)) : '00';
        $kdu3 = (isset($_GET['kdu3_id']) && !empty($_GET['kdu3_id']) && $_GET['kdu3_id'] != -1) ? trim($this->input->get('kdu3_id', TRUE)) : '000';
        $kdu4 = (isset($_GET['kdu4_id']) && !empty($_GET['kdu4_id']) && $_GET['kdu4_id'] != -1) ? trim($this->input->get('kdu4_id', TRUE)) : '000';
        $kdu5 = (isset($_GET['kdu5_id']) && !empty($_GET['kdu5_id']) && $_GET['kdu5_id'] != -1) ? trim($this->input->get('kdu5_id', TRUE)) : '00';
        $jenis_keluaran = (isset($_GET['jenis_keluaran']) && !empty($_GET['jenis_keluaran'])) ? trim($this->input->get('jenis_keluaran', TRUE)) : 2;
        $bentuk_keluaran = (isset($_GET['bentuk']) && !empty($_GET['bentuk'])) ? trim($this->input->get('bentuk', TRUE)) : '';

        $this->data['data_pdf'] = $this->statistik_diklat_pim_model->get_data($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5, $bentuk_keluaran);
        $this->load->view('statistik_diklat_pim/print_pdf_2', $this->data);
    }

}
