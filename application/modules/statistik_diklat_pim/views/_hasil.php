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
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("statistik_diklat_pim/export_excel_1") ?>">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </a>
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("statistik_diklat_pim/print_pdf_1") ?>">
                        <i class="fa fa-file-pdf-o"></i> Pdf
                    </a>
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <h1 class="text-center">KOMPOSISI PEGAWAI</h1>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Periode <?php echo date("Y") ?></h3>
            <h3 class="text-center">Menurut Diklat PIM per-Lokasi Unit Kerja</h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered table-hover table-striped table-advance">
                    <thead>
                        <tr>
                            <th class="text-center" rowspan="2" style="width: 5%;vertical-align: middle"> No </th>
                            <th class="text-center" style="width: 30%;vertical-align: middle" rowspan="2"> Unit Kerja </th>
                            <th class="text-center" colspan="2"> PIM IV </th>
                            <th class="text-center" colspan="2"> PIM III </th>
                            <th class="text-center" colspan="2"> PIM II </th>
                            <th class="text-center" colspan="2"> PIM I </th>
                            <th class="text-center" colspan="2"> Lemhanas </th>
                            <th class="text-center" colspan="2"> Jumlah </th>
                        </tr>
                        <tr>
                            <th>(L)</th>
                            <th>(P)</th>
                            <th>(L)</th>
                            <th>(P)</th>
                            <th>(L)</th>
                            <th>(P)</th>
                            <th>(L)</th>
                            <th>(P)</th>
                            <th>(L)</th>
                            <th>(P)</th>
                            <th>(L)</th>
                            <th>(P)</th>
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
                            <td class="text-center">11</td>
                            <td class="text-center">12</td>
                            <td class="text-center">13</td>
                            <td class="text-center">14</td>
                        </tr>
                        <?php if ($model): ?>
                            <?php
                            $i = 1;
                            $urutanunitkerja = '';
                            $no_parent = 1;
                            $total_es4l = 0;
                            $total_es4p = 0;
                            $total_es3l = 0;
                            $total_es3p = 0;
                            $total_es2l = 0;
                            $total_es2p = 0;
                            $total_es1l = 0;
                            $total_es1p = 0;
                            $total_es1_fk_l = 0;
                            $total_es1_fk_p = 0;
                            $total_es1_fu_l = 0;
                            $total_es1_fu_p = 0;
                            $sum_l = 0;
                            $sum_p = 0;
                            $sum = 0;
                            $pim_tk4_l = 0;
                            $pim_tk4_p = 0;
                            $pim_tk3_l = 0;
                            $pim_tk3_p = 0;
                            $pim_tk2_l = 0;
                            $pim_tk2_p = 0;
                            $pim_tk1_l = 0;
                            $pim_tk1_p = 0;
                            $lemhanas_l = 0;
                            $lemhanas_p = 0;
                            $es1_fu_l = 0;
                            $es1_fu_p = 0;
                            $tot_sum_l = 0;
                            $tot_sum_p = 0;
                            $tot_sum = 0;
                            $tot_sum_l_all = 0;
                            $tot_sum_p_all = 0;
                            $tot_sum_all = 0;
                            foreach ($model as $val):
                                $sum_l_all = $val['PIM_TK4_L'] + $val['PIM_TK3_L'] + $val['PIM_TK2_L'] + $val['PIM_TK1_L'] + $val['LEMHANAS_L'];
                                $sum_p_all = $val['PIM_TK4_P'] + $val['PIM_TK3_P'] + $val['PIM_TK2_P'] + $val['PIM_TK1_P'] + $val['LEMHANAS_P'];
                                $sum_l = $val['PIM_TK4_L'] + $val['PIM_TK3_L'] + $val['PIM_TK2_L'] + $val['PIM_TK1_L'] + $val['LEMHANAS_L'];
                                $sum_p = $val['PIM_TK4_P'] + $val['PIM_TK3_P'] + $val['PIM_TK2_P'] + $val['PIM_TK1_P'] + $val['LEMHANAS_P'];
                                $sum_all = $val['PIM_TK4_P'] + $val['PIM_TK3_P'] + $val['PIM_TK2_P'] + $val['PIM_TK1_P'] + $val['LEMHANAS_P'] + $val['PIM_TK4_L'] + $val['PIM_TK3_L'] + $val['PIM_TK2_L'] + $val['PIM_TK1_L'] + $val['LEMHANAS_L'];
                                $sum = $sum_l + $sum_p;
                                $total_es4l = $total_es4l + $val['PIM_TK4_L'];
                                $total_es4p = $total_es4p + $val['PIM_TK4_P'];
                                $total_es3l = $total_es3l + $val['PIM_TK3_L'];
                                $total_es3p = $total_es3p + $val['PIM_TK3_P'];
                                $total_es2l = $total_es2l + $val['PIM_TK2_L'];
                                $total_es2p = $total_es2p + $val['PIM_TK2_P'];
                                $total_es1l = $total_es1l + $val['PIM_TK1_L'];
                                $total_es1p = $total_es1p + $val['PIM_TK1_P'];
                                $total_es1_fk_l = $total_es1_fk_l + $val['LEMHANAS_L'];
                                $total_es1_fk_p = $total_es1_fk_p + $val['LEMHANAS_P'];

                                $pim_tk4_l = $pim_tk4_l + $val['PIM_TK4_L'];
                                $pim_tk4_p = $pim_tk4_p + $val['PIM_TK4_P'];
                                $pim_tk3_l = $pim_tk3_l + $val['PIM_TK3_L'];
                                $pim_tk3_p = $pim_tk3_p + $val['PIM_TK3_P'];
                                $pim_tk2_l = $pim_tk2_l + $val['PIM_TK2_L'];
                                $pim_tk2_p = $pim_tk2_p + $val['PIM_TK2_P'];
                                $pim_tk1_l = $pim_tk1_l + $val['PIM_TK1_L'];
                                $pim_tk1_p = $pim_tk1_p + $val['PIM_TK1_P'];
                                $lemhanas_l = $lemhanas_l + $val['LEMHANAS_L'];
                                $lemhanas_p = $lemhanas_p + $val['LEMHANAS_P'];

                                $tot_sum_l = $tot_sum_l + $sum_l;
                                $tot_sum_l_all = $tot_sum_l_all + $sum_l_all;
                                $tot_sum_p_all = $tot_sum_p_all + $sum_p_all;
                                $tot_sum_all = $tot_sum_all + $sum_all;
                                $tot_sum_p = $tot_sum_p + $sum_p;
                                $tot_sum = $tot_sum + $sum;
                                ?>
                                <tr>
                                    <td class="text-center"> <?php echo $i ?> </td>
                                    <td> <?php echo $val['LOKASI_UNIT'] ?> </td>
                                    <td class="text-center"> <?php echo $val['PIM_TK4_L'] ?> </td>
                                    <td class="text-center"> <?php echo $val['PIM_TK4_P'] ?> </td>
                                    <td class="text-center"> <?php echo $val['PIM_TK3_L'] ?> </td>
                                    <td class="text-center"> <?php echo $val['PIM_TK3_P'] ?> </td>
                                    <td class="text-center"> <?php echo $val['PIM_TK2_L'] ?> </td>
                                    <td class="text-center"> <?php echo $val['PIM_TK2_P'] ?> </td>
                                    <td class="text-center"> <?php echo $val['PIM_TK1_L'] ?> </td>
                                    <td class="text-center"> <?php echo $val['PIM_TK1_P'] ?> </td>
                                    <td class="text-center"> <?php echo $val['LEMHANAS_L'] ?> </td>
                                    <td class="text-center"> <?php echo $val['LEMHANAS_P'] ?> </td>
                                    <td class="text-center"> <?php echo $sum_l ?> </td>
                                    <td class="text-center"> <?php echo $sum_p ?> </td>
                                </tr>
                                <?php
                                $i++;
                            endforeach
                            ?>
                            <tr>
                                <td colspan="2" class="text-center">Jumlah Keseluruhan</td>
                                <td class="text-center"><?= $total_es4l ?></td>
                                <td class="text-center"><?= $total_es4p ?></td>
                                <td class="text-center"><?= $total_es3l ?></td>
                                <td class="text-center"><?= $total_es3p ?></td>
                                <td class="text-center"><?= $total_es2l ?></td>
                                <td class="text-center"><?= $total_es2p ?></td>
                                <td class="text-center"><?= $total_es1l ?></td>
                                <td class="text-center"><?= $total_es1p ?></td>
                                <td class="text-center"><?= $total_es1_fk_l ?></td>
                                <td class="text-center"><?= $total_es1_fk_p ?></td>
                                <td class="text-center"><?= $tot_sum_l_all ?></td>
                                <td class="text-center"><?= $tot_sum_p_all ?></td>
                            </tr>
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