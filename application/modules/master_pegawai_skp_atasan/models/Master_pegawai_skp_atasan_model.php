<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_skp_atasan_model extends CI_Model {

    private $tabel = "TH_PEGAWAI_SKP";
    private $column_order = array(null,'PERIODE', 'PANGKATGOL', 'JABATAN'); //set column field database for datatable orderable
    private $order = array('ID' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {
        $this->db->where('NIP_PEJABAT_PENILAI', $this->session->get_userdata()['nip']);
        $this->db->select("ID, PERIODE_AWAL || ' S/D ' || PERIODE_AKHIR || ' ' || PERIODE_TAHUN AS PERIODE, PANGKAT_YGDINILAI || ' ('||GOLONGAN_YGDINILAI ||')' AS PANGKATGOL, JABATAN_YGDINILAI");
        $this->db->from($this->tabel);

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
        $this->db->select("THS.*,TME.GELAR_DEPAN AS GELAR_DEPAN2,TME.NAMA AS NAMA2,TME.GELAR_BLKG AS GELAR_BLKG2,TMG.GELAR_DEPAN AS GELAR_DEPAN3,TMG.NAMA AS NAMA3,TMG.GELAR_BLKG AS GELAR_BLKG3");
        $this->db->from($this->tabel." THS");
        $this->db->join("TM_PEGAWAI TME", "TME.NIPNEW=THS.NIP_PEJABAT_PENILAI", "LEFT");
        $this->db->join("TM_PEGAWAI TMG", "TMG.NIPNEW=THS.NIP_ATASAN_PEJABAT_PENILAI", "LEFT");
        $this->db->where('THS.ID',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function get_unique_nama_by_id($id,$str) {
        $this->db->from($this->tabel);
        $this->db->where('lower(TINGKAT_PENDIDIKAN)', strtolower(ltrim(rtrim($str))));
        $this->db->where('ID !=',$id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function get_pegawai($id="") {
        $this->db->select("GELAR_DEPAN,NAMA,GELAR_BLKG,NIP,NIPNEW,TGLLAHIR,NO_KTP,TPTLAHIR,N_JABATAN,TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.GOLONGAN,TRG.PANGKAT");
        
        if ($id)
            $this->db->where("TP.NIPNEW", $id);
        else
            $this->db->where("SYSTEMUSER_ID", $this->session->get_userdata()['user_id']);
        
        $this->db->from("SYSTEM_USER_GROUP");
        $this->db->join('TM_PEGAWAI TP', "SYSTEM_USER_GROUP.TMPEGAWAI_ID=TP.ID", "JOIN");
        $this->db->join('V_PEGAWAI_JABATAN_MUTAKHIR VPJM', "VPJM.TMPEGAWAI_ID=TP.ID", "JOIN");
        $this->db->join('V_PEGAWAI_PANGKAT_MUTAKHIR VPPM', "VPPM.TMPEGAWAI_ID=TP.ID", "JOIN");
        $this->db->join('TR_GOLONGAN TRG', "VPPM.TRGOLONGAN_ID=TRG.ID", "LEFT");
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_detail_utama($id) {
        $query = $this->db->query("SELECT TEXT_ARRAY FROM TABLE(SELECT TUGAS_POKOK_JABATAN FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $utama_pokok = $query->result_array();
        
        $query = $this->db->query("SELECT NUMERIC_ARRAY FROM TABLE(SELECT AK_TARGET FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $utama_ak = $query->result_array();
        
        $query = $this->db->query("SELECT INTEGER_ARRAY FROM TABLE(SELECT KUANTITAS_TARGET FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $utama_kuantitas = $query->result_array();
        
        $query = $this->db->query("SELECT INTEGER_ARRAY FROM TABLE(SELECT SATUAN_TARGET FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $utama_satuan = $query->result_array();
        
        $query = $this->db->query("SELECT INTEGER_ARRAY FROM TABLE(SELECT KUALITAS_TARGET FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $utama_kualitas = $query->result_array();
        
        $query = $this->db->query("SELECT INTEGER_ARRAY FROM TABLE(SELECT WAKTU_TARGET FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $utama_waktu = $query->result_array();
        
        $query = $this->db->query("SELECT INTEGER_ARRAY FROM TABLE(SELECT BIAYA_TARGET FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $utama_biaya = $query->result_array();
        
        $query = $this->db->query("SELECT NUMERIC_ARRAY FROM TABLE(SELECT PERHITUNGAN FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $perhitungan = $query->result_array();
        
        $query = $this->db->query("SELECT NUMERIC_ARRAY FROM TABLE(SELECT NILAI_CAPAIAN_SKP FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $nilai = $query->result_array();
        
        $query = $this->db->query("SELECT NUMERIC_ARRAY FROM TABLE(SELECT AK_REALISASI FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $realiasi_ak = $query->result_array();
        
        $query = $this->db->query("SELECT INTEGER_ARRAY FROM TABLE(SELECT KUANTITAS_REALISASI FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $realiasi_kuantitas = $query->result_array();
        
        $query = $this->db->query("SELECT INTEGER_ARRAY FROM TABLE(SELECT SATUAN_REALISASI FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $realiasi_satuan = $query->result_array();
        
        $query = $this->db->query("SELECT INTEGER_ARRAY FROM TABLE(SELECT KUALITAS_REALISASI FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $realiasi_kualitas = $query->result_array();
        
        $query = $this->db->query("SELECT INTEGER_ARRAY FROM TABLE(SELECT WAKTU_REALISASI FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $realiasi_waktu = $query->result_array();
        
        $query = $this->db->query("SELECT INTEGER_ARRAY FROM TABLE(SELECT BIAYA_REALISASI FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=1)",[$id]);
        $realiasi_biaya = $query->result_array();
        
        return ['utama_pokok'=>$utama_pokok,'utama_ak'=>$utama_ak,'utama_kuantitas'=>$utama_kuantitas,'utama_satuan'=>$utama_satuan,
        'utama_kualitas'=>$utama_kualitas,'utama_waktu'=>$utama_waktu,'utama_biaya'=>$utama_biaya,'perhitungan'=>$perhitungan,
        'nilai'=>$nilai,'realiasi_ak'=>$realiasi_ak,'realiasi_kuantitas'=>$realiasi_kuantitas,'realiasi_satuan'=>$realiasi_satuan,'realiasi_kualitas'=>$realiasi_kualitas,'realiasi_waktu'=>$realiasi_waktu,'realiasi_biaya'=>$realiasi_biaya];
    }
    
    function get_detail_tambahan($id) {
        $query = $this->db->query("SELECT TEXT_ARRAY FROM TABLE(SELECT TUGAS_POKOK_JABATAN FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=2)",[$id]);
        $tambahan = $query->result_array();
        
        return $tambahan;
    }
    
    function get_detail_kreativitas($id) {
        $query = $this->db->query("SELECT TEXT_ARRAY FROM TABLE(SELECT TUGAS_POKOK_JABATAN FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=3)",[$id]);
        $kreativitas = $query->result_array();
        
        return $kreativitas;
    }
    
    function get_detail_kreativitas_nilai($id) {
        $query = $this->db->query("SELECT NUMERIC_ARRAY FROM TABLE(SELECT NILAI_CAPAIAN_SKP FROM TH_PEGAWAI_SKP_DETAIL WHERE THPEGAWAISKP_ID=? and KATEGORI=3)",[$id]);
        $kreativitas = $query->result_array();
        
        return $kreativitas;
    }
    
    function get_perilakukerja($id) {
        $query = $this->db->query("SELECT * FROM TH_PEGAWAI_SKP_PERILAKUKERJA WHERE THPEGAWAISKP_ID=?",[$id]);
        $kreativitas = $query->row_array();
        
        return $kreativitas;
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
        return $this->db->query("SELECT TH_PEGAWAI_SKP_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }

    public function insert($var = array()) {
        $this->db->trans_begin();
        $nextid = $this->next_val_id()['NEXT_ID'];
        $this->db->set("ID", $nextid, FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->insert("TH_PEGAWAI_SKP", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return ['message' => TRUE, 'id' => $nextid];
        }
    }
    
    public function update($var = array(),$id) {
        $this->db->trans_begin();
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->where('ID',$id);
        $this->db->update("TH_PEGAWAI_SKP", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function insert_detail($var = array()) {
        $this->db->trans_begin();
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        if (isset($var['TUGAS_POKOK_JABATAN'])) {
            $this->db->set('TUGAS_POKOK_JABATAN', $var['TUGAS_POKOK_JABATAN'], FALSE);
        }
        if (isset($var['AK_TARGET'])) {
            $this->db->set('AK_TARGET', $var['AK_TARGET'], FALSE);
        }
        if (isset($var['KUANTITAS_TARGET'])) {
            $this->db->set('KUANTITAS_TARGET', $var['KUANTITAS_TARGET'], FALSE);
        }
        if (isset($var['SATUAN_TARGET'])) {
            $this->db->set('SATUAN_TARGET', $var['SATUAN_TARGET'], FALSE);
        }
        if (isset($var['KUALITAS_TARGET'])) {
            $this->db->set('KUALITAS_TARGET', $var['KUALITAS_TARGET'], FALSE);
        }
        if (isset($var['WAKTU_TARGET'])) {
            $this->db->set('WAKTU_TARGET', $var['WAKTU_TARGET'], FALSE);
        }
        if (isset($var['BIAYA_TARGET'])) {
            $this->db->set('BIAYA_TARGET', $var['BIAYA_TARGET'], FALSE);
        }
        $isi = [
            'THPEGAWAISKP_ID' => $var['THPEGAWAISKP_ID'],
            'KATEGORI' => $var['KATEGORI']
        ];
        $this->db->insert("TH_PEGAWAI_SKP_DETAIL", $isi);
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
        $this->db->where('ID',$id);
        $this->db->delete("TH_PEGAWAI_SKP");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
