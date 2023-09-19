<style>
    .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
        line-height: 0.5;
    }
</style>
<?php
$jmlcpns = 0;
if ($komposisi_cpns) {
    $jmlcpns = count($komposisi_cpns);
}
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
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("statistik_golongan/export_excel") ?>">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </a>
                    <!-- a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php // echo site_url("statistik_golongan/export_pdf")          ?>">
                        <i class="fa fa-file-pdf-o"></i> Pdf
                    </a -->
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <h1 class="text-center">KOMPOSISI PEGAWAI MENURUT GOLONGAN</h1>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Periode <?php echo month_indo(date('m')) . " " . date("Y") ?></h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered table-hover table-striped table-advance order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th rowspan="4" style="vertical-align:middle;text-align: center">NO</th>
                            <th rowspan="4" style="vertical-align:middle;width: 30%;text-align: center">NAMA KANTOR SAR</th>
                            <th style="text-align:center;" colspan="17">GOLONGAN</th>
                            <?php if ($komposisi_cpns) { ?>
                                <th style="text-align: center;" <?php echo 'colspan="' . $jmlcpns . '"'; ?>>CPNS</th>
                            <?php } ?>
                            <th style="text-align: center;vertical-align: middle" rowspan="4">JML</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;" colspan="17">PEGAWAI NEGERI SIPIL</th>
                            <?php if ($komposisi_cpns) { ?>
                                <?php foreach ($komposisi_cpns as $val) { ?>
                                    <th style="text-align:center;vertical-align: middle"><?= $val['THN_GOL'] ?></th>
                                <?php } ?>
                            <?php } ?>
                        </tr>
                        <tr>
                            <th style="text-align:center;" colspan="5">IV</th>
                            <th style="text-align:center;vertical-align: middle" rowspan="2">JML</th>
                            <th style="text-align:center;" colspan="4">III</th>
                            <th style="text-align:center;vertical-align: middle" rowspan="2">JML</th>
                            <th style="text-align:center;" colspan="4">II</th>
                            <th style="text-align:center;vertical-align: middle" rowspan="2">JML</th>
                            <th style="text-align:center;">I</th>
                            <?php $totalbawah = []; if ($komposisi_cpns) { ?>
                                <?php foreach ($komposisi_cpns as $val) { $totalbawah[$val['TRGOLONGAN_ID']."_".$val['THN_GOL']] = []; ?>
                                    <th style="text-align:center;vertical-align: middle" rowspan="2"><?= $val['GOLONGAN'] ?></th>
                                <?php } ?>
                            <?php } ?>
                        </tr>
                        <tr>
                            <th style="text-align:center;">e</th>
                            <th style="text-align:center;">d</th>
                            <th style="text-align:center;">c</th>
                            <th style="text-align:center;">b</th>
                            <th style="text-align:center;">a</th>
                            <th style="text-align:center;">d</th>
                            <th style="text-align:center;">c</th>
                            <th style="text-align:center;">b</th>
                            <th style="text-align:center;">a</th>
                            <th style="text-align:center;">d</th>
                            <th style="text-align:center;">c</th>
                            <th style="text-align:center;">b</th>
                            <th style="text-align:center;">a</th>
                            <th style="text-align:center;">d</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;">1</th>
                            <th style="text-align:center;">2</th>
                            <th style="text-align:center;">3</th>
                            <th style="text-align:center;">4</th>
                            <th style="text-align:center;">5</th>
                            <th style="text-align:center;">6</th>
                            <th style="text-align:center;">7</th>
                            <th style="text-align:center;">8</th>
                            <th style="text-align:center;">9</th>
                            <th style="text-align:center;">10</th>
                            <th style="text-align:center;">11</th>
                            <th style="text-align:center;">12</th>
                            <th style="text-align:center;">13</th>
                            <th style="text-align:center;">14</th>
                            <th style="text-align:center;">15</th>
                            <th style="text-align:center;">16</th>
                            <th style="text-align:center;">17</th>
                            <th style="text-align:center;">18</th>
                            <th style="text-align:center;">19</th>
                            <?php
                            $lanjut = 20;
                            if ($komposisi_cpns) {
                                ?>
                                <?php foreach ($komposisi_cpns as $val) { ?>
                                    <th style="text-align:center;"><?php echo $lanjut; ?></th>
                                    <?php
                                    $lanjut++;
                                }
                                ?>
                            <?php } ?>
                            <th style="text-align:center;"><?php echo $lanjut; ?></th>
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
                            $totalcpnsbawah = 0;
                            $totalsamping = 0;
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
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'IV/X,IV/G,IV/F,IV/E' ?>" title="<?php echo 'IV/X,IV/G,IV/F,IV/E' ?>"><?= $val['JMLIV_E'] ?></a>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'IV/D,' ?>" title="<?php echo 'IV/D' ?>"><?= $val['JMLIV_D'] ?></a>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'IV/C' ?>" title="<?php echo 'IV/C' ?>"><?= $val['JMLIV_C'] ?></a>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'IV/B' ?>" title="<?php echo 'IV/B' ?>"><?= $val['JMLIV_B'] ?></a>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'IV/A' ?>" title="<?php echo 'IV/A' ?>"><?= $val['JMLIV_A'] ?></a>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLIV_A'] + $val['JMLIV_B'] + $val['JMLIV_C'] + $val['JMLIV_D'] + $val['JMLIV_E'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'III/D' ?>" title="<?php echo 'III/D' ?>"><?= $val['JMLIII_D'] ?></a>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'III/C' ?>" title="<?php echo 'III/C' ?>"><?= $val['JMLIII_C'] ?></a>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'III/B' ?>" title="<?php echo 'III/B' ?>"><?= $val['JMLIII_B'] ?></a>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'III/A' ?>" title="<?php echo 'III/A' ?>"><?= $val['JMLIII_A'] ?></a>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLIII_A'] + $val['JMLIII_B'] + $val['JMLIII_C'] + $val['JMLIII_D'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'II/D' ?>" title="<?php echo 'II/D' ?>"><?= $val['JMLII_D'] ?></a>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'II/C' ?>" title="<?php echo 'II/C' ?>"><?= $val['JMLII_C'] ?></a>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'II/B' ?>" title="<?php echo 'II/B' ?>"><?= $val['JMLII_B'] ?></a>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'II/A' ?>" title="<?php echo 'II/A' ?>"><?= $val['JMLII_A'] ?></a>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLII_A'] + $val['JMLII_B'] + $val['JMLII_C'] + $val['JMLII_D'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo 'I/D' ?>" title="<?php echo 'I/D' ?>"><?= $val['JMLI_D'] ?></a>
                                    </td>
                                    <?php
                                    $jmlcpnssamping = 0;
                                    if ($komposisi_cpns) {
                                        ?>
                                        <?php foreach ($komposisi_cpns as $isi) { ?>
                                            <td style=" width: 21pt; text-align:center;"><a href="javascript:;" class="popuplarge" data-url="<?php echo base_url()."statistik_golongan/liststatistikgolongan" ?>" data-lok="<?php echo $val['TRLOKASI_ID'] ?>" data-kdu1="<?php echo $val['KDU1'] ?>" data-kdu2="<?php echo $val['KDU2'] ?>" data-kdu3="<?php echo $val['KDU3'] ?>" data-kdu4="<?php echo $val['KDU4'] ?>" data-kdu5="<?php echo $val['KDU5'] ?>" data-gol="<?php echo strtoupper($isi['GOLONGAN']) ?>" data-cpns="<?php echo $isi['THN_GOL'] ?>" title="<?php echo strtoupper($isi['GOLONGAN']) ?>"><?php echo $val[$isi['TRGOLONGAN_ID'] . "_" . $isi['THN_GOL']]; ?></a></td>
                                            <?php
                                            $jmlcpnssamping += $val[$isi['TRGOLONGAN_ID'] . "_" . $isi['THN_GOL']];
                                            $totalbawah[$isi['TRGOLONGAN_ID'] . "_" . $isi['THN_GOL']][] = $val[$isi['TRGOLONGAN_ID'] . "_" . $isi['THN_GOL']];
                                        }
                                        ?>
                                    <?php } ?>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLIV_A'] + $val['JMLIV_B'] + $val['JMLIV_C'] + $val['JMLIV_D'] + $val['JMLIV_E'] + $val['JMLIII_A'] + $val['JMLIII_B'] + $val['JMLIII_C'] + $val['JMLIII_D'] + $val['JMLII_A'] + $val['JMLII_B'] + $val['JMLII_C'] + $val['JMLII_D'] + $val['JMLI_D'] + $jmlcpnssamping ?>
                                    </td>
                                </tr>
                                <?php
                                $totalbwhiv_e += $val['JMLIV_E'];
                                $totalbwhiv_d += $val['JMLIV_D'];
                                $totalbwhiv_c += $val['JMLIV_C'];
                                $totalbwhiv_b += $val['JMLIV_B'];
                                $totalbwhiv_a += $val['JMLIV_A'];
                                $totaliv += $val['JMLIV_A'] + $val['JMLIV_B'] + $val['JMLIV_C'] + $val['JMLIV_D'] + $val['JMLIV_E'];
                                $totalbwhiii_d += $val['JMLIII_D'];
                                $totalbwhiii_c += $val['JMLIII_C'];
                                $totalbwhiii_b += $val['JMLIII_B'];
                                $totalbwhiii_a += $val['JMLIII_A'];
                                $totaliii += $val['JMLIII_A'] + $val['JMLIII_B'] + $val['JMLIII_C'] + $val['JMLIII_D'];
                                $totalbwhii_d += $val['JMLII_D'];
                                $totalbwhii_c += $val['JMLII_C'];
                                $totalbwhii_b += $val['JMLII_B'];
                                $totalbwhii_a += $val['JMLII_A'];
                                $totalii += $val['JMLII_A'] + $val['JMLII_B'] + $val['JMLII_C'] + $val['JMLII_D'];
                                $totalbwhi_d += $val['JMLI_D'];
                                $totalsamping += $val['JMLIV_A'] + $val['JMLIV_B'] + $val['JMLIV_C'] + $val['JMLIV_D'] + $val['JMLIV_E'] + $val['JMLIII_A'] + $val['JMLIII_B'] + $val['JMLIII_C'] + $val['JMLIII_D'] + $val['JMLII_A'] + $val['JMLII_B'] + $val['JMLII_C'] + $val['JMLII_D'] + $val['JMLI_D'];
                                $k++;
                            endforeach;
                            ?>
                            <tr>
                                <td style="text-align:center;" colspan="2">Total</td>
                                <td style="text-align:center;"><?= $totalbwhiv_e; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiv_d; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiv_c; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiv_b; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiv_a; ?></td>
                                <td style="text-align:center;"><?= $totaliv; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiii_d; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiii_c; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiii_b; ?></td>
                                <td style="text-align:center;"><?= $totalbwhiii_a; ?></td>
                                <td style="text-align:center;"><?= $totaliii; ?></td>
                                <td style="text-align:center;"><?= $totalbwhii_d; ?></td>
                                <td style="text-align:center;"><?= $totalbwhii_c; ?></td>
                                <td style="text-align:center;"><?= $totalbwhii_b; ?></td>
                                <td style="text-align:center;"><?= $totalbwhii_a; ?></td>
                                <td style="text-align:center;"><?= $totalii; ?></td>
                                <td style="text-align:center;"><?= $totalbwhi_d; ?></td>
                                <?php $totalcpns = 0; if ($komposisi_cpns) { ?>
                                    <?php foreach ($komposisi_cpns as $isi) { ?>
                                        <td style="text-align:center;">
                                            <?php
                                            $totalcpns += array_sum($totalbawah[$isi['TRGOLONGAN_ID'] . "_" . $isi['THN_GOL']]);
                                            echo array_sum($totalbawah[$isi['TRGOLONGAN_ID'] . "_" . $isi['THN_GOL']]);
                                            ?>
                                        </td>
                                    <?php } ?>
                                <?php } ?>
                                <td style="text-align:center;"><?= $totalsamping+$totalcpns; ?></td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>