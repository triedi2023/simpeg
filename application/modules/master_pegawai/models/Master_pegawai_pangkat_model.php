<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_pangkat_model extends CI_Model {

    private $tabel = "TH_PEGAWAI_PANGKAT";
    private $column_order = array(null, 'TMT_GOL'); //set column field database for datatable orderable
    private $order = array('TMT_GOL' => 'DESC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        if ($this->input->post('status')) {
            $this->db->where('STATUS', $this->input->post('status'));
        }
        
        $this->db->where("TMPEGAWAI_ID", $this->input->post('pegawai_id'));
        $this->db->from("MK_GOLONGAN_V");
        $i = 0;

        $this->db->order_by("TMT_GOL", "DESC");
    }

    function get_datatables($id) {
        $this->_get_datatables_query();
        if ($this->input->post('length'))
            if ($this->input->post('length') != -1)
                $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();
        return $query->result();
    }
    
    private function _get_datatables_query_bkn() {

        if ($this->input->post('status')) {
            $this->db->where('STATUS', $this->input->post('status'));
        }
        
        $this->db->where("TMPEGAWAI_ID", $this->input->post('pegawai_id'));
        $this->db->from("MK_GOLONGAN_V");
        $i = 0;

        $this->db->order_by("TMT_GOL", "ASC");
    }

    function get_datatables_bkn($id) {
        $this->_get_datatables_query_bkn();
        if ($this->input->post('length'))
            if ($this->input->post('length') != -1)
                $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function pangkat_mutakhir($id) {
        return $this->db->query("SELECT TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.GOLONGAN,TRG.PANGKAT FROM V_PEGAWAI_PANGKAT_MUTAKHIR VPPM LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=VPPM.TRGOLONGAN_ID) WHERE VPPM.TMPEGAWAI_ID=?", [$id])->row_array();
    }

    function get_by_id($id) {
        $this->db->select("TH_PEGAWAI_PANGKAT.*, to_char(TMT_GOL,'DD/MM/YYYY') as TMT_GOL2, to_char(TGL_SK,'DD/MM/YYYY') as TGL_SK2");
        $this->db->from($this->tabel);
        $this->db->where('ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_by_pegawai_idpangkat($id) {
        $this->db->select("to_char(TMT_GOL,'DD/MM/YYYY') as TMT_GOL,to_char(TGL_SK,'DD/MM/YYYY') as TGL_SK,TRGOLONGAN_ID,NO_SK,PEJABAT_SK,DOC_SKPANGKAT,ID");
        $this->db->from($this->tabel);
        $this->db->where('TMPEGAWAI_ID', $id);
        $this->db->where('TRJENISKENAIKANPANGKAT_ID', 5);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_pangkat_by_nama($nama) {
        $this->db->select("ID");
        $this->db->from('TR_GOLONGAN');
        $this->db->where('LOWER(GOLONGAN)', strtolower($nama));
        $this->db->where('TRSTATUSKEPEGAWAIAN_ID', 1);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_pangkat_by_id($kode) {
        $this->db->select("ID");
        $this->db->from('TR_GOLONGAN');
        $this->db->where('ID', strtolower($kode));
        $this->db->where('TRSTATUSKEPEGAWAIAN_ID', 1);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_jenispangkat_bkn($kode) {
        $this->db->select("ID");
        $this->db->from('TR_JENIS_KENAIKAN_PANGKAT');
        $this->db->where('ID_BKN', strtolower($kode));
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_pangkat_bkn($kode) {
        $this->db->select("ID");
        $this->db->from('TR_GOLONGAN');
        $this->db->where('ID_BKN', strtolower($kode));
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_exist($idpegawai,$trgolonganid,$trkpid,$tmtgol) {
        $this->db->from($this->tabel);
        $this->db->where('TMPEGAWAI_ID', (int)$idpegawai);
        $this->db->where('TRGOLONGAN_ID', $trgolonganid);
        $this->db->where('TRJENISKENAIKANPANGKAT_ID', (int)$trkpid);
        $this->db->where("to_char(TMT_GOL,'YYYY-MM-DD')", (string)trim(str_replace(" ", "", $tmtgol)));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function get_dokumen_by_id($id) {
        $this->db->select("TP.NIP, THPP.DOC_SKPANGKAT");
        $this->db->from($this->tabel." THPP");
        $this->db->join("TM_PEGAWAI TP",'TP.ID=THPP.TMPEGAWAI_ID','JOIN');
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
        return $this->db->query("SELECT TH_PEGAWAI_PANGKAT_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }

    public function insert($var = array(), $tanggal = array()) {
        $this->db->trans_begin();
        $nextid = $this->next_val_id()['NEXT_ID'];
        $this->db->set('ID', $nextid);
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        if (isset($tanggal['TMT_GOL']) && !empty($tanggal['TMT_GOL'])) {
            $this->db->set('TMT_GOL', "TO_DATE('" . $tanggal['TMT_GOL'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_SK']) && !empty($tanggal['TGL_SK'])) {
            $this->db->set('TGL_SK', "TO_DATE('" . $tanggal['TGL_SK'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->insert("TH_PEGAWAI_PANGKAT", $var);
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
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        if (isset($tanggal['TMT_GOL']) && !empty($tanggal['TMT_GOL'])) {
            $this->db->set('TMT_GOL', "TO_DATE('" . $tanggal['TMT_GOL'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_SK']) && !empty($tanggal['TGL_SK'])) {
            $this->db->set('TGL_SK', "TO_DATE('" . $tanggal['TGL_SK'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->where('ID', $id);
        $this->db->update("TH_PEGAWAI_PANGKAT", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function update_bkn($var = array(), $tanggal = array(), $id, $jenis_pangkat) {
        $this->db->trans_begin();
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        if (isset($tanggal['TMT_GOL']) && !empty($tanggal['TMT_GOL'])) {
            $this->db->set('TMT_GOL', "TO_DATE('" . $tanggal['TMT_GOL'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_SK']) && !empty($tanggal['TGL_SK'])) {
            $this->db->set('TGL_SK', "TO_DATE('" . $tanggal['TGL_SK'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->where('ID', $id);
        $this->db->where('TRJENISKENAIKANPANGKAT_ID', $jenis_pangkat);
        $this->db->update("TH_PEGAWAI_PANGKAT", $var);
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
        $this->db->delete("TH_PEGAWAI_PANGKAT");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
