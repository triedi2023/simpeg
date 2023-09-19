<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function list_menu_group($group_id) {
        $this->db->select("URL_MENU");
        $this->db->from("VIEW_SYSTEM_MENU_RECURSIVE");
        $this->db->join("SYSTEM_MENU_USER smu", 'smu.SYSTEMMENU_ID=ID', 'JOIN');
        $this->db->where("SYSTEMGROUP_ID", $group_id);
        $query = $this->db->get();
        
        $data = [];
        if ($query->result_array()) {
            foreach ($query->result_array() as $val) {
                $data[] = $val['URL_MENU'];
            }
        }
        
        return $data;
    }
    
    public function list_menu($group_id) {
        $this->db->from("VIEW_SYSTEM_MENU_RECURSIVE");
        $this->db->join("SYSTEM_MENU_USER smu", 'smu.SYSTEMMENU_ID=ID', 'JOIN');
        $this->db->where("SYSTEMGROUP_ID", $group_id);
        $query = $this->db->get();

        $tree_menu = [];
        foreach ($query->result_array() as $row) {
            $tree_menu[$row['ID']] = $row;
        }

        foreach ($tree_menu as &$tree_menuItem)
            foreach ($tree_menu as $ID => &$tree_menuItem) {
                if (isset($tree_menuItem['ID_PARENT']) && $tree_menuItem['ID_PARENT'] != NULL)
                    $tree_menu[$tree_menuItem['ID_PARENT']]['Children'][$ID] = &$tree_menuItem;
            }
            
        foreach (array_keys($tree_menu) as $ID) {
            if ($tree_menu[$ID]['ID_PARENT'] != NULL)
                unset($tree_menu[$ID]);
        }
        
        return $tree_menu;
    }
    
    function get_survey_aktif() {
        $query = $this->db->query("SELECT * FROM TR_SURVEY WHERE SYSDATE BETWEEN START_DATE AND END_DATE");
        return $query->num_rows();
    }
    
    function get_survey() {
        $query = $this->db->query("SELECT * FROM TR_SURVEY WHERE SYSDATE BETWEEN START_DATE AND END_DATE");
        return $query->result_array();
    }
    
    function get_survey_pertanyaan_jawaban() {
        $survey = $this->get_survey();
        $result = [];
        if ($survey):
            foreach ($survey as $val):
                $pertanyaan = $this->db->query("SELECT TSP.* FROM TR_SURVEY_PERTANYAAN TSP JOIN TR_SURVEY_HASIL TSH ON (TSP.ID=TSH.TRSURVEYPERTANYAAN_ID AND TSH.CREATED_BY=?) WHERE TRSURVEY_ID = ?",[$this->session->userdata('user_id'),$val['ID']])->result_array();
                if (!$pertanyaan):
                    $pertanyaan = $this->db->query("SELECT TSP.* FROM TR_SURVEY_PERTANYAAN TSP WHERE TRSURVEY_ID = ?",[$val['ID']])->result_array();
                    foreach ($pertanyaan as $isi):
                        $jawaban = $this->db->query("SELECT ID,JAWABAN FROM TR_SURVEY_JAWABAN WHERE TRSURVEYPERTANYAAN_ID = ?",[$isi['ID']])->result_array();
                        $result[$val['ID']][] = ['id'=>$isi['ID'],'pertanyaan' => $isi['PERTANYAAN'],'tipe'=>$isi['TIPE_JAWABAN'],'jawaban'=>$jawaban];
                    endforeach;
                endif;
            endforeach;
        endif;
        
        return $result;
    }

}
