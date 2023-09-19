<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrasi_sistem_aktivitas_model extends CI_Model {

    private $tabel = "SYSTEM_USER_LOG";
    private $column_order = array(null,'SYSTEM_USER_LOG.CREATED_DATE', 'USERNAME', 'NIP', 'NAMA_PEGAWAI', 'AKSI', 'SYSTEMGROUP_ID'); //set column field database for datatable orderable
    private $column_search = array('USERNAME', 'NIP', 'NAMA_PEGAWAI', 'AKSI', 'SYSTEMGROUP_ID'); //set column field database for datatable searchable 
    private $order = array('CREATED_DATE' => 'DESC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        if (isset($_POST['username']) && (!empty($_POST['username']))) {
            $this->db->like('lower(USERNAME)', strtolower($this->input->post('username')));
        }
        if (isset($_POST['nip']) && (!empty($_POST['nip']))) {
            $this->db->like('lower(NIP)', strtolower($this->input->post('nip')));
        }
        if (isset($_POST['nama_pegawai']) && (!empty($_POST['nama_pegawai']))) {
            $this->db->like('lower(NAMA_PEGAWAI)', strtolower($this->input->post('nama_pegawai')));
        }
        if (isset($_POST['deskripsi']) && (!empty($_POST['deskripsi']))) {
            $this->db->where('DESKRIPSI', $this->input->post('deskripsi'));
        }
        if (isset($_POST['group']) && (!empty($_POST['group']))) {
            $this->db->where('NAMA_GROUP', $this->input->post('group'));
        }
        $this->db->select("SYSTEM_USER_LOG.*,SYSTEM_GROUP.NAMA_GROUP");
        $this->db->from($this->tabel);
        $this->db->join("SYSTEM_GROUP", "SYSTEM_GROUP.ID=SYSTEM_USER_LOG.SYSTEMGROUP_ID", "LEFT");
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
            if ($this->input->post('order')['0']['column'] == 0)
                $this->db->order_by($this->column_order[1], 'desc');
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
        $this->db->where('ID',$id);
        $query = $this->db->get();
        return $query->row();
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

}
?>