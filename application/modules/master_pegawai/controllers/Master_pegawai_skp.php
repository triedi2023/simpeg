<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_skp extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_skp_model','list_model','master_pegawai/master_pegawai_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['title_utama'] = 'SKP';
    }

    public function index() {
        $this->data['id'] = $this->input->get('id');
        $nippegawai = $this->master_pegawai_model->get_by_id_select($this->data['id'],"NIPNEW");
        $this->load->view('master_pegawai/skp/index', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $this->data['title_form'] = "Tambah";
            $urt = $this->list_model->list_bulan();
            $this->data['list_bulan'] = $urt;
            rsort($urt);
            $this->data['list_bulan_desc'] = $urt;
            $this->data['id'] = $id;
            $this->data['list_jabatan_pegawai'] = $this->master_pegawai_skp_model->list_jabatan_pegawai($_GET['id']);
            $this->data['list_golongan_pegawai'] = $this->master_pegawai_skp_model->list_golongan_pegawai($_GET['id']);
            
            $this->load->view("master_pegawai/skp/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('periode_awal', 'Periode Awal', 'required|trim');
        $this->form_validation->set_rules('periode_akhir', 'Periode Akhir', 'required|trim');
        $this->form_validation->set_rules('periode_tahun', 'Periode Tahun', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('pangkat', 'Pangkat', 'required|trim');
        $this->form_validation->set_rules('nilai_utama', 'Nilai Utama', 'min_length[1]|max_length[10]|trim');
        
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $id = $this->input->get('id');
            $data_pegawai = $this->master_pegawai_model->get_by_id_select($id,"NIPNEW");
            
            $post = [
                "PERIODE_AWAL" => trim($this->input->post('periode_awal',TRUE)),
                "PERIODE_AKHIR" => trim($this->input->post('periode_akhir',TRUE)),
                "PERIODE_TAHUN" => trim($this->input->post('periode_tahun',TRUE)),
                "JABATAN" => trim($this->input->post('jabatan',TRUE)),
                "PANGKAT" => trim($this->input->post('pangkat',TRUE)),
                "IDPEGAWAI" => $id,
                "NIPNEW" => $data_pegawai['NIPNEW']
            ];
            if ($insert = $this->master_pegawai_skp_model->insert($post)) {
                $insert_id = $insert['id'];
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($id,"NIP,NIPNEW");
                
                $detail = [
                    "THPEGAWAISKP_ID" => $insert_id,
                    "NILAI_AKHIR" => trim($this->input->post('nilai_utama',TRUE)),
                ];
                $this->master_pegawai_skp_model->insert_detail($detail);
                
                $prilaku = [
                    "THPEGAWAISKP_ID" => $insert_id,
                    "ORIENTASI_PELAYANAN" => trim($this->input->post('isi_orientasi_pelayanan',TRUE)),
                    "INTEGRITAS" => trim($this->input->post('isi_integritas',TRUE)),
                    "KOMITMEN" => trim($this->input->post('isi_komitmen',TRUE)),
                    "DISIPLIN" => trim($this->input->post('isi_disiplin',TRUE)),
                    "KERJASAMA" => trim($this->input->post('isi_kerjasama',TRUE)),
                    "KEPEMIMPINAN" => trim($this->input->post('isi_kepemimpinan',TRUE)),
                    "KET_ORIENTASI_PELAYANAN" => $this->input->post('kategori_orientasi_pelayanan',TRUE),
                    "KET_INTEGRITAS" => $this->input->post('kategori_integritas',TRUE),
                    "KET_KOMITMEN" => $this->input->post('kategori_komitmen',TRUE),
                    "KET_DISIPLIN" => $this->input->post('kategori_disiplin',TRUE),
                    "KET_KERJASAMA" => $this->input->post('kategori_kerjasama',TRUE),
                    "KET_KEPEMIMPINAN" => $this->input->post('kategori_kepemimpinan',TRUE),
                ];
                $this->master_pegawai_skp_model->insert_perilaku($prilaku);
                
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])),0777);
                }

                if (!empty($_FILES['doc_skp']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath').'doc_pegawai/'.preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_skp_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_skp')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name']))
                            $dokumen = ['DOC_SKP' => $config['file_name']];
                        else
                            $dokumen = ['DOC_SKP' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_skp_model->update_dokumen($dokumen,$insert_id);
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
            if (!isset($_GET['kode']) || empty($_GET['kode'])) {
                redirect('/master_pegawai');
            }
            
            $id = $this->input->get('id');
            $kode = $this->input->get('kode');
            $this->data['title_form'] = "Ubah";
            $this->data['model'] = $this->master_pegawai_skp_model->get_by_id($this->input->get('id'));
            $data_pegawai = $this->master_pegawai_model->get_by_nipnew_select($this->data['model']['NIP_YGDINILAI'],"ID");
            $urt = $this->list_model->list_bulan();
            $this->data['list_bulan'] = $urt;
            rsort($urt);
            $this->data['list_bulan_desc'] = $urt;
            
            $this->data['list_tahun'] = $this->list_model->list_tahun();
            $this->data['list_jabatan_pegawai'] = $this->master_pegawai_skp_model->list_jabatan_pegawai($data_pegawai['ID']);
            $this->data['list_golongan_pegawai'] = $this->master_pegawai_skp_model->list_golongan_pegawai($data_pegawai['ID']);
            $this->data['modeldetail'] = $this->master_pegawai_skp_model->get_detail_by_id($this->input->get('id'));
            $this->data['modelperilaku'] = $this->master_pegawai_skp_model->get_perilaku_by_id($this->input->get('id'));
            
            $this->data['id'] = $id;
            $this->data['kode'] = $kode;
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("master_pegawai/skp/form", $this->data);
        } else {
            redirect('/master_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('periode_awal', 'Periode Awal', 'required|trim');
        $this->form_validation->set_rules('periode_akhir', 'Periode Akhir', 'required|trim');
        $this->form_validation->set_rules('periode_tahun', 'Periode Tahun', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('pangkat', 'Pangkat', 'required|trim');
        $this->form_validation->set_rules('nilai_utama', 'Nilai Utama', 'min_length[1]|max_length[10]|trim');
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
            $data_pegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('kode',TRUE),"NIPNEW");
            
            $post = [
                "PERIODE_AWAL" => trim($this->input->post('periode_awal',TRUE)),
                "PERIODE_AKHIR" => trim($this->input->post('periode_akhir',TRUE)),
                "PERIODE_TAHUN" => trim($this->input->post('periode_tahun',TRUE)),
                "JABATAN" => trim($this->input->post('jabatan',TRUE)),
                "PANGKAT" => trim($this->input->post('pangkat',TRUE)),
                "IDPEGAWAI" => $this->input->get('kode',TRUE),
                "NIPNEW" => $data_pegawai['NIPNEW']
            ];
            
            $model = $this->master_pegawai_skp_model->get_by_id($this->input->get('id'));
            
            if ($this->master_pegawai_skp_model->update($post,$this->input->get('id'))) {
                $detail = [
                    "NILAI_AKHIR" => trim($this->input->post('nilai_utama',TRUE)),
                ];
                $this->master_pegawai_skp_model->update_detail($detail,$this->input->get('id'));
                $prilaku = [
                    "ORIENTASI_PELAYANAN" => trim($this->input->post('isi_orientasi_pelayanan',TRUE)),
                    "INTEGRITAS" => trim($this->input->post('isi_integritas',TRUE)),
                    "KOMITMEN" => trim($this->input->post('isi_komitmen',TRUE)),
                    "DISIPLIN" => trim($this->input->post('isi_disiplin',TRUE)),
                    "KERJASAMA" => trim($this->input->post('isi_kerjasama',TRUE)),
                    "KEPEMIMPINAN" => trim($this->input->post('isi_kepemimpinan',TRUE)),
                    "KET_ORIENTASI_PELAYANAN" => $this->input->post('kategori_orientasi_pelayanan',TRUE),
                    "KET_INTEGRITAS" => $this->input->post('kategori_integritas',TRUE),
                    "KET_KOMITMEN" => $this->input->post('kategori_komitmen',TRUE),
                    "KET_DISIPLIN" => $this->input->post('kategori_disiplin',TRUE),
                    "KET_KERJASAMA" => $this->input->post('kategori_kerjasama',TRUE),
                    "KET_KEPEMIMPINAN" => $this->input->post('kategori_kepemimpinan',TRUE),
                ];
                $cekprilaku = $this->master_pegawai_skp_model->get_perilaku_by_id($this->input->get('id'));
                
                if ($cekprilaku) {
                    $this->master_pegawai_skp_model->update_perilaku($prilaku,$this->input->get('id'));
                } else {
                    $prilaku = [
                        "THPEGAWAISKP_ID" => $this->input->get('id'),
                        "ORIENTASI_PELAYANAN" => trim($this->input->post('isi_orientasi_pelayanan',TRUE)),
                        "INTEGRITAS" => trim($this->input->post('isi_integritas',TRUE)),
                        "KOMITMEN" => trim($this->input->post('isi_komitmen',TRUE)),
                        "DISIPLIN" => trim($this->input->post('isi_disiplin',TRUE)),
                        "KERJASAMA" => trim($this->input->post('isi_kerjasama',TRUE)),
                        "KEPEMIMPINAN" => trim($this->input->post('isi_kepemimpinan',TRUE)),
                        "KET_ORIENTASI_PELAYANAN" => $this->input->post('kategori_orientasi_pelayanan',TRUE),
                        "KET_INTEGRITAS" => $this->input->post('kategori_integritas',TRUE),
                        "KET_KOMITMEN" => $this->input->post('kategori_komitmen',TRUE),
                        "KET_DISIPLIN" => $this->input->post('kategori_disiplin',TRUE),
                        "KET_KERJASAMA" => $this->input->post('kategori_kerjasama',TRUE),
                        "KET_KEPEMIMPINAN" => $this->input->post('kategori_kepemimpinan',TRUE),
                    ];
                    $this->master_pegawai_skp_model->insert_perilaku($prilaku);
                }
                
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('kode'),"NIP,NIPNEW");
                
                $dokumen = [];
                if (!is_dir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])))) {
                    mkdir($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP'])),0777);
                }

                if (!empty($_FILES['doc_skp']['name'])) {
                    $config['upload_path'] = $this->config->item('uploadpath').'doc_pegawai/'.preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']));
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '2048';
                    $config['overwrite'] = true;
                    $config['file_name'] = "doc_skp_".strtotime(date('Y-m-d H:i:s')).".pdf";

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('doc_skp')) {
                        if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$config['file_name'])) {
                            if (!empty($model['DOC_SKP']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SKP'])) {
                                unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SKP']);
                            }
                            $dokumen = ['DOC_SKP' => $config['file_name']];
                        } else
                            $dokumen = ['DOC_SKP' => NULL];
                    }
                    unset($config);
                }
                
                $this->master_pegawai_skp_model->update_dokumen($dokumen,$this->input->get('id'));
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
        $id = $this->master_pegawai_model->get_by_id_select($this->input->get('id', true),"NIPNEW");
        $list = $this->master_pegawai_skp_model->get_datatables($id['NIPNEW']);
        $kode = $this->input->get('id', true);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $file = '';
            if (!empty($val->DOC_SKP) && $val->DOC_SKP != "") {
                $file = '<a href="javascript:;" class="btn btn-xs green-haze popupfull" data-url="'. site_url('master_pegawai/master_pegawai_skp/view_dokumen?id='.$val->ID).'" title="Lihat Dokumen"><i class="fa fa-file-pdf-o"></i></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "Periode ".$val->PERIODE;
            $row[] = $val->PANGKATGOL;
            $row[] = $val->JABATAN;
            $row[] = $file.'<a href="javascript:;" data-url="'. site_url('master_pegawai/master_pegawai_skp/ubah_form?id='.$val->ID."&kode=".$kode).'" class="btndefaultshowtambahubahdetailpegawai btn btn-xs yellow-saffron" title="'.($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') == '3' ? 'Lihat Data' : 'Ubah Data').'"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrowlistdetailpegawai btn btn-xs red" data-url="'. site_url('master_pegawai/master_pegawai_skp/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a><a href="javascript:;" class="popuplarge btn btn-xs grey-cascade" data-url="'. site_url('master_pegawai/master_pegawai_skp/view_info?id='.$val->ID).'" data-id="'. $val->ID.'" title="Info Data"><i class="fa fa-info-circle"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->master_pegawai_skp_model->count_all(),
            "recordsFiltered" => $this->master_pegawai_skp_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                $model = $this->master_pegawai_skp_model->get_by_id($this->input->post('id'));
                $data_pegawai = $this->master_pegawai_model->get_by_id_select($model['TMPEGAWAI_ID'],"NIP,NIPNEW");
                if ($this->master_pegawai_skp_model->hapus($this->input->post('id'))) {
                    if (!empty($model['DOC_SKP']) && file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SKP'])) {
                        unlink($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', trim($data_pegawai['NIP']))."/".$model['DOC_SKP']);
                    }
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->master_pegawai_skp_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('gol_darah'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function view_dokumen() {
        $model = $this->master_pegawai_skp_model->get_dokumen_by_id($this->input->get('id'));
        $this->data['file'] = '';
        if (isset($model['NIP']) && $model['NIP'] != "") {
            if (file_exists($this->config->item('uploadpath')."doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_SKP'])) {
                $this->data['file'] = base_url()."_uploads/doc_pegawai/".preg_replace('/[^A-Za-z0-9\-]/', '-', $model['NIP'])."/".$model['DOC_SKP'];
            }
        }
        $this->data['content'] = 'master_pegawai/dokumen';
        $this->load->view('layouts/pdf', $this->data);
    }
    
    public function view_info() {
        $this->data['model'] = $this->master_pegawai_skp_model->get_account_by_id($this->input->get('id'));
        $this->load->view('master_pegawai/skp/info', $this->data);
    }

}
