<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi_hari_larangan_cuti extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('referensi_hari_larangan_cuti/referensi_hari_larangan_cuti_model','list_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(),['assets/plugins/bootbox/bootbox.min.js','assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js','assets/plugins/select2/js/select2.full.min.js','assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js']);
        $this->data['plugin_css'] = ['assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'];
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','referensi_hari_larangan_cuti/js'];
        $this->data['title_utama'] = 'Hari Larangan Cuti';
    }

    public function index() {
        $this->data['content'] = 'referensi_hari_larangan_cuti/index';
        $this->load->view('layouts/main', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->load->view("referensi_hari_larangan_cuti/form", $this->data);
        } else {
            redirect('/referensi_hari_larangan_cuti');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required|min_length[1]|max_length[2000]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE)))
            ];
            $tanggal = [
                "PERIODE_LARANGAN_CUTI" => datepickertodb(trim($this->input->post('tanggal',TRUE))),
            ];
            if ($this->referensi_hari_larangan_cuti_model->insert($post,$tanggal)) {
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $this->data['model'] = $this->referensi_hari_larangan_cuti_model->get_by_id($this->input->get('id'));
            $this->data['title_form'] = "Ubah";
            $this->load->view("referensi_hari_larangan_cuti/form", $this->data);
        } else {
            redirect('/referensi_hari_larangan_cuti');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required|min_length[1]|max_length[2000]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE)))
            ];
            $tanggal = [
                "TGL_LIBUR" => datepickertodb(trim($this->input->post('tanggal',TRUE))),
            ];
            if ($this->referensi_hari_larangan_cuti_model->update($post,$tanggal,$this->input->get('id'))) {
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success'=>'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        $list = $this->referensi_hari_larangan_cuti_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->PERIODE_LARANGAN_CUTI2;
            $row[] = $val->KETERANGAN;
            $row[] = '<a href="javascript:;" data-url="'. site_url('referensi_hari_larangan_cuti/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubah btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="'. site_url('referensi_hari_larangan_cuti/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->referensi_hari_larangan_cuti_model->count_all(),
            "recordsFiltered" => $this->referensi_hari_larangan_cuti_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->referensi_hari_larangan_cuti_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

}
