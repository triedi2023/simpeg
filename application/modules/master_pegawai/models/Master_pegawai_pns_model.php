<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_pns_model extends CI_Model {

    private $tabel = "TH_PEGAWAI_PNS";

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_by_id($id) {
        $this->db->select("TH_PEGAWAI_PNS.*, to_char(TGL_STLK,'DD/MM/YYYY') as TGL_STLK2");
        $this->db->from($this->tabel);
        $this->db->where('TMPEGAWAI_ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_by_pegawai_jabatan_pns($id) {
        $this->db->select("TH_PEGAWAI_JABATAN.*, to_char(TGL_SK,'DD/MM/YYYY') as TGL_SK2, to_char(TMT_JABATAN,'DD/MM/YYYY') as TMT_JABATAN2");
        $this->db->from("TH_PEGAWAI_JABATAN");
        $this->db->where('TMPEGAWAI_ID', $id);
        $this->db->where('IS_PNS', 1);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_by_pegawai_prajab_pns($id) {
        $this->db->select("ID,NO_STTPP,PJBT_STTPP,DOC_PRAJABATAN,NAMA_DIKLAT,to_char(TGL_STTPP,'DD/MM/YYYY') as TGL_STTPP2");
        $this->db->where('TMPEGAWAI_ID', $id);
        $this->db->where('IS_PNS', 1);
        $this->db->from("TH_PEGAWAI_DIKLAT_PRAJABATAN");
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update($var = array(), $tanggal = array(), $id) {
        $this->db->trans_begin();
        if (isset($tanggal['TGL_STLK']) && !empty($tanggal['TGL_STLK'])) {
            $this->db->set('TGL_STLK', "TO_DATE('" . $tanggal['TGL_STLK'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_NAPZA']) && !empty($tanggal['TGL_NAPZA'])) {
            $this->db->set('TGL_NAPZA', "TO_DATE('" . $tanggal['TGL_NAPZA'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->where('TMPEGAWAI_ID', $id);
        $this->db->update("TH_PEGAWAI_PNS", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    function get_dokumen_by_id($id) {
        $this->db->select("TP.NIP, THPP.DOC_STLK");
        $this->db->from($this->tabel." THPP");
        $this->db->join("TM_PEGAWAI TP",'TP.ID=THPP.TMPEGAWAI_ID','JOIN');
        $this->db->where('THPP.TMPEGAWAI_ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
}
