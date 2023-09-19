<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Beranda extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }

        $this->data['title_utama'] = 'Beranda';
        $this->data['plugin_js'] = array_merge(list_js_datatable(), ['assets/plugins/select2/js/select2.full.min.js?v='.uniqid(), 'assets/plugins/amcharts/amcharts.js?v='.uniqid(), 'assets/plugins/amcharts/serial.js?=v'.uniqid(), 'assets/plugins/amcharts/pie.js?v='.uniqid()]);
        $this->data['custom_js'] = ['beranda/js'];
        $this->load->model(array('list_model', 'beranda_model'));
    }

    public function index() {
        $this->data['content'] = 'beranda/index';
        $this->data['setup_dashboard'] = explode(",", $this->list_model->list_config_by_key("setup_dashboard"));

        $this->data['list_lokasi'] = $this->list_model->list_lokasi_tree_html((!empty($this->session->userdata('trlokasi_id')) && $this->session->userdata('idgroup') == 2 ? $this->session->userdata('trlokasi_id') : ''));
        $this->data['list_kdu1'] = $this->list_model->list_kdu1((!empty($this->session->userdata('trlokasi_id')) && $this->session->userdata('idgroup') == 2 ? $this->session->userdata('trlokasi_id') : 2),(!empty($this->session->userdata('kdu1')) && $this->session->userdata('idgroup') == 2 ? $this->session->userdata('kdu1') : ''));
        $this->data['jml_ultah_hari_ini'] = $this->beranda_model->get_data_ultah("", date('m'), date('d'), 2);
        $this->data['data_jab_stuktural_kosong'] = $this->beranda_model->get_data_jab_stuktural_kosong();
        $this->data['data_pensiun'] = $this->beranda_model->get_data_pensiun();
        $this->data['total_pensiun'] = 0;
        if ($this->data['data_pensiun']) {
            foreach ($this->data['data_pensiun'] as $dp) {
                $this->data['total_pensiun'] = $this->data['total_pensiun'] + $dp['JML'];
            }
        }

        // mon kp
        $bulan = date("m");
        $tahun = date("Y");
        // REGULER
//        if (($bulan == '01') OR ( $bulan == '02') OR ( $bulan == '03') OR ( $bulan == '04')) {
//            $periode_reguler1 = $tahun . "-04-01";
//            $periode_reguler2 = $tahun . "-10-01";
//            $this->data['periode_angkat1']['periode'] = $periode_reguler1;
//            $this->data['periode_angkat2']['periode'] = $periode_reguler2;
//            $this->data['periode_angkat1']['tahun'] = $tahun;
//            $this->data['periode_angkat2']['tahun'] = $tahun;
//            $this->data['periode_angkat1']['bulan'] = "04";
//            $this->data['periode_angkat2']['bulan'] = "10";
//        } else if (($bulan == '05') OR ( $bulan == '06') OR ( $bulan == '07') OR ( $bulan == '08') OR ( $bulan == '09') OR ( $bulan == '10')) {
//            $periode_reguler1 = $tahun . "-10-01";
//            $periode_reguler2 = ($tahun + 1) . "-04-01";
//            $this->data['periode_angkat1']['periode'] = $periode_reguler1;
//            $this->data['periode_angkat2']['periode'] = $periode_reguler2;
//            $this->data['periode_angkat1']['tahun'] = $tahun;
//            $this->data['periode_angkat2']['tahun'] = $tahun + 1;
//            $this->data['periode_angkat1']['bulan'] = "10";
//            $this->data['periode_angkat2']['bulan'] = "04";
//        } else {
//            $periode_reguler1 = ($tahun + 1) . "-04-01";
//            $periode_reguler2 = ($tahun + 1) . "-10-01";
//            $this->data['periode_angkat1']['periode'] = $periode_reguler1;
//            $this->data['periode_angkat2']['periode'] = $periode_reguler2;
//            $this->data['periode_angkat1']['tahun'] = $tahun + 1;
//            $this->data['periode_angkat2']['tahun'] = $tahun + 1;
//            $this->data['periode_angkat1']['bulan'] = "04";
//            $this->data['periode_angkat2']['bulan'] = "10";
//        }
//        $this->data['kp1'] = $this->beranda_model->get_kp_reguler($periode_reguler1);
//        $this->data['kp2'] = $this->beranda_model->get_kp_reguler($periode_reguler2);

        if ($this->data['setup_dashboard'] && in_array(1, $this->data['setup_dashboard'])):
            $jml_jabatan_umum = json_encode($this->beranda_model->get_jml_jabatan_umum());
            $this->data['jml_jabatan_umum'] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $jml_jabatan_umum);
        endif;
        if ($this->data['setup_dashboard'] && in_array(2, $this->data['setup_dashboard'])):
            $jml_jabatan_khusus = json_encode($this->beranda_model->get_jml_jabatan_khusus());
            $this->data['jml_jabatan_khusus'] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $jml_jabatan_khusus);
        endif;
        if ($this->data['setup_dashboard'] && in_array(3, $this->data['setup_dashboard'])):
            $jml_jabatan_eselon = json_encode($this->beranda_model->get_jml_jabatan_eselon());
            $this->data['jml_jabatan_eselon'] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $jml_jabatan_eselon);
        endif;

        $this->load->view('layouts/main', $this->data);
    }

    public function isi() {
        $trlokasi_id = (isset($_GET['lokasi_id']) && $_GET['lokasi_id'] != "" && $_GET['lokasi_id'] != '-1') ? $_GET['lokasi_id'] : 2;
        $kdu1 = (isset($_GET['kdu1_id']) && $_GET['kdu1_id'] != "" && $_GET['kdu1_id'] != '-1') ? $_GET['kdu1_id'] : "";
        $kdu2 = (isset($_GET['kdu2_id']) && $_GET['kdu2_id'] != "" && $_GET['kdu2_id'] != '-1') ? $_GET['kdu2_id'] : "";
        $kdu3 = (isset($_GET['kdu3_id']) && $_GET['kdu3_id'] != "" && $_GET['kdu3_id'] != '-1') ? $_GET['kdu3_id'] : "";
        $kdu4 = (isset($_GET['kdu4_id']) && $_GET['kdu4_id'] != "" && $_GET['kdu4_id'] != '-1') ? $_GET['kdu4_id'] : "";
        $kdu5 = (isset($_GET['kdu5_id']) && $_GET['kdu5_id'] != "" && $_GET['kdu5_id'] != '-1') ? $_GET['kdu5_id'] : "";

        $this->data['setup_dashboard'] = explode(",", $this->list_model->list_config_by_key("setup_dashboard"));
        $this->data['jml_ultah_hari_ini'] = $this->beranda_model->get_data_ultah("", date('m'), date('d'), $trlokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $this->data['data_jab_stuktural_kosong'] = $this->beranda_model->get_data_jab_stuktural_kosong($trlokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $this->data['data_pensiun'] = $this->beranda_model->get_data_pensiun($trlokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $this->data['total_pensiun'] = 0;
        if ($this->data['data_pensiun']) {
            foreach ($this->data['data_pensiun'] as $dp) {
                $this->data['total_pensiun'] = $this->data['total_pensiun'] + $dp['JML'];
            }
        }

        // mon kp
        $bulan = date("m");
        $tahun = date("Y");
        // REGULER
        if (($bulan == '01') OR ( $bulan == '02') OR ( $bulan == '03') OR ( $bulan == '04')) {
            $periode_reguler1 = $tahun . "-04-01";
            $periode_reguler2 = $tahun . "-10-01";
            $this->data['periode_angkat1']['periode'] = $periode_reguler1;
            $this->data['periode_angkat2']['periode'] = $periode_reguler2;
            $this->data['periode_angkat1']['tahun'] = $tahun;
            $this->data['periode_angkat2']['tahun'] = $tahun;
            $this->data['periode_angkat1']['bulan'] = "04";
            $this->data['periode_angkat2']['bulan'] = "10";
        } else if (($bulan == '05') OR ( $bulan == '06') OR ( $bulan == '07') OR ( $bulan == '08') OR ( $bulan == '09') OR ( $bulan == '10')) {
            $periode_reguler1 = $tahun . "-10-01";
            $periode_reguler2 = ($tahun + 1) . "-04-01";
            $this->data['periode_angkat1']['periode'] = $periode_reguler1;
            $this->data['periode_angkat2']['periode'] = $periode_reguler2;
            $this->data['periode_angkat1']['tahun'] = $tahun;
            $this->data['periode_angkat2']['tahun'] = $tahun + 1;
            $this->data['periode_angkat1']['bulan'] = "10";
            $this->data['periode_angkat2']['bulan'] = "04";
        } else {
            $periode_reguler1 = ($tahun + 1) . "-04-01";
            $periode_reguler2 = ($tahun + 1) . "-10-01";
            $this->data['periode_angkat1']['periode'] = $periode_reguler1;
            $this->data['periode_angkat2']['periode'] = $periode_reguler2;
            $this->data['periode_angkat1']['tahun'] = $tahun + 1;
            $this->data['periode_angkat2']['tahun'] = $tahun + 1;
            $this->data['periode_angkat1']['bulan'] = "04";
            $this->data['periode_angkat2']['bulan'] = "10";
        }
        $this->data['kp1'] = $this->beranda_model->get_kp_reguler($periode_reguler1, $trlokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $this->data['kp2'] = $this->beranda_model->get_kp_reguler($periode_reguler2, $trlokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);

        if ($this->data['setup_dashboard'] && in_array(1, $this->data['setup_dashboard'])):
            $jml_jabatan_umum = json_encode($this->beranda_model->get_jml_jabatan_umum($trlokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5));
            $this->data['jml_jabatan_umum'] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $jml_jabatan_umum);
        endif;
        if ($this->data['setup_dashboard'] && in_array(2, $this->data['setup_dashboard'])):
            $jml_jabatan_khusus = json_encode($this->beranda_model->get_jml_jabatan_khusus($trlokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5));
            $this->data['jml_jabatan_khusus'] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $jml_jabatan_khusus);
        endif;
        if ($this->data['setup_dashboard'] && in_array(3, $this->data['setup_dashboard'])):
            $jml_jabatan_eselon = json_encode($this->beranda_model->get_jml_jabatan_eselon($trlokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5));
            $this->data['jml_jabatan_eselon'] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $jml_jabatan_eselon);
        endif;

        $this->load->view('beranda/isi', $this->data);
    }

    public function profileultah() {
        $this->data['get_profile'] = $this->beranda_model->get_profile($this->input->post('id', FALSE));
        $this->load->view('beranda/profileultah', $this->data);
    }

    public function monitoring_pegawai_pensiun() {
        $this->data['get_profile'] = $this->beranda_model->get_daftar_pegawai_pensiun($this->input->post('id', FALSE));
        $this->load->view('beranda/listpensiun', $this->data);
    }

    public function setup_content_beranda() {
        $this->data['setup_dashboard'] = explode(",", $this->list_model->list_config_by_key("setup_dashboard"));
        $this->load->view('beranda/setup_content_beranda', $this->data);
    }

    public function content() {
        $tipe = (isset($_POST['tipe']) && !empty($_POST['tipe'])) ? $this->input->post('tipe', false) : 1;
        $lokasi_id = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? $this->input->post('trlokasi_id', false) : 2;
        $kdu1 = (isset($_POST['kdu1']) && !empty($_POST['kdu1']) && $_POST['kdu1'] != '-1') ? $this->input->post('kdu1', false) : '';
        $kdu2 = (isset($_POST['kdu2']) && !empty($_POST['kdu2']) && $_POST['kdu2'] != '-1') ? $this->input->post('kdu2', false) : '';
        $kdu3 = (isset($_POST['kdu3']) && !empty($_POST['kdu3']) && $_POST['kdu3'] != '-1') ? $this->input->post('kdu3', false) : '';
        $kdu4 = (isset($_POST['kdu4']) && !empty($_POST['kdu4']) && $_POST['kdu4'] != '-1') ? $this->input->post('kdu4', false) : '';
        $kdu5 = (isset($_POST['kdu5']) && !empty($_POST['kdu5']) && $_POST['kdu5'] != '-1') ? $this->input->post('kdu5', false) : '';

        if ($tipe == 1) {
            $this->data['setup_dashboard'] = explode(",", $this->list_model->list_config_by_key("setup_dashboard"));
            if ($this->data['setup_dashboard'] && in_array(1, $this->data['setup_dashboard'])):
                $jml_jabatan_umum = json_encode($this->beranda_model->get_jml_jabatan_umum($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5));
                $this->data['jml_jabatan_umum'] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $jml_jabatan_umum);
            endif;
            if ($this->data['setup_dashboard'] && in_array(2, $this->data['setup_dashboard'])):
                $jml_jabatan_khusus = json_encode($this->beranda_model->get_jml_jabatan_khusus($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5));
                $this->data['jml_jabatan_khusus'] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $jml_jabatan_khusus);
            endif;
            if ($this->data['setup_dashboard'] && in_array(1, $this->data['setup_dashboard'])):
                $jml_jabatan_eselon = json_encode($this->beranda_model->get_jml_jabatan_eselon($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5));
                $this->data['jml_jabatan_eselon'] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $jml_jabatan_eselon);
            endif;
            $this->load->view('beranda/chart', $this->data);
        } elseif ($tipe == 2) {
            $lokasi_id = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? $this->input->post('trlokasi_id', false) : '';
            $this->data['model'] = $this->beranda_model->get_jml_eselon_tkt($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
            $jml = 0;
            if ($this->data['model']):
                foreach ($this->data['model'] as $val):
                    $jml += $val['JML'];
                endforeach;
            endif;
            $this->data['total'] = $jml;

            $this->load->view('beranda/content_jabatan_struktural', $this->data);
        } elseif ($tipe == 3) {
            $this->data['model'] = $this->beranda_model->get_jml_jabatan_khusus($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
            $jml = 0;
            if ($this->data['model']):
                foreach ($this->data['model'] as $val):
                    $jml += $val['value'];
                endforeach;
            endif;
            $this->data['total'] = $jml;

            $this->load->view('beranda/content_jabatan_khusus', $this->data);
        } elseif ($tipe == 4) {
            $this->data['model'] = $this->beranda_model->get_jml_jabatan_umum($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
            $jml = 0;
            if ($this->data['model']):
                foreach ($this->data['model'] as $val):
                    $jml += $val['value'];
                endforeach;
            endif;
            $this->data['total'] = $jml;

            $this->load->view('beranda/content_jabatan_umum', $this->data);
        } elseif ($tipe == 5) {
            $this->data['model'] = $this->beranda_model->get_jml_diklat_pim($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
            $jml = 0;
            if ($this->data['model']):
                foreach ($this->data['model'] as $val):
                    $jml += $val['JML'];
                endforeach;
            endif;
            $this->data['total'] = $jml;

            $this->load->view('beranda/content_jabatan_diklat_pim', $this->data);
        } elseif ($tipe == 6) {
            $this->data['model'] = $this->beranda_model->get_jml_pendidikan($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
            $jml = 0;
            if ($this->data['model']):
                foreach ($this->data['model'] as $val):
                    $jml += $val['JML'];
                endforeach;
            endif;
            $this->data['total'] = $jml;

            $this->load->view('beranda/content_jabatan_pendidikan', $this->data);
        }
    }

    public function content_excel() {
        $tipe = (isset($_GET['tipe']) && !empty($_GET['tipe'])) ? $this->input->get('tipe', false) : 1;
        $lokasi_id = (isset($_GET['trlokasi_id']) && !empty($_GET['trlokasi_id'])) ? $this->input->get('trlokasi_id', false) : 2;
        $kdu1 = (isset($_GET['kdu1']) && !empty($_GET['kdu1']) && $_GET['kdu1'] != '-1') ? $this->input->get('kdu1', false) : '';
        $kdu2 = (isset($_GET['kdu2']) && !empty($_GET['kdu2']) && $_GET['kdu2'] != '-1') ? $this->input->get('kdu2', false) : '';
        $kdu3 = (isset($_GET['kdu3']) && !empty($_GET['kdu3']) && $_GET['kdu3'] != '-1') ? $this->input->get('kdu3', false) : '';
        $kdu4 = (isset($_GET['kdu4']) && !empty($_GET['kdu4']) && $_GET['kdu4'] != '-1') ? $this->input->get('kdu4', false) : '';
        $kdu5 = (isset($_GET['kdu5']) && !empty($_GET['kdu5']) && $_GET['kdu5'] != '-1') ? $this->input->get('kdu5', false) : '';

        $struktur = $this->beranda_model->get_struktur($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);

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

        if ($tipe == 2) {
            $model = $this->beranda_model->get_jml_eselon_tkt($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
            $jumlah = count($model);
            $jml = 0;
            if ($model):
                foreach ($model as $val):
                    $jml += $val['JML'];
                endforeach;
            endif;
            $total = $jml;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Pegawai Berdasarkan Jabatan Struktural');
            $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');

            $judul = 2;
            if (isset($struktur['NMSTRUKTUR']) && !empty($struktur['NMSTRUKTUR'])):
                $nmstruktur = '';
                $pecah = explode(", ", $struktur['NMSTRUKTUR']);
                if ($pecah > 0) {
                    $awal = 0;
                    foreach ($pecah as $val) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $pecah[$awal]);
                        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':D' . $judul);
                        $judul++;
                        $awal++;
                    }
                }
            endif;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':D' . $judul);

            $masihjudul = $judul + 1;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':D' . $masihjudul);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getStyle('A1:D' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:D' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

            $judultabellagi = $masihjudul + 2;
            $judultabel = $masihjudul + 3;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $judultabellagi, "No")
                    ->setCellValue('B' . $judultabellagi, "Eselon")
                    ->setCellValue('C' . $judultabellagi, "Jumlah")
                    ->setCellValue('D' . $judultabellagi, "Persen");
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . ($judultabel + $jumlah))->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            unset($styleArray);
            $j = $judultabel + 0;
            $no_detail = 1;
            $jmltotal = 0;
            if ($model) {
                foreach ($model as $val) {
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':D' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ":D" . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $j, $no_detail)
                            ->setCellValue('B' . $j, $val['SINGKATAN'])
                            ->setCellValue('C' . $j, $val['JML']." Pegawai")
                            ->setCellValue('D' . $j, round(($val['JML'] * 100) / $total, 2) . " %");

                    $no_detail++;
                    $j++;
                    $jmltotal += ($val['JML'] * 100) / $total;
                }
            }
            $totalakhir = $j;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $totalakhir, "Total")
                ->setCellValue('C' . $totalakhir, $total." Pegawai")
                ->setCellValue('D' . $totalakhir, $jmltotal . " %");
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $totalakhir . ':B' . $totalakhir);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $totalakhir . ":D" . $totalakhir)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
            //echo date('H:i:s') . " Set header/footer\n";
            $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPegawai Berdasarkan Jabatan Struktural ' . $this->config->item('instansi_panjang'));
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
            header('Content-Disposition: attachment;filename="Pegawai Berdasarkan Jabatan Struktural Periode ' . month_indo(date('m')) . " " . date("Y") . '.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } elseif ($tipe == 3) {
            $model = $this->beranda_model->get_jml_jabatan_khusus($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
            $jumlah = count($model);
            $jml = 0;
            if ($model):
                foreach ($model as $val):
                    $jml += $val['value'];
                endforeach;
            endif;
            $total = $jml;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Pegawai Berdasarkan Jabatan Fungsional Tertentu');
            $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');

            $judul = 2;
            if (isset($struktur['NMSTRUKTUR']) && !empty($struktur['NMSTRUKTUR'])):
                $nmstruktur = '';
                $pecah = explode(", ", $struktur['NMSTRUKTUR']);
                if ($pecah > 0) {
                    $awal = 0;
                    foreach ($pecah as $val) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $pecah[$awal]);
                        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':D' . $judul);
                        $judul++;
                        $awal++;
                    }
                }
            endif;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':D' . $judul);

            $masihjudul = $judul + 1;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':D' . $masihjudul);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getStyle('A1:D' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:D' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

            $judultabellagi = $masihjudul + 2;
            $judultabel = $masihjudul + 2;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $judultabellagi, "No")
                    ->setCellValue('B' . $judultabellagi, "Jabatan")
                    ->setCellValue('C' . $judultabellagi, "Jumlah")
                    ->setCellValue('D' . $judultabellagi, "Persen");
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . ($judultabel + $jumlah + 1))->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            unset($styleArray);
            $j = $judultabel + 1;
            $no_detail = 1;
            $jmltotal = 0;
            if ($model) {
                foreach ($model as $val) {
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':D' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $j . ":D" . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $j, $no_detail)
                            ->setCellValue('B' . $j, $val['jabatan'])
                            ->setCellValue('C' . $j, $val['value']." Pegawai")
                            ->setCellValue('D' . $j, round(($val['value'] * 100) / $total, 2) . " %");

                    $no_detail++;
                    $j++;
                    $jmltotal += ($val['value'] * 100) / $total;
                }
            }
            $totalakhir = $j;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $totalakhir, "Total")
                ->setCellValue('C' . $totalakhir, $total." Pegawai")
                ->setCellValue('D' . $totalakhir, $jmltotal . " %");
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $totalakhir . ':B' . $totalakhir);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $totalakhir . ":D" . $totalakhir)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
            //echo date('H:i:s') . " Set header/footer\n";
            $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPegawai Berdasarkan Jabatan Fungsional Tertentu ' . $this->config->item('instansi_panjang'));
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
            header('Content-Disposition: attachment;filename="Pegawai Berdasarkan Jabatan Fungsional Tertentu Periode ' . month_indo(date('m')) . " " . date("Y") . '.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } elseif ($tipe == 4) {
            $model = $this->beranda_model->get_jml_jabatan_umum($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
            $jumlah = count($model);
            $jml = 0;
            if ($model):
                foreach ($model as $val):
                    $jml += $val['value'];
                endforeach;
            endif;
            $total = $jml;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Pegawai Berdasarkan Jabatan Fungsional Umum');
            $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');

            $judul = 2;
            if (isset($struktur['NMSTRUKTUR']) && !empty($struktur['NMSTRUKTUR'])):
                $nmstruktur = '';
                $pecah = explode(", ", $struktur['NMSTRUKTUR']);
                if ($pecah > 0) {
                    $awal = 0;
                    foreach ($pecah as $val) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $pecah[$awal]);
                        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':D' . $judul);
                        $judul++;
                        $awal++;
                    }
                }
            endif;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':D' . $judul);

            $masihjudul = $judul + 1;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':D' . $masihjudul);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getStyle('A1:D' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:D' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

            $judultabellagi = $masihjudul + 2;
            $judultabel = $masihjudul + 2;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $judultabellagi, "No")
                    ->setCellValue('B' . $judultabellagi, "Jabatan")
                    ->setCellValue('C' . $judultabellagi, "Jumlah")
                    ->setCellValue('D' . $judultabellagi, "Persen");
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . ($judultabel + $jumlah + 1))->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            unset($styleArray);
            $j = $judultabel + 1;
            $no_detail = 1;
            $jmltotal = 0;
            if ($model) {
                foreach ($model as $val) {
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':D' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $j . ":D" . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $j, $no_detail)
                            ->setCellValue('B' . $j, $val['jabatan'])
                            ->setCellValue('C' . $j, $val['value']." Pegawai")
                            ->setCellValue('D' . $j, round(($val['value'] * 100) / $total, 2) . " %");

                    $no_detail++;
                    $j++;
                    $jmltotal += ($val['value'] * 100) / $total;
                }
            }
            $totalakhir = $j;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $totalakhir, "Total")
                ->setCellValue('C' . $totalakhir, $total." Pegawai")
                ->setCellValue('D' . $totalakhir, $jmltotal . " %");
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $totalakhir . ':B' . $totalakhir);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $totalakhir . ":D" . $totalakhir)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
            //echo date('H:i:s') . " Set header/footer\n";
            $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPegawai Berdasarkan Jabatan Fungsional Umum ' . $this->config->item('instansi_panjang'));
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
            header('Content-Disposition: attachment;filename="Pegawai Berdasarkan Jabatan Fungsional Umum Periode ' . month_indo(date('m')) . " " . date("Y") . '.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } elseif ($tipe == 5) {
            $model = $this->beranda_model->get_jml_diklat_pim($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
            $jumlah = count($model);
            $jml = 0;
            if ($model):
                foreach ($model as $val):
                    $jml += $val['JML'];
                endforeach;
            endif;
            $total = $jml;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Pegawai Berdasarkan Diklat Kepemimpinan');
            $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');

            $judul = 2;
            if (isset($struktur['NMSTRUKTUR']) && !empty($struktur['NMSTRUKTUR'])):
                $nmstruktur = '';
                $pecah = explode(", ", $struktur['NMSTRUKTUR']);
                if ($pecah > 0) {
                    $awal = 0;
                    foreach ($pecah as $val) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $pecah[$awal]);
                        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':D' . $judul);
                        $judul++;
                        $awal++;
                    }
                }
            endif;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':D' . $judul);

            $masihjudul = $judul + 1;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':D' . $masihjudul);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getStyle('A1:D' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:D' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

            $judultabellagi = $masihjudul + 2;
            $judultabel = $masihjudul + 2;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $judultabellagi, "No")
                    ->setCellValue('B' . $judultabellagi, "Diklat PIM")
                    ->setCellValue('C' . $judultabellagi, "Jumlah")
                    ->setCellValue('D' . $judultabellagi, "Persen");
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . ($judultabel + $jumlah + 1))->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            unset($styleArray);
            $j = $judultabel + 1;
            $no_detail = 1;
            $jmltotal = 0;
            if ($model) {
                foreach ($model as $val) {
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':D' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $j . ":D" . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $j, $no_detail)
                            ->setCellValue('B' . $j, $val['NAMA_JENJANG'])
                            ->setCellValue('C' . $j, $val['JML']." Pegawai")
                            ->setCellValue('D' . $j, round(($val['JML'] * 100) / $total, 2) . " %");

                    $no_detail++;
                    $j++;
                    $jmltotal += ($val['JML'] * 100) / $total;
                }
            }
            $totalakhir = $j;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $totalakhir, "Total")
                ->setCellValue('C' . $totalakhir, $total." Pegawai")
                ->setCellValue('D' . $totalakhir, $jmltotal . " %");
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $totalakhir . ':B' . $totalakhir);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $totalakhir . ":D" . $totalakhir)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
            //echo date('H:i:s') . " Set header/footer\n";
            $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPegawai Berdasarkan Diklat Kepemimpinan ' . $this->config->item('instansi_panjang'));
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
            header('Content-Disposition: attachment;filename="Pegawai Berdasarkan Diklat Kepemimpinan Periode ' . month_indo(date('m')) . " " . date("Y") . '.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } elseif ($tipe == 6) {
            $model = $this->beranda_model->get_jml_pendidikan($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
            $jumlah = count($model);
            $jml = 0;
            if ($model):
                foreach ($model as $val):
                    $jml += $val['JML'];
                endforeach;
            endif;
            $total = $jml;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Pegawai Berdasarkan Pendidikan');
            $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');

            $judul = 2;
            if (isset($struktur['NMSTRUKTUR']) && !empty($struktur['NMSTRUKTUR'])):
                $nmstruktur = '';
                $pecah = explode(", ", $struktur['NMSTRUKTUR']);
                if ($pecah > 0) {
                    $awal = 0;
                    foreach ($pecah as $val) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $pecah[$awal]);
                        $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':D' . $judul);
                        $judul++;
                        $awal++;
                    }
                }
            endif;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $judul, $this->config->item('instansi_panjang'));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $judul . ':D' . $judul);

            $masihjudul = $judul + 1;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $masihjudul, 'Periode ' . month_indo(date('m')) . " " . date("Y"));
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $masihjudul . ':D' . $masihjudul);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getStyle('A1:D' . $masihjudul)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:D' . $masihjudul)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

            $judultabellagi = $masihjudul + 2;
            $judultabel = $masihjudul + 2;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $judultabellagi, "No")
                    ->setCellValue('B' . $judultabellagi, "Tingkat Pendidikan")
                    ->setCellValue('C' . $judultabellagi, "Jumlah")
                    ->setCellValue('D' . $judultabellagi, "Persen");
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . ($judultabel + $jumlah + 1))->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . $judultabel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $judultabellagi . ':D' . $judultabel)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            unset($styleArray);
            $j = $judultabel + 1;
            $no_detail = 1;
            $jmltotal = 0;
            if ($model) {
                foreach ($model as $val) {
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j . ':D' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $j . ":D" . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $j, $no_detail)
                            ->setCellValue('B' . $j, $val['TINGKAT_PENDIDIKAN'])
                            ->setCellValue('C' . $j, $val['JML']." Pegawai")
                            ->setCellValue('D' . $j, round(($val['JML'] * 100) / $total, 2) . " %");

                    $no_detail++;
                    $j++;
                    $jmltotal += ($val['JML'] * 100) / $total;
                }
            }
            $totalakhir = $j;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $totalakhir, "Total")
                ->setCellValue('C' . $totalakhir, $total." Pegawai")
                ->setCellValue('D' . $totalakhir, $jmltotal . " %");
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $totalakhir . ':B' . $totalakhir);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $totalakhir . ":D" . $totalakhir)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            // Set header and footer. When no different headers for odd/even are used, odd header is assumed.
            //echo date('H:i:s') . " Set header/footer\n";
            $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPegawai Berdasarkan Pendidikan ' . $this->config->item('instansi_panjang'));
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
            header('Content-Disposition: attachment;filename="Pegawai Berdasarkan Pendidikan Periode ' . month_indo(date('m')) . " " . date("Y") . '.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

    public function simpansetupdashboard() {
        if ($this->beranda_model->savesetupdashboard(['ISINYA' => implode(",", $this->input->post("tipe", TRUE))])) {
            return TRUE;
        }

        return FALSE;
    }

}
