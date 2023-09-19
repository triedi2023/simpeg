<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_diklat_prajabatan_model extends CI_Model {

    private $tabel = "TH_PEGAWAI_DIKLAT_PRAJABATAN";
    private $column_order = array(null, 'NAMA_DIKLAT','JPL','NO_STTPP'); //set column field database for datatable orderable
    private $order = array('ID' => 'DESC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        if ($this->input->post('status')) {
            $this->db->where('TH_PEGAWAI_DIKLAT_PRAJABATAN.STATUS', $this->input->post('status'));
        }

        $this->db->from($this->tabel);
        $this->db->where("TMPEGAWAI_ID", $this->input->post('pegawai_id'));
        $i = 0;

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($id) {
        $this->_get_datatables_query();
        if ($this->input->post('length'))
            if ($this->input->post('length') != -1)
                $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $this->db->where("TMPEGAWAI_ID", $id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_by_id($id) {
        $this->db->select("TH_PEGAWAI_DIKLAT_PRAJABATAN.*, to_char(TGL_STTPP,'DD/MM/YYYY') as TGL_STTPP2");
        $this->db->from($this->tabel);
        $this->db->where('ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->db->from($this->tabel);
        return $this->db->count_all_results();
    }
    
    function get_dokumen_by_id($id) {
        $this->db->select("TP.NIP, THPP.DOC_PRAJABATAN");
        $this->db->from($this->tabel." THPP");
        $this->db->join("TM_PEGAWAI TP",'TP.ID=THPP.TMPEGAWAI_ID','JOIN');
        $this->db->where('THPP.ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_account_by_id($id) {
        $this->db->select("TP.GELAR_DEPAN AS GELAR_DEPANC, TP.NAMA AS NAMAC, TP.GELAR_BLKG AS GELAR_BLKGC, TP.GELAR_DEPAN AS GELAR_DEPANU, TP.NAMA AS NAMAU, TP.GELAR_BLKG AS GELAR_BLKGU, to_char(THPP.CREATED_DATE,'DD/MM/YYYY HH24:MI:SS') AS CREATED_DATE2, to_char(THPP.UPDATED_DATE,'DD/MM/YYYY HH24:MI:SS') AS UPDATED_DATE2");
        $this->db->from($this->tabel." THPP");
        $this->db->join("SYSTEM_USER_GROUP SUG",'SUG.SYSTEMUSER_ID=THPP.CREATED_BY','LEFT');
        $this->db->join("TM_PEGAWAI TP",'TP.ID=SUG.TMPEGAWAI_ID','LEFT');
        $this->db->join("SYSTEM_USER_GROUP GUS",'GUS.SYSTEMUSER_ID=THPP.UPDATED_BY','LEFT');
        $this->db->join("TM_PEGAWAI PT",'PT.ID=GUS.TMPEGAWAI_ID','JOIN');
        $this->db->where('THPP.ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function count_is_pns($id,$no_sttp,$tgl_sttp) {
        $this->db->from($this->tabel);
//        $this->db->where('IS_PNS', 1);
        if (!empty($no_sttp)) {
            $this->db->where('trim(NO_STTPP)', trim($no_sttp));
        }
        if (!empty($tgl_sttp)) {
            $this->db->where("TO_CHAR(TGL_STTPP,'DD/MM/YYYY')", $tmt_jabatan);
        }
        $this->db->where('TMPEGAWAI_ID', $id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    private function next_val_id() {
        return $this->db->query("SELECT TH_PEGAWAI_DIKLAT_PRAJABATAN_.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }

    public function insert($var = array(), $tanggal = array()) {
        $this->db->trans_begin();
        $nextid = $this->next_val_id()['NEXT_ID'];
        $this->db->set('ID', $nextid);
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        if (isset($tanggal['TGL_STTPP']) && !empty($tanggal['TGL_STTPP'])) {
            $this->db->set('TGL_STTPP', "TO_DATE('" . $tanggal['TGL_STTPP'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->insert("TH_PEGAWAI_DIKLAT_PRAJABATAN", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return ['message' => TRUE, 'id' => $nextid];
        }
    }

    public function update($var = array(), $tanggal = array(), $id) {
        $this->db->trans_begin();
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        if (isset($tanggal['TGL_STTPP']) && !empty($tanggal['TGL_STTPP'])) {
            $this->db->set('TGL_STTPP', "TO_DATE('" . $tanggal['TGL_STTPP'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->where('ID', $id);
        $this->db->update("TH_PEGAWAI_DIKLAT_PRAJABATAN", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function hapus($id) {
        $this->db->trans_begin();
        $this->db->where('ID', $id);
        $this->db->delete("TH_PEGAWAI_DIKLAT_PRAJABATAN");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
