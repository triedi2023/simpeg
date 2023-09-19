<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_user extends CI_Controller {

    private $data;
    
    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        }
        $this->load->model(array('daftar_user_model'));
    }

    public function listuser() {
        $this->load->view("daftar_user/listuser",$this->data);
    }
    
    public function ajax_listuser() {
        if (!$this->input->is_ajax_request()) {
            redirect('/beranda');
        }
        $list = $this->daftar_user_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->USERID;
            $row[] = '<a href="javascript:;" data-userid="'.$val->USERID.'" class="btn btn-circle btn-icon-only green-turquoise popuppilihuserid" title="Pilih Data"><i class="fa fa-check-square-o"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->daftar_user_model->count_all(),
            "recordsFiltered" => $this->daftar_user_model->count_filtered(),
            "data" => $data
        );

        //output to json format
        echo json_encode($output);
    }

}
