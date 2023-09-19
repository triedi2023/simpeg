<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_gaji extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_gaji_model', 'list_model', 'master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form', 'app_helper'));
        $this->data['title_utama'] = 'Gaji Pegawai';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'),"NIPNEW");
        $this->load->view('master_pegawai/gaji/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }

            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $this->data['list_golongan'] = $this->master_pegawai_gaji_model->list_golongan_pegawai($id);
            $this->data['id'] = $id;

            $this->load->view("master_pegawai/gaji/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pangkat_id', 'Pangkat / Golongan', 'required|min_length[3]|max_length[3]|trim');
        $this->form_validation->set_rules('tmt_kgb', 'Tmt KGB', 'required|min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('gaji_baru', 'Gaji Baru', 'trim');
        $this->form_validation->set_rules('pejabat_sk', 'Pejabat SK', 'min_length[1]|max_length[300]');
        $this->form_validation->set_rules('no_sk', 'No SK', 'min_length[1]|max_length[128]');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('no_skep', 'No SKEP', 'min_length[1]|max_length[128]');
        $this->form_validation->set_rules('tgl_skep', 'Tgl SKEP', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tempat', 'Tempat Penetapan', 'max_length[128]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0, 'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');

            $post = [
                "TRGOLONGAN_ID" => trim($this->input->post('pangkat_id', TRUE)),
                'TMPEGAWAI_ID' => $id,
                "GAPOK" => ltrim(rtrim($this->input->post('gaji_baru', TRUE))),
                "NO_SK" => ltrim(rtrim($this->input->post('no_sk', TRUE))),
                "PEJABAT_SK" => ltrim(rtrim($this->input->post('pejabat_sk', TRUE))),
                "NO_SKEP" => ltrim(rtrim($this->input->post('no_skep', TRUE))),
                "TEMPAT_PENETAPAN" => ltrim(rtrim($this->input->post('tempat', TRUE))),
            ];
            $tanggal = [
                "TMT_KGB" => datepickertodb(trim($this->input->post('tmt_kgb', TRUE))),
                "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk', TRUE))),
                "TGL_SKEP" => datepickertodb(trim($this->input->post('tgl_skep', TRUE))),
            ];
            
            if ($insert = $this->master_pegawai_gaji_model->insert($post, $tanggal)) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id, "NIP,NIPNEW");

                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])), 0777);
                }

                if (!empty($_FILES['doc_sk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_kgb_" . strtotime(date('Y-m-d H:i:s')) . ".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $config['file_name']))
                            $dokumen = ['DOC_SKKGB' => $config['file_name']];
                        else
                            $dokumen = ['DOC_SKKGB' => NULL];
                    }
                    unset($config);
                }

                $this->master_pegawai_gaji_model->update($dokumen, [], $insert_id);                
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success' => 'Record added successfully.', 'data' => (isset($jabatan_mutakhir) && !empty($jabatan_mutakhir['N_JABATAN'])) ? $jabatan_mutakhir['N_JABATAN'] : '-']);
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
            $kode = $this->input->get('kode');
            $this->data['title_form'] = "Ubah";
            $this->data['model'] = $this->master_pegawai_gaji_model->get_by_id($this->input->get('id'));
            $this->data['list_golongan'] = $this->master_pegawai_gaji_model->list_golongan_pegawai($this->data['model']['TMPEGAWAI_ID']);
            $this->data['id'] = $id;

            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/gaji/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }

    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pangkat_id', 'Pangkat / Golongan', 'required|min_length[3]|max_length[3]|trim');
        $this->form_validation->set_rules('tmt_kgb', 'Tmt KGB', 'required|min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('gaji_baru', 'Gaji Baru', 'trim');
        $this->form_validation->set_rules('pejabat_sk', 'Pejabat SK', 'min_length[1]|max_length[300]');
        $this->form_validation->set_rules('no_sk', 'No SK', 'min_length[1]|max_length[128]');
        $this->form_validation->set_rules('tgl_sk', 'Tgl SK', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('no_skep', 'No SKEP', 'min_length[1]|max_length[128]');
        $this->form_validation->set_rules('tgl_skep', 'Tgl SKEP', 'min_length[10]|max_length[10]|trim');
        $this->form_validation->set_rules('tempat', 'Tempat Penetapan', 'max_length[128]');
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
                "TRGOLONGAN_ID" => trim($this->input->post('pangkat_id', TRUE)),
                "GAPOK" => ltrim(rtrim($this->input->post('gaji_baru', TRUE))),
                "NO_SK" => ltrim(rtrim($this->input->post('no_sk', TRUE))),
                "PEJABAT_SK" => ltrim(rtrim($this->input->post('pejabat_sk', TRUE))),
                "NO_SKEP" => ltrim(rtrim($this->input->post('no_skep', TRUE))),
                "TEMPAT_PENETAPAN" => ltrim(rtrim($this->input->post('tempat', TRUE))),
            ];
            $tanggal = [
                "TMT_KGB" => datepickertodb(trim($this->input->post('tmt_kgb', TRUE))),
                "TGL_SK" => datepickertodb(trim($this->input->post('tgl_sk', TRUE))),
                "TGL_SKEP" => datepickertodb(trim($this->input->post('tgl_skep', TRUE))),
            ];
            
            if ($this->master_pegawai_gaji_model->update($post, $tanggal, $this->input->get('kode'))) {
                $insert_id = $this->input->get('kode');
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id'), "NIP,NIPNEW");

                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])), 0777);
                }

                if (!empty($_FILES['doc_sk']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath') . 'doc_pegawai/' . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_jabatan_" . strtotime(date('Y-m-d H:i:s')) . ".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_sk')) {
                        if (file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $config['file_name'])) {
                            if (!empty($model['DOC_SKKGB']) && file_exists($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $model['DOC_SKKGB'])) {
                                unlink($this->config->item('uploadpath') . "doc_pegawai/" . preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])) . "/" . $model['DOC_SKKGB']);
                            }
                            $dokumen = ['DOC_SKKGB' => $config['file_name']];
                        } else
                            $dokumen = ['DOC_SKKGB' => NULL];
                    }
                    unset($config);
                }

                $this->master_pegawai_gaji_model->update($dokumen, [], $insert_id);                
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
        $list = $this->master_pegawai_gaji_model->get_datatables($id);
        $data = array();
        $delete = '';
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $file = '';
            if (!empty($val->DOC_SKKGB) && $val->DOC_SKKGB != "") {
                $file = '<a href="javascript:;" class="btn btn-xs green-haze popupfull" data-url="'. site_url('master_pegawai/master_pegawai_gaji/view_dokumen?id='.$val->ID).'" title="Lihat Dokumen"><i class="fa fa-file-pdf-o"></i></a>';
            }
            if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') {
                $delete = '<a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="' . site_url('master_pegawai/master_pegawai_gaji/hapus_data') . '" data-id="' . $val->ID . '" data-identify="updatejabatanpegawai" title="Hapus Data"><i class="fa fa-trash"></i></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->NO_SK;
            $row[] = $val->TMT_KGB2;
            $row[] = $val->TGL_SK2;
            $row[] = ($val->TRSTATUSKEPEGAWAIAN_ID == '1') ? $val->PANGKAT." (".$val->GOLONGAN.") " : $val->PANGKAT;
            $row[] = $val->GAPOK;
            $row[] = $file.'<a href="javascript:;" data-url="' . site_url('master_pegawai/master_pegawai_gaji/ubah_form?id=' . $val->ID) . '" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="'.($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data').'"><i class="fa fa-edit"></i></a>'.$delete.'<a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_gaji/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_gaji_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_gaji_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_gaji_model->get_by_id($this->input->post('id'));
                if ($this->master_pegawai_gaji_model->hapus($this->input->post('id'))) {
                    $nippegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIPNEW");
                    echo json_encode(['status' => 1, 'success' => 'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

    public function unique_edit() {
        $model = $this->master_pegawai_gaji_model->get_unique_nama_by_id($this->input->get('id'), $this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit', 'Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_dokumen() {
        $model = $this->master_pegawai_gaji_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_SKKGB'])) {
                $this->data['file'] = base_url()."_uploads/doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_SKKGB'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_gaji_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/gaji/info', $this->data);
    }

}
