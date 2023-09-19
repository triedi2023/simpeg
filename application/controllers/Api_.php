<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . "libraries/REST_Controller.php";
require APPPATH . 'libraries/Format.php';
//use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller {

     public function login_post() {
        $this->load->model(array('apikepegawaian_model', 'home/home_model'));
        $this->output->enable_profiler(false);

        if (isset($_POST['username']) && isset($_POST['password'])) {
            $Q = $this->home_model->do_login_android($this->input->post('username'));
            if ($Q->num_rows() == 1) {
                $row = $Q->row_array();
                $crypt = new hash_encryption('admin-belant-encrypt');
                $pwd_decode = $crypt->decrypt($row['user_pass']);

                if ($this->input->post('password') == $pwd_decode) {
                    $this->response(array('nip'=>trim($row['nip'])));
                } else {
                    $this->response(array('status' => 'fail', 502));
                }
            } else {
                $this->response(array('status' => 'fail', 502));
            }
        }
    }

    public function pegawai_unitkerja_get() {
        $this->load->model(array('apikepegawaian_model'));

        $lok = $this->get('lok');
        $kdu1 = $this->get('kdu1');
        $kdu2 = $this->get('kdu2');
        $kdu3 = $this->get('kdu3');
        $kdu4 = $this->get('kdu4');
        $kdu5 = $this->get('kdu5');
        $tkt_eselon = $this->get('tkt_eselon');
        $kel_fungsional = $this->get('kel_fungsional');
        $query = $this->apikepegawaian_model->get_pegawai_unitkerja($lok, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5, $tkt_eselon, $kel_fungsional);
        $_venc = $query;
        $this->response($query);
    }

    // referensi
    function strukur_get() {
        $this->load->model(array('apikepegawaian_model'));

        $lok = $this->get('lok');
        $kdu1 = $this->get('kdu1');
        $kdu2 = $this->get('kdu2');
        $kdu3 = $this->get('kdu3');
        $kdu4 = $this->get('kdu4');
        $kdu5 = $this->get('kdu5');
        $query = $this->apikepegawaian_model->get_data_struktur($lok, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
        $this->response($query);
    }

    function pegawai_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $query = $this->apikepegawaian_model->get_data_single($nip);
        // $join = array('foto' => 'test') + $query;
        
        $this->response($query);
    }

    function pegawai_diklat_teknis_get() {
        $this->load->model(array('apikepegawaian_model'));

        $query = $this->apikepegawaian_model->pegawai_diklat_teknis($nip);
        $this->response($query);
    }

    function referensi_kelompok_diklat_teknis_get() {
        $this->load->model(array('apikepegawaian_model'));

        $query = $this->apikepegawaian_model->referensi_kelompok_diklat_teknis();
        $this->response($query);
    }

    function referensi_diklat_teknis_get() {
        $this->load->model(array('apikepegawaian_model'));

        $query = $this->apikepegawaian_model->referensi_diklat_teknis();
        $this->response($query);
    }
    
    function pasangan_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_pasangan($id);
        else
            $query = [];
		
        $this->response($query);
    }
    
    function anak_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_anak($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function ortu_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_ortu($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function saudara_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_saudara($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function cpns_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        if ($nip)
            $query = $this->apikepegawaian_model->get_data_cpns($nip);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function pns_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        if ($nip)
            $query = $this->apikepegawaian_model->get_data_cpns($nip);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function pangkat_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_pangkat($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function jabatan_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_jabatan($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function pendidikan_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_pendidikan($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function gaji_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_gaji($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function belajar_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_belajar($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function seminar_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_seminar($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function organisasi_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_organisasi($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function luarnegeri_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_luarnegeri($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function penghargaan_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_penghargaan($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function sanksi_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_sanksi($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function fungsional_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_fungsional($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function keterangan_lain_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_ket_lain($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function diklat_prajabatan_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_diklat_prajabatan($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function diklat_penjenjangan_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_diklat_penjenjangan($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function diklat_teknis_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_diklat_teknis($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function diklat_fungsional_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_diklat_fungsional($id);
        else
            $query = [];
        
        $this->response($query);
    }
    
    function diklat_lain_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_diklat_lain($id);
        else
            $query = [];
        
        
        $this->response($query);
    }
    
    function ak_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->apikepegawaian_model->get_pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_ak($id);
        else
            $query = [];
        
        
        $this->response($query);
    }

}
