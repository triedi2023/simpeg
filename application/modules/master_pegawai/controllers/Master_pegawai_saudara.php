<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_saudara extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_saudara_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'Saudara Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->data['id'],"NIPNEW");
        $this->load->view('master_pegawai/saudara/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_jk'] = $this->config->item('list_jk');
            $this->data['id'] = $id;
            
            $this->load->view("master_pegawai/saudara/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required|min_length[1]|max_length[1]|alpha|trim');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|max_length[64]');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'max_length[100]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[1]|max_length[100]');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            
            $post = [
                "SEX" => trim($this->input->post('jk',TRUE)),
                "NAMA" => ltrim(rtrim($this->input->post('nama_lengkap',TRUE))),
                "PEKERJAAN" => ltrim(rtrim($this->input->post('pekerjaan',TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                'TMPEGAWAI_ID' => $id,
            ];
            $tanggal = [
                "TGL_LAHIR" => datepickertodb(trim($this->input->post('tanggal_lahir',TRUE))),
            ];
            if ($insert = $this->master_pegawai_saudara_model->insert($post,$tanggal)) {
                $nippegawai = $this->master_pegawai_model->get_by_id_select($id,"NIPNEW");
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['model'] = $this->master_pegawai_saudara_model->get_by_id($id);
            $data_pegawai = $this->master_pegawai_model->get_by_id_select($this->data['model']['TMPEGAWAI_ID'],"SEX");
            $this->data['title_form'] = "Ubah";
            $this->data['list_jk'] = $this->config->item('list_jk');
            $this->data['id'] = $id;
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/saudara/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required|min_length[1]|max_length[1]|alpha|trim');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|max_length[64]');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'max_length[100]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[1]|max_length[100]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $post = [
                "SEX" => trim($this->input->post('jk',TRUE)),
                "NAMA" => ltrim(rtrim($this->input->post('nama_lengkap',TRUE))),
                "PEKERJAAN" => ltrim(rtrim($this->input->post('pekerjaan',TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
            ];
            $tanggal = [
                "TGL_LAHIR" => datepickertodb(trim($this->input->post('tanggal_lahir',TRUE))),
            ];
            $model = $this->master_pegawai_saudara_model->get_by_id($this->input->get('id'));
            
            if ($this->master_pegawai_saudara_model->update($post,$tanggal,$this->input->get('id'))) {
                $nippegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIPNEW");
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success'=>'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        if (empty($_GET['id'])) {
            redirect('/master_pegawai');
        }
        $id = $this->input->get('id');
        $list = $this->master_pegawai_saudara_model->get_datatables($id);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->NAMA;
            $row[] = ($val->SEX == "L") ? 'Laki-laki' : 'Perempuan';
            $row[] = $val->TGL_LAHIR;
            $row[] = $val->PEKERJAAN;
            $row[] = '<a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_saudara/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="'. site_url('master_pegawai/master_pegawai_saudara/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a><a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_saudara/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_saudara_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_saudara_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_saudara_model->get_by_id($this->input->post('id'));
                if ($this->master_pegawai_saudara_model->hapus($this->input->post('id'))) {
                    $nippegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIPNEW");
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_saudara_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_saudara_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/saudara/info', $this->data);
    }

}
