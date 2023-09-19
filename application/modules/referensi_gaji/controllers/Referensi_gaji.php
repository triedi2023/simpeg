<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi_gaji extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('referensi_gaji/referensi_gaji_model','list_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(),['assets/plugins/bootbox/bootbox.min.js']);
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','referensi_gaji/js'];
        $this->data['title_utama'] = 'Gaji';
    }

    public function index() {
        $this->data['content'] = 'referensi_gaji/index';
        $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat();
        $this->load->view('layouts/main', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat();
            $this->load->view("referensi_gaji/form", $this->data);
        } else {
            redirect('/referensi_gaji');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('golongan_id', 'Golongan / Pangkat', 'required|min_length[3]|max_length[3]|trim');
        $this->form_validation->set_rules('mkg', 'MKG', 'required|min_length[1]|max_length[5]|trim');
        $this->form_validation->set_rules('gapok', 'Gaji Pokok', 'required|min_length[1]|max_length[10]|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "TRGOLONGAN_ID" => trim($this->input->post('golongan_id',TRUE)),
                "MKG" => trim($this->input->post('mkg',TRUE)),
                "GAPOK" => trim($this->input->post('gapok',TRUE)),
                "STATUS" => trim($this->input->post('status',TRUE))
            ];
            if ($this->referensi_gaji_model->insert($post)) {
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $this->data['model'] = $this->referensi_gaji_model->get_by_id($this->input->get('id'));
            $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat();
            $this->data['title_form'] = "Ubah";
            $this->load->view("referensi_gaji/form", $this->data);
        } else {
            redirect('/referensi_gaji');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('golongan_id', 'Golongan / Pangkat', 'required|min_length[3]|max_length[3]');
        $this->form_validation->set_rules('mkg', 'MKG', 'required|min_length[1]|max_length[5]');
        $this->form_validation->set_rules('gapok', 'Gaji Pokok', 'required|min_length[1]|max_length[10]');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "TRGOLONGAN_ID" => trim($this->input->post('golongan_id',TRUE)),
                "MKG" => trim($this->input->post('mkg',TRUE)),
                "GAPOK" => trim($this->input->post('gapok',TRUE)),
                "STATUS" => trim($this->input->post('status',TRUE))
            ];
            if ($this->referensi_gaji_model->update($post,$this->input->get('id'))) {
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success'=>'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        $list = $this->referensi_gaji_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->PANGKAT." (".$val->GOLONGAN.")";
            $row[] = $val->MKG;
            $row[] = number_format($val->GAPOK,"2");
            $row[] = ($val->STATUS == 1) ? '<span class="label label-sm label-success"> Aktif </span>' : '<span class="label label-sm label-default"> Inaktif </span>';
            $row[] = '<a href="javascript:;" data-url="'. site_url('referensi_gaji/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubah btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="'. site_url('referensi_gaji/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->referensi_gaji_model->count_all(),
            "recordsFiltered" => $this->referensi_gaji_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function unique_create() {
        $model = $this->referensi_gaji_model->get_unique_2column($this->input->post('tkthukdis_id'),$this->input->post('jenis_hukdis'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_create','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function unique_edit() {
        $model = $this->referensi_gaji_model->get_unique_2column_by_id($this->input->get('id'),$this->input->post('jenis_hukdis'),$this->input->post('tkthukdis_id'));
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
                if ($this->referensi_gaji_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

}
