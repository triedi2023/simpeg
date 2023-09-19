<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_drh_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_struktur($lok='2',$kdu1='00',$kdu2='00',$kdu3='000',$kdu4='000',$kdu5='00') {
        $param = $lok.";".$kdu1.";".$kdu2.";".$kdu3.";".$kdu4.";".$kdu5;
        $sql = "SELECT F_GET_UNITKERJA_KODEREF('$param') AS NMSTRUKTUR FROM DUAL";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    
    function get_data_pegawai($nip='2') {
        $sql = "SELECT TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.GOLONGAN,TRG.PANGKAT,TP.*,TO_CHAR(TGLLAHIR,'DD/MM/YYYY') AS TGLLAHIR2,TA.AGAMA,
        TSP.NAMA AS PERNIKAHAN,TRP.NAMA_PROPINSI,TRK.KABUPATEN AS NAMAKABUPATEN FROM TM_PEGAWAI TP 
        LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON (TP.ID=VPPM.TMPEGAWAI_ID) LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=VPPM.TRGOLONGAN_ID) 
        LEFT JOIN TR_AGAMA TA ON (TA.ID=TP.TRAGAMA_ID) LEFT JOIN TR_STATUS_PERNIKAHAN TSP ON (TSP.ID=TP.TRSTATUSPERNIKAHAN_ID) 
        LEFT JOIN TR_PROPINSI TRP ON (TRP.ID=TP.PROPINSI) LEFT JOIN TR_KABUPATEN TRK ON (TRK.ID=TP.KABUPATEN)
        WHERE NIPNEW=? OR NIP=? ";
        $query = $this->db->query($sql,[$nip,$nip]);
        return $query->row_array();
    }
    
    function get_data_pegawai_pendidikan($id=0) {
        $sql = "SELECT TPP.*,TRTP.TINGKAT_PENDIDIKAN,TRU.NAMA_UNIVERSITAS,TRJ.NAMA_JURUSAN,TRF.NAMA_FAKULTAS,TRN.NAMA_NEGARA FROM TH_PEGAWAI_PENDIDIKAN TPP 
        LEFT JOIN TR_TINGKAT_PENDIDIKAN TRTP ON (TRTP.ID=TPP.TRTINGKATPENDIDIKAN_ID) 
        LEFT JOIN TR_UNIVERSITAS TRU ON (TRU.ID=TPP.TRUNIVERSITAS_ID) 
        LEFT JOIN TR_JURUSAN TRJ ON (TRJ.ID=TPP.TRJURUSAN_ID) 
        LEFT JOIN TR_FAKULTAS TRF ON (TRJ.ID=TPP.TRFAKULTAS_ID) 
        LEFT JOIN TR_NEGARA TRN ON (TRN.ID=TPP.TRNEGARA_ID) 
        WHERE TMPEGAWAI_ID=? ORDER BY TRTP.ID ASC, THN_LULUS DESC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_prajabatan($id=0) {
        $sql = "SELECT TPP.*,TRN.NAMA_NEGARA,TO_CHAR(TGL_STTPP,'DD/MM/YYYY') AS TGL_STTPP2 FROM TH_PEGAWAI_DIKLAT_PRAJABATAN TPP 
        LEFT JOIN TR_NEGARA TRN ON (TRN.ID=TPP.TRNEGARA_ID) 
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.ID ASC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_penjenjangan($id=0) {
        $sql = "SELECT TPP.*,TO_CHAR(TGL_STTPP,'DD/MM/YYYY') AS TGL_STTPP2,TRTDK.NAMA_JENJANG FROM TH_PEGAWAI_DIKLAT_PENJENJANGAN TPP 
        LEFT JOIN TR_KUALIFIKASI_KELULUSAN TRKK ON (TRKK.ID=TPP.TRPREDIKATKELULUSAN_ID) 
        LEFT JOIN TR_TINGKAT_DIKLAT_KEPEMIMPINAN TRTDK ON (TRTDK.ID=TPP.TRTINGKATDIKLATKEPEMIMPINAN_ID) 
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.THN_DIKLAT DESC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_diklat_teknis($id=0) {
        $sql = "SELECT TPP.*,TO_CHAR(TGL_STTPP,'DD/MM/YYYY') AS TGL_STTPP2 FROM TH_PEGAWAI_DIKLAT_TEKNIS TPP 
        LEFT JOIN TR_KELOMPOK_DKLT_TEKNIS TRKDT ON (TRKDT.ID=TPP.TRKELOMPOKDKLTTEKNIS_ID) 
        LEFT JOIN TR_DIKLAT_TEKNIS TRDT ON (TRDT.ID=TPP.TRDIKLATTEKNIS_ID) 
        LEFT JOIN TR_NEGARA TRN ON (TRN.ID=TPP.TRNEGARA_ID)  
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.ID DESC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_diklat_fungsional($id=0) {
        $sql = "SELECT TPP.*,TO_CHAR(TGL_STTPP,'DD/MM/YYYY') AS TGL_STTPP2,TRPF.PENJENJANGAN_FUNGSIONAL,TRNP.NAMA_PENJENJANGAN,TRKDT.JENIS_DIKLAT_FUNGSIONAL FROM TH_PEGAWAI_DIKLAT_FUNGSIONAL TPP 
        LEFT JOIN TR_JENIS_DIKLAT_FUNGSIONAL TRKDT ON (TRKDT.ID=TPP.TRJENISDIKLATFUNGSIONAL_ID) 
        LEFT JOIN TR_PENJENJANGAN_FUNGSIONAL TRPF ON (TRPF.ID=TPP.TRPENJENJANGANFUNGSIONAL_ID) 
        LEFT JOIN TR_KELOMPOK_FUNGSIONAL TRKF ON (TRKF.ID=TPP.TRKELOMPOKFUNGSIONAL_ID) 
        LEFT JOIN TR_NAMA_PENJENJANGAN TRNP ON (TRNP.ID=TPP.TRNAMAPENJENJANGAN_ID)  
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.ID DESC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_diklat_lain($id=0) {
        $sql = "SELECT TPP.*,TO_CHAR(TGL_STTPP,'DD/MM/YYYY') AS TGL_STTPP2 FROM TH_PEGAWAI_DIKLAT_LAIN TPP 
        LEFT JOIN TR_NEGARA TRN ON (TRN.ID=TPP.TRNEGARA_ID) 
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.TGL_STTPP DESC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_kursus($id=0) {
        $sql = "SELECT TPP.*,TRN.NAMA_NEGARA FROM TH_PEGAWAI_SEMINAR TPP 
        LEFT JOIN TR_JENIS_KEGIATAN TRJK ON (TRJK.ID=TPP.TRJENISKEGIATAN_ID) 
        LEFT JOIN TR_NEGARA TRN ON (TRN.ID=TPP.TRNEGARA_ID) 
        LEFT JOIN TR_JENIS_PEMBIAYAAN TRJP ON (TRJP.ID=TPP.TRJENISPEMBIAYAAN_ID) 
        LEFT JOIN TR_KEDUDUKAN_DLM_KEGIATAN TRKDK ON (TRKDK.ID=TPP.TRKEDUDUKANDLMKEGIATAN_ID) 
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.ID ASC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_pangkat($id=0) {
        $sql = "SELECT TPP.*,TRG.TRSTATUSKEPEGAWAIAN_ID,TRG.GOLONGAN,TRG.PANGKAT,TRJKP.JENIS_KENAIKAN_PANGKAT,(SELECT MIN(TGP.GAPOK) FROM TR_GAJI_POKOK TGP WHERE TGP.TRGOLONGAN_ID=TPP.TRGOLONGAN_ID) AS GAPOK,TO_CHAR(TMT_GOL,'DD/MM/YYYY') as TMT_GOL2 FROM TH_PEGAWAI_PANGKAT TPP 
        LEFT JOIN TR_JENIS_KENAIKAN_PANGKAT TRJKP ON (TRJKP.ID=TPP.TRJENISKENAIKANPANGKAT_ID)
        LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=TPP.TRGOLONGAN_ID)
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.TMT_GOL DESC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_jabatan($id=0) {
        $sql = "SELECT TPP.*,TO_CHAR(TMT_ESELON,'DD/MM/YYYY') as TMT_ESELON2,TO_CHAR(TMT_JABATAN,'DD/MM/YYYY') as TMT_JABATAN2,
        TO_CHAR(TGL_SK,'DD/MM/YYYY') as TGL_SK2,TO_CHAR(TGL_AKHIR,'DD/MM/YYYY') as TGL_AKHIR2,F_GET_PANGKAT_INJABATAN(TPP.TMPEGAWAI_ID,TO_CHAR(TMT_JABATAN,'YYYY-MM-DD')) AS GOLPANGKAT,
        F_GET_GAPOK_INJABATAN(TPP.TMPEGAWAI_ID,TO_CHAR(TMT_JABATAN,'YYYY-MM-DD')) as GAPOK
        FROM TH_PEGAWAI_JABATAN TPP 
        LEFT JOIN TR_ESELON TRE ON (TRE.ID=TPP.TRESELON_ID)
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.TMT_JABATAN DESC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_penghargaan($id=0) {
        $sql = "SELECT TPP.*,TRN.NAMA_NEGARA,TRJTJ.JENIS_TANDA_JASA,TRTJ.TANDA_JASA FROM TH_PEGAWAI_PENGHARGAAN TPP 
        LEFT JOIN TR_JENIS_TANDA_JASA TRJTJ ON (TRJTJ.ID=TPP.TRJENISTANDAJASA_ID) 
        LEFT JOIN TR_TANDA_JASA TRTJ ON (TRTJ.ID=TPP.TRTANDAJASA_ID) 
        LEFT JOIN TR_NEGARA TRN ON (TRN.ID=TPP.TRNEGARA_ID) 
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.ID ASC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_luar_negeri($id=0) {
        $sql = "SELECT TPP.*,TRN.NAMA_NEGARA,TRJP.JENIS_PEMBIAYAAN FROM TH_PEGAWAI_KUNJUNGAN_LN TPP 
        LEFT JOIN TR_JENIS_PEMBIAYAAN TRJP ON (TRJP.ID=TPP.TRJENISPEMBIAYAAN_ID) 
        LEFT JOIN TR_NEGARA TRN ON (TRN.ID=TPP.TRNEGARA_ID) 
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.ID ASC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_pasangan($id=0) {
        $sql = "SELECT TPP.*,TRP.PEKERJAAN,TO_CHAR(TGL_LAHIR,'DD/MM/YYYY') AS TGL_LAHIR2,TO_CHAR(TGL_NIKAH,'DD/MM/YYYY') AS TGL_NIKAH2 FROM TH_PEGAWAI_PASANGAN TPP 
        LEFT JOIN TR_PEKERJAAN TRP ON (TRP.ID=TPP.TRPEKERJAAN_ID) 
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.ID ASC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_anak($id=0) {
        $sql = "SELECT TPP.*,TRSA.NAMA AS NAMAANAK,TO_CHAR(TGL_LAHIR,'DD/MM/YYYY') AS TGL_LAHIR2 FROM TH_PEGAWAI_ANAK TPP 
        LEFT JOIN TR_STATUS_ANAK TRSA ON (TRSA.ID=TPP.TRSTATUSANAK_ID) 
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.TGL_LAHIR ASC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_ortu_kandung($id=0) {
        $sql = "SELECT TPP.*,TRSA.NAMA AS NAMAORTU,TO_CHAR(TGL_LAHIR,'DD/MM/YYYY') AS TGL_LAHIR2 FROM TH_PEGAWAI_ORTU TPP 
        LEFT JOIN TR_STATUS_ORANG_TUA TRSA ON (TRSA.ID=TPP.TMSTATUSORTU_ID) 
        WHERE TMPEGAWAI_ID=? AND TMSTATUSORTU_ID IN ('1','2') ORDER BY TPP.TGL_LAHIR ASC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_ortu_mertua($id=0) {
        $sql = "SELECT TPP.*,TRSA.NAMA AS NAMAORTU,TO_CHAR(TGL_LAHIR,'DD/MM/YYYY') AS TGL_LAHIR2 FROM TH_PEGAWAI_ORTU TPP 
        LEFT JOIN TR_STATUS_ORANG_TUA TRSA ON (TRSA.ID=TPP.TMSTATUSORTU_ID) 
        WHERE TMPEGAWAI_ID=? AND TMSTATUSORTU_ID IN ('3','4') ORDER BY TPP.TGL_LAHIR ASC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_saudara($id=0) {
        $sql = "SELECT TPP.*,TO_CHAR(TGL_LAHIR,'DD/MM/YYYY') AS TGL_LAHIR2 FROM TH_PEGAWAI_SAUDARA TPP 
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.TGL_LAHIR ASC, TPP.ID ASC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_organisasi($id=0) {
        $sql = "SELECT TPP.* FROM TH_PEGAWAI_ORGANISASI TPP 
        LEFT JOIN TR_JENIS_ORGANISASI TRSA ON (TRSA.ID=TPP.TRJENISORGANISASI_ID) 
        WHERE TMPEGAWAI_ID=? AND TRSA.ID = '3' ORDER BY TPP.THN_TERDAFTAR ASC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_perguruan($id=0) {
        $sql = "SELECT TPP.* FROM TH_PEGAWAI_ORGANISASI TPP 
        LEFT JOIN TR_JENIS_ORGANISASI TRSA ON (TRSA.ID=TPP.TRJENISORGANISASI_ID) 
        WHERE TMPEGAWAI_ID=? AND TRSA.ID = '2' ORDER BY TPP.THN_TERDAFTAR ASC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_pns($id=0) {
        $sql = "SELECT TPP.* FROM TH_PEGAWAI_ORGANISASI TPP 
        LEFT JOIN TR_JENIS_ORGANISASI TRSA ON (TRSA.ID=TPP.TRJENISORGANISASI_ID) 
        WHERE TMPEGAWAI_ID=? AND TRSA.ID = '1' ORDER BY TPP.THN_TERDAFTAR ASC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }
    
    function get_data_pegawai_keterangan($id=0) {
        $sql = "SELECT TPP.*,TO_CHAR(TGL_SK,'DD/MM/YYYY') AS TGL_SK2 FROM TH_PEGAWAI_KETERANGAN_LAIN TPP 
        WHERE TMPEGAWAI_ID=? ORDER BY TPP.TGL_SK DESC";
        $query = $this->db->query($sql,[$id]);
        return $query->result_array();
    }

}
