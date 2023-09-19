<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Survey_hasil extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('survey_hasil/survey_hasil_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(), ['assets/plugins/amcharts/amcharts.js?v=' . uniqid(), 'assets/plugins/amcharts/serial.js?=v' . uniqid()]);
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','survey_hasil/js'];
        $this->data['title_utama'] = 'Hasil';
    }

    public function index() {
        $this->data['content'] = 'survey_hasil/index';
        $this->load->view('layouts/main', $this->data);
    }
    
    public function view() {
        $id = $this->input->get('id');
        $this->data['content'] = 'survey_hasil/view';
        $this->data['hasil_pilihan'] = $this->survey_hasil_model->get_hasil_pilihan($id);
        $this->data['hasil_isian'] = $this->survey_hasil_model->get_hasil_isian($id);
        $this->load->view('layouts/main', $this->data);
    }

    public function ajax_list() {
        $list = $this->survey_hasil_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->JUDUL;
            $row[] = $val->KETERANGAN;
            $row[] = $val->START_DATE;
            $row[] = $val->END_DATE;
            $row[] = '<a href="'. site_url('survey_hasil/view?id='.$val->ID).'" class="btn btn-icon-only bg-blue bg-font-blue" title="Lihat Hasil Survei"><i class="fa fa-eye"></i></a><a href="'. site_url('survey_pengisi/index?id='.$val->ID).'" class="btn btn-icon-only bg-yellow bg-font-yellow-lemon" title="Daftar Pegawai Pengisi Survei"><i class="fa fa-table"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->survey_hasil_model->count_all(),
            "recordsFiltered" => $this->survey_hasil_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

}
