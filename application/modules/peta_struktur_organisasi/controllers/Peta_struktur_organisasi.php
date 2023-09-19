<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";
require_once APPPATH . "third_party/fpdf/fpdf.php";

class Peta_struktur_organisasi extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('peta_struktur_organisasi/peta_struktur_organisasi_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = ['assets/plugins/select2/js/select2.full.min.js'];
        $this->data['custom_js'] = ['peta_struktur_organisasi/js'];
        $this->data['title_utama'] = 'Peta Struktur Organisasi';
    }

    public function index() {
        $this->data['content'] = 'peta_struktur_organisasi/index';
        $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        $this->load->view('layouts/main', $this->data);
    }

    public function pencarian_proses() {
        $lokasi_id = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? trim($this->input->post('trlokasi_id', TRUE)) : '2';
        $kdu1 = (isset($_POST['kdu1_id']) && !empty($_POST['kdu1_id']) && $_POST['kdu1_id'] != -1) ? trim($this->input->post('kdu1_id', TRUE)) : '00';
        $kdu2 = (isset($_POST['kdu2_id']) && !empty($_POST['kdu2_id']) && $_POST['kdu2_id'] != -1) ? trim($this->input->post('kdu2_id', TRUE)) : '00';
        $kdu3 = (isset($_POST['kdu3_id']) && !empty($_POST['kdu3_id']) && $_POST['kdu3_id'] != -1) ? trim($this->input->post('kdu3_id', TRUE)) : '000';
        $kdu4 = (isset($_POST['kdu4_id']) && !empty($_POST['kdu4_id']) && $_POST['kdu4_id'] != -1) ? trim($this->input->post('kdu4_id', TRUE)) : '000';
        $kdu5 = (isset($_POST['kdu5_id']) && !empty($_POST['kdu5_id']) && $_POST['kdu5_id'] != -1) ? trim($this->input->post('kdu5_id', TRUE)) : '00';
        $tingkat_golongan = (isset($_POST['tingkat_golongan']) && !empty($_POST['tingkat_golongan'])) ? trim($this->input->post('tingkat_golongan', TRUE)) : '';

        $this->data['model'] = $this->peta_struktur_organisasi_model->get_data($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5, $tingkat_golongan);
        $this->data['struktur'] = $this->peta_struktur_organisasi_model->get_struktur($lokasi_id, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);

        $this->load->view("peta_struktur_organisasi/_hasil", $this->data);
    }

}
