<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pensiun extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        }
        $this->load->model(array('daftar_pensiun_model'));
    }

    public function listpensiun() {
        $this->data['bulan'] = isset($_POST['bulan']) ? $this->input->post('bulan') : '';
        $this->data['trlokasi_id'] = (isset($_POST['lokasi_id']) && $_POST['lokasi_id'] != "" && $_POST['lokasi_id'] != '-1') ? $this->input->post('lokasi_id', TRUE) : 2;
        $this->data['kdu1'] = (isset($_POST['kdu1_id']) && $_POST['kdu1_id'] != "" && $_POST['kdu1_id'] != '-1') ? $this->input->post('kdu1_id', TRUE) : "";
        $this->data['kdu2'] = (isset($_POST['kdu2_id']) && $_POST['kdu2_id'] != "" && $_POST['kdu2_id'] != '-1') ? $this->input->post('kdu2_id', TRUE) : "";
        $this->data['kdu3'] = (isset($_POST['kdu3_id']) && $_POST['kdu3_id'] != "" && $_POST['kdu3_id'] != '-1') ? $this->input->post('kdu3_id', TRUE) : "";
        $this->data['kdu4'] = (isset($_POST['kdu4_id']) && $_POST['kdu4_id'] != "" && $_POST['kdu4_id'] != '-1') ? $this->input->post('kdu4_id', TRUE) : "";
        $this->data['kdu5'] = (isset($_POST['kdu5_id']) && $_POST['kdu5_id'] != "" && $_POST['kdu5_id'] != '-1') ? $this->input->post('kdu5_id', TRUE) : "";
        
        $this->load->view("daftar_pensiun/listpegawai",$this->data);
    }
    
    public function ajax_listpensiun() {
        if (!$this->input->is_ajax_request()) {
            redirect('beranda/');
        }
        $list = $this->daftar_pensiun_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        $class = $this->input->post('setelementnya');
        foreach ($list as $val) {
            $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN." ": "").($val->NAMA).((!empty($val->GELAR_BLKG)) ? ", ".$val->GELAR_BLKG : '');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<img style="width: 100%; height: 40%" src="'.base_url().'_uploads/photo_pegawai/thumbs/'.$val->FOTO.'" class="img-responsive" alt="">';
            $row[] = "NIP : ".$val->NIPNEW."<br />Nama : ".$nama."<br />Tanggal Lahir : ".$val->TGLLAHIR.", Umur : ".$val->UMUR."<br />Pangkat / Golongan : ".
            ($val->TRSTATUSKEPEGAWAIAN_ID == 1 ? $val->PANGKAT." (".$val->GOLONGAN_RUANG.") " : $val->PANGKAT)."<br />TMT Pensiun : ".$val->TMT_PENSIUN_CHAR."<br />TMT Jabatan : ".$val->TMT_JABATAN."<br />Jabatan : ".$val->N_JABATAN;

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->daftar_pensiun_model->count_all(),
            "recordsFiltered" => $this->daftar_pensiun_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

}
