<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pegawai_model extends CI_Model {

    private $tabel = "TM_PEGAWAI";
    private $column_order = array(null, 'NAMA', 'NIPNEW', 'PANGKAT', 'TMT_GOL', 'N_JABATAN', 'TMT_JABATAN'); //set column field database for datatable orderable
    private $column_search = array('NIP', 'NAMA', 'TPTLAHIR', 'TGLLAHIR'); //set column field database for datatable searchable 
    private $order = array('VPJM.TRESELON_ID' => 'ASC', 'VPJM.TRLOKASI_ID' => 'ASC', 'VPJM.KDU1' => 'ASC', 'VPJM.KDU2' => 'ASC', 'VPJM.KDU3' => 'ASC', 'VPJM.KDU4' => 'ASC', 'VPJM.KDU5' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($tipe = "",$count=0) {
        $this->db->from($this->tabel . " TP");

        if ($this->session->get_userdata()['idgroup'] == 3) {
            $this->db->where('TP.NIPNEW', $this->session->get_userdata()['nip']);
            if ($count==0) {
                $this->db->select("TP.ID,TP.GELAR_DEPAN,TP.NAMA,TP.GELAR_BLKG,TP.NIPNEW,TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.GOLONGAN,TRG.PANGKAT,TO_CHAR(VPPM.TMT_GOL,'DD/MM/YYYY') AS TMT_GOL,VPJM.N_JABATAN,TO_CHAR(VPJM.TMT_JABATAN, 'DD/MM/YYYY') AS TMT_JABATAN");
                if ($this->input->post('nama')) {
                    $this->db->like('lower(TP.NAMA)', strtolower(ltrim(rtrim($this->input->post('nama', TRUE)))));
                }
            }
            $this->db->join("V_PEGAWAI_PANGKAT_MUTAKHIR VPPM", "VPPM.TMPEGAWAI_ID=TP.ID", "LEFT");
            $this->db->join("TR_GOLONGAN TRG", "TRG.ID=VPPM.TRGOLONGAN_ID", "LEFT");
            $this->db->join("V_PEGAWAI_JABATAN_MUTAKHIR VPJM", "VPJM.TMPEGAWAI_ID=TP.ID", "LEFT");
        } else {
            if ($this->input->post('nip')) {
                $this->db->where('TP.NIP', trim($this->input->post('nip', TRUE)));
                $this->db->or_where('TP.NIPNEW', trim($this->input->post('nip', TRUE)));
            }

            if ($this->input->post('pegawaibaru') == "true") {
                if ($count==0) {
                    $this->db->select("TP.ID,TP.GELAR_DEPAN,TP.NAMA,TP.GELAR_BLKG,TP.NIPNEW,'' AS TRSTATUSKEPEGAWAIAN_ID,'' AS PANGKAT,'' AS GOLONGAN,'' AS TMT_GOL,'' AS N_JABATAN,'' AS TMT_JABATAN");
                    if ($this->input->post('nama')) {
                        $this->db->like('lower(TP.NAMA)', strtolower(ltrim(rtrim($this->input->post('nama', TRUE)))));
                    }
                }
            }
            if (!isset($_POST['pegawaibaru']) || $this->input->post('pegawaibaru') == "false") {
                if ($tipe == 1) {
                    $setarray = '';
                    if (isset($this->session->userdata('config')['kode_struktural']) && $this->session->userdata('config')['kode_struktural'] != "") {
                        $setarray = $this->session->userdata('config')['kode_struktural'];
                    }
                    $this->db->where_in('VPJM.TRESELON_ID', $setarray, false);
                } elseif ($tipe == 2) {
                    $this->db->where('VPJM.TRESELON_ID',isset($this->session->userdata('config')['kode_fungsional_tertentu']) && $this->session->userdata('config')['kode_fungsional_tertentu'] != "" ? $this->session->userdata('config')['kode_fungsional_tertentu'] : '0');
//                    $this->db->where('VPJM.TRESELON_ID =', (isset($this->session->userdata('config')['kode_fungsional_umum']) && $this->session->userdata('config')['kode_fungsional_umum'] != "") ? $this->session->userdata('config')['kode_fungsional_umum'] : '0');
                }

                if ($this->input->post('eselon_id')) {
                    if ($this->input->post('eselon_id') == 18) {
                        $this->db->where_in('TP.TRSTATUSKEPEGAWAIAN_ID', [4,5,6], false);
                        $this->db->where('VPJM.TRESELON_ID !=', (isset($this->session->userdata('config')['kode_pensiun']) && $this->session->userdata('config')['kode_pensiun'] != "") ? $this->session->userdata('config')['kode_pensiun'] : '0');
                    } else {
                        $this->db->where('VPJM.TRESELON_ID', $this->input->post('eselon_id', TRUE));
                    }
                } else {
                    $this->db->where('VPJM.TRESELON_ID !=', (isset($this->session->userdata('config')['kode_pensiun']) && $this->session->userdata('config')['kode_pensiun'] != "") ? $this->session->userdata('config')['kode_pensiun'] : '0');
                }

                if ($this->input->post('nama')) {
                    $this->db->like('lower(TP.NAMA)', strtolower(ltrim(rtrim($this->input->post('nama', TRUE)))));
                }

                if ($this->input->post('statpeg_id')) {
                    $this->db->where('TP.TRSTATUSKEPEGAWAIAN_ID', trim($this->input->post('statpeg_id', TRUE)));
                }

                if ($this->input->post('gol_id') && $this->input->post('gol_id') != '-1') {
                    $this->db->where('VPPM.TRGOLONGAN_ID', trim($this->input->post('gol_id', TRUE)));
                }

                if ($this->input->post('jabatan_id') && $_POST['jabatan_id'] != '-1') {
                    $this->db->where('VPJM.TRJABATAN_ID', trim($this->input->post('jabatan_id', TRUE)));
                }

                if ($this->input->post('status_nikah_id')) {
                    $this->db->where('TP.TRSTATUSPERNIKAHAN_ID', trim($this->input->post('status_nikah_id', TRUE)));
                }

                if ($this->input->post('jk_id')) {
                    $this->db->where('upper(TP.SEX)', strtoupper(trim($this->input->post('jk_id', TRUE))));
                }

                if ($this->input->post('lokasi_id') && $this->input->post('lokasi_id') != '-1') {
                    $this->db->where('VPJM.TRLOKASI_ID', trim($this->input->post('lokasi_id', TRUE)));
                }
                if ($this->input->post('kdu1_id') && $this->input->post('kdu1_id') != '-1') {
                    $this->db->where('VPJM.KDU1', trim($this->input->post('kdu1_id', TRUE)));
                }
                if ($this->input->post('kdu2_id') && $this->input->post('kdu2_id') != '-1') {
                    $this->db->where('VPJM.KDU2', trim($this->input->post('kdu2_id', TRUE)));
                }
                if ($this->input->post('kdu3_id') && $this->input->post('kdu3_id') != '-1') {
                    $this->db->where('VPJM.KDU3', trim($this->input->post('kdu3_id', TRUE)));
                }
                if ($this->input->post('kdu4_id') && $this->input->post('kdu4_id') != '-1') {
                    $this->db->where('VPJM.KDU4', trim($this->input->post('kdu4_id', TRUE)));
                }
                if ($this->input->post('kdu5_id') && $this->input->post('kdu5_id') != '-1') {
                    $this->db->where('VPJM.KDU5', trim($this->input->post('kdu5_id', TRUE)));
                }

                $select = '';
                if ($_POST['order'][0]['column'] == 0) {
                    $select = ", ROW_NUMBER() OVER(ORDER BY VPJM.TRESELON_ID,VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5) AS daftarpegawai ";
                }

                if ($count==0)
                    $this->db->select("TP.ID,TP.GELAR_DEPAN,TP.NAMA,TP.GELAR_BLKG,TP.NIPNEW,TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.GOLONGAN,TRG.PANGKAT,TO_CHAR(VPPM.TMT_GOL,'DD/MM/YYYY') AS TMT_GOL,VPJM.N_JABATAN,TO_CHAR(VPJM.TMT_JABATAN, 'DD/MM/YYYY') AS TMT_JABATAN, VPJM.TRESELON_ID,VPJM.TRLOKASI_ID,VPJM.KDU1,VPJM.KDU2,VPJM.KDU3,VPJM.KDU4,VPJM.KDU5" . $select);
                
                $this->db->join("V_PEGAWAI_PANGKAT_MUTAKHIR VPPM", "VPPM.TMPEGAWAI_ID=TP.ID", "LEFT");
                $this->db->join("TR_GOLONGAN TRG", "TRG.ID=VPPM.TRGOLONGAN_ID", "LEFT");
                $this->db->join("V_PEGAWAI_JABATAN_MUTAKHIR VPJM", "VPJM.TMPEGAWAI_ID=TP.ID", "LEFT");

                if ($this->input->post('kel_fung_id')) {
                    $this->db->join("TR_JABATAN TRJ", "TRJ.ID=VPJM.TRJABATAN_ID", "LEFT");
                    $this->db->where('TRJ.TRKELOMPOKFUNGSIONAL_ID', trim($this->input->post('kel_fung_id', TRUE)));
                }

                if ($this->input->post('pendidikan_id')) {
                    $this->db->join("V_PEGAWAI_PENDIDIKAN_MUTAKHIR VPEM", "VPEM.TMPEGAWAI_ID=TP.ID", "LEFT");
                    $this->db->where('VPEM.TRTINGKATPENDIDIKAN_ID', trim($this->input->post('pendidikan_id', TRUE)));
                }

                if ($this->input->post('diklatpim_id')) {
                    $this->db->join("TH_PEGAWAI_DIKLAT_PENJENJANGAN TPDP", "TPDP.TMPEGAWAI_ID=TP.ID", "LEFT");
                    $this->db->where('TPDP.TRTINGKATDIKLATKEPEMIMPINAN_ID', trim($this->input->post('diklatpim_id', TRUE)));
                }
            }
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
            if ($this->input->post('pegawaibaru') != "true" && $_POST['order'][0]['column'] == 0) {
                $this->db->order_by("CASE WHEN TRESELON_ID <= '10' THEN TRESELON_ID||TRLOKASI_ID||KDU1||KDU2||KDU3||KDU4||KDU5 END ASC");
                $this->db->order_by("CASE WHEN TRESELON_ID >= '11' THEN GOLONGAN END DESC");
                $this->db->order_by("ID ASC");
            } else
                $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables($tipe = "") {
        $this->_get_datatables_query($tipe);
        if ($this->input->post('length'))
            if ($this->input->post('length') != -1)
                $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();
		//echo $this->db->last_query(); exit;
        return $query->result();
    }

    public function jabatan_mutakhir($id) {
        return $this->db->query("SELECT N_JABATAN,TRE.ESELON,TRJ.JABATAN,VPJM.NMUNIT FROM V_PEGAWAI_JABATAN_MUTAKHIR VPJM LEFT JOIN TR_ESELON TRE ON (TRE.ID=VPJM.TRESELON_ID)"
        . " LEFT JOIN TR_JABATAN TRJ ON (TRJ.ID=VPJM.TRJABATAN_ID) WHERE VPJM.TMPEGAWAI_ID=?", [$id])->row_array();
    }

    public function pangkat_mutakhir($id) {
        return $this->db->query("SELECT TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.GOLONGAN,TRG.PANGKAT,TO_CHAR(TMT_GOL,'DD/MM/YYYY') AS TMT_GOL2 FROM V_PEGAWAI_PANGKAT_MUTAKHIR VPPM LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=VPPM.TRGOLONGAN_ID) WHERE VPPM.TMPEGAWAI_ID=?", [$id])->row_array();
    }

    public function pendidikan_mutakhir($id) {
        return $this->db->query("SELECT TTP.TINGKAT_PENDIDIKAN FROM V_PEGAWAI_PENDIDIKAN_MUTAKHIR VPPM LEFT JOIN TR_TINGKAT_PENDIDIKAN TTP ON (TTP.ID=VPPM.TRTINGKATPENDIDIKAN_ID) WHERE VPPM.TMPEGAWAI_ID=?", [$id])->row_array();
    }

    function get_by_id($id) {
        $this->db->select("TMP.*,to_char(TGLLAHIR,'DD/MM/YYYY') AS TGLLAHIR2,TA.AGAMA,TSP.NAMA AS PERNIKAHAN");
        $this->db->from($this->tabel . " TMP ");
        $this->db->join("TR_AGAMA TA", "TA.ID=TMP.TRAGAMA_ID", "LEFT");
        $this->db->join("TR_STATUS_PERNIKAHAN TSP", "TSP.ID=TMP.TRSTATUSPERNIKAHAN_ID", "LEFT");
        $this->db->where('TMP.ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_by_nipnew($nipnew='') {
        $this->db->select("TMP.*,to_char(TGLLAHIR,'DD-MM-YYYY') AS TGLLAHIR2,TA.AGAMA,TSP.NAMA AS PERNIKAHAN");
        $this->db->from($this->tabel . " TMP ");
        $this->db->join("TR_AGAMA TA", "TA.ID=TMP.TRAGAMA_ID", "LEFT");
        $this->db->join("TR_STATUS_PERNIKAHAN TSP", "TSP.ID=TMP.TRSTATUSPERNIKAHAN_ID", "LEFT");
        $this->db->where('TMP.NIPNEW', trim($nipnew));
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_by_nipnewskp($nipnew='') {
        $this->db->select("TMP.*,to_char(TGLLAHIR,'DD-MM-YYYY') AS TGLLAHIR2,TA.AGAMA,TSP.NAMA AS PERNIKAHAN,VPJM.TRESELON_ID");
        $this->db->from($this->tabel . " TMP ");
        $this->db->join("TR_AGAMA TA", "TA.ID=TMP.TRAGAMA_ID", "LEFT");
        $this->db->join("TR_STATUS_PERNIKAHAN TSP", "TSP.ID=TMP.TRSTATUSPERNIKAHAN_ID", "LEFT");
        $this->db->join("V_PEGAWAI_JABATAN_MUTAKHIR VPJM", "TMP.ID=VPJM.TMPEGAWAI_ID", "LEFT");
        $this->db->where('TMP.NIPNEW', trim($nipnew));
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_by_nipnew_bkn($nipnew='') {
        $this->db->select("TMP.*,to_char(TGLLAHIR,'DD-MM-YYYY') AS TGLLAHIR2,TA.AGAMA,TSP.NAMA AS PERNIKAHAN,to_char(TPC.TMT_CPNS,'DD-MM-YYYY') AS TMT_CPNS2,
        VPM.NO_SK AS NO_SK_CPNS,to_char(VPM.TGL_SK,'DD-MM-YYYY') AS TGL_SK_CPNS,to_char(VPPM.TMT_GOL,'DD-MM-YYYY') AS TMT_PNS,VPPM.NO_SK AS NO_SK_PNS,to_char(VPPM.TGL_SK,'DD-MM-YYYY') AS TGL_SK_PNS,
        TPP.NO_STLK,to_char(TPP.TGL_STLK,'DD-MM-YYYY') AS TGL_STLK,TPP.NO_NAPZA,to_char(TPP.TGL_NAPZA,'DD-MM-YYYY') AS TGL_NAPZA");
        $this->db->from($this->tabel . " TMP ");
        $this->db->join("TH_PEGAWAI_CPNS TPC", "TPC.TMPEGAWAI_ID=TMP.ID", "LEFT");
        $this->db->join("TH_PEGAWAI_PNS TPP", "TPP.TMPEGAWAI_ID=TMP.ID", "LEFT");
        $this->db->join("TR_STATUS_PERNIKAHAN TSP", "TSP.ID=TMP.TRSTATUSPERNIKAHAN_ID", "LEFT");
        $this->db->join("TR_STATUS_PERNIKAHAN TSP", "TSP.ID=TMP.TRSTATUSPERNIKAHAN_ID", "LEFT");
        $this->db->join("TR_AGAMA TA", "TA.ID=TMP.TRAGAMA_ID", "LEFT");
        $this->db->join("TH_PEGAWAI_PANGKAT VPM", "TMP.ID=VPM.TMPEGAWAI_ID AND VPM.TRJENISKENAIKANPANGKAT_ID=5", "LEFT");
        $this->db->join("TH_PEGAWAI_PANGKAT VPPM", "TMP.ID=VPPM.TMPEGAWAI_ID AND VPPM.TRJENISKENAIKANPANGKAT_ID=6", "LEFT");
        
        $this->db->where('TMP.NIPNEW', trim($nipnew));
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_by_id_select($id, $select) {
        $this->db->select($select);
        $this->db->from($this->tabel);
        $this->db->where('ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_by_nipnew_select($id, $select) {
        $this->db->select($select);
        $this->db->from($this->tabel);
        $this->db->where('NIPNEW', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get($str = array()) {
        $this->db->from($this->tabel);
        foreach ($str as $key => $val) {
            $this->db->where($key, $val);
        }
        $query = $this->db->get();
        return $query->row_array();
    }

    function check_unique_edit_by_id($id, $field, $str) {
        $this->db->from($this->tabel);
        $this->db->where('lower(' . $field . ')', strtolower(ltrim(rtrim($str))));
        $this->db->where('ID !=', $id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_filtered($tipe='') {
        $this->_get_datatables_query($tipe);

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($tipe="") {
        $this->_get_datatables_query($tipe);

        $query = $this->db->get();
        return $query->num_rows();
    }

    private function next_val_id() {
        return $this->db->query("SELECT TM_PEGAWAI_SEQ.NEXTVAL AS NEXT_ID FROM DUAL")->row_array();
    }

    public function insert($var = array(), $tanggal = array()) {
        $this->db->trans_begin();
        $nextid = $this->next_val_id()['NEXT_ID'];
        $this->db->set('ID', $nextid);
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        if (isset($tanggal['TGLLAHIR']) && $tanggal['TGLLAHIR'] <> NULL) {
            $this->db->set('TGLLAHIR', "TO_DATE('" . $tanggal['TGLLAHIR'] . "','YYYY-MM-DD')", FALSE);
        } else {
            $this->db->set('TGLLAHIR', NULL);
        }
        $this->db->insert("TM_PEGAWAI", $var);

        $this->db->set('TMPEGAWAI_ID', $nextid);
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->insert("TH_PEGAWAI_CPNS", ['HONORER_BULAN' => 0, 'HONORER_TAHUN' => 0, 'SWASTA_BULAN' => 0, 'SWASTA_TAHUN' => 0, 'FIKTIF_BULAN' => 0, 'FIKTIF_TAHUN' => 0, 'BLN_MASAKERJA' => 0, 'THN_MASAKERJA' => 0]);
        $this->db->set('TMPEGAWAI_ID', $nextid);
        $this->db->set('CREATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_BY', !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '', FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->insert("TH_PEGAWAI_PNS");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update($var = array(), $tanggal = array(), $id) {
        $this->db->trans_begin();
        if (isset($tanggal['TGLLAHIR']) && $tanggal['TGLLAHIR'] != NULL) {
            $this->db->set('TGLLAHIR', "TO_DATE('" . $tanggal['TGLLAHIR'] . "','YYYY-MM-DD')", FALSE);
        } else {
            $this->db->set('TGLLAHIR', NULL);
        }
        $this->db->where('ID', $id);
        $this->db->update("TM_PEGAWAI", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update_custom($var = array(), $where = array()) {
        $this->db->trans_begin();
        foreach ($where as $key => $val) {
            $this->db->where($key, $val);
        }
        $this->db->update("TM_PEGAWAI", $var);
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
        $this->db->delete("TM_PEGAWAI");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_datatables_query_cetak($tipe = "") {
        if ($this->input->get('nip')) {
            $this->db->where('TP.NIP', trim($this->input->get('nip', TRUE)));
            $this->db->or_where('TP.NIPNEW', trim($this->input->get('nip', TRUE)));
        }

        $this->db->from($this->tabel . " TP");
        if ($this->input->get('pegawaibaru') == "true") {
            $this->db->select("TP.ID,TP.GELAR_DEPAN,TP.NAMA,TP.GELAR_BLKG,TP.NIPNEW,'' AS TRSTATUSKEPEGAWAIAN_ID,'' AS PANGKAT,'' AS GOLONGAN,'' AS TMT_GOL,'' AS N_JABATAN,'' AS TMT_JABATAN");
        }
        if (!isset($_GET['pegawaibaru']) || $this->input->get('pegawaibaru') == "false") {
            if ($tipe == 1) {
                $this->db->where('VPJM.TRESELON_ID', (isset($this->session->userdata('config')['kode_fungsional_tertentu']) && $this->session->userdata('config')['kode_fungsional_tertentu'] != "") ? $this->session->userdata('config')['kode_fungsional_tertentu'] : '0');
            } elseif ($tipe == 2) {
                $this->db->where('VPJM.TRESELON_ID <>', (isset($this->session->userdata('config')['kode_fungsional_tertentu']) && $this->session->userdata('config')['kode_fungsional_tertentu'] != "") ? $this->session->userdata('config')['kode_fungsional_tertentu'] : '0');
                $this->db->where('VPJM.TRESELON_ID <>', (isset($this->session->userdata('config')['kode_fungsional_umum']) && $this->session->userdata('config')['kode_fungsional_umum'] != "") ? $this->session->userdata('config')['kode_fungsional_umum'] : '0');
            }

            if ($this->input->get('eselon_id')) {
                if ($this->input->get('eselon_id') == 18) {
                    $this->db->where_in('TP.TRSTATUSKEPEGAWAIAN_ID', [4,5,6], false);
                    $this->db->where('VPJM.TRESELON_ID !=', (isset($this->session->userdata('config')['kode_pensiun']) && $this->session->userdata('config')['kode_pensiun'] != "") ? $this->session->userdata('config')['kode_pensiun'] : '0');
                } else {
                    $this->db->where('VPJM.TRESELON_ID', $this->input->get('eselon_id', TRUE));
                }
            } else {
                $this->db->where('VPJM.TRESELON_ID !=', (isset($this->session->userdata('config')['kode_pensiun']) && $this->session->userdata('config')['kode_pensiun'] != "") ? $this->session->userdata('config')['kode_pensiun'] : '0');
            }

            if ($this->input->get('nama')) {
                $this->db->like('lower(TP.NAMA)', strtolower(ltrim(rtrim($this->input->get('nama', TRUE)))));
            }

            if ($this->input->get('statpeg_id')) {
                $this->db->where('TP.TRSTATUSKEPEGAWAIAN_ID', trim($this->input->get('statpeg_id', TRUE)));
            }

            if ($this->input->get('gol_id') && $this->input->get('gol_id') != '-1') {
                $this->db->where('VPPM.TRGOLONGAN_ID', trim($this->input->get('gol_id', TRUE)));
            }

            if ($this->input->get('jabatan_id') && $this->input->get('jabatan_id') != '-1') {
                $this->db->where('VPJM.TRJABATAN_ID', trim($this->input->get('jabatan_id', TRUE)));
            }

            if ($this->input->get('status_nikah_id')) {
                $this->db->where('TP.TRSTATUSPERNIKAHAN_ID', trim($this->input->get('status_nikah_id', TRUE)));
            }

            if ($this->input->get('jk_id')) {
                $this->db->where('upper(TP.SEX)', strtoupper(trim($this->input->get('jk_id', TRUE))));
            }

            if ($this->input->get('lokasi_id') && $this->input->get('lokasi_id') != '-1') {
                $this->db->where('VPJM.TRLOKASI_ID', trim($this->input->get('lokasi_id', TRUE)));
            }
            if ($this->input->get('kdu1_id') && $this->input->get('kdu1_id') != '-1') {
                $this->db->where('VPJM.KDU1', trim($this->input->get('kdu1_id', TRUE)));
            }
            if ($this->input->get('kdu2_id') && $this->input->get('kdu2_id') != '-1') {
                $this->db->where('VPJM.KDU2', trim($this->input->get('kdu2_id', TRUE)));
            }
            if ($this->input->get('kdu3_id') && $this->input->get('kdu3_id') != '-1') {
                $this->db->where('VPJM.KDU3', trim($this->input->get('kdu3_id', TRUE)));
            }
            if ($this->input->get('kdu4_id') && $this->input->get('kdu4_id') != '-1') {
                $this->db->where('VPJM.KDU4', trim($this->input->get('kdu4_id', TRUE)));
            }
            if ($this->input->get('kdu5_id') && $this->input->get('kdu5_id') != '-1') {
                $this->db->where('VPJM.KDU5', trim($this->input->get('kdu5_id', TRUE)));
            }

            $this->db->select("TP.ID,TP.GELAR_DEPAN,TP.NAMA,TP.GELAR_BLKG,TP.NIPNEW,TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.GOLONGAN,TRG.PANGKAT,TO_CHAR(VPPM.TMT_GOL,'DD/MM/YYYY') AS TMT_GOL,VPJM.N_JABATAN,TO_CHAR(VPJM.TMT_JABATAN, 'DD/MM/YYYY') AS TMT_JABATAN");
            $this->db->join("V_PEGAWAI_PANGKAT_MUTAKHIR VPPM", "VPPM.TMPEGAWAI_ID=TP.ID", "LEFT");
            $this->db->join("TR_GOLONGAN TRG", "TRG.ID=VPPM.TRGOLONGAN_ID", "LEFT");
            $this->db->join("V_PEGAWAI_JABATAN_MUTAKHIR VPJM", "VPJM.TMPEGAWAI_ID=TP.ID", "LEFT");

            if ($this->input->get('kel_fung_id')) {
                $this->db->join("TR_JABATAN TRJ", "TRJ.ID=VPJM.TRJABATAN_ID", "LEFT");
                $this->db->where('TRJ.TRKELOMPOKFUNGSIONAL_ID', trim($this->input->get('kel_fung_id', TRUE)));
            }

            if ($this->input->get('diklatpim_id')) {
                $this->db->join("TH_PEGAWAI_DIKLAT_PENJENJANGAN TPDP", "TPDP.TMPEGAWAI_ID=TP.ID", "LEFT");
                $this->db->where('TPDP.TRTINGKATDIKLATKEPEMIMPINAN_ID', trim($this->input->get('diklatpim_id', TRUE)));
            }

            if ($this->input->get('pendidikan_id')) {
                $this->db->join("V_PEGAWAI_PENDIDIKAN_MUTAKHIR VPEM", "VPEM.TMPEGAWAI_ID=TP.ID", "LEFT");
                $this->db->where('VPEM.TRTINGKATPENDIDIKAN_ID', trim($this->input->get('pendidikan_id', TRUE)));
            }
        }

        $this->db->order_by("CASE WHEN VPJM.TRESELON_ID < '11' THEN VPJM.TRESELON_ID||VPJM.TRLOKASI_ID||VPJM.KDU1||VPJM.KDU2||VPJM.KDU3||VPJM.KDU4||VPJM.KDU5 END");
        $this->db->order_by("CASE WHEN VPJM.TRESELON_ID > '10' THEN TRG.GOLONGAN END DESC,VPPM.TMT_GOL");
        $query = $this->db->get();
        
        return $query->result();
    }
    
    public function updateidpnsbkn($var, $id) {
        $this->db->trans_begin();
        $this->db->set('ID_BKN', $var);
        $this->db->where('ID', $id);
        $this->db->update("TM_PEGAWAI");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}
