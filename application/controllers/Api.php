<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    public function pegawai_unitkerja_get() {
        $lok = $this->get('lok');
        $kdu1 = $this->get('kdu1');
        $kdu2 = $this->get('kdu2');
        $kdu3 = $this->get('kdu3');
        $kdu4 = $this->get('kdu4');
        $kdu5 = $this->get('kdu5');
        $tkt_eselon = $this->get('tkt_eselon');
        $kel_fungsional = $this->get('kel_fungsional');

        $where = "";
        if (!empty($lok)) {
            $where .= " and VPJM.TRLOKASI_ID = '" . $lok . "' ";
        }
        if (!empty($kdu1)) {
            $where .= " and VPJM.KDU1 = '" . $kdu1 . "' ";
        }
        if (!empty($kdu2)) {
            $where .= " and VPJM.KDU2 = '" . $kdu2 . "' ";
        }
        if (!empty($kdu3)) {
            $where .= " and VPJM.KDU3 = '" . $kdu3 . "' ";
        }
        if (!empty($kdu4)) {
            $where .= " and VPJM.KDU4 = '" . $kdu4 . "' ";
        }
        if (!empty($kdu5)) {
            $where .= " and VPJM.KDU5 = '" . $kdu5 . "' ";
        }
        if (!empty($tkt_eselon)) {
            $where .= " and TSO.TKTESELON = '" . $tkt_eselon . "' ";
        }
        if (!empty($kel_fungsional)) {
            $where .= " and TRJ.TRKELOMPOKFUNGSIONAL_ID = '" . $kel_fungsional . "' ";
        }

        $query = "SELECT TMP.NIPNEW AS \"btrim\", GELAR_DEPAN AS \"gelar_depan\",TMP.NAMA AS \"nama\",TMP.GELAR_BLKG AS \"gelar_blkg\",
        (CASE WHEN TMP.SEX = 'L' THEN 'Laki-laki' WHEN TMP.SEX = 'P' THEN 'Perempuan' else '' end) as \"jk\", TRSP.NAMA AS \"stskawin\",
        TRTP.TINGKAT_PENDIDIKAN as \"tktpndidikan\", MPPV.NAMA_LBGPDK as \"lbgpdk\",
        case when TMP.TRAGAMA_ID = '1' then 'Islam' when TMP.TRAGAMA_ID = '2' then 'Kristen' when TMP.TRAGAMA_ID = '3' then 'Katolik' when TMP.TRAGAMA_ID = '4' then 'Hindu' when TMP.TRAGAMA_ID = '5' then 'Budha' else '' end as \"agama\",
        TRG.PANGKAT as \"pangkat\", TRG.GOLONGAN as \"golongan\", TO_CHAR(TGLLAHIR,'DD/MM/YYYY') as \"tgllahir\",
        VPJM.N_JABATAN as \"n_jabatan\", TO_CHAR(VPJM.TMT_JABATAN,'DD/MM/YYYY') as \"tmtjab\"
        FROM V_PEGAWAI_JABATAN_MUTAKHIR VPJM JOIN TM_PEGAWAI TMP ON (VPJM.TMPEGAWAI_ID=TMP.ID) 
        JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON VPPM.TMPEGAWAI_ID=TMP.ID 
        LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=VPPM.TRGOLONGAN_ID)
        LEFT JOIN TR_STATUS_PERNIKAHAN TRSP ON TRSP.ID=TMP.TRSTATUSPERNIKAHAN_ID 
        LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON (MPPV.TMPEGAWAI_ID=TMP.ID) 
        LEFT JOIN TR_TINGKAT_PENDIDIKAN TRTP ON (TRTP.ID=MPPV.TRTINGKATPENDIDIKAN_ID) 
        LEFT JOIN TR_AGAMA TRA ON (TRA.ID=TMP.TRAGAMA_ID) LEFT JOIN TR_STRUKTUR_ORGANISASI TSO ON (VPJM.TRLOKASI_ID=TSO.TRLOKASI_ID AND VPJM.KDU1=TSO.KDU1 AND 
        VPJM.KDU2=TSO.KDU2 AND VPJM.KDU3=TSO.KDU3 AND VPJM.KDU4=TSO.KDU4 AND VPJM.KDU5=TSO.KDU5) LEFT JOIN TR_JABATAN TRJ ON (TRJ.ID=VPJM.TRJABATAN_ID)  WHERE 1=1 AND VPJM.TRJABATAN_ID NOT LIKE '09%' $where 
        ORDER BY VPJM.TRLOKASI_ID,VPJM.TRESELON_ID,VPJM.KDU1,VPJM.KDU2,VPJM.KDU3,VPJM.KDU4,VPJM.KDU5 ";
        $result = $this->db->query($query)->result_array();

        $this->response($result);
    }
    
    public function pegawai_cuti_get() {
//        $lok = $this->get('lok');
//        $kdu1 = $this->get('kdu1');
//        $kdu2 = $this->get('kdu2');
//        $kdu3 = $this->get('kdu3');
//        $kdu4 = $this->get('kdu4');
//        $kdu5 = $this->get('kdu5');
//        $tkt_eselon = $this->get('tkt_eselon');
//        $kel_fungsional = $this->get('kel_fungsional');
//
//        $where = "";
//        if (!empty($lok)) {
//            $where .= " and VPJM.TRLOKASI_ID = '" . $lok . "' ";
//        }
//        if (!empty($kdu1)) {
//            $where .= " and VPJM.KDU1 = '" . $kdu1 . "' ";
//        }
//        if (!empty($kdu2)) {
//            $where .= " and VPJM.KDU2 = '" . $kdu2 . "' ";
//        }
//        if (!empty($kdu3)) {
//            $where .= " and VPJM.KDU3 = '" . $kdu3 . "' ";
//        }
//        if (!empty($kdu4)) {
//            $where .= " and VPJM.KDU4 = '" . $kdu4 . "' ";
//        }
//        if (!empty($kdu5)) {
//            $where .= " and VPJM.KDU5 = '" . $kdu5 . "' ";
//        }
//        if (!empty($tkt_eselon)) {
//            $where .= " and TSO.TKTESELON = '" . $tkt_eselon . "' ";
//        }
//        if (!empty($kel_fungsional)) {
//            $where .= " and TRJ.TRKELOMPOKFUNGSIONAL_ID = '" . $kel_fungsional . "' ";
//        }

        $query = "SELECT TMP.NIPNEW as \"nipnew\", GELAR_DEPAN AS \"gelar_depan\",TMP.NAMA AS \"nama\",TMP.GELAR_BLKG AS \"gelar_blkg\",
        TC.NAMA_CUTI as \"nama_cuti\", TO_CHAR(TPC.TGL_PENGAJUAN,'DD/MM/YYYY') as \"tgl_pengajuan\",
        TO_CHAR(TPC.TGL_MULAI,'DD/MM/YYYY') as \"tgl_awal_cuti\", TO_CHAR(TPC.TGL_AKHIR,'DD/MM/YYYY') as \"tgl_akhir_cuti\"
        FROM TH_PEGAWAI_CUTI TPC 
        LEFT JOIN TR_CUTI TC ON TC.ID=TPC.TRCUTI_ID 
        JOIN TM_PEGAWAI TMP ON (TPC.TMPEGAWAI_ID=TMP.ID) 
        ORDER BY TPC.TGL_PENGAJUAN DESC";
        $result = $this->db->query($query)->result_array();

        $this->response($result);
    }
    
    public function pegawai_cuti_approve_get() {
        $query = "SELECT TMP.NIPNEW as \"nipnew\", GELAR_DEPAN AS \"gelar_depan\",TMP.NAMA AS \"nama\",TMP.GELAR_BLKG AS \"gelar_blkg\",
        TC.NAMA_CUTI as \"nama_cuti\", TO_CHAR(TPC.TGL_PENGAJUAN,'DD/MM/YYYY') as \"tgl_pengajuan\", 
        TO_CHAR(TPC.TGL_PERSETUJUAN,'DD/MM/YYYY') as \"tgl_persetujuan\", SK_PERSETUJUAN as \"sk_persetujuan\",
        TO_CHAR(TPC.TGL_MULAI,'DD/MM/YYYY') as \"tgl_awal_cuti\", TO_CHAR(TPC.TGL_AKHIR,'DD/MM/YYYY') as \"tgl_akhir_cuti\"
        FROM TH_PEGAWAI_CUTI TPC 
        LEFT JOIN TR_CUTI TC ON TC.ID=TPC.TRCUTI_ID 
        JOIN TM_PEGAWAI TMP ON (TPC.TMPEGAWAI_ID=TMP.ID) WHERE TGL_PERSETUJUAN IS NOT NULL AND SK_PERSETUJUAN IS NOT NULL
        ORDER BY TPC.TGL_PENGAJUAN DESC";
        $result = $this->db->query($query)->result_array();

        $this->response($result);
    }
    
    public function cuti_pegawai_get() {
        $nip = $this->get('nip');
        $query = "SELECT TMP.NIPNEW as \"nipnew\", GELAR_DEPAN AS \"gelar_depan\",TMP.NAMA AS \"nama\",TMP.GELAR_BLKG AS \"gelar_blkg\",
        TC.NAMA_CUTI as \"nama_cuti\", TO_CHAR(TPC.TGL_PENGAJUAN,'DD/MM/YYYY') as \"tgl_pengajuan\",
        TO_CHAR(TPC.TGL_PERSETUJUAN,'DD/MM/YYYY') as \"tgl_persetujuan\", SK_PERSETUJUAN as \"sk_persetujuan\",
        TO_CHAR(TPC.TGL_MULAI,'DD/MM/YYYY') as \"tgl_awal_cuti\", TO_CHAR(TPC.TGL_AKHIR,'DD/MM/YYYY') as \"tgl_akhir_cuti\"
        FROM TH_PEGAWAI_CUTI TPC 
        LEFT JOIN TR_CUTI TC ON TC.ID=TPC.TRCUTI_ID 
        JOIN TM_PEGAWAI TMP ON (TPC.TMPEGAWAI_ID=TMP.ID) WHERE TMP.NIPNEW = '$nip' 
        ORDER BY TPC.TGL_PENGAJUAN DESC";
        $result = $this->db->query($query)->result_array();

        $this->response($result);
    }

    // referensi
    function strukur_get() {
        $lok = $this->get('lok');
        $kdu1 = $this->get('kdu1');
        $kdu2 = $this->get('kdu2');
        $kdu3 = $this->get('kdu3');
        $kdu4 = $this->get('kdu4');
        $kdu5 = $this->get('kdu5');
        $where = "";
        if (!empty($lok)) {
            $where .= " and TRLOKASI_ID = '" . $lok . "' ";
        }
        if (!empty($kdu1)) {
            $where .= " and KDU1 = '" . $kdu1 . "' ";
        }
        if (!empty($kdu2)) {
            $where .= " and KDU2 = '" . $kdu2 . "' ";
        }
        if (!empty($kdu3)) {
            $where .= " and KDU3 = '" . $kdu3 . "' ";
        }
        if (!empty($kdu4)) {
            $where .= " and KDU4 = '" . $kdu4 . "' ";
        }
        if (!empty($kdu5)) {
            $where .= " and KDU5 = '" . $kdu5 . "' ";
        }
        $query = "SELECT TSO.ID as \"id\",NMUNIT as \"nmunit\",TRLOKASI_ID as \"lok\",KDU1 as \"kdu1\",KDU2 as \"kdu2\",KDU3 as \"kdu3\",KDU4 as \"kdu4\",KDU5 as \"kdu5\",
        TSE.ID as \"kode_eselon\",TSE.ESELON as \"nama_eselon\",TRJ.ID as \"kode_jabatan\",TRJ.JABATAN as \"nama_jabatan\",TSO.TKTESELON as \"tktesel\" FROM TR_STRUKTUR_ORGANISASI TSO LEFT JOIN TR_ESELON TSE ON (TSO.TRESELON_ID=TSE.ID)
        LEFT JOIN TR_JABATAN TRJ on (TRJ.ID=TSO.TRJABATAN_ID) where 1=1 $where order by TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5 ";
        $result = $this->db->query($query)->result_array();

        $this->response($result);
    }

    function pegawai_get() {
        $nip = $this->get('nip');
        if ($nip) {
            $host = base_url();
            $query1 = "select trim(TMP.NIP) as \"nip\",trim(TMP.NIPNEW) as \"nipnew\",ltrim(rtrim(TMP.GELAR_DEPAN)) as \"gelar_depan\",
			ltrim(rtrim(TMP.NAMA)) as \"nama\",ltrim(rtrim(TMP.GELAR_BLKG)) as \"gelar_blkg\",
			case when TMP.SEX = 'L' then 'Laki-laki' when TMP.SEX = 'P' THEN 'Perempuan' else '' end as \"jk\",
			case when TMP.TRSTATUSPERNIKAHAN_ID = 'B' then 'Belum Kawin' when TMP.TRSTATUSPERNIKAHAN_ID = 'K' then 'Kawin' when TMP.TRSTATUSPERNIKAHAN_ID = 'D' then 'Duda' when TMP.TRSTATUSPERNIKAHAN_ID = 'J' then 'Janda' else '' end as \"stskawin\",
			TRTP.TINGKAT_PENDIDIKAN as \"tktpndidikan\", MPPV.NAMA_LBGPDK,
			case when TMP.TRAGAMA_ID = '1' then 'Islam' when TMP.TRAGAMA_ID = '2' then 'Kristen' when TMP.TRAGAMA_ID = '3' then 'Katolik' when TMP.TRAGAMA_ID = '4' then 'Hindu' when TMP.TRAGAMA_ID = '5' then 'Budha' else '' end as \"agama\",
			TRG.PANGKAT AS \"pangkat\", TRG.GOLONGAN AS \"golongan\",to_char(TMP.TGLLAHIR,'DD-MM-YYYY') AS \"tgllahir\",VPJM.N_JABATAN as \"n_jabatan\",VPJM.N_JABATAN AS \"tmtjab\",
			'$host'||'_uploads/photo_pegawai/thumbs/'||FOTO as \"photo\",TPTLAHIR as \"tptlahir\",TRSK.STATUS_KEPEGAWAIAN as \"statpegawai\",
			TINGGI_BADAN as \"tinggi_badan\",BERAT_BADAN as \"berat_badan\",RAMBUT as \"rambut\",BENTUK_MUKA as \"bentuk_muka\",WARNA_KULIT as \"warna_kulit\",CIRI_KHAS as \"ciri_khas\",HOBI as \"hobi\"
			FROM TM_PEGAWAI TMP LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (VPJM.TMPEGAWAI_ID=TMP.ID) 
			LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON VPPM.TMPEGAWAI_ID=TMP.ID 
			LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=VPPM.TRGOLONGAN_ID)
			LEFT JOIN TR_STATUS_PERNIKAHAN TRSP ON TRSP.ID=TMP.TRSTATUSPERNIKAHAN_ID 
			LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON (MPPV.TMPEGAWAI_ID=TMP.ID) 
			LEFT JOIN TR_TINGKAT_PENDIDIKAN TRTP ON (TRTP.ID=MPPV.TRTINGKATPENDIDIKAN_ID) 
			LEFT JOIN TR_AGAMA TRA ON (TRA.ID=TMP.TRAGAMA_ID) LEFT JOIN TR_STATUS_KEPEGAWAIAN TRSK ON (TRSK.ID=TMP.TRSTATUSKEPEGAWAIAN_ID)
			where 1=1 AND TMP.NIP = '$nip' or TMP.NIPNEW = '$nip' ";
            $datapegawai = $this->db->query($query1)->row_array();

            $query2 = "SELECT tdt.KETERANGAN as \"keterangan\",skdt.NAMA_KELOMPOK as \"kelompok\",trdt.NAMA_DIKLAT as \"nama_diklat\" FROM TH_PEGAWAI_DIKLAT_TEKNIS tdt 
			LEFT JOIN TM_PEGAWAI mp ON (tdt.TMPEGAWAI_ID=mp.ID) LEFT JOIN TR_KELOMPOK_DKLT_TEKNIS skdt ON (tdt.TRKELOMPOKDKLTTEKNIS_ID=skdt.ID) 
			LEFT JOIN TR_DIKLAT_TEKNIS trdt on (tdt.TRDIKLATTEKNIS_ID=trdt.ID) WHERE mp.NIP = '$nip' OR mp.NIPNEW = '$nip' ";
            $listdiklatteknis = $this->db->query($query2)->result_array();

            $join = array_merge($datapegawai, array('diklat_teknis' => $listdiklatteknis));
        } else {
            $join = array();
        }

        $this->response($join);
    }

    function pegawai_diklat_teknis_get() {
        $query = 'SELECT trim(mp.NIP) as "nip",trim(mp.NIPNEW) as "nipnew",ltrim(rtrim(mp.GELAR_DEPAN)) as "gelar_depan",
        ltrim(rtrim(mp.NAMA)) as "nama",ltrim(rtrim(mp.GELAR_BLKG)) as "gelar_blkg",
        tdt.KETERANGAN as "keterangan",skdt.NAMA_KELOMPOK as "kelompok",trdt.NAMA_DIKLAT as "nama_diklat" FROM TH_PEGAWAI_DIKLAT_TEKNIS tdt 
        LEFT JOIN TM_PEGAWAI mp ON (tdt.TMPEGAWAI_ID=mp.ID) LEFT JOIN TR_KELOMPOK_DKLT_TEKNIS skdt ON (tdt.TRKELOMPOKDKLTTEKNIS_ID=skdt.ID) 
        LEFT JOIN TR_DIKLAT_TEKNIS trdt on (tdt.TRDIKLATTEKNIS_ID=trdt.ID)';
        $result = $this->db->query($query)->result_array();
        $this->response($result);
    }

    function referensi_kelompok_diklat_teknis_get() {
        $query = "SELECT ID as \"kode\",NAMA_KELOMPOK as \"kelompok\" FROM TR_KELOMPOK_DKLT_TEKNIS ORDER BY ID ASC";
        $result = $this->db->query($query)->result_array();
        $this->response($result);
    }

    function referensi_diklat_teknis_get() {
        $query = "SELECT TRKELOMPOKDKLTTEKNIS_ID as \"kode_jenis\",NAMA_DIKLAT as \"nama_diklat\" FROM TR_DIKLAT_TEKNIS ORDER BY TRKELOMPOKDKLTTEKNIS_ID ASC";
        $result = $this->db->query($query)->result_array();
        $this->response($result);
    }

    private function pegawai_id($nip) {
        $query = "SELECT ID FROM TM_PEGAWAI TMP WHERE NIP='$nip' OR NIPNEW='$nip'";
        if ($this->db->query($query)->num_rows() > 0) {
            return $this->db->query($query)->row_array()['ID'];
        } else {
            return null;
        }
    }

    function pasangan_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "SELECT CASE WHEN tsi.JENIS_PASANGAN = '1' THEN 'Suami' WHEN tsi.JENIS_PASANGAN = '2' THEN 'Isteri' else '' end \"jenis\",PASANGAN_KE as \"pasangan_ke\",tsi.NAMA \"nama\",trp.PEKERJAAN \"pekerjaan\",TEMPAT_LHR \"tempat_lhr\",to_char(TGL_LAHIR, 'dd/mm/yyyy') as \"tgl_lahir\" FROM TH_PEGAWAI_PASANGAN tsi  
			left join TR_PEKERJAAN trp on (trp.ID=tsi.TRPEKERJAAN_ID) WHERE tsi.TMPEGAWAI_ID = $id
			ORDER BY PASANGAN_KE ASC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function anak_get() {
        $this->load->model(array('apikepegawaian_model'));

        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id)
            $query = $this->apikepegawaian_model->get_data_anak($id);
        else
            $query = [];

        $this->response($query);
    }

    function ortu_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "SELECT sis.NAMA as \"statusortu\",to_char(TGL_LAHIR, 'DD/MM/YYYY') as \"tggl_lahir\",tsi.NAMA \"nama\",
			PEKERJAAN \"kerja\" FROM TH_PEGAWAI_ORTU tsi LEFT JOIN TR_STATUS_ORANG_TUA sis on (tsi.TMSTATUSORTU_ID=sis.ID) 
			 WHERE tsi.TMPEGAWAI_ID = $id ORDER BY TMSTATUSORTU_ID ASC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function saudara_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "SELECT (case when SEX = 'L' then 'Laki-laki' when SEX='P' then 'Perempuan' else '' end) as \"jk\",to_char(TGL_LAHIR, 'DD/MM/YYYY') as \"tggl_lahir\",tsi.NAMA \"nama\",
			PEKERJAAN \"pekerjaan\" FROM TH_PEGAWAI_SAUDARA tsi 
			 WHERE tsi.TMPEGAWAI_ID = $id ORDER BY TGL_LAHIR ASC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function cpns_get() {
        $nip = $this->get('nip');
        if ($nip) {
            $host = base_url();
            $query = "SELECT TSK.STATUS_KEPEGAWAIAN as \"statuskepegawai\", trim(TMP.NIP) as \"nip\",trim(TMP.NIPNEW) as \"nipnew\",ltrim(rtrim(TMP.GELAR_DEPAN)) as \"gelar_depan\",
			ltrim(rtrim(TMP.NAMA)) as \"nama\",ltrim(rtrim(TMP.GELAR_BLKG)) as \"gelar_blkg\",
			(case when TMP.TRSTATUSKEPEGAWAIAN_ID = '1' then PANGKAT|| '('||GOLONGAN||')' else PANGKAT end) as \"golpangkat\",
			TRTP.TINGKAT_PENDIDIKAN as \"tktpndidikan\", to_char(TMT_CPNS, 'DD/MM/YYYY') as \"tmt_cpns\", to_char(TMT_KERJA, 'DD/MM/YYYY') as \"tmt_kerja\",
			to_char(TMP.TGLLAHIR, 'DD/MM/YYYY') as \"tgl_lahir\", TRE.ESELON as \"eselon\",
			TRJ.JABATAN \"jabatan\", NAMA_JABATAN_NOKODEREF as \"nama_jabatan\", FIKTIF_BULAN \"masa_kerja_f_bulan\", FIKTIF_TAHUN \"masa_kerja_f_tahun\",
			HONORER_BULAN \"masa_kerja_h_bulan\", HONORER_TAHUN \"masa_kerja_h_tahun\", SWASTA_BULAN \"masa_kerja_s_bulan\", SWASTA_TAHUN \"masa_kerja_s_tahun\",
			THPP.NO_SK \"no_sk\", THPP.NO_SK \"no_sk\", THPP.NO_SK \"no_sk\",
			to_char(TGL_SK, 'DD/MM/YYYY') as \"tgl_sk\", PEJABAT_SK \"pejabat_sk\"
			FROM TM_PEGAWAI TMP LEFT JOIN TH_PEGAWAI_CPNS TPC ON (TPC.TMPEGAWAI_ID=TMP.ID) LEFT JOIN TR_STATUS_KEPEGAWAIAN TSK ON (TSK.ID=TMP.TRSTATUSKEPEGAWAIAN_ID) 
			LEFT JOIN TH_PEGAWAI_PANGKAT THPP ON (THPP.TMPEGAWAI_ID=TMP.ID AND THPP.TRJENISKENAIKANPANGKAT_ID=5) LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=THPP.TRGOLONGAN_ID) 
			LEFT JOIN TR_TINGKAT_PENDIDIKAN TRTP ON (TRTP.ID=TPC.TRTKTPENDIDIKAN_ID) LEFT JOIN TR_ESELON TRE ON (TRE.ID=TPC.TRESELON_ID) 
			LEFT JOIN TR_JABATAN TRJ ON (TRJ.ID=TPC.TRJABATAN_ID)
			WHERE 1=1 AND TMP.NIP = '$nip' or TMP.NIPNEW = '$nip' ";

            $result = $this->db->query($query)->row_array();
        } else
            $result = [];

        $this->response($result);
    }

    function pns_get() {
        $nip = $this->get('nip');
        if ($nip) {
            $host = base_url();
            $query = "SELECT TSK.STATUS_KEPEGAWAIAN as \"statuskepegawai\", trim(TMP.NIP) as \"nip\",trim(TMP.NIPNEW) as \"nipnew\",ltrim(rtrim(TMP.GELAR_DEPAN)) as \"gelar_depan\",
			ltrim(rtrim(TMP.NAMA)) as \"nama\",ltrim(rtrim(TMP.GELAR_BLKG)) as \"gelar_blkg\",
			(case when TMP.TRSTATUSKEPEGAWAIAN_ID = '1' then PANGKAT|| '('||GOLONGAN||')' else PANGKAT end) as \"golpangkat\",
			TRTP.TINGKAT_PENDIDIKAN as \"tktpndidikan\", to_char(TMT_CPNS, 'DD/MM/YYYY') as \"tmt_cpns\", to_char(TMT_KERJA, 'DD/MM/YYYY') as \"tmt_kerja\",
			to_char(TMP.TGLLAHIR, 'DD/MM/YYYY') as \"tgl_lahir\", TRE.ESELON as \"eselon\",
			TRJ.JABATAN \"jabatan\", NAMA_JABATAN_NOKODEREF as \"nama_jabatan\", FIKTIF_BULAN \"masa_kerja_f_bulan\", FIKTIF_TAHUN \"masa_kerja_f_tahun\",
			HONORER_BULAN \"masa_kerja_h_bulan\", HONORER_TAHUN \"masa_kerja_h_tahun\", SWASTA_BULAN \"masa_kerja_s_bulan\", SWASTA_TAHUN \"masa_kerja_s_tahun\",
			THPP.NO_SK \"no_sk\", THPP.NO_SK \"no_sk\", THPP.NO_SK \"no_sk\",
			to_char(TGL_SK, 'DD/MM/YYYY') as \"tgl_sk\", PEJABAT_SK \"pejabat_sk\"
			FROM TM_PEGAWAI TMP LEFT JOIN TH_PEGAWAI_CPNS TPC ON (TPC.TMPEGAWAI_ID=TMP.ID) LEFT JOIN TR_STATUS_KEPEGAWAIAN TSK ON (TSK.ID=TMP.TRSTATUSKEPEGAWAIAN_ID) 
			LEFT JOIN TH_PEGAWAI_PANGKAT THPP ON (THPP.TMPEGAWAI_ID=TMP.ID AND THPP.TRJENISKENAIKANPANGKAT_ID=5) LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=THPP.TRGOLONGAN_ID) 
			LEFT JOIN TR_TINGKAT_PENDIDIKAN TRTP ON (TRTP.ID=TPC.TRTKTPENDIDIKAN_ID) LEFT JOIN TR_ESELON TRE ON (TRE.ID=TPC.TRESELON_ID) 
			LEFT JOIN TR_JABATAN TRJ ON (TRJ.ID=TPC.TRJABATAN_ID)
			WHERE 1=1 AND TMP.NIP = '$nip' or TMP.NIPNEW = '$nip' ";

            $result = $this->db->query($query)->row_array();
        } else
            $result = array();

        $this->response($result);
    }

    function pangkat_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "SELECT (case when TRSTATUSKEPEGAWAIAN_ID = '1' then PANGKAT|| '('||GOLONGAN||')' else PANGKAT end) as \"golpangkat\",TMT_GOL2 \"tmt_gol2\",JENIS_KENAIKAN_PANGKAT \"jenis\",
			THN_GOL||' Tahun '||BLN_GOL||' Bulan' as \"mkgolongan\",NO_SK \"no_sk\",TGL_SK2 \"tgl_sk2\",DASAR_PANGKAT \"dasar_pangkat\",PEJABAT_SK \"pejabat_sk\" FROM MK_GOLONGAN_V tsi
			 WHERE tsi.TMPEGAWAI_ID = $id ORDER BY TMT_GOL DESC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function jabatan_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "SELECT N_JABATAN \"n_jabatan\",to_char(TMT_JABATAN, 'dd/mm/yyyy') as \"tmt_jabatan\",tre.ESELON \"eselon\",NO_SK \"no_sk\",PEJABAT_SK \"pejabat_sk\",KETERANGAN \"keterangan\",KPPN \"kppn\",LOK_TASPEN \"lok_taspen\",
			to_char(tgl_sk, 'dd/mm/yyyy') as tgl_sk,to_char(tgl_lantik, 'dd/mm/yyyy') as tgl_lantik FROM TH_PEGAWAI_JABATAN tsi 
			left join TR_ESELON tre on (tre.ID=tsi.TRESELON_ID)
			 WHERE tsi.TMPEGAWAI_ID = '$id' ORDER BY TMT_JABATAN DESC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function pendidikan_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "select a.NO_STTB \"no_sttb\",a.THN_LULUS \"thn_lulus\",e.NAMA_NEGARA as \"negara\", b.NAMA_FAKULTAS as \"fakultas\", c.NAMA_JURUSAN as \"jurusan\", d.TINGKAT_PENDIDIKAN as \"pendidikan\"
			from TH_PEGAWAI_PENDIDIKAN a left join TR_FAKULTAS b on a.TRFAKULTAS_ID=b.ID left join TR_JURUSAN c on a.TRJURUSAN_ID=c.ID
			left join TR_TINGKAT_PENDIDIKAN d on a.TRTINGKATPENDIDIKAN_ID=d.ID left join TR_NEGARA e on a.TRNEGARA_ID=e.ID 
			WHERE a.TMPEGAWAI_ID='$id' ORDER BY a.THN_LULUS DESC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function gaji_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "select a.NO_SK \"no_sk\",to_char(a.TMT_KGB, 'DD/MM/YYYY') \"tmt_kgb\",to_char(a.TGL_SK, 'DD/MM/YYYY') \"tgl_sk\",
			(case when TRSTATUSKEPEGAWAIAN_ID = '1' then PANGKAT|| '('||GOLONGAN||')' else PANGKAT end) as \"golpangkat\", a.GAPOK as \"gapok\"
			from TH_PEGAWAI_GAJI a left join TR_GOLONGAN b on a.TRGOLONGAN_ID=b.ID left join TR_GAJI_POKOK c on a.TRGAJIPOKOK_ID=c.ID
			WHERE a.TMPEGAWAI_ID='$id' ORDER BY a.TMT_KGB DESC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function belajar_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "select b.STATUS_BELAJAR \"kelompok\",e.TINGKAT_PENDIDIKAN \"tkt_pendidikan\",a.NAMA_LBGPDK \"nama_lembaga\",
			c.NAMA_FAKULTAS as \"nama_fakultas\", d.NAMA_JURUSAN as \"jurusan\"
			from TH_PEGAWAI_BELAJAR a left join TR_STATUS_BELAJAR b on a.TRSTATUSBELAJAR_ID=b.ID left join TR_FAKULTAS c on a.TRFAKULTAS_ID=c.ID 
			left join TR_JURUSAN d on a.TRJURUSAN_ID=d.ID left join TR_TINGKAT_PENDIDIKAN e on a.TRTINGKATPENDIDIKAN_ID=e.ID 
			WHERE a.TMPEGAWAI_ID='$id' ORDER BY a.START_SK DESC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function seminar_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "select b.JENIS_KEGIATAN \"jenis_kegiatan\",a.NAMA_KEGIATAN \"nama_kegiatan\",c.NAMA_NEGARA \"nama_negara\",
			TEMPAT as \"tempat\", PENYELENGGARA as \"penyelenggara\", d.JENIS_PEMBIAYAAN as \"jenis_pembiayaan\",
			BULAN ||' - '||TAHUN as \"waktu_kegiatan\"
			from TH_PEGAWAI_SEMINAR a left join TR_JENIS_KEGIATAN b on a.TRJENISKEGIATAN_ID=b.ID left join TR_NEGARA c on a.TRNEGARA_ID=c.ID 
			left join TR_JENIS_PEMBIAYAAN d on a.TRJENISPEMBIAYAAN_ID=d.ID 
			WHERE a.TMPEGAWAI_ID='$id' ORDER BY BULAN DESC, TAHUN DESC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function organisasi_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "select b.JENIS_ORGANISASI \"jenis_organisasi\",a.NAMA_ORG \"nama_organisasi\",a.JABATAN_ORG \"jabatan_organisasi\",
			TEMPAT_ORG as \"tempat_organisasi\", THN_TERDAFTAR as \"thn_terdaftar\", THN_SELESAI as \"thn_selesai\"
			from TH_PEGAWAI_ORGANISASI a left join TR_JENIS_ORGANISASI b on a.TRJENISORGANISASI_ID=b.ID 
			WHERE a.TMPEGAWAI_ID='$id' ORDER BY THN_TERDAFTAR DESC, THN_SELESAI DESC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function luarnegeri_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "select b.NAMA_NEGARA \"nama_negara\",a.SPONSOR \"sponsor\",to_char(TGL_KJGN, 'dd/mm/yyyy') as tgl_kunjungan,
			TUJUAN as \"tujuan\", c.JENIS_PEMBIAYAAN as \"jenis_pembiayaan\",TUJUAN \"tujuan\"
			from TH_PEGAWAI_KUNJUNGAN_LN a left join TR_NEGARA b on a.TRNEGARA_ID=b.ID left join TR_JENIS_PEMBIAYAAN c on a.TRJENISPEMBIAYAAN_ID=c.ID 
			WHERE a.TMPEGAWAI_ID='$id' ORDER BY TGL_KJGN DESC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function penghargaan_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $result = "select b.JENIS_TANDA_JASA \"jenis_tanda_jasa\",c.TANDA_JASA \"tanda_jasa\",THN_PRLHN as \"tahun_perolehan\",
			d.NAMA_NEGARA \"nama_negara\", INSTANSI \"instansi\"
			from TH_PEGAWAI_PENGHARGAAN a left join TR_JENIS_TANDA_JASA b on a.TRJENISTANDAJASA_ID=b.ID left join TR_TANDA_JASA c on a.TRTANDAJASA_ID=c.ID 
			left join TR_NEGARA d on a.TRNEGARA_ID=d.ID 
			WHERE a.TMPEGAWAI_ID='$id' ORDER BY TGL_PENGHARGAAN DESC";
            $result = $this->db->query($result)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function sanksi_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "select b.TKT_HUKUMAN_DISIPLIN \"tkt_hukuman\",c.JENIS_HUKDIS \"jenis_hukuman\",ALASAN_HKMN as \"alasan_hukuman\",
			to_char(a.TMT_HKMN, 'dd/mm/yyyy') || ' S/D ' || to_char(a.AKHIR_HKMN, 'dd/mm/yyyy') \"periode\"
			from TH_PEGAWAI_SANKSI a left join TR_TKT_HUKUMAN_DISIPLIN b on a.TRTKTHUKUMANDISIPLIN_ID=b.ID left join TR_JENIS_HUKUMAN_DISIPLIN c on a.TRJENISHUKUMANDISIPLIN_ID=c.ID 
			WHERE a.TMPEGAWAI_ID='$id' ORDER BY TMT_HKMN DESC,AKHIR_HKMN DESC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function fungsional_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "select b.JABATAN \"nama_jabatan\",c.STATUS_FUNGSIONAL \"status_fungsional\",ALASAN_STATUS_FUNGSIONAL as \"alasan_status_fungsional\"
			from TH_PEGAWAI_FUNGSIONAL a left join TR_JABATAN b on a.TRJABATAN_ID=b.ID LEFT JOIN TR_STATUS_FUNGSIONAL c on a.TRSTATUSFUNGSIONAL_ID=c.ID 
			LEFT JOIN TR_ALASAN_STATUS_FUNGSIONAL d on a.TRALASANSTATUSFUNGSIONAL_ID=d.ID
			WHERE a.TMPEGAWAI_ID='$id' ORDER BY TMT_JABATAN DESC,TGL_LANTIK DESC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function keterangan_lain_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "select a.KETERANGAN \"keterangan\",a.PEJABAT_SK \"pejabat_sk\",NO_SK as \"no_sk\", to_char(a.TGL_SK, 'dd/mm/yyyy') \"tgl_sk\"
			from TH_PEGAWAI_KETERANGAN_LAIN a 
			WHERE a.TMPEGAWAI_ID='$id' ORDER BY TGL_SK DESC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function diklat_prajabatan_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "SELECT a.NAMA_DIKLAT as \"nama_diklat\",a.JPL \"jpl\",PENYELENGGARA \"penyelenggara\",NO_STTPP \"no_sttpp\",PJBT_STTPP \"pjbt_sttpp\",
			to_char(a.TGL_STTPP,'dd/mm/YYYY') as \"tggl_sttpp\",
			b.NAMA_NEGARA as \"negara\" FROM TH_PEGAWAI_DIKLAT_PRAJABATAN a left join TR_NEGARA b ON a.TRNEGARA_ID=b.ID
			where a.TMPEGAWAI_ID ='$id' ORDER BY a.ID DESC";
            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function diklat_penjenjangan_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "select a.NAMA_DIKLAT \"nama_diklat\",ANGKATAN_DIKLAT \"angkatan_diklat\",THN_DIKLAT \"thn_diklat\",JPL \"jpl\",
			PENYELENGGARA \"penyelenggara\",PERINGKAT \"peringkat\",NO_STTPP \"no_sttpp\",PJBT_STTPP \"pjbt_sttpp\",to_char(a.TGL_STTPP,'dd/mm/YYYY') as \"tgl_sttpp2\",
			b.KUALIFIKASI_KELULUSAN \"kualifikasi\", c.NAMA_JENJANG \"nama\"
			FROM TH_PEGAWAI_DIKLAT_PENJENJANGAN a 
			left join TR_KUALIFIKASI_KELULUSAN b ON a.TRPREDIKATKELULUSAN_ID=b.ID
			left join TR_TINGKAT_DIKLAT_KEPEMIMPINAN c on a.TRTINGKATDIKLATKEPEMIMPINAN_ID=c.ID where TMPEGAWAI_ID ='$id' " .
                    " ORDER BY a.THN_DIKLAT DESC";

            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function diklat_teknis_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        
        $where = "";
        if ($id)
            $where .= " AND a.TMPEGAWAI_ID ='$id' ";
        if ($iddiklat)
            $where .= " AND d.ID ='$iddiklat' ";
        
        if ($id) {
            $query = "select a.KETERANGAN \"keterangan\",a.NAMA_DIKLAT \"nama_diklat\",a.JPL \"jpl\",a.PENYELENGGARA \"penyelenggara\",
			a.NO_STTPP \"no_sttpp\",PJBT_STTPP \"pjbt_sttpp\",to_char(a.TGL_STTPP,'dd/mm/YYYY') as \"tgl_sttpp2\",
			b.NAMA_KELOMPOK \"kelompok\", c.NAMA_NEGARA \"nama\", d.NAMA_DIKLAT as \"nama_diklat2\"
			from TH_PEGAWAI_DIKLAT_TEKNIS a left join TR_KELOMPOK_DKLT_TEKNIS b on a.TRKELOMPOKDKLTTEKNIS_ID=b.ID
			left join TR_NEGARA c on a.TRNEGARA_ID=c.ID
			left join TR_DIKLAT_TEKNIS d on a.TRDIKLATTEKNIS_ID=d.ID
			where 1=1 $where " .
                    " ORDER BY a.ID DESC";

            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function diklat_fungsional_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "select b.JENIS_DIKLAT_FUNGSIONAL \"jenis_diklat_fungsional\",c.PENJENJANGAN_FUNGSIONAL \"tingkat_diklat\",e.NAMA_PENJENJANGAN \"jenjang_diklat\"
			from TH_PEGAWAI_DIKLAT_FUNGSIONAL a left join TR_JENIS_DIKLAT_FUNGSIONAL b on a.TRJENISDIKLATFUNGSIONAL_ID=b.ID
			left join TR_PENJENJANGAN_FUNGSIONAL c on a.TRPENJENJANGANFUNGSIONAL_ID=c.ID
			left join TR_KELOMPOK_FUNGSIONAL d on a.TRKELOMPOKFUNGSIONAL_ID=d.ID
			left join TR_NAMA_PENJENJANGAN e on a.TRNAMAPENJENJANGAN_ID=e.ID
			where a.TMPEGAWAI_ID ='$id' " .
                    " ORDER BY a.ID DESC";

            $result = $this->db->query($query)->result_array();
        } else
            $result = [];

        $this->response($result);
    }

    function diklat_lain_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "SELECT a.NAMA_DIKLAT \"nama_diklat\",JPL \"jpl\",PENYELENGGARA \"penyelenggara\",NO_STTPP \"no_sttpp\",PJBT_STTPP \"pjbt_sttpp\",
			to_char(a.TGL_STTPP,'dd/mm/YYYY') as \"tgl_sttpp2\",
			b.NAMA_NEGARA as \"negara\" FROM TH_PEGAWAI_DIKLAT_LAIN a left join TR_NEGARA b ON a.TRNEGARA_ID=b.ID
			where a.TMPEGAWAI_ID ='$id' " . " ORDER BY a.id DESC";

            $result = $this->db->query($query)->result_array();
        } else
            $result = [];


        $this->response($result);
    }

    function ak_get() {
        $nip = $this->get('nip');
        $id = $this->pegawai_id($nip);
        if ($id) {
            $query = "SELECT a.TAHUN_KREDIT \"tahun\",b.JABATAN \"jabatan\",AK_UTAMA \"ak_utama\",AK_PENUNJANG \"ak_penunjang\",AK_JUMLAH \"ak_jumlah\"
			FROM TH_PEGAWAI_AK a left join TR_JABATAN b ON a.TRJABATAN_ID=b.ID
			where a.TMPEGAWAI_ID ='$id' " . " ORDER BY a.PERIODE_AWAL DESC, a.PERIODE_AKHIR DESC";

            $result = $this->db->query($query)->result_array();
        } else
            $result = [];


        $this->response($result);
    }

    function bsg_get() {
        $query = "SELECT TMP.NIPNEW AS \"btrim\", GELAR_DEPAN AS \"gelar_depan\",TMP.NAMA AS \"nama\",TMP.GELAR_BLKG AS \"gelar_blkg\",
        (CASE WHEN TMP.SEX = 'L' THEN 'Laki-laki' WHEN TMP.SEX = 'P' THEN 'Perempuan' else '' end) as \"jk\", TRSP.NAMA AS \"stskawin\",
        TRTP.TINGKAT_PENDIDIKAN as \"tktpndidikan\", MPPV.NAMA_LBGPDK as \"lbgpdk\",
        case when TMP.TRAGAMA_ID = '1' then 'Islam' when TMP.TRAGAMA_ID = '2' then 'Kristen' when TMP.TRAGAMA_ID = '3' then 'Katolik' when TMP.TRAGAMA_ID = '4' then 'Hindu' when TMP.TRAGAMA_ID = '5' then 'Budha' else '' end as \"agama\",
        TRG.PANGKAT as \"pangkat\", TRG.GOLONGAN as \"golongan\", TO_CHAR(TGLLAHIR,'DD/MM/YYYY') as \"tgllahir\",
        VPJM.N_JABATAN as \"n_jabatan\", TO_CHAR(VPJM.TMT_JABATAN,'DD/MM/YYYY') as \"tmtjab\"
        FROM TH_PEGAWAI_BSG TPB 
        LEFT JOIN TM_PEGAWAI TMP ON (TPB.TMPEGAWAI_ID=TMP.ID) 
        LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (VPJM.TMPEGAWAI_ID=TMP.ID)
        LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON VPPM.TMPEGAWAI_ID=TMP.ID 
        LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=VPPM.TRGOLONGAN_ID)
        LEFT JOIN TR_STATUS_PERNIKAHAN TRSP ON TRSP.ID=TMP.TRSTATUSPERNIKAHAN_ID 
        LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON (MPPV.TMPEGAWAI_ID=TMP.ID) 
        LEFT JOIN TR_TINGKAT_PENDIDIKAN TRTP ON (TRTP.ID=MPPV.TRTINGKATPENDIDIKAN_ID) 
        LEFT JOIN TR_AGAMA TRA ON (TRA.ID=TMP.TRAGAMA_ID) 
		LEFT JOIN TR_STRUKTUR_ORGANISASI TSO ON (VPJM.TRLOKASI_ID=TSO.TRLOKASI_ID AND VPJM.KDU1=TSO.KDU1 AND 
        VPJM.KDU2=TSO.KDU2 AND VPJM.KDU3=TSO.KDU3 AND VPJM.KDU4=TSO.KDU4 AND VPJM.KDU5=TSO.KDU5) 
		LEFT JOIN TR_JABATAN TRJ ON (TRJ.ID=VPJM.TRJABATAN_ID) 
        ORDER BY VPJM.TRLOKASI_ID,VPJM.KDU1,VPJM.KDU2,VPJM.KDU3,VPJM.KDU4,VPJM.KDU5";
        $result = $this->db->query($query)->result_array();

        $this->response($result);
    }

}
