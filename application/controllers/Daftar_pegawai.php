<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pegawai extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        }
        $this->load->model(array('daftar_pegawai_model'));
    }

    public function listpegawai() {
        $this->data['setelementnya'] = isset($_POST['setelementnya']) ? $this->input->post('setelementnya') : 'popuppilihpegawai';
        $this->data['sex'] = isset($_POST['sex']) ? $this->input->post('sex') : '';
        $this->load->view("daftar_pegawai/listpegawai",$this->data);
    }
    
    public function ajax_listpegawai() {
        if (!$this->input->is_ajax_request()) {
            redirect('master_pegawai/');
        }
        $list = $this->daftar_pegawai_model->get_datatables();
        $data = array();
        $no = ($this->input->post('start')) ? $this->input->post('start') : 0;
        $class = $this->input->post('setelementnya');
        foreach ($list as $val) {
            $nama = ((!empty($val->GELAR_DEPAN)) ? $val->GELAR_DEPAN." ": "").($val->NAMA).((!empty($val->GELAR_BLKG)) ? ", ".$val->GELAR_BLKG : '');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->NIPNEW;
            $row[] = $nama;
            $row[] = $val->N_JABATAN;
            $row[] = '<a href="javascript:;" data-nama="'.$nama.'" data-tgllahir="'.$val->TGLLAHIR.'" '
            . 'data-njabatan="'.$val->N_JABATAN.'" data-idpangkatgol="'.$val->TRGOLONGAN_ID.'" '
            . 'data-pangkatgol="'.($val->TRSTATUSKEPEGAWAIAN_ID == 1 ? $val->PANGKAT . " (" . $val->GOLONGAN . ")" : $val->PANGKAT).'" '
            . 'data-nik="'.$val->NO_KTP.'" data-tptlahir="'.$val->TPTLAHIR.'" data-nip="'.$val->NIPNEW.'" '
            . 'data-treselonid="'.$val->TRESELON_ID.'" data-trjabatanid="'.$val->TRJABATAN_ID.'" data-trlokasiid="'.$val->TRLOKASI_ID.'" '
            . 'data-kdu1="'.$val->KDU1.'" data-kdu2="'.$val->KDU2.'" data-kdu3="'.$val->KDU3.'" '
            . 'data-kdu4="'.$val->KDU4.'" data-kdu5="'.$val->KDU5.'" '
            . 'class="'.$class.' btn btn-circle btn-icon-only green-turquoise" title="Pilih Pegawai"><i class="fa fa-check-square-o"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => ($this->input->post('draw')) ? $this->input->post('draw') : NULL,
            "recordsTotal" => $this->daftar_pegawai_model->count_all(),
            "recordsFiltered" => $this->daftar_pegawai_model->count_filtered(),
            "data" => $data,
            'setelementnya' => $class,
        );

        //output to json format
        echo json_encode($output);
    }

}
