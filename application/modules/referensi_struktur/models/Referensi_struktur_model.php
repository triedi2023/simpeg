<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi_struktur_model extends CI_Model {

    private $tabel = "TR_STRUKTUR_ORGANISASI";
    private $column_order = array('TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5', 'NMUNIT', 'TRKABUPATEN_ID', 'TRESELON_ID', 'TRJABATAN_ID', 'STATUS'); //set column field database for datatable orderable
    private $column_search = array('NAMA_PROPINSI', 'STATUS'); //set column field database for datatable searchable 
    private $order = array('TRLOKASI_ID', 'KDU1', 'KDU2', 'KDU3', 'KDU4', 'KDU5'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($trlokasi_id="",$kdu1="",$kdu2="",$kdu3="",$kdu4="",$kdu5="",$tkteselon=1) {
        $this->db->where('TR_STRUKTUR_ORGANISASI.STATUS', 1);
        $this->db->where('TR_STRUKTUR_ORGANISASI.TRLOKASI_ID', $trlokasi_id);
        
        if ($kdu1) {
            $this->db->where('TR_STRUKTUR_ORGANISASI.KDU1', $kdu1);
        }
        if ($kdu2) {
            $this->db->where('TR_STRUKTUR_ORGANISASI.KDU2', $kdu2);
        }
        if ($kdu3) {
            $this->db->where('TR_STRUKTUR_ORGANISASI.KDU3', $kdu3);
        }
        if ($kdu4) {
            $this->db->where('TR_STRUKTUR_ORGANISASI.KDU4', $kdu4);
        }
        if ($kdu5) {
            $this->db->where('TR_STRUKTUR_ORGANISASI.KDU5', $kdu5);
        }
        
        $this->db->where('TR_STRUKTUR_ORGANISASI.TKTESELON', $tkteselon);
        $this->db->select("TR_STRUKTUR_ORGANISASI.*,TRE.ESELON,TRJ.JABATAN");
        $this->db->from($this->tabel);
        $this->db->join("TR_ESELON TRE", "TRE.ID=TR_STRUKTUR_ORGANISASI.TRESELON_ID",'LEFT');
        $this->db->join("TR_JABATAN TRJ", "TRJ.ID=TR_STRUKTUR_ORGANISASI.TRJABATAN_ID",'LEFT');
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

    function get_datatables($trlokasi_id="",$kdu1="",$kdu2="",$kdu3="",$kdu4="",$kdu5="",$tkteselon=1) {
        $this->_get_datatables_query($trlokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5,$tkteselon);
        if ($this->input->post('length'))
            if ($this->input->post('length') != -1)
                $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
        $query = $this->db->get();
        return $query->result();
    }

    function get_by_id($id) {
        $this->db->from($this->tabel);
        $this->db->where('ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_unique_nama_by_id($id, $str) {
        $this->db->from($this->tabel);
        $this->db->where('lower(NAMA_PROPINSI)', strtolower(ltrim(rtrim($str))));
        $this->db->where('ID !=', $id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_filtered($trlokasi_id=1,$kdu1="",$kdu2="",$kdu3="",$kdu4="",$kdu5="",$tkteselon=1) {
        $this->_get_datatables_query($trlokasi_id,$kdu1,$kdu2,$kdu3,$kdu4,$kdu5,$tkteselon);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($trlokasi_id=1,$kdu1="",$kdu2="",$kdu3="",$kdu4="",$kdu5="",$tkteselon=1) {
        $this->db->where('TR_STRUKTUR_ORGANISASI.TRLOKASI_ID', $trlokasi_id);
        if ($kdu1) {
            $this->db->where('TR_STRUKTUR_ORGANISASI.KDU1', $kdu1);
        }
        if ($kdu2) {
            $this->db->where('TR_STRUKTUR_ORGANISASI.KDU2', $kdu2);
        }
        
        $this->db->where('TR_STRUKTUR_ORGANISASI.TKTESELON', $tkteselon);
        
        $this->db->from($this->tabel);
        return $this->db->count_all_results();
    }

    public function next_val_id() {
        $sql = "WITH t(kode) AS (
                SELECT 1 as kode from dual
                    UNION ALL
                SELECT kode+1 FROM t WHERE kode < (select max(to_number(ID)) from TR_STRUKTUR_ORGANISASI)
            )
            SELECT MIN(to_number(KODE)) as KODE FROM t WHERE to_number(kode) NOT IN (SELECT to_number(ID) FROM TR_STRUKTUR_ORGANISASI)";
        $query = $this->db->query($sql);
        $new_id = "";
        if ($query->row_object()->KODE <> "") {
            if ($query->row_object()->KODE == 1)
                $new_id = 1;
            else
                $new_id = $query->row_object()->KODE;
        } else {
            $maxquery = $this->db->query("SELECT MAX(to_number(ID)) as KODE FROM TR_STRUKTUR_ORGANISASI");
            $last_id = $maxquery->row_object()->KODE;
            $format = $last_id + 1;

            $new_id = $format;
        }
        
        return $new_id;
    }
    
    public function next_val_kdu1($lokasi) {
        $sql = "WITH t(kode) AS (
                SELECT 1 as kode from dual
                    UNION ALL
                SELECT kode+1 FROM t WHERE kode < (select max(to_number(KDU1)) from TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi.")
            )
            SELECT MIN(to_number(KODE)) as KODE FROM t WHERE to_number(kode) NOT IN (SELECT to_number(KDU1) FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi.")";
        $query = $this->db->query($sql);
        $new_id = "";
        if ($query->row_object()->KODE <> "") {
            if ($query->row_object()->KODE == 1)
                $new_id = "01";
            else
                $new_id = $query->row_object()->KODE;
        } else {
            $maxquery = $this->db->query("SELECT MAX(to_number(KDU1)) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." ");
            $last_id = $maxquery->row_object()->KODE;
            $format = $last_id + 1;

            if (strlen($format) < 2) {
                $new_id = "0".($format);
            } elseif (strlen($last_id) < 3) {
                $new_id = $format;
            }
            
        }
        
        return $new_id;
    }
    
    public function next_urutan_kdu1($lokasi) {
        $sql = "WITH t(kode) AS (
                SELECT 1 as kode from dual
                    UNION ALL
                SELECT kode+1 FROM t WHERE kode < (select max(to_number(KDU1)) from TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi.")
            )
            SELECT MIN(to_number(KODE)) as KODE FROM t WHERE to_number(kode) NOT IN (SELECT to_number(KDU1) FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi.")";
        $query = $this->db->query($sql);
        $new_id = "";
        if ($query->row_object()->KODE <> "") {
            if ($query->row_object()->KODE == 1)
                $new_id = 1;
            else
                $new_id = $query->row_object()->KODE;
        } else {
            $maxquery = $this->db->query("SELECT MAX(to_number(KDU1)) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." ");
            $last_id = $maxquery->row_object()->KODE;
            $format = $last_id + 1;
            $new_id = $format;
            
        }
        
        return $new_id;
    }

    public function insert($var = array()) {
        $this->db->trans_begin();
        $data = $var;
        $this->db->set('ID', $this->next_val_id());
        $this->db->set('KDU1', $this->next_val_kdu1($data['TRLOKASI_ID']));
        $this->db->set('URUTAN', $this->next_urutan_kdu1($data['TRLOKASI_ID']));
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->insert("TR_STRUKTUR_ORGANISASI", $data);
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
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->where('ID', $id);
        $this->db->update("TR_STRUKTUR_ORGANISASI", $var);
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
        $this->db->delete("TR_STRUKTUR_ORGANISASI");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function getminlokasi() {
        // ambil ID paling minimal
        $sql = "SELECT MIN(ID) as ID FROM TABEL_LOKASI_KERJA_RECURSIVE WHERE LVL = (SELECT MIN(LVL) FROM TABEL_LOKASI_KERJA_RECURSIVE)";
        $query = $this->db->query($sql);
        $idmin = $query->row_array()['ID'];
        
        $sql = "SELECT MAX(ID) as ID FROM TABEL_LOKASI_KERJA_RECURSIVE WHERE PARENT_ID = ? AND LVL = (SELECT MAX(LVL) FROM TABEL_LOKASI_KERJA_RECURSIVE)";
        $query = $this->db->query($sql,[$idmin]);
        return $query->row_array()['ID'];
    }
    
    public function getminkdu1($trlokasi_id) {
        $sql = "SELECT MIN(KDU1) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ? AND TKTESELON = 1";
        $query = $this->db->query($sql,[$trlokasi_id]);
        return $query->row_array()['KODE'];
    }
    
    public function getminkdu2($trlokasi_id,$kdu1) {
        $sql = "SELECT MIN(KDU2) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ? AND KDU1 = ? AND TKTESELON = 2";
        $query = $this->db->query($sql,[$trlokasi_id,$kdu1]);
        return $query->row_array()['KODE'];
    }
    
    public function getminkdu3($trlokasi_id,$kdu1,$kdu2) {
        $sql = "SELECT MIN(KDU3) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ? AND KDU1 = ? AND KDU2 = ? AND TKTESELON = 3";
        $query = $this->db->query($sql,[$trlokasi_id,$kdu1,$kdu2]);
        return $query->row_array()['KODE'];
    }
    
    public function getminkdu4($trlokasi_id,$kdu1,$kdu2,$kdu3) {
        $sql = "SELECT MIN(KDU4) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ? AND KDU1 = ? AND KDU2 = ? AND KDU3 = ? AND TKTESELON = 4";
        $query = $this->db->query($sql,[$trlokasi_id,$kdu1,$kdu2,$kdu3]);
        return $query->row_array()['KODE'];
    }
    
    public function getprovinsi($id) {
        $this->db->where("ID", $id);
        $this->db->where("STATUS", 1);
        $this->db->from("TR_KABUPATEN");
        $query = $this->db->get();
        return $query->row_array()['TRPROPINSI_ID'];
    }
    
    /*
     * eselon 2
     */
    public function next_val_kdu2($lokasi,$kdu1) {
        $sql = "WITH t(kode) AS (
                SELECT 1 as kode from dual
                    UNION ALL
                SELECT kode+1 FROM t WHERE kode < (select max(to_number(KDU2)) from TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."')
            )
            SELECT MIN(to_number(KODE)) as KODE FROM t WHERE to_number(kode) NOT IN (SELECT to_number(KDU2) FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."')";
        $query = $this->db->query($sql);
        $new_id = "";
        if ($query->row_object()->KODE <> "") {
            if ($query->row_object()->KODE == 1)
                $new_id = "01";
            else
                $new_id = $query->row_object()->KODE;
        } else {
            $maxquery = $this->db->query("SELECT MAX(to_number(KDU2)) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' ");
            $last_id = $maxquery->row_object()->KODE;
            $format = $last_id + 1;

            if (strlen($format) < 2) {
                $new_id = "0".($format);
            } elseif (strlen($last_id) < 3) {
                $new_id = $format;
            }
            
        }
        
        return $new_id;
    }
    
    public function next_urutan_kdu2($lokasi,$kdu1) {
        $sql = "WITH t(kode) AS (
                SELECT 1 as kode from dual
                    UNION ALL
                SELECT kode+1 FROM t WHERE kode < (select max(to_number(KDU2)) from TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."')
            )
            SELECT MIN(to_number(KODE)) as KODE FROM t WHERE to_number(kode) NOT IN (SELECT to_number(KDU2) FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."')";
        $query = $this->db->query($sql);
        $new_id = "";
        if ($query->row_object()->KODE <> "") {
            if ($query->row_object()->KODE == 1)
                $new_id = 1;
            else
                $new_id = $query->row_object()->KODE;
        } else {
            $maxquery = $this->db->query("SELECT MAX(to_number(KDU2)) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' ");
            $last_id = $maxquery->row_object()->KODE;
            $format = $last_id + 1;
            $new_id = $format;
            
        }
        
        return $new_id;
    }
    
    public function insert_eselon_2($var = array()) {
        $this->db->trans_begin();
        $data = $var;
        $this->db->set('ID', $this->next_val_id());
        $this->db->set('KDU2', $this->next_val_kdu2($data['TRLOKASI_ID'],$data['KDU1']));
        $this->db->set('URUTAN', $this->next_urutan_kdu2($data['TRLOKASI_ID'],$data['KDU1']));
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->insert("TR_STRUKTUR_ORGANISASI", $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    /*
     * eselon 3
     */
    public function next_val_kdu3($lokasi,$kdu1,$kdu2) {
        $sql = "WITH t(kode) AS (
                SELECT 1 as kode from dual
                    UNION ALL
                SELECT kode+1 FROM t WHERE kode < (select max(to_number(KDU3)) from TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."')
            )
            SELECT MIN(to_number(KODE)) as KODE FROM t WHERE to_number(kode) NOT IN (SELECT to_number(KDU3) FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."')";
        $query = $this->db->query($sql);
        $new_id = "";
        if ($query->row_object()->KODE <> "") {
            if ($query->row_object()->KODE == 1)
                $new_id = "001";
            else
                $new_id = $query->row_object()->KODE;
        } else {
            $maxquery = $this->db->query("SELECT MAX(to_number(KDU3)) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' ");
            $last_id = $maxquery->row_object()->KODE;
            $format = $last_id + 1;

            if (strlen($format) < 2) {
                $new_id = "00".($format);
            } elseif (strlen($last_id) < 3) {
                $new_id = "0".($format);
            } else {
                $new_id = $format;
            }
            
        }
        
        return $new_id;
    }
    
    public function next_urutan_kdu3($lokasi,$kdu1,$kdu2) {
        $sql = "WITH t(kode) AS (
                SELECT 1 as kode from dual
                    UNION ALL
                SELECT kode+1 FROM t WHERE kode < (select max(to_number(KDU3)) from TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."')
            )
            SELECT MIN(to_number(KODE)) as KODE FROM t WHERE to_number(kode) NOT IN (SELECT to_number(KDU3) FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."')";
        $query = $this->db->query($sql);
        $new_id = "";
        if ($query->row_object()->KODE <> "") {
            if ($query->row_object()->KODE == 1)
                $new_id = 1;
            else
                $new_id = $query->row_object()->KODE;
        } else {
            $maxquery = $this->db->query("SELECT MAX(to_number(KDU3)) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' ");
            $last_id = $maxquery->row_object()->KODE;
            $format = $last_id + 1;
            $new_id = $format;
            
        }
        
        return $new_id;
    }
    
    public function insert_eselon_3($var = array()) {
        $this->db->trans_begin();
        $data = $var;
        $this->db->set('ID', $this->next_val_id());
        $this->db->set('KDU3', $this->next_val_kdu3($data['TRLOKASI_ID'],$data['KDU1'],$data['KDU2']));
        $this->db->set('URUTAN', $this->next_urutan_kdu3($data['TRLOKASI_ID'],$data['KDU1'],$data['KDU2']));
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->insert("TR_STRUKTUR_ORGANISASI", $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    /*
     * eselon 4
     */
    public function next_val_kdu4($lokasi,$kdu1,$kdu2,$kdu3) {
        $sql = "WITH t(kode) AS (
                SELECT 1 as kode from dual
                    UNION ALL
                SELECT kode+1 FROM t WHERE kode < (select max(to_number(KDU4)) from TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' AND KDU3='".$kdu3."')
            )
            SELECT MIN(to_number(KODE)) as KODE FROM t WHERE to_number(kode) NOT IN (SELECT to_number(KDU4) FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' AND KDU3='".$kdu3."')";
        $query = $this->db->query($sql);
        $new_id = "";
        if ($query->row_object()->KODE <> "") {
            if ($query->row_object()->KODE == 1)
                $new_id = "001";
            else
                $new_id = $query->row_object()->KODE;
        } else {
            $maxquery = $this->db->query("SELECT MAX(to_number(KDU4)) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' AND KDU3='".$kdu3."' ");
            $last_id = $maxquery->row_object()->KODE;
            $format = $last_id + 1;

            if (strlen($format) < 2) {
                $new_id = "00".($format);
            } elseif (strlen($last_id) < 3) {
                $new_id = "0".($format);
            } else {
                $new_id = $format;
            }
            
        }
        
        return $new_id;
    }
    
    public function next_urutan_kdu4($lokasi,$kdu1,$kdu2,$kdu3) {
        $sql = "WITH t(kode) AS (
                SELECT 1 as kode from dual
                    UNION ALL
                SELECT kode+1 FROM t WHERE kode < (select max(to_number(KDU4)) from TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' AND KDU3='".$kdu3."')
            )
            SELECT MIN(to_number(KODE)) as KODE FROM t WHERE to_number(kode) NOT IN (SELECT to_number(KDU4) FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' AND KDU3='".$kdu3."' )";
        $query = $this->db->query($sql);
        $new_id = "";
        if ($query->row_object()->KODE <> "") {
            if ($query->row_object()->KODE == 1)
                $new_id = 1;
            else
                $new_id = $query->row_object()->KODE;
        } else {
            $maxquery = $this->db->query("SELECT MAX(to_number(KDU4)) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' AND KDU3='".$kdu3."' ");
            $last_id = $maxquery->row_object()->KODE;
            $format = $last_id + 1;
            $new_id = $format;
            
        }
        
        return $new_id;
    }
    
    public function insert_eselon_4($var = array()) {
        $this->db->trans_begin();
        $data = $var;
        $this->db->set('ID', $this->next_val_id());
        $this->db->set('KDU4', $this->next_val_kdu4($data['TRLOKASI_ID'],$data['KDU1'],$data['KDU2'],$data['KDU3']));
        $this->db->set('URUTAN', $this->next_urutan_kdu4($data['TRLOKASI_ID'],$data['KDU1'],$data['KDU2'],$data['KDU3']));
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->insert("TR_STRUKTUR_ORGANISASI", $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    /*
     * eselon 5
     */
    public function next_val_kdu5($lokasi,$kdu1,$kdu2,$kdu3,$kdu4) {
        $sql = "WITH t(kode) AS (
                SELECT 1 as kode from dual
                    UNION ALL
                SELECT kode+1 FROM t WHERE kode < (select max(to_number(KDU5)) from TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' AND KDU3='".$kdu3."' AND KDU4='".$kdu4."')
            )
            SELECT MIN(to_number(KODE)) as KODE FROM t WHERE to_number(kode) NOT IN (SELECT to_number(KDU5) FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' AND KDU3='".$kdu3."' AND KDU4='".$kdu4."')";
        $query = $this->db->query($sql);
        $new_id = "";
        if ($query->row_object()->KODE <> "") {
            if ($query->row_object()->KODE == 1)
                $new_id = "01";
            else
                $new_id = $query->row_object()->KODE;
        } else {
            $maxquery = $this->db->query("SELECT MAX(to_number(KDU5)) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' AND KDU3='".$kdu3."' AND KDU4='".$kdu4."' ");
            $last_id = $maxquery->row_object()->KODE;
            $format = $last_id + 1;

            if (strlen($format) < 2) {
                $new_id = "0".($format);
            } else {
                $new_id = $format;
            }
            
        }
        
        return $new_id;
    }
    
    public function next_urutan_kdu5($lokasi,$kdu1,$kdu2,$kdu3,$kdu4) {
        $sql = "WITH t(kode) AS (
                SELECT 1 as kode from dual
                    UNION ALL
                SELECT kode+1 FROM t WHERE kode < (select max(to_number(KDU5)) from TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' AND KDU3='".$kdu3."' AND KDU4='".$kdu4."')
            )
            SELECT MIN(to_number(KODE)) as KODE FROM t WHERE to_number(kode) NOT IN (SELECT to_number(KDU5) FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' AND KDU3='".$kdu3."' AND KDU4='".$kdu4."' )";
        $query = $this->db->query($sql);
        $new_id = "";
        if ($query->row_object()->KODE <> "") {
            if ($query->row_object()->KODE == 1)
                $new_id = 1;
            else
                $new_id = $query->row_object()->KODE;
        } else {
            $maxquery = $this->db->query("SELECT MAX(to_number(KDU5)) as KODE FROM TR_STRUKTUR_ORGANISASI WHERE TRLOKASI_ID = ".$lokasi." AND KDU1='".$kdu1."' AND KDU2='".$kdu2."' AND KDU3='".$kdu3."' AND KDU4='".$kdu4."' ");
            $last_id = $maxquery->row_object()->KODE;
            $format = $last_id + 1;
            $new_id = $format;
            
        }
        
        return $new_id;
    }
    
    public function insert_eselon_5($var = array()) {
        $this->db->trans_begin();
        $data = $var;
        $this->db->set('ID', $this->next_val_id());
        $this->db->set('KDU5', $this->next_val_kdu5($data['TRLOKASI_ID'],$data['KDU1'],$data['KDU2'],$data['KDU3'],$data['KDU4']));
        $this->db->set('URUTAN', $this->next_urutan_kdu5($data['TRLOKASI_ID'],$data['KDU1'],$data['KDU2'],$data['KDU3'],$data['KDU4']));
        $this->db->set('CREATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->insert("TR_STRUKTUR_ORGANISASI", $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function list_kdu1($trlokasi_id = 1) {
        $this->db->select("KDU1||';;'||ID AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON", 1);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_kdu2($trlokasi_id = 1,$kdu1="") {
        $this->db->select("KDU2||';;'||ID AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        if ($kdu1) {
            $this->db->where("KDU1", $kdu1);
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON", 2);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_kdu3($id) {
        $this->db->select("KDU3||';;'||ID AS ID,NMUNIT AS NAMA");
        $this->db->where("ID",$id);
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON", 3);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_kdu3s($trlokasi_id = 1,$kdu1="",$kdu2="") {
        $this->db->select("KDU3||';;'||ID AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        if ($kdu1) {
            $this->db->where("KDU1", $kdu1);
        }
        if ($kdu2) {
            $this->db->where("KDU2", $kdu2);
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON", 3);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_kdu4($trlokasi_id = 1,$kdu1="",$kdu2="",$kdu3) {
        $this->db->select("KDU4||';;'||ID AS ID,NMUNIT AS NAMA");
        if ($trlokasi_id) {
            $this->db->where("TRLOKASI_ID", $trlokasi_id);
        }
        if ($kdu1) {
            $this->db->where("KDU1", $kdu1);
        }
        if ($kdu2) {
            $this->db->where("KDU2", $kdu2);
        }
        if ($kdu3) {
            $this->db->where("KDU3", $kdu3);
        }
        $this->db->where("STATUS", 1);
        $this->db->where("TKTESELON", 4);
        $this->db->from("TR_STRUKTUR_ORGANISASI");
        $this->db->order_by("ID", "ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

}
