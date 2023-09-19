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
        <div class="portlet-title">
            <div class="caption">&nbsp;</div>
            <div class="actions">
                <div class="btn-group btn-group-devided" data-toggle="buttons">
                    <!-- a class="btn btn-transparent red btn-outline btn-circle btn-sm">
                        <i class="fa fa-print"></i> Print
                    </a -->
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("statistik_pendidikan/export_excel")  ?>">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </a>
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("statistik_pendidikan/export_pdf") ?>">
                        <i class="fa fa-file-pdf-o"></i> Pdf
                    </a>
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <h1 class="text-center">KOMPOSISI PEGAWAI MENURUT PENDIDIKAN</h1>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Periode <?php echo month_indo(date('m')) . " " . date("Y") ?></h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered table-hover table-striped table-advance">
                    <thead>
                        <tr>
                            <th style="vertical-align:middle;text-align: center">NO</th>
                            <th style="vertical-align:middle;width: 30%;text-align: center">NAMA KANTOR SAR</th>
                            <th class="text-center">S3</th>
                            <th class="text-center">S2</th>
                            <th class="text-center">Profesi</th>
                            <th class="text-center">S1</th>
                            <th class="text-center">D4</th>
                            <th class="text-center">D3</th>
                            <th class="text-center">D2</th>
                            <th class="text-center">D1</th>
                            <th class="text-center">SLTA</th>
                            <th class="text-center">SLTP</th>
                            <th class="text-center">SD</th>
                            <th class="text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data_komposisi): ?>
                            <?php
                            $k = 1;
                            $jmlcpnssamping = 0;
                            $totalbwhiv_e = 0;
                            $totalbwhiv_d = 0;
                            $totalbwhiv_c = 0;
                            $totalbwhiv_b = 0;
                            $totalbwhiv_a = 0;
                            $totalbwhiii_d = 0;
                            $totalbwhiii_c = 0;
                            $totalbwhiii_b = 0;
                            $totalbwhiii_a = 0;
                            $totalbwhii_d = 0;
                            $totalbwhii_c = 0;
                            $totalbwhii_b = 0;
                            $totalbwhii_a = 0;
                            $totalbwhi_d = 0;
                            $totaliv = 0;
                            $totaliii = 0;
                            $totalii = 0;
                            $totalsamping = 0;
                            $totalcpnsbawah = 0;
                            foreach ($data_komposisi as $val):
                                ?>
                                <tr>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $k; ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:left;">
                                        <?= $val['NMUNIT'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_S3'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_S2'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_PROFESI'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_S1'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_D4'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_D3'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_D2'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_D1'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_SMA'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_SMP'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_SD'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_SD'] + $val['JML_SMP'] + $val['JML_SMA'] + $val['JML_D1'] + $val['JML_D2'] + $val['JML_D3'] + $val['JML_D4'] + $val['JML_PROFESI'] + $val['JML_S1'] + $val['JML_S2'] + $val['JML_S3'] ?>
                                    </td>
                                </tr>
                                <?php
                                $totalbwhiv_e += $val['JML_S3'];
                                $totalbwhiv_d += $val['JML_S2'];
                                $totalbwhiv_b += $val['JML_PROFESI'];
                                $totalbwhiv_c += $val['JML_S1'];
                                $totalbwhiv_a += $val['JML_D4'];
                                $totalbwhiii_d += $val['JML_D3'];
                                $totalbwhiii_c += $val['JML_D2'];
                                $totalbwhiii_b += $val['JML_D1'];
                                $totalbwhiii_a += $val['JML_SMA'];
                                $totalbwhii_d += $val['JML_SMP'];
                                $totalbwhii_c += $val['JML_SD'];
                                $totalsamping += $val['JML_SD'] + $val['JML_SMP'] + $val['JML_SMA'] + $val['JML_D1'] + $val['JML_D2'] + $val['JML_D3'] + $val['JML_D4'] + $val['JML_PROFESI'] + $val['JML_S1'] + $val['JML_S2'] + $val['JML_S3'];
                                $k++;
                            endforeach;
                            ?>
                            <tr>
                                <td style="text-align:center;" colspan="2">Total</td>
                                <td style="text-align:center;"><?= $totalbwhiv_e; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiv_d; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiv_b; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiv_c; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiv_a; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiii_d; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiii_c; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiii_b; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiii_a; ?></td>
                                <td style="text-align:center;"><?= $totalbwhii_d; ?></td>
                                <td style="text-align:center;"><?= $totalbwhii_c; ?></td>
                                <td style="text-align:center;"><?= $totalsamping; ?></td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>