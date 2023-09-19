<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_drh extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('master_pegawai/master_pegawai_model','laporan_drh/laporan_drh_model','list_model'));
        $this->data['title_utama'] = 'DRH';
    }

    public function index() {
        $pegawai = $this->master_pegawai_model->get_by_id_select($this->input->get('id',TRUE),"NIPNEW");
        $nip = $pegawai['NIPNEW'];

        $this->data['pegawai'] = $this->laporan_drh_model->get_data_pegawai($nip);
        $this->data['pegawai_pendidikan'] = $this->laporan_drh_model->get_data_pegawai_pendidikan($this->data['pegawai']['ID']);
        $this->data['pegawai_prajabatan'] = $this->laporan_drh_model->get_data_pegawai_prajabatan($this->data['pegawai']['ID']);
        $this->data['pegawai_penjenjangan'] = $this->laporan_drh_model->get_data_pegawai_penjenjangan($this->data['pegawai']['ID']);
        $this->data['pegawai_diklat_teknis'] = $this->laporan_drh_model->get_data_pegawai_diklat_teknis($this->data['pegawai']['ID']);
        $this->data['pegawai_diklat_fungsional'] = $this->laporan_drh_model->get_data_pegawai_diklat_fungsional($this->data['pegawai']['ID']);
        $this->data['pegawai_diklat_lain'] = $this->laporan_drh_model->get_data_pegawai_diklat_lain($this->data['pegawai']['ID']);
        $this->data['pegawai_kursus'] = $this->laporan_drh_model->get_data_pegawai_kursus($this->data['pegawai']['ID']);
        $this->data['pegawai_pangkat'] = $this->laporan_drh_model->get_data_pegawai_pangkat($this->data['pegawai']['ID']);
        $this->data['pegawai_jabatan'] = $this->laporan_drh_model->get_data_pegawai_jabatan($this->data['pegawai']['ID']);
        $this->data['pegawai_penghargaan'] = $this->laporan_drh_model->get_data_pegawai_penghargaan($this->data['pegawai']['ID']);
        $this->data['pegawai_luar_negeri'] = $this->laporan_drh_model->get_data_pegawai_luar_negeri($this->data['pegawai']['ID']);
        $this->data['pegawai_pasangan'] = $this->laporan_drh_model->get_data_pegawai_pasangan($this->data['pegawai']['ID']);
        $this->data['pegawai_anak'] = $this->laporan_drh_model->get_data_pegawai_anak($this->data['pegawai']['ID']);
        $this->data['pegawai_ortu_kandung'] = $this->laporan_drh_model->get_data_pegawai_ortu_kandung($this->data['pegawai']['ID']);
        $this->data['pegawai_ortu_mertua'] = $this->laporan_drh_model->get_data_pegawai_ortu_mertua($this->data['pegawai']['ID']);
        $this->data['pegawai_saudara'] = $this->laporan_drh_model->get_data_pegawai_saudara($this->data['pegawai']['ID']);
        $this->data['pegawai_organisasi'] = $this->laporan_drh_model->get_data_pegawai_organisasi($this->data['pegawai']['ID']);
        $this->data['pegawai_perguruan'] = $this->laporan_drh_model->get_data_pegawai_perguruan($this->data['pegawai']['ID']);
        $this->data['pegawai_pns'] = $this->laporan_drh_model->get_data_pegawai_pns($this->data['pegawai']['ID']);
        $this->data['pegawai_keterangan'] = $this->laporan_drh_model->get_data_pegawai_keterangan($this->data['pegawai']['ID']);
        $this->data['list_bulan'] = $this->list_model->list_bulan();
        
        $this->load->view("laporan_drh/_hasil", $this->data);
    }

}
