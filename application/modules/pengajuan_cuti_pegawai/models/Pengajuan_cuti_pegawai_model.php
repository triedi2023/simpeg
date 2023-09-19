<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan_cuti_pegawai_model extends CI_Model {

    private $tabel = "TH_PEGAWAI_CUTI";
    private $column_order = array(null, 'TGL_PENGAJUAN2', 'STATUS'); //set column field database for datatable orderable
    private $column_search = array('TRCUTI_ID', 'TGL_PENGAJUAN'); //set column field database for datatable searchable 
    private $order = array('TGL_PENGAJUAN' => 'DESC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        if ($this->input->post('jenis_cuti')) {
            $this->db->where('TRCUTI_ID', $this->input->post('jenis_cuti'));
        }
//        if (isset($_POST['status']) && ($_POST['status'] === '0' || !empty($_POST['status']))) {
//            $this->db->where('STATUS', $this->input->post('status'));
//        }

        $this->db->select("TPC.ID,TO_CHAR(TPC.TGL_PENGAJUAN,'DD-MM-YYYY') AS TGL_PENGAJUAN2,TPC.STATUS,
        TMP.GELAR_DEPAN,TMP.NAMA,TMP.GELAR_BLKG,TMP.NIPNEW,TRC.NAMA_CUTI,TPC.TRCUTI_ID,VPJM.N_JABATAN");
        $this->db->from($this->tabel." TPC ");
        $this->db->join("TM_PEGAWAI TMP", "TMP.ID=TPC.TMPEGAWAI_ID", "INNER");
        $this->db->join("V_PEGAWAI_JABATAN_MUTAKHIR VPJM", "VPJM.TMPEGAWAI_ID=TMP.ID", "LEFT");
        $this->db->join("TR_CUTI TRC", "TRC.ID=TPC.TRCUTI_ID", "LEFT");
        $verifikasi = $this->get_login_verifikasi();
        $this->db->where("((TPC.STATUS = 1 AND TRESELONID_ATASAN='".$verifikasi['TRESELON_ID']."' AND TRJABATANID_ATASAN='".$verifikasi['TRJABATAN_ID']."' 
        AND TRLOKASIID_ATASAN='".$verifikasi['TRLOKASI_ID']."' AND KDU1_ATASAN='".$verifikasi['KDU1']."' 
        AND KDU2_ATASAN='".$verifikasi['KDU2']."' AND KDU3_ATASAN='".$verifikasi['KDU3']."' AND KDU4_ATASAN='".$verifikasi['KDU4']."' AND KDU5_ATASAN='".$verifikasi['KDU5']."') OR 
        (TPC.STATUS = 2 AND TRESELONID_PEJABAT='".$verifikasi['TRESELON_ID']."' AND TRJABATANID_PEJABAT='".$verifikasi['TRJABATAN_ID']."' 
        AND TRLOKASIID_PEJABAT='".$verifikasi['TRLOKASI_ID']."' AND KDU1_PEJABAT='".$verifikasi['KDU1']."' 
        AND KDU2_PEJABAT='".$verifikasi['KDU2']."' AND KDU3_PEJABAT='".$verifikasi['KDU3']."' AND KDU4_PEJABAT='".$verifikasi['KDU4']."' AND KDU5_PEJABAT='".$verifikasi['KDU5']."'))");
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
        $this->db->where('ID', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_login_verifikasi() {
        $query = $this->db->query("SELECT * FROM SYSTEM_USER_GROUP SUG LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (SUG.TMPEGAWAI_ID=VPJM.TMPEGAWAI_ID) 
        WHERE SUG.SYSTEMUSER_ID = ".$this->session->get_userdata()['user_id']);
        return $query->row_array();
    }
    
    function get_unique_1column_by_id($id,$str) {
        $this->db->from($this->tabel);
        $this->db->where('lower(JENIS_LIBUR)', strtolower(ltrim(rtrim($str))));
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

    public function update($var = array(), $id) {
        $this->db->trans_begin();
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
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

}
