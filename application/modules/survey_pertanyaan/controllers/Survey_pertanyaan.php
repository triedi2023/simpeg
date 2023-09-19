<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Survey_pertanyaan extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('survey_pertanyaan/survey_pertanyaan_model','list_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(),['assets/plugins/bootbox/bootbox.min.js','assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js', 'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js']);
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','survey_pertanyaan/js'];
        $this->data['title_utama'] = 'Pertanyaan';
    }

    public function index() {
        $this->data['content'] = 'survey_pertanyaan/index';
        $this->data['list_eselon'] = $this->list_model->list_eselon();
        $this->data['list_kelompok_fungsional'] = $this->list_model->list_kelompok_fungsional();
        $this->data['list_tingkat_fungsional'] = $this->list_model->list_tingkat_fungsional();
        $this->data['list_pendidikan'] = $this->list_model->list_pendidikan();
        $this->load->view('layouts/main', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->load->view("survey_pertanyaan/form", $this->data);
        } else {
            redirect('/survey_pertanyaan');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('judul', 'Judul', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('tgl_selesai', 'Tanggal Selesai', 'required|min_length[10]|max_length[10]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "JUDUL" => ltrim(rtrim($this->input->post('judul',TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE)))
            ];
            
            $id = $this->survey_pertanyaan_model->next_val_id()['NEXT_ID'];
            $this->db->set('ID', $id);
            $this->db->set('START_DATE', "TO_DATE('" . ltrim(rtrim(datepickertodb($this->input->post('tgl_mulai',TRUE)))) . "','YYYY-MM-DD')", FALSE);
            $this->db->set('END_DATE', "TO_DATE('" . ltrim(rtrim(datepickertodb($this->input->post('tgl_selesai',TRUE)))) . "','YYYY-MM-DD')", FALSE);
//            $this->db->set('STATUS', "TO_DATE('" . ltrim(rtrim($this->input->post('status',TRUE))), FALSE);
            $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
            $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
            $this->db->insert("TR_SURVEY", $post);
            
            foreach ($_POST['tipe_jawaban'] as $key => $value):
                $idlast = $this->survey_pertanyaan_model->next_val_pertanyaan_id()['NEXT_ID'];
                if (!empty($_POST['pertanyaan'][$key]) && $_POST['tipe_jawaban'][$key]) {
                    $pertanyaan = [
                        'ID'=>(int)$idlast,
                        'TRSURVEY_ID'=>(int)$id,
                        'PERTANYAAN'=> $_POST['pertanyaan'][$key],
                        'TIPE_JAWABAN'=> (int)$_POST['tipe_jawaban'][$key],
                    ];
                    $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
                    $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
                    $this->db->insert("TR_SURVEY_PERTANYAAN", $pertanyaan);
                    if ($_POST['tipe_jawaban'][$key] == 1) {
                        foreach ($_POST['jawaban'][$key] as $isian) {
                            if (!empty($isian)) {
                                $jawaban = [
                                    'TRSURVEYPERTANYAAN_ID' => $idlast,
                                    'JAWABAN' => $isian
                                ];
                                $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
                                $this->db->insert("TR_SURVEY_JAWABAN", $jawaban);
                            }
                        }
                    }
                }
            endforeach;
            
            echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
        }
    }
    
    public function ubah_form_survey() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $this->data['model'] = $this->survey_pertanyaan_model->get_by_id($this->input->get('id'));
            $this->data['pertanyaan'] = $this->survey_pertanyaan_model->get_pertanyaan_by_trsurveyid($this->data['model']->ID);
            $jawaban = [];
            if ($this->data['pertanyaan']) {
                foreach ($this->data['pertanyaan'] as $pertanyaan):
                    $jawaban[$pertanyaan['ID']] = $this->survey_pertanyaan_model->get_jawaban_by_trpertanyaanid($pertanyaan['ID']);
                endforeach;
            }
            $this->data['jawaban'] = $jawaban;
            $this->data['title_form'] = "Ubah";
            $this->load->view("survey_pertanyaan/form_survey", $this->data);
        } else {
            redirect('/survey_pertanyaan');
        }
    }
    
    public function ubah_proses_pertanyaan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('judul', 'Judul', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('tgl_selesai', 'Tanggal Selesai', 'required|min_length[10]|max_length[10]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "JUDUL" => ltrim(rtrim($this->input->post('judul',TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
//                "STATUS" => ltrim(rtrim($this->input->post('status',TRUE)))
            ];
            $tanggal = [
                'START_DATE' => ltrim(rtrim(datepickertodb($this->input->post('tgl_mulai',TRUE)))),
                'END_DATE' => ltrim(rtrim(datepickertodb($this->input->post('tgl_selesai',TRUE))))
            ];
            if ($this->survey_pertanyaan_model->update_survey($post,$tanggal,$this->input->get('id'))) {
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success'=>'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $this->data['model'] = $this->survey_pertanyaan_model->get_by_id($this->input->get('id'));
            $this->data['pertanyaan'] = $this->survey_pertanyaan_model->get_pertanyaan_by_trsurveyid($this->data['model']->ID);
            $jawaban = [];
            if ($this->data['pertanyaan']) {
                foreach ($this->data['pertanyaan'] as $pertanyaan):
                    $jawaban[$pertanyaan['ID']] = $this->survey_pertanyaan_model->get_jawaban_by_trpertanyaanid($pertanyaan['ID']);
                endforeach;
            }
            $this->data['jawaban'] = $jawaban;
            $this->data['title_form'] = "Ubah";
            $this->load->view("survey_pertanyaan/form_pertanyaan", $this->data);
        } else {
            redirect('/survey_pertanyaan');
        }
    }
    
    public function ubah_proses() {
        $id = $this->input->get('id');
        $this->db->query("DELETE FROM TR_SURVEY_PERTANYAAN WHERE TRSURVEY_ID = ".$id);

        foreach ($_POST['tipe_jawaban'] as $key => $value):
            $idlast = $this->survey_pertanyaan_model->next_val_pertanyaan_id()['NEXT_ID'];
            if (!empty($_POST['pertanyaan'][$key]) && $_POST['tipe_jawaban'][$key]) {
                $pertanyaan = [
                    'ID'=>(int)$idlast,
                    'TRSURVEY_ID'=>(int)$id,
                    'PERTANYAAN'=> $_POST['pertanyaan'][$key],
                    'TIPE_JAWABAN'=> (int)$_POST['tipe_jawaban'][$key],
                ];
                $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
                $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
                $this->db->insert("TR_SURVEY_PERTANYAAN", $pertanyaan);
                if ($_POST['tipe_jawaban'][$key] == 1) {
                    foreach ($_POST['jawaban'][$key] as $isian) {
                        if (!empty($isian)) {
                            $jawaban = [
                                'TRSURVEYPERTANYAAN_ID' => $idlast,
                                'JAWABAN' => $isian
                            ];
                            $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
                            $this->db->insert("TR_SURVEY_JAWABAN", $jawaban);
                        }
                    }
                }
            }
        endforeach;

        echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success'=>'Record added successfully.']);
    }

    public function ajax_list() {
        $list = $this->survey_pertanyaan_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->JUDUL;
            $row[] = $val->KETERANGAN;
            $row[] = $val->START_DATE;
            $row[] = $val->END_DATE;
            $row[] = '<a href="javascript:;" data-url="'. site_url('survey_pertanyaan/ubah_form_survey?id='.$val->ID).'" class="btndefaultshowtambahubah btn btn-icon-only bg-yellow-lemon bg-font-yellow-lemon" title="Ubah Data Survey"><i class="fa fa-edit"></i></a><a href="javascript:;" data-url="'. site_url('survey_pertanyaan/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubah btn btn-icon-only yellow-saffron" title="Ubah Data Pertanyaan"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="'. site_url('survey_pertanyaan/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->survey_pertanyaan_model->count_all(),
            "recordsFiltered" => $this->survey_pertanyaan_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->survey_pertanyaan_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

}
