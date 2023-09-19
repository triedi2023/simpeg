<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_pensiun_model extends CI_Model {

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
    
    function get_data($lok='2',$kdu1='00',$kdu2='00',$kdu3='000',$kdu4='000',$kdu5='00',$gol_pangkat="",$eselon_id="",$bulan="",$tahun='',$bulan1="",$tahun1='') {
        $tahun_sekarang = date('Y');
        $bulan_sekarang = date('m');
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
            $where .= " AND TRGOLONGAN_ID=?";
            $condition = array_merge($condition, [$gol_pangkat]);
        }
        if (!empty($eselon_id) && $eselon_id != "") {
            $where .= " AND TRESELON_ID=?";
            $condition = array_merge($condition, [$eselon_id]);
        }
        
        if (!empty($bulan) && !empty($tahun) && !empty($bulan1) && !empty($tahun1)) {
            $where .= " AND TO_CHAR(TMT_PENSIUN,'YYYY-MM') BETWEEN ('$tahun-$bulan') AND ('$tahun1-$bulan1')";
        } else {
            $where .= " AND TO_CHAR(TMT_PENSIUN,'YYYY-MM') BETWEEN ('$tahun_sekarang-$bulan_sekarang') AND ('$tahun1-$bulan1')";
        }
        
        $sql = "SELECT * FROM V_MONITORING_PENSIUN WHERE TRESELON_ID NOT IN ('17') $where ORDER BY TMT_PENSIUN ASC";
        
        $query = $this->db->query($sql,$condition);
        
        return $query->result_array();
    }

}
