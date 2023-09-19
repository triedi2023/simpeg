<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_pendidikan extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_pendidikan_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'Pendidikan Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'),"NIPNEW");
        $this->load->view('master_pegawai/pendidikan/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_pendidikan'] = $this->list_model->list_pendidikan();
            $this->data['list_negara'] = $this->list_model->list_negara();
            $this->data['list_fakultas'] = $this->list_model->list_fakultas();
            $this->data['id'] = $id;
            
            $this->load->view("master_pegawai/pendidikan/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tkt_pendidikan', 'Tingkat Pendidikan', 'required|min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('nama_lbg', 'Nama Lembaga', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('universitas_id', 'universitas_id', 'min_length[1]|max_length[4]');
        $this->form_validation->set_rules('fakultas', 'Fakultas', 'min_length[1]|max_length[4]|trim');
        $this->form_validation->set_rules('jurusan_id', 'jurusan_id', 'min_length[1]|max_length[4]|trim');
        $this->form_validation->set_rules('negara', 'Negara', 'min_length[1]|max_length[3]|trim');
        $this->form_validation->set_rules('tahun_lulus', 'Tahun Lulus', 'min_length[4]|max_length[4]|trim');
        $this->form_validation->set_rules('no_ijasah', 'No Ijasah', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('nama_pimpinan', 'Nama Pimpinan', 'min_length[1]|max_length[100]');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            
            $post = [
                "TRTINGKATPENDIDIKAN_ID" => trim($this->input->post('tkt_pendidikan',TRUE)),
                "NAMA_LBGPDK" => ltrim(rtrim($this->input->post('nama_lbg',TRUE))),
                "TRUNIVERSITAS_ID" => trim($this->input->post('universitas_id',TRUE)),
                "TRNEGARA_ID" => trim($this->input->post('negara',TRUE)),
                "TRFAKULTAS_ID" => trim($this->input->post('fakultas',TRUE)),
                "TRJURUSAN_ID" => trim($this->input->post('jurusan_id',TRUE)),
                'TMPEGAWAI_ID' => $id,
                "THN_LULUS" => trim($this->input->post('tahun_lulus',TRUE)),
                "NO_STTB" => ltrim(rtrim($this->input->post('no_ijasah',TRUE))),
                "NAMA_DIREKTUR" => ltrim(rtrim($this->input->post('nama_pimpinan',TRUE))),
            ];
            $tanggal = [
                "TGL_IJAZAH" => datepickertodb(trim($this->input->post('tgl_ijasah',TRUE))),
            ];
            if (($insert = $this->master_pegawai_pendidikan_model->insert($post,$tanggal)) == true) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id,"NIP,NIPNEW");
                
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])),0777);
                }

                if (!empty($_FILES['doc_ijasah']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath').'doc_pegawai/'.preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_pendidikan_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_ijasah')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name']))
                            $dokumen = ['DOC_IJASAH' => $config['file_name']];
                        else
                            $dokumen = ['DOC_IJASAH' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_pendidikan_model->update($dokumen,[],$insert_id);
                $pendidikan_mutakhir = $this->master_pegawai_pendidikan_model->pendidikan_mutakhir($id);
                                
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.', 'data'=>(isset($pendidikan_mutakhir['TINGKAT_PENDIDIKAN']) && !empty($pendidikan_mutakhir['TINGKAT_PENDIDIKAN'])) ? $pendidikan_mutakhir['TINGKAT_PENDIDIKAN'] : '']);
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
            $this->data['model'] = $this->master_pegawai_pendidikan_model->get_by_id($this->input->get('id'));
            $this->data['list_pendidikan'] = $this->list_model->list_pendidikan();
            $this->data['list_negara'] = $this->list_model->list_negara();
            $this->data['list_fakultas'] = $this->list_model->list_fakultas();
            if (!empty($this->data['model']['TRJURUSAN_ID'])) {
                $this->data['list_jurusan'] = $this->list_model->list_jurusan($this->data['model']['TRJURUSAN_ID']);
            }
            $this->data['id'] = $id;
            
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/pendidikan/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tkt_pendidikan', 'Tingkat Pendidikan', 'required|min_length[1]|max_length[2]|trim|is_natural_no_zero');
        $this->form_validation->set_rules('nama_lbg', 'Nama Lembaga', 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('universitas_id', 'universitas_id', 'min_length[1]|max_length[4]');
        $this->form_validation->set_rules('fakultas', 'Fakultas', 'min_length[1]|max_length[4]|trim');
        $this->form_validation->set_rules('jurusan_id', 'jurusan_id', 'min_length[1]|max_length[4]|trim');
        $this->form_validation->set_rules('negara', 'Negara', 'min_length[1]|max_length[3]|trim');
        $this->form_validation->set_rules('tahun_lulus', 'Tahun Lulus', 'min_length[4]|max_length[4]|trim');
        $this->form_validation->set_rules('no_ijasah', 'No Ijasah', 'min_length[1]|max_length[100]');
        $this->form_validation->set_rules('nama_pimpinan', 'Nama Pimpinan', 'min_length[1]|max_length[100]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $post = [
                "TRTINGKATPENDIDIKAN_ID" => trim($this->input->post('tkt_pendidikan',TRUE)),
                "NAMA_LBGPDK" => ltrim(rtrim($this->input->post('nama_lbg',TRUE))),
                "TRUNIVERSITAS_ID" => trim($this->input->post('universitas_id',TRUE)),
                "TRNEGARA_ID" => trim($this->input->post('negara',TRUE)),
                "TRFAKULTAS_ID" => trim($this->input->post('fakultas',TRUE)),
                "TRJURUSAN_ID" => trim($this->input->post('jurusan_id',TRUE)),
                "THN_LULUS" => trim($this->input->post('tahun_lulus',TRUE)),
                "NO_STTB" => ltrim(rtrim($this->input->post('no_ijasah',TRUE))),
                "NAMA_DIREKTUR" => ltrim(rtrim($this->input->post('nama_pimpinan',TRUE))),
            ];
            $tanggal = [
                "TGL_IJAZAH" => datepickertodb(trim($this->input->post('tgl_ijasah',TRUE))),
            ];
            $model = $this->master_pegawai_pendidikan_model->get_by_id($this->input->get('id'));
            
            if ($this->master_pegawai_pendidikan_model->update($post,$tanggal,$this->input->get('id'))) {
                $insert_id = $model['ID'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])),0777);
                }

                if (!empty($_FILES['doc_ijasah']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath').'doc_pegawai/'.preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_pendidikan_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_ijasah')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name'])) {
                            if (!empty($model['DOC_IJASAH']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_IJASAH'])) {
                                unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_IJASAH']);
                            }
                            $dokumen = ['DOC_IJASAH' => $config['file_name']];
                        } else
                            $dokumen = ['DOC_IJASAH' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_pendidikan_model->update($dokumen,[],$insert_id);
                $pendidikan_mutakhir = $this->master_pegawai_pendidikan_model->pendidikan_mutakhir($model['TMPEGAWAI_ID']);
                                
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success'=>'Record updated successfully.', 'data'=>(isset($pendidikan_mutakhir['TINGKAT_PENDIDIKAN']) && !empty($pendidikan_mutakhir['TINGKAT_PENDIDIKAN'])) ? $pendidikan_mutakhir['TINGKAT_PENDIDIKAN'] : '']);
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
        $list = $this->master_pegawai_pendidikan_model->get_datatables($id);
        $data = array();
        $delete = '';
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $file = '';
            if (!empty($val->DOC_IJASAH) && $val->DOC_IJASAH != "") {
                $file = '<a href="javascript:;" class="btn btn-xs green-haze popupfull" data-url="'. site_url('master_pegawai/master_pegawai_pendidikan/view_dokumen?id='.$val->ID).'" title="Lihat Dokumen"><i class="fa fa-file-pdf-o"></i></a>';
            }
            if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') {
                $delete = '<a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="'. site_url('master_pegawai/master_pegawai_pendidikan/hapus_data').'" data-id="'. $val->ID.'" data-identify="updatependidikanpegawai" title="Hapus Data"><i class="fa fa-trash"></i></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->TINGKAT_PENDIDIKAN;
            $row[] = $val->NAMA_LBGPDK;
            $row[] = $val->NAMA_FAKULTAS;
            $row[] = $val->NAMA_JURUSAN;
            $row[] = $val->NO_STTB;
            $row[] = $val->THN_LULUS;
            $row[] = $file.'<a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_pendidikan/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="'.($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data').'"><i class="fa fa-edit"></i></a>'.$delete.'<a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_pendidikan/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_pendidikan_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_pendidikan_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_pendidikan_model->get_by_id($this->input->post('id'));
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                if ($this->master_pegawai_pendidikan_model->hapus($this->input->post('id'))) {
                    if (!empty($model['DOC_IJASAH']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_IJASAH'])) {
                        unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_IJASAH']);
                    }
                    
                    $pendidikan_mutakhir = $this->master_pegawai_pendidikan_model->pendidikan_mutakhir($model['TMPEGAWAI_ID']);
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.', 'data'=>(isset($pendidikan_mutakhir['TINGKAT_PENDIDIKAN']) && !empty($pendidikan_mutakhir['TINGKAT_PENDIDIKAN'])) ? $pendidikan_mutakhir['TINGKAT_PENDIDIKAN'] : '']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_pendidikan_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_dokumen() {
        $model = $this->master_pegawai_pendidikan_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_IJASAH'])) {
                $this->data['file'] = base_url()."_uploads/doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_IJASAH'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_pendidikan_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/pendidikan/info', $this->data);
    }

}
