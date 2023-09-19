<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi_status_fungsional extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('referensi_status_fungsional/referensi_status_fungsional_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(),['assets/plugins/bootbox/bootbox.min.js']);
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','referensi_status_fungsional/js'];
        $this->data['title_utama'] = 'Status Fungsional';
    }

    public function index() {
        $this->data['content'] = 'referensi_status_fungsional/index';
        $this->load->view('layouts/main', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->load->view("referensi_status_fungsional/form", $this->data);
        } else {
            redirect('/referensi_status_fungsional');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('status_fungsional', 'Status Fungsional', 'required|min_length[2]|max_length[100]|callback_unique_create');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "STATUS_FUNGSIONAL" => ltrim(rtrim($this->input->post('status_fungsional',TRUE))),
                "STATUS" => ltrim(rtrim($this->input->post('status',TRUE)))
            ];
            if ($this->referensi_status_fungsional_model->insert($post)) {
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $this->data['model'] = $this->referensi_status_fungsional_model->get_by_id($this->input->get('id'));
            $this->data['title_form'] = "Ubah";
            $this->load->view("referensi_status_fungsional/form", $this->data);
        } else {
            redirect('/referensi_status_fungsional');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('status_fungsional', 'Status Fungsional', 'required|min_length[2]|max_length[100]|callback_unique_edit');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "STATUS_FUNGSIONAL" => ltrim(rtrim($this->input->post('status_fungsional',TRUE))),
                "STATUS" => ltrim(rtrim($this->input->post('status',TRUE)))
            ];
            if ($this->referensi_status_fungsional_model->update($post,$this->input->get('id'))) {
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success'=>'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        $list = $this->referensi_status_fungsional_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->STATUS_FUNGSIONAL;
            $row[] = ($val->STATUS == 1) ? '<span class="label label-sm label-success"> Aktif </span>' : '<span class="label label-sm label-default"> Inaktif </span>';
            $row[] = '<a href="javascript:;" data-url="'. site_url('referensi_status_fungsional/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubah btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="'. site_url('referensi_status_fungsional/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->referensi_status_fungsional_model->count_all(),
            "recordsFiltered" => $this->referensi_status_fungsional_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function unique_create() {
        $model = $this->referensi_status_fungsional_model->get_unique_1column($this->input->post('status_fungsional'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_create','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function unique_edit() {
        $model = $this->referensi_status_fungsional_model->get_unique_1column_by_id($this->input->get('id'),$this->input->post('status_fungsional'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->referensi_status_fungsional_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

}
