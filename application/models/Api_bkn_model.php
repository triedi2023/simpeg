<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api_bkn_model extends CI_Model {

    public function insert_token($token = array()) {
        $this->hapus();
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set("ACCESS_TOKEN", $token['access_token']);
        $this->db->set("TOKEN_TYPE", $token['token_type']);
        $this->db->set('EXPIRES_IN', "TO_DATE('" . date("Y-m-d H:i:s", time()+$token['expires_in']) . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set("SCOPE_API", $token['scope']);
        $this->db->insert("SYSTEM_API_BKN");
    }
    
    public function get_token() {
        $this->db->from("SYSTEM_API_BKN");
        $this->db->where("SYSDATE < EXPIRES_IN",null,false);
        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }

    public function hapus() {
        $this->db->trans_begin();
        $this->db->empty_table("SYSTEM_API_BKN");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
