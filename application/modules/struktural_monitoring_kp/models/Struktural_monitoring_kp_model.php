<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Struktural_monitoring_kp_model extends CI_Model {

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
    
    function get_data($lok='2',$kdu1='00',$kdu2='00',$kdu3='000',$kdu4='000',$kdu5='00',$jenis_pangkat="1",$gol_pangkat="",$eselon_id="",$bulan="",$tahun='') {
        $tahun_sekarang = date('Y');
        $bulan_sekarang = date('m');
        $point = '';
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
        if (!empty($gol_pangkat) && $gol_pangkat != "") {
            $point .= " AND TRGOLONGAN_ID=?";
            $condition = array_merge($condition, [$gol_pangkat]);
        }
        if (!empty($eselon_id) && $eselon_id != "") {
            $point .= " AND TRESELON_ID=?";
            $condition = array_merge($condition, [$eselon_id]);
        }
        
        if (!empty($bulan) && !empty($tahun)) {
            $param = "$tahun-$bulan-01";
            $param2 = "01/$bulan/$tahun";
        } else {
            $param = "$tahun_sekarang-$bulan_sekarang-01";
            $param2 = "01/$bulan_sekarang/$tahun_sekarang";
        }
        
        if (!empty($jenis_pangkat) && $jenis_pangkat == 1) {
            $sql = "SELECT * FROM TABLE(f_mon_kp_reguler('$param')) WHERE TRESELON_ID NOT IN ('13','15','17') $where  ORDER BY TMT_GOL_ASLI";
        } else {
            $sql = "SELECT SUBQUERY.*,
                CASE 
                when SUBQUERY.USIA_GOLONGAN >= 1 AND SUBQUERY.USIA_JABATAN >= 1 AND SUBQUERY.GOL_URUTAN < SUBQUERY.GOL_URUTAN_TERENDAH then SUBQUERY.GOL_TERENDAH
                when SUBQUERY.USIA_GOLONGAN >= 4  AND SUBQUERY.GOL_URUTAN = SUBQUERY.GOL_URUTAN_TERENDAH AND SUBQUERY.GOL_URUTAN < SUBQUERY.GOL_URUTAN_TERTINGGI then SUBQUERY.GOL_TERTINGGI
                END as GOLONGAN_LAMA
                FROM (SELECT TP.NIP AS NIP,TP.NIPNEW,TP.GELAR_DEPAN,TP.NAMA,TP.GELAR_BLKG,TTP.TINGKAT_PENDIDIKAN,to_char(TP.TGLLAHIR, 'DD/MM/YYYY') as TGL_LAHIR,
                AGE_YEAR(SYSDATE,TP.TGLLAHIR) || ' Tahun ' || AGE_MONTH(SYSDATE,TP.TGLLAHIR) || ' Bulan' AS UMUR,VPJM.N_JABATAN,to_char(VPJM.TMT_JABATAN, 'DD/MM/YYYY') as TMT_JABATAN,
                TRG.GOLONGAN AS TRGOLONGAN,to_char(VPPM.TMT_GOL, 'DD/MM/YYYY') as TMT_GOL_ASLI,AGE_YEAR(TO_DATE('$param','YYYY-MM-DD'),VPPM.TMT_GOL) as USIA_GOLONGAN,TRL.GOLONGAN AS GOL_TERENDAH,TRN.GOLONGAN AS GOL_TERTINGGI,
                AGE_YEAR(TO_DATE('$param','YYYY-MM-DD'),VPJM.TMT_JABATAN) as USIA_JABATAN,TRG.URUTAN AS GOL_URUTAN,TRL.URUTAN AS GOL_URUTAN_TERENDAH,TRN.URUTAN AS GOL_URUTAN_TERTINGGI,'$param2' as NEXT_TMT_KP_CHAR
                FROM TM_PEGAWAI TP 
                JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON (VPPM.TMPEGAWAI_ID=TP.ID) LEFT JOIN TR_GOLONGAN TRG ON VPPM.TRGOLONGAN_ID=TRG.ID
                JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR VPEM ON VPEM.TMPEGAWAI_ID=TP.ID LEFT JOIN TR_TINGKAT_PENDIDIKAN TTP ON TTP.ID = VPEM.TRTINGKATPENDIDIKAN_ID
                JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON VPJM.TMPEGAWAI_ID=TP.ID LEFT JOIN TR_JABATAN TRJ ON TRJ.ID = VPJM.TRJABATAN_ID
                LEFT JOIN TR_GOLONGAN TRL ON TRJ.TRGOLONGAN_ID_R=TRL.ID LEFT JOIN TR_GOLONGAN TRN ON TRJ.TRGOLONGAN_ID_T=TRN.ID 
                WHERE VPJM.TRESELON_ID NOT IN ('13','15','16','17') $where
            ) SUBQUERY WHERE (SUBQUERY.USIA_GOLONGAN >= 1 AND SUBQUERY.USIA_JABATAN >= 1 AND SUBQUERY.GOL_URUTAN < SUBQUERY.GOL_URUTAN_TERENDAH) OR 
            (SUBQUERY.USIA_GOLONGAN >= 4 AND SUBQUERY.GOL_URUTAN = SUBQUERY.GOL_URUTAN_TERENDAH AND SUBQUERY.GOL_URUTAN < SUBQUERY.GOL_URUTAN_TERTINGGI) $point ORDER BY TMT_GOL_ASLI";
        }
        
        $query = $this->db->query($sql,$condition);
        
        return $query->result_array();
    }

}
