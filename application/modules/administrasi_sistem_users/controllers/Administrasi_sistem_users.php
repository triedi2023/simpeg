<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrasi_sistem_users extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('administrasi_sistem_users/administrasi_sistem_users_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(['assets/plugins/bootbox/bootbox.min.js', 'assets/plugins/select2/js/select2.full.min.js'], list_js_datatable());
        $this->data['title_utama'] = 'User';
        $this->data['plugin_css'] = ['assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
        'assets/plugins/bootstrap-select/css/bootstrap-select.css','assets/plugins/jquery-multi-select/css/multi-select.css'];
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','administrasi_sistem_users/js'];
    }

    public function index() {
        $this->data['content'] = 'administrasi_sistem_users/index';
        $this->data['list_group'] = $this->administrasi_sistem_users_model->list_group();
        $this->load->view('layouts/main', $this->data);
    }

    public function tambah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['title_form'] = "Tambah";
            $this->data['list_group'] = $this->administrasi_sistem_users_model->list_group();
            $this->load->view("administrasi_sistem_users/form", $this->data);
        } else {
            redirect('/administrasi_sistem_users');
        }
    }
    
    public function tambah_proses() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|max_length[100]|is_unique[SYSTEM_USER.USERNAME]');
        $this->form_validation->set_rules('group', 'Group', 'required|max_length[2]');
        $this->form_validation->set_rules('nip', 'NIP', 'required|max_length[18]');
        $this->form_validation->set_rules('nama', 'Nama', 'required|max_length[200]');
        $this->form_validation->set_rules('status', 'Status', 'required|trim|min_length[1]|max_length[1]|integer');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 0,'errors' => $this->form_validation->error_array()]);
        } else {
            $user = [
                "USERNAME" => ltrim(rtrim($this->input->post('username',TRUE))),
                "STATUS" => $this->input->post('status',TRUE)
            ];
            $gabung = [
                "NIP" => ltrim(rtrim($this->input->post('nip',TRUE))),
                "SYSTEMGROUP_ID" => ltrim(rtrim($this->input->post('group',TRUE))),
            ];
            if ($this->administrasi_sistem_users_model->insert($user,$gabung)) {
                echo json_encode(['status' => 1, 'cu' => 'di-tambahkan', 'success'=>'Record added successfully.']);
            } else {
                echo json_encode(['status' => 2, 'cu' => 'di-ubah']);
            }
        }
    }

    public function ajax_list() {
        $list = $this->administrasi_sistem_users_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN." ": "").($val->NAMA).((!empty($val->GELAR_BLKG)) ? " ".$val->GELAR_BLKG : '');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->NAMA_GROUP;
            $row[] = $val->USERNAME;
            $row[] = $val->NIPNEW;
            $row[] = $nama;
            $row[] = $val->N_JABATAN;
            $row[] = ($val->STATUS == 1) ? '<span class="label label-sm label-success"> Aktif </span>' : '<span class="label label-sm label-default"> Inaktif </span>';
            $row[] = '<a href="javascript:;" class="hapusdataperrow btn btn-icon-only red" data-url="'. site_url('administrasi_sistem_users/hapus_data').'" data-id="'. $val->ID.'" title="Hapus Data"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->administrasi_sistem_users_model->count_all(),
            "recordsFiltered" => $this->administrasi_sistem_users_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    public function hapus_data() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('id')) {
                if ($this->administrasi_sistem_users_model->hapus($this->input->post('id'))) {
                    echo json_encode(['status' => 1, 'success'=>'Record delete successfully.']);
                } else {
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }
    
    public function unique_edit() {
        $model = $this->administrasi_sistem_users_model->get_unique_1column_by_id($this->input->get('id'),$this->input->post('jenis_tj'));
        if ($model > 0) {
            $this->form_validation->set_message('unique_edit','Maaf, data sudah ada dalam database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    // input banyak
//    public function list_pegawai_pusat() {
//        $this->load->model(array('Daftar_user_model'));
//        $listpegawaipusat = $this->administrasi_sistem_users_model->cari_pegawai_pusat();
//        
//        $jmltmuserfix = 0;
//        $jmltmusermasuk = 0;
//        $jmltmusergagal = 0;
//        foreach ($listpegawaipusat as $list) {
//            $userpegawai = $this->Daftar_user_model->cari_by_nip($list['NIPNEW']);
//            if (isset($userpegawai)) {
//                if (!empty($userpegawai->NIP) || $userpegawai->NIP != "") {
//                    $unique = $this->administrasi_sistem_users_model->get_unique_column_by_username($userpegawai->USERID);
//                    if ($unique < 1) {
//                        echo $list['NIPNEW']."<br />";
//                        echo $userpegawai->NIP."<br />=========================<br />";
//                        $user = [
//                            "USERNAME" => ltrim(rtrim($userpegawai->USERID)),
//                            "STATUS" => 1
//                        ];
//                        $gabung = [
//                            "NIP" => $list['NIPNEW'],
//                            "SYSTEMGROUP_ID" => 3,
//                        ];
//                        
////                        if ($this->administrasi_sistem_users_model->insert($user,$gabung)) {
////                            $jmltmusermasuk++;
////                        } else {
////                            $jmltmusergagal++;
////                        }
//                        
//                        $jmltmuserfix++;
//                    }
//                }
//            }
//        }
//        echo "Jumlah Fix User = ".$jmltmuserfix.", Sukses = ".$jmltmusermasuk.", Gagal = ".$jmltmusergagal;
//        exit;
//    }

}
