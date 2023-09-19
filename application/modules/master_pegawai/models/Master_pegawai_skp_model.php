<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_skp_model extends CI_Model {

    private $tabel = "TH_PEGAWAI_SKP";
    private $column_order = array(null,'PERIODE', 'PANGKATGOL', 'JABATAN'); //set column field database for datatable orderable
    private $order = array('ID' => 'DESC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {
        $this->db->select("ID, PERIODE_AWAL || ' S/D ' || PERIODE_AKHIR || ' ' || PERIODE_TAHUN AS PERIODE, PANGKAT_YGDINILAI || ' ('||GOLONGAN_YGDINILAI ||')' AS PANGKATGOL, JABATAN_YGDINILAI AS JABATAN, DOC_SKP");
        $this->db->from($this->tabel);
        $i = 0;

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($id) {
        $this->_get_datatables_query();
        if ($this->input->post('length'))
            if ($this->input->post('length') != -1)
                $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $this->db->where("NIP_YGDINILAI", $id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_by_id($id) {
        $this->db->select("TH_PEGAWAI_SKP.*");
        $this->db->from($this->tabel);
        $this->db->where('ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_detail_by_id($id) {
        $this->db->select("NILAI_AKHIR");
        $this->db->from("TH_PEGAWAI_SKP_DETAIL");
        $this->db->where('THPEGAWAISKP_ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_perilaku_by_id($id) {
        $this->db->from("TH_PEGAWAI_SKP_PERILAKUKERJA");
        $this->db->where('THPEGAWAISKP_ID', $id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
    }
    
    function get_dokumen_by_id($id) {
        $this->db->select("TP.NIP, THPP.DOC_SKP");
        $this->db->from($this->tabel." THPP");
        $this->db->join("TM_PEGAWAI TP",'TP.NIPNEW=THPP.NIP_YGDINILAI','JOIN');
        $this->db->where('THPP.ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_account_by_id($id) {
        $this->db->select("TP.GELAR_DEPAN AS GELAR_DEPANC, TP.NAMA AS NAMAC, TP.GELAR_BLKG AS GELAR_BLKGC, TP.GELAR_DEPAN AS GELAR_DEPANU, TP.NAMA AS NAMAU, TP.GELAR_BLKG AS GELAR_BLKGU, to_char(THPP.CREATED_DATE,'DD/MM/YYYY HH24:MI:SS') AS CREATED_DATE2, to_char(THPP.UPDATED_DATE,'DD/MM/YYYY HH24:MI:SS') AS UPDATED_DATE2");
        $this->db->from($this->tabel." THPP");
        $this->db->join("SYSTEM_USER_GROUP SUG",'SUG.SYSTEMUSER_ID=THPP.CREATED_BY','LEFT');
        $this->db->join("TM_PEGAWAI TP",'TP.ID=SUG.TMPEGAWAI_ID','LEFT');
        $this->db->join("SYSTEM_USER_GROUP GUS",'GUS.SYSTEMUSER_ID=THPP.UPDATED_BY','LEFT');
        $this->db->join("TM_PEGAWAI PT",'PT.ID=GUS.TMPEGAWAI_ID','JOIN');
        $this->db->where('THPP.ID', $id);
        $query = $this->db->get();
        return $query->row_array();
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

    private function next_val_id() {
        return $this->db->query("SELECT TH_PEGAWAI_SKP_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }
    
    private function next_val_prilaku_id() {
        return $this->db->query("SELECT TH_PEGAWAI_SKP_PERILAKUKERJA1.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }

    public function insert($var = array()) {
        $this->db->trans_begin();
        $nextid = $this->next_val_id()['NEXT_ID'];
        $this->db->set('ID', $nextid);
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('NIP_YGDINILAI', "'".$var['NIPNEW']."'", FALSE);
        // ambilpangkat
        if (isset($var['PANGKAT']) && !empty($var['PANGKAT'])) {
            $listpangkat = $this->list_golongan_pegawai($var['IDPEGAWAI'], $var['PANGKAT']);
            $pecah = explode("(", $listpangkat[0]['NAMA']);
            $this->db->set('PANGKAT_YGDINILAI', "'".$pecah[0]."'", FALSE);
            $this->db->set('GOLONGAN_YGDINILAI', "'".str_replace(')', "", $pecah[1])."'", FALSE);
        }
        if (isset($var['JABATAN']) && !empty($var['JABATAN'])) {
            $listjabatan = $this->list_jabatan_pegawai($var['IDPEGAWAI'], $var['JABATAN']);
            $this->db->set('JABATAN_YGDINILAI', "'".$listjabatan[0]['NAMA']."'", FALSE);
        }
        if (isset($var['PERIODE_AWAL']) && !empty($var['PERIODE_AWAL'])) {
            $this->db->set('PERIODE_AWAL', "'".$var['PERIODE_AWAL']."'", FALSE);
        }
        if (isset($var['PERIODE_AKHIR']) && !empty($var['PERIODE_AKHIR'])) {
            $this->db->set('PERIODE_AKHIR', "'".$var['PERIODE_AKHIR']."'", FALSE);
        }
        $this->db->set('PERIODE_TAHUN', $var['PERIODE_TAHUN'], FALSE);
        
        $this->db->insert("TH_PEGAWAI_SKP");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return ['message' => TRUE, 'id' => $nextid];
        }
    }
    
    public function insert_detail($var = array()) {
        $this->db->trans_begin();
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->insert("TH_PEGAWAI_SKP_DETAIL", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function insert_perilaku($var = array()) {
        $this->db->trans_begin();
        $nextid = $this->next_val_prilaku_id()['NEXT_ID'];
        $this->db->set('ID', $nextid);
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        
        $this->db->insert("TH_PEGAWAI_SKP_PERILAKUKERJA", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update_dokumen($var = array(), $id) {
        $this->db->trans_begin();
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->where('ID', $id);
        $this->db->update("TH_PEGAWAI_SKP",$var);
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
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);

        $listpangkat = $this->list_golongan_pegawai($var['IDPEGAWAI'], $var['PANGKAT']);
        $pecah = explode("(", $listpangkat[0]['NAMA']);
        $this->db->set('PANGKAT_YGDINILAI', "'".$pecah[0]."'", FALSE);
        $this->db->set('GOLONGAN_YGDINILAI', "'".str_replace(')', "", $pecah[1])."'", FALSE);
        $listjabatan = $this->list_jabatan_pegawai($var['IDPEGAWAI'], $var['JABATAN']);
        $this->db->set('JABATAN_YGDINILAI', "'".$listjabatan[0]['NAMA']."'", FALSE);
        $this->db->set('PERIODE_AWAL', "'".$var['PERIODE_AWAL']."'", FALSE);
        $this->db->set('PERIODE_AKHIR', "'".$var['PERIODE_AKHIR']."'", FALSE);
        $this->db->set('PERIODE_TAHUN', $var['PERIODE_TAHUN'], FALSE);
        
        $this->db->where('ID', $id);
        $this->db->update("TH_PEGAWAI_SKP");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function update_detail($var = array(),$id) {
        $this->db->trans_begin();
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->where('THPEGAWAISKP_ID', $id);
        $this->db->update("TH_PEGAWAI_SKP_DETAIL", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function update_perilaku($var = array(),$id) {
        $this->db->trans_begin();
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        
        $this->db->where('THPEGAWAISKP_ID', $id);
        $this->db->update("TH_PEGAWAI_SKP_PERILAKUKERJA", $var);
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
        $this->db->delete("TH_PEGAWAI_SKP");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function list_jabatan_pegawai($id, $idjabatan="") {
        $this->db->select("N_JABATAN AS NAMA,ID");
        $this->db->from("TH_PEGAWAI_JABATAN");
        $this->db->where('TMPEGAWAI_ID', $id);
        if ($idjabatan)
            $this->db->where('ID', $idjabatan);
        
        $this->db->order_by("TMT_JABATAN DESC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_golongan_pegawai($id,$idgolpangkat="") {
        $array = [$id];
        $where = '';
        if ($idgolpangkat) {
            $where = " AND TH_PEGAWAI_PANGKAT.ID=? ";
            $array = [$id, $idgolpangkat];
        }
        return $this->db->query("SELECT TH_PEGAWAI_PANGKAT.ID AS ID,CASE WHEN TR_GOLONGAN.TRSTATUSKEPEGAWAIAN_ID = 1 THEN PANGKAT||' ('||TR_GOLONGAN.GOLONGAN||')' ELSE TR_GOLONGAN.PANGKAT END AS NAMA FROM TH_PEGAWAI_PANGKAT JOIN TR_GOLONGAN ON (TH_PEGAWAI_PANGKAT.TRGOLONGAN_ID=TR_GOLONGAN.ID) WHERE TRJENISKENAIKANPANGKAT_ID <> 5 AND TH_PEGAWAI_PANGKAT.TMPEGAWAI_ID=? $where ORDER BY TMT_GOL DESC", $array)->result_array();
    }
    
    function get_to_bkn($id) {
        $this->db->select("THPP.*,TPSD.NILAI_AKHIR,TPSP.*");
        $this->db->from($this->tabel." THPP");
        $this->db->where("NIP_YGDINILAI", $id);
        $this->db->join("TH_PEGAWAI_SKP_DETAIL TPSD",'TPSD.THPEGAWAISKP_ID=THPP.ID','LEFT');
        $this->db->join("TH_PEGAWAI_SKP_PERILAKUKERJA TPSP",'TPSP.THPEGAWAISKP_ID=THPP.ID','LEFT');
        $query = $this->db->get();
        return $query->result_array();
    }

}
