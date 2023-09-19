<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

ini_set('error_reporting', 0);

//require_once APPPATH."html2pdf/html2pdf.class.php";

class Peta_jabatan extends CI_Controller {

    private $hakakses;

    function __construct() {
        parent::__construct();
//        session_start();
//        $this->load->load->config('frm_wilayah', true);
//        $this->load->library(array('form_validation', 'groupakses'));
        $this->load->model(array('peta_jabatan/peta_jabatan_model','list_model'));
//        $this->hakakses = $this->groupakses->setAksesGroup();
        //$this->load->helper(array('url','peta_jabatan'));
    }

    function index() {
//        $this->output->enable_profiler(false);
//        $hakakses = $this->groupakses->setAksesGroup();
//        $data['lokgroup'] = $hakakses['lokgroup'];
//        $data['kdu1group'] = $hakakses['kdu1group'];
//        $data['KDU2group'] = $hakakses['kdu2group'];
//        $data['kdu3group'] = $hakakses['kdu3group'];
//        $data['kdu4group'] = $hakakses['kdu4group'];
//        $data['kdu5group'] = $hakakses['kdu5group'];

        $data['judul'] = 'Struktural  &rsaquo; Peta Jabatan &rsaquo; Struktur Organisasi';
        $data['title'] = 'Struktural  &rsaquo; Peta Jabatan &rsaquo; Struktur Organisasi';
        $data['head_title'] = 'SIMPEG &copy; 2010';
        $data['menteri'] = $this->peta_jabatan_model->get_single_data_ka();
//        $data['wmenteri'] = $this->config->item('string_wamen', 'config_appl');
//        $data['menteri_desc'] = array("nama" => $this->config->item('nama_menteri', 'config_appl'), "foto" => "menteri.jpg");
//        $data['wmenteri_desc'] = array("nama" => $this->config->item('nama_wamen', 'config_appl'), "foto" => "wmenteri.jpg");
//        $data['menu'] = $this->menu_backsite_model->listTree();
//        $data['list_loker'] = $this->list_model->list_loker($hakakses['wherelok']);
        /* $data['list_struktur_es1']	= $this->list_model->list_struktur_es1('1');
          $get_data_eselon1			= $this->peta_jabatan_model->get_first_eselon1('1','1');
          $data['data_first'] 		= $get_data_eselon1;
          switch($get_data_eselon1['TKTESELON'])
          {
          default:
          case '1' : $next_esel = '2'; break;
          case '2' : $next_esel = '3'; break;
          case '3' : $next_esel = '4'; break;
          case '4' : $next_esel = '5'; break;
          case '5' : $next_esel = '6'; break;

          }
          $data['data_master'] 		= $this->peta_jabatan_model->get_data_master($next_esel,$get_data_eselon1['lok'],$get_data_eselon1['kdu1'],$get_data_eselon1['kdu2'],$get_data_eselon1['kdu3'],$get_data_eselon1['kdu4'],$get_data_eselon1['kdu5']);
          $this->load->vars($data); */
//        $data['list_struktur_es1'] = $this->list_model->list_struktur_es1($hakakses['lokgroup'], $hakakses['whereeselon1']);
//        $data['list_struktur_es2'] = $this->list_model->list_struktur_es2($hakakses['lokgroup'], $hakakses['kdu1group'], $hakakses['whereeselon2']);
//        $data['list_struktur_es3'] = $this->list_model->list_struktur_es3($hakakses['lokgroup'], $hakakses['kdu1group'], $hakakses['kdu2group'], $hakakses['whereeselon3']);
//        $data['list_struktur_es4'] = $this->list_model->list_struktur_es4($hakakses['lokgroup'], $hakakses['kdu1group'], $hakakses['kdu2group'], $hakakses['kdu3group'], $hakakses['whereeselon4']);
//        $data['list_struktur_es5'] = $this->list_model->list_struktur_es5($hakakses['lokgroup'], $hakakses['kdu1group'], $hakakses['kdu2group'], $hakakses['kdu3group'], $hakakses['kdu4group'], $hakakses['whereeselon5']);

//        $arraygroup = array('1', '12');
//        if (!in_array($_SESSION['admin-id_group'], $arraygroup)) {
//            $sqluid = $this->peta_jabatan_model->get_data_single($hakakses['TKTESELONgroup'], $hakakses['lokgroup'], $hakakses['kdu1group'], $hakakses['kdu2group'], $hakakses['kdu3group'], $hakakses['kdu4group'], $hakakses['kdu5group']);
//            $where = array('id' => $sqluid, 'status' => 1);
//            $detail = $this->peta_jabatan_model->get_struktur('V_STRUKTUR', $where);
//            $data['data_first'] = $detail;
//            switch ($detail['TKTESELON']) {
//                default:
//                case '1' : $next_esel = '2';
//                    break;
//                case '2' : $next_esel = '3';
//                    break;
//                case '3' : $next_esel = '4';
//                    break;
//                case '4' : $next_esel = '5';
//                    break;
//                case '5' : $next_esel = '6';
//                    break;
//            }

//            $data['data_master'] = $this->peta_jabatan_model->get_data_master($next_esel, $detail['lok'], $detail['kdu1'], $detail['kdu2'], $detail['kdu3'], $detail['kdu4'], $detail['kdu5']);
//            $data['awal'] = '1';
//            $this->load->vars($data);
//            $this->load->view('peta_jabatan/tpl_page_group');
//        } else {
//        echo $hakakses['lokgroup']."<br />".$hakakses['TKTESELONgroup'];exit;
//            $data['data_master'] = $this->peta_jabatan_model->get_data_first($hakakses['lokgroup'], $hakakses['TKTESELONgroup'], $hakakses['kdu1group'], $hakakses['kdu2group'], $hakakses['kdu3group'], $hakakses['kdu4group'], $hakakses['kdu5group']);
            $data['data_master'] = $this->peta_jabatan_model->get_data_first();
//            print "<pre>";
//            print_r($data['data_master']);
//            exit;
            $this->load->vars($data);
            $this->load->view('peta_jabatan/tpl_page');
//        }
    }

