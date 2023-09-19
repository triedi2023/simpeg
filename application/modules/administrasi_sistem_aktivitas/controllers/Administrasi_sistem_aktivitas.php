<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrasi_sistem_aktivitas extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('administrasi_sistem_aktivitas/administrasi_sistem_aktivitas_model','administrasi_sistem_users/administrasi_sistem_users_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(['assets/plugins/bootbox/bootbox.min.js','assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js'], list_js_datatable());
        $this->data['title_utama'] = 'Aktivitas Pengguna';
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','administrasi_sistem_aktivitas/js'];
    }

    public function index() {
        $this->data['content'] = 'administrasi_sistem_aktivitas/index';
        $this->data['list_group'] = $this->administrasi_sistem_users_model->list_group();
        $this->load->view('layouts/main', $this->data);
    }

    public function ajax_list() {
        $list = $this->administrasi_sistem_aktivitas_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->USERNAME;
            $row[] = $val->NIP;
            $row[] = $val->NAMA_PEGAWAI;
            $row[] = $val->CREATED_DATE;
            $row[] = $val->AKSI;
            $row[] = $val->NAMA_GROUP;
            $row[] = $val->DESKRIPSI;

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->administrasi_sistem_aktivitas_model->count_all(),
            "recordsFiltered" => $this->administrasi_sistem_aktivitas_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

}
?>