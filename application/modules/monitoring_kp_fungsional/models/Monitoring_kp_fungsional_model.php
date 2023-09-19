<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_kp_fungsional_model extends CI_Model {

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
    
    function get_data($lok='2',$kdu1='00',$kdu2='00',$kdu3='000',$kdu4='000',$kdu5='00',$jenis_pangkat="1",$gol_pangkat="",$bulan="",$tahun='') {
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
        
        if (!empty($bulan) && !empty($tahun)) {
            $param = "$tahun-$bulan-01";
            $param2 = "01/$bulan/$tahun";
        } else {
            $param = "$tahun_sekarang-$bulan_sekarang-01";
            $param2 = "01/$bulan_sekarang/$tahun_sekarang";
        }
        
        if (!empty($jenis_pangkat) && $jenis_pangkat == 1) {
            $sql = "SELECT * FROM TABLE(F_MON_KP_FUNGSIONAL('$param')) WHERE 1=1 $where ";
        }
        
        $query = $this->db->query($sql,$condition);
        
        return $query->result_array();
    }

}
