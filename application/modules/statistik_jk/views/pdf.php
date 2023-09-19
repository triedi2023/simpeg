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
            <h1 class="text-center">KOMPOSISI PEGAWAI MENURUT JENIS KELAMIN</h1>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Periode <?php echo month_indo(date('m')) . " " . date("Y") ?></h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered" style="font-size: 12px;">
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
                            $totalbwhiv_e = 0;
                            $totalbwhiv_d = 0;
                            $totalsamping = 0;
                            foreach ($data_komposisi as $val):
                                ?>
                                <tr>
                                    <td>
                                        <?= $k; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $val['NMUNIT'] ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $val['JML_L'] ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $val['JML_P'] ?>
                                    </td>
                                    <td class="text-center">
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