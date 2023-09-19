<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik_golongan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_data_komposisi_cpns() {
        $sql = "select * from ( select distinct TG.GOL,GOLONGAN,urutan,to_char(TMT_GOL, 'YYYY') as thn_gol,TP.TRGOLONGAN_ID FROM V_PEGAWAI_PANGKAT_MUTAKHIR TP left join TR_GOLONGAN TG on (TP.TRGOLONGAN_ID=TG.ID) 
        where TRJENISKENAIKANPANGKAT_ID = 5 order by urutan asc) order by urutan desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_data() {
        $cpns = $this->get_data_komposisi_cpns();
        
        //$this->db->query("select F_INSERT_KOMPOSISI_PANGKAT from dual;");
        
        $sql = "SELECT * FROM TABLE(F_KOMPOSISI_PANGKAT)";
        $query = $this->db->query($sql);
        $data = array();

        $where = '';
        $i = 0;
        if ($query->result_array()) {
            foreach ($query->result_array() as $val) {
                $data[$i] = $val;
                if ($cpns) {
                    foreach ($cpns as $isi) {
                        $where = " AND VPPM.TRGOLONGAN_ID = '" . $isi['TRGOLONGAN_ID'] . "' AND to_char(VPPM.TMT_GOL, 'YYYY') = '".$isi['THN_GOL']."' AND TRLOKASI_ID = '" . $val['TRLOKASI_ID'] . "'";
                        if ($val['KDU1'] != "00") {
                            $where .= " AND KDU1 = '".$val['KDU1']."'";
                        }
                        if ($val['KDU2'] != "00") {
                            $where .= " AND KDU2 = '".$val['KDU2']."'";
                        }
                        if ($val['KDU3'] != "000") {
                            $where .= " AND KDU3 = '".$val['KDU3']."'";
                        }
                        if ($val['KDU4'] != "000") {
                            $where .= " AND KDU4 = '".$val['KDU4']."'";
                        }
                        if ($val['KDU5'] != "00") {
                            $where .= " AND KDU5 = '".$val['KDU5']."'";
                        }
                        
                        //$this->db->query("INSERT INTO TH_KOMPOSISI(TMPEGAWAI_ID) select VPJM.TMPEGAWAI_ID from V_PEGAWAI_PANGKAT_MUTAKHIR VPPM LEFT join TR_GOLONGAN TG on (VPPM.TRGOLONGAN_ID=TG.ID) LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (VPJM.TMPEGAWAI_ID=VPPM.TMPEGAWAI_ID)
                        //WHERE TRJENISKENAIKANPANGKAT_ID = 5 AND VPJM.TRESELON_ID != '17' $where");
                        
                        $sql = "select count(VPJM.TMPEGAWAI_ID) as jml from V_PEGAWAI_PANGKAT_MUTAKHIR VPPM LEFT join TR_GOLONGAN TG on (VPPM.TRGOLONGAN_ID=TG.ID) LEFT JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (VPJM.TMPEGAWAI_ID=VPPM.TMPEGAWAI_ID)
                        WHERE TRJENISKENAIKANPANGKAT_ID = 5 AND VPJM.TRESELON_ID != '17' $where ";
                        
                        $hasil = $this->db->query($sql)->row_array();
                        
                        $data[$i][$isi['TRGOLONGAN_ID']."_".$isi['THN_GOL']] = $hasil['JML'];
                    }
                }
                
                $i++;
            }
        }
        
//        print '<pre>';
//        print_r($data);
//        exit;
        return $data;
    }

}