    function printnih() {
        $this->output->enable_profiler(false);
        $hakakses = $this->groupakses->setAksesGroup();
        $data['lokgroup'] = $hakakses['lokgroup'];
        $data['kdu1group'] = $hakakses['kdu1group'];
        $data['kdu2group'] = $hakakses['kdu2group'];
        $data['kdu3group'] = $hakakses['kdu3group'];
        $data['kdu4group'] = $hakakses['kdu4group'];
        $data['kdu5group'] = $hakakses['kdu5group'];

        $data['judul'] = 'Struktural  &rsaquo; Peta Jabatan &rsaquo; Struktur Organisasi';
        $data['title'] = 'Struktural  &rsaquo; Peta Jabatan &rsaquo; Struktur Organisasi';
        $data['head_title'] = 'SIMPEG &copy; 2010';
        $data['menteri'] = $this->Daftar_menteri_model->get_single_data();
//        $data['wmenteri'] = $this->config->item('string_wamen', 'config_appl');
//        $data['menteri_desc'] = array("nama" => $this->config->item('nama_menteri', 'config_appl'), "foto" => "menteri.jpg");
//        $data['wmenteri_desc'] = array("nama" => $this->config->item('nama_wamen', 'config_appl'), "foto" => "wmenteri.jpg");
        $data['menu'] = $this->menu_backsite_model->listTree();
        $data['list_loker'] = $this->list_model->list_loker($hakakses['wherelok']);
        /* $data['list_struktur_es1']	= $this->list_model->list_struktur_es1('1');
          $get_data_eselon1			= $this->peta_jabatan_model->get_first_eselon1('1','1');
          $data['data_first'] 		= $get_data_eselon1;
          switch($get_data_eselon1['TKTESELON'])
          {
          default:
          case '1' : $next_esel = '2'; break;
          case '2' : $next_esel = '3'; break;
          case '3' : $next_esel = '4'; break;
          case '4' : $next_esel = '5'; break;
          case '5' : $next_esel = '6'; break;

          }
          $data['data_master'] 		= $this->peta_jabatan_model->get_data_master($next_esel,$get_data_eselon1['lok'],$get_data_eselon1['kdu1'],$get_data_eselon1['kdu2'],$get_data_eselon1['kdu3'],$get_data_eselon1['kdu4'],$get_data_eselon1['kdu5']);
          $this->load->vars($data); */
        $data['list_struktur_es1'] = $this->list_model->list_struktur_es1($hakakses['lokgroup'], $hakakses['whereeselon1']);
        $data['list_struktur_es2'] = $this->list_model->list_struktur_es2($hakakses['lokgroup'], $hakakses['kdu1group'], $hakakses['whereeselon2']);
        $data['list_struktur_es3'] = $this->list_model->list_struktur_es3($hakakses['lokgroup'], $hakakses['kdu1group'], $hakakses['kdu2group'], $hakakses['whereeselon3']);
        $data['list_struktur_es4'] = $this->list_model->list_struktur_es4($hakakses['lokgroup'], $hakakses['kdu1group'], $hakakses['kdu2group'], $hakakses['kdu3group'], $hakakses['whereeselon4']);
        $data['list_struktur_es5'] = $this->list_model->list_struktur_es5($hakakses['lokgroup'], $hakakses['kdu1group'], $hakakses['kdu2group'], $hakakses['kdu3group'], $hakakses['kdu4group'], $hakakses['whereeselon5']);

        $arraygroup = array('1', '12');
        if (!in_array($_SESSION['admin-id_group'], $arraygroup)) {
            $sqluid = $this->peta_jabatan_model->get_data_single($hakakses['TKTESELONgroup'], $hakakses['lokgroup'], $hakakses['kdu1group'], $hakakses['kdu2group'], $hakakses['kdu3group'], $hakakses['kdu4group'], $hakakses['kdu5group']);
            $where = array('id' => $sqluid, 'status' => 1);
            $detail = $this->peta_jabatan_model->get_struktur('V_STRUKTUR', $where);
            $data['data_first'] = $detail;
            switch ($detail['TKTESELON']) {
                default:
                case '1' : $next_esel = '2';
                    break;
                case '2' : $next_esel = '3';
                    break;
                case '3' : $next_esel = '4';
                    break;
                case '4' : $next_esel = '5';
                    break;
                case '5' : $next_esel = '6';
                    break;
            }

            $data['data_master'] = $this->peta_jabatan_model->get_data_master($next_esel, $detail['lok'], $detail['kdu1'], $detail['kdu2'], $detail['kdu3'], $detail['kdu4'], $detail['kdu5']);
            $data['awal'] = '1';
            $this->load->vars($data);
            $this->load->view('peta_jabatan/tpl_page_group');
        } else {
//        echo $hakakses['lokgroup']."<br />".$hakakses['TKTESELONgroup'];exit;
            $data['data_master'] = $this->peta_jabatan_model->get_data_first($hakakses['lokgroup'], $hakakses['TKTESELONgroup'], $hakakses['kdu1group'], $hakakses['kdu2group'], $hakakses['kdu3group'], $hakakses['kdu4group'], $hakakses['kdu5group']);
//            print "<pre>";
//            print_r($data['data_master']);
//            exit;
            $this->load->vars($data);
            $this->load->view('peta_jabatan/test');
        }
    }

