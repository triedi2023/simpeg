<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_jabatan extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        }
        $this->load->model(array('daftar_pegawai_model'));
    }

    public function listpegawai() {
        $this->data['sex'] = $this->input->get('sex');
        $this->load->view("daftar_pegawai/listpegawai",$this->data);
    }
    
    public function ajax_listpegawai() {
        if (!$this->input->is_ajax_request()) {
            redirect('master_pegawai/');
        }
        $list = $this->daftar_pegawai_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN." ": "").($val->NAMA).((!empty($val->GELAR_BLKG)) ? " ".$val->GELAR_BLKG : '');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $nama;
            $row[] = $val->NIPNEW;
            $row[] = $val->NIPNEW;
            $row[] = '<a href="javascript:;" data-nama="'.$nama.'" data-tgllahir="'.$val->TGLLAHIR.'" data-nik="'.$val->NO_KTP.'" data-tptlahir="'.$val->TPTLAHIR.'" data-nip="'.$val->NIPNEW.'" class="popuppilihpegawai btn btn-circle btn-icon-only green-turquoise" title="Ubah Data"><i class="fa fa-check-square-o"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->daftar_pegawai_model->count_all(),
            "recordsFiltered" => $this->daftar_pegawai_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

}
