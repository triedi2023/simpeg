<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_cuti extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('daftar_cuti/daftar_cuti_model','list_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(),['assets/plugins/bootbox/bootbox.min.js','assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js','assets/plugins/select2/js/select2.full.min.js','assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js']);
        $this->data['plugin_css'] = ['assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'];
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','daftar_cuti/js'];
        $this->data['title_utama'] = 'Daftar Cuti';
    }

    public function index() {
        $this->data['content'] = 'daftar_cuti/index';
        $this->data['list_jenis_cuti'] = $this->list_model->list_cuti();
        $this->load->view('layouts/main', $this->data);
    }
    
    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $this->data['model'] = $this->daftar_cuti_model->get_by_id($this->input->get('id'));
            $this->data['list_jenis_libur'] = $this->list_model->list_jenis_libur();
            $this->data['title_form'] = "Ubah";
            $this->load->view("daftar_cuti/form", $this->data);
        } else {
            redirect('/daftar_cuti');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_libur', 'Jenis Libur', 'required|min_length[1]|max_length[2]');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "TRJENISLIBUR_ID" => trim($this->input->post('jenis_libur',TRUE)),
                "STATUS" => ltrim(rtrim($this->input->post('status',TRUE)))
            ];
            $tanggal = [
                "TGL_LIBUR" => datepickertodb(trim($this->input->post('tanggal',TRUE))),
            ];
            if ($this->daftar_cuti_model->update($post,$tanggal,$this->input->get('id'))) {
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success'=>'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        $list = $this->daftar_cuti_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN . " " : "") . ($val->NAMA) . ((!empty($val->GELAR_BLKG)) ? ", " . $val->GELAR_BLKG : '');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->TGL_PENGAJUAN2;
            $row[] = $val->NAMA_CUTI;
            $row[] = $val->NIPNEW;
            $row[] = $nama;

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->daftar_cuti_model->count_all(),
            "recordsFiltered" => $this->daftar_cuti_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->daftar_cuti_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

}
