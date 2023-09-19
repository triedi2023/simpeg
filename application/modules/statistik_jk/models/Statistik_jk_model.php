<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik_jk_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_data() {
        $sql = "SELECT * FROM TABLE(F_KOMPOSISI_JK)";
        $query = $this->db->query($sql);
        
        return $query->result_array();
    }
    
    function insertjabatan() {
        exit;
        $sql = "SELECT * FROM CARIID";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        foreach ($result as $val) {
            $cariid = $this->db->query("SELECT ID FROM TM_PEGAWAI WHERE NIPNEW='".$val['NIPNEW']."' OR NIP='".$val['NIPNEW']."' ");
            $hasil = $cariid->row_array();
            
            $this->db->query("UPDATE CARIID SET ID = ".$hasil['ID']." WHERE NIPNEW='".$val['NIPNEW']."' ");
        }
    }

}
