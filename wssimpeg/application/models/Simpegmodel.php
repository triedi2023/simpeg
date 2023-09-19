<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Simpegmodel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }


    // function getDataMain() {
    //     $this->db->select('A.TMPEGAWAI_ID AS ID, B.NIP, B.NIPNEW,B.NAMA, B.GELAR_DEPAN, B.GELAR_BLKG, B.NO_KARPEG,B.SEX');
    //     $this->db->join('TM_PEGAWAI B','B.ID = A.TMPEGAWAI_ID','LEFT');
    //     $this->db->join('TR_JABATAN TRJ','TRJ.ID=A.TRJABATAN_ID','LEFT');
    //      $this->db->order_by('B.NAMA','ASC');
    //     $query = $this->db->get('V_PEGAWAI_JABATAN_MUTAKHIR A')->result_array();
    //     return $query;
    // }

    public function getDataMain($nip,$jabatan)
    {
        $where='';
        if($nip!=''){
            $where=" AND B.NIP = '".$nip."' or B.NIPNEW = '".$nip."'";
        }
        if($jabatan!=''){
            $where=" AND UPPER(A.N_JABATAN) LIKE '%".strtoupper($jabatan)."%'";
        }
        $query = $this->db->query("SELECT
                            A.TMPEGAWAI_ID AS ID,
                            A.TRJABATAN_ID AS ID_JAB,
                            A.N_JABATAN as JABATAN,
                            A.TRESELON_ID,
                            TRS.ESELON,
                            TO_CHAR(A.TMT_JABATAN,'DD-MM-YYYY') AS TMT_JABATAN,
                            B.NIP,
                            B.NIPNEW,
                            B.NAMA,
                            B.GELAR_DEPAN,
                            B.GELAR_BLKG,
                            B.FOTO,
                            B.NO_KARPEG,
                            B.SEX,
                            B.TPTLAHIR,
                            B.TINGGI_BADAN,
                            B.BERAT_BADAN,
                            B.ALAMAT,
                            B.RT,
                            B.RW,
                            B.KELURAHAN,
                            B.KECAMATAN,
                            B.PROPINSI,
                            B.KABUPATEN,
                            B.KODEPOS,
                            B.TELP_RMH,
                            B.TELP_HP,
                            B.KODEPOS,
                            TO_CHAR(B.TGLLAHIR,'DD-MM-YYYY')AS TGLLAHIR,
                            A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5,
                            MPPV.TRTINGKATPENDIDIKAN_ID,
                            TRTP.TINGKAT_PENDIDIKAN,
                            VPM.TRGOLONGAN_ID,
                            TO_CHAR(VPM.TMT_GOL,'DD-MM-YYYY') AS TMT_GOL,
                            TRG.GOLONGAN,
                            TRG.PANGKAT,
                            -- TSO.KD_SATKER,
                            A.NMUNIT
                        FROM
                            V_PEGAWAI_JABATAN_MUTAKHIR A
                        JOIN TM_PEGAWAI B ON B.ID = A.TMPEGAWAI_ID
                        JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPM ON B.ID = VPM.TMPEGAWAI_ID
                        LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON MPPV.TMPEGAWAI_ID=B.ID 
                        LEFT JOIN TR_TINGKAT_PENDIDIKAN TRTP ON TRTP.ID=MPPV.TRTINGKATPENDIDIKAN_ID 
                        LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=VPM.TRGOLONGAN_ID) 
                        LEFT JOIN TR_ESELON TRS ON (TRS.ID=A.TRESELON_ID) 
                        WHERE 1=1 ".$where."
                        ORDER BY
                            A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5")->result_array();

           // -- LEFT JOIN TR_STRUKTUR_ORGANISASI TSO ON (A.TRLOKASI_ID=TSO.TRLOKASI_ID AND A.KDU1=TSO.KDU1 AND 
           //                  -- A.KDU2=TSO.KDU2 AND A.KDU3=TSO.KDU3 AND A.KDU4=TSO.KDU4 AND A.KDU5=TSO.KDU5)

        // foreach ($query as $i => $value) {
        //     $this->db->where('A.TMPEGAWAI_ID',$value->ID);
        //     $this->db->select('C.NAMA_KELOMPOK AS KELOMPOK,B.NAMA_DIKLAT');
        //     $this->db->join('TR_DIKLAT_TEKNIS B','B.ID = A.TRDIKLATTEKNIS_ID','LEFT');
        //     $this->db->join('TR_KELOMPOK_DKLT_TEKNIS C','C.ID = A.TRKELOMPOKDKLTTEKNIS_ID','LEFT');
        //     $diklat_teknis = $this->db->get('TH_PEGAWAI_DIKLAT_TEKNIS A')->result_array();
        //     $value->diklat_teknis = $diklat_teknis;

        //     $this->db->where('A.TMPEGAWAI_ID',$value->ID);
        //     $this->db->select(' C.PENJENJANGAN_FUNGSIONAL,B.JENIS_DIKLAT_FUNGSIONAL,D.NAMA_PENJENJANGAN, B.ID AS ID_DIKLAT_FUNGSIONAL');
        //     $this->db->join('TR_NAMA_PENJENJANGAN D','D.ID = A.TRNAMAPENJENJANGAN_ID','LEFT');
        //     $this->db->join('TR_PENJENJANGAN_FUNGSIONAL C','C.ID = A.TRPENJENJANGANFUNGSIONAL_ID','LEFT');
        //     $this->db->join('TR_JENIS_DIKLAT_FUNGSIONAL B','B.ID = A.TRJENISDIKLATFUNGSIONAL_ID','LEFT');
        //     $diklat_fungsional = $this->db->get('TH_PEGAWAI_DIKLAT_FUNGSIONAL A')->result_array();
        //     $value->diklat_fungsional = $diklat_fungsional;

        //     $this->db->where('A.TMPEGAWAI_ID',$value->ID);
        //     $this->db->select('B.NAMA_JENJANG,B.ID AS ID_PENJENJANGAN');
        //     $this->db->join('TR_TINGKAT_DIKLAT_KEPEMIMPINAN B','B.ID = A.TRTINGKATDIKLATKEPEMIMPINAN_ID','LEFT');
        //     $diklat_penjenjangan = $this->db->get('TH_PEGAWAI_DIKLAT_PENJENJANGAN A')->result_array();
        //     $value->diklat_penjenjangan = $diklat_penjenjangan;

        //     $this->db->where('TMPEGAWAI_ID',$value->ID);
        //     $this->db->select('NAMA_DIKLAT');
        //     $diklat_prajabatan = $this->db->get('TH_PEGAWAI_DIKLAT_PRAJABATAN')->result_array();
        //     $value->diklat_prajabatan = $diklat_prajabatan;

        //     $this->db->where('TMPEGAWAI_ID',$value->ID);
        //     $this->db->select('NAMA_DIKLAT');
        //     $diklat_lain = $this->db->get('TH_PEGAWAI_DIKLAT_LAIN')->result_array();
        //     $value->diklat_lain = $diklat_lain;

        // }
        return $query;

    }

     public function getDataMain2($param)
    {
        $where='';
        if ($param=='jenjang') {
            $where=' AND VPM.TRGOLONGAN_ID=013 OR VPM.TRGOLONGAN_ID=010 OR VPM.TRGOLONGAN_ID=008';    
        }

        $query = $this->db->query("SELECT DISTINCT
                            A.TMPEGAWAI_ID AS ID,
                            A.TRJABATAN_ID AS ID_JAB,
                            A.N_JABATAN as JABATAN,
                            TO_CHAR(A.TMT_JABATAN,'DD-MM-YYYY') AS TMT_JABATAN,
                            B.NIP,
                            B.NIPNEW,
                            B.NAMA,
                            B.GELAR_DEPAN,
                            B.GELAR_BLKG,
                            B.FOTO,
                            B.NO_KARPEG,
                            B.SEX,
                            B.TPTLAHIR,
                            B.TINGGI_BADAN,
                            B.BERAT_BADAN,
                            B.ALAMAT,
                            B.RT,
                            B.RW,
                            B.KELURAHAN,
                            B.KECAMATAN,
                            B.PROPINSI,
                            B.KABUPATEN,
                            B.KODEPOS,
                            B.TELP_RMH,
                            B.TELP_HP,
                            TO_CHAR(B.TGLLAHIR,'DD-MM-YYYY')AS TGLLAHIR,
                            A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5,
                            MPPV.TRTINGKATPENDIDIKAN_ID,
                            TRTP.TINGKAT_PENDIDIKAN,
                            VPM.TRGOLONGAN_ID,
                            TO_CHAR(VPM.TMT_GOL,'DD-MM-YYYY') AS TMT_GOL,
                            TRG.GOLONGAN,
                            TRG.PANGKAT,
                            TSO.KD_SATKER,
                            TSO.NMUNIT
                        FROM
                            V_PEGAWAI_JABATAN_MUTAKHIR A
                        JOIN TM_PEGAWAI B ON B.ID = A.TMPEGAWAI_ID
                        JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPM ON B.ID = VPM.TMPEGAWAI_ID
                        LEFT JOIN TR_JABATAN TRJ ON TRJ.ID=A.TRJABATAN_ID 
                        LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON MPPV.TMPEGAWAI_ID=B.ID 
                        LEFT JOIN TR_TINGKAT_PENDIDIKAN TRTP ON TRTP.ID=MPPV.TRTINGKATPENDIDIKAN_ID 
                        LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=VPM.TRGOLONGAN_ID)
                        LEFT JOIN TR_STRUKTUR_ORGANISASI TSO ON (A.TRLOKASI_ID=TSO.TRLOKASI_ID AND A.KDU1=TSO.KDU1 AND 
                            A.KDU2=TSO.KDU2 AND A.KDU3=TSO.KDU3 AND A.KDU4=TSO.KDU4 AND A.KDU5=TSO.KDU5)
                        WHERE TRJ.TRKELOMPOKFUNGSIONAL_ID=10".$where."
                        ORDER BY
                            A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5")->result_array();
        return $query;

    }

    public function getDataMainRescuerAll($param)
    {
        $where='';
        if ($param=='jenjang') {
            $where=' AND VPM.TRGOLONGAN_ID=013 OR VPM.TRGOLONGAN_ID=010 OR VPM.TRGOLONGAN_ID=008';    
        }

        $query = $this->db->query("SELECT DISTINCT
                            A.TMPEGAWAI_ID AS ID,
                            A.TRJABATAN_ID AS ID_JAB,
                            A.N_JABATAN as JABATAN,
                            TO_CHAR(A.TMT_JABATAN,'DD-MM-YYYY') AS TMT_JABATAN,
                            B.NIP,
                            B.NIPNEW,
                            B.NAMA,
                            B.GELAR_DEPAN,
                            B.GELAR_BLKG,
                            B.FOTO,
                            B.NO_KARPEG,
                            B.SEX,
                            B.TPTLAHIR,
                            B.TINGGI_BADAN,
                            B.BERAT_BADAN,
                            B.ALAMAT,
                            B.RT,
                            B.RW,
                            B.KELURAHAN,
                            B.KECAMATAN,
                            B.PROPINSI,
                            B.KABUPATEN,
                            B.KODEPOS,
                            B.TELP_RMH,
                            B.TELP_HP,
                            TO_CHAR(B.TGLLAHIR,'DD-MM-YYYY')AS TGLLAHIR,
                            A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5,
                            MPPV.TRTINGKATPENDIDIKAN_ID,
                            TRTP.TINGKAT_PENDIDIKAN,
                            VPM.TRGOLONGAN_ID,
                            TO_CHAR(VPM.TMT_GOL,'DD-MM-YYYY') AS TMT_GOL,
                            TRG.GOLONGAN,
                            TRG.PANGKAT,
                            TSO.KD_SATKER,
                            TSO.NMUNIT
                        FROM
                            V_PEGAWAI_JABATAN_MUTAKHIR A
                        JOIN TM_PEGAWAI B ON B.ID = A.TMPEGAWAI_ID
                        JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPM ON B.ID = VPM.TMPEGAWAI_ID
                        LEFT JOIN TR_JABATAN TRJ ON TRJ.ID=A.TRJABATAN_ID 
                        LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON MPPV.TMPEGAWAI_ID=B.ID 
                        LEFT JOIN TR_TINGKAT_PENDIDIKAN TRTP ON TRTP.ID=MPPV.TRTINGKATPENDIDIKAN_ID 
                        LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=VPM.TRGOLONGAN_ID)
                        LEFT JOIN TR_STRUKTUR_ORGANISASI TSO ON (A.TRLOKASI_ID=TSO.TRLOKASI_ID AND A.KDU1=TSO.KDU1 AND 
                            A.KDU2=TSO.KDU2 AND A.KDU3=TSO.KDU3 AND A.KDU4=TSO.KDU4 AND A.KDU5=TSO.KDU5)
                        WHERE UPPER(A.N_JABATAN) LIKE '%RESCUER%'".$where."
                        ORDER BY
                            A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5")->result_array();
        return $query;

    }


     public function getpensiun($nip,$bln,$thn,$pendidikan,$pangkat,$jenjang)
    {
        $where='';
        if($nip!=''){
            $where .= "AND B.NIP = '".$nip."' or B.NIPNEW = '".$nip."'";
        }
        if($bln!=''){
            $where.="AND TO_CHAR(VP.TMT_PENSIUN, 'MM') = '".$bln."'";
        }
        if($thn!=''){
            $where.="AND TO_CHAR(VP.TMT_PENSIUN, 'YYYY') = ".$thn;
        }
        if($pendidikan!=''){
            $where.="AND TRTP.TINGKAT_PENDIDIKAN= '".$pendidikan."'";
        }
        if($pangkat!=''){
            $where.="AND UPPER(A.PANGKAT) = '".$pangkat."'";
        }
        if($jenjang!=''){
            $where.="AND UPPER(A.N_JABATAN) LIKE '%".$jenjang."%'";
        }
        // // $this->db->where('KEL_JABATAN','FUNGSIONAL');
        // $this->db->where("TRESELON_ID <> '17' AND TRESELON_ID IN ('13','15')");
        // $this->db->select('A.*,TRTP.TINGKAT_PENDIDIKAN');
        // $this->db->join('V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV','MPPV.TMPEGAWAI_ID=A.ID','LEFT');
        // $this->db->join('TR_TINGKAT_PENDIDIKAN TRTP','TRTP.ID=MPPV.TRTINGKATPENDIDIKAN_ID','LEFT');
        // $query = $this->db->get('V_MONITORING_PENSIUN A')->result_array();
        // return $query;

         $query = $this->db->query("SELECT DISTINCT
                            A.TMPEGAWAI_ID AS ID,
                            A.TRJABATAN_ID AS ID_JAB,
                            A.N_JABATAN as JABATAN,
                            TO_CHAR(A.TMT_JABATAN,'DD-MM-YYYY') AS TMT_JABATAN,
                            B.NIP,
                            B.NIPNEW,
                            B.NAMA,
                            B.GELAR_DEPAN,
                            B.GELAR_BLKG,
                            B.FOTO,
                            B.NO_KARPEG,
                            B.SEX,
                            B.TPTLAHIR,
                            B.TINGGI_BADAN,
                            B.BERAT_BADAN,
                            B.ALAMAT,
                            B.RT,
                            B.RW,
                            B.KELURAHAN,
                            B.KECAMATAN,
                            B.PROPINSI,
                            B.KABUPATEN,
                            B.KODEPOS,
                            B.TELP_RMH,
                            B.TELP_HP,
                            TO_CHAR(B.TGLLAHIR,'DD-MM-YYYY')AS TGLLAHIR,
                            A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5,
                            MPPV.TRTINGKATPENDIDIKAN_ID,
                            TRTP.TINGKAT_PENDIDIKAN,
                            VPM.TRGOLONGAN_ID,
                            TO_CHAR(VPM.TMT_GOL,'DD-MM-YYYY') AS TMT_GOL,
                            TRG.GOLONGAN,
                            TRG.PANGKAT,
                            TSO.KD_SATKER,
                            TSO.NMUNIT,
                            VP.TMT_PENSIUN
                        FROM
                            V_PEGAWAI_JABATAN_MUTAKHIR A
                        JOIN TM_PEGAWAI B ON B.ID = A.TMPEGAWAI_ID
                        JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPM ON B.ID = VPM.TMPEGAWAI_ID
                        LEFT JOIN V_MONITORING_PENSIUN VP ON B.NIP = VP.NIP AND B.NIPNEW=VP.NIPNEW
                        LEFT JOIN TR_JABATAN TRJ ON TRJ.ID=A.TRJABATAN_ID 
                        LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON MPPV.TMPEGAWAI_ID=B.ID 
                        LEFT JOIN TR_TINGKAT_PENDIDIKAN TRTP ON TRTP.ID=MPPV.TRTINGKATPENDIDIKAN_ID 
                        LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=VPM.TRGOLONGAN_ID)
                        LEFT JOIN TR_STRUKTUR_ORGANISASI TSO ON (A.TRLOKASI_ID=TSO.TRLOKASI_ID AND A.KDU1=TSO.KDU1 AND 
                            A.KDU2=TSO.KDU2 AND A.KDU3=TSO.KDU3 AND A.KDU4=TSO.KDU4 AND A.KDU5=TSO.KDU5)
                        WHERE TRJ.TRKELOMPOKFUNGSIONAL_ID=10 ".$where."
                        ORDER BY
                            A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5")->result_array();
         return $query;
    }

    public function getfungsional($nip,$bln,$thn,$pangkat,$jenjang)
    {
        if($nip!=''){
            $this->db->where("A.NIP = '".$nip."' or A.NIPNEW = '".$nip."'");
        }
        if($bln!=''){
            $this->db->where("TO_CHAR(A.TMT_JABATAN, 'MM') = '".$bln."'");
        }
        if($thn!=''){
            $this->db->where("TO_CHAR(A.TMT_JABATAN, 'YYYY') = ".$thn);
        }
        if($jenjang!=''){
            $this->db->like('UPPER(A.JABATAN)',$jenjang);
        }
        if($pangkat!=''){
            $this->db->where('UPPER(A.PANGKAT)',$pangkat);
        }
        // $this->db->where('TRJABATAN_ID','FUNGSIONAL');
        $this->db->select("A.*");
        $this->db->like('UPPER(A.JABATAN)','RESCUER');
        // $this->db->join('V_PEGAWAI_JABATAN_MUTAKHIR VPM','VPM.NIP=A.NIPNEW','LEFT');
        // $this->db->join('TR_JABATAN C','C.ID=B.TRJABATAN_ID','LEFT');
        $query = $this->db->get('V_SUPERVISE_FUNGSIONAL A')->result_array();
        return $query;

    }

    public function getak($nip,$pangkat,$akmin,$aknow)
    {
        if($nip!=''){
            $this->db->where("A.NIP = '".$nip."' or A.NIPNEW = '".$nip."'");
        }
        if($akmin!=''){
            $this->db->where('AK_MINIMAL',$akmin);
        }
        if($aknow!=''){
            $this->db->where('AK_SAAT_INI',$aknow);
        }
        if($pangkat!=''){
            $this->db->where('PANGKAT',$pangkat);
        }
        $this->db->like('UPPER(N_JABATAN)','RESCUER');
        // $this->db->where('TRJABATAN_ID','FUNGSIONAL');
        $this->db->select("*");
        // $this->db->join('V_PEGAWAI_JABATAN_MUTAKHIR VPM','VPM.NIP=A.NIPNEW','LEFT');
        // $this->db->join('TR_JABATAN C','C.ID=B.TRJABATAN_ID','LEFT');
        $query = $this->db->get('V_MONITORING_AK')->result_array();
        return $query;

    }

