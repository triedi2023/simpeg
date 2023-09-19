<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_kunjungan_ln extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_kunjungan_ln_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'Kunjungan Luar Negeri Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'),"NIPNEW");
        $this->load->view('master_pegawai/kunjungan_ln/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_negara'] = $this->list_model->list_negara();
            $this->data['list_pembiayaan'] = $this->list_model->list_pembiayaan();
            $this->data['id'] = $id;
            
            $this->load->view("master_pegawai/kunjungan_ln/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('negara', 'Negara', 'required|min_length[1]|max_length[3]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('tujuan', 'Tujuan', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('pembiayaan', 'Pembiayaan', 'min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('sponsor', 'Sponsor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('hari', 'Hari', 'min_length[1]|max_length[3]|trim|is_natural');
        $this->form_validation->set_rules('bulan', 'Bulan', 'min_length[1]|max_length[3]|trim|is_natural');
        $this->form_validation->set_rules('tahun', 'Tahun', 'min_length[1]|max_length[3]|trim|is_natural');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            
            $post = [
                'TMPEGAWAI_ID' => $id,
                "TRNEGARA_ID" => trim($this->input->post('negara',TRUE)),
                "TUJUAN" => ltrim(rtrim($this->input->post('tujuan',TRUE))),
                "TRJENISPEMBIAYAAN_ID" => trim($this->input->post('pembiayaan',TRUE)),
                "SPONSOR" => ltrim(rtrim($this->input->post('sponsor',TRUE))),
                "WKTU_HARI" => trim($this->input->post('hari',TRUE)),
                "WKTU_BLN" => trim($this->input->post('bulan',TRUE)),
                "WKTU_THN" => trim($this->input->post('tahun',TRUE)),
            ];
            $tanggal = [
                "TGL_KJGN" => datepickertodb(trim($this->input->post('tgl_kunjungan',TRUE)))
            ];
            if ($this->master_pegawai_kunjungan_ln_model->insert($post,$tanggal)) {
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
            $this->data['title_form'] = "Ubah";
            $this->data['model'] = $this->master_pegawai_kunjungan_ln_model->get_by_id($this->input->get('id'));
            $this->data['list_negara'] = $this->list_model->list_negara();
            $this->data['list_pembiayaan'] = $this->list_model->list_pembiayaan();
            $this->data['id'] = $id;
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/kunjungan_ln/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('negara', 'Negara', 'required|min_length[1]|max_length[3]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('tujuan', 'Tujuan', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('pembiayaan', 'Pembiayaan', 'min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('sponsor', 'Sponsor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('hari', 'Hari', 'min_length[1]|max_length[3]|trim|is_natural');
        $this->form_validation->set_rules('bulan', 'Bulan', 'min_length[1]|max_length[3]|trim|is_natural');
        $this->form_validation->set_rules('tahun', 'Tahun', 'min_length[1]|max_length[3]|trim|is_natural');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            $post = [
                "TRNEGARA_ID" => trim($this->input->post('negara',TRUE)),
                "TUJUAN" => ltrim(rtrim($this->input->post('tujuan',TRUE))),
                "TRJENISPEMBIAYAAN_ID" => trim($this->input->post('pembiayaan',TRUE)),
                "SPONSOR" => ltrim(rtrim($this->input->post('sponsor',TRUE))),
                "WKTU_HARI" => trim($this->input->post('hari',TRUE)),
                "WKTU_BLN" => trim($this->input->post('bulan',TRUE)),
                "WKTU_THN" => trim($this->input->post('tahun',TRUE)),
            ];
            $tanggal = [
                "TGL_KJGN" => datepickertodb(trim($this->input->post('tgl_kunjungan',TRUE)))
            ];
            
            if ($this->master_pegawai_kunjungan_ln_model->update($post,$tanggal,$this->input->get('id'))) {
                $model = $this->master_pegawai_pendidikan_model->get_by_id($this->input->get('id'));
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
        $list = $this->master_pegawai_kunjungan_ln_model->get_datatables($id);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->NAMA_NEGARA;
            $row[] = $val->SPONSOR;
            $row[] = $val->JENIS_PEMBIAYAAN;
            $row[] = $val->TGL_KJGN;
            $row[] = $val->TUJUAN;
            $row[] = '<a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_kunjungan_ln/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="'.($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data').'"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="'. site_url('master_pegawai/master_pegawai_kunjungan_ln/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a><a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_kunjungan_ln/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_kunjungan_ln_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_kunjungan_ln_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_kunjungan_ln_model->get_by_id($this->input->post('id'));
                if ($this->master_pegawai_kunjungan_ln_model->hapus($this->input->post('id'))) {
                    $nippegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIPNEW");
                    
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_kunjungan_ln_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_kunjungan_ln_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/kunjungan_ln/info', $this->data);
    }

}
