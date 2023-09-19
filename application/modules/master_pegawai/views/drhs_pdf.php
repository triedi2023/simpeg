<div class="portlet light ">
    <div class="portlet-title">
        <div class="caption">&nbsp;</div>
        <div class="actions">&nbsp;</div>
    </div>
    <div class="portlet-body">
        <h2 class="text-center">DAFTAR RIWAYAT HIDUP SINGKAT</h2>
        <br />
        <div class="table-scrollable">
            <table class="table">
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="text-right"><img width="20%" src="<?php echo $_SERVER['DOCUMENT_ROOT'].'_uploads/photo_pegawai/thumbs/' . $pegawai['FOTO'] ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h3>I. KETERANGAN PERORANGAN</h3>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td colspan="2" style="width: 35%">NAMA LENGKAP</td>
                        <td>
                            <?php echo ((!empty($pegawai['GELAR_DEPAN'])) ? $pegawai['GELAR_DEPAN'] . " " : "") . ($pegawai['NAMA']) . ((!empty($pegawai['GELAR_BLKG'])) ? " " . $pegawai['GELAR_BLKG'] : ''); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">NIP</td>
                        <td>
                            <?php
                            if ($pegawai['NIPNEW'] == '' or $pegawai['NIPNEW'] == Null) {
                                $nip = $pegawai['NIP'];
                            } else {
                                $nip = $pegawai['NIPNEW'];
                            }
                            ?>
                            <?= $nip ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">TEMPAT, TGL. LAHIR</td>
                        <td>
                            <?= $pegawai['TPTLAHIR']." ".$pegawai['FOTO'] ?>
                            &nbsp;/&nbsp;
                            <?= $pegawai['TGLLAHIR2'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">PANGKAT/GOL. RUANG</td>
                        <td><?= ($pangkat['TRSTATUSKEPEGAWAIAN_ID'] == 1) ? $pangkat['PANGKAT'] . " / " . $pangkat['GOLONGAN'] : $pangkat['PANGKAT'] ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">JABATAN TERAKHIR</td>
                        <td>
                            <?php
                            echo $jabatan['N_JABATAN'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">INSTANSI</td>
                        <td><?php echo $this->config->item('instansi_panjang'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">JENIS KELAMIN</td>
                        <td>
                            <?php
                            if ($pegawai['SEX'] == 'L') {
                                $klm = "Laki-laki";
                            } else {
                                $klm = "Perempuan";
                            }
                            echo $klm;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">AGAMA</td>
                        <td>
                            <?= $pegawai['AGAMA'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">PENDIDIKAN TERAKHIR</td>
                        <td>
                            <?= $pendidikan['TINGKAT_PENDIDIKAN'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">ALAMAT</td>
                        <td>
                            <?= $pegawai['ALAMAT'] . " " . $pegawai['KELURAHAN'] . " " . $pegawai['KECAMATAN'] ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br />
            <h3>II. RIWAYAT PEKERJAAN</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center">NO</th>
                        <th class="text-center">PANGKAT/GOLONGAN RUANG</th>
                        <th colspan="3" class="text-center">JABATAN</th>
                    </tr>
                    <tr>
                        <th class="text-center">TMT</th>
                        <th class="text-center">NAMA JABATAN</th>
                        <th class="text-center">PEJABAT YANG MENETAPKAN</th>
                        <th class="text-center">NOMOR DAN TANGGAL SKEP</th>
                    </tr>
                    <tr>
                        <th class="text-center">1</th>
                        <th class="text-center">2</th>
                        <th class="text-center">3</th>
                        <th class="text-center">4</th>
                        <th class="text-center">5</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($pegawai_jabatan):
                        $i = 1;
                        foreach ($pegawai_jabatan as $p) {
                            $mecah = explode(";;", $p['GOLPANGKAT']);
                            ?>
                            <tr>
                                <td class="text-center"><?= $i ?>.</td>
                                <td><?= (isset($mecah[0]) ? $mecah[0] : '') . "<br />" . (isset($mecah[1]) ? $mecah[1] : '') ?></td>
                                <td><?= $p['N_JABATAN'] ?></td>
                                <td><?= $p['PEJABAT_SK'] ?></td>
                                <td class="text-left"><?= $p['NO_SK'] . " " . $p['TMT_JABATAN2'] ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    else:
                        ?>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <h3>III. TANDA KEHORMATAN YANG TELAH DIMILIKI</h3>
            <table class="table table-bordered">
                <thead style="text-transform: uppercase">
                    <tr>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;">NO</th>
                        <th class="text-center" rowspan="2" style="vertical-align: middle;">NAMA BINTANG / SATYALANCANA</th>
                        <th colspan="2" class="text-center">SURAT KEPUTUSAN</th>
                        <th class="text-center" rowspan="2" style="vertical-align: middle;">NAMA NEGARA / INSTANSI</th>
                    </tr>
                    <tr>
                        <th class="text-center">NOMOR</th>
                        <th class="text-center">TANGGAL</th>
                    </tr>
                    <tr>
                        <th class="text-center">1</th>
                        <th class="text-center">2</th>
                        <th class="text-center">3</th>
                        <th class="text-center">4</th>
                        <th class="text-center">5</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($pegawai_penghargaan) {
                        $i = 1;
                        foreach ($pegawai_penghargaan as $p) {
                            ?>
                            <tr>
                                <td class="center"><?= $i ?></td>
                                <td>
                                    <?= $p['JENIS_TANDA_JASA'] ?>
                                    &nbsp;/&nbsp;
                                    <?= $p['TANDA_JASA'] ?>
                                </td>
                                <td class="text-left">
                                    <?= $p['NOMOR'] ?>
                                </td>
                                <td class="text-left">
                                    <?= $p['THN_PRLHN'] ?>
                                </td>
                                <td>
                                    <?= $p['NAMA_NEGARA'] ?>
                                    &nbsp;/&nbsp;
                                    <?= $p['INSTANSI'] ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    } else {
                        ?>
                        <tr>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br /><br />
            <table class="table">
                <tr>
                    <td style="width:40%">&nbsp;</td>
                    <td style="width:30%">&nbsp;</td>
                    <td style="width:30%">
                        <div class="ttd text-center">
                            <p><span>...............,</span> ..................</p>
                            <p> Yang Membuat,</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p style="text-decoration: underline;padding-bottom: 0px;margin-bottom: 0px"><?php echo ((!empty($pegawai['GELAR_DEPAN'])) ? $pegawai['GELAR_DEPAN'] . " " : "") . ($pegawai['NAMA']) . ((!empty($pegawai['GELAR_BLKG'])) ? " " . $pegawai['GELAR_BLKG'] : ''); ?></p>
                            <p style="padding-top: 0px;margin-top: 0px;">NIP. <?php echo $pegawai['NIPNEW']; ?></p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>