<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik_jabatan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_jenjang_fungsional() {
        $sql = "SELECT TJ.ID,STF.TINGKAT_FUNGSIONAL FROM TR_JABATAN TJ left join TR_TINGKAT_FUNGSIONAL STF ON (TJ.TRTINGKATFUNGSIONAL_ID=STF.ID) WHERE TJ.TRKELOMPOKFUNGSIONAL_ID = '10' AND TJ.STATUS = 1";
        $query = $this->db->query($sql);
        
        return $query->result_array();
    }

}
