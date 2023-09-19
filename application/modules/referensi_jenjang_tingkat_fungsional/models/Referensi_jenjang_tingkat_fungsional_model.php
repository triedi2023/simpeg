<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi_jenjang_tingkat_fungsional_model extends CI_Model {

    private $tabel = "TR_NAMA_PENJENJANGAN";
    private $column_order = array(null, 'PENJENJANGAN_FUNGSIONAL','NAMA_PENJENJANGAN', 'STATUS'); //set column field database for datatable orderable
    private $column_search = array('PENJENJANGAN_FUNGSIONAL', 'NAMA_PENJENJANGAN', 'STATUS'); //set column field database for datatable searchable 
    private $order = array('PENJENJANGAN_FUNGSIONAL' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        if ($this->input->post('tingkat')) {
            $this->db->like('lower(KODE_JENIS)', strtolower($this->input->post('tingkat')));
        }
        if ($this->input->post('jenjang_tingkat_fungsional')) {
            $this->db->like('lower(NAMA_PENJENJANGAN)', strtolower($this->input->post('jenjang_tingkat_fungsional')));
        }
        if (isset($_POST['status']) && ($_POST['status'] === '0' || !empty($_POST['status']))) {
            $this->db->where('TR_NAMA_PENJENJANGAN.STATUS', $this->input->post('status'));
        }

        $this->db->select("TR_NAMA_PENJENJANGAN.ID,TR_NAMA_PENJENJANGAN.STATUS,NAMA_PENJENJANGAN,PENJENJANGAN_FUNGSIONAL");
        $this->db->from($this->tabel);
        $this->db->join("TR_PENJENJANGAN_FUNGSIONAL","TR_PENJENJANGAN_FUNGSIONAL.ID=TR_NAMA_PENJENJANGAN.KODE_JENIS");
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

    function get_unique_1column($str) {
        $this->db->from($this->tabel);
        $this->db->where('lower(NAMA_PENJENJANGAN)', strtolower(ltrim(rtrim($str))));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function get_unique_1column_by_id($id,$str) {
        $this->db->from($this->tabel);
        $this->db->where('lower(NAMA_PENJENJANGAN)', strtolower(ltrim(rtrim($str))));
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

    public function next_val_id() {
        $sql = "WITH t(kode) AS (
                SELECT 1 as kode from dual
                    UNION ALL
                SELECT kode+1 FROM t WHERE to_number(kode) < (select max(to_number(ID)) from TR_NAMA_PENJENJANGAN)
            )
            SELECT MIN(to_number(KODE)) as KODE FROM t WHERE to_number(kode) NOT IN (SELECT to_number(ID) FROM TR_NAMA_PENJENJANGAN)";
        $query = $this->db->query($sql);
        $new_id = "";
        if ($query->row_object()->KODE <> "") {
            if ($query->row_object()->KODE == 1)
                $new_id = "1";
            else
                $new_id = $query->row_object()->KODE;
        } else {    
            $maxquery = $this->db->query("SELECT MAX(to_number(ID)) as KODE FROM TR_NAMA_PENJENJANGAN");
            $last_id = $maxquery->row_object()->KODE;
            $format = $last_id + 1;
            
            $new_id = $format;
        }
        
        return $new_id;
    }

    public function insert($var = array()) {
        $this->db->trans_begin();
        $data = $var;
        $this->db->set('ID', $this->next_val_id());
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->insert("TR_NAMA_PENJENJANGAN", $data);
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
        $this->db->update("TR_NAMA_PENJENJANGAN", $var);
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
        $this->db->delete("TR_NAMA_PENJENJANGAN");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
