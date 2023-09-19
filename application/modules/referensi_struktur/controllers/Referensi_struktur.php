<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi_struktur extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('referensi_struktur/referensi_struktur_model','list_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(),['assets/plugins/bootbox/bootbox.min.js','assets/plugins/select2/js/select2.full.min.js']);
        $this->data['custom_js'] = ['referensi_struktur/js'];
        $this->data['title_utama'] = 'Struktur';
    }

    public function index() {
        $this->data['content'] = 'referensi_struktur/index';
        $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        $this->load->view('layouts/main', $this->data);
    }
    
    public function index_eselon_1() {
        $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        $this->load->view('referensi_struktur/eselon_1', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->data['list_provinsi'] = $this->list_model->list_provinsi();
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            $this->data['list_eselon_bkn'] = $this->list_model->list_eselon_bkn();
            $this->load->view("referensi_struktur/form", $this->data);
        } else {
            redirect('/referensi_struktur');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nmunit', 'Nama Unit Kerja', 'required|min_length[1]|max_length[150]');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|min_length[1]|max_length[5]');
        $this->form_validation->set_rules('eselon', 'Eselon', 'trim|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|min_length[4]|max_length[4]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'max_length[500]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'max_length[500]');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_rules('kd_satker', 'Kode Satker', 'trim|max_length[6]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "NMUNIT" => ltrim(rtrim($this->input->post('nmunit',TRUE))),
                "TRKABUPATEN_ID" => ($this->input->post('kabupaten') == 'null') ? NULL : ltrim(rtrim($this->input->post('kabupaten',TRUE))),
                "TRESELON_ID" => ltrim(rtrim($this->input->post('eselon',TRUE))),
                "TRJABATAN_ID" => ($this->input->post('jabatan') == 'null') ? NULL : ltrim(rtrim($this->input->post('jabatan',TRUE))),
                "ALAMAT" => ltrim(rtrim($this->input->post('alamat',TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                "TKTESELON" => 1,
                "STATUS" => ltrim(rtrim($this->input->post('status',TRUE))),
                "KD_SATKER" => ltrim(rtrim($this->input->post('kd_satker',TRUE))),
                "TRLOKASI_ID" => ltrim(rtrim($this->input->post('trlokasi_id',TRUE))),
                "ID_BKN" => ltrim(rtrim($this->input->post('idbkn',TRUE))),
                "NAMA_UNOR_BKN" => ltrim(rtrim($this->input->post('namaunor',TRUE))),
                "ESELON_ID_BKN" => ltrim(rtrim($this->input->post('eselonbkn',TRUE))),
                "KODE_CEPAT_BKN" => ltrim(rtrim($this->input->post('kodecptbkn',TRUE))),
                "NAMA_JABATAN_BKN" => ltrim(rtrim($this->input->post('namajbtbkn',TRUE))),
                "DIATASAN_ID_BKN" => ltrim(rtrim($this->input->post('idatasanbkn',TRUE))),
                "INSTANSI_ID_BKN" => ltrim(rtrim($this->input->post('instansiidbkn',TRUE))),
                "PEMIMPIN_NON_PNS_BKN" => ltrim(rtrim($this->input->post('nonpnsbkn',TRUE))),
                "PEMIMPIN_PNS_BKN" => ltrim(rtrim($this->input->post('pnsbkn',TRUE))),
                "JENIS_UNOR_BKN" => ltrim(rtrim($this->input->post('jenisunorbkn',TRUE))),
                "UNOR_INDUK_BKN" => ltrim(rtrim($this->input->post('unorindukbkn',TRUE))),
            ];
            if ($this->referensi_struktur_model->insert($post)) {
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $model = $this->referensi_struktur_model->get_by_id($this->input->get('id'));
            $this->data['model'] = array_merge($model, ['TRPROVINSI_ID' => $this->referensi_struktur_model->getprovinsi($model['TRKABUPATEN_ID'])]);
            $this->data['list_provinsi'] = $this->list_model->list_provinsi();
            $this->data['list_kabupaten'] = $this->list_model->list_kabupaten($this->data['model']['TRPROVINSI_ID']);
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            $this->data['list_jabatan'] = $this->list_model->list_jabatan($this->data['model']['TRESELON_ID']);
            $this->data['list_eselon_bkn'] = $this->list_model->list_eselon_bkn();
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("referensi_struktur/form", $this->data);
        } else {
            redirect('/referensi_struktur');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nmunit', 'Nama Unit Kerja', 'required|min_length[1]|max_length[150]');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|min_length[1]|max_length[5]');
        $this->form_validation->set_rules('eselon', 'Eselon', 'trim|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|min_length[4]|max_length[4]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'max_length[500]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'max_length[500]');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_rules('kd_satker', 'Kode Satker', 'trim|max_length[6]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $post = [
                "NMUNIT" => ltrim(rtrim($this->input->post('nmunit',TRUE))),
                "TRKABUPATEN_ID" => ($this->input->post('kabupaten') == 'null') ? NULL : ltrim(rtrim($this->input->post('kabupaten',TRUE))),
                "TRESELON_ID" => ltrim(rtrim($this->input->post('eselon',TRUE))),
                "TRJABATAN_ID" => ltrim(rtrim($this->input->post('jabatan',TRUE))),
                "ALAMAT" => ltrim(rtrim($this->input->post('alamat',TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                "STATUS" => ltrim(rtrim($this->input->post('status',TRUE))),
                "KD_SATKER" => ltrim(rtrim($this->input->post('kd_satker',TRUE))),
                "ID_BKN" => ltrim(rtrim($this->input->post('idbkn',TRUE))),
                "NAMA_UNOR_BKN" => ltrim(rtrim($this->input->post('namaunor',TRUE))),
                "ESELON_ID_BKN" => ltrim(rtrim($this->input->post('eselonbkn',TRUE))),
                "KODE_CEPAT_BKN" => ltrim(rtrim($this->input->post('kodecptbkn',TRUE))),
                "NAMA_JABATAN_BKN" => ltrim(rtrim($this->input->post('namajbtbkn',TRUE))),
                "DIATASAN_ID_BKN" => ltrim(rtrim($this->input->post('idatasanbkn',TRUE))),
                "INSTANSI_ID_BKN" => ltrim(rtrim($this->input->post('instansiidbkn',TRUE))),
                "PEMIMPIN_NON_PNS_BKN" => ltrim(rtrim($this->input->post('nonpnsbkn',TRUE))),
                "PEMIMPIN_PNS_BKN" => ltrim(rtrim($this->input->post('pnsbkn',TRUE))),
                "JENIS_UNOR_BKN" => ltrim(rtrim($this->input->post('jenisunorbkn',TRUE))),
                "UNOR_INDUK_BKN" => ltrim(rtrim($this->input->post('unorindukbkn',TRUE))),
            ];
            if ($this->referensi_struktur_model->update($post,$this->input->get('id'))) {
                echo json_encode(['status' => 1, 'cu' => 'di-ubah', 'success'=>'Record updated successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        $trlokasi_id = empty($_POST['trlokasi_id']) ? $this->referensi_struktur_model->getminlokasi() : $_POST['trlokasi_id'];
        $list = $this->referensi_struktur_model->get_datatables($trlokasi_id,"","","","","",1);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->TRLOKASI_ID."-".$val->KDU1;
            $row[] = $val->NMUNIT;
            $row[] = $val->TRKABUPATEN_ID;
            $row[] = $val->ESELON;
            $row[] = $val->JABATAN;
            $row[] = ($val->STATUS == 1) ? '<span class="label label-sm label-success"> Aktif </span>' : '<span class="label label-sm label-default"> Inaktif </span>';
            $row[] = '<a href="javascript:;" data-url="'. site_url('referensi_struktur/ubah_form?id='.$val->ID).'" class="btndefaultshowtambahubah btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="'. site_url('referensi_struktur/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->referensi_struktur_model->count_all($trlokasi_id,"","","","","",1),
            "recordsFiltered" => $this->referensi_struktur_model->count_filtered($trlokasi_id,"","","","","",1),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function unique_edit() {
        $model = $this->referensi_struktur_model->get_unique_nama_by_id($this->input->get('id'),$this->input->post('negara'));
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
                if ($this->referensi_struktur_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    /*
     * Eselon II
     */
    public function index_eselon_2() {
        $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        $this->data['list_kdu1'] = $this->referensi_struktur_model->list_kdu1($this->referensi_struktur_model->getminlokasi());
        $this->load->view('referensi_struktur/eselon_2', $this->data);
    }
    
    public function ajax_list_eselon_2() {
        $trlokasi_id = (isset($_POST['trlokasi_id']) && !empty($_POST['trlokasi_id'])) ? $this->input->post('trlokasi_id') : $this->referensi_struktur_model->getminlokasi();
        $kdu1 = (isset($_POST['kdu1']) && !empty($_POST['kdu1'])) ? $this->input->post('kdu1') : $this->referensi_struktur_model->getminkdu1($trlokasi_id);
        if (isset($_POST['kdu1']) && !empty($_POST['kdu1'])) {
            $mecah = explode(";;", $_POST['kdu1']);
            $kdu1 = $mecah[0];
        }
        $list = $this->referensi_struktur_model->get_datatables($trlokasi_id,$kdu1,"","","","",2);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->TRLOKASI_ID."-".$val->KDU1."-".$val->KDU2;
            $row[] = $val->NMUNIT;
            $row[] = $val->TRKABUPATEN_ID;
            $row[] = $val->ESELON;
            $row[] = $val->JABATAN;
            $row[] = ($val->STATUS == 1) ? '<span class="label label-sm label-success"> Aktif </span>' : '<span class="label label-sm label-default"> Inaktif </span>';
            $row[] = '<a href="javascript:;" data-url="'. site_url('referensi_struktur/ubah_form_eselon_2?id='.$val->ID).'" class="btndefaultshowtambahubah btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="'. site_url('referensi_struktur/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }
        
        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->referensi_struktur_model->count_all($trlokasi_id,$kdu1,"","","","",2),
            "recordsFiltered" => $this->referensi_struktur_model->count_filtered($trlokasi_id,$kdu1,"","","","",2),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function tambah_form_eselon_2() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->data['list_provinsi'] = $this->list_model->list_provinsi();
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            $this->data['list_eselon_bkn'] = $this->list_model->list_eselon_bkn();
            $this->load->view("referensi_struktur/form_2", $this->data);
        } else {
            redirect('/referensi_struktur');
        }
    }
    
    public function tambah_proses_eselon_2() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nmunit', 'Nama Unit Kerja', 'required|min_length[1]|max_length[150]');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|min_length[1]|max_length[5]');
        $this->form_validation->set_rules('eselon', 'Eselon', 'trim|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|min_length[4]|max_length[4]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'max_length[500]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'max_length[500]');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_rules('kd_satker', 'Kode Satker', 'trim|max_length[6]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $mecah = explode(";;", ltrim(rtrim($this->input->post('kdu1',TRUE))));
            
            $post = [
                "NMUNIT" => ltrim(rtrim($this->input->post('nmunit',TRUE))),
                "TRKABUPATEN_ID" => ($this->input->post('kabupaten') == 'null') ? NULL : ltrim(rtrim($this->input->post('kabupaten',TRUE))),
                "TRESELON_ID" => ltrim(rtrim($this->input->post('eselon',TRUE))),
                "TRJABATAN_ID" => ltrim(rtrim($this->input->post('jabatan',TRUE))),
                "ALAMAT" => ltrim(rtrim($this->input->post('alamat',TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                "TKTESELON" => 2,
                "STATUS" => ltrim(rtrim($this->input->post('status',TRUE))),
                "KD_SATKER" => ltrim(rtrim($this->input->post('kd_satker',TRUE))),
                "TRLOKASI_ID" => ltrim(rtrim($this->input->post('trlokasi_id',TRUE))),
                "KDU1" => ltrim(rtrim($mecah[0])),
                "PARENT_ID" => ltrim(rtrim($mecah[1])),
                "ID_BKN" => ltrim(rtrim($this->input->post('idbkn',TRUE))),
                "NAMA_UNOR_BKN" => ltrim(rtrim($this->input->post('namaunor',TRUE))),
                "ESELON_ID_BKN" => ltrim(rtrim($this->input->post('eselonbkn',TRUE))),
                "KODE_CEPAT_BKN" => ltrim(rtrim($this->input->post('kodecptbkn',TRUE))),
                "NAMA_JABATAN_BKN" => ltrim(rtrim($this->input->post('namajbtbkn',TRUE))),
                "DIATASAN_ID_BKN" => ltrim(rtrim($this->input->post('idatasanbkn',TRUE))),
                "INSTANSI_ID_BKN" => ltrim(rtrim($this->input->post('instansiidbkn',TRUE))),
                "PEMIMPIN_NON_PNS_BKN" => ltrim(rtrim($this->input->post('nonpnsbkn',TRUE))),
                "PEMIMPIN_PNS_BKN" => ltrim(rtrim($this->input->post('pnsbkn',TRUE))),
                "JENIS_UNOR_BKN" => ltrim(rtrim($this->input->post('jenisunorbkn',TRUE))),
                "UNOR_INDUK_BKN" => ltrim(rtrim($this->input->post('unorindukbkn',TRUE))),
            ];
            if ($this->referensi_struktur_model->insert_eselon_2($post)) {
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function ubah_form_eselon_2() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $model = $this->referensi_struktur_model->get_by_id($this->input->get('id'));
            $this->data['model'] = array_merge($model, ['TRPROVINSI_ID' => $this->referensi_struktur_model->getprovinsi($model['TRKABUPATEN_ID'])]);
            $this->data['list_provinsi'] = $this->list_model->list_provinsi();
            $this->data['list_kabupaten'] = $this->list_model->list_kabupaten($this->data['model']['TRPROVINSI_ID']);
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            $this->data['list_jabatan'] = $this->list_model->list_jabatan($this->data['model']['TRESELON_ID']);
            $this->data['list_eselon_bkn'] = $this->list_model->list_eselon_bkn();
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("referensi_struktur/form_2", $this->data);
        } else {
            redirect('/referensi_struktur');
        }
    }
    
    public function geteselonistruktur2() {
        $lists = $this->referensi_struktur_model->list_kdu1($this->input->get('id',TRUE));
        $list = [];
        if ($lists) {
            foreach ($lists as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    /*
     * Eselon III
     */
    public function index_eselon_3() {
        $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        $this->data['list_kdu1'] = $this->referensi_struktur_model->list_kdu1($this->referensi_struktur_model->getminlokasi());
        $this->data['list_kdu2'] = $this->referensi_struktur_model->list_kdu2($this->referensi_struktur_model->getminlokasi(),$this->referensi_struktur_model->getminkdu1($this->referensi_struktur_model->getminlokasi()));
        $this->load->view('referensi_struktur/eselon_3', $this->data);
    }
    
    public function ajax_list_eselon_3() {
        $trlokasi_id = empty($_POST['trlokasi_id']) ? $this->referensi_struktur_model->getminlokasi() : $_POST['trlokasi_id'];
        $kdu1 = empty($_POST['kdu1']) ? $this->referensi_struktur_model->getminkdu1($trlokasi_id) : $_POST['trlokasi_id'];
        $kdu2 = empty($_POST['kdu2']) ? $this->referensi_struktur_model->getminkdu2($trlokasi_id,$kdu1) : $_POST['trlokasi_id'];
        if (isset($_POST['kdu1']) && !empty($_POST['kdu1'])) {
            $mecah = explode(";;", $_POST['kdu1']);
            $kdu1 = $mecah[0];
        }
        if (isset($_POST['kdu2']) && !empty($_POST['kdu2'])) {
            $mecah = explode(";;", $_POST['kdu2']);
            $kdu2 = $mecah[0];
        }
        $list = $this->referensi_struktur_model->get_datatables($trlokasi_id,$kdu1,$kdu2,"","","",3);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->TRLOKASI_ID."-".$val->KDU1."-".$val->KDU2."-".$val->KDU3;
            $row[] = $val->NMUNIT;
            $row[] = $val->TRKABUPATEN_ID;
            $row[] = $val->ESELON;
            $row[] = $val->JABATAN;
            $row[] = ($val->STATUS == 1) ? '<span class="label label-sm label-success"> Aktif </span>' : '<span class="label label-sm label-default"> Inaktif </span>';
            $row[] = '<a href="javascript:;" data-url="'. site_url('referensi_struktur/ubah_form_eselon_3?id='.$val->ID).'" class="btndefaultshowtambahubah btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="'. site_url('referensi_struktur/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }
        
        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->referensi_struktur_model->count_all($trlokasi_id,$kdu1,$kdu2,"","","",3),
            "recordsFiltered" => $this->referensi_struktur_model->count_filtered($trlokasi_id,$kdu1,$kdu2,"","","",3),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function tambah_form_eselon_3() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->data['list_provinsi'] = $this->list_model->list_provinsi();
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            $this->data['list_eselon_bkn'] = $this->list_model->list_eselon_bkn();
            $this->load->view("referensi_struktur/form_3", $this->data);
        } else {
            redirect('/referensi_struktur');
        }
    }
    
    public function tambah_proses_eselon_3() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nmunit', 'Nama Unit Kerja', 'required|min_length[1]|max_length[150]');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|min_length[1]|max_length[5]');
        $this->form_validation->set_rules('eselon', 'Eselon', 'trim|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|min_length[4]|max_length[4]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'max_length[500]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'max_length[500]');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_rules('kd_satker', 'Kode Satker', 'trim|max_length[6]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $mecah = explode(";;", ltrim(rtrim($this->input->post('kdu1',TRUE))));
            $pecah = explode(";;", ltrim(rtrim($this->input->post('kdu2',TRUE))));
            
            $post = [
                "NMUNIT" => ltrim(rtrim($this->input->post('nmunit',TRUE))),
                "TRKABUPATEN_ID" => ($this->input->post('kabupaten') == 'null') ? NULL : ltrim(rtrim($this->input->post('kabupaten',TRUE))),
                "TRESELON_ID" => ltrim(rtrim($this->input->post('eselon',TRUE))),
                "TRJABATAN_ID" => ltrim(rtrim($this->input->post('jabatan',TRUE))),
                "ALAMAT" => ltrim(rtrim($this->input->post('alamat',TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                "TKTESELON" => 3,
                "STATUS" => ltrim(rtrim($this->input->post('status',TRUE))),
                "KD_SATKER" => ltrim(rtrim($this->input->post('kd_satker',TRUE))),
                "TRLOKASI_ID" => ltrim(rtrim($this->input->post('trlokasi_id',TRUE))),
                "KDU1" => ltrim(rtrim($mecah[0])),
                "KDU2" => ltrim(rtrim($pecah[0])),
                "PARENT_ID" => ltrim(rtrim($pecah[1])),
                "ID_BKN" => ltrim(rtrim($this->input->post('idbkn',TRUE))),
                "NAMA_UNOR_BKN" => ltrim(rtrim($this->input->post('namaunor',TRUE))),
                "ESELON_ID_BKN" => ltrim(rtrim($this->input->post('eselonbkn',TRUE))),
                "KODE_CEPAT_BKN" => ltrim(rtrim($this->input->post('kodecptbkn',TRUE))),
                "NAMA_JABATAN_BKN" => ltrim(rtrim($this->input->post('namajbtbkn',TRUE))),
                "DIATASAN_ID_BKN" => ltrim(rtrim($this->input->post('idatasanbkn',TRUE))),
                "INSTANSI_ID_BKN" => ltrim(rtrim($this->input->post('instansiidbkn',TRUE))),
                "PEMIMPIN_NON_PNS_BKN" => ltrim(rtrim($this->input->post('nonpnsbkn',TRUE))),
                "PEMIMPIN_PNS_BKN" => ltrim(rtrim($this->input->post('pnsbkn',TRUE))),
                "JENIS_UNOR_BKN" => ltrim(rtrim($this->input->post('jenisunorbkn',TRUE))),
                "UNOR_INDUK_BKN" => ltrim(rtrim($this->input->post('unorindukbkn',TRUE))),
            ];
            if ($this->referensi_struktur_model->insert_eselon_3($post)) {
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function ubah_form_eselon_3() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $model = $this->referensi_struktur_model->get_by_id($this->input->get('id'));
            $this->data['model'] = array_merge($model, ['TRPROVINSI_ID' => $this->referensi_struktur_model->getprovinsi($model['TRKABUPATEN_ID'])]);
            $this->data['list_provinsi'] = $this->list_model->list_provinsi();
            $this->data['list_kabupaten'] = $this->list_model->list_kabupaten($this->data['model']['TRPROVINSI_ID']);
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            $this->data['list_jabatan'] = $this->list_model->list_jabatan($this->data['model']['TRESELON_ID']);
            $this->data['list_eselon_bkn'] = $this->list_model->list_eselon_bkn();
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("referensi_struktur/form_3", $this->data);
        } else {
            redirect('/referensi_struktur');
        }
    }
    
    public function geteselonistruktur3() {
        $lists = $this->referensi_struktur_model->list_kdu1($this->input->get('id',TRUE));
        $list = [];
        if ($lists) {
            foreach ($lists as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function geteseloniistruktur3() {
        $listkdu1 = $this->list_model->list_kdu1($this->input->get('id',TRUE));
        $kdu1 = $listkdu1[0]['ID'];
        if (isset($_GET['kdu1']) && !empty($_GET['kdu1'])) {
            $mecah = explode(";;", $_GET['kdu1']);
            $kdu1 = $mecah[0];
        }
        $lists = $this->referensi_struktur_model->list_kdu2($this->input->get('id',TRUE),$kdu1);
        $list = [];
        if ($lists) {
            foreach ($lists as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    /*
     * Eselon IV
     */
    public function index_eselon_4() {
        $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        $this->data['list_kdu1'] = $this->referensi_struktur_model->list_kdu1($this->referensi_struktur_model->getminlokasi());
        $this->data['list_kdu2'] = $this->referensi_struktur_model->list_kdu2($this->referensi_struktur_model->getminlokasi(),$this->referensi_struktur_model->getminkdu1($this->referensi_struktur_model->getminlokasi()));
        $this->data['list_kdu3'] = $this->referensi_struktur_model->list_kdu3s($this->referensi_struktur_model->getminlokasi(),$this->referensi_struktur_model->getminkdu1($this->referensi_struktur_model->getminlokasi()),$this->referensi_struktur_model->getminkdu2($this->referensi_struktur_model->getminlokasi(),$this->referensi_struktur_model->getminkdu1($this->referensi_struktur_model->getminlokasi())));
        $this->load->view('referensi_struktur/eselon_4', $this->data);
    }
    
    public function ajax_list_eselon_4() {
        $trlokasi_id = empty($_POST['trlokasi_id']) ? $this->referensi_struktur_model->getminlokasi() : $_POST['trlokasi_id'];
        $kdu1 = empty($_POST['kdu1']) ? $this->referensi_struktur_model->getminkdu1($trlokasi_id) : $_POST['trlokasi_id'];
        $kdu2 = empty($_POST['kdu2']) ? $this->referensi_struktur_model->getminkdu2($trlokasi_id,$kdu1) : $_POST['trlokasi_id'];
        $kdu3 = empty($_POST['kdu3']) ? $this->referensi_struktur_model->getminkdu3($trlokasi_id,$kdu1,$kdu2) : $_POST['trlokasi_id'];
        if (isset($_POST['kdu1']) && !empty($_POST['kdu1'])) {
            $mecah = explode(";;", $_POST['kdu1']);
            $kdu1 = $mecah[0];
        }
        if (isset($_POST['kdu2']) && !empty($_POST['kdu2'])) {
            $mecah = explode(";;", $_POST['kdu2']);
            $kdu2 = $mecah[0];
        }
        if (isset($_POST['kdu3']) && !empty($_POST['kdu3'])) {
            $mecah = explode(";;", $_POST['kdu3']);
            $kdu3 = $mecah[0];
        }
        $list = $this->referensi_struktur_model->get_datatables($trlokasi_id,$kdu1,$kdu2,$kdu3,"","",4);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->TRLOKASI_ID."-".$val->KDU1."-".$val->KDU2."-".$val->KDU3."-".$val->KDU4;
            $row[] = $val->NMUNIT;
            $row[] = $val->TRKABUPATEN_ID;
            $row[] = $val->ESELON;
            $row[] = $val->JABATAN;
            $row[] = ($val->STATUS == 1) ? '<span class="label label-sm label-success"> Aktif </span>' : '<span class="label label-sm label-default"> Inaktif </span>';
            $row[] = '<a href="javascript:;" data-url="'. site_url('referensi_struktur/ubah_form_eselon_4?id='.$val->ID).'" class="btndefaultshowtambahubah btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="'. site_url('referensi_struktur/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }
        
        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->referensi_struktur_model->count_all($trlokasi_id,$kdu1,$kdu2,$kdu3,"","",4),
            "recordsFiltered" => $this->referensi_struktur_model->count_filtered($trlokasi_id,$kdu1,$kdu2,$kdu3,"","",4),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function tambah_form_eselon_4() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->data['list_provinsi'] = $this->list_model->list_provinsi();
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            $this->data['list_eselon_bkn'] = $this->list_model->list_eselon_bkn();
            $this->load->view("referensi_struktur/form_4", $this->data);
        } else {
            redirect('/referensi_struktur');
        }
    }
    
    public function tambah_proses_eselon_4() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nmunit', 'Nama Unit Kerja', 'required|min_length[1]|max_length[150]');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|min_length[1]|max_length[5]');
        $this->form_validation->set_rules('eselon', 'Eselon', 'trim|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|min_length[4]|max_length[4]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'max_length[500]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'max_length[500]');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_rules('kd_satker', 'Kode Satker', 'trim|max_length[6]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $mecah = explode(";;", ltrim(rtrim($this->input->post('kdu1',TRUE))));
            $pecah = explode(";;", ltrim(rtrim($this->input->post('kdu2',TRUE))));
            $belah = explode(";;", ltrim(rtrim($this->input->post('kdu3',TRUE))));
            
            $post = [
                "NMUNIT" => ltrim(rtrim($this->input->post('nmunit',TRUE))),
                "TRKABUPATEN_ID" => ($this->input->post('kabupaten') == 'null') ? NULL : ltrim(rtrim($this->input->post('kabupaten',TRUE))),
                "TRESELON_ID" => ltrim(rtrim($this->input->post('eselon',TRUE))),
                "TRJABATAN_ID" => ltrim(rtrim($this->input->post('jabatan',TRUE))),
                "ALAMAT" => ltrim(rtrim($this->input->post('alamat',TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                "TKTESELON" => 4,
                "STATUS" => ltrim(rtrim($this->input->post('status',TRUE))),
                "KD_SATKER" => ltrim(rtrim($this->input->post('kd_satker',TRUE))),
                "TRLOKASI_ID" => ltrim(rtrim($this->input->post('trlokasi_id',TRUE))),
                "KDU1" => ltrim(rtrim($mecah[0])),
                "KDU2" => ltrim(rtrim($pecah[0])),
                "KDU3" => ltrim(rtrim($belah[0])),
                "PARENT_ID" => $belah[1],
                "ID_BKN" => ltrim(rtrim($this->input->post('idbkn',TRUE))),
                "NAMA_UNOR_BKN" => ltrim(rtrim($this->input->post('namaunor',TRUE))),
                "ESELON_ID_BKN" => ltrim(rtrim($this->input->post('eselonbkn',TRUE))),
                "KODE_CEPAT_BKN" => ltrim(rtrim($this->input->post('kodecptbkn',TRUE))),
                "NAMA_JABATAN_BKN" => ltrim(rtrim($this->input->post('namajbtbkn',TRUE))),
                "DIATASAN_ID_BKN" => ltrim(rtrim($this->input->post('idatasanbkn',TRUE))),
                "INSTANSI_ID_BKN" => ltrim(rtrim($this->input->post('instansiidbkn',TRUE))),
                "PEMIMPIN_NON_PNS_BKN" => ltrim(rtrim($this->input->post('nonpnsbkn',TRUE))),
                "PEMIMPIN_PNS_BKN" => ltrim(rtrim($this->input->post('pnsbkn',TRUE))),
                "JENIS_UNOR_BKN" => ltrim(rtrim($this->input->post('jenisunorbkn',TRUE))),
                "UNOR_INDUK_BKN" => ltrim(rtrim($this->input->post('unorindukbkn',TRUE))),
            ];
            if ($this->referensi_struktur_model->insert_eselon_4($post)) {
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function ubah_form_eselon_4() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $model = $this->referensi_struktur_model->get_by_id($this->input->get('id'));
            $this->data['model'] = array_merge($model, ['TRPROVINSI_ID' => $this->referensi_struktur_model->getprovinsi($model['TRKABUPATEN_ID'])]);
            $this->data['list_provinsi'] = $this->list_model->list_provinsi();
            $this->data['list_kabupaten'] = $this->list_model->list_kabupaten($this->data['model']['TRPROVINSI_ID']);
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            $this->data['list_jabatan'] = $this->list_model->list_jabatan($this->data['model']['TRESELON_ID']);
            $this->data['list_eselon_bkn'] = $this->list_model->list_eselon_bkn();
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("referensi_struktur/form_4", $this->data);
        } else {
            redirect('/referensi_struktur');
        }
    }
    
    public function geteselonistruktur4() {
        $lists = $this->referensi_struktur_model->list_kdu1($this->input->get('id',TRUE));
        $list = [];
        if ($lists) {
            foreach ($lists as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function geteseloniistruktur4() {
        $listkdu1 = $this->list_model->list_kdu1($this->input->get('id',TRUE));
        $kdu1 = $listkdu1[0]['ID'];
        if (isset($_GET['kdu1']) && !empty($_GET['kdu1'])) {
            $mecah = explode(";;", $_GET['kdu1']);
            $kdu1 = $mecah[0];
        }
        $lists = $this->referensi_struktur_model->list_kdu2($this->input->get('id',TRUE),$kdu1);
        $list = [];
        if ($lists) {
            foreach ($lists as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function geteseloniiistruktur4() {
        $trlokasi_id = $this->input->get('id',TRUE);
        if (isset($_GET['kdu1']) && !empty($_GET['kdu1'])) {
            $mecah = explode(";;", $_GET['kdu1']);
            $kdu1 = $mecah[0];
        }
        if (isset($_GET['kdu2']) && !empty($_GET['kdu2'])) {
            $mecah = explode(";;", $_GET['kdu2']);
            $kdu2 = $mecah[0];
        }
        $lists = $this->referensi_struktur_model->list_kdu3s($trlokasi_id,$kdu1,$kdu2);
        $list = [];
        if ($lists) {
            foreach ($lists as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    /*
     * Eselon IV
     */
    public function index_eselon_5() {
        $this->data['list_lokasi'] = json_encode($this->list_model->list_lokasi_tree());
        $trlokasi_id = $this->referensi_struktur_model->getminlokasi();
        $kdu1 = $this->referensi_struktur_model->getminkdu1($trlokasi_id);
        $kdu2 = $this->referensi_struktur_model->getminkdu2($trlokasi_id,$kdu1);
        $kdu3 = $this->referensi_struktur_model->getminkdu3($trlokasi_id,$kdu1,$kdu2);
        $kdu4 = $this->referensi_struktur_model->getminkdu4($trlokasi_id,$kdu1,$kdu2,$kdu3);

        $this->data['list_kdu1'] = $this->referensi_struktur_model->list_kdu1($trlokasi_id);
        $this->data['list_kdu2'] = $this->referensi_struktur_model->list_kdu2($trlokasi_id,$kdu1);
        $this->data['list_kdu3'] = $this->referensi_struktur_model->list_kdu3s($trlokasi_id,$kdu1,$kdu2);
        $this->data['list_kdu4'] = $this->referensi_struktur_model->list_kdu4($trlokasi_id,$kdu1,$kdu2,$kdu3);
        $this->load->view('referensi_struktur/eselon_5', $this->data);
    }
    
    public function ajax_list_eselon_5() {
        $trlokasi_id = empty($_POST['trlokasi_id']) ? $this->referensi_struktur_model->getminlokasi() : $_POST['trlokasi_id'];
        $kdu1 = empty($_POST['kdu1']) ? $this->referensi_struktur_model->getminkdu1($trlokasi_id) : $_POST['kdu1'];
        $kdu2 = empty($_POST['kdu2']) ? $this->referensi_struktur_model->getminkdu2($trlokasi_id,$kdu1) : $_POST['kdu2'];
        $kdu3 = empty($_POST['kdu3']) ? $this->referensi_struktur_model->getminkdu3($trlokasi_id,$kdu1,$kdu2) : $_POST['kdu3'];
        $kdu4 = empty($_POST['kdu4']) ? $this->referensi_struktur_model->getminkdu4($trlokasi_id,$kdu1,$kdu2,$kdu3) : $_POST['kdu4'];
        if (isset($_POST['kdu1']) && !empty($_POST['kdu1'])) {
            $mecah = explode(";;", $_POST['kdu1']);
            $kdu1 = $mecah[0];
        }
        if (isset($_POST['kdu2']) && !empty($_POST['kdu2'])) {
            $mecah = explode(";;", $_POST['kdu2']);
            $kdu2 = $mecah[0];
        }
        if (isset($_POST['kdu3']) && !empty($_POST['kdu3'])) {
            $mecah = explode(";;", $_POST['kdu3']);
            $kdu3 = $mecah[0];
        }
        if (isset($_POST['kdu4']) && !empty($_POST['kdu4'])) {
            $mecah = explode(";;", $_POST['kdu4']);
            $kdu4 = $mecah[0];
        }
        $list = $this->referensi_struktur_model->get_datatables($trlokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,"",5);
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->TRLOKASI_ID."-".$val->KDU1."-".$val->KDU2."-".$val->KDU3."-".$val->KDU4."-".$val->KDU5;
            $row[] = $val->NMUNIT;
            $row[] = $val->TRKABUPATEN_ID;
            $row[] = $val->ESELON;
            $row[] = $val->JABATAN;
            $row[] = ($val->STATUS == 1) ? '<span class="label label-sm label-success"> Aktif </span>' : '<span class="label label-sm label-default"> Inaktif </span>';
            $row[] = '<a href="javascript:;" data-url="'. site_url('referensi_struktur/ubah_form_eselon_5?id='.$val->ID).'" class="btndefaultshowtambahubah btn btn-icon-only yellow-saffron" title="Ubah Data"><i class="fa fa-edit"></i></a><a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="'. site_url('referensi_struktur/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }
        
        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->referensi_struktur_model->count_all($trlokasi_id,$kdu1,$kdu2,$kdu3,"","",4),
            "recordsFiltered" => $this->referensi_struktur_model->count_filtered($trlokasi_id,$kdu1,$kdu2,$kdu3,"","",4),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function tambah_form_eselon_5() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->data['list_provinsi'] = $this->list_model->list_provinsi();
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            $this->data['list_eselon_bkn'] = $this->list_model->list_eselon_bkn();
            $this->load->view("referensi_struktur/form_5", $this->data);
        } else {
            redirect('/referensi_struktur');
        }
    }
    
    public function tambah_proses_eselon_5() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nmunit', 'Nama Unit Kerja', 'required|min_length[1]|max_length[150]');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|min_length[1]|max_length[5]');
        $this->form_validation->set_rules('eselon', 'Eselon', 'trim|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|min_length[4]|max_length[4]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'max_length[500]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'max_length[500]');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_rules('kd_satker', 'Kode Satker', 'trim|max_length[6]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $mecah = explode(";;", ltrim(rtrim($this->input->post('kdu1',TRUE))));
            $pecah = explode(";;", ltrim(rtrim($this->input->post('kdu2',TRUE))));
            $belah = explode(";;", ltrim(rtrim($this->input->post('kdu3',TRUE))));
            $pisah = explode(";;", ltrim(rtrim($this->input->post('kdu4',TRUE))));
            
            $post = [
                "NMUNIT" => ltrim(rtrim($this->input->post('nmunit',TRUE))),
                "TRKABUPATEN_ID" => ($this->input->post('kabupaten') == 'null') ? NULL : ltrim(rtrim($this->input->post('kabupaten',TRUE))),
                "TRESELON_ID" => ltrim(rtrim($this->input->post('eselon',TRUE))),
                "TRJABATAN_ID" => ltrim(rtrim($this->input->post('jabatan',TRUE))),
                "ALAMAT" => ltrim(rtrim($this->input->post('alamat',TRUE))),
                "KETERANGAN" => ltrim(rtrim($this->input->post('keterangan',TRUE))),
                "TKTESELON" => 5,
                "STATUS" => ltrim(rtrim($this->input->post('status',TRUE))),
                "KD_SATKER" => ltrim(rtrim($this->input->post('kd_satker',TRUE))),
                "TRLOKASI_ID" => ltrim(rtrim($this->input->post('trlokasi_id',TRUE))),
                "KDU1" => ltrim(rtrim($mecah[0])),
                "KDU2" => ltrim(rtrim($pecah[0])),
                "KDU3" => ltrim(rtrim($belah[0])),
                "KDU4" => ltrim(rtrim($pisah[0])),
                "PARENT_ID" => ltrim(rtrim($pisah[1])),
                "ID_BKN" => ltrim(rtrim($this->input->post('idbkn',TRUE))),
                "NAMA_UNOR_BKN" => ltrim(rtrim($this->input->post('namaunor',TRUE))),
                "ESELON_ID_BKN" => ltrim(rtrim($this->input->post('eselonbkn',TRUE))),
                "KODE_CEPAT_BKN" => ltrim(rtrim($this->input->post('kodecptbkn',TRUE))),
                "NAMA_JABATAN_BKN" => ltrim(rtrim($this->input->post('namajbtbkn',TRUE))),
                "DIATASAN_ID_BKN" => ltrim(rtrim($this->input->post('idatasanbkn',TRUE))),
                "INSTANSI_ID_BKN" => ltrim(rtrim($this->input->post('instansiidbkn',TRUE))),
                "PEMIMPIN_NON_PNS_BKN" => ltrim(rtrim($this->input->post('nonpnsbkn',TRUE))),
                "PEMIMPIN_PNS_BKN" => ltrim(rtrim($this->input->post('pnsbkn',TRUE))),
                "JENIS_UNOR_BKN" => ltrim(rtrim($this->input->post('jenisunorbkn',TRUE))),
                "UNOR_INDUK_BKN" => ltrim(rtrim($this->input->post('unorindukbkn',TRUE))),
            ];
            if ($this->referensi_struktur_model->insert_eselon_5($post)) {
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }
    
    public function ubah_form_eselon_5() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $model = $this->referensi_struktur_model->get_by_id($this->input->get('id'));
            $this->data['model'] = array_merge($model, ['TRPROVINSI_ID' => $this->referensi_struktur_model->getprovinsi($model['TRKABUPATEN_ID'])]);
            $this->data['list_provinsi'] = $this->list_model->list_provinsi();
            $this->data['list_kabupaten'] = $this->list_model->list_kabupaten($this->data['model']['TRPROVINSI_ID']);
            $this->data['list_eselon'] = $this->list_model->list_eselon();
            $this->data['list_jabatan'] = $this->list_model->list_jabatan($this->data['model']['TRESELON_ID']);
            $this->data['list_eselon_bkn'] = $this->list_model->list_eselon_bkn();
            
            $this->data['title_form'] = "Ubah";
            $this->load->view("referensi_struktur/form_5", $this->data);
        } else {
            redirect('/referensi_struktur');
        }
    }
    
    public function geteselonistruktur5() {
        $lists = $this->referensi_struktur_model->list_kdu1($this->input->get('id',TRUE));
        $list = [];
        if ($lists) {
            foreach ($lists as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function geteseloniistruktur5() {
        $listkdu1 = $this->list_model->list_kdu1($this->input->get('id',TRUE));
        $kdu1 = $listkdu1[0]['ID'];
        if (isset($_GET['kdu1']) && !empty($_GET['kdu1'])) {
            $mecah = explode(";;", $_GET['kdu1']);
            $kdu1 = $mecah[0];
        }
        $lists = $this->referensi_struktur_model->list_kdu2($this->input->get('id',TRUE),$kdu1);
        $list = [];
        if ($lists) {
            foreach ($lists as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function geteseloniiistruktur5() {
        $trlokasi_id = $this->input->get('id',TRUE);
        if (isset($_GET['kdu1']) && !empty($_GET['kdu1'])) {
            $mecah = explode(";;", $_GET['kdu1']);
            $kdu1 = $mecah[0];
        }
        if (isset($_GET['kdu2']) && !empty($_GET['kdu2'])) {
            $mecah = explode(";;", $_GET['kdu2']);
            $kdu2 = $mecah[0];
        }
        $lists = $this->referensi_struktur_model->list_kdu3s($trlokasi_id,$kdu1,$kdu2);
        $list = [];
        if ($lists) {
            foreach ($lists as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function geteselonivstruktur5() {
        $trlokasi_id = $this->input->get('id',TRUE);
        if (isset($_GET['kdu1']) && !empty($_GET['kdu1'])) {
            $mecah = explode(";;", $_GET['kdu1']);
            $kdu1 = $mecah[0];
        }
        if (isset($_GET['kdu2']) && !empty($_GET['kdu2'])) {
            $mecah = explode(";;", $_GET['kdu2']);
            $kdu2 = $mecah[0];
        }
        if (isset($_GET['kdu3']) && !empty($_GET['kdu3'])) {
            $mecah = explode(";;", $_GET['kdu3']);
            $kdu3 = $mecah[0];
        }
        $lists = $this->referensi_struktur_model->list_kdu4($trlokasi_id,$kdu1,$kdu2,$kdu3);
        $list = [];
        if ($lists) {
            foreach ($lists as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }

}
