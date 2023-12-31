<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_nominatif_model extends CI_Model {

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

    function get_data($lok = '2', $kdu1 = '00', $kdu2 = '00', $kdu3 = '000', $kdu4 = '000', $kdu5 = '00') {
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

        $sql = "WITH LAPORAN_DAFTAR_NOMINATIF AS (
            SELECT TRLOKASI_ID, KDU1, KDU2, KDU3, KDU4, KDU5, TRESELON_ID, NMUNIT, NULL AS GELAR_DEPAN, NULL AS NAMA, NULL AS GELAR_BLKG,
            NULL AS GOLONGAN, NULL AS PANGKAT, NULL AS TRSTATUSKEPEGAWAIAN_ID, NULL AS ESELONTEXT, TRJABATAN_ID, NULL AS N_JABATAN, NULL AS NIPNEW, NULL AS NIP,NULL AS TMT_GOL,
            NULL AS TMT_JABATAN, TKTESELON, NULL AS URUTANGOL,ROW_NUMBER() OVER(ORDER BY TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5) AS NUMBERSATU,
            NULL AS NUMBERDUA, NULL AS NUMBERTIGA FROM TR_STRUKTUR_ORGANISASI WHERE STATUS = 1 $where
            UNION
            SELECT VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5, VPJM.TRESELON_ID, NULL AS NMUNIT, TP.GELAR_DEPAN, 
            TP.NAMA, TP.GELAR_BLKG, TRG.GOLONGAN, TRG.PANGKAT, TRG.TRSTATUSKEPEGAWAIAN_ID, LTRIM(TRE.ESELON,'Eselon ') AS ESELONTEXT, VPJM.TRJABATAN_ID, VPJM.N_JABATAN, TP.NIPNEW, TP.NIP,
            TO_CHAR(VPPM.TMT_GOL, 'DD/MM/YYYY') AS TMT_GOL,TO_CHAR(VPJM.TMT_JABATAN, 'DD/MM/YYYY') AS TMT_JABATAN,NULL AS TKTESELON, TRG.URUTAN, NULL AS NUMBERSATU,
            ROW_NUMBER() OVER(ORDER BY VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5, TRG.URUTAN DESC, VPPM.TMT_GOL ASC, TRE.ID) AS NUMBERDUA,
            ROW_NUMBER() OVER(PARTITION BY VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5 ORDER BY VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5, TRG.URUTAN DESC, VPPM.TMT_GOL ASC, TRE.ID) AS NUMBERTIGA
            FROM TM_PEGAWAI TP 
            JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (TP.ID=VPJM.TMPEGAWAI_ID) LEFT JOIN TR_JABATAN TRJ ON (TRJ.ID=VPJM.TRJABATAN_ID) LEFT JOIN TR_ESELON TRE ON (TRE.ID=VPJM.TRESELON_ID)
            LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON (TP.ID=VPPM.TMPEGAWAI_ID) LEFT JOIN TR_GOLONGAN TRG ON (VPPM.TRGOLONGAN_ID=TRG.ID)
            WHERE VPJM.TRESELON_ID <> '17' $where
            UNION
            SELECT VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5, VPJM.TRESELON_ID, NULL AS NMUNIT, TP.GELAR_DEPAN, 
            TP.NAMA, TP.GELAR_BLKG, TRG.GOLONGAN, TRG.PANGKAT, TRG.TRSTATUSKEPEGAWAIAN_ID, LTRIM(TRE.ESELON,'Eselon ') AS ESELONTEXT, VPJM.TRJABATAN_ID, VPJM.N_JABATAN, TP.NIPNEW, TP.NIP,
            TO_CHAR(VPPM.TMT_GOL, 'DD/MM/YYYY') AS TMT_GOL,TO_CHAR(VPJM.TMT_JABATAN, 'DD/MM/YYYY') AS TMT_JABATAN, NULL AS TKTESELON, TRG.URUTAN, NULL AS NUMBERSATU,
            ROW_NUMBER() OVER(ORDER BY VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5, TRG.URUTAN DESC, VPPM.TMT_GOL ASC, TRE.ID) AS NUMBERDUA,
            ROW_NUMBER() OVER(PARTITION BY VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5 ORDER BY VPJM.TRLOKASI_ID, VPJM.KDU1, VPJM.KDU2, VPJM.KDU3, VPJM.KDU4, VPJM.KDU5, TRG.URUTAN DESC, VPPM.TMT_GOL ASC, TRE.ID) AS NUMBERTIGA
            FROM TM_PEGAWAI TP 
            LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (TP.ID=VPJM.TMPEGAWAI_ID) LEFT JOIN TR_JABATAN TRJ ON (TRJ.ID=VPJM.TRJABATAN_ID) LEFT JOIN TR_ESELON TRE ON (TRE.ID=VPJM.TRESELON_ID)
            LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON (TP.ID=VPPM.TMPEGAWAI_ID) LEFT JOIN TR_GOLONGAN TRG ON (VPPM.TRGOLONGAN_ID=TRG.ID) WHERE VPJM.TRESELON_ID <> '17' $where
        )
        SELECT TRLOKASI_ID, KDU1, KDU2, KDU3, KDU4, KDU5, TRESELON_ID, NMUNIT, GELAR_DEPAN, NAMA, GELAR_BLKG, GOLONGAN, PANGKAT, TRSTATUSKEPEGAWAIAN_ID,
        CASE WHEN (TRESELON_ID IN ('01','02','03','04','05','06','07','08','09','10')) THEN ESELONTEXT ELSE '' END AS TEXTESELON,
        CASE WHEN TRJABATAN_ID IN ('0103', '0104') THEN N_JABATAN ELSE F_GET_JABATAN_JABUNITKERJAESEL(TRJABATAN_ID,TRLOKASI_ID, KDU1, KDU2, KDU3, KDU4, KDU5, TRESELON_ID) END AS JABATAN,NIPNEW,
        TMT_GOL, TMT_JABATAN, TKTESELON, URUTANGOL, NUMBERSATU, NUMBERDUA, NUMBERTIGA
        FROM LAPORAN_DAFTAR_NOMINATIF ORDER BY TRLOKASI_ID, KDU1, KDU2, KDU3, KDU4, KDU5, NUMBERSATU, NUMBERTIGA, NUMBERDUA, TRESELON_ID, URUTANGOL DESC";
//        echo $sql;
        $query = $this->db->query($sql);

        return $query->result_array();
    }

}
