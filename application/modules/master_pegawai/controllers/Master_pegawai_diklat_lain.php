<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_diklat_lain extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_diklat_lain_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'Diklat Lain';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->data['id'],"NIPNEW");
        $this->load->view('master_pegawai/diklat_lain/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_negara'] = $this->list_model->list_negara();
            $this->data['id'] = $id;
            
            $this->load->view("master_pegawai/diklat_lain/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_diklat', 'Nama Diklat', 'required|min_length[1]|max_length[350]');
        $this->form_validation->set_rules('jpl', 'JPL', 'min_length[1]|max_length[4]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('negara', 'Negara', 'min_length[1]|max_length[3]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('penyelenggara', 'Penyelenggara', 'min_length[1]|max_length[255]');
        $this->form_validation->set_rules('no_sk', 'Nomor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('pejabat', 'Pejabat SK', 'min_length[1]|max_length[128]');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            
            $post = [
                "NAMA_DIKLAT" => ltrim(rtrim($this->input->post('nama_diklat',TRUE))),
                "TRNEGARA_ID" => trim($this->input->post('negara',TRUE)),
                "JPL" => trim($this->input->post('jpl',TRUE)),
                "PENYELENGGARA" => ltrim(rtrim($this->input->post('penyelenggara',TRUE))),
                "NO_STTPP" => ltrim(rtrim($this->input->post('no_sk',TRUE))),
                "PJBT_STTPP" => ltrim(rtrim($this->input->post('pejabat',TRUE))),
                'TMPEGAWAI_ID' => $id,
            ];
            $tanggal = [
                "TGL_STTPP" => datepickertodb(trim($this->input->post('tgl_sk',TRUE))),
            ];
            if ($insert = $this->master_pegawai_diklat_lain_model->insert($post,$tanggal)) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id,"NIP,NIPNEW");
                
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])),0777);
                }

                if (!empty($_FILES['doc_sk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath').'doc_pegawai/'.preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_diklat_lain_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name']))
                            $dokumen = ['DOC_DIKLATLAIN' => $config['file_name']];
                        else
                            $dokumen = ['DOC_DIKLATLAIN' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_diklat_lain_model->update($dokumen,[],$insert_id);
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
            $this->data['model'] = $this->master_pegawai_diklat_lain_model->get_by_id($this->input->get('id'));
            $this->data['list_negara'] = $this->list_model->list_negara();
            $this->data['id'] = $id;
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/diklat_lain/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_diklat', 'Nama Diklat', 'required|min_length[1]|max_length[350]');
        $this->form_validation->set_rules('jpl', 'JPL', 'min_length[1]|max_length[4]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('negara', 'Negara', 'min_length[1]|max_length[3]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('penyelenggara', 'Penyelenggara', 'min_length[1]|max_length[255]');
        $this->form_validation->set_rules('no_sk', 'Nomor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('pejabat', 'Pejabat SK', 'min_length[1]|max_length[128]');
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
                "NAMA_DIKLAT" => ltrim(rtrim($this->input->post('nama_diklat',TRUE))),
                "TRNEGARA_ID" => trim($this->input->post('negara',TRUE)),
                "JPL" => trim($this->input->post('jpl',TRUE)),
                "PENYELENGGARA" => ltrim(rtrim($this->input->post('penyelenggara',TRUE))),
                "NO_STTPP" => ltrim(rtrim($this->input->post('no_sk',TRUE))),
                "PJBT_STTPP" => ltrim(rtrim($this->input->post('pejabat',TRUE))),
            ];
            $tanggal = [
                "TGL_STTPP" => datepickertodb(trim($this->input->post('tgl_sk',TRUE))),
            ];
            $model = $this->master_pegawai_diklat_lain_model->get_by_id($this->input->get('kode'));
            
            if ($this->master_pegawai_diklat_lain_model->update($post,$tanggal,$this->input->get('kode'))) {
                $insert_id = $model['ID'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'),"NIP,NIPNEW");
                
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])),0777);
                }

                if (!empty($_FILES['doc_sk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath').'doc_pegawai/'.preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_diklat_lain_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name'])) {
                            if (!empty($model['DOC_DIKLATLAIN']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_DIKLATLAIN'])) {
                                unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_DIKLATLAIN']);
                            }
                            $dokumen = ['DOC_DIKLATLAIN' => $config['file_name']];
                        } else
                            $dokumen = ['DOC_DIKLATLAIN' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_diklat_lain_model->update($dokumen,[],$insert_id);
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
        $list = $this->master_pegawai_diklat_lain_model->get_datatables($id);
        $data = array();
        $delete = '';
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $file = '';
            if (!empty($val->DOC_DIKLATLAIN) && $val->DOC_DIKLATLAIN != "") {
                $file = '<a href="javascript:;" class="btn btn-xs green-haze popupfull" data-url="'. site_url('master_pegawai/master_pegawai_diklat_lain/view_dokumen?id='.$val->ID).'" title="Lihat Dokumen"><i class="fa fa-file-pdf-o"></i></a>';
            }
            if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') {
                $delete = '<a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="'. site_url('master_pegawai/master_pegawai_diklat_lain/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->NAMA_DIKLAT;
            $row[] = $val->JPL;
            $row[] = $val->NO_STTPP;
            $row[] = $file.'<a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_diklat_lain/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="'.($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data').'"><i class="fa fa-edit"></i></a>'.$delete.'<a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_diklat_lain/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_diklat_lain_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_diklat_lain_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_diklat_lain_model->get_by_id($this->input->post('id'));
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                if ($this->master_pegawai_diklat_lain_model->hapus($this->input->post('id'))) {
                    if (!empty($model['DOC_DIKLATLAIN']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_DIKLATLAIN'])) {
                        unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_DIKLATLAIN']);
                    }
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_diklat_lain_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_dokumen() {
        $model = $this->master_pegawai_diklat_lain_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_DIKLATLAIN'])) {
                $this->data['file'] = base_url()."_uploads/doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_DIKLATLAIN'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_diklat_lain_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/diklat_lain/info', $this->data);
    }

}
