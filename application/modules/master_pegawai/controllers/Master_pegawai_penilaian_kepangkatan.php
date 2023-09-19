<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_penilaian_kepangkatan extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_penilaian_kepangkatan_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'Penilaian Kepangkatan Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $this->load->view('master_pegawai/penilaian_kepangkatan/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_jenis_data_kepangkatan'] = $this->list_model->list_jenis_data_kepangkatan();
            $this->data['id'] = $id;
            
            $this->load->view("master_pegawai/penilaian_kepangkatan/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_kepangkatan', 'Jenis Test', 'min_length[1]|max_length[2]|trim');
        $this->form_validation->set_rules('tempat_test', 'Tempat Test', 'min_length[1]|max_length[64]');
        $this->form_validation->set_rules('hasil_test', 'Hasil Test', 'min_length[1]|max_length[3]|trim');
        $this->form_validation->set_rules('nomor', 'Nomor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('pejabat', 'Pejabat', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('tgl_test', 'Tgl Test', 'required|min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            
            $post = [
                "TRJENISDATA_KEPANGKATAN_ID" => rtrim(ltrim($this->input->post('jenis_kepangkatan',TRUE))),
                "TEMPAT_TEST" => rtrim(ltrim($this->input->post('tempat_test',TRUE))),
                "HASIL_TEST" => rtrim(ltrim($this->input->post('hasil_test',TRUE))),
                "NO_SKKLSN" => rtrim(ltrim($this->input->post('nomor',TRUE))),
                "PEJABAT_SKKLSN" => rtrim(ltrim($this->input->post('pejabat',TRUE))),
                'TMPEGAWAI_ID' => $id
            ];
            $tanggal = [
                "TGL_TEST" => datepickertodb(trim($this->input->post('tgl_test',TRUE))),
                "TGL_SKKLSN" => datepickertodb(trim($this->input->post('tgl_sk',TRUE))),
            ];
            if ($insert = $this->master_pegawai_penilaian_kepangkatan_model->insert($post,$tanggal)) {
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
            $this->data['title_form'] = "Ubah";
            $this->data['model'] = $this->master_pegawai_penilaian_kepangkatan_model->get_by_id($this->input->get('id'));
            $this->data['list_jenis_data_kepangkatan'] = $this->list_model->list_jenis_data_kepangkatan();
            $this->data['id'] = $id;
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/penilaian_kepangkatan/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_kepangkatan', 'Jenis Test', 'min_length[1]|max_length[2]|trim');
        $this->form_validation->set_rules('tempat_test', 'Tempat Test', 'min_length[1]|max_length[64]');
        $this->form_validation->set_rules('hasil_test', 'Hasil Test', 'min_length[1]|max_length[3]|trim');
        $this->form_validation->set_rules('nomor', 'Nomor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('pejabat', 'Pejabat', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('tgl_test', 'Tgl Test', 'required|min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            if (!isset($_GET['kode']) || empty($_GET['kode'])) {
                redirect('/master_pegawai');
            }
            
            $post = [
                "TRJENISDATA_KEPANGKATAN_ID" => rtrim(ltrim($this->input->post('jenis_kepangkatan',TRUE))),
                "TEMPAT_TEST" => rtrim(ltrim($this->input->post('tempat_test',TRUE))),
                "HASIL_TEST" => rtrim(ltrim($this->input->post('hasil_test',TRUE))),
                "NO_SKKLSN" => rtrim(ltrim($this->input->post('nomor',TRUE))),
                "PEJABAT_SKKLSN" => rtrim(ltrim($this->input->post('pejabat',TRUE))),
            ];
            $tanggal = [
                "TGL_TEST" => datepickertodb(trim($this->input->post('tgl_test',TRUE))),
                "TGL_SKKLSN" => datepickertodb(trim($this->input->post('tgl_sk',TRUE))),
            ];
            
            if ($this->master_pegawai_penilaian_kepangkatan_model->update($post,$tanggal,$this->input->get('kode'))) {
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
        $list = $this->master_pegawai_penilaian_kepangkatan_model->get_datatables($id);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->JENIS_DATA_KEPANGKATAN;
            $row[] = $val->TGL_TEST;
            $row[] = $val->TEMPAT_TEST;
            $row[] = $val->PEJABAT_SKKLSN;
            $row[] = '<a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_penilaian_kepangkatan/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubahdetailpegawai btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a>&nbsp;<a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-icon-only red" data-url="'. site_url('master_pegawai/master_pegawai_penilaian_kepangkatan/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_penilaian_kepangkatan_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_penilaian_kepangkatan_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->master_pegawai_penilaian_kepangkatan_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_penilaian_kepangkatan_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
