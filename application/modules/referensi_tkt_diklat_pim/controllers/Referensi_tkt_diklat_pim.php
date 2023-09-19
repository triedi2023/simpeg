<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi_tkt_diklat_pim extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('referensi_tkt_diklat_pim/referensi_tkt_diklat_pim_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(['assets/plugins/bootbox/bootbox.min.js','assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js'], list_js_datatable());
        $this->data['title_utama'] = 'Tingkat Diklat PIM';
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','referensi_tkt_diklat_pim/js'];
    }

    public function index() {
        $this->data['content'] = 'referensi_tkt_diklat_pim/index';
        $this->load->view('layouts/main', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->load->view("referensi_tkt_diklat_pim/form", $this->data);
        } else {
            redirect('/referensi_tkt_diklat_pim');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_jenjang', 'Nama Jenjang', 'required|min_length[2]|max_length[100]|callback_unique_create');
        $this->form_validation->set_rules('level_pim', 'Level PIM', 'required|min_length[1]|max_length[1]');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "NAMA_JENJANG" => ltrim(rtrim($this->input->post('nama_jenjang',TRUE))),
                "LEVEL_PIM" => ltrim(rtrim($this->input->post('level_pim',TRUE))),
                "STATUS" => ltrim(rtrim($this->input->post('status',TRUE))),
                "ID_BKN" => ltrim(rtrim($this->input->post('id_bkn',TRUE))),
                "NAMA_BKN" => ltrim(rtrim($this->input->post('nama_bkn',TRUE)))
            ];
            if ($this->referensi_tkt_diklat_pim_model->insert($post)) {
                echo json_encode(['status' => 1, 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2]);
            }
        }
    }
    
    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $this->data['model'] = $this->referensi_tkt_diklat_pim_model->get_by_id($this->input->get('id'));
            $this->data['title_form'] = "Ubah";
            $this->load->view("referensi_tkt_diklat_pim/form", $this->data);
        } else {
            redirect('/referensi_tkt_diklat_pim');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_jenjang', 'Nama Jenjang', 'required|min_length[2]|max_length[100]|callback_unique_edit');
        $this->form_validation->set_rules('level_pim', 'Level PIM', 'required|min_length[1]|max_length[1]|callback_unique_edit');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "NAMA_JENJANG" => $this->input->post('nama_jenjang',TRUE),
                "LEVEL_PIM" => $this->input->post('level_pim',TRUE),
                "STATUS" => $this->input->post('status',TRUE),
                "ID_BKN" => ltrim(rtrim($this->input->post('id_bkn',TRUE))),
                "NAMA_BKN" => ltrim(rtrim($this->input->post('nama_bkn',TRUE)))
            ];
            if ($this->referensi_tkt_diklat_pim_model->update($post,$this->input->get('id'))) {
                echo json_encode(['status' => 1, 'success'=>'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2]);
            }
        }
    }

    public function ajax_list() {
        $list = $this->referensi_tkt_diklat_pim_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->NAMA_JENJANG;
            $row[] = $val->LEVEL_PIM;
            $row[] = $val->ID_BKN;
            $row[] = $val->NAMA_BKN;
            $row[] = ($val->STATUS == 1) ? '<span class="label label-sm label-success"> Aktif </span>' : '<span class="label label-sm label-default"> Inaktif </span>';
            $row[] = '<a href="javascript:;" data-url="'. site_url('referensi_tkt_diklat_pim/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubah btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="'. site_url('referensi_tkt_diklat_pim/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->referensi_tkt_diklat_pim_model->count_all(),
            "recordsFiltered" => $this->referensi_tkt_diklat_pim_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->referensi_tkt_diklat_pim_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

    public function unique_create() {
        $model = $this->referensi_tkt_diklat_pim_model->get_unique_jenjang_level($this->input->post('nama_jenjang'),$this->input->post('level_pim'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_create','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function unique_edit() {
        $model = $this->referensi_tkt_diklat_pim_model->get_unique_jenjang_level_by_id($this->input->get('id'),$this->input->post('nama_jenjang'),$this->input->post('level_pim'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}