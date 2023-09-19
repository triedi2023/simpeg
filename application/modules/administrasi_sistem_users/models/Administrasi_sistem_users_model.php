<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrasi_sistem_users_model extends CI_Model {

    private $tabel = "SYSTEM_USER";
    private $column_order = array(null,'USERNAME', 'EMAIL', 'STATUS'); //set column field database for datatable orderable
    private $column_search = array('USERNAME', 'EMAIL', 'STATUS'); //set column field database for datatable searchable 
    private $order = array('ID' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {
        
        $this->db->select("SUG.ID,TMP.GELAR_DEPAN,GELAR_BLKG,NAMA,NIPNEW,SG.NAMA_GROUP,SU.USERNAME,SUG.STATUS, VPJM.N_JABATAN");
        $this->db->where('lower(SU.USERNAME) <> ', 'arief.widiyantoro');
        if ($this->input->post('username')) {
            $this->db->like('lower(SU.USERNAME)', strtolower($this->input->post('username', TRUE)));
        }
        if ($this->input->post('nip')) {
            $this->db->where('TMP.NIP', strtolower($this->input->post('nip', TRUE)));
            $this->db->or_where('TMP.NIPNEW', strtolower($this->input->post('nip', TRUE)));
        }
        if ($this->input->post('nama')) {
            $this->db->like('lower(TMP.NAMA)', strtolower($this->input->post('nama', TRUE)));
        }
        if ($this->input->post('group')) {
            $this->db->where('SUG.SYSTEMGROUP_ID', strtolower($this->input->post('group', TRUE)));
        }
        if (isset($_POST['status']) && ($_POST['status'] === '0' || !empty($_POST['status']))) {
            $this->db->where('SU.STATUS', $this->input->post('status', TRUE));
            $this->db->where('SUG.STATUS', $this->input->post('status', TRUE));
        }
        
        $this->db->from($this->tabel." SU");
        $this->db->join("SYSTEM_USER_GROUP SUG",'SU.ID=SUG.SYSTEMUSER_ID','LEFT');
        $this->db->join("TM_PEGAWAI TMP",'TMP.ID=SUG.TMPEGAWAI_ID','LEFT');
        $this->db->join("SYSTEM_GROUP SG",'SG.ID=SUG.SYSTEMGROUP_ID','LEFT');
        $this->db->join("SYSTEM_GROUP SG",'SG.ID=SUG.SYSTEMGROUP_ID','LEFT');
        $this->db->join("V_PEGAWAI_JABATAN_MUTAKHIR VPJM","VPJM.TMPEGAWAI_ID=SUG.TMPEGAWAI_ID AND VPJM.TRESELON_ID <> '17'",'LEFT');
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
    
    public function list_group($id = "") {
        $this->db->select("ID,NAMA_GROUP AS NAMA");
        $this->db->where("STATUS", 1);
        $this->db->from("SYSTEM_GROUP");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_by_id($id) {
        $this->db->from("SYSTEM_USER_GROUP");
        $this->db->where('ID',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function get_unique_1column_by_id($id,$str) {
        $this->db->from($this->tabel);
        $this->db->where('lower(USERNAME)', strtolower(ltrim(rtrim($str))));
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
        return $this->db->query("SELECT SYSTEM_USER_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }
    
    public function next_id_val() {
        return $this->db->query("SELECT SYSTEM_USER_GROUP_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }
    
    public function cari_pegawai($nipnew) {
        $this->db->from("TM_PEGAWAI");
        $this->db->where('LOWER(NIPNEW)', strtolower(ltrim(rtrim($nipnew))));
        $query = $this->db->get();
        return $query->row_array()['ID'];
    }

    public function insert($var = array(),$gabung = array()) {
        $this->db->trans_begin();
        $nextid = $this->next_val_id()['NEXT_ID'];
        $this->db->set("ID", $nextid);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->insert("SYSTEM_USER", $var);
        
        $this->db->set("ID", $this->next_id_val()['NEXT_ID']);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->insert("SYSTEM_USER_GROUP", ['SYSTEMUSER_ID'=>$nextid,'SYSTEMGROUP_ID'=>$gabung['SYSTEMGROUP_ID'],'TMPEGAWAI_ID'=> $this->cari_pegawai($gabung['NIP'])]);
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
        $model = $this->get_by_id($id);
        
        $this->db->where('ID',$id);
        $this->db->delete("SYSTEM_USER_GROUP");
        $this->db->where('ID',$model->SYSTEMUSER_ID);
        $this->db->delete("SYSTEM_USER");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    // input banyak
//    public function cari_pegawai_pusat() {
//        $this->db->select("TP.NIPNEW,TP.NIP,TP.NAMA");
//        $this->db->from("TM_PEGAWAI TP");
//        $this->db->join("V_PEGAWAI_PANGKAT_MUTAKHIR VPPM", "VPPM.TMPEGAWAI_ID=TP.ID", "LEFT");
//        $this->db->join("TR_GOLONGAN TRG", "TRG.ID=VPPM.TRGOLONGAN_ID", "LEFT");
//        $this->db->join("V_PEGAWAI_JABATAN_MUTAKHIR VPJM", "VPJM.TMPEGAWAI_ID=TP.ID", "LEFT");
//        $this->db->where("VPJM.TRESELON_ID !=", "'17'");
//        $query = $this->db->get();
//        return $query->result_array();
//    }
//    
//    function get_unique_column_by_username($str) {
//        $this->db->from($this->tabel);
//        $this->db->where('lower(USERNAME)', strtolower(ltrim(rtrim($str))));
//        $query = $this->db->get();
//        return $query->num_rows();
//    }

}
