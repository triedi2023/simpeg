<?php
$pangkatgol = isset($model) ? $model['PANGKAT_YGDINILAI'] . " (" . $model['GOLONGAN_YGDINILAI'] . ")" : '';
?>
<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Riwayat SKP
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_skp/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_skp/ubah_proses?id=' . $model['ID']."&kode=".$kode)]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-xs-3">Tahun Penilaian <span class="required" aria-required="true"> * </span></label>
                    <div class="col-xs-2">
                        <select id="periode_awal" name="periode_awal" class="form-control">
                            <?php foreach ($list_bulan as $key => $val): ?>
                                <?php
                                $select = '';
                                if (isset($model) && $model['PERIODE_AWAL'] == $val['kode'])
                                    $select = "selected=''";
                                ?>
                                <option <?php echo $select ?> value="<?php echo $val['kode'] ?>"><?php echo $val['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-xs-1 text-center"><p class="form-control-static">S/D</p></div>
                    <div class="col-xs-2">
                        <select id="periode_akhir" name="periode_akhir" class="form-control">
                            <?php foreach ($list_bulan_desc as $key => $val): ?>
                                <?php
                                $select = '';
                                if (isset($model) && $model['PERIODE_AKHIR'] == $val['kode'])
                                    $select = "selected=''";
                                ?>
                                <option <?php echo $select ?> value="<?php echo $val['kode'] ?>"><?php echo $val['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <select id="periode_tahun" name="periode_tahun" class="form-control">
                            <?php for ($year = date('Y') + 1; $year >= 2012; $year--): ?>
                                <?php
                                $selec = '';
                                if (isset($model) && $model['PERIODE_TAHUN'] == $year)
                                    $selec = 'selected=""';
                                elseif (!isset($model) && $year == date('Y'))
                                    $selec = 'selected=""';
                                ?>
                                <option <?php echo $selec; ?> value="<?php echo $year ?>"><?php echo $year ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Pangkat / Gol.Ruang <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="pangkat" id="field_cr_pangkat" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_golongan_pegawai)): ?>
                                <?php foreach ($list_golongan_pegawai as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && strtolower(str_replace(['(',')','/','.',' '], "", trim($val['NAMA']))) == strtolower(str_replace(['(',')','/','.',' '], "", trim($pangkatgol))))
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Jabatan <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="jabatan" id="field_cr_jabatan" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_jabatan_pegawai)): ?>
                                <?php foreach ($list_jabatan_pegawai as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['NAMA'] == $model['JABATAN_YGDINILAI'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Sasaran Kerja PNS (SKP) <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="nilai_utama" maxlength="10" id="field_cr_nilai_utama" class="form-control" value="<?php echo isset($modeldetail['NILAI_AKHIR']) ? $modeldetail['NILAI_AKHIR'] : set_value('nilai_utama'); ?>" placeholder="Nilai Akhir" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">&nbsp;</div>
                    <div class="col-md-12">&nbsp;</div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="tabbable-custom nav-justified">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active">
                                    <a href="#tab_1_1_1" data-toggle="tab" aria-expanded="true"> Perilaku Kerja </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_1_1">
                                    <div class="form-body form-horizontal">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Orientasi Pelayanan</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="isi_orientasi_pelayanan" maxlength="64" id="field_cr_isi_orientasi_pelayanan" data-class="kategori-orientasi_pelayanan" class="form-control" value="<?php echo isset($modelperilaku['ORIENTASI_PELAYANAN']) ? $modelperilaku['ORIENTASI_PELAYANAN'] : set_value('isi_orientasi_pelayanan'); ?>" placeholder="0" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <?php
                                                        $nilaiorientasi_pelayanan = (isset($modelperilaku['ORIENTASI_PELAYANAN']) && !empty($modelperilaku['ORIENTASI_PELAYANAN'])) ? $modelperilaku['ORIENTASI_PELAYANAN'] : 0;
                                                        $jmlnilaiorientasi = (isset($modelperilaku['ORIENTASI_PELAYANAN']) && !empty($modelperilaku['ORIENTASI_PELAYANAN'])) ? 1 : 0;
                                                        ?>
                                                        <input type="text" name="kategori_orientasi_pelayanan" readonly="" maxlength="64" id="field_cr_kategori_orientasi_pelayanan" class="form-control" value="<?php echo isset($modelperilaku['KET_ORIENTASI_PELAYANAN']) ? $modelperilaku['KET_ORIENTASI_PELAYANAN'] : set_value('kategori_orientasi_pelayanan'); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Integritas</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="isi_integritas" id="field_cr_isi_integritas" class="form-control" data-class="kategori-integritas" value="<?php echo isset($modelperilaku['INTEGRITAS']) ? $modelperilaku['INTEGRITAS'] : set_value('isi_integritas'); ?>" placeholder="0" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <?php
                                                        $nilai_integritas = (isset($modelperilaku['INTEGRITAS']) && !empty($modelperilaku['INTEGRITAS'])) ? $modelperilaku['INTEGRITAS'] : 0;
                                                        $jmlnilaiintegritas = (isset($modelperilaku['INTEGRITAS']) && !empty($modelperilaku['INTEGRITAS'])) ? 1 : 0;
                                                        ?>
                                                        <input type="text" name="kategori_integritas" readonly="" id="field_cr_kategori_integritas" class="form-control" value="<?php echo isset($modelperilaku['KET_INTEGRITAS']) ? $modelperilaku['KET_INTEGRITAS'] : set_value('kategori_integritas'); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Komitmen</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="isi_komitmen" id="field_cr_isi_komitmen" class="form-control kategori-komitmen" data-class="kategori-komitmen" value="<?php echo isset($modelperilaku['KOMITMEN']) ? $modelperilaku['KOMITMEN'] : set_value('isi_komitmen'); ?>" placeholder="0" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <?php
                                                        $nilai_komitmen = (isset($modelperilaku['KOMITMEN']) && !empty($modelperilaku['KOMITMEN'])) ? $modelperilaku['KOMITMEN'] : 0;
                                                        $jmlnilaikomitmen = (isset($modelperilaku['KOMITMEN']) && !empty($modelperilaku['KOMITMEN'])) ? 1 : 0;
                                                        ?>
                                                        <input type="text" name="kategori_komitmen" readonly="" id="field_cr_kategori_komitmen" class="form-control" value="<?php echo isset($modelperilaku['KET_KOMITMEN']) ? $modelperilaku['KET_KOMITMEN'] : set_value('kategori_komitmen'); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Disiplin</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="isi_disiplin" id="field_cr_isi_disiplin" class="form-control" data-class="kategori-disiplin" value="<?php echo isset($modelperilaku['DISIPLIN']) ? $modelperilaku['DISIPLIN'] : set_value('isi_disiplin'); ?>" placeholder="0" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <?php
                                                        $nilai_disiplin = (isset($modelperilaku['DISIPLIN']) && !empty($modelperilaku['DISIPLIN'])) ? $modelperilaku['DISIPLIN'] : 0;
                                                        $jmlnilaidisiplin = (isset($modelperilaku['DISIPLIN']) && !empty($modelperilaku['DISIPLIN'])) ? 1 : 0;
                                                        ?>
                                                        <input type="text" name="kategori_disiplin" readonly="" id="field_cr_kategori_disiplin" class="form-control" value="<?php echo isset($modelperilaku['KET_DISIPLIN']) ? $modelperilaku['KET_DISIPLIN'] : set_value('kategori_disiplin'); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Kerjasama</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="isi_kerjasama" id="field_cr_isi_kerjasama" class="form-control" data-class="kategori-kerjasama" value="<?php echo isset($modelperilaku['KERJASAMA']) ? $modelperilaku['KERJASAMA'] : set_value('isi_kerjasama'); ?>" placeholder="0" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <?php
                                                        $nilai_kerjasama = (isset($modelperilaku['KERJASAMA']) && !empty($modelperilaku['KERJASAMA'])) ? $modelperilaku['KERJASAMA'] : 0;
                                                        $jmlnilaikerjasama = (isset($modelperilaku['KERJASAMA']) && !empty($modelperilaku['KERJASAMA'])) ? 1 : 0;
                                                        ?>
                                                        <input type="text" name="kategori_kerjasama" readonly="" id="field_cr_kategori_kerjasama" class="form-control" value="<?php echo isset($modelperilaku['KET_KERJASAMA']) ? $modelperilaku['KET_KERJASAMA'] : set_value('kategori_kerjasama'); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Kepemimpinan</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="isi_kepemimpinan" id="field_cr_isi_kepemimpinan" class="form-control" data-class="kategori-kepemimpinan" value="<?php echo isset($modelperilaku['KEPEMIMPINAN']) ? $modelperilaku['KEPEMIMPINAN'] : set_value('isi_kepemimpinan'); ?>" placeholder="0" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <?php
                                                        $nilai_kepemimpinan = (isset($modelperilaku['KEPEMIMPINAN']) && !empty($modelperilaku['KEPEMIMPINAN'])) ? $modelperilaku['KEPEMIMPINAN'] : 0;
                                                        $jmlnilaikepemimpinan = (isset($modelperilaku['KEPEMIMPINAN']) && !empty($modelperilaku['KEPEMIMPINAN'])) ? 1 : 0;
                                                        ?>
                                                        <input type="text" name="kategori_kepemimpinan" readonly="" id="field_cr_kategori_kepemimpinan" class="form-control" value="<?php echo isset($modelperilaku['KET_KEPEMIMPINAN']) ? $modelperilaku['KET_KEPEMIMPINAN'] : set_value('kategori_kepemimpinan'); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Jumlah</label>
                                                    <div class="col-md-3"><p class="form-control-static" id="jumlahprilakukerja"><?php
                                            echo $nilaiorientasi_pelayanan + $nilai_integritas + $nilai_komitmen + $nilai_disiplin + $nilai_kerjasama + $nilai_kepemimpinan;
                                            ?></p></div>
                                                    <div class="col-md-3 text-center"><p class="form-control-static">-</p></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Nilai rata-rata</label>
                                                    <div class="col-md-3"><p class="form-control-static" id="nilairataprilakukerja"><?php echo isset($modelperilaku) ? number_format(($nilaiorientasi_pelayanan + $nilai_integritas + $nilai_komitmen + $nilai_disiplin + $nilai_kerjasama + $nilai_kepemimpinan)/($jmlnilaiorientasi+$jmlnilaiintegritas+$jmlnilaikomitmen+$jmlnilaidisiplin+$jmlnilaikerjasama+$jmlnilaikepemimpinan),2) : 0; ?></p></div>
                                                    <div class="col-md-3 text-center"><p class="form-control-static">-</p></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Nilai Perilaku Kerja</label>
                                                    <div class="col-md-2">
                                                        <p class="form-control-static" id="nilaiprilakukerja"><?php echo isset($modelperilaku) ? number_format(number_format((((($nilaiorientasi_pelayanan + $nilai_integritas + $nilai_komitmen + $nilai_disiplin + $nilai_kerjasama + $nilai_kepemimpinan)/($jmlnilaiorientasi+$jmlnilaiintegritas+$jmlnilaikomitmen+$jmlnilaidisiplin+$jmlnilaikerjasama+$jmlnilaikepemimpinan))*40)/100),2))." x 40%" : 0; ?></p>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <p class="form-control-static" id="textnilaiprilakukerja"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Dokumen</label>
                                                    <div class="col-md-8">
                                                        <input type="file" name="doc_skp" id="field_cr_doc_skp" class="form-control" value="" placeholder="Dokumen" />
                                                        <span class="help-block text-danger"> Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb. </span>
                                                    </div>
                                                    <?php if (!empty($model['DOC_SKP']) && $model['DOC_SKP'] <> '') { ?>
                                                        <div class="col-md-1">
                                                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_skp/view_dokumen?id=' . $model['ID']) ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                                                <i class="fa fa-file-pdf-o"></i>
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/row-->
            </div>
            <?php if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') { ?>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="button" class="btn default btnbatalformcudetailpegawai"><i class="fa fa-close"></i> Batal</button>
                        <button type="submit" class="btn btn-warning btn-circle blue-chambray"><i class="fa fa-check"> </i>Simpan</button>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script>
    $("select#field_cr_tahun_penilaian").select2();
    $("select#field_cr_jabatan").select2();
    $("input#field_cr_tgl_mulai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_slesai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>