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
        <div class="portlet-body">
            <h1 class="text-center">KOMPOSISI PEGAWAI MENURUT GOLONGAN</h1>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Periode <?php echo month_indo(date('m')) . " " . date("Y") ?></h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered" style="font-size: 10px;padding: 1px;">
                    <thead>
                        <tr>
                            <td rowspan="4" style="vertical-align:middle;text-align: center">NO</td>
                            <td rowspan="4" style="vertical-align:middle;width: 30%;text-align: center">NAMA KANTOR SAR</td>
                            <td style="text-align:center;" colspan="17">GOLONGAN</td>
                            <td style="text-align: center;" <?php echo 'colspan="' . $jmlcpns . '"'; ?>>CPNS</td>
                            <td style="text-align: center;vertical-align: middle" rowspan="4">JML</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;" colspan="17">PEGAWAI NEGERI SIPIL</td>
                            <td style="text-align:center;" <?php echo 'colspan="' . $jmlcpns . '"'; ?>><?= date('Y', mktime(0, 0, 0, date('m'), date('d'), date('Y') - 1)) ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center;" colspan="5">IV</td>
                            <td style="text-align:center;vertical-align: middle" rowspan="2">JML</td>
                            <td style="text-align:center;" colspan="4">III</td>
                            <td style="text-align:center;vertical-align: middle" rowspan="2">JML</td>
                            <td style="text-align:center;" colspan="4">II</td>
                            <td style="text-align:center;vertical-align: middle" rowspan="2">JML</td>
                            <td style="text-align:center;">I</td>
                            <?php if ($komposisi_cpns) { ?>
                                <?php foreach ($komposisi_cpns as $val) { ?>
                                    <td style="text-align:center;vertical-align: middle" rowspan="2"><?= $val['GOLONGAN'] ?></td>
                                <?php } ?>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td style="text-align:center;">e</td>
                            <td style="text-align:center;">d</td>
                            <td style="text-align:center;">c</td>
                            <td style="text-align:center;">b</td>
                            <td style="text-align:center;">a</td>
                            <td style="text-align:center;">d</td>
                            <td style="text-align:center;">c</td>
                            <td style="text-align:center;">b</td>
                            <td style="text-align:center;">a</td>
                            <td style="text-align:center;">d</td>
                            <td style="text-align:center;">c</td>
                            <td style="text-align:center;">b</td>
                            <td style="text-align:center;">a</td>
                            <td style="text-align:center;">d</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">1</td>
                            <td style="text-align:center;">2</td>
                            <td style="text-align:center;">3</td>
                            <td style="text-align:center;">4</td>
                            <td style="text-align:center;">5</td>
                            <td style="text-align:center;">6</td>
                            <td style="text-align:center;">7</td>
                            <td style="text-align:center;">8</td>
                            <td style="text-align:center;">9</td>
                            <td style="text-align:center;">10</td>
                            <td style="text-align:center;">11</td>
                            <td style="text-align:center;">12</td>
                            <td style="text-align:center;">13</td>
                            <td style="text-align:center;">14</td>
                            <td style="text-align:center;">15</td>
                            <td style="text-align:center;">16</td>
                            <td style="text-align:center;">17</td>
                            <td style="text-align:center;">18</td>
                            <td style="text-align:center;">19</td>
                            <?php
                            $lanjut = 20;
                            if ($komposisi_cpns) {
                                ?>
                                <?php foreach ($komposisi_cpns as $val) { ?>
                                    <td style="text-align:center;"><?php echo $lanjut; ?></td>
                                    <?php
                                    $lanjut++;
                                }
                                ?>
                            <?php } ?>
                            <td style="text-align:center;"><?php echo $lanjut; ?></td>
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
                                        <?= $val['JMLIV_E'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLIV_D'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLIV_C'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLIV_B'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLIV_A'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLIV_A'] + $val['JMLIV_B'] + $val['JMLIV_C'] + $val['JMLIV_D'] + $val['JMLIV_E'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLIII_D'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLIII_C'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLIII_B'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLIII_A'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLIII_A'] + $val['JMLIII_B'] + $val['JMLIII_C'] + $val['JMLIII_D'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLII_D'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLII_C'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLII_B'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLII_A'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLII_A'] + $val['JMLII_B'] + $val['JMLII_C'] + $val['JMLII_D'] ?>
                                    </td>
                                    <td style=" width: 21pt; text-align:center;">
                                        <?= $val['JMLI_D'] ?>
                                    </td>
                                    <?php
                                    $jmlcpnssamping = 0;
                                    if ($komposisi_cpns) {
                                        ?>
                                        <?php foreach ($komposisi_cpns as $isi) { ?>
                                            <td style=" width: 21pt; text-align:center;"><?php echo $val[$isi['GOL']]; ?></td>
                                            <?php
                                            $jmlcpnssamping += $val[$isi['GOL']];
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
                                $totalcpnsbawah += $jmlcpnssamping;
                                $totalsamping += $val['JMLIV_A'] + $val['JMLIV_B'] + $val['JMLIV_C'] + $val['JMLIV_D'] + $val['JMLIV_E'] + $val['JMLIII_A'] + $val['JMLIII_B'] + $val['JMLIII_C'] + $val['JMLIII_D'] + $val['JMLII_A'] + $val['JMLII_B'] + $val['JMLII_C'] + $val['JMLII_D'] + $val['JMLI_D'] + $jmlcpnssamping;
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
                                <td style="text-align:center;"><?= $totalcpnsbawah; ?></td>
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