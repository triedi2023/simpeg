<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Survey_hasil_model extends CI_Model {

    private $tabel = "TR_SURVEY";
    private $column_order = array(null, 'JUDUL', 'KETERANGAN', 'START_DATE', 'END_DATE'); //set column field database for datatable orderable
    private $column_search = array('JUDUL', 'KETERANGAN', 'START_DATE', 'END_DATE'); //set column field database for datatable searchable 
    private $order = array('JUDUL' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {

        $this->db->select("ID,JUDUL,KETERANGAN,TO_CHAR(START_DATE,'DD/MM/YYYY') START_DATE,TO_CHAR(END_DATE,'DD/MM/YYYY') END_DATE");
        if ($this->input->post('judul')) {
            $this->db->like('lower(JUDUL)', strtolower($this->input->post('judul')));
        }
        if ($this->input->post('keterangan')) {
            $this->db->like('lower(KETERANGAN)', strtolower($this->input->post('keterangan')));
        }

        $this->db->from($this->tabel);
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
                ) XYZ ON (TSJ.ID=XYZ.HASIL) WHERE TSJ.TRSURVEYPERTANYAAN_ID = ? GROUP BY TSJ.ID, TSJ.JAWABAN ",[$listpertanyaan['ID'],$listpertanyaan['ID']]);
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
