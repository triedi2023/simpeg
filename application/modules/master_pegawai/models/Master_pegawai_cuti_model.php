<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_cuti_model extends CI_Model {

    private $tabel = "TH_PEGAWAI_CUTI";
    private $column_order = array(null, 'NAMA_CUTI', 'PERIODE', 'LAMA'); //set column field database for datatable orderable
    private $order = array('TH_PEGAWAI_CUTI.TMT_HKMN' => 'DESC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        if ($this->input->post('status')) {
            $this->db->where('TH_PEGAWAI_CUTI.STATUS', $this->input->post('status'));
        }

        $this->db->select("TH_PEGAWAI_CUTI.ID,NAMA_CUTI,LAMA,TO_CHAR(TGL_MULAI,'DD/MM/YYYY')||' - '||TO_CHAR(TGL_AKHIR,'DD/MM/YYYY') AS PERIODE");
        $this->db->join("TR_CUTI", "(TR_CUTI.ID=TH_PEGAWAI_CUTI.TRCUTI_ID)", "LEFT");
        $this->db->from($this->tabel);
        $this->db->where("TMPEGAWAI_ID", $this->input->post('pegawai_id'));
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

        $this->db->where("TMPEGAWAI_ID", $id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_by_id($id) {
        $this->db->select("TH_PEGAWAI_CUTI.*,TO_CHAR(TGL_MULAI,'DD/MM/YYYY') as TGL_MULAI2,TO_CHAR(TGL_AKHIR,'DD/MM/YYYY') as TGL_AKHIR2,TO_CHAR(TGL_PENGAJUAN,'DD/MM/YYYY') as TGL_PENGAJUAN2,TO_CHAR(TGL_PERSETUJUAN,'DD/MM/YYYY') as TGL_PERSETUJUAN2");
        $this->db->from($this->tabel);
        $this->db->where('ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_pegawai_by_id($id) {
        $this->db->select("TM_PEGAWAI.*,TH_PEGAWAI_CUTI.*,TO_CHAR(TGL_MULAI,'DD/MM/YYYY') as TGL_MULAI2,TO_CHAR(TGL_AKHIR,'DD/MM/YYYY') as TGL_AKHIR2,TO_CHAR(TGL_PENGAJUAN,'DD/MM/YYYY') as TGL_PENGAJUAN2,TO_CHAR(TGL_PERSETUJUAN,'DD/MM/YYYY') as TGL_PERSETUJUAN2,
        AGE_YEAR(SYSDATE,TPC.TMT_CPNS) + (TPC.FIKTIF_TAHUN+TPC.HONORER_TAHUN+TPC.SWASTA_TAHUN) AS MK_THN_TOTAL,
        AGE_MONTH(SYSDATE,TPC.TMT_CPNS) + (TPC.FIKTIF_BULAN+TPC.HONORER_BULAN+TPC.SWASTA_BULAN) AS MK_BLN_TOTAL");
        $this->db->from($this->tabel);
        $this->db->join("TM_PEGAWAI", "(TM_PEGAWAI.ID=TH_PEGAWAI_CUTI.TMPEGAWAI_ID)", "INNER");
        $this->db->join("TH_PEGAWAI_CPNS TPC", "(TM_PEGAWAI.ID=TPC.TMPEGAWAI_ID)", "LEFT");
        $this->db->join("TR_CUTI", "(TR_CUTI.ID=TH_PEGAWAI_CUTI.TRCUTI_ID)", "LEFT");
        $this->db->where('TH_PEGAWAI_CUTI.ID', $id);
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
        return $this->db->query("SELECT TH_PEGAWAI_CUTI_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }

    public function insert($var = array(),$tanggal = array()) {
        $this->db->trans_begin();
        $nextid = $this->next_val_id()['NEXT_ID'];
        $this->db->set('ID', $nextid);
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        if (isset($tanggal['TGL_MULAI']) && !empty($tanggal['TGL_MULAI'])) {
            $this->db->set('TGL_MULAI', "TO_DATE('" . $tanggal['TGL_MULAI'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_AKHIR']) && !empty($tanggal['TGL_AKHIR'])) {
            $this->db->set('TGL_AKHIR', "TO_DATE('" . $tanggal['TGL_AKHIR'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_PENGAJUAN']) && !empty($tanggal['TGL_PENGAJUAN'])) {
            $this->db->set('TGL_PENGAJUAN', "TO_DATE('" . $tanggal['TGL_PENGAJUAN'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_PERSETUJUAN']) && !empty($tanggal['TGL_PERSETUJUAN'])) {
            $this->db->set('TGL_PERSETUJUAN', "TO_DATE('" . $tanggal['TGL_PERSETUJUAN'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->insert("TH_PEGAWAI_CUTI", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return ['message' => TRUE, 'id' => $nextid];
        }
    }

    public function update($var = array(),$tanggal = array(), $id) {
        $this->db->trans_begin();
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        if (isset($tanggal['TGL_MULAI']) && !empty($tanggal['TGL_MULAI'])) {
            $this->db->set('TGL_MULAI', "TO_DATE('" . $tanggal['TGL_MULAI'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_AKHIR']) && !empty($tanggal['TGL_AKHIR'])) {
            $this->db->set('TGL_AKHIR', "TO_DATE('" . $tanggal['TGL_AKHIR'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_PENGAJUAN']) && !empty($tanggal['TGL_PENGAJUAN'])) {
            $this->db->set('TGL_PENGAJUAN', "TO_DATE('" . $tanggal['TGL_PENGAJUAN'] . "','YYYY-MM-DD')", FALSE);
        }
        if (isset($tanggal['TGL_PERSETUJUAN']) && !empty($tanggal['TGL_PERSETUJUAN'])) {
            $this->db->set('TGL_PERSETUJUAN', "TO_DATE('" . $tanggal['TGL_PERSETUJUAN'] . "','YYYY-MM-DD')", FALSE);
        }
        $this->db->where('ID', $id);
        $this->db->update("TH_PEGAWAI_CUTI", $var);
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
        $this->db->delete("TH_PEGAWAI_CUTI");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function cekHariLibur($tgllibur) {
        $find = $this->db->query("SELECT * FROM TR_HARI_LIBUR WHERE TO_CHAR(TGL_LIBUR,'YYYY-MM-DD') = '$tgllibur' ");
        return $find->num_rows();
    }
    
    public function cekHariLaranganCuti($tglawal,$tglakhir) {
        $find = $this->db->query("SELECT * FROM TR_PERIODE_LARANGAN_CUTI WHERE PERIODE_LARANGAN_CUTI BETWEEN TO_DATE('$tglawal','YYYY-MM-DD') AND TO_DATE('$tglakhir','YYYY-MM-DD') ");
        return $find->num_rows();
    }

}
