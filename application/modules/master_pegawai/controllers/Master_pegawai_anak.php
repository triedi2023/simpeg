<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_anak extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_anak_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'Anak Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->data['id'],"NIPNEW");
        $this->load->view('master_pegawai/anak/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_jk'] = $this->config->item('list_jk');
            $this->data['list_sts_anak'] = $this->list_model->list_sts_anak();
            $this->data['id'] = $id;
            
            $this->load->view("master_pegawai/anak/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('status_anak', 'Status Anak', 'required|min_length[1]|max_length[1]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|max_length[60]');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required|min_length[1]|max_length[1]|alpha|trim');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'max_length[50]');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'min_length[1]|max_length[50]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[1]|max_length[100]');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            
            $post = [
                "TRSTATUSANAK_ID" => trim($this->input->post('status_anak',TRUE)),
                "NAMA" => ltrim(rtrim($this->input->post('nama_lengkap',TRUE))),
                "SEX" => trim($this->input->post('jk',TRUE)),
                "TEMPAT_LHR" => ltrim(rtrim($this->input->post('tempat_lahir',TRUE))),
                "PEKERJAAN" => ltrim(rtrim($this->input->post('pekerjaan',TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                'TMPEGAWAI_ID' => $id,
            ];
            $tanggal = [
                "TGL_LAHIR" => datepickertodb(trim($this->input->post('tanggal_lahir',TRUE))),
            ];
            if ($insert = $this->master_pegawai_anak_model->insert($post,$tanggal)) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id,"NIP,NIPNEW");
                
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])),0777);
                }

                if (!empty($_FILES['doc_akta']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath').'doc_pegawai/'.preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_anak_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_akta')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name']))
                            $dokumen = ['DOC_AKTEANAK' => $config['file_name']];
                        else
                            $dokumen = ['DOC_AKTEANAK' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_anak_model->update($dokumen,[],$insert_id);
                
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
            $this->data['model'] = $this->master_pegawai_anak_model->get_by_id($id);
            $data_pegawai = $this->master_pegawai_model->get_by_id_select($this->data['model']['TMPEGAWAI_ID'],"SEX");
            $this->data['title_form'] = "Ubah";
            $this->data['list_jk'] = $this->config->item('list_jk');
            $this->data['list_sts_anak'] = $this->list_model->list_sts_anak();
            $this->data['id'] = $id;
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/anak/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('status_anak', 'Status Anak', 'required|min_length[1]|max_length[1]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|max_length[60]');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required|min_length[1]|max_length[1]|alpha|trim');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'max_length[50]');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'min_length[1]|max_length[50]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[1]|max_length[100]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $post = [
                "TRSTATUSANAK_ID" => trim($this->input->post('status_anak',TRUE)),
                "NAMA" => ltrim(rtrim($this->input->post('nama_lengkap',TRUE))),
                "SEX" => trim($this->input->post('jk',TRUE)),
                "TEMPAT_LHR" => ltrim(rtrim($this->input->post('tempat_lahir',TRUE))),
                "PEKERJAAN" => ltrim(rtrim($this->input->post('pekerjaan',TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
            ];
            $tanggal = [
                "TGL_LAHIR" => datepickertodb(trim($this->input->post('tanggal_lahir',TRUE))),
            ];
            $model = $this->master_pegawai_anak_model->get_by_id($this->input->get('id'));
            
            if ($this->master_pegawai_anak_model->update($post,$tanggal,$this->input->get('id'))) {
                $insert_id = $model['ID'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])),0777);
                }

                if (!empty($_FILES['doc_akta']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath').'doc_pegawai/'.preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_anak_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_akta')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name'])) {
                            if (!empty($model['DOC_AKTEANAK']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_AKTEANAK'])) {
                                unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_AKTEANAK']);
                            }
                            $dokumen = ['DOC_AKTEANAK' => $config['file_name']];
                        } else
                            $dokumen = ['DOC_AKTEANAK' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_anak_model->update($dokumen,[],$insert_id);
                
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
        $list = $this->master_pegawai_anak_model->get_datatables($id);
        $data = array();
        $delete = '';
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $file = '';
            if (!empty($val->DOC_AKTEANAK) && $val->DOC_AKTEANAK != "") {
                $file = '<a href="javascript:;" class="btn btn-xs green-haze popupfull" data-url="'. site_url('master_pegawai/master_pegawai_anak/view_dokumen?id='.$val->ID).'" title="Lihat Dokumen"><i class="fa fa-file-pdf-o"></i></a>';
            }
            if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') {
                $delete = '<a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="'. site_url('master_pegawai/master_pegawai_anak/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->STATUS_ANAK;
            $row[] = $val->NAMA;
            $row[] = ($val->SEX == 'L') ? 'Laki-laki' : 'Perempuan';
            $row[] = $val->TGL_LAHIR2;
            $row[] = $val->PEKERJAAN;
            $row[] = $file.'<a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_anak/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="'.($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data').'"><i class="fa fa-edit"></i></a>'.$delete.'<a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_anak/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_anak_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_anak_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_anak_model->get_by_id($this->input->post('id'));
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                if ($this->master_pegawai_anak_model->hapus($this->input->post('id'))) {
                    if (!empty($model['DOC_AKTEANAK']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".trim($data_pegawai['NIP'])."/".$model['DOC_AKTEANAK'])) {
                        unlink($this->config->item('uploadpath')."doc_pegawai/".trim($data_pegawai['NIP'])."/".$model['DOC_AKTEANAK']);
                    }
                    
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_anak_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_dokumen() {
        $model = $this->master_pegawai_anak_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath')."doc_pegawai/".$model['NIP']."/".$model['DOC_AKTEANAK'])) {
                $this->data['file'] = base_url()."_uploads/doc_pegawai/".$model['NIP']."/".$model['DOC_AKTEANAK'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_anak_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/anak/info', $this->data);
    }

}
