<style>
    table.minimalistBlack {
        border: 0.5px solid;
        width: 100%;
        text-align: left;
        border-collapse: collapse;
    }
    table.minimalistBlack td, table.minimalistBlack th {
        border: 0.5px solid;
    }
    table.minimalistBlack tbody td {
        font-size: 13px;
        text-align: left;
    }
    table.minimalistBlack thead {
        border-bottom: 0.5px solid;
    }
    table.minimalistBlack thead th {
        font-size: 13px;
        font-weight: bold;
        color: #000000;
        text-align: center;
    }
    table.minimalistBlack tfoot {
        font-size: 14px;
        font-weight: bold;
        color: #000000;
        border-top: 3px solid #000000;
    }
    table.minimalistBlack tfoot td {
        font-size: 14px;
    }
</style>
<div class="row">
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
                        <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexportdrh" data-id="<?php echo $pegawai['NIP'] ?>" data-url="<?php echo site_url("laporan_drh/export_excel") ?>">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                        <!-- a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php // echo site_url("laporan_drh/export_pdf")  ?>">
                            <i class="fa fa-file-pdf-o"></i> Pdf
                        </a -->
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <h2 class="text-center">DAFTAR RIWAYAT HIDUP</h2>
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
                                <td class="text-right"><img width="20%" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?php echo $pegawai['FOTO']."?v=".uniqid() ?>" /></td>
                            </tr>
                        </tbody>
                    </table>

                    <h3>I. KETERANGAN PERORANGAN</h3>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td style="width: 3%" class="text-center">1.</td>
                                <td colspan="2" style="width: 35%">Nama Lengkap</td>
                                <td>
                                    <?php echo ((!empty($pegawai['GELAR_DEPAN'])) ? $pegawai['GELAR_DEPAN'] . " " : "") . ($pegawai['NAMA']) . ((!empty($pegawai['GELAR_BLKG'])) ? ", " . $pegawai['GELAR_BLKG'] : ''); ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">2.</td>
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
                                <td class="text-center">3.</td>
                                <td colspan="2">Pangkat / Golongan Ruang</td>
                                <td>
                                    <?= ($pegawai['TRSTATUSKEPEGAWAIAN_ID'] == 1) ? $pegawai['PANGKAT'] . " / " . $pegawai['GOLONGAN'] : $pegawai['PANGKAT'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">4.</td>
                                <td colspan="2">Tempat Lahir/Tgl.Lahir</td>
                                <td>
                                    <?= $pegawai['TPTLAHIR'] ?>
                                    &nbsp;/&nbsp;
                                    <?= $pegawai['TGLLAHIR2'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">5.</td>
                                <td colspan="2">Jenis Kelamin</td>
                                <?php
                                if ($pegawai['SEX'] == 'L') {
                                    $klm = "Laki-laki";
                                } else {
                                    $klm = "Perempuan";
                                }
                                ?>
                                <td>
                                    <?= $klm ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">6.</td>
                                <td colspan="2">Agama</td>
                                <td>
                                    <?= $pegawai['AGAMA'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">7.</td>
                                <td colspan="2">Status Perkawinan</td>
                                <td>
                                    <?= $pegawai['PERNIKAHAN'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="center" rowspan="5">8.</td>
                                <td rowspan="5">Alamat Rumah</td>
                                <td>a. Jalan</td>
                                <td>&nbsp;
                                    <?= $pegawai['ALAMAT'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>b. Kelurahan/Desa</td>
                                <td>&nbsp;
                                    <?= $pegawai['KELURAHAN'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>c. Kecamatan</td>
                                <td>&nbsp;
                                    <?= $pegawai['KECAMATAN'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>d. Kabupaten/Kota</td>
                                <td>&nbsp;
                                    <?= $pegawai['NAMAKABUPATEN'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>e. Propinsi</td>
                                <td>&nbsp;
                                    <?= $pegawai['NAMA_PROPINSI'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="center" rowspan="6">9.</td>
                                <td rowspan="6">Keterangan Badan </td>
                                <td>a.Tinggi(cm)</td>
                                <td>&nbsp;
                                    <?= $pegawai['TINGGI_BADAN'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>b. Berat Badan(kg)</td>
                                <td>&nbsp;
                                    <?= $pegawai['BERAT_BADAN'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>c. Rambut</td>
                                <td>&nbsp;
                                    <?= $pegawai['RAMBUT'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>d. Bentuk muka</td>
                                <td>&nbsp;
                                    <?= $pegawai['BENTUK_MUKA'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>e. Warna kulit</td>
                                <td>&nbsp;
                                    <?= $pegawai['WARNA_KULIT'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>f. Ciri-ciri khas</td>
                                <td>&nbsp;
                                    <?= $pegawai['CIRI_KHAS'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">10</td>
                                <td colspan="2">Kegemaran (Hobby)</td>
                                <td>&nbsp;
                                    <?= $pegawai['HOBI'] ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br />
                    <h3>II. PENDIDIKAN</h3>
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp;Pendidikan</h4>
                    <table class="minimalistBlack">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">TINGKAT</th>
                                <th class="text-center">NAMA PENDIDIKAN</th>
                                <th class="text-center">JURUSAN</th>
                                <th class="text-center">STTB/TANDA LULUS/IJAZAH TAHUN</th>
                                <th class="text-center">TEMPAT</th>
                                <th class="text-center">NAMA KEPALA SEKOLAH/<br />DIREKTUR/DEKAN/PROMOTOR</th>
                            </tr>
                            <tr>
                                <th class="text-center">1</th>
                                <th class="text-center">2</th>
                                <th class="text-center">3</th>
                                <th class="text-center">4</th>
                                <th class="text-center">5</th>
                                <th class="text-center">6</th>
                                <th class="text-center">7</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($pegawai_pendidikan): ?>
                                <?php
                                $i = 1;
                                foreach ($pegawai_pendidikan as $r) {
                                    ?>
                                    <tr>
                                        <td class="center"><?= $i ?>.</td>
                                        <td><?= $r['TINGKAT_PENDIDIKAN'] ?>&nbsp;( <?= $r['NAMA_JURUSAN'] ?> )</td>
                                        <td><?= $r['NAMA_LBGPDK'] ?></td>
                                        <td><?= $r['NAMA_FAKULTAS'] ?></td>
                                        <td><?= $r['NO_STTB'] ?> / <?= $r['THN_LULUS'] ?></td>
                                        <td><?= $r['NAMA_NEGARA'] ?></td>
                                        <td><?= $r['NAMA_DIREKTUR'] ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            <?php else: ?>
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
                    <br />
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.&nbsp;Kursus / Latihan Di Dalam Dan Di Luar Negeri</h4>
                    <table class="minimalistBlack">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">NAMA KURSUS/LATIHAN</th>
                                <th class="text-center">LAMANYA TGL/BLN/THN S/D TGL/BLN/THN</th>
                                <th class="text-center">IJAZAH/ TANDA LULUS/ SURAT KETERANGAN TAHUN</th>
                                <th class="text-center">TEMPAT</th>
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
                            $i = 1;
                            if ($pegawai_prajabatan) {
                                foreach ($pegawai_prajabatan as $r) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?>.</td>
                                        <td class="text-left"><?= ucwords($r['NAMA_DIKLAT']) ?></td>
                                        <td class="text-left"><?= $r['JPL'] ?></td>
                                        <td class="text-left"><?= $r['NO_STTPP'] . " " . $r['TGL_STTPP2'] . " " . $r['PJBT_STTPP'] ?></td>
                                        <td class="text-left"><?= $r['PENYELENGGARA'] ?></td>
                                        <td class="text-center">-</td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                            <?php
                            if ($pegawai_penjenjangan) {
                                foreach ($pegawai_penjenjangan as $r) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?>.</td>
                                        <td class="text-left"><?= ucwords($r['NAMA_JENJANG']) ?></td>
                                        <td class="text-left"><?= $r['JPL'] ?></td>
                                        <td class="text-left"><?= $r['NO_STTPP'] . " " . $r['TGL_STTPP2'] . " " . $r['PJBT_STTPP'] . " " . $r['THN_DIKLAT'] ?></td>
                                        <td class="text-left"><?= $r['PENYELENGGARA'] ?></td>
                                        <td class="text-center">-</td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                            <?php
                            if ($pegawai_diklat_teknis) {
                                foreach ($pegawai_diklat_teknis as $r) {
                                    ?>
                                    <tr>
                                        <td class="center"><?= $i ?>.</td>
                                        <td><?= ucwords($r['KETERANGAN']) ?></td>
                                        <td class="center"><?= $r['JPL'] ?></td>
                                        <td class="center"><?= $r['NO_STTPP'] . " " . $r['TGL_STTPP2'] . " " . $r['PJBT_STTPP'] ?></td>
                                        <td class="center"><?= $r['PENYELENGGARA'] ?></td>
                                        <td class="center">-</td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                            <?php
                            if ($pegawai_diklat_fungsional) {
                                foreach ($pegawai_diklat_fungsional as $r) {
                                    ?>
                                    <tr>
                                        <td class="center"><?= $i ?>.</td>
                                        <td><?= ucwords($r['JENIS_DIKLAT_FUNGSIONAL']) . " " . ucwords($r['PENJENJANGAN_FUNGSIONAL']) . " " . ucwords($r['NAMA_PENJENJANGAN']) ?></td>
                                        <td class="center"><?= $r['JPL'] ?></td>
                                        <td class="center"><?= $r['NO_STTPP'] . " " . $r['TGL_STTPP2'] . " " . $r['PJBT_STTPP'] ?></td>
                                        <td class="center"><?= $r['PENYELENGGARA'] ?></td>
                                        <td class="center"><?= '-' ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                            <?php
                            if ($pegawai_diklat_lain) {
                                foreach ($pegawai_diklat_lain as $r) {
                                    ?>
                                    <tr>
                                        <td class="center"><?= $i ?>.</td>
                                        <td><?= ucwords($r['NAMA_DIKLAT']) ?></td>
                                        <td class="center"><?= $r['JPL'] ?></td>
                                        <td class="center"><?= $r['NO_STTPP'] . " " . $r['TGL_STTPP2'] . " " . $r['PJBT_STTPP'] ?></td>
                                        <td class="center"><?= $r['PENYELENGGARA'] ?></td>
                                        <td class="center"><?= '-' ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                            <?php
                            if ($pegawai_kursus) {
                                foreach ($pegawai_kursus as $r) {
                                    ?>
                                    <tr>
                                        <td class="center"><?= $i ?>.</td>
                                        <td><?= ($r['NAMA_KEGIATAN']) ?></td>
                                        <?php
                                        foreach ($list_bulan as $b) {
                                            if ($r['BULAN'] == trim($b['kode'])) {
                                                $bln = $b['nama'];
                                            } else {
                                                
                                            }
                                        }
                                        ?>
                                        <td><?= $bln ?> <?= $r['TAHUN'] ?></td>
                                        <td class="center"><?= $r['TAHUN'] ?></td>
                                        <td><?= $r['TEMPAT'] ?>-<?= $r['NAMA_NEGARA'] ?></td>
                                        <td>-</td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <br />
                    <h3>III. RIWAYAT PEKERJAAN</h3>
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp;Riwayat Kepangkatan Golongan/Ruang Penggajian</h4>
                    <table class="minimalistBlack">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th rowspan="2" class="text-center">NO</th>
                                <th rowspan="2" class="text-center">Pangkat</th>
                                <th rowspan="2" class="text-center">gol. ruang penggajian</th>
                                <th rowspan="2" class="text-center">Berlaku terhitung mulai tanggal</th>
                                <th rowspan="2" class="text-center">gaji pokok</th>
                                <th colspan="3" class="text-center">surat keputusan</th>
                                <th rowspan="2" class="text-center">peraturan yang diberlakukan</th>
                            </tr>
                            <tr>
                                <th class="text-center">pejabat</th>
                                <th class="text-center">nomor</th>
                                <th class="text-center">tgl</th>
                            </tr>
                            <tr>
                                <th class="text-center">1</th>
                                <th class="text-center">2</th>
                                <th class="text-center">3</th>
                                <th class="text-center">4</th>
                                <th class="text-center">5</th>
                                <th class="text-center">6</th>
                                <th class="text-center">7</th>
                                <th class="text-center">8</th>
                                <th class="text-center">9</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($pegawai_pangkat) {
                                $i = 1;
                                foreach ($pegawai_pangkat as $p) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?>.</td>
                                        <td><?= $p['JENIS_KENAIKAN_PANGKAT'] ?></td>
                                        <td class="text-center"><?= ($p['TRSTATUSKEPEGAWAIAN_ID'] == "1") ? $p['PANGKAT'] . " (" . $p['GOLONGAN'] . ")" : $p['PANGKAT'] ?></td>
                                        <td class="text-center"><?= $p['TMT_GOL2'] ?></td>
                                        <td><?= $p['GAPOK'] ?></td>
                                        <td><?= $p['PEJABAT_SK'] ?></td>
                                        <td class="text-center"><?= $p['NO_SK'] ?></td>
                                        <td class="text-center"><?= $p['TGL_SK'] ?></td>
                                        <td><?= $p['DASAR_PANGKAT'] ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <br />
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.&nbsp;Pengalaman Jabatan / Pekerjaan</h4>
                    <table class="minimalistBlack">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th rowspan="2" class="text-center">NO</th>
                                <th rowspan="2" class="text-center">JABATAN/PEKERJAAN</th>
                                <th rowspan="2" class="text-center">mulai dan SAMPAI</th>
                                <th rowspan="2" class="text-center">gol. ruang penggajian</th>
                                <th rowspan="2" class="text-center">gaji pokok</th>
                                <th colspan="3" class="text-center">surat keputusan</th>
                            </tr>
                            <tr>
                                <th class="text-center">pejabat</th>
                                <th class="text-center">nomor</th>
                                <th class="text-center">tanggal</th>
                            </tr>
                            <tr>
                                <th class="text-center">1</th>
                                <th class="text-center">2</th>
                                <th class="text-center">3</th>
                                <th class="text-center">4</th>
                                <th class="text-center">5</th>
                                <th class="text-center">6</th>
                                <th class="text-center">7</th>
                                <th class="text-center">8</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($pegawai_jabatan) {
                                $i = 1;
                                foreach ($pegawai_jabatan as $p) {
                                    $mecah = explode(";;", $p['GOLPANGKAT']);
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?>.</td>
                                        <td><?= ucwords($p['N_JABATAN']) ?></td>
                                        <td><?= $p['TMT_JABATAN2'] ?>&nbsp;sampai&nbsp;<?= $p['TGL_AKHIR2'] ?></td>
                                        <td><?= isset($mecah[0]) ? $mecah[0] : '' ?></td>
                                        <td class="text-center"><?= $p['GAPOK'] ?></td>
                                        <td><?= $p['PEJABAT_SK'] ?></td>
                                        <td class="text-center"><?= $p['NO_SK'] ?></td>
                                        <td class="text-center"><?= $p['TGL_SK2'] ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <br />
                    <h3>IV. TANDA JASA / PENGHARGAAN</h3>
                    <table class="minimalistBlack">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">nama bintang/ satya lencana penghargaan</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">nama negara/instansi yang memberi</th>
                            </tr>
                            <tr>
                                <th class="text-center">1</th>
                                <th class="text-center">2</th>
                                <th class="text-center">3</th>
                                <th class="text-center">4</th>
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
                                        <td class="center">
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
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br />
                    <h3>V. PENGALAMAN KE LUAR NEGERI</h3>
                    <table class="minimalistBlack">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">negara</th>
                                <th class="text-center">tujuan kunjungan</th>
                                <th class="text-center">lamanya</th>
                                <th class="text-center">yang membiayai</th>
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
                            if ($pegawai_luar_negeri) {
                                $i = 1;
                                foreach ($pegawai_luar_negeri as $s) {
                                    ?>
                                    <tr>
                                        <td class="center">
                                            <?= $i ?>
                                            .</td>
                                        <td>
                                            <?= $s['NAMA_NEGARA'] ?>
                                        </td>
                                        <td>
                                            <?= $s['TUJUAN'] ?>
                                        </td>
                                        <td>
                                            <?= $s['WKTU_HARI'] ?>
                                            Hari&nbsp;
                                            <?= $s['WKTU_BLN'] ?>
                                            Bulan.&nbsp;
                                            <?= $s['WKTU_THN'] ?>
                                            Tahun.</td>
                                        <td>
                                            <?= $s['JENIS_PEMBIAYAAN'] ?>
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
                    <br />
                    <h3>VI. KETERANGAN KELUARGA</h3>
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp;Isteri / Suami</h4>
                    <table class="minimalistBlack">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">nama</th>
                                <th class="text-center">tempat lahir</th>
                                <th class="text-center">tanggal lahir</th>
                                <th class="text-center">tanggal nikah</th>
                                <th class="text-center">pekerjaan</th>
                                <th class="text-center">keterangan</th>
                            </tr>
                            <tr>
                                <th class="text-center">1</th>
                                <th class="text-center">2</th>
                                <th class="text-center">3</th>
                                <th class="text-center">4</th>
                                <th class="text-center">5</th>
                                <th class="text-center">6</th>
                                <th class="text-center">7</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($pegawai_pasangan) {
                                $i = 1;
                                foreach ($pegawai_pasangan as $p) {
                                    ?>
                                    <tr>
                                        <td class="center"><?= $i ?></td>
                                        <td>
                                            <?= $p['NAMA'] ?>
                                        </td>
                                        <td>
                                            <?= $p['TEMPAT_LHR'] ?>
                                        </td>
                                        <td class="center">
                                            <?= $p['TGL_LAHIR2'] ?>
                                        </td>
                                        <td class="center">
                                            <?= $p['TGL_NIKAH2'] ?>
                                        </td>
                                        <td>
                                            <?= $p['PEKERJAAN'] ?>
                                        </td>
                                        <td>
                                            <?= $p['JENIS_PASANGAN'] == '1' ? "Suami" : 'Isteri' ?>
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
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br />
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.&nbsp;Anak</h4>
                    <table class="minimalistBlack">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">nama</th>
                                <th class="text-center">jenis kelamin</th>
                                <th class="text-center">tempat lahir</th>
                                <th class="text-center">tanggal lahir</th>
                                <th class="text-center">pekerjaan</th>
                                <th class="text-center">keterangan</th>
                            </tr>
                            <tr>
                                <th class="text-center">1</th>
                                <th class="text-center">2</th>
                                <th class="text-center">3</th>
                                <th class="text-center">4</th>
                                <th class="text-center">5</th>
                                <th class="text-center">6</th>
                                <th class="text-center">7</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($pegawai_anak) {
                                $i = 1;
                                foreach ($pegawai_anak as $a) {
                                    ?>
                                    <tr>
                                        <td class="center">
                                            <?= $i ?>
                                            .</td>
                                        <td>
                                            <?= $a['NAMA'] ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            if ($a['SEX'] == 'L')
                                                echo 'Laki-laki';
                                            elseif ($a['SEX'] == 'P')
                                                echo 'Perempuan';
                                            else
                                                echo '-';
                                            ?>
                                        </td>
                                        <td>
                                            <?= $a['TEMPAT_LHR'] ?>
                                        </td>
                                        <td>
                                            <?= $a['TGL_LAHIR2'] ?>
                                        </td>
                                        <td>
                                            <?= $a['PEKERJAAN'] ?>
                                        </td>
                                        <td>
                                            <?= $a['KETERANGAN'] ?>
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
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br />
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.&nbsp;Bapak Dan Ibu Kandung</h4>
                    <table class="minimalistBlack">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">nama</th>
                                <th class="text-center">tgl lahir/ umur</th>
                                <th class="text-center">pekerjaan</th>
                                <th class="text-center">keterangan</th>
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
                            if ($pegawai_ortu_kandung) {
                                $i = 1;
                                foreach ($pegawai_ortu_kandung as $d) {
                                    ?>
                                    <tr>
                                        <td class="center">
                                            <?= $i ?>
                                            .</td>
                                        <td>
                                            <?= $d['NAMA'] ?>
                                        </td>
                                        <td class="center">
                                            <?= $d['TGL_LAHIR2'] ?>
                                        </td>
                                        <td>
                                            <?= $d['PEKERJAAN'] ?>
                                        </td>
                                        <td>
                                            <?= $d['NAMAORTU'] ?>
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
                    <br />
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.&nbsp;Bapak Dan Ibu Mertua</h4>
                    <table class="minimalistBlack">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">nama</th>
                                <th class="text-center">tgl lahir/ umur</th>
                                <th class="text-center">pekerjaan</th>
                                <th class="text-center">keterangan</th>
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
                            if ($pegawai_ortu_mertua) {
                                $i = 1;
                                foreach ($pegawai_ortu_mertua as $d) {
                                    ?>
                                    <tr>
                                        <td class="center">
                                            <?= $i ?>
                                            .</td>
                                        <td>
                                            <?= $d['NAMA'] ?>
                                        </td>
                                        <td class="center">
                                            <?= $d['TGL_LAHIR2'] ?>
                                        </td>
                                        <td>
                                            <?= $d['PEKERJAAN'] ?>
                                        </td>
                                        <td>
                                            <?= $d['NAMAORTU'] ?>
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
                    <br />
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.&nbsp;Saudara Kandung</h4>
                    <table class="minimalistBlack">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">nama</th>
                                <th class="text-center">jenis kelamin</th>
                                <th class="text-center">tanggal lahir/umur</th>
                                <th class="text-center">pekerjaan</th>
                                <th class="text-center">keterangan</th>
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
                            if ($pegawai_saudara) {
                                $i = 1;
                                foreach ($pegawai_saudara as $s) {
                                    ?>
                                    <tr>
                                        <td class="center">
                                            <?= $i ?>
                                        </td>
                                        <td>
                                            <?= $s['NAMA'] ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($s['SEX'] == 'L')
                                                echo 'Laki-laki';
                                            elseif ($s['SEX'] == 'P')
                                                echo 'Perempuan';
                                            else
                                                echo '-';
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?= $s['TGL_LAHIR2'] ?>
                                        </td>
                                        <td>
                                            <?= $s['PEKERJAAN'] ?>
                                        </td>
                                        <td>
                                            <?= $s['KETERANGAN'] ?>
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
                                    <td class="text-center">-</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br />
                    <h3>VII. KETERANGAN ORGANISASI</h3>
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp;Semasa Mengikuti Pendidikan Pada SLTA Ke Bawah.</h4>
                    <table class="minimalistBlack">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">nama organisasi</th>
                                <th class="text-center">kedudukan dalam organisasi</th>
                                <th class="text-center">dalam tahun s/d tahun</th>
                                <th class="text-center">tempat</th>
                                <th class="text-center">nama pimpinan organisasi</th>
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
                            if ($pegawai_organisasi) {
                                $i = 1;
                                foreach ($pegawai_organisasi as $r) {
                                    ?>
                                    <tr>
                                        <td class="center">
                                            <?= $i ?>
                                            .</td>
                                        <td>
                                            <?= $r['NAMA_ORG'] ?>
                                        </td>
                                        <td>
                                            <?= $r['JABATAN_ORG'] ?>
                                        </td>
                                        <td>
                                            <?= $r['THN_TERDAFTAR'] ?>
                                            sd
                                            <?= $r['THN_SELESAI'] ?>
                                        </td>
                                        <td>
                                            <?= $r['TEMPAT_ORG'] ?>
                                        </td>
                                        <td>
                                            <?= $r['PIMPINAN_ORG'] ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br />
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.&nbsp;Semasa Mengikuti Pendidikan Pada Perguruan Tinggi.</h4>
                    <table class="minimalistBlack">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">nama organisasi</th>
                                <th class="text-center">kedudukan dalam organisasi</th>
                                <th class="text-center">dalam tahun s/d tahun</th>
                                <th class="text-center">tempat</th>
                                <th class="text-center">nama pimpinan organisasi</th>
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
                            if ($pegawai_perguruan) {
                                $i = 1;
                                foreach ($pegawai_perguruan as $r) {
                                    ?>
                                    <tr>
                                        <td class="center">
                                            <?= $i ?>
                                            .</td>
                                        <td>
                                            <?= $r['NAMA_ORG'] ?>
                                        </td>
                                        <td>
                                            <?= $r['JABATAN_ORG'] ?>
                                        </td>
                                        <td>
                                            <?= $r['THN_TERDAFTAR'] ?>
                                            sd
                                            <?= $r['THN_SELESAI'] ?>
                                        </td>
                                        <td>
                                            <?= $r['TEMPAT_ORG'] ?>
                                        </td>
                                        <td>
                                            <?= $r['PIMPINAN_ORG'] ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br />
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.&nbsp;Sesudah Selesai Pendidikan Dan Atau Selama Menjadi Pegawai.</h4>
                    <table class="minimalistBlack">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">nama organisasi</th>
                                <th class="text-center">kedudukan dalam organisasi</th>
                                <th class="text-center">dalam tahun s/d tahun</th>
                                <th class="text-center">tempat</th>
                                <th class="text-center">nama pimpinan organisasi</th>
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
                            if ($pegawai_pns) {
                                $i = 1;
                                foreach ($pegawai_pns as $r) {
                                    ?>
                                    <tr>
                                        <td class="center">
                                            <?= $i ?>
                                            .</td>
                                        <td>
                                            <?= $r['NAMA_ORG'] ?>
                                        </td>
                                        <td>
                                            <?= $r['JABATAN_ORG'] ?>
                                        </td>
                                        <td>
                                            <?= $r['THN_TERDAFTAR'] ?>
                                            sd
                                            <?= $r['THN_SELESAI'] ?>
                                        </td>
                                        <td>
                                            <?= $r['TEMPAT_ORG'] ?>
                                        </td>
                                        <td>
                                            <?= $r['PIMPINAN_ORG'] ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br />
                    <h3>VIII. KETERANGAN LAIN-LAIN</h3>
                    <table class="minimalistBlack">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th rowspan="2" class="text-center">NO</th>
                                <th rowspan="2" class="text-center">nama keterangan</th>
                                <th colspan="2" class="text-center">surat keterangan</th>
                                <th rowspan="2" class="text-center">tanggal</th>
                            </tr>
                            <tr>
                                <th class="text-center">pejabat</th>
                                <th class="text-center">nomor</th>
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
                            if ($pegawai_keterangan) {
                                $i = 1;
                                foreach ($pegawai_keterangan as $r) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td>
                                            <?= $r['KETERANGAN'] ?>
                                        </td>
                                        <td>
                                            <?= $r['PEJABAT_SK'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $r['NO_SK'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $r['TGL_SK2'] ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br /><br />
                    <p>Demikian daftar riwayat hidup ini saya buat dengan sesungguhnya dan apabila dikemudian hari terdapat keterangan yang tidak benar saya bersedia dituntut dimuka pengadilan serta bersedia menerima segala tindakan yang di ambil oleh pemerintah.</p>
                    <table class="table table-bordered">
                        <tr>
                            <td style="width:70%">&nbsp;</td>
                            <td style="width:30%">
                                <div class="ttd center">
                                    <p><span><?php echo date('d-m-Y') ?></span></p>
                                    <p> Dibuat Oleh,</p>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                    <p><?php // echo $_SESSION['admin-display_name'] . " ( " . $_SESSION['admin-newnip'] . " )";   ?></p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <div class="note">
                        <h2>PERHATIAN  :</h2>
                        <ul>
                            <li>Harus di isi sendiri menggunakan huruf kapital/balok dan tinta hitam.</li>
                            <li>Jika ada yang salah harus di coret, yang dicoret tetap terbaca kemudian yang benar dituliskan diatas atau sibawahnya dan diparaf.</li>
                            <li>Kolom yang kosong diberi tanda (-) </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>