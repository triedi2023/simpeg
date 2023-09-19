<style>
    .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
        line-height: 0.5;
    }
    div.vrt-header {
        margin-left: -105px;
        position: absolute;
        width: 215px;
        margin-top: -130px;
        transform: rotate(-90deg);
        -webkit-transform: rotate(-90deg); /* Safari/Chrome */
        -moz-transform: rotate(-90deg); /* Firefox */
        -o-transform: rotate(-90deg); /* Opera */
        -ms-transform: rotate(-90deg); /* IE 9 */
    }
    th.vrt-header
    {
        height: 250px;
        line-height: 50px;
        padding-bottom: 0px;
        text-align: left;
    }
</style>
<?php
$nmstruktur = '<h2 class="text-center">' . $this->config->item('instansi_panjang') . "</h2>";
?>
<div class="col-md-12">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">&nbsp;</div>
            <div class="actions">
                <div class="btn-group btn-group-devided" data-toggle="buttons">
                    <!-- a class="btn btn-transparent red btn-outline btn-circle btn-sm">
                        <i class="fa fa-print"></i> Print
                    </a -->
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("statistik_jabatan_abk/export_excel")                   ?>">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </a>
                    <!-- a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php // echo site_url("statistik_jabatan_abk/export_pdf") ?>">
                        <i class="fa fa-file-pdf-o"></i> Pdf
                    </a -->
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <h1 class="text-center">KOMPOSISI PEGAWAI</h1>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Periode <?php echo month_indo(date('m')) . " " . date("Y") ?></h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered table-hover table-striped table-advance">
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align:middle;text-align: center">NO</th>
                            <th rowspan="2" style="vertical-align:middle;width: 30%;text-align: center">Nama Kantor Sar</th>
                            <th colspan="<?php echo count($list_jabatan) ?>" class="text-center">Jabatan ABK</th>
                            <th rowspan="2" class="text-center" style="vertical-align: middle">Total</th>
                        </tr>
                        <tr>
                            <?php if ($list_jabatan) { ?>
                                <?php foreach ($list_jabatan as $val) { ?>
                                    <th class="text-center vrt-header" style="text-align: center"><div class="vrt-header"><?php echo ucwords(strtolower($val['JABATAN'])) ?></div></th>
                                <?php } ?>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlstruktur = "SELECT * FROM ((SELECT NMUNIT,TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5,TKTESELON,1 as URUT,URUTAN,SUSUNAN FROM TR_STRUKTUR_ORGANISASI WHERE   
                        TRLOKASI_ID=2 and KDU1 = '00' AND STATUS=1) UNION (SELECT NMUNIT,TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5,TKTESELON,2 as URUT,URUTAN,SUSUNAN FROM TR_STRUKTUR_ORGANISASI WHERE   
                        TRLOKASI_ID=4 and TKTESELON='3' AND KDU3 <> '017' AND STATUS=1) UNION (SELECT NMUNIT,TRLOKASI_ID,KDU1,KDU2,KDU3,KDU4,KDU5,TKTESELON,3 as URUT,URUTAN,SUSUNAN FROM TR_STRUKTUR_ORGANISASI WHERE   
                        TRLOKASI_ID=4 and TKTESELON='4' AND KDU3 = '017' AND STATUS=1)) XYZ ORDER BY URUT,SUSUNAN ASC";
                        $data = $this->db->query($sqlstruktur)->result_array();
                        $k = 1;
                        $totalcalon = 0;
                        $temp_where = '';
                        $tempr_where = '';
                        $jmlbawah = [];
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
                                if ($list_jabatan) {
                                    $yeah = 1;
                                    foreach ($list_jabatan as $isinya) {
                                        $sqlnya = "select count(MJPV.TRJABATAN_ID) as jmlpegawai from V_PEGAWAI_JABATAN_MUTAKHIR MJPV where MJPV.TRESELON_ID != '17' and MJPV.TRJABATAN_ID = '" . $isinya['TRJABATAN_ID'] . "' $temp_where $tempr_where ";
                                        $hasilnya = $this->db->query($sqlnya)->row_array();
                                        ?>
                                            <td class="text-center"><a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_jabatan_abk/liststatistik" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-jabatan="<?php echo $isinya['TRJABATAN_ID'] ?>" data-nmjabatan="<?php echo $isinya['JABATAN'] ?>" title="<?php echo $isinya['JABATAN'] ?>"><?php echo $hasilnya['JMLPEGAWAI'] ?></a></td>
                                        <?php
                                        $totaljenjang += $hasilnya['JMLPEGAWAI'];
                                        $jmlbawah[$yeah][] = $hasilnya['JMLPEGAWAI'];
                                        $yeah++;
                                    }
                                }
                                ?>
                                <td class="text-center"><?php echo $totaljenjang ?></td>
                            </tr>
                            <?php
                            $k++;
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-center">Total</th>
                            <?php if ($list_jabatan) { ?>
                                <?php $sip=1;$jmlsemua=0; foreach ($list_jabatan as $val) { ?>
                                    <th class="text-center"><?php echo array_sum($jmlbawah[$sip]) ?></th>
                                <?php $jmlsemua += array_sum($jmlbawah[$sip]);$sip++;} ?>
                                <th class="text-center"><?php echo $jmlsemua ?></th>
                            <?php } ?>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>