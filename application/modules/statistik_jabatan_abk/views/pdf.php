<style>
    .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
        line-height: 0.5;
    }
</style>
<?php
$nmstruktur = '<h2 class="text-center">' . $this->config->item('instansi_panjang') . "</h2>";
?>
<div class="col-md-12">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet light ">
        <div class="portlet-body">
            <h1 class="text-center">KOMPOSISI PEGAWAI MENURUT PENDIDIKAN</h1>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Periode <?php echo month_indo(date('m')) . " " . date("Y") ?></h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered table-hover table-striped table-advance">
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align:middle;text-align: center">NO</th>
                            <th rowspan="2" style="vertical-align:middle;width: 30%;text-align: center">Nama Kantor Sar</th>
                            <th colspan="<?php echo count($jenjang_fungsional) ?>" class="text-center">Jenjang</th>
                            <th rowspan="2" class="text-center">Jumlah</th>
                            <th rowspan="2" class="text-center">Calon Rescuer</th>
                            <th rowspan="2" class="text-center">Total</th>
                        </tr>
                        <tr>
                            <?php if ($jenjang_fungsional) { ?>
                                <?php foreach ($jenjang_fungsional as $val) { ?>
                                    <th class="text-center"><?php echo ucwords(strtolower($val['TINGKAT_FUNGSIONAL'])) ?></th>
                                <?php } ?>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlstruktur = "SELECT * FROM ((SELECT NMUNIT,TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5,TKTESELON,1 as URUT,URUTAN FROM TR_STRUKTUR_ORGANISASI WHERE   
                        TRLOKASI_ID=2 and KDU1 = '00') UNION (SELECT NMUNIT,TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5,TKTESELON,1 as URUT,URUTAN FROM TR_STRUKTUR_ORGANISASI WHERE   
                        TRLOKASI_ID=4 and TKTESELON='3' AND KDU3 <> '017') UNION (SELECT NMUNIT,TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5,TKTESELON,1 as URUT,URUTAN FROM TR_STRUKTUR_ORGANISASI WHERE   
                        TRLOKASI_ID=4 and TKTESELON='4' AND KDU3 = '017')) XYZ ORDER BY URUTAN ASC";
                        $data = $this->db->query($sqlstruktur)->result_array();
                        $k = 1;
                        $totalcalon = 0;
                        $temp_where = '';
                        $tempr_where = '';
                        foreach ($data as $val) {
                            ?>
                            <tr>
                                <td class="text-center"><?= $k ?></td>
                                <td><?php echo $val['NMUNIT'] ?></td>
                                <?php
                                if ($val['TRLOKASI_ID'] == '2') {
                                    $temp_where = " and TRLOKASI_ID=2 ";
                                }

                                if ($val['TRLOKASI_ID'] == '4') {
                                    $temp_where = " and TRLOKASI_ID=4 ";
                                }

                                $tempr_where = '';
                                if ($val['TKTESELON'] == '3') {
                                    $tempr_where = " and KDU1 = '" . $val['KDU1'] . "' and KDU2 = '" . $val['KDU2'] . "' and KDU3 ='" . $val['KDU3'] . "' ";
                                }
                                if ($val['TKTESELON'] == '4') {
                                    $tempr_where = " and KDU1 = '" . $val['KDU1'] . "' and KDU2 = '" . $val['KDU2'] . "' and KDU3 ='" . $val['KDU3'] . "' and KDU4 ='" . $val['KDU4'] . "' ";
                                }
                                $totaljenjang = 0;
                                if ($jenjang_fungsional) {
                                    foreach ($jenjang_fungsional as $isinya) {
                                        $sqlnya = "select count(MJPV.TMPEGAWAI_ID) as jmlpegawai from V_PEGAWAI_JABATAN_MUTAKHIR MJPV where MJPV.TRESELON_ID != '17' and MJPV.TRJABATAN_ID = '" . $isinya['ID'] . "' $temp_where $tempr_where ";
                                        $hasilnya = $this->db->query($sqlnya)->row_array();
                                        ?>
                                        <td class="text-center"><?php echo $hasilnya['JMLPEGAWAI'] ?></td>
                                        <?php
                                        $totaljenjang += $hasilnya['JMLPEGAWAI'];
                                    }
                                }
                                ?>
                                <td><?php echo $totaljenjang ?></td>
                                <?php
                                $sqlnih = "select count(MJPV.TMPEGAWAI_ID) as jmlpegawai from V_PEGAWAI_JABATAN_MUTAKHIR MJPV where MJPV.TRESELON_ID != '17' and MJPV.TRJABATAN_ID = '2119' $temp_where $tempr_where ";
                                $hasilnih = $this->db->query($sqlnih)->row_array();
                                ?>
                                <td class="text-center"><?php echo $hasilnih['JMLPEGAWAI'] ?></td>
                                <td class="text-center"><?php echo $totaljenjang + $hasilnih['JMLPEGAWAI'] ?></td>
                            </tr>
                            <?php
                            $k++;
                            $totalcalon += $hasilnih['JMLPEGAWAI'];
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-center">Total</th>
                            <?php
                            $hasiltotal = 0;
                            if ($jenjang_fungsional) {
                                ?>
                                <?php foreach ($jenjang_fungsional as $val) { ?>
                                    <?php
                                    $sqlnya = "select count(MJPV.TMPEGAWAI_ID) as jmlpegawai from V_PEGAWAI_JABATAN_MUTAKHIR MJPV where MJPV.TRESELON_ID != '17' and MJPV.TRJABATAN_ID = '" . $val['ID'] . "' ";
                                    $hasilnya = $this->db->query($sqlnya)->row_array();
                                    ?>
                                    <th class="text-center"><?php echo $hasilnya['JMLPEGAWAI'] ?></th>
                                        <?php
                                        $hasiltotal += $hasilnya['JMLPEGAWAI'];
                                    }
                                    ?>
                                <?php } ?>
                            <th class="text-center"><?php echo $hasiltotal ?></th>
                            <th class="text-center"><?php echo $totalcalon ?></th>
                            <th class="text-center"><?php echo $hasiltotal + $totalcalon ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>