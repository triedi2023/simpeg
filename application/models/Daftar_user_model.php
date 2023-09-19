<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_user_model extends CI_Model {

    private $tabel = "TMUSER";
    private $column_order = array(null, 'USERID', 'NIP'); //set column field database for datatable orderable
    private $column_search = array('USERID', 'NIP'); //set column field database for datatable searchable 
    private $order = array('USERID' => 'ASC'); // default order 
    private $dbportal;

    public function __construct() {
        parent::__construct();
        $this->dbportal = $this->load->database('dbportal', TRUE);
    }

    private function _get_datatables_query() {
        if (isset($_POST['nama_username']) && $this->input->post('nama_username') <> '') {
            $this->dbportal->like('LOWER(USERID)', strtolower($this->input->post('nama_username')));
        }
        $this->dbportal->from($this->tabel." TP");
        $i = 0;

        foreach ($this->column_search as $item) { // loop column 
            if ($this->input->post('search')) { // if datatable send POST for search
                if ($this->input->post('search')['value']) { // if datatable send POST for search
                    if ($i === 0) { // first loop
                        $this->dbportal->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->dbportal->like($item, $this->input->post('search')['value']);
                    } else {
                        $this->dbportal->or_like($item, $this->input->post('search')['value']);
                    }

                    if (count($this->column_search) - 1 == $i) //last loop
                        $this->dbportal->group_end(); //close bracket
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->dbportal->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dbportal->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {
        $this->_get_datatables_query();
        if ($this->input->post('length'))
            if ($this->input->post('length') != -1)
                $this->dbportal->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->dbportal->get();
        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->dbportal->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->dbportal->from($this->tabel);
        return $this->dbportal->count_all_results();
    }
    
    // input banyak
//    public function cari_by_nip($nip) {
//        $this->dbportal->from($this->tabel);
//        $this->dbportal->where('NIP',$nip);
//        $query = $this->dbportal->get();
//        return $query->row();
//    }
    
}
