<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_seminar extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_seminar_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'Seminar Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'),"NIPNEW");
//        $this->Log_model->insert_log("Melihat","Data Seminar Pegawai Dengan NIP ".($nippegawai['NIPNEW']).";");
        $this->load->view('master_pegawai/seminar/index', $this->data);
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
            $this->data['list_kegiatan'] = $this->list_model->list_kegiatan();
            $this->data['list_kedudukan'] = $this->list_model->list_kedudukan();
            $this->data['id'] = $id;
            
            $this->load->view("master_pegawai/seminar/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_kegiatan', 'Jenis Kegiatan', 'required|min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('nama_kegiatan', 'Nama Kegiatan', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('negara', 'Negara', 'min_length[1]|max_length[3]|trim');
        $this->form_validation->set_rules('tempat', 'Tempat', 'min_length[1]|max_length[64]');
        $this->form_validation->set_rules('pembiayaan', 'Pembiayaan', 'min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('sponsor', 'Sponsor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('kedudukan', 'Kedudukan', 'min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('wktu_kegiatan', 'Waktu Kegiatan', 'min_length[7]|max_length[7]');
        $this->form_validation->set_rules('penyelenggara', 'Penyelenggara', 'min_length[1]|max_length[255]');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            $bln = NULL;
            $thn = NULL;
            if (!empty($_POST['wktu_kegiatan'])) {
                $pecah = explode("/", $_POST['wktu_kegiatan']);
                $bln = $pecah[0];
                $thn = $pecah[1];
            }
            
            $post = [
                "TRJENISKEGIATAN_ID" => trim($this->input->post('jenis_kegiatan',TRUE)),
                "NAMA_KEGIATAN" => ltrim(rtrim($this->input->post('nama_kegiatan',TRUE))),
                "TRNEGARA_ID" => trim($this->input->post('negara',TRUE)),
                "TEMPAT" => ltrim(rtrim($this->input->post('tempat',TRUE))),
                "PENYELENGGARA" => ltrim(rtrim($this->input->post('penyelenggara',TRUE))),
                'TMPEGAWAI_ID' => $id,
                "TRJENISPEMBIAYAAN_ID" => trim($this->input->post('pembiayaan',TRUE)),
                "TRKEDUDUKANDLMKEGIATAN_ID" => trim($this->input->post('kedudukan',TRUE)),
                "SPONSOR" => ltrim(rtrim($this->input->post('sponsor',TRUE))),
                "BULAN" => $bln,
                "TAHUN" => $thn,
            ];
            $tanggal = [
                "TGL_MULAI" => datepickertodb(trim($this->input->post('tgl_mulai', TRUE))),
                "TGL_SELESAI" => datepickertodb(trim($this->input->post('tgl_selesai', TRUE)))
            ];
            if (($insert = $this->master_pegawai_seminar_model->insert($post,$tanggal)) == true) {
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
                    $config['file_name'] = "doc_seminar_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name']))
                            $dokumen = ['DOC_SERTIFIKAT' => $config['file_name']];
                        else
                            $dokumen = ['DOC_SERTIFIKAT' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_seminar_model->update($dokumen,[],$insert_id);
//                $this->Log_model->insert_log("Menambah","Data Seminar Pegawai Dengan NIP ".($data_pegawai['NIPNEW']).";");
                
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
            $this->data['model'] = $this->master_pegawai_seminar_model->get_by_id($this->input->get('id'));
            $this->data['list_negara'] = $this->list_model->list_negara();
            $this->data['list_pembiayaan'] = $this->list_model->list_pembiayaan();
            $this->data['list_kegiatan'] = $this->list_model->list_kegiatan();
            $this->data['list_kedudukan'] = $this->list_model->list_kedudukan();
            $this->data['id'] = $id;
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/seminar/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_kegiatan', 'Jenis Kegiatan', 'required|min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('nama_kegiatan', 'Nama Kegiatan', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('negara', 'Negara', 'min_length[1]|max_length[3]|trim');
        $this->form_validation->set_rules('tempat', 'Tempat', 'min_length[1]|max_length[64]');
        $this->form_validation->set_rules('pembiayaan', 'Pembiayaan', 'min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('sponsor', 'Sponsor', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('kedudukan', 'Kedudukan', 'min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('wktu_kegiatan', 'Waktu Kegiatan', 'min_length[7]|max_length[7]');
        $this->form_validation->set_rules('penyelenggara', 'Penyelenggara', 'min_length[1]|max_length[255]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            $bln = NULL;
            $thn = NULL;
            if (!empty($_POST['wktu_kegiatan'])) {
                $pecah = explode("/", $_POST['wktu_kegiatan']);
                $bln = $pecah[0];
                $thn = $pecah[1];
            }
            
            $post = [
                "TRJENISKEGIATAN_ID" => trim($this->input->post('jenis_kegiatan',TRUE)),
                "NAMA_KEGIATAN" => ltrim(rtrim($this->input->post('nama_kegiatan',TRUE))),
                "TRNEGARA_ID" => trim($this->input->post('negara',TRUE)),
                "TEMPAT" => ltrim(rtrim($this->input->post('tempat',TRUE))),
                "PENYELENGGARA" => ltrim(rtrim($this->input->post('penyelenggara',TRUE))),
                "TRJENISPEMBIAYAAN_ID" => trim($this->input->post('pembiayaan',TRUE)),
                "TRKEDUDUKANDLMKEGIATAN_ID" => trim($this->input->post('kedudukan',TRUE)),
                "SPONSOR" => ltrim(rtrim($this->input->post('sponsor',TRUE))),
                "BULAN" => $bln,
                "TAHUN" => $thn,
            ];
            $tanggal = [
                "TGL_MULAI" => datepickertodb(trim($this->input->post('tgl_mulai', TRUE))),
                "TGL_SELESAI" => datepickertodb(trim($this->input->post('tgl_selesai', TRUE)))
            ];
            $model = $this->master_pegawai_seminar_model->get_by_id($this->input->get('id'));
            
            if ($this->master_pegawai_seminar_model->update($post,$tanggal,$this->input->get('id'))) {
                $insert_id = $model['ID'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])),0777);
                }

                if (!empty($_FILES['doc_sk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath').'doc_pegawai/'.preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_seminar_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name'])) {
                            if (!empty($model['DOC_SERTIFIKAT']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SERTIFIKAT'])) {
                                unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SERTIFIKAT']);
                            }
                            $dokumen = ['DOC_SERTIFIKAT' => $config['file_name']];
                        } else
                            $dokumen = ['DOC_SERTIFIKAT' => NULL];
                    }
                    unset($config);
                    $this->master_pegawai_seminar_model->update($dokumen,$insert_id);
                }
                
//                $this->Log_model->insert_log("Mengubah","Data Seminar Pegawai Dengan NIP ".($data_pegawai['NIPNEW']).";");
                
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
        $list = $this->master_pegawai_seminar_model->get_datatables($id);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $file = '';
            if (!empty($val->DOC_SERTIFIKAT) && $val->DOC_SERTIFIKAT != "") {
                $file = '<a href="javascript:;" class="btn btn-xs green-haze popupfull" data-url="'. site_url('master_pegawai/master_pegawai_seminar/view_dokumen?id='.$val->ID).'" title="Lihat Dokumen"><i class="fa fa-file-pdf-o"></i></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->JENIS_KEGIATAN;
            $row[] = $val->NAMA_KEGIATAN;
            $row[] = $val->NAMA_NEGARA;
            $row[] = $val->TEMPAT;
            $row[] = $val->PENYELENGGARA;
            $row[] = $val->JENIS_PEMBIAYAAN;
            $row[] = $val->BULAN."/".$val->TAHUN;
            $row[] = $file.'<a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_seminar/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="'.($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data').'"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="'. site_url('master_pegawai/master_pegawai_seminar/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a><a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_seminar/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_seminar_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_seminar_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_seminar_model->get_by_id($this->input->post('id'));
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                if ($this->master_pegawai_seminar_model->hapus($this->input->post('id'))) {
                    if (!empty($model['DOC_SERTIFIKAT']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SERTIFIKAT'])) {
                        unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SERTIFIKAT']);
                    }
//                    $this->Log_model->insert_log("Menghapus","Data Seminar Pegawai Dengan NIP ".($data_pegawai['NIPNEW']).";");
                    
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_seminar_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_dokumen() {
        $model = $this->master_pegawai_seminar_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_SERTIFIKAT'])) {
                $this->data['file'] = base_url()."_uploads/doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_SERTIFIKAT'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_seminar_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/seminar/info', $this->data);
    }

}
