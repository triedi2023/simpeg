<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

class Statistik_jk extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('statistik_jk/statistik_jk_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = ['assets/plugins/select2/js/select2.full.min.js'];
        $this->data['custom_js'] = ['statistik_jk/js'];
        $this->data['title_utama'] = 'Statistik Berdasarkan Jenis Kelamin';
    }
    
    public function insertjabatan() {
        exit;
        $this->statistik_jk_model->insertjabatan();
    }

    public function index() {
        $this->data['content'] = 'statistik_jk/index';
        $this->load->view('layouts/main', $this->data);
    }

    public function pencarian_proses() {
        $this->data['data_komposisi'] = $this->statistik_jk_model->get_data();
        $this->load->view("statistik_jk/_hasil", $this->data);
    }

    public function export_pdf() {
        $this->data['data_komposisi'] = $this->statistik_jk_model->get_data();
        $this->data['content'] = 'statistik_jk/pdf';
        
        $this->load->library('M_pdf');
        $this->m_pdf->set_paper('a4', 'landscape');
        $this->m_pdf->load_view("layouts/print", $this->data);
        $this->m_pdf->render();
        $this->m_pdf->stream($this->data['title_utama'] . " " . 'Periode ' . month_indo(date('m')) . " " . date("Y"));
    }

}
