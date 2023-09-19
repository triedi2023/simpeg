<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi_jabatan extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('referensi_jabatan/referensi_jabatan_model','list_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(),['assets/plugins/bootbox/bootbox.min.js','assets/plugins/select2/js/select2.full.min.js']);
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','referensi_jabatan/js'];
        $this->data['title_utama'] = 'Jabatan';
    }

    public function index() {
        $this->data['content'] = 'referensi_jabatan/index';
        $this->data['list_eselon'] = $this->list_model->list_eselon();
        $this->data['list_kelompok_fungsional'] = $this->list_model->list_kelompok_fungsional();
        $this->data['list_tingkat_fungsional'] = $this->list_model->list_tingkat_fungsional();
        $this->data['list_pendidikan'] = $this->list_model->list_pendidikan();
        $this->load->view('layouts/main', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->data['list_kelompok_fungsional'] = $this->list_model->list_kelompok_fungsional();
            $this->data['list_tingkat_fungsional'] = $this->list_model->list_tingkat_fungsional();
            $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat();
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            $this->data['list_pendidikan'] = $this->list_model->list_pendidikan();
            $this->load->view("referensi_jabatan/form", $this->data);
        } else {
            redirect('/referensi_jabatan');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[1]|max_length[255]');
        $this->form_validation->set_rules('kelompok_fungsional', 'Kelompok Fungsional', 'min_length[2]|max_length[2]|numeric');
        $this->form_validation->set_rules('tingkat_fungsional', 'Tingkat Fungsional', 'min_length[1]|max_length[2]|numeric');
        $this->form_validation->set_rules('gol_terendah', 'Golongan Terendah', 'min_length[3]|max_length[3]|numeric');
        $this->form_validation->set_rules('gol_tertinggi', 'Golongan Tertinggi', 'min_length[3]|max_length[3]');
        $this->form_validation->set_rules('eselon', 'Eselon', 'required|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('usia_pensiun', 'Usia Pensiun', 'required|min_length[1]|max_length[3]|numeric');
        $this->form_validation->set_rules('tunjangan', 'Tunjangan', 'min_length[1]|max_length[10]|numeric');
        $this->form_validation->set_rules('ak_minimal', 'AK Minimal', 'min_length[1]|max_length[4]');
        $this->form_validation->set_rules('tingkat_pendidikan', 'Tingkat Pendidikan', 'min_length[1]|max_length[2]|numeric');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "JABATAN" => $this->input->post('jabatan',TRUE),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                "TRKELOMPOKFUNGSIONAL_ID" => ltrim(rtrim($this->input->post('kelompok_fungsional',TRUE))),
                "TRTINGKATFUNGSIONAL_ID" => ltrim(rtrim($this->input->post('tingkat_fungsional',TRUE))),
                "TRGOLONGAN_ID_R" => ltrim(rtrim($this->input->post('gol_terendah',TRUE))),
                "TRGOLONGAN_ID_T" => ltrim(rtrim($this->input->post('gol_tertinggi',TRUE))),
                "TRESELON_ID" => ltrim(rtrim($this->input->post('eselon',TRUE))),
                "USIA_PENSIUN" => ltrim(rtrim($this->input->post('usia_pensiun',TRUE))),
                "TUNJANGAN" => ltrim(rtrim($this->input->post('tunjangan',TRUE))),
                "AK_MINIMAL" => ltrim(rtrim($this->input->post('ak_minimal',TRUE))),
                "TRTINGKATPENDIDIKAN_ID" => ltrim(rtrim($this->input->post('tingkat_pendidikan',TRUE))),
                "ID_JABFUNGT_BKN" => ltrim(rtrim($this->input->post('idbknt',TRUE))),
                "ID_JABFUNGU_BKN" => ltrim(rtrim($this->input->post('idbknu',TRUE))),
                "ID_STRUKTURAL_BKN" => ltrim(rtrim($this->input->post('idstrukturalbkn',TRUE))),
                "NAMA_BKN" => ltrim(rtrim($this->input->post('namabkn',TRUE))),
                "KEL_JABATAN_ID" => ltrim(rtrim($this->input->post('idkeljab',TRUE))),
                "JENJANG" => ltrim(rtrim($this->input->post('jenjang',TRUE))),
                "CEPAT_KODE" => ltrim(rtrim($this->input->post('kdcepat',TRUE))),
            ];
            if ($this->referensi_jabatan_model->insert($post)) {
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $this->data['model'] = $this->referensi_jabatan_model->get_by_id($this->input->get('id'));
            $this->data['list_kelompok_fungsional'] = $this->list_model->list_kelompok_fungsional();
            $this->data['list_tingkat_fungsional'] = $this->list_model->list_tingkat_fungsional();
            $this->data['list_golongan_pangkat'] = $this->list_model->list_golongan_pangkat();
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            $this->data['list_pendidikan'] = $this->list_model->list_pendidikan();
            $this->data['title_form'] = "Ubah";
            $this->load->view("referensi_jabatan/form", $this->data);
        } else {
            redirect('/referensi_jabatan');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[1]|max_length[255]');
        $this->form_validation->set_rules('kelompok_fungsional', 'Kelompok Fungsional', 'min_length[2]|max_length[2]|numeric');
        $this->form_validation->set_rules('tingkat_fungsional', 'Tingkat Fungsional', 'min_length[1]|max_length[2]|numeric');
        $this->form_validation->set_rules('gol_terendah', 'Golongan Terendah', 'min_length[3]|max_length[3]|numeric');
        $this->form_validation->set_rules('gol_tertinggi', 'Golongan Tertinggi', 'min_length[3]|max_length[3]');
        $this->form_validation->set_rules('eselon', 'Eselon', 'required|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('usia_pensiun', 'Usia Pensiun', 'required|min_length[1]|max_length[3]|numeric');
        $this->form_validation->set_rules('tunjangan', 'Tunjangan', 'min_length[1]|max_length[10]|numeric');
        $this->form_validation->set_rules('ak_minimal', 'AK Minimal', 'min_length[1]|max_length[4]');
        $this->form_validation->set_rules('tingkat_pendidikan', 'Tingkat Pendidikan', 'min_length[1]|max_length[2]|numeric');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "JABATAN" => $this->input->post('jabatan',TRUE),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                "TRKELOMPOKFUNGSIONAL_ID" => ltrim(rtrim($this->input->post('kelompok_fungsional',TRUE))),
                "TRTINGKATFUNGSIONAL_ID" => ltrim(rtrim($this->input->post('tingkat_fungsional',TRUE))),
                "TRGOLONGAN_ID_R" => ltrim(rtrim($this->input->post('gol_terendah',TRUE))),
                "TRGOLONGAN_ID_T" => ltrim(rtrim($this->input->post('gol_tertinggi',TRUE))),
                "TRESELON_ID" => ltrim(rtrim($this->input->post('eselon',TRUE))),
                "USIA_PENSIUN" => ltrim(rtrim($this->input->post('usia_pensiun',TRUE))),
                "TUNJANGAN" => ltrim(rtrim($this->input->post('tunjangan',TRUE))),
                "AK_MINIMAL" => ltrim(rtrim($this->input->post('ak_minimal',TRUE))),
                "TRTINGKATPENDIDIKAN_ID" => ltrim(rtrim($this->input->post('tingkat_pendidikan',TRUE))),
                "STATUS" => ltrim(rtrim($this->input->post('status',TRUE))),
                "ID_JABFUNGT_BKN" => ltrim(rtrim($this->input->post('idbknt',TRUE))),
                "ID_JABFUNGU_BKN" => ltrim(rtrim($this->input->post('idbknu',TRUE))),
                "ID_STRUKTURAL_BKN" => ltrim(rtrim($this->input->post('idstrukturalbkn',TRUE))),
                "NAMA_BKN" => ltrim(rtrim($this->input->post('namabkn',TRUE))),
                "KEL_JABATAN_ID" => ltrim(rtrim($this->input->post('idkeljab',TRUE))),
                "JENJANG" => ltrim(rtrim($this->input->post('jenjang',TRUE))),
                "CEPAT_KODE" => ltrim(rtrim($this->input->post('kdcepat',TRUE))),
            ];
            if ($this->referensi_jabatan_model->update($post,$this->input->get('id'))) {
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success'=>'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        $list = $this->referensi_jabatan_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->JABATAN;
            $row[] = $val->ESELON;
            $row[] = $val->TINGKAT_PENDIDIKAN;
            $row[] = $val->KELOMPOK_FUNGSIONAL;
            $row[] = $val->TINGKAT_FUNGSIONAL;
            $row[] = ($val->STATUS == 1) ? '<span class="label label-sm label-success"> Aktif </span>' : '<span class="label label-sm label-default"> Inaktif </span>';
            $row[] = '<a href="javascript:;" data-url="'. site_url('referensi_jabatan/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubah btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="'. site_url('referensi_jabatan/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->referensi_jabatan_model->count_all(),
            "recordsFiltered" => $this->referensi_jabatan_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function unique_create() {
        $model = $this->referensi_jabatan_model->get_unique_create($this->input->post('tipe_pangkat',true),$this->input->post('golongan',true),$this->input->post('pangkat',true));
        if ($model > 0) {
            $this->form_validation->set_message('unique_create','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function unique_edit() {
        $model = $this->referensi_jabatan_model->get_unique_update($this->input->get('id'),$this->input->post('tipe_pangkat',true),$this->input->post('golongan',true),$this->input->post('pangkat',true));
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
                if ($this->referensi_jabatan_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

}
