<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_masa_kerja_jabatan_model extends CI_Model {

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
    
    function get_data($lok='2',$kdu1='00',$kdu2='00',$kdu3='000',$kdu4='000',$kdu5='00',$masa_kerja="") {
        
        $where = '';
        $condition = [];
        if (!empty($lok) && $lok != '0') {
            $where .= " AND TSO.TRLOKASI_ID=? ";
            $condition = array_merge($condition, [$lok]);
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND TSO.KDU1=? ";
            $condition = array_merge($condition, [$kdu1]);
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND TSO.KDU2=? ";
            $condition = array_merge($condition, [$kdu2]);
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND TSO.KDU3=? ";
            $condition = array_merge($condition, [$kdu3]);
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND TSO.KDU4=? ";
            $condition = array_merge($condition, [$kdu4]);
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND TSO.KDU5=? ";
            $condition = array_merge($condition, [$kdu5]);
        }
        if (!empty($masa_kerja)) {
            if ($masa_kerja < 6) {
                $where .= " AND AGE_YEAR(SYSDATE,VPJM.TMT_JABATAN)=?";
                $condition = array_merge($condition, [$masa_kerja]);
            } else {
                $where .= " AND AGE_YEAR(SYSDATE,VPJM.TMT_JABATAN)>=?";
                $condition = array_merge($condition, [$masa_kerja]);
            }
        }
        
        $sql = "SELECT TP.ID,TP.NIPNEW,TP.GELAR_DEPAN,TP.NAMA,TP.GELAR_BLKG,TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.GOLONGAN,TRG.PANGKAT,TRE.ESELON, 
        TO_CHAR(VPPM.TMT_GOL,'DD/MM/YYYY') AS TMT_GOL,VPJM.N_JABATAN,TO_CHAR(VPJM.TMT_JABATAN,'DD/MM/YYYY') AS TMT_JABATAN,
        AGE_YEAR(SYSDATE,VPJM.TMT_JABATAN) as TAHUN,AGE_MONTH(SYSDATE,VPJM.TMT_JABATAN) as BULAN,AGE_DAY(SYSDATE,VPJM.TMT_JABATAN) as HARI FROM TR_STRUKTUR_ORGANISASI TSO LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (TSO.TRESELON_ID=VPJM.TRESELON_ID AND 
        TSO.TRJABATAN_ID=VPJM.TRJABATAN_ID AND TSO.TRLOKASI_ID=VPJM.TRLOKASI_ID AND TSO.KDU1=VPJM.KDU1 AND TSO.KDU2=VPJM.KDU2 AND TSO.KDU3=VPJM.KDU3
        AND TSO.KDU4=VPJM.KDU4 AND TSO.KDU5=VPJM.KDU5) JOIN TM_PEGAWAI TP ON (TP.ID=VPJM.TMPEGAWAI_ID) LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON (VPPM.TMPEGAWAI_ID=TP.ID) 
        LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=VPPM.TRGOLONGAN_ID) LEFT JOIN TR_ESELON TRE ON (TRE.ID=VPJM.TRESELON_ID) WHERE 1=1 $where ORDER BY VPJM.TRLOKASI_ID,VPJM.KDU1,VPJM.KDU2,VPJM.KDU3,VPJM.KDU4,VPJM.KDU5";
        $query = $this->db->query($sql,$condition);
        $model = [];
        
        if ($query->result_array()) {
            foreach ($query->result_array() as $val) {
                $model[] = ['GELAR_DEPAN'=>$val['GELAR_DEPAN'],'NAMA'=>$val['NAMA'],'GELAR_BLKG'=>$val['GELAR_BLKG'],'NIPNEW'=>$val['NIPNEW'],'ESELON'=>$val['ESELON'],
                'TRSTATUSKEPEGAWAIAN_ID'=>$val['TRSTATUSKEPEGAWAIAN_ID'],'TMT_GOL'=>$val['TMT_GOL'],'PANGKAT'=>$val['PANGKAT'],'GOLONGAN'=>$val['GOLONGAN'],
                'N_JABATAN'=>$val['N_JABATAN'],'TMT_JABATAN'=>$val['TMT_JABATAN'],'TAHUN'=>$val['TAHUN'],'BULAN'=>$val['BULAN'],'HARI'=>$val['HARI'],'DIKLATPIM'=> $this->get_diklat_penjenjangan($val['ID'])];
            }
        }
        return $model;
    }
    
    function get_diklat_penjenjangan($tmpegawai_id) {
        $sql = "SELECT TTDK.NAMA_JENJANG FROM TH_PEGAWAI_DIKLAT_PENJENJANGAN TPDP LEFT JOIN TR_TINGKAT_DIKLAT_KEPEMIMPINAN TTDK ON (TTDK.ID=TPDP.TRTINGKATDIKLATKEPEMIMPINAN_ID) WHERE TMPEGAWAI_ID=? ORDER BY TTDK.LEVEL_PIM";
        $query = $this->db->query($sql,[$tmpegawai_id]);
        return $query->result_array();
    }

}
