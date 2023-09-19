<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_jurusan extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        }
        $this->load->model(array('daftar_jurusan_model'));
    }

    public function listjurusan() {
        $this->data['sex'] = $this->input->get('sex');
        $this->load->view("daftar_jurusan/listjurusan",$this->data);
    }
    
    public function ajax_listjurusan() {
        if (!$this->input->is_ajax_request()) {
            redirect('master_pegawai/');
        }
        $list = $this->daftar_jurusan_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->NAMA_JURUSAN;
            $row[] = '<a href="javascript:;" data-nama="'.$val->NAMA_JURUSAN.'" data-id="'.$val->ID.'" class="popuppilihjurusan btn btn-circle btn-icon-only green-turquoise" title="Ubah Data"><i class="fa fa-check-square-o"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->daftar_jurusan_model->count_all(),
            "recordsFiltered" => $this->daftar_jurusan_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

}
