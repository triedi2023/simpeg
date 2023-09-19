<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Survey_pengisi extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('survey_pengisi/survey_pengisi_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(), ['assets/plugins/amcharts/amcharts.js?v=' . uniqid(), 'assets/plugins/amcharts/serial.js?=v' . uniqid()]);
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','survey_pengisi/js'];
        $this->data['title_utama'] = 'Hasil';
    }

    public function index() {
        $this->data['content'] = 'survey_pengisi/index';
        $this->data['id'] = (int) $this->input->get('id');
        $this->load->view('layouts/main', $this->data);
    }

    public function ajax_list() {
        $list = $this->survey_pengisi_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN . " " : "") . ($val->NAMA) . ((!empty($val->GELAR_BLKG)) ? ", " . $val->GELAR_BLKG : '');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $nama;
            $row[] = $val->NIPNEW;
            $row[] = ($val->TRSTATUSKEPEGAWAIAN_ID == 1) ? $val->PANGKAT . " (" . $val->GOLONGAN . ")" : $val->PANGKAT;
            $row[] = $val->TMT_GOL;
            $row[] = $val->N_JABATAN;
            $row[] = $val->TMT_JABATAN;
            $row[] = $val->CREATED_DATE;

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->survey_pengisi_model->count_all(),
            "recordsFiltered" => $this->survey_pengisi_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

}
