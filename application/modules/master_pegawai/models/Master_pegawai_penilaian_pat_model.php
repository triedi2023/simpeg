<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_penilaian_pat_model extends CI_Model {

    private $tabel = "TH_PEGAWAI_PAT";
    private $column_order = array(null, 'JENIS_ASSESSMENT_TEST','TUJUAN_ASSESSMENT_TEST','REKOMENDASI','TGL_TEST'); //set column field database for datatable orderable
    private $order = array('TGL_TEST' => 'DESC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        if ($this->input->post('status')) {
            $this->db->where('TH_PEGAWAI_PAT.STATUS', $this->input->post('status'));
        }

        $this->db->select("TH_PEGAWAI_PAT.ID,TO_CHAR(TGL_TEST,'DD/MM/YYYY') as TGL_TEST,JENIS_ASSESSMENT_TEST,TUJUAN_ASSESSMENT_TEST,REKOMENDASI");
        $this->db->from($this->tabel);
        $this->db->join("TR_JENIS_ASSESSMENT_TEST","TR_JENIS_ASSESSMENT_TEST.ID=TH_PEGAWAI_PAT.TRJENISASSESSMENTTEST_ID","LEFT");
        $this->db->join("TR_TUJUAN_ASSESSMENT_TEST","TR_TUJUAN_ASSESSMENT_TEST.ID=TH_PEGAWAI_PAT.TRTUJUANASSESSMENTTEST_ID","LEFT");
        $this->db->join("TR_REKOMENDASI","TR_REKOMENDASI.ID=TH_PEGAWAI_PAT.TRREKOMENDASI_ID","LEFT");
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
        $this->db->select("TH_PEGAWAI_PAT.*, to_char(TGL_TEST,'DD/MM/YYYY') as TGL_TEST2");
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
    
    private function next_val_id() {
        return $this->db->query("SELECT TH_PEGAWAI_PAT_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }

    public function insert($var = array(), $tanggal = array()) {
        $this->db->trans_begin();
        $nextid = $this->next_val_id()['NEXT_ID'];
        $this->db->set('ID', $nextid);
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        if (isset($tanggal['TGL_TEST']) && !empty($tanggal['TGL_TEST'])) {
            $this->db->set('TGL_TEST', "TO_DATE('" . $tanggal['TGL_TEST'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->insert("TH_PEGAWAI_PAT", $var);
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
        if (isset($tanggal['TGL_TEST']) && !empty($tanggal['TGL_TEST'])) {
            $this->db->set('TGL_TEST', "TO_DATE('" . $tanggal['TGL_TEST'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->where('ID', $id);
        $this->db->update("TH_PEGAWAI_PAT", $var);
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
        $this->db->delete("TH_PEGAWAI_PAT");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
