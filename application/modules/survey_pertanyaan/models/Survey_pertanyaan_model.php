<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Survey_pertanyaan_model extends CI_Model {

    private $tabel = "TR_SURVEY";
    private $column_order = array(null, 'JUDUL', 'KETERANGAN', 'START_DATE', 'END_DATE'); //set column field database for datatable orderable
    private $column_search = array('JUDUL', 'KETERANGAN', 'START_DATE', 'END_DATE'); //set column field database for datatable searchable 
    private $order = array('JUDUL' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        $this->db->select("ID,JUDUL,KETERANGAN,TO_CHAR(START_DATE,'DD/MM/YYYY') START_DATE,TO_CHAR(END_DATE,'DD/MM/YYYY') END_DATE");
        if ($this->input->post('judul')) {
            $this->db->like('lower(JUDUL)', strtolower($this->input->post('judul')));
        }
        if ($this->input->post('keterangan')) {
            $this->db->like('lower(KETERANGAN)', strtolower($this->input->post('keterangan')));
        }

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
        $this->db->select("ID,JUDUL,KETERANGAN,TO_CHAR(START_DATE,'DD/MM/YYYY') START_DATE,TO_CHAR(END_DATE,'DD/MM/YYYY') END_DATE,STATUS");
        $this->db->from($this->tabel);
        $this->db->where('ID', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function get_pertanyaan_by_trsurveyid($id) {
        $this->db->from('TR_SURVEY_PERTANYAAN');
        $this->db->where('TRSURVEY_ID', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_jawaban_by_trpertanyaanid($id) {
        $this->db->from('TR_SURVEY_JAWABAN');
        $this->db->where('TRSURVEYPERTANYAAN_ID', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_unique_create($tipe_pangkat, $golongan, $pangkat) {
        $this->db->from($this->tabel);
        $this->db->where('JUDUL', $tipe_pangkat);
        $this->db->where('lower(KETERANGAN)', strtolower(ltrim(rtrim($golongan))));
        $this->db->where('lower(START_DATE)', strtolower(ltrim(rtrim($pangkat))));
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_unique_update($id, $tipe_pangkat, $golongan, $pangkat) {
        $this->db->from($this->tabel);
        $this->db->where('JUDUL', $tipe_pangkat);
        $this->db->where('lower(KETERANGAN)', strtolower(ltrim(rtrim($golongan))));
        $this->db->where('lower(START_DATE)', strtolower(ltrim(rtrim($pangkat))));
        $this->db->where('ID !=', $id);
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
        return $this->db->query("SELECT TR_SURVEY_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }
    
    public function next_val_pertanyaan_id() {
        return $this->db->query("SELECT TR_SURVEY_PERTANYAAN_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }

    public function insert($var = array(),$tanggal=array()) {
        $this->db->trans_begin();
        $data = $var;
        $id = $this->next_val_id()['NEXT_ID'];
        $this->db->set('ID', $id);
        $this->db->set('START_DATE', "TO_DATE('" . $tanggal['START_DATE'] . "','YYYY-MM-DD')", FALSE);
        $this->db->set('END_DATE', "TO_DATE('" . $tanggal['END_DATE'] . "','YYYY-MM-DD')", FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->insert("TR_SURVEY", $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $id;
        }
    }

    public function update_survey($var = array(), $tanggal = array(), $id) {
        $this->db->trans_begin();
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('START_DATE', "TO_DATE('" . $tanggal['START_DATE'] . "','YYYY-MM-DD')", FALSE);
        $this->db->set('END_DATE', "TO_DATE('" . $tanggal['END_DATE'] . "','YYYY-MM-DD')", FALSE);
        $this->db->where('ID', $id);
        $this->db->update("TR_SURVEY", $var);
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
        $this->db->delete("TR_SURVEY");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
