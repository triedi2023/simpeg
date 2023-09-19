<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pegawai_lengkap_model extends CI_Model {

    private $column_order = array(null, 'GELAR_BLKG', 'NAMA', 'GELAR_DEPAN', 'NIPNEW'); //set column field database for datatable orderable
    private $column_search = array('NAMA', 'NIPNEW', 'GELAR_DEPAN', 'GELAR_BLKG'); //set column field database for datatable searchable 
    private $order = array('ID' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        $this->db->where("VPJM.TRESELON_ID <> ", '17');
        if (isset($_POST['tipe']) && $_POST['tipe'] == 3) {
            $this->db->where("VPJM.TRESELON_ID", '13');
        }
        if (isset($_POST['tipe']) && $_POST['tipe'] == 4) {
            $this->db->where("VPJM.TRESELON_ID", '15');
        }
        if (isset($_POST['jabatan']) && !empty($_POST['jabatan']) && in_array($_POST['tipe'],[3,4])) {
            $this->db->where("VPJM.TRJABATAN_ID", $_POST['jabatan']);
        }
        
        if (isset($_POST['nama_nip']) && $_POST['nama_nip'] != '') {
            $this->db->where("(lower(TP.NAMA) LIKE '%".strtolower($this->input->post('nama_nip', false))."%' OR lower(NIP) = '".strtolower($this->input->post('nama_nip', false))."' OR lower(NIPNEW) = '".strtolower($this->input->post('nama_nip', false))."')");
        }
        
        if (isset($_POST['trlokasi_id']) && $_POST['trlokasi_id'] != '') {
            $this->db->where("VPJM.TRLOKASI_ID",$this->input->post('trlokasi_id', false));
        }
        if (isset($_POST['kdu1']) && $_POST['kdu1'] != '') {
            $this->db->where("VPJM.KDU1",$this->input->post('kdu1', false));
        }
        if (isset($_POST['kdu2']) && $_POST['kdu2'] != '') {
            $this->db->where("VPJM.KDU2",$this->input->post('kdu2', false));
        }
        if (isset($_POST['kdu3']) && $_POST['kdu3'] != '') {
            $this->db->where("VPJM.KDU3",$this->input->post('kdu3', false));
        }
        if (isset($_POST['kdu4']) && $_POST['kdu4'] != '') {
            $this->db->where("VPJM.KDU4",$this->input->post('kdu4', false));
        }
        
        $this->db->select("TP.GELAR_DEPAN,TP.NAMA,TP.GELAR_BLKG,TP.FOTO,TP.NIPNEW,TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.PANGKAT,TRG.GOLONGAN,
        VPJM.N_JABATAN,TO_CHAR(VPJM.TMT_JABATAN,'DD/MM/YYYY') AS TMT_JABATAN,TO_CHAR(TP.TGLLAHIR,'DD/MM/YYYY') AS TGLLAHIR,TO_CHAR(VPPM.TMT_GOL,'DD/MM/YYYY') AS TMT_GOL,
        AGE_YEAR(SYSDATE,TP.TGLLAHIR) || ' Tahun ' || AGE_MONTH(SYSDATE,TP.TGLLAHIR) || ' Bulan '||AGE_DAY(SYSDATE,TP.TGLLAHIR)||' Hari' AS UMUR,
        AGE_YEAR(SYSDATE,VPJM.TMT_JABATAN) || ' Tahun ' || AGE_MONTH(SYSDATE,VPJM.TMT_JABATAN) || ' Bulan '||AGE_DAY(SYSDATE,VPJM.TMT_JABATAN)||' Hari' AS MK_JABATAN");
        $this->db->from("TM_PEGAWAI TP");
        $this->db->join("V_PEGAWAI_JABATAN_MUTAKHIR VPJM", "TP.ID=VPJM.TMPEGAWAI_ID","LEFT");
        $this->db->join("V_PEGAWAI_PANGKAT_MUTAKHIR VPPM", "TP.ID=VPPM.TMPEGAWAI_ID","LEFT");
        $this->db->join("TR_GOLONGAN TRG", "VPPM.TRGOLONGAN_ID=TRG.ID","LEFT");
        
        if (isset($_POST['jabatan']) && !empty($_POST['jabatan']) && $_POST['tipe'] == 2) {
            $this->db->where_not_in("VPJM.TRESELON_ID",['13','15']);
            $this->db->where("TRE.SINGKATAN", $_POST['jabatan']);
            $this->db->join("TR_ESELON TRE", "VPJM.TRESELON_ID=TRE.ID","LEFT");
        }
        if (isset($_POST['jabatan']) && !empty($_POST['jabatan']) && $_POST['tipe'] == 5) {
            $this->db->where("VPDM.TRTINGKATDIKLATKEPEMIMPINAN_ID", $_POST['jabatan']);
            $this->db->join("TH_PEGAWAI_DIKLAT_PENJENJANGAN VPDM","TP.ID=VPDM.TMPEGAWAI_ID","LEFT");
        }
        if (isset($_POST['jabatan']) && !empty($_POST['jabatan']) && $_POST['tipe'] == 6) {
            $this->db->where("TPPU.TRTINGKATPENDIDIKAN_ID", $_POST['jabatan']);
            $this->db->join("V_PEGAWAI_PENDIDIKAN_MUTAKHIR TPPU","TP.ID=TPPU.TMPEGAWAI_ID","LEFT");
        }
        
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
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }
    
    public function cetak_excel_query() {

        $this->db->where("VPJM.TRESELON_ID <> ", '17');
        if (isset($_GET['tipe']) && $_GET['tipe'] == 3) {
            $this->db->where("VPJM.TRESELON_ID", '13');
        }
        if (isset($_GET['tipe']) && $_GET['tipe'] == 4) {
            $this->db->where("VPJM.TRESELON_ID", '15');
        }
        if (isset($_GET['jabatan']) && !empty($_GET['jabatan']) && in_array($_GET['tipe'],[3,4])) {
            $this->db->where("VPJM.TRJABATAN_ID", $_GET['jabatan']);
        }
        
        if (isset($_GET['nama']) && $_GET['nama'] != '') {
            $this->db->like("lower(NAMA)", strtolower($this->input->get('nama', false)));
        }
        
        if (isset($_GET['trlokasi_id']) && $_GET['trlokasi_id'] != '') {
            $this->db->where("VPJM.TRLOKASI_ID",$this->input->get('trlokasi_id', false));
        }
        if (isset($_GET['kdu1']) && $_GET['kdu1'] != '') {
            $this->db->where("VPJM.KDU1",$this->input->get('kdu1', false));
        }
        if (isset($_GET['kdu2']) && $_GET['kdu2'] != '') {
            $this->db->where("VPJM.KDU2",$this->input->get('kdu2', false));
        }
        if (isset($_GET['kdu3']) && $_GET['kdu3'] != '') {
            $this->db->where("VPJM.KDU3",$this->input->get('kdu3', false));
        }
        if (isset($_GET['kdu4']) && $_GET['kdu4'] != '') {
            $this->db->where("VPJM.KDU4",$this->input->get('kdu4', false));
        }
        
        $this->db->select("TP.GELAR_DEPAN,TP.NAMA,TP.GELAR_BLKG,TP.FOTO,TP.NIPNEW,TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.PANGKAT,TRG.GOLONGAN,
        VPJM.N_JABATAN,TO_CHAR(VPJM.TMT_JABATAN,'DD/MM/YYYY') AS TMT_JABATAN,TO_CHAR(TP.TGLLAHIR,'DD/MM/YYYY') AS TGLLAHIR,TO_CHAR(VPPM.TMT_GOL,'DD/MM/YYYY') AS TMT_GOL,
        AGE_YEAR(SYSDATE,TP.TGLLAHIR) || ' Tahun ' || AGE_MONTH(SYSDATE,TP.TGLLAHIR) || ' Bulan '||AGE_DAY(SYSDATE,TP.TGLLAHIR)||' Hari' AS UMUR,
        AGE_YEAR(SYSDATE,VPJM.TMT_JABATAN) || ' Tahun ' || AGE_MONTH(SYSDATE,VPJM.TMT_JABATAN) || ' Bulan '||AGE_DAY(SYSDATE,VPJM.TMT_JABATAN)||' Hari' AS MK_JABATAN");
        $this->db->from("TM_PEGAWAI TP");
        $this->db->join("V_PEGAWAI_JABATAN_MUTAKHIR VPJM", "TP.ID=VPJM.TMPEGAWAI_ID","LEFT");
        $this->db->join("V_PEGAWAI_PANGKAT_MUTAKHIR VPPM", "TP.ID=VPPM.TMPEGAWAI_ID","LEFT");
        $this->db->join("TR_GOLONGAN TRG", "VPPM.TRGOLONGAN_ID=TRG.ID","JOIN");
        
        if (isset($_GET['jabatan']) && !empty($_GET['jabatan']) && $_GET['tipe'] == 2) {
            $this->db->where_not_in("VPJM.TRESELON_ID",['13','15']);
            $this->db->where("TRE.SINGKATAN", $_GET['jabatan']);
            $this->db->join("TR_ESELON TRE", "VPJM.TRESELON_ID=TRE.ID","LEFT");
        }
        if (isset($_GET['jabatan']) && !empty($_GET['jabatan']) && $_GET['tipe'] == 5) {
            $this->db->where("VPDM.TRTINGKATDIKLATKEPEMIMPINAN_ID", $_GET['jabatan']);
            $this->db->join("TH_PEGAWAI_DIKLAT_PENJENJANGAN VPDM","TP.ID=VPDM.TMPEGAWAI_ID","JOIN");
        }
        if (isset($_GET['jabatan']) && !empty($_GET['jabatan']) && $_GET['tipe'] == 6) {
            $this->db->where("TPPU.TRTINGKATPENDIDIKAN_ID", $_GET['jabatan']);
            $this->db->join("V_PEGAWAI_PENDIDIKAN_MUTAKHIR TPPU","TP.ID=TPPU.TMPEGAWAI_ID","LEFT");
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_struktur($lok='2',$kdu1='00',$kdu2='00',$kdu3='000',$kdu4='000',$kdu5='00') {
        $param = $lok.";".$kdu1.";".$kdu2.";".$kdu3.";".$kdu4.";".$kdu5;
        $sql = "SELECT F_GET_UNITKERJA_KODEREF('$param') AS NMSTRUKTUR FROM DUAL";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    
}
