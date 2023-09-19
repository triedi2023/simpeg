<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pensiun_model extends CI_Model {

    private $tabel = "V_MONITORING_PENSIUN";
    private $column_order = array(null, 'GELAR_BLKG', 'NAMA', 'GELAR_DEPAN', 'NIPNEW'); //set column field database for datatable orderable
    private $column_search = array('NAMA', 'NIPNEW', 'GELAR_DEPAN', 'GELAR_BLKG'); //set column field database for datatable searchable 
    private $order = array('ID' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        if (isset($_POST['bulan']) && $_POST['bulan'] != '') {
            $bln = $this->input->post('bulan', false); 
            $this->db->where("TO_CHAR(VMP.TMT_PENSIUN,'MM-YYYY')",$bln."-".date('Y'));
        }
        if (isset($_POST['nama']) && $_POST['nama'] != '') {
            $this->db->like("lower(VMP.NAMA)", strtolower($this->input->post('nama', false)));
        }
        if (isset($_POST['trlokasi_id']) && $_POST['trlokasi_id'] != '') {
            $this->db->where("VMP.TRLOKASI_ID",$this->input->post('trlokasi_id', false));
        }
        if (isset($_POST['kdu1']) && $_POST['kdu1'] != '') {
            $this->db->where("VMP.KDU1",$this->input->post('kdu1', false));
        }
        if (isset($_POST['kdu2']) && $_POST['kdu2'] != '') {
            $this->db->where("VMP.KDU2",$this->input->post('kdu2', false));
        }
        if (isset($_POST['kdu3']) && $_POST['kdu3'] != '') {
            $this->db->where("VMP.KDU3",$this->input->post('kdu3', false));
        }
        if (isset($_POST['kdu4']) && $_POST['kdu4'] != '') {
            $this->db->where("VMP.KDU4",$this->input->post('kdu4', false));
        }
        if (isset($_POST['kdu5']) && $_POST['kdu5'] != '') {
            $this->db->where("VMP.KDU5",$this->input->post('kdu5', false));
        }
        
        $this->db->select("GELAR_DEPAN,FOTO,NAMA,GELAR_BLKG,NIPNEW,TGLLAHIR,UMUR,PANGKAT,GOLONGAN_RUANG,TMT_JABATAN,TMT_PENSIUN_CHAR,TRSTATUSKEPEGAWAIAN_ID,N_JABATAN");
        $this->db->from($this->tabel." VMP");
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
