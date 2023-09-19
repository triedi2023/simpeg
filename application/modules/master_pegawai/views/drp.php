
<div class="portlet light ">
    <div class="portlet-title">
        <div class="caption">&nbsp;</div>
        <div class="actions">
            <div class="btn-group btn-group-devided" data-toggle="buttons">
                <!-- a class="btn btn-transparent red btn-outline btn-circle btn-sm">
                    <i class="fa fa-print"></i> Print
                </a -->
                <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexportdrhsp" data-url="<?php echo site_url("master_pegawai/export_excel_drhp?id=".$pegawai['ID']) ?>">
                    <i class="fa fa-file-excel-o"></i> Excel
                </a>
                <!-- a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php // echo site_url("laporan_duk/export_pdf") ?>">
                    <i class="fa fa-file-pdf-o"></i> Pdf
                </a -->
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <h2 class="text-center">DAFTAR RIWAYAT PEKERJAAN</h2>
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
                        <td class="text-right"><img width="20%" src="<?php echo base_url() ?>_uploads/photo_pegawai/thumbs/<?php echo $pegawai['FOTO']; ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h3>I. KETERANGAN PERORANGAN</h3>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="width: 5%" class="text-center">1</td>
                        <td colspan="2" style="width: 20%">NAMA LENGKAP</td>
                        <td>
                            <?php echo ((!empty($pegawai['GELAR_DEPAN'])) ? $pegawai['GELAR_DEPAN'] . " " : "") . ($pegawai['NAMA']) . ((!empty($pegawai['GELAR_BLKG'])) ? " " . $pegawai['GELAR_BLKG'] : ''); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
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
                        <td class="text-center">3</td>
                        <td colspan="2">TEMPAT, TGL. LAHIR</td>
                        <td>
                            <?= $pegawai['TPTLAHIR'] ?>
                            &nbsp;/&nbsp;
                            <?= $pegawai['TGLLAHIR2'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">4</td>
                        <td colspan="2">PANGKAT / GOL. RUANG / TMT</td>
                        <td><?= ($pangkat['TRSTATUSKEPEGAWAIAN_ID'] == 1) ? $pangkat['PANGKAT'] . " / " . $pangkat['GOLONGAN'] : $pangkat['PANGKAT'] ?>&nbsp;/&nbsp;<?=$pangkat['TMT_GOL2']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-center">5</td>
                        <td colspan="2">JABATAN / ESELON</td>
                        <td>
                            <?php
                            echo $jabatan['N_JABATAN']." / ".$jabatan['ESELON'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">6</td>
                        <td colspan="2">PENDIDIKAN</td>
                        <td>
                            <?php
                            if ($pendidikan):
                                $k=1;
                                foreach ($pendidikan as $val):
                                    echo $k.". ".$val['TINGKAT_PENDIDIKAN']." ".$val['NAMA_JURUSAN']." ".$val['NAMA_LBGPDK']."<br />";
                                    $k++;
                                endforeach;
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">7</td>
                        <td colspan="2">STATUS PERKAWINAN</td>
                        <td>
                            <?php
                            echo $pegawai['PERNIKAHAN']
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br />
            <h3>II. RIWAYAT PEKERJAAN</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">NO</th>
                        <th class="text-center">RIWAYAT PEKERJAAN</th>
                        <th class="text-center">DARI TGL/BLN/TH S/D TGL/BLN/TH</th>
                        <th class="text-center">GOL. RUANG</th>
                        <th class="text-center">INSTANSI INDUK</th>
                        <th class="text-center">KETERANGAN</th>
                    </tr>
                    <tr>
                        <th class="text-center">1</th>
                        <th class="text-center">2</th>
                        <th class="text-center">3</th>
                        <th class="text-center">4</th>
                        <th class="text-center">5</th>
                        <th class="text-center">6</th>
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
                                <td><?= $p['N_JABATAN'] ?></td>
                                <td class="text-left"><?= $p['TMT_JABATAN2'].(!empty($p['TGL_AKHIR2']) ? $p['TGL_AKHIR2'] : '') ?></td>
                                <td><?= (isset($mecah[1]) ? $mecah[1] : '') ?></td>
                                <td>Basarnas</td>
                                <td class="text-left">-</td>
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
                        </tr>
                    <?php endif; ?>
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