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
                    <!--a class="btn btn-transparent red btn-outline btn-circle btn-sm">
                        <i class="fa fa-print"></i> Print
                    </a -->
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("monitoring_pensiun_fungsional/export_excel") ?>">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </a>
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("monitoring_pensiun_fungsional/export_pdf") ?>">
                        <i class="fa fa-file-pdf-o"></i> Pdf
                    </a>
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <h1 class="text-center">Monitoring Pensiun Fungsional</h1>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Periode <?php echo month_indo(date('m')) . " " . date("Y") ?></h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered table-hover table-striped table-advance">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%"> No </th>
                            <th class="text-center" style="width: 18%"> Nama / NIP </th>
                            <th class="text-center" style="width: 10%"> Gol Ruang </th>
                            <th class="text-center"> Jabatan<br />a. TMT Jabatan </th>
                            <th class="text-center" style="width: 10%"> Pendidikan </th>
                            <th class="text-center" style="width: 10%"> Masa Kerja<br />(Tahun / Bulan) </th>
                            <th class="text-center" style="width: 10%"> TMT Pensiun </th>
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
                        </tr>
                        <?php if ($model): ?>
                            <?php
                            $t = 1;
                            foreach ($model as $val):
                                $nama = ((!empty($val['GELAR_DEPAN'])) ? $val['GELAR_DEPAN'] . " " : "") . ($val['NAMA']) . ((!empty($val['GELAR_BLKG'])) ? ", " . $val['GELAR_BLKG'] : '');
                                ?>
                                <tr>
                                    <td class="text-center"> <?php echo $t ?> </td>
                                    <td> <?php echo $nama."<br />"."NIP. ".$val['NIPNEW'] ?> </td>
                                    <td> <?php echo (($val['TRSTATUSKEPEGAWAIAN_ID'] == '1') ? $val['PANGKAT']." (".$val['GOLONGAN_RUANG'].") " : $val['PANGKAT']) ?> </td>
                                    <td> <?php echo $val['N_JABATAN']."<br />"."a. ".$val['TMT_JABATAN'] ?> </td>
                                    <td> <?php echo $val['TINGKAT_PENDIDIKAN'] ?> </td>
                                    <td> <?php echo $val['MK_THN_TOTAL']." Tahun ".$val['MK_BLN_TOTAL']." Bulan" ?> </td>
                                    <td> <?php echo $val['TMT_PENSIUN_CHAR'] ?> </td>
                                </tr>
                                <?php
                                $t++;
                            endforeach
                            ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6"> Maaf data tidak ditemukan </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>