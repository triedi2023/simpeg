<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pegawai_bsg extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('daftar_pegawai_bsg/daftar_pegawai_bsg_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(['assets/plugins/bootbox/bootbox.min.js'], list_js_datatable());
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','daftar_pegawai_bsg/js'];
        $this->data['title_utama'] = 'BSG';
    }

    public function index() {
        $this->data['content'] = 'daftar_pegawai_bsg/index';
        $this->load->view('layouts/main', $this->data);
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nip', 'NIP', 'required|max_length[18]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "nip" => ltrim(rtrim($this->input->post('nip',TRUE)))
            ];
            if ($this->daftar_pegawai_bsg_model->insert($post)) {
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        $list = $this->daftar_pegawai_bsg_model->get_datatables();
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
            $row[] = '<a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-identify="pegawaibsg" data-url="'.site_url('daftar_pegawai_bsg/hapus_data').'" data-id="'.$val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->daftar_pegawai_bsg_model->count_all(),
            "recordsFiltered" => $this->daftar_pegawai_bsg_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->daftar_pegawai_bsg_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
}
