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
                    <!-- a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php // echo site_url("statistik_golongan/export_excel")               ?>">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </a -->
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("statistik_jk/export_pdf") ?>">
                        <i class="fa fa-file-pdf-o"></i> Pdf
                    </a>
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <h1 class="text-center">KOMPOSISI PEGAWAI BERDASARKAN JENIS KELAMIN</h1>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Periode <?php echo month_indo(date('m')) . " " . date("Y") ?></h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered table-hover table-striped table-advance">
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align:middle;text-align: center;width:5%">NO</th>
                            <th rowspan="2" style="vertical-align:middle;width: 30%;text-align: center">Nama Kantor Sar</th>
                            <th class="text-center" colspan="2">Jenis Kelamin</th>
                            <th rowspan="2" class="text-center" style="width: 10%">Jumlah</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="width: 10%">Laki-laki</th>
                            <th class="text-center" style="width: 10%">Perempuan</th>
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
                                        <?= $val['JML_L'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_P'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JML_P'] + $val['JML_L'] ?>
                                    </td>
                                </tr>
                                <?php
                                $totalbwhiv_e += $val['JML_L'];
                                $totalbwhiv_d += $val['JML_P'];
                                $totalsamping += $val['JML_L'] + $val['JML_P'];
                                $k++;
                            endforeach;
                            ?>
                        <?php endif ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-center">Total</th>
                            <th class="text-center"><?php echo $totalbwhiv_e ?></th>
                            <th class="text-center"><?php echo $totalbwhiv_d ?></th>
                            <th class="text-center"><?php echo $totalsamping ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>