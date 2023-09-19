<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi_tanda_jasa extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('referensi_tanda_jasa/referensi_tanda_jasa_model','list_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(['assets/plugins/bootbox/bootbox.min.js','assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js'], list_js_datatable());
        $this->data['title_utama'] = 'Penghargaan / Tanda Jasa';
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','referensi_tanda_jasa/js'];
    }

    public function index() {
        $this->data['content'] = 'referensi_tanda_jasa/index';
        $this->data['list_jenis_tanda_jasa'] = $this->list_model->list_jenis_tanda_jasa();
        $this->load->view('layouts/main', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->data['list_jenis_tanda_jasa'] = $this->list_model->list_jenis_tanda_jasa();
            $this->load->view("referensi_tanda_jasa/form", $this->data);
        } else {
            redirect('/referensi_tanda_jasa');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tanda_jasa', 'Penghargaan / Tanda Jasa', 'required|min_length[2]|max_length[255]|callback_unique_create');
        $this->form_validation->set_rules('penerbit', 'Penerbit', 'required|min_length[2]|max_length[255]');
        $this->form_validation->set_rules('jenis_tanda_jasa', 'Jenis Tanda Jasa', 'required|trim|min_length[1]|max_length[2]|integer');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "TANDA_JASA" => ltrim(rtrim($this->input->post('tanda_jasa',TRUE))),
                "TRJENISTANDAJASA_ID" => $this->input->post('jenis_tanda_jasa',TRUE),
                "PENERBIT" => ltrim(rtrim($this->input->post('penerbit',TRUE))),
                "STATUS" => $this->input->post('status',TRUE),
                'ID_BKN' => ltrim(rtrim($this->input->post('idbkn',TRUE))),
                'NAMA_BKN' => ltrim(rtrim($this->input->post('namabkn',TRUE))),
            ];
            if ($this->referensi_tanda_jasa_model->insert($post)) {
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $this->data['model'] = $this->referensi_tanda_jasa_model->get_by_id($this->input->get('id'));
            $this->data['list_jenis_tanda_jasa'] = $this->list_model->list_jenis_tanda_jasa();
            $this->data['title_form'] = "Ubah";
            $this->load->view("referensi_tanda_jasa/form", $this->data);
        } else {
            redirect('/referensi_tanda_jasa');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tanda_jasa', 'Penghargaan / Tanda Jasa', 'required|min_length[2]|max_length[255]|callback_unique_edit');
        $this->form_validation->set_rules('penerbit', 'Penerbit', 'required|min_length[2]|max_length[255]');
        $this->form_validation->set_rules('jenis_tanda_jasa', 'Jenis Tanda Jasa', 'required|trim|min_length[1]|max_length[2]|integer');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "TANDA_JASA" => ltrim(rtrim($this->input->post('tanda_jasa',TRUE))),
                "TRJENISTANDAJASA_ID" => $this->input->post('jenis_tanda_jasa',TRUE),
                "PENERBIT" => ltrim(rtrim($this->input->post('penerbit',TRUE))),
                "STATUS" => $this->input->post('status',TRUE),
                'ID_BKN' => ltrim(rtrim($this->input->post('idbkn',TRUE))),
                'NAMA_BKN' => ltrim(rtrim($this->input->post('namabkn',TRUE))),
            ];
            if ($this->referensi_tanda_jasa_model->update($post,$this->input->get('id'))) {
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success'=>'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        $list = $this->referensi_tanda_jasa_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->JENIS_TANDA_JASA;
            $row[] = $val->TANDA_JASA;
            $row[] = $val->PENERBIT;
            $row[] = $val->ID_BKN;
            $row[] = $val->NAMA_BKN;
            $row[] = ($val->STATUS == 1) ? '<span class="label label-sm label-success"> Aktif </span>' : '<span class="label label-sm label-default"> Inaktif </span>';
            $row[] = '<a href="javascript:;" data-url="'. site_url('referensi_tanda_jasa/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubah btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="'. site_url('referensi_tanda_jasa/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->referensi_tanda_jasa_model->count_all(),
            "recordsFiltered" => $this->referensi_tanda_jasa_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->referensi_tanda_jasa_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_create() {
        $model = $this->referensi_tanda_jasa_model->get_unique_3column($this->input->post('jenis_tanda_jasa'),$this->input->post('tanda_jasa'),$this->input->post('penerbit'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_create','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function unique_edit() {
        $model = $this->referensi_tanda_jasa_model->get_unique_2column_by_id($this->input->get('id'),$this->input->post('tkt_fungsional'),$this->input->post('jenjang_fungsional'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
