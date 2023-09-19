<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Daftar_pegawai_lengkap extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        }
        $this->load->model(array('daftar_pegawai_lengkap_model'));
    }

    public function listpegawai() {
        $this->data['tipe'] = isset($_GET['tipe']) ? $this->input->get('tipe', TRUE) : 3;
        $this->data['jabatan'] = isset($_GET['id']) ? $this->input->get('id', TRUE) : 0;
        if ($this->data['tipe'] == 2)
            $this->data['trlokasi_id'] = (isset($_POST['lokasi_id']) && $_POST['lokasi_id'] != "" && $_POST['lokasi_id'] != '-1') ? $this->input->post('lokasi_id') : '';
        else
            $this->data['trlokasi_id'] = (isset($_POST['lokasi_id']) && $_POST['lokasi_id'] != "" && $_POST['lokasi_id'] != '-1') ? $this->input->post('lokasi_id') : 2;
        $this->data['kdu1'] = (isset($_POST['kdu1_id']) && $_POST['kdu1_id'] != "" && $_POST['kdu1_id'] != '-1') ? $this->input->post('kdu1_id') : "";
        $this->data['kdu2'] = (isset($_POST['kdu2_id']) && $_POST['kdu2_id'] != "" && $_POST['kdu2_id'] != '-1') ? $this->input->post('kdu2_id') : "";
        $this->data['kdu3'] = (isset($_POST['kdu3_id']) && $_POST['kdu3_id'] != "" && $_POST['kdu3_id'] != '-1') ? $this->input->post('kdu3_id') : "";
        $this->data['kdu4'] = (isset($_POST['kdu4_id']) && $_POST['kdu4_id'] != "" && $_POST['kdu4_id'] != '-1') ? $this->input->post('kdu4_id') : "";
        $this->data['kdu5'] = (isset($_POST['kdu5_id']) && $_POST['kdu5_id'] != "" && $_POST['kdu5_id'] != '-1') ? $this->input->post('kdu5_id') : "";
        $this->load->view("daftar_pegawai_lengkap/listpegawai", $this->data);
    }

    public function ajax_listpegawai() {
        if (!$this->input->is_ajax_request()) {
            redirect('beranda/');
        }
        $list = $this->daftar_pegawai_lengkap_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN . " " : "") . ($val->NAMA) . ((!empty($val->GELAR_BLKG)) ? ", " . $val->GELAR_BLKG : '');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<img style="width: 100%; height: 40%" src="' . base_url() . '_uploads/photo_pegawai/thumbs/' . $val->FOTO . '?v=' . uniqid() . '" class="img-responsive" alt="">';
            $row[] = "NIP : " . $val->NIPNEW . "<br />Nama : " . $nama . "<br />Pangkat / Golongan / TMT : " . ($val->TRSTATUSKEPEGAWAIAN_ID == 1 ? $val->PANGKAT . " (" . $val->GOLONGAN . ")" : $val->PANGKAT) . " / " . $val->TMT_GOL . "<br />TMT Jabatan : " . $val->TMT_JABATAN . "<br />Jabatan : " . $val->N_JABATAN
                    . "<br />Masa Jab : " . ($val->MK_JABATAN) . "<br />Tanggal Lahir : " . $val->TGLLAHIR . ", Umur : " . $val->UMUR;

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->daftar_pegawai_lengkap_model->count_all(),
            "recordsFiltered" => $this->daftar_pegawai_lengkap_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function cetak_excel() {
        $tipe = (isset($_GET['tipe']) && !empty($_GET['tipe'])) ? $this->input->get('tipe', false) : 1;
        $jabatan = (isset($_GET['jabatan']) && !empty($_GET['jabatan'])) ? $this->input->get('jabatan', false) : 1;
        $lokasi_id = (isset($_GET['trlokasi_id']) && !empty($_GET['trlokasi_id'])) ? $this->input->get('trlokasi_id', false) : 2;
        $kdu1 = (isset($_GET['kdu1']) && !empty($_GET['kdu1']) && $_GET['kdu1'] != '-1') ? $this->input->get('kdu1', false) : '';
        $kdu2 = (isset($_GET['kdu2']) && !empty($_GET['kdu2']) && $_GET['kdu2'] != '-1') ? $this->input->get('kdu2', false) : '';
        $kdu3 = (isset($_GET['kdu3']) && !empty($_GET['kdu3']) && $_GET['kdu3'] != '-1') ? $this->input->get('kdu3', false) : '';
        $kdu4 = (isset($_GET['kdu4']) && !empty($_GET['kdu4']) && $_GET['kdu4'] != '-1') ? $this->input->get('kdu4', false) : '';
        $kdu5 = (isset($_GET['kdu5']) && !empty($_GET['kdu5']) && $_GET['kdu5'] != '-1') ? $this->input->get('kdu5', false) : '';
        
        $struktur = $this->daftar_pegawai_lengkap_model->get_struktur($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $model = $this->daftar_pegawai_lengkap_model->cetak_excel_query();

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

        $jumlah = count($model);
        $jml = 0;
        if ($model):
            foreach ($model as $val):
                $jml += $val->NIPNEW;
            endforeach;
        endif;
        $total = $jml;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Daftar Pegawai');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');

        $judul = 2;
        if (isset($struktur['NMSTRUKTUR']) && !empty($struktur['NMSTRUKTUR'])):
            $nmstruktur = '';
            $pecah = explode(", ", $struktur['NMSTRUKTUR']);
            if ($pecah > 0) {
                $awal = 0;
                foreach ($pecah as $val) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $pecah[$awal]);
                    $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':C' . $judul);
                    $judul++;
                    $awal++;
                }
            }
        endif;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':C' . $judul);

        $masihjudul = $judul + 1;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':C' . $masihjudul);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(100);
        $objPHPExcel->getActiveSheet()->getStyle('A1:C' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:C' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $judultabellagi = $masihjudul + 2;
        $judultabel = $masihjudul + 3;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $judultabellagi, "No")
                ->setCellValue('B' . $judultabellagi, "Foto")
                ->setCellValue('C' . $judultabellagi, "Keterangan");
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':C' . ($judultabel + $jumlah))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':C' . $judultabellagi)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':C' . $judultabellagi)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        unset($styleArray);
        $j = $judultabel + 0;
        $no_detail = 1;
        if ($model) {
            foreach ($model as $val) {
                $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(100);
                $objDrawing = new PHPExcel_Worksheet_Drawing();
                $objDrawing->setName('Foto');
                $objDrawing->setDescription('Foto');
                $foto = "./_uploads/photo_pegawai/thumbs/".$val->FOTO;
                $objDrawing->setPath($foto);
                $objDrawing->setCoordinates('B' . $j);
                $objDrawing->setOffsetY(10);
                $objDrawing->setHeight(105);
                $objDrawing->setResizeProportional(true);
                $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                
                $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN . " " : "") . ($val->NAMA) . ((!empty($val->GELAR_BLKG)) ? " " . $val->GELAR_BLKG : '');
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $no_detail)
                        ->setCellValue('C' . $j, "NIP : " . $val->NIPNEW . "\nNama : " . $nama . "\nPangkat / Golongan / TMT : " . ($val->TRSTATUSKEPEGAWAIAN_ID == 1 ? $val->PANGKAT . " (" . $val->GOLONGAN . ")" : $val->PANGKAT) . " / " . $val->TMT_GOL . "\nTMT Jabatan : " . $val->TMT_JABATAN . "\nJabatan : " . $val->N_JABATAN
                    . "\nMasa Jab : " . ($val->MK_JABATAN) . "\nTanggal Lahir : " . $val->TGLLAHIR . ", Umur : " . $val->UMUR);

                $no_detail++;
                $j++;
            }
        }

        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HDaftar Pegawai ' . $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

        // Set page orientation and size
        //echo date('H:i:s') . " Set page orientation and size\n";
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        // Rename sheet
        //echo date('H:i:s') . " Rename sheet\n";
        $objPHPExcel->getActiveSheet()->setTitle('Pegawai');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Daftar Pegawai' . month_indo(date('m')) . " " . date("Y") . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}
