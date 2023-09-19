<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi_jabatan_abk extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('referensi_jabatan_abk/referensi_jabatan_abk_model', 'list_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(), ['assets/plugins/bootbox/bootbox.min.js', 'assets/plugins/select2/js/select2.full.min.js']);
        $this->data['custom_js'] = ['layouts/widget/main/js_crud', 'referensi_jabatan_abk/js'];
        $this->data['title_utama'] = 'Jabatan ABK';
    }

    public function index() {
        $this->data['content'] = 'referensi_jabatan_abk/index';
        $this->load->view('layouts/main', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->data['list_jabatan'] = $this->list_model->list_jabatan();
            $this->load->view("referensi_jabatan_abk/form", $this->data);
        } else {
            redirect('/referensi_jabatan_abk');
        }
    }

    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jabatan[]', 'Jabatan', 'required|trim');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            if (count($this->input->post('jabatan', TRUE)) > 0) {
                for ($i = 0; $i < count($this->input->post('jabatan', TRUE)); $i++) {
                    $post = [
                        "TRJABATAN_ID" => $this->input->post('jabatan', TRUE)[$i]
                    ];
                    if ($this->referensi_jabatan_abk_model->get_unique_create($this->input->post('jabatan', TRUE)[$i]) < 1) {
                        $this->referensi_jabatan_abk_model->insert($post);
                    }
                }
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        $list = $this->referensi_jabatan_abk_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->JABATAN;
            $row[] = '<a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="' . site_url('referensi_jabatan_abk/hapus_data') . '" data-id="' . $val->TRJABATAN_ID . '" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->referensi_jabatan_abk_model->count_all(),
            "recordsFiltered" => $this->referensi_jabatan_abk_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function unique_create() {
        $model = $this->referensi_jabatan_abk_model->get_unique_create($this->input->post('tipe_pangkat', true), $this->input->post('golongan', true), $this->input->post('pangkat', true));
        if ($model > 0) {
            $this->form_validation->set_message('unique_create', 'Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->referensi_jabatan_abk_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success' => 'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

}
