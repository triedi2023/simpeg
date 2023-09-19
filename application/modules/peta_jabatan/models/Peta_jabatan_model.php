<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Peta_jabatan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
//        $this->load->helper('limit');
    }
    
    public function get_single_data_ka() {
        $Q_1 = "SELECT NAMA,GELAR_DEPAN,GELAR_BLKG,NIPNEW,to_char(TGLLAHIR,'dd/mm/YYYY') as TGLLAHIR2,FOTO,NULL as url_link,NULL as pangkatgol FROM V_PEGAWAI_JABATAN_MUTAKHIR VPJM LEFT JOIN TM_PEGAWAI TMP ON (VPJM.TMPEGAWAI_ID=TMP.ID) 
        WHERE TRLOKASI_ID = 2 AND KDU1 = '00' AND KDU2 = '00' AND VPJM.TRESELON_ID <> '17' ";
        $result = $this->db->query($Q_1);
        
        return $result->row_array();
    }

    public function get_struktur($table = FALSE, $where = FALSE) {
        $this->db->where($where);
        return $this->db->get($table)->row_array();
    }

    public function get_first_eselon1($lok = '1', $tktesel = '1') {
        $query = "SELECT * FROM V_STRUKTUR WHERE TRLOKASI_ID='$lok' AND TKTESELON='$tktesel' AND STATUS=1 ORDER BY lok,kdu1,kdu2,kdu3,kdu4,kdu5 LIMIT 1 OFFSET 0";
        return $this->db->query($query)->row_array();
    }

    public function list_eselon1($lok = '1', $tktesel = '1') {
        $query = " SELECT * FROM struktur WHERE TRLOKASI_ID='$lok' AND TKTESELON='$tktesel' AND STATUS=1 ORDER BY lok,kdu1,kdu2,kdu3,kdu4,kdu5";
        return $this->db->query($query)->result_array();
    }

    // FIRST ---------------------
    public function get_data_first($lok = 2, $tktesel = '1', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        if (!empty($kdu1) && $kdu1 != '00') {
            $where .= " and (kdu1 = '$kdu1') ";
        }
        if (!empty($kdu2) && $kdu2 != '00') {
            $where .= " and (kdu2 = '$kdu2') ";
        }
        if (!empty($kdu3) && $kdu3 != '000') {
            $where .= " and (kdu3 = '$kdu3') ";
        }
        if (!empty($kdu4) && $kdu4 != '000') {
            $where .= " and (kdu4 = '$kdu4') ";
        }
        if (!empty($kdu5) && $kdu5 != '00') {
            $where .= " and (kdu5 = '$kdu5') ";
        }
        
        $query = " SELECT V_STRUKTUR.*,NULL as pangkatgol,NULL as url_link FROM V_STRUKTUR WHERE TRLOKASI_ID='$lok' AND TKTESELON='$tktesel' $where AND STATUS=1 ORDER BY TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5";
        
        $data = [];
        $i = 0;
        foreach ($this->db->query($query)->result_array() as $row) {
            $data[$i] = $row;
            $data[$i]['detail'] = $this->get_data_spesial('2', $row['TRLOKASI_ID'], $row['KDU1'], $row['KDU2'], $row['KDU3'], $row['KDU4'], $row['KDU5']);
            $i++;
        }
        return $data;
    }

    public function get_data_spesial($tktesel = '2', $lok = 2, $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = "WHERE TKTESELON='$tktesel' AND TRLOKASI_ID='$lok' AND KDU1='$kdu1' AND SPESIAL='Y' AND STATUS=1 ";
        $query = " SELECT V_STRUKTUR.*,NULL as pangkatgol,NULL as url_link FROM V_STRUKTUR " . $where . " ORDER BY TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5";
        return $this->db->query($query)->result_array();
    }

    // END FIRST


    public function get_data_master($tktesel = '2', $lok = 2, $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00', $single = 'Y') {
        switch ($tktesel) {
            default:
            case '2' :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.KDU1='$kdu1' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '3';
                break;

            case '3' :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.KDU1='$kdu1' AND V_STRUKTUR.KDU2='$kdu2' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '4';
                break;

            case '4' :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.KDU1='$kdu1' AND V_STRUKTUR.KDU2='$kdu2' AND V_STRUKTUR.KDU3='$kdu3' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '5';
                break;

            case '5' :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.KDU1='$kdu1' AND V_STRUKTUR.KDU2='$kdu2' AND V_STRUKTUR.KDU3='$kdu3' AND V_STRUKTUR.KDU4='$kdu4' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '6';
                break;
        }
        
        $data = array();
//        $query = " SELECT V_STRUKTUR.*,(SELECT case when TRG.TRSTATUSKEPEGAWAIAN_ID = '1' then PANGKAT||' ('||GOLONGAN||') ' else PANGKAT end as pangkatgol FROM V_PEGAWAI_PANGKAT_MUTAKHIR VPPM LEFT join TR_GOLONGAN TRG on (VPPM.TRGOLONGAN_ID=TRG.ID) lEfT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (VPJM.TMPEGAWAI_ID=VPPM.TMPEGAWAI_ID) 
//        where VPJM.TRLOKASI_ID=V_STRUKTUR.TRLOKASI_ID and VPJM.KDU1=V_STRUKTUR.KDU1 and VPJM.KDU2=V_STRUKTUR.KDU2 
//        and VPJM.KDU3=V_STRUKTUR.KDU3 and VPJM.KDU4=V_STRUKTUR.KDU4 and VPJM.KDU5=V_STRUKTUR.KDU5 and VPJM.TRESELON_ID=V_STRUKTUR.TRESELON_ID and VPJM.TRJABATAN_ID=V_STRUKTUR.TRJABATAN_ID) as pangkatgol FROM V_STRUKTUR  " . $where . " ORDER BY TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5";
        $query = "SELECT V_STRUKTUR.*,
        (case when TRG.TRSTATUSKEPEGAWAIAN_ID = '1' then PANGKAT||' ('||GOLONGAN||') ' else PANGKAT end) as pangkatgol
        FROM V_STRUKTUR LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (VPJM.TRLOKASI_ID=V_STRUKTUR.TRLOKASI_ID 
        and VPJM.KDU1=V_STRUKTUR.KDU1 and VPJM.KDU2=V_STRUKTUR.KDU2 and VPJM.KDU3=V_STRUKTUR.KDU3 and VPJM.KDU4=V_STRUKTUR.KDU4 
        and VPJM.KDU5=V_STRUKTUR.KDU5 and VPJM.TRESELON_ID=V_STRUKTUR.TRESELON_ID and VPJM.TRJABATAN_ID=V_STRUKTUR.TRJABATAN_ID) 
        LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON (VPJM.TMPEGAWAI_ID=VPPM.TMPEGAWAI_ID) 
        LEFT join TR_GOLONGAN TRG on (VPPM.TRGOLONGAN_ID=TRG.ID) ".$where." 
        ORDER BY V_STRUKTUR.TRLOKASI_ID,V_STRUKTUR.KDU1,V_STRUKTUR.KDU2,V_STRUKTUR.KDU3,V_STRUKTUR.KDU4,V_STRUKTUR.KDU5";
//        echo $query;exit;
        $result = $this->db->query($query)->result_array();
        if ($tktesel == '5') {
            if (count($result) > 0) {
                $i = 0;
                foreach ($result as $row) {
                    $data[$i] = $row;
                    if ($single == 'Y') {
                        $data[$i]['detail'] = $this->get_data_detail_single($next_esel, $row['lok'], $row['kdu1'], $row['kdu2'], $row['kdu3'], $row['kdu4'], $row['kdu5']);
                    } else {
                        $get_detail[$i] = $this->get_data_detail($next_esel, $row['lok'], $row['kdu1'], $row['kdu2'], $row['kdu3'], $row['kdu4'], $row['kdu5']);
                        if (count($get_detail[$i]) == 0) {
                            $data[$i]['detail'] = $this->get_data_staff($row['lok'], $row['kdu1'], $row['kdu2'], $row['kdu3'], $row['kdu4'], $row['kdu5']);
                        } else {
                            $data[$i]['detail'] = $get_detail[$i];
                        }
                    }
                    $i++;
                }
            } else {
                $data = $this->get_data_staff($lok, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
            }
        } else {
            $i = 0;
            if (count($result) > 0) {
                foreach ($result as $row) {
                    $data[$i] = $row;
                    if ($single == 'Y') {
                        $data[$i]['detail'] = $this->get_data_detail_single($next_esel, $row['TRLOKASI_ID'], $row['KDU1'], $row['KDU2'], $row['KDU3'], $row['KDU4'], $row['KDU5']);
                    } else {
                        $get_detail[$i] = $this->get_data_detail($next_esel, $row['TRLOKASI_ID'], $row['KDU1'], $row['KDU2'], $row['KDU3'], $row['KDU4'], $row['KDU5']);
                        if (count($get_detail[$i]) == 0) {
                            $data[$i]['detail'] = $this->get_data_staff($row['TRLOKASI_ID'], $row['KDU1'], $row['KDU2'], $row['KDU3'], $row['KDU4'], $row['KDU5']);
                        } else {
                            $data[$i]['detail'] = $get_detail[$i];
                        }
                        //$data[$i]['detail']=$this->get_data_detail($next_esel,$row['lok'],$row['kdu1'],$row['kdu2'],$row['kdu3'],$row['kdu4'],$row['kdu5']);
                    }
                    $i++;
                }
            } else {
                $data = $this->get_data_staff($lok, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5);
            } 
        }
        //echo_r($data,1);
        return $data;
    }

    public function get_data_detail($tktesel = '3', $lok = '1', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        switch ($tktesel) {
            case '2' :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.KDU1='$kdu1' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '3';
                break;

            case '3' :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.KDU1='$kdu1' AND V_STRUKTUR.kdu2='$kdu2' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '4';
                break;

            case '4' :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.KDU1='$kdu1' AND V_STRUKTUR.kdu2='$kdu2' AND V_STRUKTUR.kdu3='$kdu3' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '5';
                break;

            case '5' :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.KDU1='$kdu1' AND V_STRUKTUR.kdu2='$kdu2' AND V_STRUKTUR.kdu3='$kdu3' AND V_STRUKTUR.kdu4='$kdu4' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '6';
                break;
            default :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.kdu1='$kdu1' AND V_STRUKTUR.kdu2='$kdu2' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '4';
                break;
        }
        $query = " SELECT V_STRUKTUR.*,
        (case when TRG.TRSTATUSKEPEGAWAIAN_ID = '1' then PANGKAT||' ('||GOLONGAN||') ' else PANGKAT end) as pangkatgol
        FROM V_STRUKTUR LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (VPJM.TRLOKASI_ID=V_STRUKTUR.TRLOKASI_ID 
        and VPJM.KDU1=V_STRUKTUR.KDU1 and VPJM.KDU2=V_STRUKTUR.KDU2 and VPJM.KDU3=V_STRUKTUR.KDU3 and VPJM.KDU4=V_STRUKTUR.KDU4 
        and VPJM.KDU5=V_STRUKTUR.KDU5 and VPJM.TRESELON_ID=V_STRUKTUR.TRESELON_ID and VPJM.TRJABATAN_ID=V_STRUKTUR.TRJABATAN_ID) 
        LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON (VPJM.TMPEGAWAI_ID=VPPM.TMPEGAWAI_ID) 
        LEFT join TR_GOLONGAN TRG on (VPPM.TRGOLONGAN_ID=TRG.ID) ".$where." 
        ORDER BY V_STRUKTUR.TRLOKASI_ID,V_STRUKTUR.KDU1,V_STRUKTUR.KDU2,V_STRUKTUR.KDU3,V_STRUKTUR.KDU4,V_STRUKTUR.KDU5";
        $i = 0;
        foreach ($this->db->query($query)->result_array() as $row) {
            //$data['query']=$query;
            $data[$i] = $row;
            $data[$i]['detail'] = $this->get_data_detail($next_esel, $row['lok'], $row['kdu1'], $row['kdu2'], $row['kdu3'], $row['kdu4'], $row['kdu5']);
            $i++;
        }
        return $data;
    }

    public function get_data_detail_single($tktesel = '3', $lok = '1', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        switch ($tktesel) {
            case '2' :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.KDU1='$kdu1' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '3';
                break;

            case '3' :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.kdu1='$kdu1' AND V_STRUKTUR.kdu2='$kdu2' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '4';
                break;

            case '4' :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.kdu1='$kdu1' AND V_STRUKTUR.kdu2='$kdu2' AND V_STRUKTUR.kdu3='$kdu3' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '5';
                break;

            case '5' :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.kdu1='$kdu1' AND V_STRUKTUR.kdu2='$kdu2' AND V_STRUKTUR.kdu3='$kdu3' AND V_STRUKTUR.kdu4='$kdu4' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '6';
                break;
            default :
                $where = "WHERE V_STRUKTUR.TKTESELON='$tktesel' AND V_STRUKTUR.TRLOKASI_ID='$lok' AND V_STRUKTUR.kdu1='$kdu1' AND V_STRUKTUR.kdu2='$kdu2' AND V_STRUKTUR.STATUS=1 ";
                $next_esel = '4';
                break;
        }
        $query = " SELECT V_STRUKTUR.*,
        (case when TRG.TRSTATUSKEPEGAWAIAN_ID = '1' then PANGKAT||' ('||GOLONGAN||') ' else PANGKAT end) as pangkatgol
        FROM V_STRUKTUR LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (VPJM.TRLOKASI_ID=V_STRUKTUR.TRLOKASI_ID 
        and VPJM.KDU1=V_STRUKTUR.KDU1 and VPJM.KDU2=V_STRUKTUR.KDU2 and VPJM.KDU3=V_STRUKTUR.KDU3 and VPJM.KDU4=V_STRUKTUR.KDU4 
        and VPJM.KDU5=V_STRUKTUR.KDU5 and VPJM.TRESELON_ID=V_STRUKTUR.TRESELON_ID and VPJM.TRJABATAN_ID=V_STRUKTUR.TRJABATAN_ID) 
        LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON (VPJM.TMPEGAWAI_ID=VPPM.TMPEGAWAI_ID) 
        LEFT join TR_GOLONGAN TRG on (VPPM.TRGOLONGAN_ID=TRG.ID) ".$where." 
        ORDER BY V_STRUKTUR.TRLOKASI_ID,V_STRUKTUR.KDU1,V_STRUKTUR.KDU2,V_STRUKTUR.KDU3,V_STRUKTUR.KDU4,V_STRUKTUR.KDU5";
//        echo $query;exit;
        return $this->db->query($query)->result_array();
    }

    public function get_data_staff($lok = 2, $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $query = " SELECT * FROM V_STRUKTUR_STAFF WHERE TRLOKASI_ID=$lok AND KDU1='$kdu1' AND KDU2='$kdu2' AND KDU3='$kdu3' AND KDU4='$kdu4' and KDU5 = '$kdu5' ";
        return $this->db->query($query)->result_array();
    }
    
    public function get_data_single($tktesel = '2', $lok = '1', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        if (!empty($tktesel)) {
            $where .= " and TKTESELON = '$tktesel' ";
        } else {
            $where .= '';
        }
        if (!empty($kdu1) && $kdu1 != '00') {
            $where .= " and (KDU1 = '$kdu1') ";
        } else {
            $where .= " and (KDU1 = '00') ";
        }
        if (!empty($kdu2) && $kdu2 != '00') {
            $where .= " and (KDU2 = '$kdu2') ";
        } else {
            $where .= " and (KDU2 = '00') ";
        }
        if (!empty($kdu3) && $kdu3 != '000') {
            $where .= " and (KDU3 = '$kdu3') ";
        } else {
            $where .= " and (KDU3 = '000') ";
        }
        if (!empty($kdu4) && $kdu4 != '000') {
            $where .= " and (KDU4 = '$kdu4') ";
        } else {
            $where .= " and (KDU4 = '000') ";
        }
        if (!empty($kdu5) && $kdu5 != '00') {
            $where .= " and (KDU5 = '$kdu5') ";
        } else {
            $where .= " and (KDU5 = '00') ";
        }
        
        $query = " SELECT ID FROM V_STRUKTUR where STATUS = 1 and TRLOKASI_ID = '$lok' $where ORDER BY TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5";
        return $this->db->query($query)->row()->ID;
    }
    
    public function getdatasingletingkateselon($lok = '1', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
        $where = '';
        if (!empty($lok) && $lok != '0') {
            $where .= " and (V_STRUKTUR.TRLOKASI_ID = $lok) ";
        } else {
            $where .= " and (V_STRUKTUR.TRLOKASI_ID = 0) ";
        }
        if (!empty($kdu1) && $kdu1 != '00') {
            $where .= " and (V_STRUKTUR.KDU1 = '$kdu1') ";
        } else {
            $where .= " and (V_STRUKTUR.KDU1 = '00') ";
        }
        if (!empty($kdu2) && $kdu2 != '00') {
            $where .= " and (V_STRUKTUR.KDU2= '$kdu2') ";
        } else {
            $where .= " and (V_STRUKTUR.KDU2 = '00') ";
        }
        if (!empty($kdu3) && $kdu3 != '000') {
            $where .= " and (V_STRUKTUR.KDU3 = '$kdu3') ";
        } else {
            $where .= " and (V_STRUKTUR.KDU3 = '000') ";
        }
        if (!empty($kdu4) && $kdu4 != '000') {
            $where .= " and (V_STRUKTUR.KDU4 = '$kdu4') ";
        } else {
            $where .= " and (V_STRUKTUR.KDU4 = '000') ";
        }
        if (!empty($kdu5) && $kdu5 != '00') {
            $where .= " and (V_STRUKTUR.KDU5 = '$kdu5') ";
        } else {
            $where .= " and (V_STRUKTUR.KDU5 = '00') ";
        }
        
        $query = " SELECT V_STRUKTUR.*,
        (case when TRG.TRSTATUSKEPEGAWAIAN_ID = '1' then PANGKAT||' ('||GOLONGAN||') ' else PANGKAT end) as pangkatgol
        FROM V_STRUKTUR LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (VPJM.TRLOKASI_ID=V_STRUKTUR.TRLOKASI_ID 
        and VPJM.KDU1=V_STRUKTUR.KDU1 and VPJM.KDU2=V_STRUKTUR.KDU2 and VPJM.KDU3=V_STRUKTUR.KDU3 and VPJM.KDU4=V_STRUKTUR.KDU4 
        and VPJM.KDU5=V_STRUKTUR.KDU5 and VPJM.TRESELON_ID=V_STRUKTUR.TRESELON_ID and VPJM.TRJABATAN_ID=V_STRUKTUR.TRJABATAN_ID) 
        LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON (VPJM.TMPEGAWAI_ID=VPPM.TMPEGAWAI_ID) 
        LEFT join TR_GOLONGAN TRG on (VPPM.TRGOLONGAN_ID=TRG.ID) WHERE V_STRUKTUR.STATUS=1 ".$where." 
        ORDER BY V_STRUKTUR.TRLOKASI_ID,V_STRUKTUR.KDU1,V_STRUKTUR.KDU2,V_STRUKTUR.KDU3,V_STRUKTUR.KDU4,V_STRUKTUR.KDU5 ";
//        echo $query;
        return $this->db->query($query)->row_array();
    }

}
