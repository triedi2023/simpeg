<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi extends CI_Controller {
     private $data;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('akses/logout', 'refresh');
        }
        $this->load->model(array('list_model'));
        $this->load->helper(array('app_helper'));
    }

    public function getkabupaten() {
        $list_kabupaten = $this->list_model->list_kabupaten($this->input->get('id',TRUE));
        $list[] = ['id'=>'-1', 'text' => '- Pilih -'];
        if ($list_kabupaten) {
            foreach ($list_kabupaten as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getjabatan() {
        $list_kabupaten = $this->list_model->list_jabatan($this->input->get('id',TRUE));
        $list = [];
        if ($list_kabupaten) {
            foreach ($list_kabupaten as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getalasanstatusfungsional() {
        $list_nya = $this->list_model->list_status_alasan_fungsional($this->input->get('id',TRUE));
        $list = [];
        if ($list_nya) {
            foreach ($list_nya as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getnamatandajasa() {
        $listdata = $this->list_model->list_tanda_jasa($this->input->get('id',TRUE));
        $list = [];
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getjenishukuman() {
        $listdata = $this->list_model->list_jenis_hukdis($this->input->get('id',TRUE));
        $list = [];
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getnamadiklat() {
        $listdata = $this->list_model->list_diklat_teknis($this->input->get('id',TRUE));
        $list = [];
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getjenjangdiklatfungsional() {
        $listdata = $this->list_model->list_nama_penjenjangan($this->input->get('id',TRUE),$this->input->get('jenis_diklat',TRUE));
        $list = [];
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getstrukturkdu1() {
        $listdata = $this->list_model->list_kdu1($this->input->get('lokasi_id',TRUE));
        $list = [];
        if (!empty($this->session->userdata('kdu1')) && in_array($this->session->userdata('idgroup'),[1,4])) {
            $list[] = ['id'=>'-1','text'=>'- Pilih Jabatan Pimpinan Tinggi Madya -'];
        }
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getstrukturkdu2() {
        $listdata = $this->list_model->list_kdu2($this->input->get('lokasi_id',TRUE),$this->input->get('kdu1_id',TRUE));
        $list = [];
        if (!empty($this->session->userdata('kdu2')) && in_array($this->session->userdata('idgroup'),[1,4])) {
            $list[] = ['id'=>'-1','text'=>'- Pilih Jabatan Pimpinan Tinggi Pratama -'];
        }
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getstrukturkdu3() {
        $listdata = $this->list_model->list_kdu3($this->input->get('lokasi_id',TRUE),$this->input->get('kdu1_id',TRUE),$this->input->get('kdu2_id',TRUE));
        $list = [];
        if (!empty($this->session->userdata('kdu3')) && (in_array($this->session->userdata('idgroup'),[1,4])) || ($this->session->userdata('idgroup') == 2 && $this->session->userdata('trlokasi_id') < 3)) {
            $list[] = ['id'=>'-1','text'=>'- Pilih Jabatan Administrator -'];
        }
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getstrukturkdu4() {
        $listdata = $this->list_model->list_kdu4($this->input->get('lokasi_id',TRUE),$this->input->get('kdu1_id',TRUE),$this->input->get('kdu2_id',TRUE),$this->input->get('kdu3_id',TRUE));
        $list = [];
        if (!empty($this->session->userdata('kdu4')) && in_array($this->session->userdata('idgroup'),[1,2,4]) && $this->session->userdata('kdu3') != '017') {
            $list[] = ['id'=>'-1','text'=>'- Pilih Pengawas -'];
        }
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getstrukturkdu5() {
        $listdata = $this->list_model->list_kdu5($this->input->get('lokasi_id',TRUE),$this->input->get('kdu1_id',TRUE),$this->input->get('kdu2_id',TRUE),$this->input->get('kdu3_id',TRUE),$this->input->get('kdu4_id',TRUE));
        $list[] = ['id'=>'-1','text'=>'- Pilih Pelaksana (Eselon V) -'];
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getstrukturjabatankdu1() {
        $listdata = $this->list_model->list_kdu1_jabatan($this->input->get('lokasi_id',TRUE));
        $list[] = ['id'=>'-1','text'=>'- Pilih Jabatan Pimpinan Tinggi Madya -'];
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getstrukturjabatankdu2() {
        $listdata = $this->list_model->list_kdu2_jabatan($this->input->get('lokasi_id',TRUE),$this->input->get('kdu1_id',TRUE));
        $list[] = ['id'=>'-1','text'=>'- Pilih Jabatan Pimpinan Tinggi Pratama -'];
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getstrukturjabatankdu3() {
        $listdata = $this->list_model->list_kdu3_jabatan($this->input->get('lokasi_id',TRUE),$this->input->get('kdu1_id',TRUE),$this->input->get('kdu2_id',TRUE));
        $list[] = ['id'=>'-1','text'=>'- Pilih Jabatan Administrator -'];
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getstrukturjabatankdu4() {
        $listdata = $this->list_model->list_kdu4_jabatan($this->input->get('lokasi_id',TRUE),$this->input->get('kdu1_id',TRUE),$this->input->get('kdu2_id',TRUE),$this->input->get('kdu3_id',TRUE));
        $list[] = ['id'=>'-1','text'=>'- Pilih Pengawas -'];
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getstrukturjabatankdu5() {
        $listdata = $this->list_model->list_kdu5_jabatan($this->input->get('lokasi_id',TRUE),$this->input->get('kdu1_id',TRUE),$this->input->get('kdu2_id',TRUE),$this->input->get('kdu3_id',TRUE),$this->input->get('kdu4_id',TRUE));
        $list[] = ['id'=>'-1','text'=>'- Pilih Pelaksana (Eselon V) -'];
        if ($listdata) {
            foreach ($listdata as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }
    
    public function getgolonganbystatus() {
        $fetch = $this->list_model->list_golongan_pangkat($this->input->get('id',TRUE));
        $list = [];
        if ($fetch) {
            foreach ($fetch as $val) {
                $list[] = ['id'=>$val['ID'],'text'=>$val['NAMA']];
            }
        }
        
        echo json_encode(['data'=>$list]);
    }

}