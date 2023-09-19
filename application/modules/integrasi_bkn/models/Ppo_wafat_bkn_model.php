<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ppo_wafat_bkn_model extends CI_Model {

    private $tabel = "TH_PPO_WAFAT_BKN";
    private $column_order = array(null, "NAMA", "NIPNEW", 'TGL_MENINGGAL','AKTEMENINGGAL'); //set column field database for datatable orderable
    private $order = array('NAMA' => 'DESC','TGL_MENINGGAL' => 'DESC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        $this->db->select("TH_PPO_WAFAT_BKN.*,NAMA,TP.NIPNEW");
        $this->db->from($this->tabel);
        $this->db->join("TM_PEGAWAI TP","TP.NIPNEW=TH_PPO_WAFAT_BKN.NIPBARU","JOIN");
        $i = 0;

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {
        $this->_get_datatables_query();
        if ($this->input->post('length'))
            if ($this->input->post('length') != -1)
                $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();
        return $query->result();
    }
    
    function get_by_id($id) {
        $this->db->select("TH_PPO_BKN.*, to_char(TMT_GOLONGAN,'DD/MM/YYYY') as TMT_GOLONGAN2,to_char(TGL_SK,'DD/MM/YYYY') as TGL_SK2");
        $this->db->from($this->tabel);
        $this->db->where('ID', $id);
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

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->db->from($this->tabel);
        return $this->db->count_all_results();
    }

    public function insert($var = array(), $tanggal = array()) {
        $this->db->trans_begin();
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);

        if (isset($tanggal['TMT_GOLONGAN']) && !empty($tanggal['TMT_GOLONGAN'])) {
            $this->db->set('TMT_GOLONGAN', "TO_DATE('" . $tanggal['TMT_GOLONGAN'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_SK']) && !empty($tanggal['TGL_SK'])) {
            $this->db->set('TGL_SK', "TO_DATE('" . $tanggal['TGL_SK'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TMT_PENSIUN']) && !empty($tanggal['TMT_PENSIUN'])) {
            $this->db->set('TMT_PENSIUN', "TO_DATE('" . $tanggal['TMT_PENSIUN'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_USUL']) && !empty($tanggal['TGL_USUL'])) {
            $this->db->set('TGL_USUL', "TO_DATE('" . $tanggal['TGL_USUL'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->insert("TH_PPO_BKN", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return ['message' => TRUE];
        }
    }

    public function hapus($id) {
        $this->db->trans_begin();
//        $this->db->where('ID', $id);
//        $this->db->delete("TH_PPO_BKN");
//        $this->db->empty_table('TH_PPO_BKN');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
