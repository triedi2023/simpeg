<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pegawai_model extends CI_Model {

    private $tabel = "TM_PEGAWAI";
    private $column_order = array(null, 'NAMA', 'NIPNEW'); //set column field database for datatable orderable
    private $column_search = array('NAMA', 'NIPNEW'); //set column field database for datatable searchable 
    private $order = array('ID' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        $this->db->where("VPJM.TRESELON_ID <>","17");
        if (isset($_POST['sex']) && $this->input->post('sex') <> '') {
            $sex = ($this->input->post('sex') == 2) ? "P" : "L";
            $this->db->where('SEX', $sex);
        }
        
        if (isset($_POST['nama_nip']) && $this->input->post('nama_nip') <> '') {
            $this->db->like('LOWER(TP.NAMA)', strtolower($this->input->post('nama_nip')));
            $this->db->or_where("TP.NIP",$this->input->post('nama_nip'));
            $this->db->or_where("TP.NIPNEW",$this->input->post('nama_nip'));
        }
        
        $this->db->select("GELAR_DEPAN,NAMA,GELAR_BLKG,NIPNEW,TGLLAHIR,NO_KTP,TPTLAHIR,N_JABATAN,TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.GOLONGAN,TRG.PANGKAT,VPPM.TRGOLONGAN_ID,
        VPJM.TRESELON_ID,VPJM.TRJABATAN_ID,VPJM.TRLOKASI_ID,VPJM.KDU1,VPJM.KDU2,VPJM.KDU3,VPJM.KDU4,VPJM.KDU5");
        $this->db->from($this->tabel." TP");
        $this->db->join('V_PEGAWAI_JABATAN_MUTAKHIR VPJM', "VPJM.TMPEGAWAI_ID=TP.ID", "LEFT");
        $this->db->join('V_PEGAWAI_PANGKAT_MUTAKHIR VPPM', "VPPM.TMPEGAWAI_ID=TP.ID", "LEFT");
        $this->db->join('TR_GOLONGAN TRG', "VPPM.TRGOLONGAN_ID=TRG.ID", "LEFT");
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
