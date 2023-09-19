<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_nominatif_gabungan_model extends CI_Model {

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

    function get_data($lok = 1, $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
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
        
        if (!empty($lok) && $lok != 2) {
            $sql = "SELECT VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5, VPJM.TRESELON_ID, NULL AS NMUNIT, TP.GELAR_DEPAN, 
                TP.NAMA, TP.GELAR_BLKG, TRG.GOLONGAN, TRG.PANGKAT, TRG.TRSTATUSKEPEGAWAIAN_ID, LTRIM(TRE.ESELON,'Eselon ') AS ESELONTEXT, VPJM.TRJABATAN_ID, VPJM.N_JABATAN, TP.NIPNEW, TP.NIP,
                TO_CHAR(VPPM.TMT_GOL, 'DD/MM/YYYY') AS TMT_GOL2,TO_CHAR(VPJM.TMT_JABATAN, 'DD/MM/YYYY') AS TMT_JABATAN,NULL AS TKTESELON, TRG.URUTAN, NULL AS NUMBERSATU,
                ROW_NUMBER() OVER(ORDER BY VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5, TRG.URUTAN DESC, VPPM.TMT_GOL ASC, TRE.ID) AS NUMBERDUA,
                ROW_NUMBER() OVER(PARTITION BY VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5 ORDER BY VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5, TRG.URUTAN DESC, VPPM.TMT_GOL ASC, TRE.ID) AS NUMBERTIGA,
                CASE WHEN VPJM.TRJABATAN_ID IN ('0103', '0104') THEN VPJM.N_JABATAN ELSE F_GET_JABATAN_JABUNITKERJAESEL(VPJM.TRJABATAN_ID,TRLOKASI_ID, KDU1, KDU2, KDU3, KDU4, KDU5, VPJM.TRESELON_ID) END AS JABATAN
                FROM TM_PEGAWAI TP 
                LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (TP.ID=VPJM.TMPEGAWAI_ID) LEFT JOIN TR_JABATAN TRJ ON (TRJ.ID=VPJM.TRJABATAN_ID AND TRJ.STATUS=1) LEFT JOIN TR_ESELON TRE ON (TRE.ID=VPJM.TRESELON_ID AND TRE.STATUS=1)
                LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON (TP.ID=VPPM.TMPEGAWAI_ID) LEFT JOIN TR_GOLONGAN TRG ON (VPPM.TRGOLONGAN_ID=TRG.ID AND TRG.STATUS=1)
                WHERE VPJM.TRESELON_ID <> '17' $where ORDER BY CASE WHEN VPJM.TRESELON_ID < '11' THEN VPJM.TRESELON_ID||VPJM.TRLOKASI_ID||VPJM.KDU1||VPJM.KDU2||VPJM.KDU3||VPJM.KDU4||VPJM.KDU5 END,
                CASE WHEN VPJM.TRESELON_ID > '10' THEN TRG.GOLONGAN END DESC,VPPM.TMT_GOL";
//                WHERE VPJM.TRESELON_ID <> '17' $where ORDER BY TRG.URUTAN DESC, TO_DATE(VPPM.TMT_GOL) ASC";
        } else {
            $sql = "SELECT VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5, VPJM.TRESELON_ID, NULL AS NMUNIT, TP.GELAR_DEPAN, 
                TP.NAMA, TP.GELAR_BLKG, TRG.GOLONGAN, TRG.PANGKAT, TRG.TRSTATUSKEPEGAWAIAN_ID, LTRIM(TRE.ESELON,'Eselon ') AS ESELONTEXT, VPJM.TRJABATAN_ID, VPJM.N_JABATAN, TP.NIPNEW, TP.NIP,
                TO_CHAR(VPPM.TMT_GOL, 'DD/MM/YYYY') AS TMT_GOL2,TO_CHAR(VPJM.TMT_JABATAN, 'DD/MM/YYYY') AS TMT_JABATAN,NULL AS TKTESELON, TRG.URUTAN, NULL AS NUMBERSATU,
                ROW_NUMBER() OVER(ORDER BY VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5, TRG.URUTAN DESC, VPPM.TMT_GOL ASC, TRE.ID) AS NUMBERDUA,
                ROW_NUMBER() OVER(PARTITION BY VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5 ORDER BY VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5, TRG.URUTAN DESC, VPPM.TMT_GOL ASC, TRE.ID) AS NUMBERTIGA,
                CASE WHEN VPJM.TRJABATAN_ID IN ('0103', '0104') THEN VPJM.N_JABATAN ELSE F_GET_JABATAN_JABUNITKERJAESEL(VPJM.TRJABATAN_ID,TRLOKASI_ID, KDU1, KDU2, KDU3, KDU4, KDU5, VPJM.TRESELON_ID) END AS JABATAN
                FROM TM_PEGAWAI TP LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON (TP.ID=VPPM.TMPEGAWAI_ID) LEFT JOIN TR_GOLONGAN TRG ON (VPPM.TRGOLONGAN_ID=TRG.ID AND TRG.STATUS=1)
                LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (TP.ID=VPJM.TMPEGAWAI_ID) LEFT JOIN TR_JABATAN TRJ ON (TRJ.ID=VPJM.TRJABATAN_ID AND TRJ.STATUS=1) LEFT JOIN TR_ESELON TRE ON (TRE.ID=VPJM.TRESELON_ID AND TRE.STATUS=1)
                WHERE VPJM.TRESELON_ID <> '17' AND (TRLOKASI_ID = '2' AND KDU1 <> '00') $where ORDER BY VPJM.TRESELON_ID, TRG.URUTAN DESC, TO_DATE(VPPM.TMT_GOL) ASC";
        }
        
        $query = $this->db->query($sql);

        return $query->result_array();
    }

}