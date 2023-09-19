<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Statistik_pendidikan extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('statistik_pendidikan/statistik_pendidikan_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = ['assets/plugins/select2/js/select2.full.min.js'];
        $this->data['custom_js'] = ['statistik_pendidikan/js'];
        $this->data['title_utama'] = 'Statistik Pendidikan';
    }

    public function index() {
        $this->data['content'] = 'statistik_pendidikan/index';
        $this->load->view('layouts/main', $this->data);
    }

    public function pencarian_proses() {
        $this->data['data_komposisi'] = $this->statistik_pendidikan_model->get_data();
        $this->load->view("statistik_pendidikan/_hasil", $this->data);
    }

    public function export_pdf() {
        $this->data['data_komposisi'] = $this->statistik_pendidikan_model->get_data();
        $this->data['content'] = 'statistik_pendidikan/pdf';

        $this->load->library('M_pdf');
        $this->m_pdf->set_paper('a4', 'landscape');
        $this->m_pdf->load_view("layouts/print", $this->data);
        $this->m_pdf->render();
        $this->m_pdf->stream($this->data['title_utama'] . " " . 'Periode ' . month_indo(date('m')) . " " . date("Y"));
    }

    public function export_excel() {
        $model = $this->statistik_pendidikan_model->get_data();
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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'KOMPOSISI PEGAWAI MENURUT PENDIDIKAN');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $this->config->item('instansi_panjang'));
        $objPHPExcel->getActiveSheet()->mergeCells('A2:N2');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'Periode ' . month_indo(date('m')) . " " . date("Y"));
        $objPHPExcel->getActiveSheet()->mergeCells('A3:N3');

        $judul = 5;
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
        $objPHPExcel->getActiveSheet()->getStyle('A1:N' . $judul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:N' . $judul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $judul, 'NO')
                ->setCellValue('B' . $judul, 'NAMA KANTOR SAR')
                ->setCellValue('C' . $judul, 'S3')
                ->setCellValue('D' . $judul, 'S2')
                ->setCellValue('E' . $judul, 'PROFESI')
                ->setCellValue('F' . $judul, 'S1')
                ->setCellValue('G' . $judul, 'D4')
                ->setCellValue('H' . $judul, 'D3')
                ->setCellValue('I' . $judul, 'D2')
                ->setCellValue('J' . $judul, 'D1')
                ->setCellValue('K' . $judul, 'SLTA')
                ->setCellValue('L' . $judul, 'SLTP')
                ->setCellValue('M' . $judul, 'SD')
                ->setCellValue('N' . $judul, 'JUMLAH');

//        unset($styleArray);
        $j = $judul+1;
        if ($model):
            $k = 1;
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
            $totalsamping = 0;
            $totalcpnsbawah = 0;
            foreach ($model as $val):
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $k)
                        ->setCellValue('B' . $j, $val['NMUNIT'])
                        ->setCellValue('C' . $j, $val['JML_S3'])
                        ->setCellValue('D' . $j, $val['JML_S2'])
                        ->setCellValue('E' . $j, $val['JML_PROFESI'])
                        ->setCellValue('F' . $j, $val['JML_S1'])
                        ->setCellValue('G' . $j, $val['JML_D4'])
                        ->setCellValue('H' . $j, $val['JML_D3'])
                        ->setCellValue('I' . $j, $val['JML_D2'])
                        ->setCellValue('J' . $j, $val['JML_D1'])
                        ->setCellValue('K' . $j, $val['JML_SMA'])
                        ->setCellValue('L' . $j, $val['JML_SMP'])
                        ->setCellValue('M' . $j, $val['JML_SD'])
                        ->setCellValue('N' . $j, $val['JML_SD'] + $val['JML_SMP'] + $val['JML_SMA'] + $val['JML_D1'] + $val['JML_D2'] + $val['JML_D3'] + $val['JML_D4'] + $val['JML_PROFESI'] + $val['JML_S1'] + $val['JML_S2'] + $val['JML_S3']);

                $totalbwhiv_e += $val['JML_S3'];
                $totalbwhiv_d += $val['JML_S2'];
                $totalbwhiv_b += $val['JML_PROFESI'];
                $totalbwhiv_c += $val['JML_S1'];
                $totalbwhiv_a += $val['JML_D4'];
                $totalbwhiii_d += $val['JML_D3'];
                $totalbwhiii_c += $val['JML_D2'];
                $totalbwhiii_b += $val['JML_D1'];
                $totalbwhiii_a += $val['JML_SMA'];
                $totalbwhii_d += $val['JML_SMP'];
                $totalbwhii_c += $val['JML_SD'];
                $totalsamping += $val['JML_SD'] + $val['JML_SMP'] + $val['JML_SMA'] + $val['JML_D1'] + $val['JML_D2'] + $val['JML_D3'] + $val['JML_D4'] + $val['JML_PROFESI'] + $val['JML_S1'] + $val['JML_S2'] + $val['JML_S3'];
                $k++;
                $j++;
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
            ->setCellValue('N' . $j, $totalbwhii_d);
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$j.':B'.$j);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$j.':B'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$j.':B'.$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':N10')->applyFromArray($styleArray);

        // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
        //echo date('H:i:s') . " Set header/footer\n";
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&H Komposisi Pegawai Menurut Pendidikan ' . $this->config->item('instansi_panjang'));
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
