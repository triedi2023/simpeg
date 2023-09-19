<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Survey_pengisi_model extends CI_Model {

    private $tabel = "(SELECT SUG.TMPEGAWAI_ID,TSH.* FROM (SELECT DISTINCT TR_SURVEY_HASIL.CREATED_BY,TR_SURVEY_HASIL.CREATED_DATE,TR_SURVEY.ID AS TR_SURVEY_ID FROM TR_SURVEY_HASIL JOIN TR_SURVEY_PERTANYAAN ON (TR_SURVEY_HASIL.TRSURVEYPERTANYAAN_ID=TR_SURVEY_PERTANYAAN.ID) JOIN TR_SURVEY ON (TR_SURVEY_PERTANYAAN.TRSURVEY_ID=TR_SURVEY.ID)) TSH 
    JOIN SYSTEM_USER_GROUP SUG ON (TSH.CREATED_BY=SUG.SYSTEMUSER_ID)) HASILSURVEY";
    private $column_order = array(null, 'NAMA', 'NIPNEW', 'PANGKAT', 'TMT_GOL', 'N_JABATAN', 'TMT_JABATAN'); //set column field database for datatable orderable
    private $column_search = array('NIP', 'NAMA', 'TPTLAHIR', 'TGLLAHIR'); //set column field database for datatable searchable 
    private $order = array('VPJM.TRESELON_ID' => 'ASC', 'VPJM.TRLOKASI_ID' => 'ASC', 'VPJM.KDU1' => 'ASC', 'VPJM.KDU2' => 'ASC', 'VPJM.KDU3' => 'ASC', 'VPJM.KDU4' => 'ASC', 'VPJM.KDU5' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        $this->db->select("TP.ID,TP.GELAR_DEPAN,TP.NAMA,TP.GELAR_BLKG,TP.NIPNEW,TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.GOLONGAN,TRG.PANGKAT,TO_CHAR(VPPM.TMT_GOL,'DD/MM/YYYY') AS TMT_GOL,VPJM.N_JABATAN,TO_CHAR(VPJM.TMT_JABATAN, 'DD/MM/YYYY') AS TMT_JABATAN, VPJM.TRESELON_ID,VPJM.TRLOKASI_ID,VPJM.KDU1,VPJM.KDU2,VPJM.KDU3,VPJM.KDU4,VPJM.KDU5,TO_CHAR(HASILSURVEY.CREATED_DATE,'DD/MM/YYYY HH24:MI:SS') AS CREATED_DATE");
        $this->db->from($this->tabel);
        $this->db->join("TM_PEGAWAI TP", "HASILSURVEY.TMPEGAWAI_ID=TP.ID");
        $this->db->join("V_PEGAWAI_PANGKAT_MUTAKHIR VPPM", "VPPM.TMPEGAWAI_ID=TP.ID", "LEFT");
        $this->db->join("TR_GOLONGAN TRG", "TRG.ID=VPPM.TRGOLONGAN_ID", "LEFT");
        $this->db->join("V_PEGAWAI_JABATAN_MUTAKHIR VPJM", "VPJM.TMPEGAWAI_ID=TP.ID", "LEFT");
        $this->db->where("TR_SURVEY_ID",(int) $this->input->get('id'));
        
        if ($this->input->post('nip')) {
            $this->db->where('TP.NIP', trim($this->input->post('nip', TRUE)));
            $this->db->or_where('TP.NIPNEW', trim($this->input->post('nip', TRUE)));
        }
        
        if ($this->input->post('nama')) {
            $this->db->like('lower(TP.NAMA)', strtolower(ltrim(rtrim($this->input->post('nama', TRUE)))));
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
        $this->db->from($this->tabel);
        return $this->db->count_all_results();
    }
    
    function get_hasil_pilihan($id) {
        $listpertanyaans = $this->db->query("SELECT * FROM TR_SURVEY_PERTANYAAN WHERE TIPE_JAWABAN = 1 AND TRSURVEY_ID = ?",[$id])->result_array();
        
        $hasilnya = [];
        if ($listpertanyaans) {
            foreach ($listpertanyaans as $listpertanyaan) {
                $listcapaians = $this->db->query("SELECT COUNT(XYZ.HASIL) AS CAPAIAN, TSJ.JAWABAN FROM TR_SURVEY_JAWABAN TSJ 
                LEFT JOIN (
                    SELECT to_number(TRSURVEY_JAWABAN,'9999999999999999999999999999') AS HASIL, TSH.TRSURVEYPERTANYAAN_ID 
                    FROM TR_SURVEY_HASIL TSH
                    WHERE TRSURVEYPERTANYAAN_ID = ?
                ) XYZ ON (TSJ.ID=XYZ.HASIL) GROUP BY TSJ.ID, TSJ.JAWABAN ",[$listpertanyaan['ID']]);
                $hasilnya[] = ['id'=>$listpertanyaan['ID'],'pertanyaan'=>$listpertanyaan['PERTANYAAN'],'hasil'=>$listcapaians->result_array()];
                
            }
        }

        return $hasilnya;
    }
    
    function get_hasil_isian($id) {
        $listpertanyaans = $this->db->query("SELECT * FROM TR_SURVEY_PERTANYAAN WHERE TIPE_JAWABAN = 2 AND TRSURVEY_ID = ?",[$id])->result_array();
        
        $hasilnya = [];
        if ($listpertanyaans) {
            foreach ($listpertanyaans as $listpertanyaan) {
                $listcapaians = $this->db->query("SELECT * FROM TR_SURVEY_HASIL TSH
                    WHERE TRSURVEYPERTANYAAN_ID = ?",[$listpertanyaan['ID']]);
                $hasilnya[] = ['id'=>$listpertanyaan['ID'],'pertanyaan'=>$listpertanyaan['PERTANYAAN'],'hasil'=>$listcapaians->result_array()];
            }
        }

        return $hasilnya;
    }

}
