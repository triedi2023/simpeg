<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model {

    public function insert_log($aksi,$deskripsi) {
        $this->db->set("USER_ID", (int) $this->session->userdata('user_id'));
        $this->db->set("SYSTEMGROUP_ID", (int) $this->session->userdata('idgroup'));
        $this->db->set("NIP", $this->session->userdata('nip'));
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set("URL_ACCESS", $this->router->fetch_class() . "/" . $this->router->fetch_method());
        $this->db->set("USERNAME", $this->session->userdata('USERNAME'));
        $this->db->set("AKSI", $aksi);
        $this->db->set("DESKRIPSI", $deskripsi);
        $this->db->insert("SYSTEM_USER_LOG",array('NAMA_PEGAWAI'=>$this->session->userdata('nama')));
    }

}
