<style>
    .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
        line-height: 0.5;
    }
</style>
<?php
$nmstruktur = '<h2 class="text-center">' . $this->config->item('instansi_panjang') . "</h2>";
if ($struktur):
    $nmstruktur = '';
    $pecah = explode(", ", $struktur['NMSTRUKTUR']);
    $nm4 = '';
    if (isset($pecah[0]) && !empty($pecah[0])) {
        $nmstruktur .= '<h2 class="text-center">' . $pecah[0] . "</h2>";
    }
    $nm3 = '';
    if (isset($pecah[1]) && !empty($pecah[1])) {
        $nmstruktur .= '<h2 class="text-center">' . $pecah[1] . "</h2>";
    }
    $nm2 = '';
    if (isset($pecah[2]) && !empty($pecah[2])) {
        $nmstruktur .= '<h2 class="text-center">' . $pecah[2] . "</h2>";
    }
    $nm1 = '';
    if (isset($pecah[3]) && !empty($pecah[3])) {
        $nmstruktur .= '<h2 class="text-center">' . $pecah[3] . "</h2>";
    }
    $nm0 = '';
    if (isset($pecah[4]) && !empty($pecah[4])) {
        $nmstruktur .= '<h2 class="text-center">' . $pecah[4] . "</h2>";
    }
    $nmstruktur .= '<h2 class="text-center">' . $this->config->item('instansi_panjang') . "</h2>";
endif;
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
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("laporan_diklat_pegawai/export_excel") ?>">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </a>
                    <!-- a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php // echo  site_url("laporan_diklat_pegawai/export_pdf") ?>">
                        <i class="fa fa-file-pdf-o"></i> Pdf
                    </a -->
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <h1 class="text-center">Laporan Diklat Pegawai</h1>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Periode <?php echo month_indo(date('m')) . " " . date("Y") ?></h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered table-hover table-striped table-advance">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;vertical-align: middle;"> No </th>
                            <th class="text-center" style="vertical-align: middle;"> NIP </th>
                            <th class="text-center" style="vertical-align: middle;"> Nama </th>
                            <th class="text-center" style="vertical-align: middle;"> Pendidikan </th>
                            <th class="text-center" style="vertical-align: middle;"> Diklat PIM<br />Tahun </th>
                            <th class="text-center" style="vertical-align: middle;"> Diklat Fungsional </th>
                            <th class="text-center" style="vertical-align: middle;"> Diklat Teknis </th>
                            <th class="text-center" style="vertical-align: middle;"> Diklat Lain </th>
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
                                    <td>
                                        <?php if ($val['pendidikan']): ?>
                                            <?php $k=1; foreach ($val['pendidikan'] as $isi): ?>
                                                <?php echo $k.". ".$isi['TINGKAT_PENDIDIKAN']." ".$isi['NAMA_JURUSAN'].'<hr style="margin: 2px 0" />' ?>
                                            <?php $k++;endforeach ?>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if ($val['diklat_pim']): ?>
                                            <?php $k=1; foreach ($val['diklat_pim'] as $isi): ?>
                                                <?php echo $k.". ".$isi['NAMA_JENJANG']."<br />".$isi['THN_DIKLAT'].'<hr style="margin: 2px 0" />' ?>
                                            <?php $k++;endforeach ?>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if ($val['diklat_fungsional']): ?>
                                            <?php $k=1; foreach ($val['diklat_fungsional'] as $isi): ?>
                                                <?php echo $k.". ".$isi['JENIS_DIKLAT_FUNGSIONAL']."<br />".$isi['KELOMPOK_FUNGSIONAL']." ".$isi['PENJENJANGAN_FUNGSIONAL']." ".$isi['NAMA_PENJENJANGAN'].'<hr style="margin: 2px 0" />' ?>
                                            <?php $k++;endforeach ?>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if ($val['diklat_teknis']): ?>
                                            <?php $k=1; foreach ($val['diklat_teknis'] as $isi): ?>
                                                <?php echo $k.". ".$isi['KETERANGAN'].'<hr style="margin: 2px 0" />' ?>
                                            <?php $k++;endforeach ?>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if ($val['diklat_lain']): ?>
                                            <?php $k=1; foreach ($val['diklat_lain'] as $isi): ?>
                                                <?php echo $k.". ".$isi['NAMA_DIKLAT'].'<hr style="margin: 2px 0" />' ?>
                                            <?php $k++;endforeach ?>
                                        <?php endif ?>
                                    </td>
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