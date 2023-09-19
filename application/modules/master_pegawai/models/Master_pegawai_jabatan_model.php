<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_jabatan_model extends CI_Model {

    private $tabel = "TH_PEGAWAI_JABATAN";
    private $column_order = array(null, 'N_JABATAN', 'NO_SK', 'TMT_JABATAN', 'KETERANGAN_JABATAN'); //set column field database for datatable orderable
    private $order = array('TMT_JABATAN' => 'DESC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        if ($this->input->post('status')) {
            $this->db->where('STATUS', $this->input->post('status'));
        }

        $this->db->select("N_JABATAN,TMT_JABATAN,TO_CHAR(TMT_JABATAN,'DD/MM/YYYY') as TMT_JABATAN2,NO_SK,TPJ.ID,DOC_SKJABATAN,TKJ.KETERANGAN_JABATAN");
        $this->db->where("TMPEGAWAI_ID", $this->input->post('pegawai_id'));
        $this->db->from($this->tabel." TPJ");
        $this->db->join("TR_KETERANGAN_JABATAN TKJ", "TKJ.ID=TPJ.TRKETERANGANJABATAN_ID", "LEFT");
        $i = 0;

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($id) {
        $this->_get_datatables_query();
        if ($this->input->post('length'))
            if ($this->input->post('length') != -1)
                $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $this->db->where("TMPEGAWAI_ID", $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_by_id($id) {
        $this->db->select("TH_PEGAWAI_JABATAN.*, to_char(TMT_GOL,'DD/MM/YYYY') as TMT_GOL2,to_char(TGL_LANTIK,'DD/MM/YYYY') as TGL_LANTIK2,to_char(TMT_ESELON,'DD/MM/YYYY') as TMT_ESELON2, to_char(TMT_JABATAN,'DD/MM/YYYY') as TMT_JABATAN2, to_char(TGL_AKHIR,'DD/MM/YYYY') as TGL_AKHIR2, to_char(TGL_SK,'DD/MM/YYYY') as TGL_SK2");
        $this->db->from($this->tabel);
        $this->db->where('ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_by_pegawai_idpangkat($id) {
        $this->db->select("to_char(TMT_GOL,'DD/MM/YYYY') as TMT_GOL,to_char(TGL_SK,'DD/MM/YYYY') as TGL_SK, TRGOLONGAN_ID,NO_SK,PEJABAT_SK,DOC_SKPANGKAT");
        $this->db->from($this->tabel);
        $this->db->where('TMPEGAWAI_ID', $id);
        $this->db->where('TRJENISKENAIKANPANGKAT_ID', 5);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_dokumen_by_id($id) {
        $this->db->select("TP.NIP, THPP.DOC_SKJABATAN");
        $this->db->from($this->tabel." THPP");
        $this->db->join("TM_PEGAWAI TP",'TP.ID=THPP.TMPEGAWAI_ID','JOIN');
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
    
    public function count_is_pns($id,$no_sk,$tmt_jabatan="",$tgl_sk="") {
        $this->db->from($this->tabel);
        $this->db->where('TMPEGAWAI_ID', $id);
        if (!empty($no_sk)) {
            $this->db->where("TRIM(NO_SK)", trim($no_sk));
        }
        if (!empty($tmt_jabatan)) {
            $this->db->where("TO_CHAR(TMT_JABATAN,'DD/MM/YYYY')", $tmt_jabatan);
        }
        if (!empty($tgl_sk)) {
            $this->db->where("TO_CHAR(TGL_SK,'DD/MM/YYYY')", $tgl_sk);
        }
        $query = $this->db->get();
        $jml = $query->num_rows();
        
        if ($jml > 0) {
            $datanya = $query->row_array();
            $this->db->query("UPDATE TH_PEGAWAI_JABATAN SET IS_PNS=1 WHERE ID=".$datanya['ID']);
            return 1;
        } else {
            return 0;
        }
    }
    
    public function count_is_cpns($id,$no_sk,$tmt_jabatan="",$tgl_sk="") {
        $this->db->from($this->tabel);
        $this->db->where('TMPEGAWAI_ID', $id);
        if (!empty($no_sk)) {
            $this->db->where("TRIM(NO_SK)", trim($no_sk));
        }
        if (!empty($tmt_jabatan)) {
            $this->db->where("TO_CHAR(TMT_JABATAN,'DD/MM/YYYY')", $tmt_jabatan);
        }
        if (!empty($tgl_sk)) {
            $this->db->where("TO_CHAR(TGL_SK,'DD/MM/YYYY')", $tgl_sk);
        }
        $query = $this->db->get();
        $jml = $query->num_rows();
        
        if ($jml > 0) {
            return $query->row_array();
        } else {
            return [];
        }
    }

    private function next_val_id() {
        return $this->db->query("SELECT TH_PEGAWAI_JABATAN_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }

    public function list_golongan_pegawai($id) {
        return $this->db->query("SELECT TR_GOLONGAN.ID AS ID,CASE WHEN TR_GOLONGAN.TRSTATUSKEPEGAWAIAN_ID = 1 THEN PANGKAT||' ('||TR_GOLONGAN.GOLONGAN||')' ELSE TR_GOLONGAN.PANGKAT END AS NAMA FROM TH_PEGAWAI_PANGKAT JOIN TR_GOLONGAN ON (TH_PEGAWAI_PANGKAT.TRGOLONGAN_ID=TR_GOLONGAN.ID) WHERE TH_PEGAWAI_PANGKAT.TMPEGAWAI_ID=? ORDER BY TMT_GOL DESC", [$id])->result_array();
    }

    public function nama_unitkerja($kode) {
        return $this->db->query("SELECT f_get_unitkerja_koderef('$kode') AS NMUNITKERJA FROM DUAL")->row_array();
    }

    public function nama_jabatan($id) {
        return $this->db->query("SELECT JABATAN,KETERANGAN FROM TR_JABATAN WHERE ID=?", [$id])->row_array();
    }
    
    public function jabatan_mutakhir($id) {
        return $this->db->query("SELECT N_JABATAN FROM V_PEGAWAI_JABATAN_MUTAKHIR WHERE TMPEGAWAI_ID=?", [$id])->row_array();
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

    public function insert($var = array(), $tanggal = array()) {
        $this->db->trans_begin();
        $nextid = $this->next_val_id()['NEXT_ID'];
        $this->db->set('ID', $nextid);
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);

        if (isset($tanggal['TMT_ESELON']) && !empty($tanggal['TMT_ESELON'])) {
            $this->db->set('TMT_ESELON', "TO_DATE('" . $tanggal['TMT_ESELON'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TMT_JABATAN']) && !empty($tanggal['TMT_JABATAN'])) {
            $this->db->set('TMT_JABATAN', "TO_DATE('" . $tanggal['TMT_JABATAN'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_AKHIR']) && !empty($tanggal['TGL_AKHIR'])) {
            $this->db->set('TGL_AKHIR', "TO_DATE('" . $tanggal['TGL_AKHIR'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_SK']) && !empty($tanggal['TGL_SK'])) {
            $this->db->set('TGL_SK', "TO_DATE('" . $tanggal['TGL_SK'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_LANTIK']) && !empty($tanggal['TGL_LANTIK'])) {
            $this->db->set('TGL_LANTIK', "TO_DATE('" . $tanggal['TGL_LANTIK'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->insert("TH_PEGAWAI_JABATAN", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return ['message' => TRUE, 'id' => $nextid];
        }
    }

    public function update($var = array(), $tanggal = array(), $id) {
        $this->db->trans_begin();
        if (isset($tanggal['TMT_ESELON']) && !empty($tanggal['TMT_ESELON'])) {
            $this->db->set('TMT_ESELON', "TO_DATE('" . $tanggal['TMT_ESELON'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TMT_JABATAN']) && !empty($tanggal['TMT_JABATAN'])) {
            $this->db->set('TMT_JABATAN', "TO_DATE('" . $tanggal['TMT_JABATAN'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_AKHIR']) && !empty($tanggal['TGL_AKHIR'])) {
            $this->db->set('TGL_AKHIR', "TO_DATE('" . $tanggal['TGL_AKHIR'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_SK']) && !empty($tanggal['TGL_SK'])) {
            $this->db->set('TGL_SK', "TO_DATE('" . $tanggal['TGL_SK'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_LANTIK']) && !empty($tanggal['TGL_LANTIK'])) {
            $this->db->set('TGL_LANTIK', "TO_DATE('" . $tanggal['TGL_LANTIK'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->where('ID', $id);
        $this->db->update("TH_PEGAWAI_JABATAN", $var);
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
        $this->db->delete("TH_PEGAWAI_JABATAN");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function listbkn($id) {
        $this->db->select("N_JABATAN,TMT_JABATAN,TO_CHAR(TMT_JABATAN,'DD/MM/YYYY') as TMT_JABATAN2,TO_CHAR(TGL_SK,'DD/MM/YYYY') as TGL_SK,NO_SK,TPJ.ID,DOC_SKJABATAN,TKJ.KETERANGAN_JABATAN,TRE.ESELON,TRJ.JABATAN");
        $this->db->where("TMPEGAWAI_ID", $id);
        $this->db->from($this->tabel." TPJ");
        $this->db->join("TR_KETERANGAN_JABATAN TKJ", "TKJ.ID=TPJ.TRKETERANGANJABATAN_ID", "LEFT");
        $this->db->join("TR_ESELON TRE", "TRE.ID=TPJ.TRESELON_ID", "LEFT");
        $this->db->join("TR_JABATAN TRJ", "TRJ.ID=TPJ.TRJABATAN_ID", "LEFT");
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_eselon_by_id_bkn($id) {
        $this->db->select("ID,ESELON,ID_BKN,NAMA_BKN,JABATAN_BKN");
        $this->db->from("TR_ESELON");
        $this->db->where('ID_BKN', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_struktur_by_id_bkn($id) {
        $this->db->select("ID,JENIS_UNOR_BKN");
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->where('ID_BKN', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_jabatan_by_id_bkn($id,$jenisjabatan = "") {
        $this->db->select("ID,JABATAN,ID_JABFUNGT_BKN,ID_JABFUNGU_BKN,NAMA_BKN");
        $this->db->from("TR_JABATAN");
        if ($jenisjabatan === 'STRUKTURAL') {
            $this->db->where('ID_STRUKTURAL_BKN', $id);
        }
        if ($jenisjabatan === 'FUNGSIONAL_TERTENTU') {
            $this->db->where('ID_JABFUNGT_BKN', $id);
        }
        if ($jenisjabatan === 'FUNGSIONAL_UMUM') {
            $this->db->where('ID_JABFUNGU_BKN', $id);
        }
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_struktur_bkn($bkn) {
        $getawal = $this->db->query("SELECT * FROM TR_STRUKTUR_ORGANISASI WHERE ");
        $this->db->select("ID,JENIS_UNOR_BKN");
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->where('ID_BKN', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

}
