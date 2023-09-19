<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_cuti_model extends CI_Model {

    private $tabel = "TH_PEGAWAI_CUTI";
    private $column_order = array(null, 'TGL_PENGAJUAN', 'TRCUTI_ID', 'NIP', 'NAMA'); //set column field database for datatable orderable
    private $column_search = array('TGL_PENGAJUAN', 'NIP'); //set column field database for datatable searchable 
    private $order = array('TGL_PENGAJUAN' => 'DESC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        if ($this->input->post('jenis_cuti')) {
            $this->db->where('TRCUTI_ID', $this->input->post('jenis_cuti'));
        }
        if (isset($_POST['nip']) && !empty($_POST['nip'])) {
            $this->db->where('NIPNEW', $this->input->post('nip'));
        }

        $this->db->select("TH_PEGAWAI_CUTI.ID,TR_CUTI.NAMA_CUTI,GELAR_DEPAN,NAMA,GELAR_BLKG,NIPNEW,TO_CHAR(TGL_PENGAJUAN,'DD/MM/YYYY') AS TGL_PENGAJUAN2");
        $this->db->from($this->tabel);
        $this->db->join("TR_CUTI","TR_CUTI.ID=TH_PEGAWAI_CUTI.TRCUTI_ID","LEFT");
        $this->db->join("TM_PEGAWAI","TM_PEGAWAI.ID=TH_PEGAWAI_CUTI.TMPEGAWAI_ID","INNER JOIN");
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
        $this->db->select("TR_HARI_LIBUR.*,TO_CHAR(TGL_LIBUR,'DD/MM/YYYY') AS TGL_LIBUR2");
        $this->db->from($this->tabel);
        $this->db->where('ID', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_unique_1column($str) {
        $this->db->from($this->tabel);
        $this->db->where('lower(STATUS_FUNGSIONAL)', strtolower(ltrim(rtrim($str))));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function get_unique_1column_by_id($id,$str) {
        $this->db->from($this->tabel);
        $this->db->where('lower(STATUS_FUNGSIONAL)', strtolower(ltrim(rtrim($str))));
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
        return $this->db->query("SELECT TR_HARI_LIBUR_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }

    public function insert($var = array(),$tanggal = array()) {
        $this->db->trans_begin();
        $data = $var;
        $this->db->set('ID', $this->next_val_id()['NEXT_ID']);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        if (isset($tanggal['TGL_LIBUR']) && !empty($tanggal['TGL_LIBUR'])) {
            $this->db->set('TGL_LIBUR', "TO_DATE('" . $tanggal['TGL_LIBUR'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->insert("TR_HARI_LIBUR", $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update($var = array(),$tanggal = array(), $id) {
        $this->db->trans_begin();
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        if (isset($tanggal['TGL_LIBUR']) && !empty($tanggal['TGL_LIBUR'])) {
            $this->db->set('TGL_LIBUR', "TO_DATE('" . $tanggal['TGL_LIBUR'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->where('ID', $id);
        $this->db->update("TR_HARI_LIBUR", $var);
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
        $this->db->delete("TR_HARI_LIBUR");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
