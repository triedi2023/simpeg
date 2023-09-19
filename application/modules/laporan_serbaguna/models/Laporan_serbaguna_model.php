<?php

class Laporan_serbaguna_model extends CI_Model {

    public function jmlpegawai() {
        $sql = "SELECT COUNT(TMPEGAWAI_ID) AS JML FROM V_PEGAWAI_JABATAN_MUTAKHIR VPJM WHERE VPJM.TRESELON_ID <> '17' ";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    function get_data($jsonpar,$is='') {
        $p = $jsonpar;

        $default_page_per_row = 30;
        $start = !empty($p["awal_data"]) && is_numeric($p["awal_data"]) ? $p["awal_data"] - 1 : 0;
        $limit = !empty($p["halaman"]) && is_numeric($p["halaman"]) ? $p["halaman"] : $default_page_per_row;

        $selCol = "";
        $from = " FROM TM_PEGAWAI TMP JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (TMP.ID=VPJM.TMPEGAWAI_ID)  JOIN TH_PEGAWAI_CPNS THPC ON (THPC.TMPEGAWAI_ID=TMP.ID) LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPAM ON (VPAM.TMPEGAWAI_ID=TMP.ID) LEFT JOIN V_PEGAWAI_DIKLATPIM_MUTAKHIR VPDM ON (VPDM.TMPEGAWAI_ID=TMP.ID) ";
        if (isset($p['selectColumn']) && is_array($p['selectColumn'])) {
            $selectColumn = $p['selectColumn'];
        } else {
            $selectColumn = ['nip', 'nama'];
        }
        $riwayatpendidikan = false;
        if ($p['whereColumn']) {
            foreach ($p['whereColumn'] as $key => $val) {
                if ($key == "rwytpdk" && is_array($val)) {
                    foreach ($val as $kunci => $isi) {
                        if (in_array($kunci,['tktpdk']) && !empty($isi)) {
                            $riwayatpendidikan = true;
                        }
                    }
                }
            }
        }
        $colMap = $this->columnMap($is,$riwayatpendidikan);
        $rwytpdk = false;
        $kelfgs = false;
        $pendterahir = false;
        $diklatteknis = false;

        if ($p['whereColumn']) {
            foreach ($p['whereColumn'] as $key => $val) {
                if ($key == "kerja" && is_array($val)) {
                    if (isset($val['kelfgs']) && !empty($val['kelfgs'])) {
                        $kelfgs = true;
                    }
                }
                if ($key == "pend" && is_array($val)) {
                    foreach ($val as $kunci => $isi) {
                        if (in_array($kunci,['tktpdk','lbgpdk','fakpdk','jurpdk','thnpdk']) && !empty($isi)) {
                            $pendterahir = true;
                        }
                    }
                }
                if ($key == "diklatteknis" && is_array($val)) {
                    foreach ($val as $kunci => $isi) {
                        if (in_array($kunci,['keldiknis','sekdiknis','namadiknis','ketdiklatteknis']) && !empty($isi) && !in_array('nama_teknis', $p['selectColumn'])) {
                            $diklatteknis = true;
                        }
                    }
                }

                if (!is_array($val)) {
                    if (isset($colMap[$key]) && !empty($val)) {
                        $from .= strpos($from, $colMap[$key]['table']) === false ? $colMap[$key]['table'] : "";
                    }
                } else {
                    foreach ($val as $kunci => $isi) {
                        if (isset($colMap[$kunci]) && !empty($isi)) {
                            $from .= strpos($from, $colMap[$kunci]['table']) === false ? $colMap[$kunci]['table'] : "";
                        }
                    }
                }
            }
        }

        if ($selectColumn):
            foreach ($selectColumn as $c) {
                if ($c != "rwytpdk") {
                    $selCol .= empty($selCol) ? $colMap[$c]['column'] : "," . $colMap[$c]['column'];
                    $from .= strpos($from, $colMap[$c]['table']) === false ? $colMap[$c]['table'] : "";
                }
                if ($c == "rwytpdk")
                    $rwytpdk = true;
            }
        endif;
        
        if ($kelfgs == true) {
            $from .= " LEFT OUTER JOIN TR_JABATAN TRRL ON (VPJM.TRJABATAN_ID=TRRL.ID) ";
        }

        if ($rwytpdk)
            $selCol = " $selCol, TMP.nip nippddk ";

        $selCol = str_replace("TMP.NAMA", " coalesce(ltrim(rtrim(GELAR_DEPAN)),'') || ' ' || ltrim(rtrim(TMP.NAMA)) || ' ' || coalesce(ltrim(rtrim(GELAR_BLKG)),'') ", $selCol);
        
        if ($pendterahir)
            $from .= " LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON (MPPV.TMPEGAWAI_ID=TMP.ID) ";
        if ($diklatteknis)
            $from .= " LEFT JOIN TH_PEGAWAI_DIKLAT_TEKNIS TDPT ON (TDPT.TMPEGAWAI_ID=TMP.ID) ";
        
        if (empty($selectColumn)) {
            foreach ($colMap as $c) {
                $selCol .= empty($selCol) ? $c['column'] : "," . $c['column'];
                $from .= strpos($from, $c['table']) === false ? $c['table'] : "";
            }
        }

        $query = " SELECT $selCol $from " . $this->constructWhereClause($p['whereColumn']) . " ORDER BY VPJM.TRESELON_ID ASC";

        $rows = $this->db->query($query)->result_array();

        if ($rwytpdk)
            $rows = $this->getRiwayatPdk($rows, $p['whereColumn']);

        return $rows;
    }

    function getRiwayatPdk($rows, $w) {
        $tmp = $w['rwytpdk'];
        $whr = "";
        $tktpdk = $tmp['tktpdk'];
        if (!empty($tktpdk)) {
            $whr .= " AND THPDK.tktpdk = '$tktpdk' ";
            if ($tktpdk == '11' || $tktpdk == '12' || $tktpdk == '13') {
                if (!empty($tmp['nama_lbgpdk']))
                    $whr .= " AND UPPER(THPDK.nama_lbgpdk) LIKE UPPER('" . $tmp['nama_lbgpdk'] . "%') ";
            }else {
                if (!empty($tmp['nama_lbgpdk']))
                    $whr .= " AND UPPER(THPDK.nama_lbgpdk) LIKE UPPER('" . $tmp['nama_lbgpdk'] . "%') ";
                if (!empty($tmp['fakpdk']))
                    $whr .= " AND THPDK.fakpdk LIKE '" . $tmp['fakpdk'] . "' ";
                if (!empty($tmp['jurpdk']))
                    $whr .= " AND THPDK.jurpdk LIKE '" . $tmp['jurpdk'] . "' ";
            }
        }

        $query = " SELECT pdk.nama tktpdk, THPDK.nama_lbgpdk, THPDK.thn_lulus, jur.nama jurpdk, fak.nama fakpdk ";
        $query .= " FROM th_pendidikan THPDK ";
        $query .= " LEFT JOIN tr_pendidikan pdk ON THPDK.tktpdk=pdk.kode ";
        $query .= " LEFT JOIN tr_jurusan jur ON THPDK.jurpdk=jur.kode ";
        $query .= " LEFT JOIN tr_fakultas fak ON THPDK.fakpdk=fak.kode ";

        $data = array();

        foreach ($rows as $r) {
            $nip = $r['nippddk'];
            $sql = " $query WHERE THPDK.nip='$nip' $whr ";
            $result = $this->db->query($sql)->result_array();
            $rwytpdk = "";
            foreach ($result as $res) {
                $fak = !empty($res['fakpdk']) ? "Fakultas " . $res['fakpdk'] : "";
                $jur = !empty($res['fakpdk']) ? "Jurusan " . $res['jurpdk'] : "";
                $thn = !empty($res['fakpdk']) ? "Lulus Tahun " . $res['thn_lulus'] : "";
                $rwytpdk .= $res['tktpdk'] . " " . $res['nama_lbgpdk'] . " $fak $jur $thn ";
            }
            unset($r['nippddk']);
            $r['rwytpdk'] = $rwytpdk;
            $data[] = $r;
        }
        return $data;
    }

    function constructWhereClause($w) {
        $whr = " 1=1 ";
        if (!empty($w['nama'])) {
            $tem = "";
            $whr .= " AND ( ";
            $tmp = explode(",", $w['nama']);
            foreach ($tmp as $t)
                if (!empty($t))
                    $tem .= empty($tem) ? " lower(TMP.NAMA) like lower('%$t%') " : " OR lower(TMP.NAMA) like lower('%$t%') ";
            $whr .= " $tem ) ";
        }
        if (!empty($w['nip'])) {
            $tem = "";
            $whr .= !empty($whr) ? " AND ( " : " ( ";
            $tmp = explode("-", $w['nip']);
            foreach ($tmp as $t)
                if (!empty($t))
                    $tem .= empty($tem) ? " TMP.NIP like '%$t%' " : " OR TMP.NIP like '%$t%'";
            $whr .= " $tem ) ";
        }
        if (!empty($w['sex']))
            $whr .= !empty($whr) ? " AND TMP.SEX = '" . $w['sex'] . "' " : " TMP.SEX = '" . $w['sex'] . "' ";
        if (!empty($w['gol_darah'])) {
            $tem = "";
            $whr .= !empty($whr) ? " AND TMP.TRGOLDARAH_ID IN ( " : " TMP.TRGOLDARAH_ID IN ( ";
            foreach ($w['gol_darah'] as $t)
                $tem .= empty($tem) ? "'$t'" : ",'$t'";
            $whr .= " $tem ) ";
        }
        if (!empty($w['cpns'])) {
            $tmp = $w['cpns'];
            $tem = "";
            $t = "";
            if (!empty($tmp['bln']) && $tmp['bln'] != '-') {
                $tem .= "MM";
                $t .= $tmp['bln'];
            }
            if (!empty($tmp['thn'])) {
                $tem .= "YYYY";
                $t .= $tmp['thn'];
            }
            if (!empty($t))
                $whr .= !empty($whr) ? " AND to_char(THPC.TMT_CPNS,'$tem')='$t' " : " to_char(THPC.TMT_CPNS,'$tem')='$t' ";
            if (!empty($tmp['sk_cpns']))
                $whr .= !empty($whr) ? " AND lower(THPPCPNS.NO_SK) LIKE lower('%" . $tmp['sk_cpns'] . "%') " : " lower(THPPCPNS.NO_SK) LIKE lower('%" . $tmp['sk_cpns'] . "%') ";
        }
        if (!empty($w['pns'])) {
            $tmp = $w['pns'];
            $tem = "";
            $t = "";
            if (!empty($tmp['bln']) && $tmp['bln'] != '-') {
                $tem .= "MM";
                $t .= $tmp['bln'];
            }
            if (!empty($tmp['thn'])) {
                $tem .= "YYYY";
                $t .= $tmp['thn'];
            }
            if (!empty($t))
                $whr .= !empty($whr) ? " AND to_char(TMP.tmt_pns,'$tem')='$t' " : " to_char(TMP.tmt_pns,'$tem')='$t' ";
            if (!empty($tmp['sk_pns']))
                $whr .= !empty($whr) ? " AND TMP.sk_pns LIKE '%" . $tmp['sk_pns'] . "%' " : " TMP.sk_pns LIKE '%" . $tmp['sk_pns'] . "%' ";
        }
        if (!empty($w['agama'])) {
            $tem = "";
            $whr .= !empty($whr) ? " AND TMP.TRAGAMA_ID IN ( " : " TMP.agama IN ( ";
            foreach ($w['agama'] as $t)
                $tem .= empty($tem) ? "'$t'" : ",'$t'";
            $whr .= " $tem ) ";
        }
        if (!empty($w['pend'])) {
            $tmp = $w['pend'];
            if (!empty($tmp['tktpdk']))
                $whr .= !empty($whr) ? " AND MPPV.TRTINGKATPENDIDIKAN_ID  IN ('" . implode("','", $tmp['tktpdk']) . "') " : " TMP.tktpdk IN ('" . implode("','", $tmp['tktpdk']) . "') ";
            if (!empty($tmp['lbgpdk']))
                $whr .= !empty($whr) ? " AND lower(MPPV.NAMA_LBGPDK) = lower('" . $tmp['lbgpdk'] . "') " : " AND lower(MPPV.NAMA_LBGPDK) = lower('" . $tmp['lbgpdk'] . "') ";
            if (!empty($tmp['fakpdk']))
                $whr .= !empty($whr) ? " AND MPPV.TRFAKULTAS_ID  IN ('" . $tmp['fakpdk'] . "') " : " MPPV.TRFAKULTAS_ID  IN ('" . $tmp['fakpdk'] . "') ";
            if (!empty($tmp['jurpdk']))
                $whr .= !empty($whr) ? " AND MPPV.TRJURUSAN_ID IN ('" . $tmp['jurpdk'] . "') " : " AND MPPV.TRJURUSAN_ID IN ('" . $tmp['jurpdk'] . "') ";
            if (!empty($tmp['thnpdk']))
                $whr .= !empty($whr) ? " AND MPPV.THN_LULUS IN ('" . $tmp['thnpdk'] . "') " : " MPPV.THN_LULUS IN ('" . $tmp['thnpdk'] . "') ";
        }
        if (!empty($w['eselon'])) {
            $tmp = $w['eselon'];
            if (!empty($tmp['eselon'])) {
                $cektni = false;
                foreach ($tmp['eselon'] as $t) {
                    if ($t == '18') {
                        $cektni = true;
                    }
                }
                if ($cektni == true) {
                    $whr .= " AND TMP.TRSTATUSKEPEGAWAIAN_ID IN ('4','5','6') AND VPJM.TRESELON_ID != '17' ";
                } else {
                    $tem = "";
                    $whr .= !empty($whr) ? " AND VPJM.TRESELON_ID IN ( " : " VPJM.TRESELON_ID IN ( ";
                    foreach ($tmp['eselon'] as $t) {
                        if ($t == '18') {
                            $cektni = true;
                        }
                        $tem .= empty($tem) ? "'$t'" : ",'$t'";
                    }
                    $whr .= " $tem ) ";
                }
            } else {
                $whr .= " AND VPJM.TRESELON_ID != '17' ";
            }
            if (!empty($tmp['tmtesel']))
                $whr .= !empty($whr) ? " AND to_char(VPJM.TMT_ESELON,'DD/MM/YYYY') LIKE '%" . $tmp['tmtesel'] . "%' " : " to_char(VPJM.TMT_ESELON,'DD/MM/YYYY') LIKE '%" . $tmp['tmtesel'] . "%' ";
        } else {
            $whr .= " AND VPJM.TRESELON_ID != '17' ";
        }
        if (!empty($w['gol'])) {
            $tmp = $w['gol'];
            if (!empty($tmp['polri']) || !empty($tmp['pns'])) {
                $tem = "";
                $whr .= !empty($whr) ? " AND VPAM.TRGOLONGAN_ID IN ( " : " VPAM.TRGOLONGAN_ID IN ( ";
                if (isset($tmp['polri'])) {
                    foreach ($tmp['polri'] as $t)
                        $tem .= empty($tem) ? "'$t'" : ",'$t'";
                }
                if (isset($tmp['pns'])) {
                    foreach ($tmp['pns'] as $t)
                        $tem .= empty($tem) ? "'$t'" : ",'$t'";
                }
                $whr .= " $tem ) ";
            }
            if (!empty($tmp['tmtgol']))
                $whr .= !empty($whr) ? " AND to_char(VPAM.TMT_GOL,'DD/MM/YYYY') LIKE '%" . $tmp['tmtgol'] . "%' " : " to_char(VPAM.TMT_GOL,'DD/MM/YYYY') LIKE '%" . $tmp['tmtgol'] . "%' ";
        }
        if (!empty($w['pim'])) {
            $tmp = $w['pim'];
            if (!empty($tmp['namapim'])) {
                $tem = "";
                $whr .= !empty($whr) ? " AND VPDM.TRTINGKATDIKLATKEPEMIMPINAN_ID IN ( " : " VPDM.TRTINGKATDIKLATKEPEMIMPINAN_ID IN ( ";
                foreach ($tmp['namapim'] as $t)
                    $tem .= empty($tem) ? "'$t'" : ",'$t'";
                $whr .= " $tem ) ";
            }
            if (!empty($tmp['thnpim']))
                $whr .= !empty($whr) ? " AND VPDM.THN_DIKLAT = '" . $tmp['thnpim'] . "' " : " VPDM.THN_DIKLAT = '" . $tmp['thnpim'] . "' ";
        }
        if (!empty($w['diklatteknis'])) {
            $tmp = $w['diklatteknis'];
            $whrtek = "";
            if (!empty($tmp['keldiknis']))
                $whrtek .= " AND TDPT.TRKELOMPOKDKLTTEKNIS_ID = '" . $tmp['keldiknis'] . "' ";
            if (!empty($tmp['sekdiknis']))
                $whrtek .= " AND s.kode_sektor = '" . $tmp['sekdiknis'] . "' ";
            if (!empty($tmp['namadiknis']))
                $whrtek .= " AND TDPT.TRDIKLATTEKNIS_ID = '" . $tmp['namadiknis'] . "' ";
            if (!empty($tmp['ketdiklatteknis']))
                $whrtek .= " AND lower(TDPT.KETERANGAN) LIKE '%" . strtolower($tmp['ketdiklatteknis']) . "%' ";

            if ($whrtek != "")
                $whr .= $whrtek;
        }
        if (!empty($w['diklatlainlain']))
            $whr .= !empty($whr) ? " AND upper(u.nama_diklat) LIKE upper('%" . $w['diklatlainlain'] . "%') " : " upper(u.nama_diklat) LIKE upper('%" . $w['diklatlainlain'] . "%') ";
        if (!empty($w['kerja'])) {
            $tmp = $w['kerja'];
            if (!empty($tmp['jabat'])) {
                if ($tmp['jabat'] == '0000') {
                    $whr .= !empty($whr) ? " AND VPJM.TRJABATAN_ID IN (SELECT TJA.TRJABATAN_ID FROM TR_JABATAN_ABK TJA) " : " VPJM.TRJABATAN_ID IN (SELECT TJA.TRJABATAN_ID FROM TR_JABATAN_ABK TJA) ";
                } else {
                    $whr .= !empty($whr) ? " AND VPJM.TRJABATAN_ID = '" . $tmp['jabat'] . "' " : " VPJM.TRJABATAN_ID = '" . $tmp['jabat'] . "' ";
                }
            }
            if (!empty($tmp['tmtjab']))
                $whr .= !empty($whr) ? " AND TO_CHAR(VPJM.TMT_JABATAN,'DD/MM/YYYY') = '" . $tmp['tmtjab'] . "' " : " TO_CHAR(VPJM.TMT_JABATAN,'DD/MM/YYYY') = '" . $tmp['tmtjab'] . "' ";
            if (!empty($tmp['propunit']))
                $whr .= !empty($whr) ? " AND TMP.propunit = '" . $tmp['propunit'] . "' " : " TMP.propunit = '" . $tmp['propunit'] . "' ";
            if (!empty($tmp['kelfgs']))
                $whr .= !empty($whr) ? " AND TRRL.TRKELOMPOKFUNGSIONAL_ID = '" . $tmp['kelfgs'] . "' " : " TRRL.TRKELOMPOKFUNGSIONAL_ID = '" . $tmp['kelfgs'] . "' ";
            if (!empty($tmp['tmtgol']))
                $whr .= !empty($whr) ? " AND to_char(TMP.tmtgol,'DD/MM/YYYY') LIKE '%" . $tmp['tmtgol'] . "%' " : " to_char(TMP.tmtgol,'DD/MM/YYYY') LIKE '%" . $tmp['tmtgol'] . "%' ";
        }
        if (!empty($w['sts_kawin'])) {
            $tem = "";
            $whr .= !empty($whr) ? " AND TMP.TRSTATUSPERNIKAHAN_ID IN ( " : " TMP.TRSTATUSPERNIKAHAN_ID IN ( ";
            foreach ($w['sts_kawin'] as $t)
                $tem .= empty($tem) ? "'$t'" : ",'$t'";
            $whr .= " $tem ) ";
        }

        if (!empty($w['tgllahir']))
            $whr .= !empty($whr) ? " AND to_char(TMP.tgllahir,'DD/MM/YYYY') LIKE '%" . $w['tgllahir'] . "%' " : " to_char(TMP.tgllahir,'DD/MM/YYYY') LIKE '%" . $w['tgllahir'] . "%' ";
        if (!empty($w['range_tgllahir_1']) && !empty($w['range_tgllahir_2'])) {
            $pecah1 = explode("/", $w['range_tgllahir_1']);
            $format1 = $pecah1[2] . "-" . $pecah1[1] . "-" . $pecah1[0];
            $pecah2 = explode("/", $w['range_tgllahir_2']);
            $format2 = $pecah2[2] . "-" . $pecah2[1] . "-" . $pecah2[0];
            $whr .= !empty($whr) ? " AND TMP.tgllahir BETWEEN '" . $format1 . "' AND '" . $format2 . "' " : " AND TMP.tgllahir BETWEEN '" . $format1 . "' AND '" . $format2 . "' ";
        }
        //calculate usia
        if (!empty($w['usia1']) && empty($w['usia2']))
            $whr .= !empty($whr) ? " AND AGE_YEAR(SYSDATE,TMP.TGLLAHIR) = '" . $w['usia1'] . "'" : " AND AGE_YEAR(SYSDATE,TMP.TGLLAHIR) = '" . $w['usia1'] . "'";
        if (empty($w['usia1']) && !empty($w['usia2']))
            $whr .= !empty($whr) ? " AND AGE_YEAR(SYSDATE,TMP.TGLLAHIR) = '" . $w['usia2'] . "'" : " AND AGE_YEAR(SYSDATE,TMP.TGLLAHIR) = '" . $w['usia2'] . "'";
        if (!empty($w['usia1']) && !empty($w['usia2']))
            $whr .= !empty($whr) ? " AND AGE_YEAR(SYSDATE,TMP.TGLLAHIR) BETWEEN " . $w['usia1'] . " AND " . $w['usia2'] : " AND AGE_YEAR(SYSDATE,TMP.TGLLAHIR) BETWEEN " . $w['usia1'] . " AND " . $w['usia2'];
        if (!empty($w['propinsi']))
            $whr .= !empty($whr) ? " AND TMP.TRPROPINSI_ID_LAHIR = '" . $tmp['propinsi'] . "' " : " TMP.TRPROPINSI_ID_LAHIR = '" . $tmp['propinsi'] . "' ";
        if (!empty($w['kablahir']))
            $whr .= !empty($whr) ? " AND TMP.TRKABUPATEN_ID_LAHIR = '" . $tmp['kablahir'] . "' " : " TMP.TRKABUPATEN_ID_LAHIR = '" . $tmp['kablahir'] . "' ";
        if (!empty($w['alamat']))
            $whr .= !empty($whr) ? " AND TMP.alamat LIKE '" . $w['alamat'] . "%' " : " TMP.alamat LIKE '" . $w['alamat'] . "%' ";
        if (!empty($w['telp_hp'])) {
            $whr .= !empty($whr) ? " AND TMP.TELP_HP LIKE '" . $w['telp_hp'] . "%' " : " TMP.TELP_HP LIKE '" . $w['telp_hp'] . "%' ";
            $whr .= !empty($whr) ? " AND TMP.TELP_RMH LIKE '" . $w['telp_hp'] . "%' " : " TMP.TELP_RMH LIKE '" . $w['telp_rmh'] . "%' ";
        }
        if (!empty($w['hobi']))
            $whr .= !empty($whr) ? " AND lower(TMP.HOBI) LIKE lower('%" . $w['hobi'] . "%') " : " lower(TMP.HOBI) LIKE lower('%" . $w['hobi'] . "%') ";
        if (!empty($w['karpeg']))
            $whr .= !empty($whr) ? " AND TMP.NO_KARPEG LIKE lower('%" . $w['karpeg'] . "%') " : " lower(TMP.karpeg) LIKE lower('%" . $w['karpeg'] . "%') ";
        if (!empty($w['karis']))
            $whr .= !empty($whr) ? " AND TMP.NO_KARIS LIKE lower('%" . $w['karis'] . "%') " : " lower(TMP.karis) LIKE lower('%" . $w['karis'] . "%') ";
        if (!empty($w['taspen']))
            $whr .= !empty($whr) ? " AND TMP.NO_TASPEN LIKE lower('%" . $w['taspen'] . "%') " : " lower(TMP.taspen) LIKE lower('%" . $w['taspen'] . "%') ";
        if (!empty($w['no_ktp']))
            $whr .= !empty($whr) ? " AND TMP.NO_KTP LIKE lower('%" . $w['no_ktp'] . "%') " : " lower(TMP.no_ktp) LIKE lower('%" . $w['no_ktp'] . "%') ";
        if (!empty($w['askes']))
            $whr .= !empty($whr) ? " AND TMP.NO_ASKES LIKE lower('%" . $w['askes'] . "%)' " : " lower(TMP.askes) LIKE lower('%" . $w['askes'] . "%') ";
        if (!empty($w['kodepos']))
            $whr .= !empty($whr) ? " AND TMP.KODEPOS LIKE '%" . $w['kodepos'] . "%' " : " TMP.KODEPOS LIKE '%" . $w['kodepos'] . "%' ";
        if (!empty($w['warna_kulit']))
            $whr .= !empty($whr) ? " AND lower(TMP.WARNA_KULIT) LIKE lower('%" . $w['warna_kulit'] . "%') " : " lower(TMP.warna_kulit) LIKE lower('" . $w['warna_kulit'] . "%') ";

        $unit = "";
        if (!empty($w['lok']) AND $w['lok'] != '-1')
            $unit .= $w['lok'];
        if (!empty($w['kdu1']) AND $w['kdu1'] != '-1')
            $unit .= $w['kdu1'];
        if (!empty($w['kdu2']) AND $w['kdu2'] != '-1')
            $unit .= $w['kdu2'];
        if (!empty($w['kdu3']) AND $w['kdu3'] != '-1')
            $unit .= $w['kdu3'];
        if (!empty($w['kdu4']) AND $w['kdu4'] != '-1')
            $unit .= $w['kdu4'];
        if (!empty($w['kdu5']) AND $w['kdu5'] != '-1')
            $unit .= $w['kdu5'];

        if ($unit != "")
            $whr .= !empty($whr) ? " AND VPJM.TRLOKASI_ID||VPJM.KDU1||VPJM.KDU2||VPJM.KDU3||VPJM.KDU4||VPJM.KDU5 LIKE '$unit%' " : " TMP.TRLOKASI_ID||TMP.KDU1||TMP.KDU2||TMP.KDU3||TMP.KDU4||TMP.KDU5 LIKE '$unit%' ";

        if (!empty($w['rwytpdk'])) {
            $tmp = $w['rwytpdk'];
            $tmpWhr = " SELECT 1 FROM TH_PEGAWAI_PENDIDIKAN THPDK WHERE TMP.ID=THPDK.TMPEGAWAI_ID "; //" AND THPDK.tktpdk LIKE '".$tmp['tktpdk']."%'";
            $tktpdk = $tmp['tktpdk'];
            if (!empty($tktpdk)) {
                $tmpWhr .= " AND THPDK.TRTINGKATPENDIDIKAN_ID = '$tktpdk' ";
                if ($tktpdk == '11' || $tktpdk == '12' || $tktpdk == '13') {
                    if (!empty($tmp['nama_lbgpdk']))
                        $tmpWhr .= " AND UPPER(THPDK.NAMA_LBGPDK) LIKE UPPER('" . $tmp['nama_lbgpdk'] . "%') ";
                } else {
                    if (!empty($tmp['nama_lbgpdk']))
                        $tmpWhr .= " AND UPPER(THPDK.NAMA_LBGPDK) LIKE UPPER('" . $tmp['nama_lbgpdk'] . "%') ";
                    if (!empty($tmp['fakpdk']))
                        $tmpWhr .= " AND THPDK.TRFAKULTAS_ID LIKE '" . $tmp['fakpdk'] . "' ";
                    if (!empty($tmp['jurpdk']))
                        $tmpWhr .= " AND THPDK.TRJURUSAN_ID LIKE '" . $tmp['nama_jurpdk'] . "' ";
                }
            }
            $whr .= !empty($whr) ? " AND EXISTS( $tmpWhr ) " : " EXISTS( $tmpWhr ) ";
        }

        return empty($whr) ? "" : " WHERE $whr";
    }

    protected $_column;

    function columnMap($is="",$riwayatpendidikan=false) {
        if ($this->_column === null) {
            $base_url = base_url();
            $colMap["nama"] = array("column" => " TMP.NAMA as nama ", "table" => " TM_PEGAWAI TMP ");
            $colMap["nip"] = array("column" => " '`'||TMP.NIPNEW as nip ", "table" => " TM_PEGAWAI TMP ");
            $colMap["sex"] = array("column" => " TMP.SEX ", "table" => " TM_PEGAWAI TMP ");
            if (empty($is))
                $colMap["foto"] = array("column" => " '<img class=\"photo_pegawai\" width=\"150px\" src=\"{$base_url}/_uploads/photo_pegawai/thumbs/'||TMP.foto||'\"/>' as foto", "table" => " TM_PEGAWAI TMP ");
            else
                $colMap["foto"] = array("column" => " TMP.FOTO as foto", "table" => " TM_PEGAWAI TMP ");
            $colMap["gol_darah"] = array("column" => " TRRB.GOL_DARAH as gol_darah ", "table" => " LEFT JOIN TR_GOL_DARAH TRRB ON (TMP.TRGOLDARAH_ID = TRRB.ID) ");
            $colMap["tgl_skpns"] = array("column" => " to_char(TMP.tgl_skpns,'DD/MM/YYYY') tgl_skpns ", "table" => " TM_PEGAWAI TMP ");
            $colMap["sk_pns"] = array("column" => " VPAM.NO_SK AS sk_pns", "table" => "TM_PEGAWAI TMP ");
            $colMap["tgl_skcpns"] = array("column" => " to_char(THPPCPNS.TGL_SK,'DD/MM/YYYY') as tgl_skcpns ", "table" => " LEFT JOIN TH_PEGAWAI_PANGKAT THPPCPNS ON (THPPCPNS.TMPEGAWAI_ID=TMP.ID AND THPPCPNS.TRJENISKENAIKANPANGKAT_ID = 5) ");
            $colMap["sk_cpns"] = array("column" => " THPPCPNS.NO_SK AS sk_cpns ", "table" => " LEFT JOIN TH_PEGAWAI_PANGKAT THPPCPNS ON (THPPCPNS.TMPEGAWAI_ID=TMP.ID) ");
            $colMap["agama"] = array("column" => " TRRC.AGAMA AS agama ", "table" => " LEFT OUTER JOIN TR_AGAMA TRRC ON (TMP.TRAGAMA_ID=TRRC.ID) ");
            
            if ($riwayatpendidikan)
                $colMap["pddk"] = array("column" => " TRRZ.TINGKAT_PENDIDIKAN pddk ", "table" => " LEFT JOIN TR_TINGKAT_PENDIDIKAN TRRZ ON (TRRZ.ID=MPPV.TRTINGKATPENDIDIKAN_ID) ");
            else
                $colMap["pddk"] = array("column" => " TRRZ.TINGKAT_PENDIDIKAN pddk ", "table" => " LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON (MPPV.TMPEGAWAI_ID=TMP.ID) LEFT JOIN TR_TINGKAT_PENDIDIKAN TRRZ ON (TRRZ.ID=MPPV.TRTINGKATPENDIDIKAN_ID) ");
            
            if ($riwayatpendidikan)
                $colMap["lbg_pddk"] = array("column" => " e.nama2 lbg_pddk ", "table" => " LEFT OUTER JOIN tr_universitas e ON TMP.lbgpdk=e.kode ");
            else
                $colMap["lbg_pddk"] = array("column" => " e.nama2 lbg_pddk ", "table" => " LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON (MPPV.TMPEGAWAI_ID=TMP.ID) LEFT OUTER JOIN tr_universitas e ON TMP.lbgpdk=e.kode ");
            
            if ($riwayatpendidikan)
                $colMap["fakultas"] = array("column" => " TRRF.NAMA_FAKULTAS as fakultas ", "table" => " LEFT OUTER JOIN TR_FAKULTAS TRRF ON MPPV.TRFAKULTAS_ID=TRRF.ID ");
            else
                $colMap["fakultas"] = array("column" => " TRRF.NAMA_FAKULTAS as fakultas ", "table" => " LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON (MPPV.TMPEGAWAI_ID=TMP.ID) LEFT OUTER JOIN TR_FAKULTAS TRRF ON MPPV.TRFAKULTAS_ID=TRRF.ID ");
            
            if ($riwayatpendidikan)
                $colMap["jurusan"] = array("column" => " TRRG.NAMA_JURUSAN AS jurusan ", "table" => " LEFT OUTER JOIN TR_JURUSAN TRRG ON MPPV.TRJURUSAN_ID=TRRG.ID ");
            else
                $colMap["jurusan"] = array("column" => " TRRG.NAMA_JURUSAN AS jurusan ", "table" => " LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON (MPPV.TMPEGAWAI_ID=TMP.ID) LEFT OUTER JOIN TR_JURUSAN TRRG ON MPPV.TRJURUSAN_ID=TRRG.ID ");
            
            $colMap["thn_pddk"] = array("column" => " MPPV.THN_LULUS as thn_pddk ", "table" => " LEFT JOIN V_PEGAWAI_PENDIDIKAN_MUTAKHIR MPPV ON (MPPV.TMPEGAWAI_ID=TMP.ID) ");
            
            $colMap["eselon"] = array("column" => " TRRH.ESELON AS eselon ", "table" => " LEFT OUTER JOIN TR_ESELON TRRH ON (VPJM.TRESELON_ID=TRRH.ID) ");
            $colMap["tmt_eselon"] = array("column" => " to_char(VPJM.TMT_ESELON,'DD/MM/YYYY') as tmt_eselon ", "table" => " TM_PEGAWAI TMP ");
//            $colMap["gol_polri"] = array("column" => " i.golongan gol_polri ", "table" => " LEFT OUTER JOIN tr_golongan i ON TMP.gol=i.kode and i.tipe_pangkat='2' ");
            $colMap["gol_pns"] = array("column" => " (CASE WHEN TRRV.TRSTATUSKEPEGAWAIAN_ID='1' THEN TRRV.PANGKAT ||' ('||TRRV.GOLONGAN||')' ELSE TRRV.PANGKAT END) AS gol_pns ", "table" => " LEFT OUTER JOIN TR_GOLONGAN TRRV ON VPAM.TRGOLONGAN_ID=TRRV.ID ");
            $colMap["tmt_gol"] = array("column" => " to_char(VPAM.TMT_GOL,'DD/MM/YYYY') as tmt_gol ", "table" => " LEFT JOIN V_PEGAWAI_PANGKAT_MUTAKHIR VPAM ON (VPAM.TMPEGAWAI_ID=TMP.ID) ");
            $colMap["nama_pim"] = array("column" => " VPDM.NAMA_DIKLAT AS nama_pim ", "table" => " TM_PEGAWAI TMP ");
            $colMap['nama_teknis'] = array("column" => " TDPT.KETERANGAN as nama_teknis ", "table" => " LEFT OUTER JOIN TH_PEGAWAI_DIKLAT_TEKNIS TDPT ON (TDPT.TMPEGAWAI_ID=TMP.ID) ");
            $colMap['nama_diklat_lain'] = array("column" => " TRRU.NAMA_DIKLAT AS nama_diklat_lain ", "table" => " LEFT OUTER JOIN TH_PEGAWAI_DIKLAT_LAIN TRRU ON (TRRU.TMPEGAWAI_ID=TMP.ID) ");
            $colMap["thn_pim"] = array("column" => " VPDM.THN_DIKLAT as thn_pim ", "table" => " LEFT JOIN V_PEGAWAI_DIKLATPIM_MUTAKHIR VPDM ON (VPDM.TMPEGAWAI_ID=TMP.ID) ");
            $colMap["jabatan"] = array("column" => " VPJM.N_JABATAN as jabatan", "table" => " JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (TMP.ID=VPJM.TMPEGAWAI_ID) ");
            $colMap["tmt_jabatan"] = array("column" => " to_char(VPJM.TMT_JABATAN,'DD/MM/YYYY') AS tmt_jabatan ", "table" => " JOIN V_PEGAWAI_JABATAN_MUTAKHIR VPJM ON (TMP.ID=VPJM.TMPEGAWAI_ID) ");
            $colMap["prop_unit"] = array("column" => " m.propinsi prop_unit ", "table" => " LEFT OUTER JOIN tr_propinsi m ON TMP.propunit=m.kode ");
            $colMap["kelompok_fungsional"] = array("column" => " n.nama kelompok_fungsional ", "table" => " LEFT OUTER JOIN TR_KELOMPOK_FUNGSIONAL TRRN ON TRJ.TRKELOMPOKFUNGSIONAL_ID=TRRN.ID ");

            $colMap["sts_kawin"] = array("column" => " TRRO.NAMA AS sts_kawin ", "table" => " LEFT OUTER JOIN TR_STATUS_PERNIKAHAN TRRO ON TMP.TRSTATUSPERNIKAHAN_ID=TRRO.ID ");
            $colMap["tgllahir"] = array("column" => " to_char(TMP.TGLLAHIR,'DD/MM/YYYY') AS tgllahir ", "table" => " TM_PEGAWAI TMP ");
            $colMap["usia"] = array("column" => "AGE_YEAR(SYSDATE,tgllahir) as usia", "table" => "TM_PEGAWAI TMP");
            $colMap["prop_lahir"] = array("column" => " TRRP.NAMA_PROPINSI as prop_lahir ", "table" => " LEFT OUTER JOIN TR_PROPINSI TRRP ON TMP.TRPROPINSI_ID_LAHIR=TRRP.ID ");
            $colMap["kab_lahir"] = array("column" => " TRRQ.KABUPATEN as kab_lahir ", "table" => " LEFT OUTER JOIN TR_KABUPATEN TRRQ ON TMP.TRKABUPATEN_ID_LAHIR=TRRQ.ID ");

            $colMap["alamat"] = array("column" => " TMP.ALAMAT as alamat ", "table" => " TM_PEGAWAI TMP ");
            $colMap["telp_hp"] = array("column" => " TMP.TELP_HP as telp_hp ", "table" => " TM_PEGAWAI TMP ");
            $colMap["telp_rmh"] = array("column" => " TMP.TELP_RMH as telp_rmh ", "table" => " TM_PEGAWAI TMP ");
            $colMap["hobi"] = array("column" => " TMP.HOBI as hobi ", "table" => " TM_PEGAWAI TMP ");
            $colMap["karpeg"] = array("column" => " TMP.NO_KARPEG as karpeg ", "table" => " TM_PEGAWAI TMP ");
            $colMap["karis"] = array("column" => " TMP.NO_KARIS as karis ", "table" => " TM_PEGAWAI TMP ");
            $colMap["taspen"] = array("column" => " TMP.NO_TASPEN as taspen ", "table" => " TM_PEGAWAI TMP ");
            $colMap["no_ktp"] = array("column" => " '`'||TMP.NO_KTP as no_ktp ", "table" => " TM_PEGAWAI TMP ");
            $colMap["askes"] = array("column" => " TMP.NO_ASKES as askes ", "table" => " TM_PEGAWAI TMP ");
            $colMap["kodepos"] = array("column" => " TMP.KODEPOS as kodepos ", "table" => " TM_PEGAWAI TMP ");
            $colMap["warna_kulit"] = array("column" => " TMP.WARNA_KULIT as warna_kulit ", "table" => " TM_PEGAWAI TMP ");

//            $colMap['lok'] = array("column" => " LOK.TR_LOKASI ", "table" => " LEFT OUTER JOIN TR_LOKASI LOK ON VPJM.TRLOKASI_ID = LOK.ID AND LOK.STATUS=1 ");
//            $colMap['kdu1'] = array("column" => " s1.NMUNIT kdu1 ", "table" => " LEFT OUTER JOIN TR_STRUKTUR_ORGANISASI s1 ON VPJM.TRLOKASI_ID||VPJM.KDU1=case s1.TRLOKASI_ID when 0 then 0 else s1.TRLOKASI_ID end||case s1.KDU1 when '00' then '' else s1.KDU1 end||case s1.KDU2 when '00' then '' else s1.KDU2 end||case s1.KDU3 when '000' then '' else s1.KDU3 end||case s1.KDU4 when '000' then '' else s1.KDU4 end||case s1.KDU5 when '00' then '' else s1.KDU5 end ");
//            $colMap['kdu2'] = array("column" => " s2.NMUNIT kdu2 ", "table" => " LEFT OUTER JOIN TR_STRUKTUR_ORGANISASI s2 ON VPJM.TRLOKASI_ID||VPJM.KDU1||VPJM.KDU2=case s2.TRLOKASI_ID when 0 then 0 else s2.TRLOKASI_ID end||case s2.KDU1 when '00' then '' else s2.KDU1 end||case s2.KDU2 when '00' then '' else s2.KDU2 end||case s2.KDU3 when '000' then '' else s2.KDU3 end||case s2.KDU4 when '000' then '' else s2.KDU4 end||case s2.KDU5 when '00' then '' else s2.KDU5 end ");
//            $colMap['kdu3'] = array("column" => " s3.NMUNIT kdu3 ", "table" => " LEFT OUTER JOIN TR_STRUKTUR_ORGANISASI s3 ON VPJM.TRLOKASI_ID||VPJM.KDU1||VPJM.KDU2||VPJM.KDU3=case s3.TRLOKASI_ID when 0 then 0 else s3.TRLOKASI_ID end||case s3.KDU1 when '00' then '' else s3.KDU1 end||case s3.KDU2 when '00' then '' else s3.KDU2 end||case s3.KDU3 when '000' then '' else s3.KDU3 end||case s3.KDU4 when '000' then '' else s3.KDU4 end||case s3.KDU5 when '00' then '' else s3.KDU5 end ");
//            $colMap['kdu4'] = array("column" => " s4.NMUNIT kdu4 ", "table" => " LEFT OUTER JOIN TR_STRUKTUR_ORGANISASI s4 ON VPJM.TRLOKASI_ID||VPJM.KDU1||VPJM.KDU2||VPJM.KDU3||VPJM.KDU4=case s4.TRLOKASI_ID when 0 then 0 else s4.TRLOKASI_ID end||case s4.KDU1 when '00' then '' else s4.KDU1 end||case s4.KDU2 when '00' then '' else s4.KDU2 end||case s4.KDU3 when '000' then '' else s4.KDU3 end||case s4.KDU4 when '000' then '' else s4.KDU4 end||case s4.KDU5 when '00' then '' else s4.KDU5 end ");
//            $colMap['kdu5'] = array("column" => " s5.NMUNIT kdu5 ", "table" => " LEFT OUTER JOIN TR_STRUKTUR_ORGANISASI s5 ON VPJM.TRLOKASI_ID||VPJM.KDU1||VPJM.KDU2||VPJM.KDU3||VPJM.KDU4||VPJM.KDU5=case s5.TRLOKASI_ID when 0 then 0 else s5.TRLOKASI_ID end||case s5.KDU1 when '00' then '' else s5.KDU1 end||case s5.KDU2 when '00' then '' else s5.KDU2 end||case s5.KDU3 when '000' then '' else s5.KDU3 end||case s5.KDU4 when '000' then '' else s5.KDU4 end||case s5.KDU5 when '00' then '' else s5.KDU5 end ");

            $this->_column = $colMap;
        }
        return $this->_column;
    }

    protected $_selectColumn;

    function getSelectColumn() {
        if ($this->_selectColumn === null) {
            $colShow = array();
            $colShow['nip'] = 'NIP';
            $colShow['nama'] = 'Nama';
            $colShow['sex'] = 'Jenis Kelamin';
            $colShow['tgl_skcpns'] = 'Tanggal SK CPNS';
            $colShow['sk_cpns'] = 'SK CPNS';
            $colShow['tgl_skpns'] = 'Tanggal SK PNS';
            $colShow['sk_pns'] = 'SK PNS';
            $colShow['gol_pns'] = 'Pangkat PNS';
            $colShow['tmt_gol'] = 'TMT Golongan';
            $colShow['jabatan'] = 'Jabatan';
            $colShow['tmt_jabatan'] = 'TMT Jabatan';
            $colShow['pddk'] = 'Tingkat Pendidikan';
            $colShow['fakultas'] = 'Fakultas';
            $colShow['jurusan'] = 'Jurusan';
            $colShow['rwytpdk'] = 'Riwayat Pendidikan';
            $colShow['eselon'] = 'Eselon';
            $colShow['tmt_eselon'] = 'TMT Eselon';
            $colShow['agama'] = 'Agama';
            $colShow['gol_darah'] = 'Golongan Darah';
            $colShow['lbg_pddk'] = 'Lembaga Pendidikan';
            $colShow['thn_pddk'] = 'Tahun Kelulusan';
//            $colShow['gol_polri'] = 'Pangkat Polri';
            $colShow['nama_pim'] = 'Diklat PIM';
            $colShow['nama_teknis'] = 'Diklat Teknis';
            $colShow['nama_diklat_lain'] = 'Diklat Lain / Umum';
            $colShow['thn_pim'] = 'Tahun PIM';
            $colShow['prop_unit'] = 'Propinsi Unit';
            $colShow['kelompok_fungsional'] = 'Kelompok Fungsional';

            $colShow['sts_kawin'] = 'Status Pernikahan';
            $colShow['tgllahir'] = 'Tanggal Lahir';
            $colShow['usia'] = 'Usia';
            $colShow['prop_lahir'] = 'Propinsi Lahir';
            $colShow['kab_lahir'] = 'Kabupaten Lahir';

            $colShow['alamat'] = 'Alamat';
            $colShow['telp_hp'] = 'Telp HP';
            $colShow['telp_rmh'] = 'Telp Rumah';
            $colShow['hobi'] = 'Hobi';
            $colShow['karpeg'] = 'No KARPEG';
            $colShow['karis'] = 'No. Anggota KORPRI';
            $colShow['taspen'] = 'No. TASPEN';
            $colShow['no_ktp'] = 'No. KTP';
            $colShow['askes'] = 'No. ASKES';
            $colShow['kodepos'] = 'Kode Pos';
            $colShow['warna_kulit'] = 'Warna Kulit';
            // $colShow['keterangan_diklat'] = 'Keterangan Diklat';
            $colShow['foto'] = 'Foto';

//            $colShow['lok'] = 'Lokasi';
//            $colShow['kdu1'] = 'Unit Eselon I';
//            $colShow['kdu2'] = 'Unit Eselon II';
//            $colShow['kdu3'] = 'Unit Eselon III';
//            $colShow['kdu4'] = 'Unit Eselon IV';
//            $colShow['kdu5'] = 'Unit Eselon V';

            $this->_selectColumn = $colShow;
        }
        return $this->_selectColumn;
    }

    function get_data_xml() {
        $data = $this->get_data();
        $i = 0;
        $total_a = 0;
        foreach ($data as $row) {
            $total_a = $total_a + $row['a1'];
            $data_grid[$i]['unit'] = $row['unit'];
            $data_grid[$i]['total'] = $total_a;
            $i++;
        }
        return $data_grid;
    }

}

?>
