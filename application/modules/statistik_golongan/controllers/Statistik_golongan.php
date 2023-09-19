<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Statistik_golongan extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('statistik_golongan/statistik_golongan_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(), ['assets/plugins/select2/js/select2.min.js']);
        $this->data['custom_js'] = ['statistik_golongan/js'];
        $this->data['title_utama'] = 'Statistik Golongan';
    }

    public function index() {
        $this->data['content'] = 'statistik_golongan/index';
        $this->load->view('layouts/main', $this->data);
    }

    public function pencarian_proses() {
        $this->data['data_komposisi'] = $this->statistik_golongan_model->get_data();
        $this->data['komposisi_cpns'] = $this->statistik_golongan_model->get_data_komposisi_cpns();
        $this->load->view("statistik_golongan/_hasil", $this->data);
    }

    public function export_excel() {
        $model = $this->statistik_golongan_model->get_data();
        $komposisi_cpns = $this->statistik_golongan_model->get_data_komposisi_cpns();
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
        $col = array('1' => 'A', '2' => 'B', '3' => 'C', '4' => 'D', '5' => 'E', '6' => 'F', '7' => 'G', '8' => 'H', '9' => 'I', '10' => 'J', '11' => 'K', '12' => 'L',
            '13' => 'M', '14' => 'N', '15' => 'O', '16' => 'P', '17' => 'Q', '18' => 'R', '19' => 'S', '20' => 'T', '21' => 'U', '22' => 'V', '23' => 'W', '24' => 'X',
            '25' => 'Y', '26' => 'Z', '27' => 'AA', '28' => 'AB', '29' => 'AC', '30' => 'AD', '31' => 'AE', '32' => 'AF', '33' => 'AG', '34' => 'AH', '35' => 'AI', '36' => 'AJ',
            '37' => 'AK', '38' => 'AL', '39' => 'AM', '40' => 'AN', '41' => 'AO', '42' => 'AP', '43' => 'AQ', '44' => 'AR', '45' => 'AS', '46' => 'AT', '47' => 'AU', '48' => 'AV');

        $jmlcpns = 1;
        $kolomcpns = 20;
        if ($komposisi_cpns) {
            foreach ($komposisi_cpns as $val) {
                $jmlcpns++;
                $kolomcpns++;
            }
        }

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'KOMPOSISI PEGAWAI MENURUT GOLONGAN');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:' . $col[$kolomcpns] . '1');

        $judul = 2;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':' . $col[$kolomcpns] . $judul);

        $masihjudul = $judul + 1;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':' . $col[$kolomcpns] . $masihjudul);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getStyle('A1:N' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:N' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $judultabel = $masihjudul + 2;
        $judultabellagi = $masihjudul + 3;
        $judullagi = $masihjudul + 4;
        $judulnih = $masihjudul + 5;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $judultabel, 'No')
                ->setCellValue('B' . $judultabel, 'NAMA KANTOR SAR')
                ->setCellValue('C' . $judultabel, 'GOLONGAN')
                ->setCellValue('T' . $judultabel, 'CPNS')
                ->setCellValue('C' . $judultabellagi, 'PEGAWAI NEGERI SIPIL');

        $jmlcpns = 1;
        $kolomcpns = 20;
        $totalbawah = [];
        if ($komposisi_cpns) {
            foreach ($komposisi_cpns as $val) {
                $totalbawah[$val['TRGOLONGAN_ID']."_".$val['THN_GOL']] = [];
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col[$kolomcpns] . $judultabellagi, $val['THN_GOL']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col[$kolomcpns] . $judullagi, $val['GOLONGAN']);
                $objPHPExcel->getActiveSheet()->mergeCells($col[$kolomcpns] . $judullagi . ':' . $col[$kolomcpns] . $judulnih);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col[$kolomcpns] . ($judulnih+1), $kolomcpns);
                $objPHPExcel->getActiveSheet()->getColumnDimension($col[$kolomcpns])->setWidth(5);
                $jmlcpns++;
                $kolomcpns++;
            }
        }

        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':' . $col[$kolomcpns] . ($judultabel + $jumlah + 5))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':' . $col[$kolomcpns] . ($judulnih+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabel . ':' . $col[$kolomcpns] . ($judulnih+1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judultabel . ':A' . $judulnih);
        $objPHPExcel->getActiveSheet()->mergeCells('B' . $judultabel . ':B' . $judulnih);
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $judultabel . ':S' . $judultabel);
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $judultabellagi . ':S' . $judultabellagi);
        if ($kolomcpns > 20)
            $objPHPExcel->getActiveSheet()->mergeCells('T' . $judultabel . ':' . $col[$kolomcpns - 1] . $judultabel);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col[$kolomcpns] . $judultabel, 'JML');
        $objPHPExcel->getActiveSheet()->mergeCells($col[$kolomcpns] . $judultabel . ':' . $col[$kolomcpns] . $judulnih);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col[$kolomcpns] . ($judulnih+1), $kolomcpns);
        $objPHPExcel->getActiveSheet()->getColumnDimension($col[$kolomcpns])->setWidth(5);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $judullagi, 'IV');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $judullagi . ':G' . $judullagi);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $judullagi, 'JML');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . $judullagi . ':H' . $judulnih);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $judullagi, 'III');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . $judullagi . ':L' . $judullagi);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $judullagi, 'JML');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . $judullagi . ':M' . $judulnih);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $judullagi, 'II');
        $objPHPExcel->getActiveSheet()->mergeCells('N' . $judullagi . ':Q' . $judullagi);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R' . $judullagi, 'JML');
        $objPHPExcel->getActiveSheet()->mergeCells('R' . $judullagi . ':R' . $judulnih);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S' . $judullagi, 'I');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S' . $judulnih, 'd');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $judulnih, 'e');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $judulnih, 'd');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $judulnih, 'c');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $judulnih, 'b');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $judulnih, 'a');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $judulnih, 'd');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $judulnih, 'c');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $judulnih, 'b');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $judulnih, 'a');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $judulnih, 'd');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $judulnih, 'c');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $judulnih, 'b');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $judulnih, 'a');

        $judulnih = $judulnih + 1;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $judulnih, 1)
            ->setCellValue('B' . $judulnih, 2)
            ->setCellValue('C' . $judulnih, 3)
            ->setCellValue('D' . $judulnih, 4)
            ->setCellValue('E' . $judulnih, 5)
            ->setCellValue('F' . $judulnih, 6)
            ->setCellValue('G' . $judulnih, 7)
            ->setCellValue('H' . $judulnih, 8)
            ->setCellValue('I' . $judulnih, 9)
            ->setCellValue('J' . $judulnih, 10)
            ->setCellValue('K' . $judulnih, 11)
            ->setCellValue('L' . $judulnih, 12)
            ->setCellValue('M' . $judulnih, 13)
            ->setCellValue('N' . $judulnih, 14)
            ->setCellValue('O' . $judulnih, 15)
            ->setCellValue('P' . $judulnih, 16)
            ->setCellValue('Q' . $judulnih, 17)
            ->setCellValue('R' . $judulnih, 18)
            ->setCellValue('S' . $judulnih, 19);
        
        unset($styleArray);
        if ($model):
            $j = $judulnih + 1;
            $no_detail = 1;
            $kolomcpns = 20;
            $jmlcpnssamping = 0;
            $totalbwhiv_e = 0;
            $totalbwhiv_d = 0;
            $totalbwhiv_c = 0;
            $totalbwhiv_b = 0;
            $totalbwhiv_a = 0;
            $totalbwhiii_d = 0;
            $totalbwhiii_c = 0;
            $totalbwhiii_b = 0;
            $totalbwhiii_a = 0;
            $totalbwhii_d = 0;
            $totalbwhii_c = 0;
            $totalbwhii_b = 0;
            $totalbwhii_a = 0;
            $totalbwhi_d = 0;
            $totaliv = 0;
            $totaliii = 0;
            $totalii = 0;
            $totalcpnsbawah = 0;
            $totalsamping = 0;
            foreach ($model as $val):
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $j, $no_detail)
                    ->setCellValue('B' . $j, $val['NMUNIT'])
                    ->setCellValue('C' . $j, $val['JMLIV_E'])
                    ->setCellValue('D' . $j, $val['JMLIV_D'])
                    ->setCellValue('E' . $j, $val['JMLIV_C'])
                    ->setCellValue('F' . $j, $val['JMLIV_B'])
                    ->setCellValue('G' . $j, $val['JMLIV_A'])
                    ->setCellValue('H' . $j, $val['JMLIV_A'] + $val['JMLIV_B'] + $val['JMLIV_C'] + $val['JMLIV_D'] + $val['JMLIV_E'])
                    ->setCellValue('I' . $j, $val['JMLIII_D'])
                    ->setCellValue('J' . $j, $val['JMLIII_C'])
                    ->setCellValue('K' . $j, $val['JMLIII_B'])
                    ->setCellValue('L' . $j, $val['JMLIII_A'])
                    ->setCellValue('M' . $j, $val['JMLIII_A'] + $val['JMLIII_B'] + $val['JMLIII_C'] + $val['JMLIII_D'])
                    ->setCellValue('N' . $j, $val['JMLII_D'])
                    ->setCellValue('O' . $j, $val['JMLII_C'])
                    ->setCellValue('P' . $j, $val['JMLII_B'])
                    ->setCellValue('Q' . $j, $val['JMLII_A'])
                    ->setCellValue('R' . $j, $val['JMLII_A'] + $val['JMLII_B'] + $val['JMLII_C'] + $val['JMLII_D'])
                    ->setCellValue('S' . $j, $val['JMLI_D']);
            
                $kolomcpns = 20;
                $jmlcpnssamping = 0;
                if ($komposisi_cpns):
                    foreach ($komposisi_cpns as $isi):
                        if (isset($val[$isi['TRGOLONGAN_ID'] . "_" . $isi['THN_GOL']]))
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col[$kolomcpns] . $j, $val[$isi['TRGOLONGAN_ID'] . "_" . $isi['THN_GOL']]);
                        $jmlcpnssamping += $val[$isi['TRGOLONGAN_ID'] . "_" . $isi['THN_GOL']];
                        $totalbawah[$isi['TRGOLONGAN_ID'] . "_" . $isi['THN_GOL']][] = $val[$isi['TRGOLONGAN_ID'] . "_" . $isi['THN_GOL']];
                        $kolomcpns++;
                    endforeach;
                endif;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col[$kolomcpns] . $j, $val['JMLIV_A'] + $val['JMLIV_B'] + $val['JMLIV_C'] + $val['JMLIV_D'] + $val['JMLIV_E'] + $val['JMLIII_A'] + $val['JMLIII_B'] + $val['JMLIII_C'] + $val['JMLIII_D'] + $val['JMLII_A'] + $val['JMLII_B'] + $val['JMLII_C'] + $val['JMLII_D'] + $val['JMLI_D'] + $jmlcpnssamping);
                
                $totalbwhiv_e += $val['JMLIV_E'];
                $totalbwhiv_d += $val['JMLIV_D'];
                $totalbwhiv_c += $val['JMLIV_C'];
                $totalbwhiv_b += $val['JMLIV_B'];
                $totalbwhiv_a += $val['JMLIV_A'];
                $totaliv += $val['JMLIV_A'] + $val['JMLIV_B'] + $val['JMLIV_C'] + $val['JMLIV_D'] + $val['JMLIV_E'];
                $totalbwhiii_d += $val['JMLIII_D'];
                $totalbwhiii_c += $val['JMLIII_C'];
                $totalbwhiii_b += $val['JMLIII_B'];
                $totalbwhiii_a += $val['JMLIII_A'];
                $totaliii += $val['JMLIII_A'] + $val['JMLIII_B'] + $val['JMLIII_C'] + $val['JMLIII_D'];
                $totalbwhii_d += $val['JMLII_D'];
                $totalbwhii_c += $val['JMLII_C'];
                $totalbwhii_b += $val['JMLII_B'];
                $totalbwhii_a += $val['JMLII_A'];
                $totalii += $val['JMLII_A'] + $val['JMLII_B'] + $val['JMLII_C'] + $val['JMLII_D'];
                $totalbwhi_d += $val['JMLI_D'];
                $totalsamping += $val['JMLIV_A'] + $val['JMLIV_B'] + $val['JMLIV_C'] + $val['JMLIV_D'] + $val['JMLIV_E'] + $val['JMLIII_A'] + $val['JMLIII_B'] + $val['JMLIII_C'] + $val['JMLIII_D'] + $val['JMLII_A'] + $val['JMLII_B'] + $val['JMLII_C'] + $val['JMLII_D'] + $val['JMLI_D'];
            
                $j++;
                $no_detail++;
            endforeach;
        endif;
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $j, 'Total')
            ->setCellValue('C' . $j, $totalbwhiv_e)
            ->setCellValue('D' . $j, $totalbwhiv_d)
            ->setCellValue('E' . $j, $totalbwhiv_c)
            ->setCellValue('F' . $j, $totalbwhiv_b)
            ->setCellValue('G' . $j, $totalbwhiv_a)
            ->setCellValue('H' . $j, $totaliv)
            ->setCellValue('I' . $j, $totalbwhiii_d)
            ->setCellValue('J' . $j, $totalbwhiii_c)
            ->setCellValue('K' . $j, $totalbwhiii_b)
            ->setCellValue('L' . $j, $totalbwhiii_a)
            ->setCellValue('M' . $j, $totaliii)
            ->setCellValue('N' . $j, $totalbwhii_d)
            ->setCellValue('O' . $j, $totalbwhii_c)
            ->setCellValue('P' . $j, $totalbwhii_b)
            ->setCellValue('Q' . $j, $totalbwhii_a)
            ->setCellValue('R' . $j, $totalii)
            ->setCellValue('S' . $j, $totalbwhi_d);
        $totalcpns = 0;
        $kolomcpns = 20;
        if ($komposisi_cpns) {
            foreach ($komposisi_cpns as $isi) {
                $totalcpns += array_sum($totalbawah[$isi['TRGOLONGAN_ID'] . "_" . $isi['THN_GOL']]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col[$kolomcpns] . $j, array_sum($totalbawah[$isi['TRGOLONGAN_ID'] . "_" . $isi['THN_GOL']]));
                $kolomcpns++;
            }
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col[$kolomcpns] . $j, $totalsamping+$totalcpns);
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $j . ':B' . $j);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':B' .$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&H Komposisi Pegawai Menurut Golongan ' . $this->config->item('instansi_panjang'));
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
    
    public function liststatistikgolongan() {
        $this->data['trlokasi_id'] = (isset($_POST['lokasi_id']) && $_POST['lokasi_id'] != "" && $_POST['lokasi_id'] != '-1') ? $this->input->post('lokasi_id') : 2;
        $this->data['kdu1'] = (isset($_POST['kdu1_id']) && $_POST['kdu1_id'] != "" && $_POST['kdu1_id'] != '-1') ? $this->input->post('kdu1_id') : "";
        $this->data['kdu2'] = (isset($_POST['kdu2_id']) && $_POST['kdu2_id'] != "" && $_POST['kdu2_id'] != '-1') ? $this->input->post('kdu2_id') : "";
        $this->data['kdu3'] = (isset($_POST['kdu3_id']) && $_POST['kdu3_id'] != "" && $_POST['kdu3_id'] != '-1') ? $this->input->post('kdu3_id') : "";
        $this->data['kdu4'] = (isset($_POST['kdu4_id']) && $_POST['kdu4_id'] != "" && $_POST['kdu4_id'] != '-1') ? $this->input->post('kdu4_id') : "";
        $this->data['kdu5'] = (isset($_POST['kdu5_id']) && $_POST['kdu5_id'] != "" && $_POST['kdu5_id'] != '-1') ? $this->input->post('kdu5_id') : "";
        $this->data['golongan'] = isset($_POST['golongan']) ? $this->input->post('golongan') : '';
        $this->data['cpns'] = isset($_POST['cpns']) ? $this->input->post('cpns') : '';
        
        $this->load->view("statistik_golongan/liststatistikgolongan",$this->data);
    }
    
    public function ajax_liststatistikgolongan() {
        if (!$this->input->is_ajax_request()) {
            redirect('beranda/');
        }
        $this->load->model(['statistik_golongan_detail_model']);
        $list = $this->statistik_golongan_detail_model->get_datatables();
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
            "recordsTotal" => $this->statistik_golongan_detail_model->count_all(),
            "recordsFiltered" => $this->statistik_golongan_detail_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

}
