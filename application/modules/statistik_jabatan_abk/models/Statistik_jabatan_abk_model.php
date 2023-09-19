<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik_jabatan_abk_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_data() {
        $sql = "SELECT TJA.TRJABATAN_ID,TJ.JABATAN FROM TR_JABATAN_ABK TJA LEFT JOIN TR_JABATAN TJ ON (TJ.ID=TJA.TRJABATAN_ID) ORDER BY TJ.JABATAN ASC";
        $query = $this->db->query($sql);
        
        return $query->result_array();
    }

}
