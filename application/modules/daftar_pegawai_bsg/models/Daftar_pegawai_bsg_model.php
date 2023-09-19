<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pegawai_bsg_model extends CI_Model {

    private $tabel = "TH_PEGAWAI_BSG";
    private $column_order = array(null, 'NAMA', 'NIPNEW', 'PANGKAT', 'TMT_GOL', 'N_JABATAN', 'TMT_JABATAN'); //set column field database for datatable orderable
    private $column_search = array('AGAMA', 'STATUS'); //set column field database for datatable searchable 
    private $order = array('ID' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

//        if ($this->input->post('agama')) {
//            $this->db->like('lower(AGAMA)', strtolower($this->input->post('agama')));
//        }
//        if (isset($_POST['status']) && ($_POST['status'] === '0' || !empty($_POST['status']))) {
//            $this->db->where('STATUS', $this->input->post('status'));
//        }
        
        $this->db->select("TPB.ID,TP.GELAR_DEPAN,TP.NAMA,TP.GELAR_BLKG,TP.NIPNEW,TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.GOLONGAN,TRG.PANGKAT,TO_CHAR(VPPM.TMT_GOL,'DD/MM/YYYY') AS TMT_GOL,VPJM.N_JABATAN,TO_CHAR(VPJM.TMT_JABATAN, 'DD/MM/YYYY') AS TMT_JABATAN");
        
        $this->db->from($this->tabel." TPB");
        $this->db->join("TM_PEGAWAI TP", "TP.ID=TPB.TMPEGAWAI_ID", "LEFT");
        $this->db->join("V_PEGAWAI_JABATAN_MUTAKHIR VPJM", "VPJM.TMPEGAWAI_ID=TP.ID", "LEFT");
        $this->db->join("V_PEGAWAI_PANGKAT_MUTAKHIR VPPM", "VPPM.TMPEGAWAI_ID=TP.ID", "LEFT");
        $this->db->join("TR_GOLONGAN TRG", "TRG.ID=VPPM.TRGOLONGAN_ID", "LEFT");
        $this->db->join("V_PEGAWAI_PENDIDIKAN_MUTAKHIR VPPU", "VPPU.TMPEGAWAI_ID=TP.ID", "LEFT");
        
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
        $this->db->where('ID',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function get_unique_nama_by_id($id,$str) {
        $this->db->from($this->tabel);
        $this->db->where('lower(AGAMA)', strtolower(ltrim(rtrim($str))));
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
        return $this->db->query("SELECT TH_PEGAWAI_BSG_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }
    
    function get_pegawai_by_nip($id) {
        $this->db->select("ID");
        $this->db->from("TM_PEGAWAI");
        $this->db->where('NIPNEW', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_cek_pegawai_by_nip($id) {
        $this->db->from($this->tabel);
        $this->db->where('TMPEGAWAI_ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function insert($var = array()) {
        $this->db->trans_begin();
        
        $pegawai = $this->get_pegawai_by_nip($var['nip'])['ID'];
        
        $data = $var;
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        
        if (count($this->get_cek_pegawai_by_nip($pegawai)) < 1) {
            $this->db->insert("TH_PEGAWAI_BSG", ['TMPEGAWAI_ID'=>$pegawai]);
        
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            } else {
                $this->db->trans_commit();
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }
    
    public function hapus($id) {
        $this->db->trans_begin();
        $this->db->where('ID', $id);
        $this->db->delete("TH_PEGAWAI_BSG");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