    # Get Struktur

    function pilih_lokasi() {
        $hakakses = $this->groupakses->setAksesGroup();
        $where = '';
        if ($_SESSION['admin-id_group'] != '1' || $_SESSION['admin-id_group'] != '12') {
            if ($_SESSION['admin-group_lok'] == '1' && $_SESSION['admin-group_kdu1'] == '08' && $_POST['lok'] == '1') {
                $where = $hakakses['whereeselon1'];
                $data['kdu1'] = $hakakses['kdu1group'];
            } elseif ($_SESSION['admin-group_lok'] == '1' && $_SESSION['admin-group_kdu1'] == '08' && $_POST['lok'] == '3') {
                $where = " and kdu1 = '07' ";
                $data['kdu1'] = '07';
            } else {
                $where = $hakakses['whereeselon1'];
                $data['kdu1'] = $hakakses['kdu1group'];
            }
        } else {
            $data['lok'] = $_POST['lok'];
            $data['kdu1'] = $_POST['kdu1'];
            $data['kdu2'] = $_POST['kdu2'];
        }

//        $data['kdu1group'] = $hakakses['kdu1group'];
        $data['list_struktur_es1'] = $this->list_model->list_struktur_es1($_POST['lok'], $where);
        $data['menteri'] = $this->Daftar_menteri_model->get_single_data();
//        $data['wmenteri'] = "Wakil Menteri Perhubungan";
//        $data['menteri_desc'] = array("nama" => "EE Mangindaan", "foto" => "menteri.jpg");
//        $data['wmenteri_desc'] = array("nama" => "Bambang Susantono", "foto" => "wmenteri.jpg");
        $data['data_master'] = $this->peta_jabatan_model->get_data_first($_POST['lok'], '1', $data['kdu1']);
        $this->load->vars($data);
        $this->load->view('peta_jabatan/page_pilih_lokasi_eselon');
    }

