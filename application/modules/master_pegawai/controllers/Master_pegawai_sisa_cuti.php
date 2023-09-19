<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_sisa_cuti extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_sisa_cuti_model', 'list_model', 'master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['title_utama'] = 'Sisa Cuti';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'),"NIPNEW");
        $this->load->view('master_pegawai/sisa_cuti/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }

            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_cuti'] = $this->list_model->list_cuti();
            $this->data['id'] = $id;

            $this->load->view("master_pegawai/sisa_cuti/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cuti_id', 'Cuti', 'required|min_length[2]|max_length[2]|trim');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|min_length[4]|max_length[4]|trim');
        $this->form_validation->set_rules('sisa_cuti', 'Sisa Cuti', 'min_length[1]|max_length[3]|trim');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');

            $post = [
                "TMCUTI_ID" => trim($this->input->post('cuti_id', TRUE)),
                'TMPEGAWAI_ID' => $id,
                "TAHUN" => ltrim(rtrim($this->input->post('tahun', TRUE))),
                "SISA_CUTI" => ltrim(rtrim($this->input->post('sisa_cuti', TRUE))),
            ];
            
            if ($insert = $this->master_pegawai_sisa_cuti_model->insert($post)) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "NIP,NIPNEW");        
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success' => 'Record added successfully.', 'data' => (isset($jabatan_mutakhir) && !empty($jabatan_mutakhir['N_JABATAN'])) ? $jabatan_mutakhir['N_JABATAN'] : '-']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-tambahkan']);
            }
        }
    }

    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }

            $id = $this->input->get('id');
            $kode = $this->input->get('kode');
            $this->data['title_form'] = "Ubah";
            $this->data['model'] = $this->master_pegawai_sisa_cuti_model->get_by_id($this->input->get('id'));
            $this->data['list_cuti'] = $this->list_model->list_cuti();
            $this->data['id'] = $id;

            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/sisa_cuti/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cuti_id', 'Cuti', 'required|min_length[2]|max_length[2]|trim');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|min_length[4]|max_length[4]|trim');
        $this->form_validation->set_rules('sisa_cuti', 'Sisa Cuti', 'min_length[1]|max_length[3]|trim');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            if (!isset($_GET['kode']) || empty($_GET['kode'])) {
                redirect('/master_pegawai');
            }

            $post = [
                "TMCUTI_ID" => trim($this->input->post('cuti_id', TRUE)),
                "TAHUN" => ltrim(rtrim($this->input->post('tahun', TRUE))),
                "SISA_CUTI" => ltrim(rtrim($this->input->post('sisa_cuti', TRUE))),
            ];
            
            if ($this->master_pegawai_sisa_cuti_model->update($post, $this->input->get('kode'))) {
                $insert_id = $this->input->get('kode');
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'), "NIP,NIPNEW");               
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success' => 'Record updated successfully.', 'data' => (isset($jabatan_mutakhir) && !empty($jabatan_mutakhir['N_JABATAN'])) ? $jabatan_mutakhir['N_JABATAN'] : '-']);
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
        $list = $this->master_pegawai_sisa_cuti_model->get_datatables($id);
        $data = array();
        $delete = '';
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
//            $file = '';
//            if (!empty($val->DOC_SKKGB) && $val->DOC_SKKGB != "") {
//                $file = '<a href="javascript:;" class="btn btn-xs green-haze popupfull" data-url="'. site_url('master_pegawai/master_pegawai_gaji/view_dokumen?id='.$val->ID).'" title="Lihat Dokumen"><i class="fa fa-file-pdf-o"></i></a>';
//            }
            if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') {
                $delete = '<a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="' . site_url('master_pegawai/master_pegawai_gaji/hapus_data') . '" data-id="' . $val->ID . '" data-identify="updatejabatanpegawai" title="Hapus Data"><i class="fa fa-trash"></i></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->NAMA;
            $row[] = $val->TAHUN;
            $row[] = $val->SISA_CUTI;
            $row[] = '<a href="javascript:;" data-url="' . site_url('master_pegawai/master_pegawai_sisa_cuti/ubah_form?id=' . $val->ID) . '" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="'.($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data').'"><i class="fa fa-edit"></i></a>'.$delete.'<a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_sisa_cuti/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_sisa_cuti_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_sisa_cuti_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_sisa_cuti_model->get_by_id($this->input->post('id'));
                if ($this->master_pegawai_sisa_cuti_model->hapus($this->input->post('id'))) {
                    $nippegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIPNEW");
                    echo json_encode(['status' => 1, 'success' => 'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

    public function unique_edit() {
        $model = $this->master_pegawai_sisa_cuti_model->get_unique_nama_by_id($this->input->get('id'), $this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit', 'Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_dokumen() {
        $model = $this->master_pegawai_sisa_cuti_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath')."doc_pegawai/".$model['NIP']."/".$model['DOC_SKKGB'])) {
                $this->data['file'] = base_url()."_uploads/doc_pegawai/".$model['NIP']."/".$model['DOC_SKKGB'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_sisa_cuti_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/sisa_cuti/info', $this->data);
    }

}
