<?php

ini_set('max_execution_time', 180);
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Statistik_jabatan_abk extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('statistik_jabatan_abk/statistik_jabatan_abk_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(), ['assets/plugins/select2/js/select2.min.js']);
        $this->data['custom_js'] = ['statistik_jabatan_abk/js'];
        $this->data['title_utama'] = 'ABK';
    }

    public function index() {
        $this->data['content'] = 'statistik_jabatan_abk/index';
        $this->load->view('layouts/main', $this->data);
    }

    public function pencarian_proses() {
        $this->data['list_jabatan'] = $this->statistik_jabatan_abk_model->get_data();
        $this->load->view("statistik_jabatan_abk/_hasil", $this->data);
    }

    public function export_pdf() {
        $this->data['list_jabatan'] = $this->statistik_jabatan_abk_model->get_data();
        $this->data['content'] = 'statistik_jabatan_abk/pdf';
        
        $this->load->library('M_pdf');
        $this->m_pdf->set_paper('a4', 'landscape');
        $this->m_pdf->load_view("layouts/print", $this->data);
        $this->m_pdf->render();
        $this->m_pdf->stream($this->data['title_utama'] . " " . 'Periode ' . month_indo(date('m')) . " " . date("Y"));
    }
    
    public function liststatistik() {
        $this->data['trlokasi_id'] = (isset($_POST['lokasi_id']) && $_POST['lokasi_id'] != "" && $_POST['lokasi_id'] != '-1') ? $this->input->post('lokasi_id') : 2;
        $this->data['kdu1'] = (isset($_POST['kdu1_id']) && $_POST['kdu1_id'] != "" && $_POST['kdu1_id'] != '-1') ? $this->input->post('kdu1_id') : "";
        $this->data['kdu2'] = (isset($_POST['kdu2_id']) && $_POST['kdu2_id'] != "" && $_POST['kdu2_id'] != '-1') ? $this->input->post('kdu2_id') : "";
        $this->data['kdu3'] = (isset($_POST['kdu3_id']) && $_POST['kdu3_id'] != "" && $_POST['kdu3_id'] != '-1') ? $this->input->post('kdu3_id') : "";
        $this->data['kdu4'] = (isset($_POST['kdu4_id']) && $_POST['kdu4_id'] != "" && $_POST['kdu4_id'] != '-1') ? $this->input->post('kdu4_id') : "";
        $this->data['kdu5'] = (isset($_POST['kdu5_id']) && $_POST['kdu5_id'] != "" && $_POST['kdu5_id'] != '-1') ? $this->input->post('kdu5_id') : "";
        $this->data['jabatan'] = isset($_POST['jabatan']) ? $this->input->post('jabatan') : '';
        $this->data['nmjabatan'] = isset($_POST['nmjabatan']) ? $this->input->post('nmjabatan') : '';
        
        $this->load->view("statistik_jabatan_abk/liststatistik",$this->data);
    }
    
    public function ajax_liststatistik() {
        if (!$this->input->is_ajax_request()) {
            redirect('beranda/');
        }
        $this->load->model(['statistik_jabatan_abk_detail_model']);
        $list = $this->statistik_jabatan_abk_detail_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        $class = $this->input->post('setelementnya');
        foreach ($list as $val) {
            $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN." ": "").($val->NAMA).((!empty($val->GELAR_BLKG)) ? ", ".$val->GELAR_BLKG : '');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<img style="width: 100%; height: 40%" src="'.base_url().'_uploads/photo_pegawai/thumbs/'.$val->FOTO.'" class="img-responsive" alt="">';
            $row[] = "NIP : ".$val->NIPNEW."<br />Nama : ".$nama."<br />Tanggal Lahir : ".$val->TGLLAHIR.", Umur : ".$val->UMUR."<br />Pendidikan : ".
            ($val->TINGKAT_PENDIDIKAN)."<br />TMT Jabatan : ".$val->TMT_JABATAN."<br />Jabatan : ".$val->N_JABATAN;

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->statistik_jabatan_abk_detail_model->count_all(),
            "recordsFiltered" => $this->statistik_jabatan_abk_detail_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    private function range() {
        $list = array();
        for ($i='A';$i!=='ZZ';$i++) {
            $list[] = $i;
        }
        
        return $list;
    }
    
    public function export_excel() {
        $model = $this->statistik_jabatan_abk_model->get_data();
        $besaran = count($model);

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

//        $jumlah = count($model);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'KOMPOSISI PEGAWAI');
        $alphabet = $this->range()[$besaran];
        $kuantitas = $this->range()[$besaran + 1];

        $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$kuantitas.'1');
        $judul = 2;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':'. $kuantitas . $judul);
        $masihjudul = $judul + 1;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':'. $kuantitas . $masihjudul);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getStyle('A1:'. $kuantitas . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $kuantitas . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $k = 1;
        $totalcalon = 0;
        $temp_where = '';
        $tempr_where = '';
        
        $judultabel = $masihjudul + 2;
        $headertabel = $masihjudul + 3;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $judultabel, "No")
                ->setCellValue('B' . $judultabel, "Nama Kantor SAR")
                ->setCellValue('C' . $judultabel, "Jabatan ABK ")
                ->setCellValue($this->range()[$besaran+2] . $judultabel, "Total");
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judultabel . ':A'. $headertabel);
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $judultabel . ':B'. $headertabel);
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $judultabel . ':'.$this->range()[$besaran+1]. $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells($this->range()[$besaran+2] . $judultabel. ':'.$this->range()[$besaran+2] . $headertabel);
        if ($model) {
            $urutsamping = 2;
            foreach ($model as $isinya) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->range()[$urutsamping] . $headertabel, ucwords(strtolower($isinya['JABATAN'])));
                $urutsamping++;
            }
        }

        if ($model) {
            $sqlstruktur = "SELECT * FROM ((SELECT NMUNIT,TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5,TKTESELON,1 as URUT,URUTAN FROM TR_STRUKTUR_ORGANISASI WHERE   
            TRLOKASI_ID=2 and KDU1 = '00') UNION (SELECT NMUNIT,TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5,TKTESELON,1 as URUT,URUTAN FROM TR_STRUKTUR_ORGANISASI WHERE   
            TRLOKASI_ID=4 and TKTESELON='3' AND KDU3 <> '017') UNION (SELECT NMUNIT,TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5,TKTESELON,1 as URUT,URUTAN FROM TR_STRUKTUR_ORGANISASI WHERE   
            TRLOKASI_ID=4 and TKTESELON='4' AND KDU3 = '017')) XYZ ORDER BY URUTAN ASC";
            $data = $this->db->query($sqlstruktur)->result_array();
            $k = 1;
            $totalcalon = 0;
            $temp_where = '';
            $tempr_where = '';
            $j = $headertabel + 1;
            foreach ($data as $val) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $j, $k)
                    ->setCellValue('B' . $j, $val['NMUNIT']);
                    if ($val['TRLOKASI_ID'] == '2') {
                        $temp_where = " and TRLOKASI_ID=2 ";
                    }

                    if ($val['TRLOKASI_ID'] == '4') {
                        $temp_where = " and TRLOKASI_ID=4 ";
                    }

                    $tempr_where = '';
                    if ($val['TKTESELON'] == '3') {
                        $tempr_where = " and KDU1 = '" . $val['KDU1'] . "' and KDU2 = '" . $val['KDU2'] . "' and KDU3 ='" . $val['KDU3'] . "' ";
                    }
                    if ($val['TKTESELON'] == '4') {
                        $tempr_where = " and KDU1 = '" . $val['KDU1'] . "' and KDU2 = '" . $val['KDU2'] . "' and KDU3 ='" . $val['KDU3'] . "' and KDU4 ='" . $val['KDU4'] . "' ";
                    }
                    $totaljenjang = 0;
                    if ($model) {
                        $urutsamping = 2;
                        foreach ($model as $isinya) {
                            $sqlnya = "select count(MJPV.TRJABATAN_ID) as jmlpegawai from V_PEGAWAI_JABATAN_MUTAKHIR MJPV where MJPV.TRESELON_ID != '17' and MJPV.TRJABATAN_ID = '" . $isinya['TRJABATAN_ID'] . "' $temp_where $tempr_where ";
                            $hasilnya = $this->db->query($sqlnya)->row_array();
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->range()[$urutsamping] . $j, $hasilnya['JMLPEGAWAI']);
                            
                            $urutsamping++;
                            $totaljenjang += $hasilnya['JMLPEGAWAI'];
                        }
                    }
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->range()[$besaran+2] . $j, $totaljenjang);
                $j++;
                $k++;
            }
        }
        
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . ($headertabel+$k), 'Total');
        $hasiltotal = 0;
        if ($model) {
            $urutalpa = 2;
            foreach ($model as $val) {
                $sqlnya = "select count(MJPV.TMPEGAWAI_ID) as jmlpegawai from V_PEGAWAI_JABATAN_MUTAKHIR MJPV where MJPV.TRESELON_ID != '17' and MJPV.TRJABATAN_ID = '" . $val['TRJABATAN_ID'] . "' ";
                $hasilnya = $this->db->query($sqlnya)->row_array();
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->range()[$urutalpa] . ($headertabel+$k), $hasilnya['JMLPEGAWAI']);
                $hasiltotal += $hasilnya['JMLPEGAWAI'];
                $urutalpa++;
            }
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->range()[$besaran+2] . ($headertabel+$k), $hasiltotal + $totalcalon);
//        
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($headertabel + ($k)) . ':B' . ($headertabel + ($k)));
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':'.$this->range()[$besaran+2] . ($headertabel + ($k)))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':'.$this->range()[$besaran+2] . $headertabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':'.$this->range()[$besaran+2] . $headertabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HDAFTAR PEGAWAI ' . $this->config->item('instansi_panjang'));
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
