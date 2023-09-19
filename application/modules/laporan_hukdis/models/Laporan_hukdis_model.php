<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_hukdis_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_tkt_hukdis($tingkat_hukdis=0) {
        $sql = "SELECT TKT_HUKUMAN_DISIPLIN FROM TR_TKT_HUKUMAN_DISIPLIN TTHD WHERE ID=?";
        $query = $this->db->query($sql,[$tingkat_hukdis]);
        return $query->row_array();
    }
    
    function get_data($tingkat_hukdis="") {
        $where = '';
        $condition = [];
        if (!empty($tingkat_hukdis) && $tingkat_hukdis != '0') {
            $where .= " AND TPS.TRTKTHUKUMANDISIPLIN_ID=? ";
            $condition = array_merge($condition, [$tingkat_hukdis]);
        }
        
        $sql = "SELECT TP.NIP,TP.NIPNEW,TP.GELAR_DEPAN,TP.NAMA,TP.GELAR_BLKG,TTHD.TKT_HUKUMAN_DISIPLIN,TJHD.JENIS_HUKDIS,TO_CHAR(TGL_SK, 'DD/MM/YYYY') AS TGL_SK2, TPS.ALASAN_HKMN,
        TO_CHAR(TMT_HKMN, 'DD/MM/YYYY') AS TMT_HKMN2,TO_CHAR(AKHIR_HKMN, 'DD/MM/YYYY') AS AKHIR_HKMN2,NO_SK,NAMA_UNIT_KERJA FROM TH_PEGAWAI_SANKSI TPS LEFT JOIN TR_TKT_HUKUMAN_DISIPLIN TTHD ON (TTHD.ID=TPS.TRTKTHUKUMANDISIPLIN_ID) 
        LEFT JOIN TR_JENIS_HUKUMAN_DISIPLIN TJHD ON (TJHD.ID=TPS.TRJENISHUKUMANDISIPLIN_ID) LEFT JOIN TM_PEGAWAI TP ON (TPS.TMPEGAWAI_ID=TP.ID) WHERE 1=1 $where ORDER BY TMT_HKMN DESC,AKHIR_HKMN DESC, TGL_SK DESC";
        
        $query = $this->db->query($sql,$condition);
        
        return $query->result_array();
    }
    
    function get_data_komposisi($tingkat_hukdis="") {
        $where = '';
        $condition = [];
        if (!empty($tingkat_hukdis) && $tingkat_hukdis != '0') {
            $where .= " AND TPS.TRTKTHUKUMANDISIPLIN_ID=? ";
            $condition = array_merge($condition, [$tingkat_hukdis]);
        }
        
        $sql = "SELECT TPS.TRJENISHUKUMANDISIPLIN_ID, TJHD.JENIS_HUKDIS, COUNT(TMPEGAWAI_ID) AS JML FROM TH_PEGAWAI_SANKSI TPS LEFT JOIN TR_TKT_HUKUMAN_DISIPLIN TTHD ON (TTHD.ID=TPS.TRTKTHUKUMANDISIPLIN_ID) 
        LEFT JOIN TR_JENIS_HUKUMAN_DISIPLIN TJHD ON (TJHD.ID=TPS.TRJENISHUKUMANDISIPLIN_ID) WHERE 1=1 $where GROUP BY TPS.TRJENISHUKUMANDISIPLIN_ID, TJHD.JENIS_HUKDIS";
        
        $query = $this->db->query($sql,$condition);
        
        return $query->result_array();
    }

}
