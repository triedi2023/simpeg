<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik_pendidikan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_data() {
        $sql = "SELECT * FROM TABLE(F_KOMPOSISI_PENDIDIKAN)";
        $query = $this->db->query($sql);
        
        return $query->result_array();
    }

}
