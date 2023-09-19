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
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("laporan_hukdis/export_excel") ?>">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </a>
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("laporan_hukdis/export_pdf") ?>">
                        <i class="fa fa-file-pdf-o"></i> Pdf
                    </a>
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <h1 class="text-center">Daftar Hukuman Disiplin / Sanksi</h1>
            <h2 class="text-center">Dengan Tingkat Hukuman Disiplin / Sanksi <?=$title['TKT_HUKUMAN_DISIPLIN'];?></h2>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Sampai Dengan <?php echo month_indo(date('m')) . " " . date("Y") ?></h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered table-hover table-striped table-advance">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%"> No </th>
                            <th class="text-left"> NIP </th>
                            <th class="text-left"> Nama </th>
                            <th class="text-left"> Tingkat Hukuman </th>
                            <th class="text-left"> Jenis Hukuman </th>
                            <th class="text-left"> Alasan Hukuman </th>
                            <th class="text-left"> TMT Hukuman </th>
                            <th class="text-left"> Nomor / Tanggal SK </th>
                            <th class="text-center"> Unit Kerja </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">2</td>
                            <td class="text-center">3</td>
                            <td class="text-center">4</td>
                            <td class="text-center">5</td>
                            <td class="text-center">6</td>
                            <td class="text-center">7</td>
                            <td class="text-center">8</td>
                            <td class="text-center">9</td>
                        </tr>
                        <?php if ($model): ?>
                            <?php
                            $t = 1;
                            foreach ($model as $val):
                                $nama = ((!empty($val['GELAR_DEPAN'])) ? $val['GELAR_DEPAN'] . " " : "") . ($val['NAMA']) . ((!empty($val['GELAR_BLKG'])) ? ", " . $val['GELAR_BLKG'] : '');
                                ?>
                                <tr>
                                    <td class="text-center"> <?php echo $t ?> </td>
                                    <td> <?php echo $val['NIPNEW'] ?> </td>
                                    <td> <?php echo $nama ?> </td>
                                    <td> <?php echo $val['TKT_HUKUMAN_DISIPLIN'] ?> </td>
                                    <td> <?php echo $val['JENIS_HUKDIS'] ?> </td>
                                    <td> <?php echo (!empty($val['ALASAN_HKMN'])) ? $val['ALASAN_HKMN'] : '' ?> </td>
                                    <td> <?php echo $val['TMT_HKMN2']." S/D ".$val['AKHIR_HKMN2'] ?> </td>
                                    <td> <?php echo $val['NO_SK']." ".$val['TGL_SK2'] ?> </td>
                                    <td> <?php echo $val['NAMA_UNIT_KERJA'] ?> </td>
                                </tr>
                                <?php
                                $t++;
                            endforeach
                            ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3"> Maaf data tidak ditemukan </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>