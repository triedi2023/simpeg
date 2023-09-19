<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_ak extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_ak_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'Angka Kredit';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->data['id'],"NIPNEW");
        $this->load->view('master_pegawai/ak/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_tahun'] = $this->list_model->list_tahun();
            $this->data['list_jabatan_pegawai'] = $this->master_pegawai_ak_model->list_jabatan_pegawai($_GET['id']);
            $this->data['id'] = $id;
            
            $this->load->view("master_pegawai/ak/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tahun_penilaian', 'Tahun Penilaian', 'required|min_length[1]|max_length[4]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|min_length[1]|max_length[4]|trim');
        $this->form_validation->set_rules('nilai_utama', 'Nilai Utama', 'min_length[1]|max_length[10]|trim');
        $this->form_validation->set_rules('nilai_penunjang', 'Nilai Penunjang', 'min_length[1]|max_length[10]|trim');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'max_length[300]');
        $this->form_validation->set_rules('lembaga', 'Lembaga', 'min_length[1]|max_length[150]');
        $this->form_validation->set_rules('no_sk', 'Nomor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('pejabat', 'Pejabat SK', 'min_length[1]|max_length[128]');
        $this->form_validation->set_rules('nama_pejabat', 'Nama Pejabat', 'min_length[1]|max_length[150]');
        $this->form_validation->set_rules('nip_pejabat', 'NIP Pejabat', 'min_length[1]|max_length[18]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_mulai', 'Tgl mulai', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_slesai', 'Tgl slesai', 'min_length[10]|max_length[10]|trim');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            
            $post = [
                "TAHUN_KREDIT" => trim($this->input->post('tahun_penilaian',TRUE)),
                "TRJABATAN_ID" => trim($this->input->post('jabatan',TRUE)),
                "AK_UTAMA" => trim($this->input->post('nilai_utama',TRUE)),
                "AK_PENUNJANG" => trim($this->input->post('nilai_penunjang',TRUE)),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                "LEMBAGA" => ltrim(rtrim($this->input->post('lembaga',TRUE))),
                "NO_SK" => ltrim(rtrim($this->input->post('no_sk',TRUE))),
                "PEJABAT_SK" => ltrim(rtrim($this->input->post('pejabat_sk',TRUE))),
                "NAMA_PEJABAT_SK" => ltrim(rtrim($this->input->post('nama_pejabat',TRUE))),
                "NIP_PEJABAT_SK" => ltrim(rtrim($this->input->post('nip_pejabat',TRUE))),
                "AK_JUMLAH" => trim($this->input->post('nilai_utama',TRUE)) + trim($this->input->post('nilai_penunjang',TRUE)),
                'TMPEGAWAI_ID' => $id,
            ];
            $tanggal = [
                "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk',TRUE))),
                "PERIODE_AWAL" => datepickertodb(trim($this->input->post('tgl_mulai',TRUE))),
                "PERIODE_AKHIR" => datepickertodb(trim($this->input->post('tgl_slesai',TRUE))),
            ];
            if ($insert = $this->master_pegawai_ak_model->insert($post,$tanggal)) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id,"NIP,NIPNEW");
                
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath')."doc_pegawai/".trim($data_pegawai['NIP']))) {
                    mkdir($this->config->item('uploadpath')."doc_pegawai/".trim($data_pegawai['NIP']),0777);
                }

                if (!empty($_FILES['doc_sk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath').'doc_pegawai/'.trim($data_pegawai['NIP']);
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_ak_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".trim($data_pegawai['NIP'])."/".$config['file_name']))
                            $dokumen = ['DOC_AK' => $config['file_name']];
                        else
                            $dokumen = ['DOC_AK' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_ak_model->update($dokumen,[],$insert_id);
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
            $this->data['model'] = $this->master_pegawai_ak_model->get_by_id($this->input->get('id'));
            $this->data['list_tahun'] = $this->list_model->list_tahun();
            $this->data['list_jabatan_pegawai'] = $this->master_pegawai_ak_model->list_jabatan_pegawai($this->data['model']['TMPEGAWAI_ID']);
            $this->data['id'] = $id;
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/ak/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tahun_penilaian', 'Tahun Penilaian', 'required|min_length[1]|max_length[4]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|min_length[1]|max_length[4]|trim');
        $this->form_validation->set_rules('nilai_utama', 'Nilai Utama', 'min_length[1]|max_length[10]|trim');
        $this->form_validation->set_rules('nilai_penunjang', 'Nilai Penunjang', 'min_length[1]|max_length[10]|trim');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'max_length[300]');
        $this->form_validation->set_rules('lembaga', 'Lembaga', 'min_length[1]|max_length[150]');
        $this->form_validation->set_rules('no_sk', 'Nomor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('pejabat', 'Pejabat SK', 'min_length[1]|max_length[128]');
        $this->form_validation->set_rules('nama_pejabat', 'Nama Pejabat', 'min_length[1]|max_length[150]');
        $this->form_validation->set_rules('nip_pejabat', 'NIP Pejabat', 'min_length[1]|max_length[18]|is_natural_no_zero|trim');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_mulai', 'Tgl mulai', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tgl_slesai', 'Tgl slesai', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $post = [
                "TAHUN_KREDIT" => trim($this->input->post('tahun_penilaian',TRUE)),
                "TRJABATAN_ID" => trim($this->input->post('jabatan',TRUE)),
                "AK_UTAMA" => trim($this->input->post('nilai_utama',TRUE)),
                "AK_PENUNJANG" => trim($this->input->post('nilai_penunjang',TRUE)),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                "LEMBAGA" => ltrim(rtrim($this->input->post('lembaga',TRUE))),
                "NO_SK" => ltrim(rtrim($this->input->post('no_sk',TRUE))),
                "PEJABAT_SK" => ltrim(rtrim($this->input->post('pejabat_sk',TRUE))),
                "NAMA_PEJABAT_SK" => ltrim(rtrim($this->input->post('nama_pejabat',TRUE))),
                "NIP_PEJABAT_SK" => ltrim(rtrim($this->input->post('nip_pejabat',TRUE))),
                "AK_JUMLAH" => trim($this->input->post('nilai_utama',TRUE)) + trim($this->input->post('nilai_penunjang',TRUE)),
            ];
            $tanggal = [
                "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk',TRUE))),
                "PERIODE_AWAL" => datepickertodb(trim($this->input->post('tgl_mulai',TRUE))),
                "PERIODE_AKHIR" => datepickertodb(trim($this->input->post('tgl_slesai',TRUE))),
            ];
            $model = $this->master_pegawai_ak_model->get_by_id($this->input->get('id'));
            
            if ($this->master_pegawai_ak_model->update($post,$tanggal,$this->input->get('id'))) {
                $insert_id = $model['ID'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath')."doc_pegawai/".trim($data_pegawai['NIP']))) {
                    mkdir($this->config->item('uploadpath')."doc_pegawai/".trim($data_pegawai['NIP']),0777);
                }

                if (!empty($_FILES['doc_sk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath').'doc_pegawai/'.trim($data_pegawai['NIP']);
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_ak_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".trim($data_pegawai['NIP'])."/".$config['file_name'])) {
                            if (!empty($model['DOC_AK']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".trim($data_pegawai['NIP'])."/".$model['DOC_AK'])) {
                                unlink($this->config->item('uploadpath')."doc_pegawai/".trim($data_pegawai['NIP'])."/".$model['DOC_AK']);
                            }
                            $dokumen = ['DOC_AK' => $config['file_name']];
                        } else
                            $dokumen = ['DOC_AK' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_ak_model->update($dokumen,[],$insert_id);
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
        $list = $this->master_pegawai_ak_model->get_datatables($id);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $file = '';
            if (!empty($val->DOC_AK) && $val->DOC_AK != "") {
                $file = '<a href="javascript:;" class="btn btn-xs green-haze popupfull" data-url="'. site_url('master_pegawai/master_pegawai_ak/view_dokumen?id='.$val->ID).'" title="Lihat Dokumen"><i class="fa fa-file-pdf-o"></i></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->TAHUN_KREDIT;
            $row[] = $val->JABATAN;
            $row[] = $val->AK_UTAMA;
            $row[] = $val->AK_PENUNJANG;
            $row[] = $val->AK_JUMLAH;
            $row[] = $file.'<a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_ak/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="'.($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data').'"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="'. site_url('master_pegawai/master_pegawai_ak/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a><a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_ak/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_ak_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_ak_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_ak_model->get_by_id($this->input->post('id'));
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                if ($this->master_pegawai_ak_model->hapus($this->input->post('id'))) {
                    if (!empty($model['DOC_AK']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".trim($data_pegawai['NIP'])."/".$model['DOC_AK'])) {
                        unlink($this->config->item('uploadpath')."doc_pegawai/".trim($data_pegawai['NIP'])."/".$model['DOC_AK']);
                    }
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_ak_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_dokumen() {
        $model = $this->master_pegawai_ak_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath')."doc_pegawai/".$model['NIP']."/".$model['DOC_AK'])) {
                $this->data['file'] = base_url()."_uploads/doc_pegawai/".$model['NIP']."/".$model['DOC_AK'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_ak_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/ak/info', $this->data);
    }

}
