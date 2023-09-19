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
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("daftar_nominatif/export_excel") ?>">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </a>
                    <!-- a class="btn btn-transparent red btn-outline btn-circle btn-sm">
                        <i class="fa fa-file-pdf-o"></i> Pdf
                    </a -->
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <h1 class="text-center">Daftar Nominatif</h1>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Periode <?php echo date("Y") ?></h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered table-hover table-striped table-advance">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center" style="width: 5%"> No </th>
                            <th class="text-center" style="width: 10%"> NIP </th>
                            <th class="text-center" style="width: 20%"> Nama </th>
                            <th class="text-center" style="width: 10%"> Pangkat / Gol </th>
                            <th class="text-center"> Jabatan </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center" colspan="2">1</td>
                            <td class="text-center">2</td>
                            <td class="text-center">3</td>
                            <td class="text-center">4</td>
                            <td class="text-center">5</td>
                        </tr>
                        <?php if ($model): ?>
                            <?php
                            $i = 1;
                            $urutanunitkerja = '';
                            foreach ($model as $val):
                                if ($val['TKTESELON'] == '1') {
                                    $urutanunitkerja = ($val['KDU1']);
                                } elseif ($val['TKTESELON'] == '2') {
                                    $urutanunitkerja = ($val['KDU2']);
                                } elseif ($val['TKTESELON'] == '3') {
                                    $urutanunitkerja = ($val['KDU3']);
                                } elseif ($val['TKTESELON'] == '4') {
                                    $urutanunitkerja = ($val['KDU4']);
                                } elseif ($val['TKTESELON'] == '5') {
                                    $urutanunitkerja = ($val['KDU5']);
                                }
                                
                                $nama = ((!empty($val['GELAR_DEPAN'])) ? $val['GELAR_DEPAN'] . " " : "") . ($val['NAMA']) . ((!empty($val['GELAR_BLKG'])) ? ", " . $val['GELAR_BLKG'] : '');
                                ?>
                                <?php
                                if (!empty($val['NMUNIT'])) {
                                ?>
                                    <tr>
                                        <td colspan="6" class="danger"> <?php echo Romawi($urutanunitkerja).". ".$val['NMUNIT'] ?> </td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td class="text-center"> <?php echo $val['NUMBERDUA'] ?> </td>
                                        <td class="text-center"> <?php echo $val['NUMBERTIGA'] ?> </td>
                                        <td> <?php echo $val['NIPNEW'] ?> </td>
                                        <td> <?php echo $nama ?> </td>
                                        <td class="text-center"> <?php echo ($val['TRSTATUSKEPEGAWAIAN_ID'] == '1') ? $val['PANGKAT'] . " (" . $val['GOLONGAN'] . ") " : $val['PANGKAT'] ?> </td>
                                        <td> <?php echo $val['JABATAN'] ?> </td>
                                    </tr>
                                <?php } ?>
                                <?php
                                $i++;
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