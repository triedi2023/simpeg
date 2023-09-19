<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda_model extends CI_Model {

    public function get_data_ultah($pegawai_id = "", $bulan = "", $tanggal = "", $trlokasi_id = '2', $kdu1 = '', $kdu2 = '', $kdu3 = '', $kdu4 = '', $kdu5 = '') {
        if ($pegawai_id) {
            $this->db->where("TP.ID", $pegawai_id);
        }
        if (!empty($bulan) && !empty($tanggal)) {
            $this->db->where("TO_CHAR(TO_DATE(TGLLAHIR),'MM-DD')","$bulan-$tanggal");
        }
        if ($trlokasi_id) {
            $this->db->where("VPJM.TRLOKASI_ID", $trlokasi_id);
        }
        if ($kdu1) {
            $this->db->where("VPJM.KDU1", $kdu1);
        }
        if ($kdu2) {
            $this->db->where("VPJM.KDU2", $kdu2);
        }
        if ($kdu3) {
            $this->db->where("VPJM.KDU3", $kdu3);
        }
        if ($kdu4) {
            $this->db->where("VPJM.KDU4", $kdu4);
        }
        if ($kdu5) {
            $this->db->where("VPJM.KDU5", $kdu5);
        }
        
        $this->db->where("VPJM.TRESELON_ID <>", '17');

        $this->db->select("TP.ID,TP.NAMA,TP.GELAR_DEPAN,TP.GELAR_BLKG,TP.NIPNEW,TO_CHAR(TGLLAHIR,'DD/MM/YYYY') AS TGLLAHIR");
        $this->db->from("TM_PEGAWAI TP");
        $this->db->join("V_PEGAWAI_JABATAN_MUTAKHIR VPJM", "TP.ID=VPJM.TMPEGAWAI_ID", "JOIN");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_profile($pegawai_id = "") {
        if ($pegawai_id) {
            $this->db->where("TP.ID", $pegawai_id);
        }

        $this->db->select("TP.NAMA,TP.GELAR_DEPAN,TP.GELAR_BLKG,TP.NIPNEW,TO_CHAR(TGLLAHIR,'DD/MM/YYYY') AS TGLLAHIR,VPJM.N_JABATAN,
        TRG.GOLONGAN,TRG.PANGKAT,TP.TPTLAHIR,TRG.TRSTATUSKEPEGAWAIAN_ID,TP.ALAMAT,TP.TELP_HP,TP.FOTO");
        $this->db->from("TM_PEGAWAI TP");
        $this->db->join("V_PEGAWAI_JABATAN_MUTAKHIR VPJM", "TP.ID=VPJM.TMPEGAWAI_ID", "LEFT");
        $this->db->join("V_PEGAWAI_PANGKAT_MUTAKHIR VPPM", "TP.ID=VPPM.TMPEGAWAI_ID", "LEFT");
        $this->db->join("TR_GOLONGAN TRG", "VPPM.TRGOLONGAN_ID=TRG.ID", "LEFT");
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_data_jab_stuktural_kosong($lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        $condition = [];
        if (!empty($lok) && $lok != '0') {
            $where .= " AND TRLOKASI_ID=? ";
            $condition = array_merge($condition, [$lok]);
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND KDU1=? ";
            $condition = array_merge($condition, [$kdu1]);
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND KDU2=? ";
            $condition = array_merge($condition, [$kdu2]);
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND KDU3=? ";
            $condition = array_merge($condition, [$kdu3]);
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND KDU4=? ";
            $condition = array_merge($condition, [$kdu4]);
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND KDU5=? ";
            $condition = array_merge($condition, [$kdu5]);
        }

        $query = "SELECT TSO.TRLOKASI_ID,TSO.KDU1,TSO.KDU2,TSO.KDU3,TSO.KDU4,TSO.KDU5,TSO.TRESELON_ID,TSO.TRJABATAN_ID,TSO.ID, f_get_jabatan_jabunitkerjaesel(TSO.TRJABATAN_ID,TSO.TRLOKASI_ID,TSO.KDU1,TSO.KDU2,TSO.KDU3,TSO.KDU4,TSO.KDU5,TSO.TRESELON_ID) as nm_stuktur
        FROM TR_STRUKTUR_ORGANISASI TSO WHERE not exists (select 1 from V_PEGAWAI_JABATAN_MUTAKHIR VPJM where VPJM.TRESELON_ID <> '17' AND TSO.TRLOKASI_ID = VPJM.TRLOKASI_ID AND 
            TSO.KDU1 = VPJM.KDU1 AND TSO.KDU2 = VPJM.KDU2 AND TSO.KDU3 = VPJM.KDU3 AND TSO.KDU4 = VPJM.KDU4 AND TSO.KDU5 = VPJM.KDU5 and TSO.TRESELON_ID = VPJM.TRESELON_ID
        ) AND TSO.STATUS=1 AND TSO.NMUNIT <> '-' $where ORDER BY TSO.TRLOKASI_ID,TSO.KDU1,TSO.KDU2,TSO.KDU3,TSO.KDU4,TSO.KDU5";
        
        return $this->db->query($query, $condition)->result_array();
    }

    public function get_data_pensiun($lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        $condition = [];
        if (!empty($lok) && $lok != '0') {
            $where .= " AND TRLOKASI_ID=? ";
            $condition = array_merge($condition, [$lok]);
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND KDU1=? ";
            $condition = array_merge($condition, [$kdu1]);
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND KDU2=? ";
            $condition = array_merge($condition, [$kdu2]);
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND KDU3=? ";
            $condition = array_merge($condition, [$kdu3]);
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND KDU4=? ";
            $condition = array_merge($condition, [$kdu4]);
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND KDU5=? ";
            $condition = array_merge($condition, [$kdu5]);
        }
        
        $bulan = date('m');
        $tahun = date('Y');
        $query = "SELECT XX.BULAN_PENSIUN,COUNT(XX.TMT_PENSIUN) AS JML FROM (
            SELECT TO_CHAR(TO_DATE(TMT_PENSIUN),'MM') AS BULAN_PENSIUN, TMT_PENSIUN FROM V_MONITORING_PENSIUN 
            WHERE TO_CHAR(TO_DATE(TMT_PENSIUN),'YYYY') = '$tahun' AND TO_CHAR(TO_DATE(TMT_PENSIUN),'MM') >= '$bulan' $where
        ) XX GROUP BY XX.BULAN_PENSIUN ORDER BY XX.BULAN_PENSIUN";

        return $this->db->query($query, $condition)->result_array();
    }

    public function get_daftar_pegawai_pensiun($bulan = "", $lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        if ($bulan) {
            $this->db->where("TO_CHAR(TO_DATE(VMP.TMT_PENSIUN),'MM-YYYY')", "'$bulan-" . date('Y') . "'");
        }
        if ($kdu1) {
            $this->db->where("VMP.KDU1", $kdu1);
        }
        if ($kdu2) {
            $this->db->where("VMP.KDU2", $kdu2);
        }
        if ($kdu3) {
            $this->db->where("VMP.KDU3", $kdu3);
        }
        if ($kdu4) {
            $this->db->where("VMP.KDU4", $kdu4);
        }
        if ($kdu5) {
            $this->db->where("VMP.KDU5", $kdu5);
        }

        $this->db->from("V_MONITORING_PENSIUN VMP");
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_kp_reguler($periode, $lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        $condition = [];
        if (!empty($lok) && $lok != '0') {
            $where .= " AND TRLOKASI_ID=? ";
            $condition = array_merge($condition, [$lok]);
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND KDU1=? ";
            $condition = array_merge($condition, [$kdu1]);
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND KDU2=? ";
            $condition = array_merge($condition, [$kdu2]);
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND KDU3=? ";
            $condition = array_merge($condition, [$kdu3]);
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND KDU4=? ";
            $condition = array_merge($condition, [$kdu4]);
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND KDU5=? ";
            $condition = array_merge($condition, [$kdu5]);
        }

        $query = "SELECT * FROM (
            SELECT NAMA,TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5 FROM TABLE(F_MON_KP_REGULER('$periode')) WHERE TRESELON_ID NOT IN ('13','15','17')
            UNION ALL
            SELECT NAMA,TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5 FROM TABLE(F_MON_KP_FUNGSIONAL('$periode')) WHERE TRESELON_ID <> '17'
        ) XYZ WHERE 1=1 $where ";
        
        return $this->db->query($query, $condition)->result_array();
    }
    
    public function get_jml_jabatan_umum($lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        $condition = [];
        if (!empty($lok) && $lok != '0') {
            $where .= " AND TRLOKASI_ID=? ";
            $condition = array_merge($condition, [$lok]);
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND KDU1=? ";
            $condition = array_merge($condition, [$kdu1]);
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND KDU2=? ";
            $condition = array_merge($condition, [$kdu2]);
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND KDU3=? ";
            $condition = array_merge($condition, [$kdu3]);
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND KDU4=? ";
            $condition = array_merge($condition, [$kdu4]);
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND KDU5=? ";
            $condition = array_merge($condition, [$kdu5]);
        }

        $query = "SELECT TRJ.ID,TRJ.JABATAN,COUNT(VPJM.TMPEGAWAI_ID) AS JML FROM V_PEGAWAI_JABATAN_MUTAKHIR VPJM 
        LEFT JOIN TR_JABATAN TRJ ON TRJ.ID = VPJM.TRJABATAN_ID WHERE VPJM.TRESELON_ID <> '17' 
        AND VPJM.TRESELON_ID = '15' AND TRJ.STATUS = 1 $where GROUP BY TRJ.ID,TRJ.JABATAN ORDER BY TRJ.JABATAN";
        $fetch = $this->db->query($query, $condition)->result_array();
        $data = [];
        if ($fetch):
            foreach ($fetch as $val):
                $data[] = ['id' => $val['ID'], 'jabatan' => $val['JABATAN'], 'value' => $val['JML']];
            endforeach;
        endif;
        
        return $data;
    }
    
    public function get_jml_jabatan_khusus($lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        $condition = [];
        if (!empty($lok) && $lok != '0') {
            $where .= " AND TRLOKASI_ID=? ";
            $condition = array_merge($condition, [$lok]);
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND KDU1=? ";
            $condition = array_merge($condition, [$kdu1]);
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND KDU2=? ";
            $condition = array_merge($condition, [$kdu2]);
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND KDU3=? ";
            $condition = array_merge($condition, [$kdu3]);
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND KDU4=? ";
            $condition = array_merge($condition, [$kdu4]);
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND KDU5=? ";
            $condition = array_merge($condition, [$kdu5]);
        }
        
        $query = "SELECT TRJ.ID,TRJ.JABATAN,COUNT(VPJM.TMPEGAWAI_ID) AS JML FROM V_PEGAWAI_JABATAN_MUTAKHIR VPJM 
        LEFT JOIN TR_JABATAN TRJ ON TRJ.ID = VPJM.TRJABATAN_ID WHERE VPJM.TRESELON_ID <> '17'
        AND VPJM.TRESELON_ID = '13' AND TRJ.STATUS = 1 $where GROUP BY TRJ.ID,TRJ.JABATAN ORDER BY TRJ.JABATAN";
        
        $fetch = $this->db->query($query, $condition)->result_array();
        $data = [];
        if ($fetch):
            foreach ($fetch as $val):
                $data[] = ['id' => $val['ID'], 'jabatan' => $val['JABATAN'], 'value' => $val['JML']];
            endforeach;
        endif;

        return $data;
    }
    
    public function get_jml_jabatan_eselon($lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        $condition = [];
        if (!empty($lok) && $lok != '0') {
            $where .= " AND TRLOKASI_ID=? ";
            $condition = array_merge($condition, [$lok]);
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND KDU1=? ";
            $condition = array_merge($condition, [$kdu1]);
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND KDU2=? ";
            $condition = array_merge($condition, [$kdu2]);
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND KDU3=? ";
            $condition = array_merge($condition, [$kdu3]);
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND KDU4=? ";
            $condition = array_merge($condition, [$kdu4]);
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND KDU5=? ";
            $condition = array_merge($condition, [$kdu5]);
        }
        
        $query = "SELECT TRE.SINGKATAN AS ESELON,sum((case when MPPV.TMPEGAWAI_ID is not null then 1 else 0 end)) AS JML FROM TR_ESELON TRE 
        LEFT JOIN (SELECT VPJM.TRESELON_ID,VPJM.TMPEGAWAI_ID FROM V_PEGAWAI_JABATAN_MUTAKHIR VPJM 
        WHERE 1=1 $where ) 
        MPPV ON TRE.ID = MPPV.TRESELON_ID WHERE TRE.STATUS = 1 AND TRE.ID < '11' GROUP BY TRE.SINGKATAN
        ORDER BY TRE.SINGKATAN ASC";
        $fetch = $this->db->query($query, $condition)->result_array();
        $data = [];
        $color = ["#FF0F00","#FF9E01","#B0DE09","#04D215","#0D8ECF"];
        if ($fetch):
            $i = 0;
            foreach ($fetch as $val):
                $data[] = ['jabatan' => $val['ESELON'], 'value' => $val['JML'], 'color' => $color[$i]];
                $i++;
            endforeach;
        endif;
        
        return $data;
    }
    
    public function get_jml_eselon_tkt($lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        $condition = [];
        if (!empty($lok) && $lok != '0') {
            $where .= " AND TRLOKASI_ID=? ";
            $condition = array_merge($condition, [$lok]);
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND KDU1=? ";
            $condition = array_merge($condition, [$kdu1]);
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND KDU2=? ";
            $condition = array_merge($condition, [$kdu2]);
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND KDU3=? ";
            $condition = array_merge($condition, [$kdu3]);
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND KDU4=? ";
            $condition = array_merge($condition, [$kdu4]);
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND KDU5=? ";
            $condition = array_merge($condition, [$kdu5]);
        }
        
        $query = "SELECT TRE.SINGKATAN AS SINGKATAN,sum((case when MPPV.TMPEGAWAI_ID is not null then 1 else 0 end)) AS JML FROM TR_ESELON TRE 
        LEFT JOIN (SELECT VPJM.TRESELON_ID,VPJM.TMPEGAWAI_ID FROM V_PEGAWAI_JABATAN_MUTAKHIR VPJM 
        WHERE 1=1 $where ) 
        MPPV ON TRE.ID = MPPV.TRESELON_ID WHERE TRE.STATUS = 1 AND TRE.ID < '11' GROUP BY TRE.SINGKATAN
        ORDER BY TRE.SINGKATAN ASC";
        
        $fetch = $this->db->query($query, $condition)->result_array();
        
        return $fetch;
    }
    
    public function get_jml_diklat_pim($lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        $condition = [];
        if (!empty($lok) && $lok != '0') {
            $where .= " AND TRLOKASI_ID=? ";
            $condition = array_merge($condition, [$lok]);
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND KDU1=? ";
            $condition = array_merge($condition, [$kdu1]);
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND KDU2=? ";
            $condition = array_merge($condition, [$kdu2]);
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND KDU3=? ";
            $condition = array_merge($condition, [$kdu3]);
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND KDU4=? ";
            $condition = array_merge($condition, [$kdu4]);
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND KDU5=? ";
            $condition = array_merge($condition, [$kdu5]);
        }
        
        $query = "SELECT TTDK.ID,TTDK.NAMA_JENJANG,COUNT(VPJM.TMPEGAWAI_ID) AS JML FROM V_PEGAWAI_JABATAN_MUTAKHIR VPJM 
        LEFT JOIN TH_PEGAWAI_DIKLAT_PENJENJANGAN TPDP ON TPDP.TMPEGAWAI_ID = VPJM.TMPEGAWAI_ID LEFT JOIN TR_TINGKAT_DIKLAT_KEPEMIMPINAN TTDK ON (TTDK.ID=TPDP.TRTINGKATDIKLATKEPEMIMPINAN_ID)
        WHERE TPDP.TRTINGKATDIKLATKEPEMIMPINAN_ID IN (1,2,3,4,15) 
        AND VPJM.TRESELON_ID <> '17' $where GROUP BY TTDK.ID,TTDK.NAMA_JENJANG ORDER BY TTDK.NAMA_JENJANG ASC";
        $fetch = $this->db->query($query, $condition)->result_array();
        
        return $fetch;
    }
    
    public function get_jml_pendidikan($lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        $condition = [];
        if (!empty($lok) && $lok != '0') {
            $where .= " AND TRLOKASI_ID=? ";
            $condition = array_merge($condition, [$lok]);
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND KDU1=? ";
            $condition = array_merge($condition, [$kdu1]);
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND KDU2=? ";
            $condition = array_merge($condition, [$kdu2]);
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND KDU3=? ";
            $condition = array_merge($condition, [$kdu3]);
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND KDU4=? ";
            $condition = array_merge($condition, [$kdu4]);
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND KDU5=? ";
            $condition = array_merge($condition, [$kdu5]);
        }
        
        $query = "SELECT VPPM.TRTINGKATPENDIDIKAN_ID,TTP.TINGKAT_PENDIDIKAN,COUNT(VPJM.TMPEGAWAI_ID) AS JML FROM V_PEGAWAI_JABATAN_MUTAKHIR VPJM 
        JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR VPPM ON VPPM.TMPEGAWAI_ID = VPJM.TMPEGAWAI_ID LEFT JOIN TR_TINGKAT_PENDIDIKAN TTP ON (TTP.ID=VPPM.TRTINGKATPENDIDIKAN_ID) 
        WHERE TTP.STATUS = 1 AND VPJM.TRESELON_ID <> '17' $where GROUP BY VPPM.TRTINGKATPENDIDIKAN_ID,TTP.TINGKAT_PENDIDIKAN ORDER BY TTP.TINGKAT_PENDIDIKAN ASC";
        $fetch = $this->db->query($query, $condition)->result_array();
        
        return $fetch;
    }
    
    public function savesetupdashboard($var = array()) {
        $this->db->trans_begin();
        $this->db->set('UPDATED_DATE', "TO_DATE('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $this->db->where('KUNCINYA',"setup_dashboard");
        $this->db->update("SYSTEM_CONFIG", $var);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    function get_struktur($lok='2',$kdu1='00',$kdu2='00',$kdu3='000',$kdu4='000',$kdu5='00') {
        $param = $lok.";".$kdu1.";".$kdu2.";".$kdu3.";".$kdu5.";".$kdu5;
        $sql = "SELECT F_GET_UNITKERJA_KODEREF('$param') AS NMSTRUKTUR FROM DUAL";
        $query = $this->db->query($sql);
        return $query->row_array();
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
                $pertanyaan = $this->db->query("SELECT TSP.* FROM TR_SURVEY_PERTANYAAN TSP JOIN TR_SURVEY_HASIL TSH ON (TSP.ID=TSH.TRSURVEYPERTANYAAN_ID AND TSH.CREATED_BY=?) WHERE TRSURVEY_ID = ? ORDER BY TSP.ID ASC",[$this->session->userdata('user_id'),$val['ID']])->result_array();
                if (!$pertanyaan):
                    $pertanyaan = $this->db->query("SELECT TSP.* FROM TR_SURVEY_PERTANYAAN TSP WHERE TRSURVEY_ID = ? ORDER BY TSP.ID ASC",[$val['ID']])->result_array();
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
