<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik_diklat_pim_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_struktur($lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $param = $lok . ";" . $kdu1 . ";" . $kdu2 . ";" . $kdu3 . ";" . $kdu5 . ";" . $kdu5;
        $sql = "SELECT F_GET_UNITKERJA_KODEREF('$param') AS NMSTRUKTUR FROM DUAL";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    function get_data_chart($lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        if (!empty($lok) && $lok != '0') {
            $where .= " AND TRLOKASI_ID=$lok ";
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND KDU1='$kdu1' ";
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND KDU2='$kdu2' ";
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND KDU3='$kdu3' ";
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND KDU4='$kdu4' ";
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND KDU5='$kdu5' ";
        }

        $sql = "SELECT COUNT(TRTINGKATDIKLATKEPEMIMPINAN_ID) AS JML,TTD.ID,NAMA_JENJANG FROM TR_TINGKAT_DIKLAT_KEPEMIMPINAN TTD 
        LEFT JOIN V_PEGAWAI_DIKLATPIM_MUTAKHIR VPDM ON (TTD.ID=VPDM.TRTINGKATDIKLATKEPEMIMPINAN_ID) 
        LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (VPDM.TMPEGAWAI_ID=VPJM.TMPEGAWAI_ID) 
        WHERE TTD.ID NOT IN (5,10) AND TTD.STATUS = 1 $where GROUP BY TTD.ID, NAMA_JENJANG";
        $query = $this->db->query($sql);

        $data = [];
        if ($query->result_array()):
            foreach ($query->result_array() as $val):
                $data[] = ['id' => $val['ID'], 'diklat' => $val['NAMA_JENJANG'], 'value' => $val['JML']];
            endforeach;
        endif;
        return $data;
    }
    
    function get_data_matrix($lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        if (!empty($lok) && $lok != '0') {
            $where .= " AND LOKASI=$lok ";
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND KDU1='$kdu1' ";
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND KDU2='$kdu2' ";
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND KDU3='$kdu3' ";
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND KDU4='$kdu4' ";
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND KDU5='$kdu5' ";
        }

        $sql = "SELECT * FROM V_DIKLATPIM_PER_UNITKERJA WHERE 1=1 $where order by LOKASI,KDU1,KDU2,KDU3,KDU4,KDU5";
        $query = $this->db->query($sql);
        
        return $query->result_array();
    }

    function get_data($lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00', $matrix_type) {
        $where = '';
        if (!empty($lok) && $lok != '0') {
            $where .= " AND LOKASI=$lok ";
        }
        if (!empty($kdu1) && $kdu1 != "00") {
            $where .= " AND KDU1='$kdu1' ";
        }
        if (!empty($kdu2) && $kdu2 != "00") {
            $where .= " AND KDU2='$kdu2' ";
        }
        if (!empty($kdu3) && $kdu3 != "000") {
            $where .= " AND KDU3='$kdu3' ";
        }
        if (!empty($kdu4) && $kdu4 != "000") {
            $where .= " AND KDU4='$kdu4' ";
        }
        if (!empty($kdu5) && $kdu5 != "00") {
            $where .= " AND KDU5='$kdu5' ";
        }

        $sql = "select a.LOKASI_UNIT as PARENT_LOKASI,
                    a.LOKASI,
                     a.KDU1,
                     a.KDU2,
                     a.KDU3,
                     a.KDU4,
                     a.KDU5,
                   (select sum(b.total) FROM V_DIKLATPIM_PER_UNITKERJA b where b.LOKASI_UNIT=a.LOKASI_UNIT)as total
          from V_DIKLATPIM_PER_UNITKERJA a
          WHERE 1=1 $where 
                          order by 
                          a.LOKASI,
                             a.KDU1,
                             a.KDU2,
                             a.KDU3,
                             a.KDU4,
                             a.KDU5";

        $query = $this->db->query($sql)->result_array();
        
        $data_grid = [];
        $i = 0;
        foreach ($query as $row) {
            $data_grid[$i]['parent_lokasi'] = $row['PARENT_LOKASI'];
            $data_grid[$i]['total_group'] = $row['TOTAL'];
            $data_grid[$i]['detail_lokasi'] = $this->get_data_detail($row['PARENT_LOKASI'], $matrix_type);
            $i++;
        }
        return $data_grid;
    }
    
    function get_data_detail($unit_lokasi = false, $matrix_type = '1') {
        switch ($matrix_type) {
            default:
            case '1':
                $query = "select 
							a.lokasi_unit as  nm_lokasi,
							sum(a.pim_tk4_l) as es4l,
							sum(a.pim_tk4_p) as es4p,
							sum(a.pim_tk3_l) as es3l,
							sum(a.pim_tk3_p) as es3p,
							sum(a.pim_tk2_l) as es2l,
							sum(a.pim_tk2_p) as es2p,
							sum(a.pim_tk1_l) as es1l,
							sum(a.pim_tk1_p) as es1p,
							sum(a.lemhanas_l) as es1_fk_l,
							sum(a.lemhanas_p) as es1_fk_p,
							sum(a.total)
						from V_DIKLATPIM_PER_UNITKERJA a
						WHERE a.lokasi_unit='$unit_lokasi'
						group by a.lokasi_unit ";
                break;
            case '2':
                $query = "select 
							a.jabatan as  nm_lokasi,
							sum(a.pim_tk4_l) as es4l,
							sum(a.pim_tk4_p) as es4p,
							sum(a.pim_tk3_l) as es3l,
							sum(a.pim_tk3_p) as es3p,
							sum(a.pim_tk2_l) as es2l,
							sum(a.pim_tk2_p) as es2p,
							sum(a.pim_tk1_l) as es1l,
							sum(a.pim_tk1_p) as es1p,
							sum(a.lemhanas_l) as es1_fk_l,
							sum(a.lemhanas_p) as es1_fk_p,
							sum(a.total)
						from V_DIKLATPIM_PER_ESELON a
						WHERE a.lokasi_unit='$unit_lokasi'
						group by a.jabatan ";
                break;
        }
        return $this->db->query($query)->result_array();
    }

}
