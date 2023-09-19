<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Tambah Data SKP Dari BKN</h4>
</div>
<?php echo form_open(site_url('integrasi_bkn/tambah_skp_proses?id=' . $id), ["class" => "formtambahbkn form-horizontal"]); ?>
<div class="modal-body">
    <div class="form">

        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-3">Tahun Penilaian <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-8">
                    <select id="field_cr_tahun_penilaian" name="periode_tahun" class="form-control">
                        <option value="">- Pilih -</option>
                        <?php if (isset($list_tahun)): ?>
                            <?php foreach ($list_tahun as $val): ?>
                                <?php
                                $selec = '';
                                if (isset($bkn) && $val == $bkn['tahun'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val ?>"><?= $val ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Sasaran Kerja PNS (SKP) <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-4">
                    <input type="text" name="nilai_utama" maxlength="10" id="field_cr_nilai_utama" class="form-control" value="<?php echo isset($bkn['nilaiSkp']) ? $bkn['nilaiSkp'] : set_value('nilai_utama'); ?>" placeholder="Nilai Akhir" />
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
                                                    <input type="text" name="isi_orientasi_pelayanan" maxlength="64" id="field_cr_isi_orientasi_pelayanan" data-class="kategori-orientasi_pelayanan" class="form-control" value="<?php echo isset($bkn['orientasiPelayanan']) ? $bkn['orientasiPelayanan'] : set_value('isi_orientasi_pelayanan'); ?>" placeholder="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Integritas</label>
                                                <div class="col-md-3">
                                                    <input type="text" name="isi_integritas" id="field_cr_isi_integritas" class="form-control" data-class="kategori-integritas" value="<?php echo isset($bkn['integritas']) ? $bkn['integritas'] : set_value('isi_integritas'); ?>" placeholder="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Komitmen</label>
                                                <div class="col-md-3">
                                                    <input type="text" name="isi_komitmen" id="field_cr_isi_komitmen" class="form-control kategori-komitmen" data-class="kategori-komitmen" value="<?php echo isset($bkn['komitmen']) ? $bkn['komitmen'] : set_value('isi_komitmen'); ?>" placeholder="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Disiplin</label>
                                                <div class="col-md-3">
                                                    <input type="text" name="isi_disiplin" id="field_cr_isi_disiplin" class="form-control" data-class="kategori-disiplin" value="<?php echo isset($bkn['disiplin']) ? $bkn['disiplin'] : set_value('isi_disiplin'); ?>" placeholder="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Kerjasama</label>
                                                <div class="col-md-3">
                                                    <input type="text" name="isi_kerjasama" id="field_cr_isi_kerjasama" class="form-control" data-class="kategori-kerjasama" value="<?php echo isset($bkn['kerjasama']) ? $bkn['kerjasama'] : set_value('isi_kerjasama'); ?>" placeholder="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Kepemimpinan</label>
                                                <div class="col-md-3">
                                                    <input type="text" name="isi_kepemimpinan" id="field_cr_isi_kepemimpinan" class="form-control" data-class="kategori-kepemimpinan" value="<?php echo isset($bkn['kepemimpinan']) ? $bkn['kepemimpinan'] : set_value('isi_kepemimpinan'); ?>" placeholder="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Jumlah</label>
                                                <div class="col-md-3"><p class="form-control-static" id="jumlahprilakukerja"><?php
                                                        echo $bkn['orientasiPelayanan'] + $bkn['integritas'] + $bkn['komitmen'] + $bkn['disiplin'] + $bkn['kerjasama'] + $bkn['kepemimpinan'];
                                                        ?></p></div>
                                                <div class="col-md-3 text-center"><p class="form-control-static">-</p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Nilai rata-rata</label>
                                                <?php
                                                $jmlnilaiorientasi = (isset($bkn['orientasiPelayanan']) && !empty($bkn['orientasiPelayanan'])) ? 1 : 0;
                                                $jmlnilaiintegritas = (isset($bkn['integritas']) && !empty($bkn['integritas'])) ? 1 : 0;
                                                $jmlnilaikomitmen = (isset($bkn['komitmen']) && !empty($bkn['komitmen'])) ? 1 : 0;
                                                $jmlnilaidisiplin = (isset($bkn['disiplin']) && !empty($bkn['disiplin'])) ? 1 : 0;
                                                $jmlnilaikerjasama = (isset($bkn['kerjasama']) && !empty($bkn['kerjasama'])) ? 1 : 0;
                                                $jmlnilaikepemimpinan =(isset($bkn['kepemimpinan']) && !empty($bkn['kepemimpinan'])) ? 1 : 0;
                                                ?>
                                                <div class="col-md-3"><p class="form-control-static" id="nilairataprilakukerja"><?php echo isset($bkn) ? number_format(($bkn['orientasiPelayanan'] + $bkn['integritas'] + $bkn['komitmen'] + $bkn['disiplin'] + $bkn['kerjasama'] + $bkn['kepemimpinan']) / ($jmlnilaiorientasi + $jmlnilaiintegritas + $jmlnilaikomitmen + $jmlnilaidisiplin + $jmlnilaikerjasama + $jmlnilaikepemimpinan), 2) : 0; ?></p></div>
                                                <div class="col-md-3 text-center"><p class="form-control-static">-</p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Nilai Perilaku Kerja</label>
                                                <div class="col-md-2">
                                                    <p class="form-control-static" id="nilaiprilakukerja"><?php echo isset($bkn) ? number_format(number_format((((($bkn['orientasiPelayanan'] + $bkn['integritas'] + $bkn['komitmen'] + $bkn['disiplin'] + $bkn['kerjasama'] + $bkn['kepemimpinan']) / ($jmlnilaiorientasi + $jmlnilaiintegritas + $jmlnilaikomitmen + $jmlnilaidisiplin + $jmlnilaikerjasama + $jmlnilaikepemimpinan)) * 40) / 100), 2)) . " x 40%" : 0; ?></p>
                                                </div>
                                                <div class="col-md-2">
                                                    <p class="form-control-static" id="textnilaiprilakukerja"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-6 text-left">
            <button type="button" data-dismiss="modal" class="btn default btnbatalformcudetailpegawai text-left"><i class="fa fa-close"></i> Batal</button>
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-warning btn-circle blue-chambray"><i class="fa fa-check"></i> Simpan</button>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<script>
    $("select#field_cr_tahun_penilaian").select2();
    $("select#field_cr_jabatan").select2();
    $("input#field_cr_tgl_mulai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_slesai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("body").on('change',"input#field_cr_isi_orientasi_pelayanan,input#field_cr_isi_integritas,input#field_cr_isi_komitmen,input#field_cr_isi_disiplin,input#field_cr_isi_kerjasama,input#field_cr_isi_kepemimpinan", function () {
        var jmlsemuanya = Number($("input#field_cr_isi_orientasi_pelayanan").val()) + Number($("input#field_cr_isi_integritas").val()) + Number($("input#field_cr_isi_komitmen").val()) +
                Number($("input#field_cr_isi_disiplin").val()) + Number($("input#field_cr_isi_kerjasama").val()) + Number($("input#field_cr_isi_kepemimpinan").val());
        var bnykprilakukerja = 0;
        $("input[id^='field_cr_isi_']").each(function () {
            if ($(this).val() != "")
                bnykprilakukerja = bnykprilakukerja + 1;
        });
        var total1 = jmlsemuanya / bnykprilakukerja;
        var total2 = ((jmlsemuanya / bnykprilakukerja) * 40) / 100;
        var hasilakhirskp = Number($("th#nilaiskpakhirasli").text());
        $("p#jumlahprilakukerja").text(jmlsemuanya.toFixed(2));
        $("p#nilairataprilakukerja").text(total1.toFixed(2));
        $("p#nilaiprilakukerja").text(total1.toFixed(2) + ' x 40%');
        $("p#textnilaiprilakukerja").text(total2.toFixed(2));

        var isikategori = $(this).attr('data-class').split("-");
        var valuekategori = '';
        if ($(this).val() >= 91 && $(this).val() <= 100) {
            valuekategori = "Sangat Baik";
        } else if ($(this).val() >= 76 && $(this).val() <= 90) {
            valuekategori = "Baik";
        } else if ($(this).val() >= 61 && $(this).val() <= 75) {
            valuekategori = "Cukup";
        } else if ($(this).val() >= 51 && $(this).val() <= 60) {
            valuekategori = "Kurang";
        } else if ($(this).val() != "" && $(this).val() <= 50) {
            valuekategori = "Buruk";
        } else if ($(this).val() == "") {
            valuekategori = "";
        }
        $("#field_cr_kategori_" + isikategori[1]).val(valuekategori);
    });
</script>