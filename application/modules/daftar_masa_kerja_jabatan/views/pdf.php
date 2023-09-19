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
            <div class="actions">&nbsp;</div>
        </div>
        <div class="portlet-body">
            <h1 class="text-center">Daftar Masa Kerja Jabatan</h1>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Periode <?php echo month_indo(date('m')) . " " . date("Y") ?></h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered table-hover table-striped table-advance">
                    <thead>
                        <tr>
                            <th class="text-center"> No </th>
                            <th class="text-center"> Nama </th>
                            <th class="text-center"> NIP / NRP </th>
                            <th class="text-center"> Eselon </th>
                            <th class="text-center"> Pangkat / Golongan </th>
                            <th class="text-center"> TMT Golongan </th>
                            <th class="text-center"> Jabatan </th>
                            <th class="text-center"> TMT Jabatan </th>
                            <th class="text-center"> Masa Kerja Jabatan </th>
                            <th class="text-center"> Diklat Kepemimpinan </th>
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
                            <td class="text-center">10</td>
                        </tr>
                        <?php if ($model): ?>
                            <?php
                            $t = 1;
                            foreach ($model as $val):
                                $nama = ((!empty($val['GELAR_DEPAN'])) ? $val['GELAR_DEPAN'] . " " : "") . ($val['NAMA']) . ((!empty($val['GELAR_BLKG'])) ? ", " . $val['GELAR_BLKG'] : '');
                                ?>
                                <tr>
                                    <td class="text-center"> <?php echo $t ?> </td>
                                    <td> <?php echo $nama ?> </td>
                                    <td> <?php echo $val['NIPNEW'] ?> </td>
                                    <td> <?php echo $val['ESELON'] ?> </td>
                                    <td> <?php echo ($val['TRSTATUSKEPEGAWAIAN_ID'] == 1) ? $val['PANGKAT'] . " (" . $val['GOLONGAN'] . ")" : $val['PANGKAT'] ?> </td>
                                    <td> <?php echo $val['TMT_GOL'] ?> </td>
                                    <td> <?php echo $val['N_JABATAN'] ?> </td>
                                    <td> <?php echo $val['TMT_JABATAN'] ?> </td>
                                    <td> <?php echo $val['TAHUN']." Tahun ".$val['BULAN']." Bulan ".$val['HARI']." Hari" ?> </td>
                                    <td class="text-left">
                                        <?php if ($val['DIKLATPIM']): ?>
                                            <ol>
                                            <?php foreach ($val['DIKLATPIM'] as $diklat): ?>
                                                <li class="text-left"><? echo $diklat['NAMA_JENJANG'] ?></li>
                                            <?php endforeach ?>
                                            </ol>
                                        <?php endif; ?>
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