public function getkenaikanpangkat($nip,$bln,$thn,$pendidikan)
    {
        $tahun_sekarang = date('Y');
        $bulan_sekarang = date('m');
        $param = "$tahun_sekarang-$bulan_sekarang-01";
        $point = '';
        $where = '';
        // if($nip!=''){
        //     $this->db->where("A.NIP = '".$nip."' or A.NIPNEW = '".$nip."'");
        // }
        // if($bln!=''){
        //     $param = "$tahun_sekarang-$bln-01";
        //     // $this->db->where('AK_MINIMAL',$bln);
        // }
        // if($thn!=''){
        //     $param = "$thn-$bulan_sekarang-01";
        //     // $this->db->where('AK_SAAT_INI',$thn);
        // }
        // if($pendidikan!=''){
        //     $this->db->where('PANGKAT',$pendidikan);
        // }
        // // $this->db->where('TRJABATAN_ID','FUNGSIONAL');
        // $this->db->select("*, TRG.PANGKAT");
        // // $this->db->join('TR_GOLONGAN TRG','TRG.ID=A.ID_TRGOLONGAN_BARU','LEFT');
        // // $query = $this->db->get("TABLE(F_MON_KP_FUNGSIONAL('".$param."'))")->result_array();
        // // $this->db->join('TR_JABATAN C','C.ID=B.TRJABATAN_ID','LEFT');
        // // $query = $this->db->get('V_MONITORING_AK')->result_array();
        // $query = $this->db->query("
        //     SELECT * FROM TABLE(F_MON_KP_FUNGSIONAL('".$param."'))")->result_array();
         $condition = [];
       
        if (!empty($nip) && $nip != "") {
            $point .= " AND A.NIPNEW=?";
            $condition = array_merge($condition, [$nip]);
        }
        
        if (!empty($bln) && !empty($thn)) {
            $param = "$thn-$bln-01";
            $param2 = "01/$bln/$thn";
        } else {
            $param = "$tahun_sekarang-$bulan_sekarang-01";
            $param2 = "01/$bulan_sekarang/$tahun_sekarang";
        }
        
       
            $sql = "SELECT A.*,TRG.PANGKAT FROM TABLE(F_MON_KP_FUNGSIONAL('$param')) A
                    LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=A.ID_TRGOLONGAN_BARU)
                    WHERE 1=1 AND UPPER(N_JABATAN) LIKE 'RESCUER%' $where ";
        
        
        $query = $this->db->query($sql,$condition)->result_array();
        return $query;

    }


    public function getDataSingle($nip)
    {
         $query = $this->db->query("SELECT DISTINCT
                            A.TMPEGAWAI_ID AS ID,
                            B.NIP,
                            B.NIPNEW,
                            B.NAMA,
                            B.GELAR_DEPAN,
                            B.GELAR_BLKG,
                            A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5,
                            MPPV.TRTINGKATPENDIDIKAN_ID,
                            TRTP.TINGKAT_PENDIDIKAN,
                            VPM.TRGOLONGAN_ID,
                            TRG.GOLONGAN,
                            TRG.PANGKAT
                        FROM
                            V_PEGAWAI_JABATAN_MUTAKHIR A
                        JOIN TM_PEGAWAI B ON B.ID = A.TMPEGAWAI_ID
                        JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPM ON B.ID = VPM.TMPEGAWAI_ID
                        LEFT JOIN TR_JABATAN TRJ ON TRJ.ID=A.TRJABATAN_ID 
                        LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON MPPV.TMPEGAWAI_ID=B.ID 
                        LEFT JOIN TR_TINGKAT_PENDIDIKAN TRTP ON TRTP.ID=MPPV.TRTINGKATPENDIDIKAN_ID 
                        LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=VPM.TRGOLONGAN_ID)
                        WHERE B.NIP = '".$nip."' or B.NIPNEW = '".$nip."'
                        ORDER BY
                            A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5")->row_array();

         $query1=array_merge($query, array('diklat_teknis' => $this->getDiklatTeknis($query['ID'])));
         $query2=array_merge($query1, array('diklat_fungsional' => $this->getDiklatFungsional($query['ID'])));
         $query3=array_merge($query2, array('diklat_penjenjangan' => $this->getDiklatPenjenjangan($query['ID'])));
         $query4=array_merge($query3, array('diklat_prajabatan' => $this->getDiklatPrajabatan($query['ID'])));
         $query5=array_merge($query4, array('diklat_lain' => $this->getDiklatLain($query['ID'])));

         // print_r($query1);
         return $query5;
    }

    // function getDataMain2() {
    //     $this->db->where('TRJ.TRKELOMPOKFUNGSIONAL_ID',10);
    //     $this->db->select('A.TMPEGAWAI_ID AS ID, B.NIP, B.NIPNEW,B.NAMA, B.GELAR_DEPAN, B.GELAR_BLKG, B.NO_KARPEG,B.SEX');
    //     $this->db->join('TM_PEGAWAI B','B.ID = A.TMPEGAWAI_ID','LEFT');
    //     $this->db->join('TR_JABATAN TRJ','TRJ.ID=A.TRJABATAN_ID','LEFT');
    //      $this->db->order_by('B.NAMA','ASC');
    //     $query = $this->db->get('V_PEGAWAI_JABATAN_MUTAKHIR A')->result_array();
    //     return $query;
    // }

    function getPangkat($param) {
        $this->db->where('A.TMPEGAWAI_ID',$param);
        $this->db->select('A.ID AS ID_PANGKAT, A.TRGOLONGAN_ID,B.GOLONGAN, B.PANGKAT');
        $this->db->join('TR_GOLONGAN B','B.ID = A.TRGOLONGAN_ID','LEFT');
        $query = $this->db->get('TH_PEGAWAI_PANGKAT A')->row();
        return $query;
    }

    function getPendidikan($param) {
        $this->db->where('A.TMPEGAWAI_ID',$param);
        $this->db->order_by('B.ID','ASC');
        $this->db->select('A.TRTINGKATPENDIDIKAN_ID, B.KETERANGAN,B.ID AS ID_PENDIDIKAN');
        $this->db->join('TR_TINGKAT_PENDIDIKAN B','B.ID = A.TRTINGKATPENDIDIKAN_ID','LEFT');
        $query = $this->db->get('TH_PEGAWAI_PENDIDIKAN A')->row();
        return $query;
    }

    function getJabatan($param) {
        $this->db->where('A.TMPEGAWAI_ID',$param);
        $this->db->select('A.TRJABATAN_ID,A.N_JABATAN');
        $this->db->join('TR_JABATAN B','B.ID = A.TRJABATAN_ID','LEFT');
        $query = $this->db->get('TH_PEGAWAI_JABATAN A')->row();
        return $query;
    }

    function getDiklatTeknis($param) {
        $this->db->where('A.TMPEGAWAI_ID',$param);
        $this->db->select('C.NAMA_KELOMPOK AS KELOMPOK,B.NAMA_DIKLAT');
        $this->db->join('TR_DIKLAT_TEKNIS B','B.ID = A.TRDIKLATTEKNIS_ID','LEFT');
        $this->db->join('TR_KELOMPOK_DKLT_TEKNIS C','C.ID = A.TRKELOMPOKDKLTTEKNIS_ID','LEFT');
        $query = $this->db->get('TH_PEGAWAI_DIKLAT_TEKNIS A')->result_array();
        return $query;
    }

    function getDiklatFungsional($param) {
        $this->db->where('A.TMPEGAWAI_ID',$param);
        $this->db->select(' C.PENJENJANGAN_FUNGSIONAL,B.JENIS_DIKLAT_FUNGSIONAL,D.NAMA_PENJENJANGAN, B.ID AS ID_DIKLAT_FUNGSIONAL');
        $this->db->join('TR_NAMA_PENJENJANGAN D','D.ID = A.TRNAMAPENJENJANGAN_ID','LEFT');
        $this->db->join('TR_PENJENJANGAN_FUNGSIONAL C','C.ID = A.TRPENJENJANGANFUNGSIONAL_ID','LEFT');
        $this->db->join('TR_JENIS_DIKLAT_FUNGSIONAL B','B.ID = A.TRJENISDIKLATFUNGSIONAL_ID','LEFT');
        $query = $this->db->get('TH_PEGAWAI_DIKLAT_FUNGSIONAL A')->result_array();
        return $query;
    }

    function getDiklatPenjenjangan($param) {
        $this->db->where('A.TMPEGAWAI_ID',$param);
        $this->db->select('B.NAMA_JENJANG,B.ID AS ID_PENJENJANGAN');
        $this->db->join('TR_TINGKAT_DIKLAT_KEPEMIMPINAN B','B.ID = A.TRTINGKATDIKLATKEPEMIMPINAN_ID','LEFT');
        $query = $this->db->get('TH_PEGAWAI_DIKLAT_PENJENJANGAN A')->result_array();
        return $query;
    }

    function getDiklatPrajabatan($param) {
        $this->db->where('TMPEGAWAI_ID',$param);
        $this->db->select('NAMA_DIKLAT');
        $query = $this->db->get('TH_PEGAWAI_DIKLAT_PRAJABATAN')->result_array();
        return $query;
    }

    function getDiklatLain($param) {
        $this->db->where('TMPEGAWAI_ID',$param);
        $this->db->select('NAMA_DIKLAT');
        $query = $this->db->get('TH_PEGAWAI_DIKLAT_LAIN')->result_array();
        return $query;
    }

    //===========================================================================
    //MASTER DATA
    function getMasterJabatan($data) {
        if(sizeof($data)>0){
            if(isset($data['TR_JABATAN.JABATAN'])){
                $this->db->like('UPPER(TR_JABATAN.JABATAN)',strtoupper($data['TR_JABATAN.JABATAN']));
                unset($data['TR_JABATAN.JABATAN']);
            }
            if(isset($data['TR_ESELON.ESELON'])){
                $this->db->like('UPPER(TR_ESELON.ESELON)',strtoupper($data['TR_ESELON.ESELON']));
                unset($data['TR_ESELON.ESELON']);
            }
            $this->db->where($data);
        }
        $this->db->order_by('ID','ASC');
        $this->db->select('TR_JABATAN.ID as ID_JABATAN,TR_JABATAN.JABATAN,TR_ESELON.ID,TR_ESELON.ESELON');
        $this->db->join('TR_ESELON','TR_ESELON.ID=TR_JABATAN.TRESELON_ID','LEFT');
        $query = $this->db->get('TR_JABATAN')->result_array();
        return $query;
    }

    function getUnitKerja() {
        $this->db->order_by('ID','ASC');
        $this->db->select('TR_JABATAN.ID as ID_JABATAN,TR_JABATAN.JABATAN,TR_ESELON.ID,TR_ESELON.ESELON');
        $this->db->join('TR_ESELON','TR_ESELON.ID=TR_JABATAN.TRESELON_ID','LEFT');
        $query = $this->db->get('TR_JABATAN')->result_array();
        return $query;
    }

    function getMasterDiklatTeknis() {
        $this->db->order_by('A.ID','ASC');
        $this->db->select('A.ID AS ID_DIKLAT,B.NAMA_KELOMPOK AS KELOMPOK,A.NAMA_DIKLAT');
        $this->db->join('TR_KELOMPOK_DKLT_TEKNIS B','B.ID = A.TRKELOMPOKDKLTTEKNIS_ID','LEFT');
        $query = $this->db->get('TR_DIKLAT_TEKNIS A')->result_array();
        return $query;
    }

    public function getMasterDiklatFungsional()
    {
        $this->db->order_by('ID','ASC');
        $this->db->select('ID AS ID_PENJENJANGAN,NAMA_PENJENJANGAN');
        $query = $this->db->get('TR_NAMA_PENJENJANGAN')->result_array();
        return $query;
    }

    public function getMasterkelFungsional()
    {
        $this->db->order_by('ID','ASC');
        $this->db->select('ID AS ID_KEL_FUNGSIONAL,KELOMPOK_FUNGSIONAL');
        $query = $this->db->get('TR_KELOMPOK_FUNGSIONAL')->result_array();
        return $query;
    }


    public function getMasterDiklatPenjenjangan()
    {
        $this->db->select('ID AS ID_PENJENJANGAN,NAMA_JENJANG');
        $query = $this->db->get('TR_TINGKAT_DIKLAT_KEPEMIMPINAN')->result_array();
        return $query;
    }

    public function getMasterGolongan()
    {
        $this->db->order_by('ID','ASC');
        $this->db->select('ID AS ID_GOLONGAN,GOLONGAN,PANGKAT');
        $query = $this->db->get('TR_GOLONGAN')->result_array();
        return $query;
    } 

    public function getMasterPendidikan()
    {
        $this->db->order_by('ID','ASC');
        $this->db->select('ID AS ID_PENDIDIKAN,KETERANGAN');
        $query = $this->db->get('TR_TINGKAT_PENDIDIKAN')->result_array();
        return $query;
    }

    public function getMasterStruktur($nmunit,$kdlok,$kdu3,$kdu4)
    {
        if(isset($nmunit)){
            $this->db->like('UPPER(NMUNIT)',strtoupper($nmunit));
        }

        if(isset($kdlok)){
            $this->db->where('TRLOKASI_ID',strtoupper($kdlok));
        }

        if(isset($kdu3)){
            $this->db->where('KDU3',$kdu3);
        }

        if(isset($kdu4)){
            $this->db->where('KDU4',$kdu4);
        }
        $this->db->order_by('TRLOKASI_ID','ASC');
        $this->db->select('TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5,NMUNIT');
        $query = $this->db->get('TR_STRUKTUR_ORGANISASI')->result_array();
        return $query;
    }

     public function getSatker($satker)
    {
        $where = '';
        if ($satker!='') {
            $where=' AND KD_SATKER='.$satker;
        }
        // $this->db->where('A.KD_SATKER!=',null);
        // // $this->db->where("B.N_JABATAN LIKE '%Kepala Kantor%'");
        // $this->db->order_by('A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5','ASC');
        // $this->db->distinct();
        // $this->db->select('A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5,A.NMUNIT,A.KD_SATKER,B.N_JABATAN');
        // $this->db->join('V_PEGAWAI_JABATAN_MUTAKHIR B','B.TRLOKASI_ID = A.TRLOKASI_ID','LEFT');
        // $query = $this->db->get('TR_STRUKTUR_ORGANISASI2 A')->result_array();
        $query = $this->db->query("
                                SELECT DISTINCT
								A.ID,
                                A.TRLOKASI_ID,
                                A.KDU1,
                                A.KDU2,
                                A.KDU3,
                                A.KDU4,
                                A.KDU5,
                                A.NMUNIT,
                                A.KD_SATKER,
                                (
                                    SELECT DISTINCT
                                        NAMA
                                    FROM
                                        V_PEGAWAI_JABATAN_MUTAKHIR B
                                LEFT JOIN TM_PEGAWAI C ON C.ID=B.TMPEGAWAI_ID
                                    WHERE
                                        A .TRLOKASI_ID = B.TRLOKASI_ID
                                    AND A.KDU1 = B.KDU1
                                    AND A .KDU2 = B.KDU2
                                    AND A .KDU3 = B.KDU3
                                    AND A .KDU4 = B.KDU4
                                    AND A .KDU5 = B.KDU5
                            AND B.N_JABATAN LIKE '%Kepala Kantor%'
                                ) AS NAMA,
                                (
                                    SELECT DISTINCT
                                        GELAR_DEPAN
                                    FROM
                                        V_PEGAWAI_JABATAN_MUTAKHIR B
                                LEFT JOIN TM_PEGAWAI C ON C.ID=B.TMPEGAWAI_ID
                                    WHERE
                                        A .TRLOKASI_ID = B.TRLOKASI_ID
                                    AND A.KDU1 = B.KDU1
                                    AND A .KDU2 = B.KDU2
                                    AND A .KDU3 = B.KDU3
                                    AND A .KDU4 = B.KDU4
                                    AND A .KDU5 = B.KDU5
                            AND B.N_JABATAN LIKE '%Kepala Kantor%'
                                ) AS GELAR_DPN,
                                (
                                    SELECT DISTINCT
                                        GELAR_BLKG
                                    FROM
                                        V_PEGAWAI_JABATAN_MUTAKHIR B
                                LEFT JOIN TM_PEGAWAI C ON C.ID=B.TMPEGAWAI_ID
                                    WHERE
                                        A .TRLOKASI_ID = B.TRLOKASI_ID
                                    AND A.KDU1 = B.KDU1
                                    AND A .KDU2 = B.KDU2
                                    AND A .KDU3 = B.KDU3
                                    AND A .KDU4 = B.KDU4
                                    AND A .KDU5 = B.KDU5
                            AND B.N_JABATAN LIKE '%Kepala Kantor%'
                                ) AS GELAR_BLKG
                            FROM
                                TR_STRUKTUR_ORGANISASI A
                            WHERE
                                A.KD_SATKER IS NOT NULL $where
								-- AND A.STATUS = 1
                            ORDER BY
								A.ID ASC,
                                A.TRLOKASI_ID ASC,
                                A.KDU1 ASC,
                                A.KDU2 ASC,
                                A.KDU3 ASC,
                                A.KDU4 ASC,
                                A.KDU5 ASC")->result_array();
        return $query;
    }

    public function getKepalaBadan()
    {
        $this->db->where('KDU1','00');
        $this->db->like('UPPER(A.N_JABATAN)',strtoupper('KEPALA BADAN'));
        $this->db->select('B.NAMA,B.GELAR_DEPAN,B.GELAR_BLKG');
        $this->db->join('TM_PEGAWAI B','B.ID = A.TMPEGAWAI_ID','LEFT');
        $query = $this->db->get('V_PEGAWAI_JABATAN_MUTAKHIR A')->result_array();
        return $query;
    }

    public function getEselon($id)
    {
        if($id!=''){
            $this->db->where('ID',$id);
        }
        return $this->db->get('TR_ESELON')->result_array();
    }

    public function get_data_single($nip = '0') {
        $host = 'https://simpeg.basarnas.go.id/';
        $query1 = "select trim(TMP.NIP) as \"nip\",trim(TMP.NIPNEW) as \"nipnew\",ltrim(rtrim(TMP.GELAR_DEPAN)) as \"gelar_depan\",
        ltrim(rtrim(TMP.NAMA)) as \"nama\",ltrim(rtrim(TMP.GELAR_BLKG)) as \"gelar_blkg\",
        case when TMP.SEX = 'L' then 'Laki-laki' when TMP.SEX = 'P' THEN 'Perempuan' else '' end as \"jk\",
        case when TMP.TRSTATUSPERNIKAHAN_ID = 'B' then 'Belum Kawin' when TMP.TRSTATUSPERNIKAHAN_ID = 'K' then 'Kawin' when TMP.TRSTATUSPERNIKAHAN_ID = 'D' then 'Duda' when TMP.TRSTATUSPERNIKAHAN_ID = 'J' then 'Janda' else '' end as \"stskawin\",
        TRTP.TINGKAT_PENDIDIKAN as \"tktpndidikan\", MPPV.NAMA_LBGPDK,
        case when TMP.TRAGAMA_ID = '1' then 'Islam' when TMP.TRAGAMA_ID = '2' then 'Kristen' when TMP.TRAGAMA_ID = '3' then 'Katolik' when TMP.TRAGAMA_ID = '4' then 'Hindu' when TMP.TRAGAMA_ID = '5' then 'Budha' else '' end as \"agama\",
        TRG.PANGKAT AS \"pangkat\", TRG.GOLONGAN AS \"golongan\",TMP.TPTLAHIR AS \"tgllahir\",VPJM.N_JABATAN as \"n_jabatan\",VPJM.N_JABATAN AS \"tmtjab\",
        '$host'||'_uploads/photo_pegawai/thumbs/'||FOTO as \"photo\",TPTLAHIR as \"tptlahir\",TRSK.STATUS_KEPEGAWAIAN as \"statpegawai\",
        TINGGI_BADAN as \"tinggi_badan\",BERAT_BADAN as \"berat_badan\",RAMBUT as \"rambut\",BENTUK_MUKA as \"bentuk_muka\",WARNA_KULIT as \"warna_kulit\",CIRI_KHAS as \"ciri_khas\",HOBI as \"hobi\"
        FROM V_PEGAWAI_JABATAN_MUTAKHIR VPJM JOIN TM_PEGAWAI TMP ON (VPJM.TMPEGAWAI_ID=TMP.ID) 
        JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPPM ON VPPM.TMPEGAWAI_ID=TMP.ID 
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

        return $join;
    }

    public function get_pegawai_unitkerja($lok = "2", $kdu1 = "", $kdu2 = "", $kdu3 = "", $kdu4 = "", $kdu5 = "", $tkt_eselon = "", $kel_fungsional = "") {
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
        VPJM.KDU2=TSO.KDU2 AND VPJM.KDU3=TSO.KDU3 AND VPJM.KDU4=TSO.KDU4 AND VPJM.KDU5=TSO.KDU5) LEFT JOIN TR_JABATAN TRJ ON (TRJ.ID=VPJM.TRJABATAN_ID)  WHERE 1=1 $where 
        ORDER BY VPJM.TRLOKASI_ID,VPJM.KDU1,VPJM.KDU2,VPJM.KDU3,VPJM.KDU4,VPJM.KDU5 ";
        return $this->db->query($query)->result_array();
    }

    public function getSatker2()
    {
        $query = $this->db->query("
                                SELECT DISTINCT
                                A.TRLOKASI_ID,
                                A.KDU1,
                                A.KDU2,
                                A.KDU3,
                                A.KDU4,
                                A.KDU5,
                                A.NMUNIT,
                                A.KD_SATKER
                            FROM
                                TR_STRUKTUR_ORGANISASI A
                            WHERE
                                A.KD_SATKER IS NOT NULL 
                            ORDER BY
                                A.TRLOKASI_ID ASC,
                                A.KDU1 ASC,
                                A.KDU2 ASC,
                                A.KDU3 ASC,
                                A.KDU4 ASC,
                                A.KDU5 ASC")->result_array();
        return $query;
    }
	
	function getPenghargaan($nip) {
        $this->db->where('TM_PEGAWAI.NIP',$nip);
		
        $this->db->order_by('TH_PEGAWAI_PENGHARGAAN.ID','ASC');
        $this->db->select('TH_PEGAWAI_PENGHARGAAN.ID,TM_PEGAWAI.NIP,JENIS_TANDA_JASA,TANDA_JASA,THN_PRLHN,NAMA_NEGARA,INSTANSI,DOC_SERTIFIKAT');
        $this->db->join('TM_PEGAWAI','TH_PEGAWAI_PENGHARGAAN.TMPEGAWAI_ID = TM_PEGAWAI.ID','LEFT');
		$this->db->join('TR_JENIS_TANDA_JASA','TR_JENIS_TANDA_JASA.ID=TH_PEGAWAI_PENGHARGAAN.TRJENISTANDAJASA_ID','LEFT');
		$this->db->join('TR_TANDA_JASA','TR_TANDA_JASA.ID=TH_PEGAWAI_PENGHARGAAN.TRTANDAJASA_ID','LEFT');
		$this->db->join('TR_NEGARA','TR_NEGARA.ID=TH_PEGAWAI_PENGHARGAAN.TRNEGARA_ID','LEFT');
        $query = $this->db->get('TH_PEGAWAI_PENGHARGAAN')->result_array();
        return $query;
    }
	
	function getSanksi($nip) {
        $this->db->where('TM_PEGAWAI.NIP',$nip);
		
        $this->db->order_by('TH_PEGAWAI_SANKSI.ID','ASC');
        $this->db->select("TH_PEGAWAI_SANKSI.ID,TKT_HUKUMAN_DISIPLIN,JENIS_HUKDIS,ALASAN_HKMN,TO_CHAR(TMT_HKMN,'DD/MM/YYYY')||' - '||TO_CHAR(AKHIR_HKMN,'DD/MM/YYYY') AS PERIODE,DOC_SANKSI");
        $this->db->join('TM_PEGAWAI','TH_PEGAWAI_SANKSI.TMPEGAWAI_ID = TM_PEGAWAI.ID','LEFT');
		$this->db->join('TR_TKT_HUKUMAN_DISIPLIN','TR_TKT_HUKUMAN_DISIPLIN.ID=TH_PEGAWAI_SANKSI.TRTKTHUKUMANDISIPLIN_ID','LEFT');
		$this->db->join('TR_JENIS_HUKUMAN_DISIPLIN','TR_JENIS_HUKUMAN_DISIPLIN.ID=TH_PEGAWAI_SANKSI.TRJENISHUKUMANDISIPLIN_ID','LEFT');
        $query = $this->db->get('TH_PEGAWAI_SANKSI')->result_array();
        return $query;
    }
	
	public function getDataMonev($nip,$jabatan)
    {
        $where='';
        if($nip!=''){
            $where=" AND B.NIP = '".$nip."' or B.NIPNEW = '".$nip."'";
        }
        if($jabatan!=''){
            $where=" AND UPPER(A.N_JABATAN) LIKE '%".strtoupper($jabatan)."%'";
        }
        $query = $this->db->query("SELECT
                            A.TMPEGAWAI_ID AS ID,
                            A.TRJABATAN_ID AS ID_JAB,
                            A.N_JABATAN as JABATAN,
                            A.TRESELON_ID,
                            TRS.ESELON,
                            TO_CHAR(A.TMT_JABATAN,'DD-MM-YYYY') AS TMT_JABATAN,
                            B.NIP,
                            B.NIPNEW,
                            B.NAMA,
                            B.GELAR_DEPAN,
                            B.GELAR_BLKG,
                            B.FOTO,
                            B.NO_KARPEG,
                            B.SEX,
                            B.TPTLAHIR,
                            TO_CHAR(B.TGLLAHIR,'DD-MM-YYYY')AS TGLLAHIR,
                            A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5,
                            MPPV.TRTINGKATPENDIDIKAN_ID,
                            TRTP.TINGKAT_PENDIDIKAN,
                            VPM.TRGOLONGAN_ID,
                            TO_CHAR(VPM.TMT_GOL,'DD-MM-YYYY') AS TMT_GOL,
                            TRG.GOLONGAN,
                            TRG.PANGKAT,
                            -- TSO.KD_SATKER,
                            A.NMUNIT,
							TAG.AGAMA,
							TRSP.NAMA AS STATUS_KAWIN
                        FROM
                            V_PEGAWAI_JABATAN_MUTAKHIR A
                        JOIN TM_PEGAWAI B ON B.ID = A.TMPEGAWAI_ID
                        JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPM ON B.ID = VPM.TMPEGAWAI_ID
                        LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON MPPV.TMPEGAWAI_ID=B.ID 
                        LEFT JOIN TR_TINGKAT_PENDIDIKAN TRTP ON TRTP.ID=MPPV.TRTINGKATPENDIDIKAN_ID 
                        LEFT JOIN TR_GOLONGAN TRG ON (TRG.ID=VPM.TRGOLONGAN_ID) 
                        LEFT JOIN TR_ESELON TRS ON (TRS.ID=A.TRESELON_ID) 
						JOIN TR_AGAMA TAG ON B.TRAGAMA_ID = TAG.ID
						JOIN TR_STATUS_PERNIKAHAN TRSP ON B.TRSTATUSPERNIKAHAN_ID = TRSP.ID
                        WHERE 1=1 ".$where."
                        ORDER BY
                            A.TRLOKASI_ID,A.KDU1,A.KDU2,A.KDU3,A.KDU4,A.KDU5")->result_array();

        return $query;

    }

}