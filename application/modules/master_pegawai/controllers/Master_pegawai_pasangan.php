<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_pasangan extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_pasangan_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'Pasangan Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->data['id'],"NIPNEW");
        $this->load->view('master_pegawai/pasangan/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $data_pegawai = $this->master_pegawai_model->get_by_id_select($id,'SEX');
            $this->data['title_form'] = "Tambah";
            $this->data['list_jenis_pasangan'] = ($data_pegawai['SEX'] == "L") ? [['ID'=>2,"NAMA"=>'Istri']] : [['ID'=>1,"NAMA"=>'Suami']];
            $this->data['list_pekerjaan'] = $this->list_model->list_pekerjaan();
            $this->data['pasangan_ke'] = $this->master_pegawai_pasangan_model->count_pasangan($id) + 1;
            $this->data['id'] = $id;
            
            $this->load->view("master_pegawai/pasangan/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_pasangan', 'Status Pasangan', 'required|min_length[1]|max_length[1]');
        $this->form_validation->set_rules('pasangan_ke', 'Pasangan Ke', 'required|min_length[1]|max_length[2]|is_natural_no_zero');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|max_length[100]');
        $this->form_validation->set_rules('trpekerjaan_id', 'Pekerjaan Pasangan', 'min_length[1]|max_length[2]|is_natural_no_zero');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir Pasangan', 'min_length[1]|max_length[50]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[0]|max_length[100]');
        $this->form_validation->set_rules('karis', 'No Karis', 'min_length[1]|max_length[64]');
        $this->form_validation->set_rules('nik', 'NIK', 'max_length[18]|trim');
        $this->form_validation->set_rules('nip', 'NIP', 'min_length[18]|max_length[18]|trim|is_natural');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            
            $post = [
                "JENIS_PASANGAN" => ltrim(rtrim($this->input->post('jenis_pasangan',TRUE))),
                "PASANGAN_KE" => ltrim(rtrim($this->input->post('pasangan_ke',TRUE))),
                "TRPEKERJAAN_ID" => ltrim(rtrim($this->input->post('trpekerjaan_id',TRUE))),
                "NAMA" => ltrim(rtrim($this->input->post('nama_lengkap',TRUE))),
                "TEMPAT_LHR" => ltrim(rtrim($this->input->post('tempat_lahir',TRUE))),
                "KET" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                "KARIS" => ltrim(rtrim($this->input->post('karis',TRUE))),
                'TMPEGAWAI_ID' => $id,
                "NIP" => ltrim(rtrim($this->input->post('nip',TRUE))),
                "NIK" => ltrim(rtrim($this->input->post('nik',TRUE))),
            ];
            $tanggal = [
                "TGL_NIKAH" => datepickertodb(trim($this->input->post('tanggal_nikah',TRUE))),
                "TGL_LAHIR" => datepickertodb(trim($this->input->post('tanggal_lahir',TRUE))),
            ];
            if ($insert = $this->master_pegawai_pasangan_model->insert($post,$tanggal)) {
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
                    $config['file_name'] = "doc_pasangan_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_akta')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name']))
                            $dokumen = ['DOC_AKTENIKAH' => $config['file_name']];
                        else
                            $dokumen = ['DOC_AKTENIKAH' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_pasangan_model->update($dokumen,[],$insert_id);
                
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
            
            $id = $this->input->get('id',TRUE);
            $this->data['model'] = $this->master_pegawai_pasangan_model->get_by_id($id);
            $data_pegawai = $this->master_pegawai_model->get_by_id_select($this->data['model']['TMPEGAWAI_ID'],"SEX");
            $this->data['title_form'] = "Ubah";
            $this->data['list_jenis_pasangan'] = ($data_pegawai['SEX'] == "L") ? [['ID'=>2,"NAMA"=>'Istri']] : [['ID'=>1,"NAMA"=>'Suami']];
            $this->data['list_pekerjaan'] = $this->list_model->list_pekerjaan();
            $this->data['pasangan_ke'] = $this->master_pegawai_pasangan_model->count_pasangan($id) + 1;
            $this->data['id'] = $id;
            
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/pasangan/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_pasangan', 'Status Pasangan', 'required|min_length[1]|max_length[1]');
        $this->form_validation->set_rules('pasangan_ke', 'Pasangan Ke', 'required|min_length[1]|max_length[2]|is_natural_no_zero');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|max_length[100]');
        $this->form_validation->set_rules('trpekerjaan_id', 'Pekerjaan Pasangan', 'min_length[1]|max_length[2]|is_natural_no_zero');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir Pasangan', 'min_length[1]|max_length[50]');
        $this->form_validation->set_rules('nip', 'NIP', 'min_length[18]|max_length[18]|trim|is_natural');
        $this->form_validation->set_rules('nik', 'NIK', 'max_length[18]|trim');
        $this->form_validation->set_rules('karis', 'No Karis', 'min_length[1]|max_length[64]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'min_length[1]|max_length[100]');
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
                "JENIS_PASANGAN" => ltrim(rtrim($this->input->post('jenis_pasangan',TRUE))),
                "PASANGAN_KE" => ltrim(rtrim($this->input->post('pasangan_ke',TRUE))),
                "TRPEKERJAAN_ID" => ltrim(rtrim($this->input->post('trpekerjaan_id',TRUE))),
                "NAMA" => ltrim(rtrim($this->input->post('nama_lengkap',TRUE))),
                "TEMPAT_LHR" => ltrim(rtrim($this->input->post('tempat_lahir',TRUE))),
                "KET" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                "KARIS" => ltrim(rtrim($this->input->post('karis',TRUE))),
                "NIP" => ltrim(rtrim($this->input->post('nip',TRUE))),
                "NIK" => ltrim(rtrim($this->input->post('nik',TRUE))),
            ];
            $tanggal = [
                "TGL_NIKAH" => datepickertodb(trim($this->input->post('tanggal_nikah',TRUE))),
                "TGL_LAHIR" => datepickertodb(trim($this->input->post('tanggal_lahir',TRUE))),
            ];
            $model = $this->master_pegawai_pasangan_model->get_by_id($this->input->get('kode'));
            
            if ($this->master_pegawai_pasangan_model->update($post,$tanggal,$this->input->get('kode'))) {
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
                    $config['file_name'] = "doc_pasangan_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_akta')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name'])) {
                            if (!empty($model['DOC_AKTENIKAH']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_AKTENIKAH'])) {
                                unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_AKTENIKAH']);
                            }
                            $dokumen = ['DOC_AKTENIKAH' => $config['file_name']];
                        } else
                            $dokumen = ['DOC_AKTENIKAH' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_pasangan_model->update($dokumen,[],$insert_id);
                
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
        $list = $this->master_pegawai_pasangan_model->get_datatables($id);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        $delete = '';
        foreach ($list as $val) {
            $file = '';
            if (!empty($val->DOC_AKTENIKAH) && $val->DOC_AKTENIKAH != "") {
                $file = '<a href="javascript:;" class="btn btn-xs green-haze popupfull" data-url="'. site_url('master_pegawai/master_pegawai_pasangan/view_dokumen?id='.$val->ID).'" title="Lihat Dokumen"><i class="fa fa-file-pdf-o"></i></a>';
            }
            if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') {
                $delete = '<a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="'. site_url('master_pegawai/master_pegawai_pasangan/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a><a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_pasangan/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ($val->JENIS_PASANGAN == 1) ? 'Suami' : 'Istri';
            $row[] = $val->PASANGAN_KE;
            $row[] = $val->NAMA;
            $row[] = $val->PEKERJAAN;
            $row[] = $val->TEMPAT_LHR;
            $row[] = $val->TGL_LAHIR2;
            $row[] = $file.'<a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_pasangan/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="'.($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data').'"><i class="fa fa-edit"></i></a>'.$delete;

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_pasangan_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_pasangan_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_pasangan_model->get_by_id($this->input->post('id'));
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                if ($this->master_pegawai_pasangan_model->hapus($this->input->post('id'))) {
                    if (!empty($model['DOC_AKTENIKAH']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_AKTENIKAH'])) {
                        unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_AKTENIKAH']);
                    }
                    
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_pasangan_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_dokumen() {
        $model = $this->master_pegawai_pasangan_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_AKTENIKAH'])) {
                $this->data['file'] = base_url()."_uploads/doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_AKTENIKAH'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_pasangan_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/pasangan/info', $this->data);
    }

}
