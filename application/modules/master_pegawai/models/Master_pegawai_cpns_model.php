<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_cpns_model extends CI_Model {

    private $tabel = "TH_PEGAWAI_CPNS";

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_by_id($id) {
        $this->db->select("TH_PEGAWAI_CPNS.*,to_char(TMT_CPNS,'DD/MM/YYYY') as TMT_CPNS2,to_char(TMT_KERJA,'DD/MM/YYYY') as TMT_KERJA2");
        $this->db->from($this->tabel);
        $this->db->where('TMPEGAWAI_ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function update($var = array(), $tanggal = array(), $id) {
        $this->db->trans_begin();
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        if (isset($tanggal['TMT_CPNS']) && !empty($tanggal['TMT_CPNS'])) {
            $this->db->set('TMT_CPNS', "TO_DATE('" . $tanggal['TMT_CPNS'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TMT_KERJA']) && !empty($tanggal['TMT_KERJA'])) {
            $this->db->set('TMT_KERJA', "TO_DATE('" . $tanggal['TMT_KERJA'] . "','YYYY-MM-DD')", FALSE);
        } else {
            $this->db->set('TMT_KERJA', NULL);
        }
        $this->db->where('TMPEGAWAI_ID', $id);
        $this->db->update("TH_PEGAWAI_CPNS", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    private function next_val_id() {
        return $this->db->query("SELECT TH_PEGAWAI_PANGKAT_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }
    
    public function save_pangkat($var = array(), $tanggal = array(), $id) {
        $this->db->trans_begin();
        $querycek = $this->db->query("SELECT TRGOLONGAN_ID FROM TH_PEGAWAI_PANGKAT WHERE TRJENISKENAIKANPANGKAT_ID=5 AND TMPEGAWAI_ID=?",[$id]);
        $jml = $querycek->num_rows();
        
        if (isset($tanggal['TMT_GOL']) && !empty($tanggal['TMT_GOL'])) {
            $this->db->set('TMT_GOL', "TO_DATE('" . $tanggal['TMT_GOL'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_SK']) && !empty($tanggal['TGL_SK'])) {
            $this->db->set('TGL_SK', "TO_DATE('" . $tanggal['TGL_SK'] . "','YYYY-MM-DD')", FALSE);
        }
        
        $nextid = $this->next_val_id()['NEXT_ID'];
        if ($jml < 1) {
            $this->db->set("ID", $nextid);
            $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
            $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
            $this->db->set('TRJENISKENAIKANPANGKAT_ID', 5);
            $this->db->set('TMPEGAWAI_ID', $id);
            $this->db->insert("TH_PEGAWAI_PANGKAT", $var);
        } else {
            $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
            $this->db->where("TRJENISKENAIKANPANGKAT_ID", 5);
            $this->db->where("TMPEGAWAI_ID", $id);
            $this->db->update("TH_PEGAWAI_PANGKAT", $var);
        }
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function save_pangkat_dok($var = array(), $id) {
        $this->db->where("TRJENISKENAIKANPANGKAT_ID", 5);
        $this->db->where("TMPEGAWAI_ID", $id);
        $this->db->update("TH_PEGAWAI_PANGKAT", $var);
    }
    
    function get_by_pegawai_jabatan_cpns($id,$tmt_jabatan,$no_sk,$tgl_sk) {
        $this->db->select("TH_PEGAWAI_JABATAN.*, to_char(TGL_SK,'DD/MM/YYYY') as TGL_SK2, to_char(TMT_JABATAN,'DD/MM/YYYY') as TMT_JABATAN2");
        $this->db->from("TH_PEGAWAI_JABATAN");
        $this->db->where('TMPEGAWAI_ID', $id);
        $this->db->where('TO_CHAR(TMT_JABATAN)', $tmt_jabatan);
        $this->db->where('NO_SK', $no_sk);
        $this->db->where('TO_CHAR(TGL_SK)', $tgl_sk);
        $query = $this->db->get();
        return $query->row_array();
    }

}