    function view_master() {
//        $hakakses = $this->groupakses->setAksesGroup();
        $where = '';
//        if ($_SESSION['admin-id_group'] != '1' || $_SESSION['admin-id_group'] != '12') {
//            if ($_SESSION['admin-group_lok'] == '1' && $_SESSION['admin-group_kdu1'] == '08' && $_POST['lok'] == '1') {
//                $where = $hakakses['whereeselon2'];
//            } elseif ($_SESSION['admin-group_lok'] == '1' && $_SESSION['admin-group_kdu1'] == '08' && $_POST['lok'] == '3') {
//                $where = " and kdu1 = '07' ";
//            } else {
//                $where = $hakakses['whereeselon2'];
//            }
//            $_POST['lok'] = $hakakses['lokgroup'];
//            $_POST['kdu1'] = $unitkerja['kdu1group'];
//            $_POST['kdu2'] = $unitkerja['kdu2group'];
//            $_POST['kdu3'] = $unitkerja['kdu3group'];
//            $_POST['kdu4'] = $unitkerja['kdu4group'];
//            $_POST['kdu5'] = $unitkerja['kdu5group'];
//        } else {
//            $data['lok'] = $_POST['lok'];
//            $data['kdu1'] = $_POST['kdu1'];
//            $data['kdu2'] = $_POST['kdu2'];
//        }

        if ($_POST['kdu1'] == '') {
            $data['list_struktur_es1'] = $this->list_model->list_struktur_es1($_GET['lok']);
            $data['menteri'] = "Kepala Basarnas";
            $data['wmenteri'] = "";
            $data['menteri_desc'] = array("nama" => "EE Mangindaan", "foto" => "menteri.jpg");
            $data['wmenteri_desc'] = array("nama" => "Bambang Susantono", "foto" => "wmenteri.jpg");
            $data['data_master'] = $this->peta_jabatan_model->get_data_first($_GET['lok'], '1');
            $this->load->vars($data);
            $this->load->view('peta_jabatan/page_pilih_lokasi_eselon');
        } else {
            $lokasi_id = (isset($_POST['lok']) && !empty($_POST['lok'])) ? trim($this->input->post('lok', TRUE)) : '2';
            $kdu1 = (isset($_POST['kdu1']) && !empty($_POST['kdu1']) && $_POST['kdu1'] != -1) ? trim($this->input->post('kdu1', TRUE)) : '00';
            $kdu2 = (isset($_POST['kdu3']) && !empty($_POST['kdu2']) && $_POST['kdu2'] != -1) ? trim($this->input->post('kdu2', TRUE)) : '00';
            $kdu3 = (isset($_POST['kdu3']) && !empty($_POST['kdu3']) && $_POST['kdu3'] != -1) ? trim($this->input->post('kdu3', TRUE)) : '000';
            $kdu4 = (isset($_POST['kdu4']) && !empty($_POST['kdu4']) && $_POST['kdu4'] != -1) ? trim($this->input->post('kdu4', TRUE)) : '000';
            $kdu5 = (isset($_POST['kdu5']) && !empty($_POST['kdu5']) && $_POST['kdu5'] != -1) ? trim($this->input->post('kdu5', TRUE)) : '00';
            
            $sqlcariTKTESELON = $this->peta_jabatan_model->getdatasingletingkateselon($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
            
            $where = array('TKTESELON' => $sqlcariTKTESELON['TKTESELON'], 'STATUS' => 1, 'TRLOKASI_ID' => $sqlcariTKTESELON['TRLOKASI_ID'], 'KDU1' => $sqlcariTKTESELON['KDU1'],
                'KDU2' => $sqlcariTKTESELON['KDU2'], 'KDU3' => $sqlcariTKTESELON['KDU3'], 'KDU4' => $sqlcariTKTESELON['KDU4'], 'KDU5' => $sqlcariTKTESELON['KDU5']);

            $detail = $this->peta_jabatan_model->get_struktur('V_STRUKTUR', $where);
            $data['menteri'] = $this->config->item('instansi_panjang');
            $data['wmenteri'] = $this->config->item('instansi_panjang');
            $data['menteri_desc'] = array("nama" => "", "foto" => "menteri.jpg");
            $data['wmenteri_desc'] = array("nama" => "", "foto" => "wmenteri.jpg");
            $data['data_first'] = $detail;

            switch ($detail['TKTESELON']) {
                default:
                case '1' : $next_esel = '2';
                    break;
                case '2' : $next_esel = '3';
                    break;
                case '3' : $next_esel = '4';
                    break;
                case '4' : $next_esel = '5';
                    break;
                case '5' : $next_esel = '6';
                    break;
            }
            $data['data_master'] = $this->peta_jabatan_model->get_data_master($next_esel, $detail['TRLOKASI_ID'], $detail['KDU1'], $detail['KDU2'], $detail['KDU3'], $detail['KDU4'], $detail['KDU5'], 'Y');
            $this->load->vars($data);

            if ($next_esel == '5' || $next_esel == '6') {
                $this->load->view('peta_jabatan/tpl_detail');
            } else {
                $this->load->view('peta_jabatan/tpl_master');
            }
        }
    }

    function view_detail() {
//        $hakakses = $this->groupakses->setAksesGroup();
        $where = '';
//        if ($_SESSION['admin-id_group'] != '1' || $_SESSION['admin-id_group'] != '12') {
//            if ($_SESSION['admin-group_lok'] == '1' && $_SESSION['admin-group_kdu1'] == '08' && $_POST['lok'] == '1') {
//                $where = $hakakses['whereeselon2'];
//            } elseif ($_SESSION['admin-group_lok'] == '1' && $_SESSION['admin-group_kdu1'] == '08' && $_POST['lok'] == '3') {
//                $where = " and kdu1 = '07' ";
//            } else {
//                $where = $hakakses['whereeselon2'];
//            }
//        } else {
//            $data['lok'] = $_POST['lok'];
//            $data['kdu1'] = $_POST['kdu1'];
//            $data['kdu2'] = $_POST['kdu2'];
//        }

        $sqluid = $this->peta_jabatan_model->get_data_single('', $_POST['lok'], $_POST['kdu1'], $_POST['kdu2'], $_POST['kdu3'], $_POST['kdu4'], $_POST['kdu5']);
        
        if (!isset($_POST['uid']) || empty($_POST['uid'])) {
            $where = array('ID' => $sqluid, 'STATUS' => 1);
        } else {
            $where = array('ID' => $_POST['uid'], 'STATUS' => 1);
        }
        $detail = $this->peta_jabatan_model->get_struktur('V_STRUKTUR', $where);
        $data['data_first'] = $detail;
        switch ($detail['TKTESELON']) {
            default:
            case '1' : $next_esel = '2';
                break;
            case '2' : $next_esel = '3';
                break;
            case '3' : $next_esel = '4';
                break;
            case '4' : $next_esel = '5';
                break;
            case '5' : $next_esel = '6';
                break;
        }
        $data['data_master'] = $this->peta_jabatan_model->get_data_master($next_esel, $detail['TRLOKASI_ID'], $detail['KDU1'], $detail['KDU2'], $detail['KDU3'], $detail['KDU4'], $detail['KDU5']);
        $this->load->vars($data);
        $this->load->view('peta_jabatan/tpl_detail');
    }

    function view_back() {
        $where = array('ID' => $_POST['uid'], 'STATUS' => 1);
        $get_data = $this->peta_jabatan_model->get_struktur('V_STRUKTUR', $where);
        
        // get parent
        $get_data_tktteselon = $get_data['TKTESELON'] - 1;
        switch ($get_data_tktteselon) {
            //default:
            case '1' :
                $next_esel = '2';
                $where_parent = array('TKTESELON' => '1', 'TRLOKASI_ID' => $get_data['TRLOKASI_ID'], 'KDU1' => $get_data['KDU1'], 'STATUS' => 1);
                break;
            case '2' :
                $next_esel = '3';
                $where_parent = array('TKTESELON' => '2', 'TRLOKASI_ID' => $get_data['TRLOKASI_ID'], 'KDU1' => $get_data['KDU1'],'KDU2' => $get_data['KDU2'], 'STATUS' => 1);
                break;
            case '3' :
                $next_esel = '4';
                $where_parent = array('TKTESELON' => '3', 'TRLOKASI_ID' => $get_data['TRLOKASI_ID'], 'KDU1' => $get_data['KDU1'], 'KDU2' => $get_data['KDU2'], 'KDU3' => $get_data['KDU3'], 'STATUS' => 1);
                break;
            case '4' :
                $next_esel = '5';
                $where_parent = array('TKTESELON' => '4', 'TRLOKASI_ID' => $get_data['TRLOKASI_ID'], 'KDU1' => $get_data['KDU1'], 'KDU2' => $get_data['KDU2'], 'KDU3' => $get_data['KDU3'], 'KDU4' => $get_data['KDU4'], 'STATUS' => 1);
                break;
            case '5' :
                $next_esel = '6';
                $where_parent = array('TKTESELON' => '5', 'TRLOKASI_ID' => $get_data['TRLOKASI_ID'], 'KDU1' => $get_data['KDU1'], 'KDU2' => $get_data['KDU2'], 'KDU3' => $get_data['KDU3'], 'KDU4' => $get_data['KDU4'], 'KDU5' => $get_data['KDU5'], 'STATUS' => 1);
                break;
        }

        $detail_parent = $this->peta_jabatan_model->get_struktur('V_STRUKTUR', $where_parent);
        $data['data_first'] = $detail_parent;

        if ($get_data['TKTESELON'] == '2') {
//            $data['menteri'] = $this->config->item('instansi_panjang');
//            $data['menteri_desc'] = array("nama" => "M. Saugi", "foto" => "menteri.jpg");
            $data['data_master'] = $this->peta_jabatan_model->get_data_master($next_esel, $detail_parent['TRLOKASI_ID'], $detail_parent['KDU1'], $detail_parent['KDU2'], $detail_parent['KDU3'], $detail_parent['KDU4'], $detail_parent['KDU5'], 'Y');
            $this->load->vars($data);
            $this->load->view('peta_jabatan/tpl_master');
        } else {
            $data['data_master'] = $this->peta_jabatan_model->get_data_master($next_esel, $detail_parent['TRLOKASI_ID'], $detail_parent['KDU1'], $detail_parent['KDU2'], $detail_parent['KDU3'], $detail_parent['KDU4'], $detail_parent['KDU5']);
            $this->load->vars($data);
            $this->load->view('peta_jabatan/tpl_detail');
        }
    }

}
