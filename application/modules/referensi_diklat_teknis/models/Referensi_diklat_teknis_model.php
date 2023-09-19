<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi_diklat_teknis_model extends CI_Model {

    private $tabel = "TR_DIKLAT_TEKNIS";
    private $column_order = array(null, 'TRKELOMPOKDKLTTEKNIS_ID', 'NAMA_DIKLAT', 'STATUS'); //set column field database for datatable orderable
    private $column_search = array('TRKELOMPOKDKLTTEKNIS_ID','NAMA_DIKLAT', 'STATUS'); //set column field database for datatable searchable 
    private $order = array('TRKELOMPOKDKLTTEKNIS_ID' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        if ($this->input->post('namadiklat')) {
            $this->db->like('lower(NAMA_DIKLAT)', strtolower($this->input->post('namadiklat')));
        }
        if ($this->input->post('klpk_id')) {
            $this->db->where('TRKELOMPOKDKLTTEKNIS_ID', $this->input->post('klpk_id'));
        }
        if (isset($_POST['status']) && ($_POST['status'] === '0' || !empty($_POST['status']))) {
            $this->db->where('TR_DIKLAT_TEKNIS.STATUS', $this->input->post('status'));
        }
        $this->db->select("TR_DIKLAT_TEKNIS.*, TRP.NAMA_KELOMPOK");
        $this->db->join("TR_KELOMPOK_DKLT_TEKNIS TRP", "TRP.ID=TR_DIKLAT_TEKNIS.TRKELOMPOKDKLTTEKNIS_ID", "LEFT JOIN");
        $this->db->from($this->tabel);
        $i = 0;

        foreach ($this->column_search as $item) { // loop column 
            if ($this->input->post('search')) { // if datatable send POST for search
                if ($this->input->post('search')['value']) { // if datatable send POST for search
                    if ($i === 0) { // first loop
                        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->db->like($item, $this->input->post('search')['value']);
                    } else {
                        $this->db->or_like($item, $this->input->post('search')['value']);
                    }

                    if (count($this->column_search) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
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
        $this->db->from($this->tabel);
        $this->db->where('ID', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_unique_2column($tkthukdis_id,$str) {
        $this->db->from($this->tabel);
        $this->db->where('TRKELOMPOKDKLTTEKNIS_ID', $tkthukdis_id);
        $this->db->where('lower(NAMA_DIKLAT)', strtolower(ltrim(rtrim($str))));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function get_unique_2column_by_id($id,$str,$tkthukdis_id) {
        $this->db->from($this->tabel);
        $this->db->where('lower(NAMA_DIKLAT)', strtolower(ltrim(rtrim($str))));
        $this->db->where('TRKELOMPOKDKLTTEKNIS_ID', $tkthukdis_id);
        $this->db->where('ID !=',$id);
        $query = $this->db->get();
        return $query->num_rows();
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

    public function insert($var = array()) {
        $this->db->trans_begin();
        $data = $var;
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->insert("TR_DIKLAT_TEKNIS", $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update($var = array(), $id) {
        $this->db->trans_begin();
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->where('ID', $id);
        $this->db->update("TR_DIKLAT_TEKNIS", $var);
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
        $this->db->where('ID',$id);
        $this->db->delete("TR_DIKLAT_TEKNIS");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
