<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik_diklat_teknis_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_struktur($lok='2',$kdu1='00',$kdu2='00',$kdu3='000',$kdu4='000',$kdu5='00') {
        $param = $lok.";".$kdu1.";".$kdu2.";".$kdu3.";".$kdu4.";".$kdu5;
        $sql = "SELECT F_GET_UNITKERJA_KODEREF('$param') AS NMSTRUKTUR FROM DUAL";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    
    function get_data($lok='2',$kdu1='00',$kdu2='00',$kdu3='000',$kdu4='000',$kdu5='00') {
        $where = '';
        $condition = [];
        if (!empty($lok) && $lok != '0') {
            $where .= " AND TRLOKASI_ID=? ";
            $condition = array_merge($condition, [$lok]);
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND KDU1=? ";
            $condition = array_merge($condition, [$kdu1]);
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND KDU2=? ";
            $condition = array_merge($condition, [$kdu2]);
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND KDU3=? ";
            $condition = array_merge($condition, [$kdu3]);
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND KDU4=? ";
            $condition = array_merge($condition, [$kdu4]);
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND KDU5=? ";
            $condition = array_merge($condition, [$kdu5]);
        }
        
        $sql = "SELECT NAMA_DIKLAT,TRDIKLATTEKNIS_ID,count(case when SEX = 'P' THEN 1 else null end) as jumlah_p, 
        count(case when SEX = 'L' THEN 1 else null end) as jumlah_l FROM V_DIKLAT_TEKNIS WHERE 1=1 $where GROUP BY NAMA_DIKLAT,TRDIKLATTEKNIS_ID ORDER BY NAMA_DIKLAT";
        
        $query = $this->db->query($sql,$condition);
        
        $pokok = $query->result_array();
        
        return $query->result_array();
    }
    
    function get_data_detail($table = FAlSE, $clause = FALSE, $order = FALSE, $type_order = 'DESC') {
        if ($table == 'pendidikan') {
            $this->db->select('TTP.TINGKAT_PENDIDIKAN, TRJ.NAMA_JURUSAN');
            $this->db->from('V_PEGAWAI_PENDIDIKAN_MUTAKHIR VPPM');
            $this->db->join('TR_TINGKAT_PENDIDIKAN TTP', 'VPPM.TRTINGKATPENDIDIKAN_ID = TTP.ID', 'left');
            $this->db->join('TR_JURUSAN TRJ', 'VPPM.TRJURUSAN_ID = TRJ.ID', 'left');
            $this->db->where("VPPM.TMPEGAWAI_ID",$clause['TMPEGAWAI_ID']);
            return $this->db->get()->result_array();
        } else if ($table == 'diklat_fungsional') {
            $query = $this->db->query("SELECT TJDF.JENIS_DIKLAT_FUNGSIONAL,TRKF.KELOMPOK_FUNGSIONAL,TRPF.PENJENJANGAN_FUNGSIONAL,TRNP.NAMA_PENJENJANGAN
            FROM TH_PEGAWAI_DIKLAT_FUNGSIONAL TPDF LEFT JOIN TR_JENIS_DIKLAT_FUNGSIONAL TJDF on(TPDF.TRJENISDIKLATFUNGSIONAL_ID=TJDF.ID)
            LEFT JOIN TR_PENJENJANGAN_FUNGSIONAL TRPF ON (TPDF.TRPENJENJANGANFUNGSIONAL_ID=TRPF.ID) 
            LEFT JOIN TR_KELOMPOK_FUNGSIONAL TRKF ON (TPDF.TRKELOMPOKFUNGSIONAL_ID=TRKF.ID) 
            LEFT JOIN TR_NAMA_PENJENJANGAN TRNP ON (TPDF.TRNAMAPENJENJANGAN_ID=TRNP.ID) 
            WHERE TPDF.TMPEGAWAI_ID=? order by TPDF.TGL_STTPP DESC",[$clause['TMPEGAWAI_ID']]);
            return $query->result_array();
        } else if ($table == 'diklat_teknis') {
            $query = $this->db->query("select KETERANGAN FROM TH_PEGAWAI_DIKLAT_TEKNIS WHERE TMPEGAWAI_ID=? order by TGL_STTPP DESC",[$clause['TMPEGAWAI_ID']]);
            return $query->result_array();
        } else if ($table == 'diklat_lain') {
            $query = $this->db->query("select NAMA_DIKLAT from TH_PEGAWAI_DIKLAT_LAIN a where TMPEGAWAI_ID=? order by TGL_STTPP DESC",[$clause['TMPEGAWAI_ID']]);
            return $query->result_array();
        } else if ($table == 'diklat_pim') {
            $query = $this->db->query("select NAMA_JENJANG,THN_DIKLAT from TH_PEGAWAI_DIKLAT_PENJENJANGAN TPDP LEFT JOIN TR_TINGKAT_DIKLAT_KEPEMIMPINAN TTDK ON (TTDK.ID=TPDP.TRTINGKATDIKLATKEPEMIMPINAN_ID) where TMPEGAWAI_ID=? order by THN_DIKLAT DESC",[$clause['TMPEGAWAI_ID']]);
            return $query->result_array();
        } else if ($table == 'dtl_jabatan') {
            $query = $this->db->query("select N_JABATAN,TO_CHAR(TMT_JABATAN,'DD/MM/YYYY') AS TMT_JABATAN,TO_CHAR(TMT_ESELON,'DD/MM/YYYY') AS TMT_ESELON from TH_PEGAWAI_JABATAN TPJ where TMPEGAWAI_ID=? ORDER BY TMT_JABATAN DESC",[$clause['TMPEGAWAI_ID']]);
            return $query->result_array();
        }
    }

}
