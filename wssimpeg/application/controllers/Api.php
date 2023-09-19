<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends REST_Controller {

public function __construct()
    {
        parent::__construct();
        $this->load->model('Simpegmodel');
        // $this->dbsimpeg = $this->load->database('dbsimpeg', TRUE);
    }


    public function test_get()
    {
        echo 'test';
    }

    public function satker2()
    {
        return array(
            array('kode'=>'414370','kdu3'=>'017','kdu4'=>'00','nama'=>'KANTOR PUSAT BADAN NASIONAL PENCARIAN DAN PERTOLONGAN'),
            array('kode'=>'414386','kdu3'=>'009','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN SURABAYA'),
            array('kode'=>'414392','kdu3'=>'002','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN MEDAN'),
            array('kode'=>'414406','kdu3'=>'003','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN PADANG'),
            array('kode'=>'414412','kdu3'=>'017','kdu4'=>'001','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN PEKANBARU'),
            array('kode'=>'414421','kdu3'=>'017','kdu4'=>'012','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN PONTIANAK'),
            array('kode'=>'414437','kdu3'=>'017','kdu4'=>'013','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN BANJARMASIN'),
            array('kode'=>'414443','kdu3'=>'015','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN BALIKPAPAN'),
            array('kode'=>'414452','kdu3'=>'012','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN MANADO'),
            array('kode'=>'414468','kdu3'=>'011','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN MAKASSAR'),
            array('kode'=>'414474','kdu3'=>'013','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN AMBON '),
            array('kode'=>'414480','kdu3'=>'010','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN DENPASAR'),
            array('kode'=>'414499','kdu3'=>'017','kdu4'=>'022','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN MERAUKE'),
            array('kode'=>'414500','kdu3'=>'014','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN BIAK'),
            array('kode'=>'414519','kdu3'=>'017','kdu4'=>'020','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN JAYAPURA'),
            array('kode'=>'414525','kdu3'=>'016','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN KUPANG'),
            array('kode'=>'414531','kdu3'=>'004','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN TANJUNG PINANG'),
            array('kode'=>'414540','kdu3'=>'017','kdu4'=>'004','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN PALEMBANG'),
            array('kode'=>'414556','kdu3'=>'017','kdu4'=>'018','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN SORONG'),
            array('kode'=>'414559','kdu3'=>'017','kdu4'=>'002','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN JAMBI'),
            array('kode'=>'414563','kdu3'=>'017','kdu4'=>'003','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN PANGKAL PINANG'),
            array('kode'=>'414566','kdu3'=>'007','kdu4'=>'017','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN BANDUNG'),
            array('kode'=>'414568','kdu3'=>'017','kdu4'=>'016','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN PALU'),
            array('kode'=>'414572','kdu3'=>'017','kdu4'=>'017','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN TERNATE'),
            array('kode'=>'414574','kdu3'=>'017','kdu4'=>'005','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN BENGKULU'),
            array('kode'=>'414576','kdu3'=>'005','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN LAMPUNG'),
            array('kode'=>'414578','kdu3'=>'017','kdu4'=>'014','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN GORONTALO'),
            array('kode'=>'414580','kdu3'=>'017','kdu4'=>'019','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN MANOKWARI'),
            array('kode'=>'414582','kdu3'=>'018','kdu4'=>'000','nama'=>'BALAI DIKLAT BADAN NASIONAL PENCARIAN DAN PERTOLONGAN'),
            array('kode'=>'414583','kdu3'=>'017','kdu4'=>'009','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN YOGYAKARTA'),
            array('kode'=>'417623','kdu3'=>'017','kdu4'=>'008','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN BANTEN'),
            array('kode'=>'417624','kdu3'=>'017','kdu4'=>'006','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN NATUNA'),
            array('kode'=>'417625','kdu3'=>'017','kdu4'=>'011','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN MAUMERE'),
            array('kode'=>'417626','kdu3'=>'017','kdu4'=>'007','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN MENTAWAI'),
            array('kode'=>'517641','kdu3'=>'006','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN JAKARTA'),
            array('kode'=>'614794','kdu3'=>'001','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN BANDA ACEH'),
            array('kode'=>'614802','kdu3'=>'008','kdu4'=>'000','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN SEMARANG'),
            array('kode'=>'614816','kdu3'=>'017','kdu4'=>'015','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN KENDARI'),
            array('kode'=>'614820','kdu3'=>'017','kdu4'=>'021','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN TIMIKA'),
            array('kode'=>'000000','kdu3'=>'000','kdu4'=>'000','nama'=>'-'),
            array('kode'=>'649924','kdu3'=>'017','kdu4'=>'010','nama'=>'KANTOR PENCARIAN DAN PERTOLONGAN MATARAM'));
    }

  
    public function satker_get()
    {
        $kdsatker='';
        if($this->input->get('kdsatker')){
            $kdsatker.=$this->input->get('kdsatker');
        }
        $data = $this->Simpegmodel->getSatker($kdsatker);
        $result=[];
        foreach ($data as $i => $value) {
                $result[$i]=$value;
                $a=str_replace(' Kelas A', '', $value['NMUNIT']);
                $b=str_replace(' Kelas B', '', $a);
                $result[$i]['NM_SATKER']=strtoupper($b);
                if ($value['KD_SATKER']==414370) {
                    $kabadan = $this->Simpegmodel->getKepalaBadan();
                    $result[$i]['NM_SATKER']='KANTOR PUSAT BADAN NASIONAL PENCARIAN DAN PERTOLONGAN';
                    $result[$i]['GELAR_DPN']=$kabadan[0]['GELAR_DEPAN'];
                    $result[$i]['NAMA']=$kabadan[0]['NAMA'];
                    $result[$i]['GELAR_BLKG']=$kabadan[0]['GELAR_BLKG'];
                }
        }

        $this->response($result);
    }

     public function satkerApi()
    {
        $kdsatker='';
        $data = $this->Simpegmodel->getSatker2();
        $result=[];
        foreach ($data as $i => $value) {
                $result[$i]=$value;
                $a=str_replace(' Kelas A', '', $value['NMUNIT']);
                $b=str_replace(' Kelas B', '', $a);
                $result[$i]['NM_SATKER']=strtoupper($b);
        }

        return $result;
    }



    public function pegawai_get()
    {
        $nip='';
        $jabatan='';
        if($this->input->get('nip')){
            $nip.=$this->input->get('nip');
        }
         if($this->input->get('jabatan')){
            $jabatan.=$this->input->get('jabatan');
        }
        $data = $this->Simpegmodel->getDataMain($nip,$jabatan);

        // echo "<pre>";
         // print_r($data);
        $result=[];
        // if($this->input->get('satker')){
            foreach ($data as $i => $value) {
                $result[$i]['ID_PEGAWAI']= $value['ID'];
                $result[$i]['ID_ESELON']= $value['TRESELON_ID'];
                $result[$i]['ESELON']= $value['ESELON'];
                $result[$i]['NIP']= $value['NIP'];
                $result[$i]['NIPBARU']= $value['NIPNEW'];
                $result[$i]['NAMA']= $value['NAMA'];
                $result[$i]['GELAR_DEPAN']= $value['GELAR_DEPAN'];
                $result[$i]['GELAR_BLKG']= $value['GELAR_BLKG'];
                $result[$i]['ALAMAT']= $value['ALAMAT'];
                $result[$i]['RT']= $value['RT'];
                $result[$i]['RW']= $value['RW'];
                $result[$i]['KELURAHAN']= $value['KELURAHAN'];
                $result[$i]['KECAMATAN']= $value['KECAMATAN'];
                $result[$i]['KABUPATEN']= $value['KABUPATEN'];
                $result[$i]['PROPINSI']= $value['PROPINSI'];
                $result[$i]['TELP_RMH']= $value['TELP_RMH'];
                $result[$i]['TELP_HP']= $value['TELP_HP'];
                $result[$i]['NO_KARPEG']= $value['NO_KARPEG'];
                $result[$i]['JNS_KELAMIN']= $value['SEX'];
                $result[$i]['TINGGI_BADAN']= $value['TINGGI_BADAN'];
                $result[$i]['BERAT_BADAN']= $value['BERAT_BADAN'];
                $result[$i]['TEMPAT_LAHIR']= $value['TPTLAHIR'];
                $result[$i]['TGL_LAHIR']= $value['TGLLAHIR'];
                $result[$i]['ID_GOLONGAN']= $value['TRGOLONGAN_ID'];
                $result[$i]['GOLONGAN']= $value['GOLONGAN'];
                $result[$i]['PANGKAT']= $value['PANGKAT'];
                $result[$i]['TMT_GOL']= $value['TMT_GOL'];
                $result[$i]['ID_PENDIDIKAN']= $value['TRTINGKATPENDIDIKAN_ID'];
                $result[$i]['TNGKT_PENDIDIKAN']= $value['TINGKAT_PENDIDIKAN'];
                $result[$i]['ID_JABATAN']= $value['ID_JAB'];
                $result[$i]['JABATAN']= $value['JABATAN'];
                $result[$i]['TMT_JABATAN']= $value['TMT_JABATAN'];
                $result[$i]['FOTO']='';
                $result[$i]['KD_SATKER']='';
                $result[$i]['NAMA_SATKER']='';
                $result[$i]['KD_LOK']=$value['TRLOKASI_ID'];
                $result[$i]['KDU1']=$value['KDU1'];
                $result[$i]['KDU2']=$value['KDU2'];
                $result[$i]['KDU3']=$value['KDU3'];
                $result[$i]['KDU4']=$value['KDU4'];
                $result[$i]['KDU5']=$value['KDU5'];

                if($value['FOTO']){
                    $result[$i]['FOTO'].= 'https://simpeg.basarnas.go.id/_uploads/photo_pegawai/thumbs/'.$value['FOTO'];
                }

                $result[$i]['NMUNIT']= $value['NMUNIT'];


            }


            foreach ($result as $r => $re) {
                foreach ($this->satkerApi() as $t => $val) {
                    if(($re['KD_LOK']=='2')or($re['KD_LOK']=='')){  
                        $result[$r]['KD_SATKER']='414370';
                        $result[$r]['NAMA_SATKER']='KANTOR PUSAT BADAN NASIONAL PENCARIAN DAN PERTOLONGAN';
                    }else{
                        if($re['KDU3']!='017'){
                            if($re['KDU3']==$val['KDU3']){
                                $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                                $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                            }
                        }else if($re['KDU3']=='017'){
                            if($re['KDU4']==$val['KDU4']){
                                $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                                $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                            }
                        }else{
                            $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                            $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                        }
                    }
                    // echo '<br>';
                }
            }

            // print_r($result);
        
        $no=0;
        $hasil=[];
        if($this->input->get('satker')){
            foreach ($result as $j => $row) {
                if($row['KD_SATKER']==$this->input->get('satker')){
                    $hasil[$no]=$row++;
                    $no++;
                }
            }
        }

        if($this->input->get('satker')){
            $this->response($hasil);
        }else{
            $this->response($result);
        }
    }

    public function rescuer_get()
    {
        $param=$this->input->get('naik');
        $data = $this->Simpegmodel->getDataMain2($param);
        // echo "<pre>";
         // print_r($data);
        $result=[];
        foreach ($data as $i => $value) {
            $result[$i]['ID_PEGAWAI']= $value['ID'];
            $result[$i]['NIP']= $value['NIP'];
            $result[$i]['NIPBARU']= $value['NIPNEW'];
            $result[$i]['NAMA']= $value['NAMA'];
            $result[$i]['GELAR_DEPAN']= $value['GELAR_DEPAN'];
            $result[$i]['GELAR_BLKG']= $value['GELAR_BLKG'];
            $result[$i]['ALAMAT']= $value['ALAMAT'];
            $result[$i]['RT']= $value['RT'];
            $result[$i]['RW']= $value['RW'];
            $result[$i]['KELURAHAN']= $value['KELURAHAN'];
            $result[$i]['KECAMATAN']= $value['KECAMATAN'];
            $result[$i]['KABUPATEN']= $value['KABUPATEN'];
            $result[$i]['PROPINSI']= $value['PROPINSI'];
            $result[$i]['TELP_RMH']= $value['TELP_RMH'];
            $result[$i]['TELP_HP']= $value['TELP_HP'];
            $result[$i]['NO_KARPEG']= $value['NO_KARPEG'];
            $result[$i]['JNS_KELAMIN']= $value['SEX'];
            $result[$i]['TINGGI_BADAN']= $value['TINGGI_BADAN'];
            $result[$i]['BERAT_BADAN']= $value['BERAT_BADAN'];
            $result[$i]['JNS_KELAMIN']= $value['SEX'];
            $result[$i]['TEMPAT_LAHIR']= $value['TPTLAHIR'];
            $result[$i]['TGL_LAHIR']= $value['TGLLAHIR'];
            $result[$i]['ID_GOLONGAN']= $value['TRGOLONGAN_ID'];
            $result[$i]['GOLONGAN']= $value['GOLONGAN'];
            $result[$i]['PANGKAT']= $value['PANGKAT'];
            $result[$i]['TMT_GOL']= $value['TMT_GOL'];
            $result[$i]['ID_PENDIDIKAN']= $value['TRTINGKATPENDIDIKAN_ID'];
            $result[$i]['TNGKT_PENDIDIKAN']= $value['TINGKAT_PENDIDIKAN'];
            $result[$i]['ID_JABATAN']= $value['ID_JAB'];
            $result[$i]['JABATAN']= $value['JABATAN'];
            $result[$i]['TMT_JABATAN']= $value['TMT_JABATAN'];
            $result[$i]['TRLOKASI_ID']= $value['TRLOKASI_ID'];
            // $foto = '/var/www/html/simpeg/_uploads/photo_pegawai/thumbs/';
            // $foto = $_SERVER['DOCUMENT_ROOT']."/simpeg/_uploads/photo_pegawai/thumbs/";
            // $foto = '/var/www/basarnas.go.id/simpeg/public_html/_uploads/photo_pegawai/thumbs/';
            $result[$i]['FOTO']= $value['FOTO'];
            if($value['TRLOKASI_ID']==2){
                $result[$i]['KD_SATKER']='414370';
                $result[$i]['NAMA_SATKER']='KANTOR PUSAT BADAN NASIONAL PENCARIAN DAN PERTOLONGAN';
            }else {
                foreach ($this->satkerApi() as $j => $row) {
                     if(($value['KDU3']==$row['KDU3'])&& ($value['KDU3']!='017')){
                        $result[$i]['KD_SATKER']=$row['KD_SATKER'];
                        $result[$i]['NAMA_SATKER']=$row['NM_SATKER'];
                        // echo "<pre>";
                        // echo $result[$i]['KD_SATKER'];
                    }else if(($value['KDU3']=='017')&&($value['KDU4']==$row['KDU4'])){
                         $result[$i]['KD_SATKER']=$row['KD_SATKER'];
                         $result[$i]['NAMA_SATKER']=$row['NM_SATKER'];
                    }
                }
               
            }
            $result[$i]['NMUNIT']= $value['NMUNIT'];
        }



        $this->response($result);
    }

    public function rescuerall_get()
    {
        $param=$this->input->get('naik');
        $data = $this->Simpegmodel->getDataMainRescuerAll($param);
        // echo "<pre>";
         // print_r($data);
        $result=[];
        foreach ($data as $i => $value) {
            $result[$i]['ID_PEGAWAI']= $value['ID'];
            $result[$i]['NIP']= $value['NIP'];
            $result[$i]['NIPBARU']= $value['NIPNEW'];
            $result[$i]['NAMA']= $value['NAMA'];
            $result[$i]['GELAR_DEPAN']= $value['GELAR_DEPAN'];
            $result[$i]['GELAR_BLKG']= $value['GELAR_BLKG'];
            $result[$i]['ALAMAT']= $value['ALAMAT'];
            $result[$i]['RT']= $value['RT'];
            $result[$i]['RW']= $value['RW'];
            $result[$i]['KELURAHAN']= $value['KELURAHAN'];
            $result[$i]['KECAMATAN']= $value['KECAMATAN'];
            $result[$i]['KABUPATEN']= $value['KABUPATEN'];
            $result[$i]['PROPINSI']= $value['PROPINSI'];
            $result[$i]['TELP_RMH']= $value['TELP_RMH'];
            $result[$i]['TELP_HP']= $value['TELP_HP'];
            $result[$i]['NO_KARPEG']= $value['NO_KARPEG'];
            $result[$i]['JNS_KELAMIN']= $value['SEX'];
            $result[$i]['TINGGI_BADAN']= $value['TINGGI_BADAN'];
            $result[$i]['BERAT_BADAN']= $value['BERAT_BADAN'];
            $result[$i]['JNS_KELAMIN']= $value['SEX'];
            $result[$i]['TEMPAT_LAHIR']= $value['TPTLAHIR'];
            $result[$i]['TGL_LAHIR']= $value['TGLLAHIR'];
            $result[$i]['ID_GOLONGAN']= $value['TRGOLONGAN_ID'];
            $result[$i]['GOLONGAN']= $value['GOLONGAN'];
            $result[$i]['PANGKAT']= $value['PANGKAT'];
            $result[$i]['TMT_GOL']= $value['TMT_GOL'];
            $result[$i]['ID_PENDIDIKAN']= $value['TRTINGKATPENDIDIKAN_ID'];
            $result[$i]['TNGKT_PENDIDIKAN']= $value['TINGKAT_PENDIDIKAN'];
            $result[$i]['ID_JABATAN']= $value['ID_JAB'];
            $result[$i]['JABATAN']= $value['JABATAN'];
            $result[$i]['TMT_JABATAN']= $value['TMT_JABATAN'];
            // $foto = '/var/www/html/simpeg/_uploads/photo_pegawai/thumbs/';
            // $foto = $_SERVER['DOCUMENT_ROOT']."/simpeg/_uploads/photo_pegawai/thumbs/";
            // $foto = '/var/www/basarnas.go.id/simpeg/public_html/_uploads/photo_pegawai/thumbs/';
            $result[$i]['FOTO']= $value['FOTO'];
            if($value['TRLOKASI_ID']==2){
                $result[$i]['KD_SATKER']='414370';
            }else {
                foreach ($this->satkerApi() as $j => $row) {
                     if(($value['KDU3']==$row['KDU3'])&& ($value['KDU3']!='017')){
                        $result[$i]['KD_SATKER']=$row['KD_SATKER'];
                        $result[$i]['NAMA_SATKER']=$row['NM_SATKER'];
                        // echo "<pre>";
                        // echo $result[$i]['KD_SATKER'];
                    }else if(($value['KDU3']=='017')&&($value['KDU4']==$row['KDU4'])){
                         $result[$i]['KD_SATKER']=$row['KD_SATKER'];
                         $result[$i]['NAMA_SATKER']=$row['NM_SATKER'];
                    }
                }
               
            }
            $result[$i]['NMUNIT']= $value['NMUNIT'];
        }



        $this->response($result);
    }

    public function pgw_diklat_get()
    {
        $nip=0;
        if($this->input->get('nip')){
            $nip = $this->input->get('nip');
        }
        $data = $this->Simpegmodel->getDataSingle($nip);
        $this->response($data);
    }


    // public function rescuer_get()
    // {
        
    //     $data = $this->Simpegmodel->getDataMain2();
    //     // print_r(count($data));
    //     $result=[];
    //     foreach ($data as $i => $value) {
    //         $result[$i]['ID_PEGAWAI']= $value['ID'];
    //         $result[$i]['NIP']= $value['NIP'];
    //         $result[$i]['NIPBARU']= $value['NIPNEW'];
    //         $result[$i]['NAMA']= $value['GELAR_DEPAN'].$value['NAMA'].' '.$value['GELAR_BLKG'];
    //         $result[$i]['NO_KARPEG']= $value['NO_KARPEG'];
    //         $result[$i]['JNS_KELAMIN']= $value['SEX'];
            
    //         $result[$i]['ID_GOLONGAN']= '';
    //         $result[$i]['GOLONGAN']= '';
    //         $result[$i]['PANGKAT']= '';
    //         $result[$i]['ID_PENDIDIKAN']= '';
    //         $result[$i]['TNGKT_PENDIDIKAN']= '';
    //         $result[$i]['ID_JABATAN']= '';
    //         $result[$i]['JABATAN']= '';
    //         $pangkat = $this->Simpegmodel->getPangkat($value['ID']);
    //         // print_r($pangkat);
    //         if($pangkat){
    //             $result[$i]['ID_GOLONGAN'].= $pangkat->TRGOLONGAN_ID;
    //             $result[$i]['GOLONGAN'].= $pangkat->GOLONGAN;
    //             $result[$i]['PANGKAT'].= $pangkat->PANGKAT;
    //         }

    //         $pendidikan = $this->Simpegmodel->getPendidikan($value['ID']);
    //         if($pendidikan){
    //             $result[$i]['ID_PENDIDIKAN'].= $pendidikan->ID_PENDIDIKAN;
    //             $result[$i]['TNGKT_PENDIDIKAN'].= $pendidikan->KETERANGAN;
    //         }

    //         $jabatan = $this->Simpegmodel->getJabatan($value['ID']);
    //         if($jabatan){
    //             $result[$i]['ID_JABATAN'].= $jabatan->TRJABATAN_ID;
    //             $result[$i]['JABATAN'].= $jabatan->N_JABATAN;
    //         }

    //         $diklatteknis = $this->Simpegmodel->getDiklatTeknis($value['ID']); 
    //         if(sizeof($diklatteknis)>0){
    //             foreach ($diklatteknis as $j => $md) {
    //                 $result[$i]['DIKLAT_TEKNIS'][$j] = $md;
    //             }   
    //         }else {
    //             $result[$i]['DIKLAT_TEKNIS']='';
    //         }

    //         $diklatfungsional = $this->Simpegmodel->getDiklatFungsional($value['ID']); 
    //         if(sizeof($diklatfungsional)>0){
    //             foreach ($diklatfungsional as $j => $md) {
    //                 $result[$i]['DIKLAT_FUNGSIONAL'][$j] = $md;
    //             }   
    //         }else {
    //             $result[$i]['DIKLAT_FUNGSIONAL']='';
    //         }

    //         $diklatpenjenjangan = $this->Simpegmodel->getDiklatPenjenjangan($value['ID']); 
    //         if(sizeof($diklatpenjenjangan)>0){
    //             foreach ($diklatpenjenjangan as $j => $md) {
    //                 $result[$i]['DIKLAT_PENJENJANGAN'][$j] = $md;
    //             }   
    //         }else {
    //             $result[$i]['DIKLAT_PENJENJANGAN']='';
    //         }

    //         $diklatPrajabatan = $this->Simpegmodel->getDiklatPrajabatan($value['ID']); 
    //         if(sizeof($diklatPrajabatan)>0){
    //             foreach ($diklatPrajabatan as $j => $md) {
    //                 $result[$i]['DIKLAT_PRAJABATAN'][$j] = $md;
    //             }   
    //         }else {
    //             $result[$i]['DIKLAT_PRAJABATAN']='';
    //         }

    //         $diklatLain = $this->Simpegmodel->getDiklatLain($value['ID']); 
    //         if(sizeof($diklatLain)>0){
    //             foreach ($diklatLain as $j => $md) {
    //                 $result[$i]['DIKLAT_LAIN'][$j] = $md;
    //             }   
    //         }else {
    //             $result[$i]['DIKLAT_LAIN']='';
    //         }
    //     }
    //         // print_r($result[0]['TNGKT_PENDIDIKAN']);


    //     $this->response($result);
    // }


    public function jabatan_get()
    {
        // $data=[];
        $data['TR_JABATAN.JABATAN']=$this->input->get('jabatan');
        $data['TR_JABATAN.ID']=$this->input->get('id_jabatan');
        $data['TR_ESELON.ESELON']=$this->input->get('eselon');

        $param=array();
        foreach($data as $i=>$value){
            if($data[$i]!=null){
                $param[$i]=$value;
            }
        }
        $query = $this->Simpegmodel->getMasterJabatan($param);
        $this->response($query);
    }

    public function unitkerja_get()
    {
        $query1 = $this->Simpegmodel->getUnit1();
        $query2 = $this->Simpegmodel->getUnit2();
        $query3 = $this->Simpegmodel->getUnit3();
        $this->response($query);
    }

    public function golongan_get()
    {
        $query = $this->Simpegmodel->getMasterGolongan();
        $this->response($query);
    }

    public function pendidikan_get()
    {
        $query = $this->Simpegmodel->getMasterPendidikan();
        $this->response($query);
    }

    public function diklat_teknis_get()
    {
        $query = $this->Simpegmodel->getMasterDiklatTeknis();
        $this->response($query);
    }

    public function diklat_fungsional_get()
    {
        $query = $this->Simpegmodel->getMasterDiklatFungsional();
        $this->response($query);
    }

    public function kel_fungsional_get()
    {
        $query = $this->Simpegmodel->getMasterkelFungsional();
        $this->response($query);
    }

    public function diklat_pim_get()
    {
        $query = $this->Simpegmodel->getMasterDiklatPenjenjangan();
        $this->response($query);
    }


    public function pegawai22_get($jabatan)
    {
        $nip='';
        if($this->input->get('nip')){
            $nip.=$this->input->get('nip');
        }
        $data = $this->Simpegmodel->getDataMain($nip,$jabatan);
        // echo "<pre>";
         // print_r($data);
        $result=[];
        // if($this->input->get('satker')){
            foreach ($data as $i => $value) {
                $result[$i]['ID_PEGAWAI']= $value['ID'];
                $result[$i]['NIP']= $value['NIP'];
                $result[$i]['NIPBARU']= $value['NIPNEW'];
                $result[$i]['NAMA']= $value['NAMA'];
                $result[$i]['GELAR_DEPAN']= $value['GELAR_DEPAN'];
                $result[$i]['GELAR_BLKG']= $value['GELAR_BLKG'];
                $result[$i]['ALAMAT']= $value['ALAMAT'];
                $result[$i]['RT']= $value['RT'];
                $result[$i]['RW']= $value['RW'];
                $result[$i]['KELURAHAN']= $value['KELURAHAN'];
                $result[$i]['KECAMATAN']= $value['KECAMATAN'];
                $result[$i]['KABUPATEN']= $value['KABUPATEN'];
                $result[$i]['PROPINSI']= $value['PROPINSI'];
                $result[$i]['TELP_RMH']= $value['TELP_RMH'];
                $result[$i]['TELP_HP']= $value['TELP_HP'];
                $result[$i]['NO_KARPEG']= $value['NO_KARPEG'];
                $result[$i]['JNS_KELAMIN']= $value['SEX'];
                $result[$i]['TINGGI_BADAN']= $value['TINGGI_BADAN'];
                $result[$i]['BERAT_BADAN']= $value['BERAT_BADAN'];
                $result[$i]['TEMPAT_LAHIR']= $value['TPTLAHIR'];
                $result[$i]['TGL_LAHIR']= $value['TGLLAHIR'];
                $result[$i]['ID_GOLONGAN']= $value['TRGOLONGAN_ID'];
                $result[$i]['GOLONGAN']= $value['GOLONGAN'];
                $result[$i]['PANGKAT']= $value['PANGKAT'];
                $result[$i]['ID_PENDIDIKAN']= $value['TRTINGKATPENDIDIKAN_ID'];
                $result[$i]['TNGKT_PENDIDIKAN']= $value['TINGKAT_PENDIDIKAN'];
                $result[$i]['ID_JABATAN']= $value['ID_JAB'];
                $result[$i]['JABATAN']= $value['JABATAN'];
                $result[$i]['FOTO']='';
                $result[$i]['KD_SATKER']='';
                $result[$i]['NAMA_SATKER']='';
                $result[$i]['KD_LOK']=$value['TRLOKASI_ID'];
                $result[$i]['KDU1']=$value['KDU1'];
                $result[$i]['KDU2']=$value['KDU2'];
                $result[$i]['KDU3']=$value['KDU3'];
                $result[$i]['KDU4']=$value['KDU4'];
                $result[$i]['KDU5']=$value['KDU5'];

                if($value['FOTO']){
                    $result[$i]['FOTO'].= 'https://simpeg.basarnas.go.id/_uploads/photo_pegawai/thumbs/'.$value['FOTO'];
                }

                $result[$i]['NMUNIT']= $value['NMUNIT'];


            }


            foreach ($result as $r => $re) {
                foreach ($this->satkerApi() as $t => $val) {
                    if(($re['KD_LOK']=='2')or($re['KD_LOK']=='')){  
                        $result[$r]['KD_SATKER']='414370';
                        $result[$r]['NAMA_SATKER']='KANTOR PUSAT BADAN NASIONAL PENCARIAN DAN PERTOLONGAN';
                    }else{
                        if($re['KDU3']!='017'){
                            if($re['KDU3']==$val['KDU3']){
                                $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                                $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                            }
                        }else if($re['KDU3']=='017'){
                            if($re['KDU4']==$val['KDU4']){
                                $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                                $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                            }
                        }else{
                            $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                            $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                        }
                    }
                    // echo '<br>';
                }
            }

        return $result;
    }


    public function unor_get()
    {
        $jabatan='';
        if($this->input->get('jabatan')){
            $jabatan.=$this->input->get('jabatan');
        }
        $isi = $this->pegawai22_get($jabatan);
        $temp=array();

        // $kdlok = $this->input->get('lok');
        // $kdu1 = $this->input->get('kdu1');
        // $kdu2 = $this->input->get('kdu2');
        // $kdu3 = $this->input->get('kdu3');
        // $kdu4 = $this->input->get('kdu4');
        // $kdu5 = $this->input->get('kdu5');

        foreach ($isi as $j => $val) {
                $jab1= explode(',', $val['JABATAN']);
                if (!empty($jab1)) {
                    $jab=$jab1[0];
                }else{
                    $jab='';
                }
                if (sizeof($jab1)>1) {
                    $unit=$jab1[1];
                }else{
                    $unit='';
                }

                if(sizeof($temp)==0){
                    array_push($temp, array('KDU1'=>$val['KDU1'],
                                            'KDU2'=>$val['KDU2'],
                                            'KDU3'=>$val['KDU3'],
                                            'KDU4'=>$val['KDU4'],
                                            'KDU5'=>$val['KDU5'],
                                            'KD_LOK'=>$val['KD_LOK'],
                                            'KD_SATKER'=>$val['KD_SATKER'],
                                            'JAB'=>$jab,
                                            'UNIT'=>$unit,
                                            ));                             
                
                }else if(!$this->checkdata($val['KDU1'],$val['KDU2'],$val['KDU3'],$val['KDU4'],$val['KDU5'],$val['KD_LOK'],strtoupper($jab),$temp)){
                    array_push($temp, array('KDU1'=>$val['KDU1'],
                                            'KDU2'=>$val['KDU2'],
                                            'KDU3'=>$val['KDU3'],
                                            'KDU4'=>$val['KDU4'],
                                            'KDU5'=>$val['KDU5'],
                                            'KD_LOK'=>$val['KD_LOK'],
                                            'KD_SATKER'=>$val['KD_SATKER'],
                                            'JAB'=>$jab,
                                            'UNIT'=>$unit,
                                            ));                             
                }else{}
        }

        // $no=0;
        // $hasil=[];
        //     foreach ($temp as $j => $row) {
        //         if(($row['KDU1']==$kdu1)and($row['KDU3']==$kdu3)and($row['KDU2']==$kdu2)and($row['KDU4']==$kdu4)and($row['KDU5']==$kdu5)and($row['KD_LOK']==$kdlok)){
        //             $hasil[$no]=$row++;
        //             $no++;
        //         }
        //     }

        $this->response($temp);
        
    }

    public function checkdata($kdu1,$kdu2,$kdu3,$kdu4,$kdu5,$lok,$jab,$table)
    {
        $check = false;
        foreach ($table as $i => $value) {
            if(($kdu1==$value['KDU1'])and($kdu2==$value['KDU2'])and($kdu3==$value['KDU3'])and($kdu4==$value['KDU4'])and($kdu5==$value['KDU5'])and(strtoupper($jab)==strtoupper($value['JAB']))and($lok==$value['KD_LOK'])){
                $check = true;
            }
        }
        return $check;
    }

    public function monitoring_pensiun_get()
    {
        $nip='';
        $bln='';
        $thn='';
        $pendidikan='';
        $pangkat='';
        $jenjang='';
        if($this->input->get('nip')){
            $nip.=$this->input->get('nip');
        }
        if($this->input->get('bulan')){
            $bln.=$this->input->get('bulan');
        }
        if($this->input->get('tahun')){
            $thn.=$this->input->get('tahun');
        }
        if($this->input->get('pendidikan')){
            $pendidikan.=$this->input->get('pendidikan');
        }
        if($this->input->get('pangkat')){
            $pangkat.=$this->input->get('pangkat');
        }
        if($this->input->get('jenjang')){
            $jenjang.=$this->input->get('jenjang');
        }
        $data = $this->Simpegmodel->getpensiun($nip,$bln,$thn,$pendidikan,$pangkat,$jenjang);
        $result=[];
        foreach ($data as $j => $value) {
            $result[$j]=$value;
            $result[$j]['N_JABATAN']=$value['JABATAN'];
            $result[$j]['GOLONGAN_RUANG']=$value['GOLONGAN'];
            $result[$j]['TMT_JABATAN']=date('d-m-Y',strtotime($value['TMT_JABATAN']));
            $result[$j]['TMT_PENSIUN']=date('d-m-Y',strtotime($value['TMT_PENSIUN']));
        }

        foreach ($result as $r => $re) {
            foreach ($this->satkerApi() as $t => $val) {
                if(($re['TRLOKASI_ID']=='2')or($re['TRLOKASI_ID']=='')){  
                    $result[$r]['KD_SATKER']='414370';
                    $result[$r]['NAMA_SATKER']='KANTOR PUSAT BADAN NASIONAL PENCARIAN DAN PERTOLONGAN';
                }else{
                    if($re['KDU3']!='017'){
                        if($re['KDU3']==$val['KDU3']){
                            $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                            $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                        }
                    }else if($re['KDU3']=='017'){
                        if($re['KDU4']==$val['KDU4']){
                            $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                            $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                        }
                    }else{
                        $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                        $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                    }
                }
            }
        }

            // print_r($result);
        
        $no=0;
        $hasil=[];
        if($this->input->get('satker')){
            foreach ($result as $k => $row) {
                if($row['KD_SATKER']==$this->input->get('satker')){
                    $hasil[$no]=$row++;
                    $no++;
                }
            }
        }

        if($this->input->get('satker')){
            $this->response($hasil);
        }else{
            $this->response($result);
        }
    }

    public function monitoring_fungsional_get()
    {
        $nip='';
        $bln='';
        $thn='';
        $pangkat='';
        $jenjang='';
        if($this->input->get('nip')){
            $nip.=$this->input->get('nip');
        }
        if($this->input->get('bulan')){
            $bln.=$this->input->get('bulan');
        }
        if($this->input->get('tahun')){
            $thn.=$this->input->get('tahun');
        }
        if($this->input->get('pangkat')){
            $pangkat.=$this->input->get('pangkat');
            // print_r($pangkat);
        }
        if($this->input->get('jenjang')){
            $jenjang.=$this->input->get('jenjang');
        }
        $data = $this->Simpegmodel->getfungsional($nip,$bln,$thn,$pangkat,$jenjang);
        $result=[];
        foreach ($data as $j => $value) {
            $result[$j]=$value;
            $result[$j]['TMT_JABATAN']=date('d-m-Y',strtotime($value['TMT_JABATAN']));
            // $result[$j]['TMT_PENSIUN']=date('d-m-Y',strtotime($value['TMT_PENSIUN']));
        }

        foreach ($result as $r => $re) {
            foreach ($this->satkerApi() as $t => $val) {
                if(($re['TRLOKASI_ID']=='2')or($re['TRLOKASI_ID']=='')){  
                    $result[$r]['KD_SATKER']='414370';
                    $result[$r]['NAMA_SATKER']='KANTOR PUSAT BADAN NASIONAL PENCARIAN DAN PERTOLONGAN';
                }else{
                    if($re['KDU3']!='017'){
                        if($re['KDU3']==$val['KDU3']){
                            $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                            $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                        }
                    }else if($re['KDU3']=='017'){
                        if($re['KDU4']==$val['KDU4']){
                            $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                            $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                        }
                    }else{
                        $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                        $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                    }
                }
            }
        }

            // print_r($result);
        
        $no=0;
        $hasil=[];
        if($this->input->get('satker')){
            foreach ($result as $k => $row) {
                if($row['KD_SATKER']==$this->input->get('satker')){
                    $hasil[$no]=$row++;
                    $no++;
                }
            }
        }

        if($this->input->get('satker')){
            $this->response($hasil);
        }else{
            $this->response($result);
        }
    }


    public function monitoring_ak_get()
    {
        $nip='';
        $akmin='';
        $aknow='';
        $pangkat='';
        if($this->input->get('nip')){
            $nip.=$this->input->get('nip');
        }
        if($this->input->get('akminimal')){
            $akmin.=$this->input->get('akminimal');
        }
        if($this->input->get('aknow')){
            $aknow.=$this->input->get('aknow');
        }
        if($this->input->get('pangkat')){
            $pangkat.=$this->input->get('pangkat');
        }
        $data = $this->Simpegmodel->getak($nip,$pangkat,$akmin,$aknow);
        $result=[];
        foreach ($data as $j => $value) {
            $result[$j]=$value;
            // $result[$j]['AK_SAAT_INI']=$value['AK_SAAT_INI']!=''?$value['AK_SAAT_INI']:0;
            // $result[$j]['TMT_PENSIUN']=date('d-m-Y',strtotime($value['TMT_PENSIUN']));
        }

        foreach ($result as $r => $re) {
            foreach ($this->satkerApi() as $t => $val) {
                if(($re['TRLOKASI_ID']=='2')or($re['TRLOKASI_ID']=='')){  
                    $result[$r]['KD_SATKER']='414370';
                    $result[$r]['NAMA_SATKER']='KANTOR PUSAT BADAN NASIONAL PENCARIAN DAN PERTOLONGAN';
                }else{
                    if($re['KDU3']!='017'){
                        if($re['KDU3']==$val['KDU3']){
                            $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                            $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                        }
                    }else if($re['KDU3']=='017'){
                        if($re['KDU4']==$val['KDU4']){
                            $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                            $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                        }
                    }else{
                        $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                        $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                    }
                }
            }
        }

            // print_r($result);
        
        $no=0;
        $hasil=[];
        if($this->input->get('satker')){
            foreach ($result as $k => $row) {
                if($row['KD_SATKER']==$this->input->get('satker')){
                    $hasil[$no]=$row++;
                    $no++;
                }
            }
        }

        if($this->input->get('satker')){
            $this->response($hasil);
        }else{
            $this->response($result);
        }
    }


    public function monitoring_kp_get()
    {
        $nip='';
        $pendidikan='';
        $bln='';
        $tahun='';
        if($this->input->get('nip')){
            $nip.=$this->input->get('nip');
        }
        if($this->input->get('pendidikan')){
            $pendidikan.=$this->input->get('pendidikan');
        }
        if($this->input->get('bulan')){
            $bln.=$this->input->get('bulan');
        }
        if($this->input->get('tahun')){
            $tahun.=$this->input->get('tahun');
        }
        $data = $this->Simpegmodel->getkenaikanpangkat($nip,$bln,$tahun,$pendidikan);
        $result=[];
        foreach ($data as $j => $value) {
            $result[$j]=$value;
            // $result[$j]['AK_SAAT_INI']=$value['AK_SAAT_INI']!=''?$value['AK_SAAT_INI']:0;
            // $result[$j]['TMT_PENSIUN']=date('d-m-Y',strtotime($value['TMT_PENSIUN']));
        }

        foreach ($result as $r => $re) {
            foreach ($this->satkerApi() as $t => $val) {
                if(($re['TRLOKASI_ID']=='2')or($re['TRLOKASI_ID']=='')){  
                    $result[$r]['KD_SATKER']='414370';
                    $result[$r]['NAMA_SATKER']='KANTOR PUSAT BADAN NASIONAL PENCARIAN DAN PERTOLONGAN';
                }else{
                    if($re['KDU3']!='017'){
                        if($re['KDU3']==$val['KDU3']){
                            $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                            $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                        }
                    }else if($re['KDU3']=='017'){
                        if($re['KDU4']==$val['KDU4']){
                            $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                            $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                        }
                    }else{
                        $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                        $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                    }
                }
            }
        }

            // print_r($result);
        
        $no=0;
        $hasil=[];
        if($this->input->get('satker')){
            foreach ($result as $k => $row) {
                if($row['KD_SATKER']==$this->input->get('satker')){
                    $hasil[$no]=$row++;
                    $no++;
                }
            }
        }

        if($this->input->get('satker')){
            $this->response($hasil);
        }else{
            $this->response($result);
        }
    }

    public function eselon_get()
    {
        $id=$this->input->get('id');
        $data = $this->Simpegmodel->getEselon($id);
        $this->response($data);
    }


    function pegawai_single_get() {

        $nip = $this->input->get('nip');
        $query = $this->Simpegmodel->get_data_single($nip);
        // $join = array('foto' => 'test') + $query;
        
        $this->response($query);
    }

     public function pegawai_unitkerja_get() {

        $lok = $this->input->get('lok');
        $kdu1 = $this->input->get('kdu1');
        $kdu2 = $this->input->get('kdu2');
        $kdu3 = $this->input->get('kdu3');
        $kdu4 = $this->input->get('kdu4');
        $kdu5 = $this->input->get('kdu5');
        $tkt_eselon = $this->input->get('tkt_eselon');
        $kel_fungsional = $this->input->get('kel_fungsional');
        $query = $this->Simpegmodel->get_pegawai_unitkerja($lok, $kdu1, $kdu2, $kdu3, $kdu4, $kdu5, $tkt_eselon, $kel_fungsional);
        $this->response($query);
    }
	
	public function pegawai_penghargaan_get()
    {
        $nip=0;
        if($this->input->get('nip')){
            $nip = $this->input->get('nip');
        }
        $data = $this->Simpegmodel->getPenghargaan($nip);
        $this->response($data);
    }
	
	public function pegawai_sanksi_get()
    {
        $nip=0;
        if($this->input->get('nip')){
            $nip = $this->input->get('nip');
        }
        $data = $this->Simpegmodel->getSanksi($nip);
        $this->response($data);
    }
	
	public function pegawaimonev_get()
    {
        $nip='';
        $jabatan='';
        if($this->input->get('nip')){
            $nip.=$this->input->get('nip');
        }
         if($this->input->get('jabatan')){
            $jabatan.=$this->input->get('jabatan');
        }
        $data = $this->Simpegmodel->getDataMonev($nip,$jabatan);

        // echo "<pre>";
         // print_r($data);
        $result=[];
        // if($this->input->get('satker')){
            foreach ($data as $i => $value) {
                $result[$i]['ID_PEGAWAI']= $value['ID'];
                $result[$i]['ID_ESELON']= $value['TRESELON_ID'];
                $result[$i]['ESELON']= $value['ESELON'];
                $result[$i]['NIP']= $value['NIP'];
                $result[$i]['NIPBARU']= $value['NIPNEW'];
                $result[$i]['NAMA']= $value['NAMA'];
                $result[$i]['GELAR_DEPAN']= $value['GELAR_DEPAN'];
                $result[$i]['GELAR_BLKG']= $value['GELAR_BLKG'];               
                $result[$i]['NO_KARPEG']= $value['NO_KARPEG'];
                $result[$i]['JNS_KELAMIN']= $value['SEX'];
                $result[$i]['TEMPAT_LAHIR']= $value['TPTLAHIR'];
                $result[$i]['TGL_LAHIR']= $value['TGLLAHIR'];
                $result[$i]['ID_GOLONGAN']= $value['TRGOLONGAN_ID'];
                $result[$i]['GOLONGAN']= $value['GOLONGAN'];
                $result[$i]['PANGKAT']= $value['PANGKAT'];
                $result[$i]['TMT_GOL']= $value['TMT_GOL'];
                $result[$i]['ID_PENDIDIKAN']= $value['TRTINGKATPENDIDIKAN_ID'];
                $result[$i]['TNGKT_PENDIDIKAN']= $value['TINGKAT_PENDIDIKAN'];
                $result[$i]['ID_JABATAN']= $value['ID_JAB'];
                $result[$i]['JABATAN']= $value['JABATAN'];
                $result[$i]['TMT_JABATAN']= $value['TMT_JABATAN'];
                $result[$i]['KD_SATKER']='';
                $result[$i]['NAMA_SATKER']='';
                $result[$i]['KD_LOK']=$value['TRLOKASI_ID'];
                $result[$i]['KDU1']=$value['KDU1'];
                $result[$i]['KDU2']=$value['KDU2'];
                $result[$i]['KDU3']=$value['KDU3'];
                $result[$i]['KDU4']=$value['KDU4'];
                $result[$i]['KDU5']=$value['KDU5'];
                $result[$i]['NMUNIT']= $value['NMUNIT'];
				$result[$i]['AGAMA']= $value['AGAMA'];
				$result[$i]['STATUS_KAWIN']= $value['STATUS_KAWIN'];
            }


            foreach ($result as $r => $re) {
                foreach ($this->satkerApi() as $t => $val) {
                    if(($re['KD_LOK']=='2')or($re['KD_LOK']=='')){  
                        $result[$r]['KD_SATKER']='414370';
                        $result[$r]['NAMA_SATKER']='KANTOR PUSAT BADAN NASIONAL PENCARIAN DAN PERTOLONGAN';
                    }else{
                        if($re['KDU3']!='017'){
                            if($re['KDU3']==$val['KDU3']){
                                $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                                $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                            }
                        }else if($re['KDU3']=='017'){
                            if($re['KDU4']==$val['KDU4']){
                                $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                                $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                            }
                        }else{
                            $result[$r]['KD_SATKER']=$val['KD_SATKER'];
                            $result[$r]['NAMA_SATKER']=$val['NM_SATKER'];
                        }
                    }
                    // echo '<br>';
                }
            }

            // print_r($result);
        
        $no=0;
        $hasil=[];
        if($this->input->get('satker')){
            foreach ($result as $j => $row) {
                if($row['KD_SATKER']==$this->input->get('satker')){
                    $hasil[$no]=$row++;
                    $no++;
                }
            }
        }

        if($this->input->get('satker')){
            $this->response($hasil);
        }else{
            $this->response($result);
        }
    }
}
