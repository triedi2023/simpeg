<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_fungsional_model extends CI_Model {

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
    
    function get_data($lok='2',$kdu1='00',$kdu2='00',$kdu3='000',$kdu4='000',$kdu5='00',$kelompok_jabatan="",$status="") {
        $where = '';
        $point = '';
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
        if (!empty($kelompok_jabatan) && $kelompok_jabatan != "") {
            $where .= " AND TRKELOMPOKFUNGSIONAL_ID=?";
            $condition = array_merge($condition, [$kelompok_jabatan]);
        }
        if (!empty($status) && $status != "") {
            $point .= " AND TRSTATUSFUNGSIONAL_ID=?";
            $condition = array_merge($condition, [$status]);
        }
        
        if (!empty($status) && $status != "") {
            $sql = "SELECT * FROM V_MON_FUNGSIONAL WHERE 1=1 $where $point ORDER BY MK_THN_TOTAL,MK_BLN_TOTAL";
        } else {
            $sql = "SELECT * FROM V_SUPERVISE_FUNGSIONAL WHERE 1=1 $where ORDER BY MK_THN_TOTAL,MK_BLN_TOTAL";
        }
        
        $query = $this->db->query($sql,$condition);
        
        return $query->result_array();
    }

}
