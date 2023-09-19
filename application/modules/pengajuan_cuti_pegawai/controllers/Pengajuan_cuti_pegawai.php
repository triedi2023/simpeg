<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan_cuti_pegawai extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        } else if (!in_array($this->router->fetch_class(), $this->session->get_userdata()['auth'])) {
            show_error("Anda tidak di ijinkan meng-akses halaman ini", 403);
        }
        $this->load->model(array('pengajuan_cuti_pegawai/pengajuan_cuti_pegawai_model','master_pegawai/master_pegawai_cuti_model','list_model'));
        $this->load->helper(array('form','app_helper'));
        $this->data['plugin_js'] = array_merge(list_js_datatable(),['assets/plugins/bootbox/bootbox.min.js','assets/plugins/select2/js/select2.full.min.js']);
        $this->data['custom_js'] = ['layouts/widget/main/js_crud','pengajuan_cuti_pegawai/js'];
        $this->data['title_utama'] = 'Pengajuan Cuti Pegawai';
    }

    public function index() {
        $this->data['content'] = 'pengajuan_cuti_pegawai/index';
        $this->load->view('layouts/main', $this->data);
    }
    
    public function ubah_form() {
        if ($this->input->is_ajax_request()) {
            $this->data['id'] = $this->input->get('id');
            $this->data['model'] = $this->master_pegawai_cuti_model->get_by_id($this->input->get('id'));
            $this->data['list_cuti'] = $this->list_model->list_cuti();
            $this->data['daftar_verifikasi_cuti'] = $this->list_model->daftar_verifikasi_cuti();
            $this->data['title_form'] = "Ubah";
            $this->load->view("pengajuan_cuti_pegawai/form", $this->data);
        } else {
            redirect('/pengajuan_cuti_pegawai');
        }
    }
    
    public function ubah_proses() {
        $this->load->library('form_validation');
        
        $id = $this->input->get('id');
        $model = $this->master_pegawai_cuti_model->get_by_id($this->input->get('id'));
        $statusverifikasi = '';
        $alasanverifikasi = '';
        $bingkai = '';
        $sket = '';

        if (isset($model['STATUS']) && $model['STATUS'] == 1) {
            $statusverifikasi = 'verifikasi_atasan';
            $alasanverifikasi = 'alasan_atasan';
            $bingkai = 'VERIFIKASI_ALASAN';
            $sket = 'VERIFIKASI_ATASAN';
            if ($_POST[$statusverifikasi] == 1) {
                $status = 2;
            }
        }
        if (isset($model['STATUS']) && $model['STATUS'] == 2) {
            $statusverifikasi = 'verifikasi_pejabat';
            $alasanverifikasi = 'alasan_pejabat';
            $bingkai = 'VERIFIKASI_PEJABAT_ALASAN';
            $sket = 'VERIFIKASI_PEJABAT';
            if ($_POST[$statusverifikasi] == 1) {
                $status = 4;
            }
        }
        
        $this->form_validation->set_rules($statusverifikasi, $statusverifikasi, 'required|min_length[1]|max_length[1]');
        $this->form_validation->set_rules($alasanverifikasi, $alasanverifikasi, 'required|trim|min_length[1]|max_length[1000]');
        $this->form_validation->set_error_delimiters('', '</span>');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('pesan', "Anda belum melengkapi data.");
            redirect('pengajuan_cuti_pegawai');
        } else {
            $post = [
                $sket => ltrim(rtrim($this->input->post($statusverifikasi,TRUE))),
                $bingkai => ltrim(rtrim($this->input->post($alasanverifikasi,TRUE))),
                "STATUS" => $status
            ];
            if ($this->pengajuan_cuti_pegawai_model->update($post,$this->input->get('id'))) {
                redirect('pengajuan_cuti_pegawai');
            } else {
                redirect('pengajuan_cuti_pegawai');
            }
        }
    }

    public function ajax_list() {
        $list = $this->pengajuan_cuti_pegawai_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        foreach ($list as $val) {
            $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN." ": "").($val->NAMA).((!empty($val->GELAR_BLKG)) ? ", ".$val->GELAR_BLKG : '');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->NAMA_CUTI;
            $row[] = $nama;
            $row[] = $val->NIPNEW;
            $row[] = $val->N_JABATAN;
            $row[] = $val->TGL_PENGAJUAN2;
//            $row[] = ($val->STATUS == 1) ? '<span class="label label-sm label-success"> Aktif </span>' : '<span class="label label-sm label-default"> Inaktif </span>';
            $row[] = '<a href="javascript:;" data-url="'. site_url('pengajuan_cuti_pegawai/ubah_form?id='.$val->ID).'" class="popupfull btn btn-icon-only yellow-saffron" title="Verifikasi Data"><i class="fa fa-check"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->pengajuan_cuti_pegawai_model->count_all(),
            "recordsFiltered" => $this->pengajuan_cuti_pegawai_model->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
    
    

}
