<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Tambah Data Angka Kredit Dari BKN</h4>
</div>
<?php echo form_open(site_url('integrasi_bkn/tambah_angkakredit_proses?id=' . $id), ["class" => "formtambahbkn form-horizontal"]); ?>
<div class="modal-body">
    <div class="form">

        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-3">Tahun Penilaian <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-8">
                    <select name="tahun_penilaian" id="field_cr_tahun_penilaian" class="form-control" style="width: 100%">
                        <option value="">- Pilih -</option>
                        <?php if (isset($list_tahun)): ?>
                            <?php foreach ($list_tahun as $val): ?>
                                <?php
                                $selec = '';
                                if (isset($bkn['tahunSelesaiPenailan']) && $val == $bkn['tahunSelesaiPenailan'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val ?>"><?= $val ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Nilai Utama <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-4">
                    <input type="text" name="nilai_utama" maxlength="7" id="field_cr_nilai_utama" class="form-control" value="<?php echo isset($bkn['kreditUtamaBaru']) ? $bkn['kreditUtamaBaru'] : set_value('nilai_utama'); ?>" placeholder="Nilai Utama" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Nilai Penunjang <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-4">
                    <input type="text" name="nilai_penunjang" maxlength="7" id="field_cr_nilai_penunjang" class="form-control" value="<?php echo isset($bkn['kreditPenunjangBaru']) ? $bkn['kreditPenunjangBaru'] : set_value('nilai_penunjang'); ?>" placeholder="Nilai Penunjang" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Lembaga</label>
                <div class="col-md-7">
                    <input type="text" name="lembaga" maxlength="150" id="field_cr_lembaga" class="form-control" value="<?php echo isset($model['LEMBAGA']) ? $model['LEMBAGA'] : set_value('lembaga'); ?>" placeholder="Lembaga" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Periode</label>
                <div class="col-md-3">
                    <input type="text" name="tgl_mulai" maxlength="10" id="field_cr_tgl_mulai" class="form-control" value="<?php echo isset($bkn)? "01/".sprintf("%02d", $bkn['bulanMulaiPenailan'])."/".$bkn['tahunMulaiPenailan'] : set_value('tgl_mulai'); ?>" placeholder="Tanggal Mulai" />
                </div>
                <div style="margin-left: 0px;margin-right: 0px;padding-left: 0px;padding-right: 0px;width: 2%;vertical-align: middle" class="col-md-1">S/D</div>
                <div class="col-md-3">
                    <input type="text" name="tgl_slesai" maxlength="10" id="field_cr_tgl_slesai" class="form-control" value="<?php echo isset($bkn)? "01/".sprintf("%02d", $bkn['bulanSelesaiPenailan'])."/".$bkn['tahunSelesaiPenailan'] : set_value('tgl_slesai'); ?>" placeholder="Tanggal Selesai" />
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
                                <a href="#tab_1_1_1" data-toggle="tab" aria-expanded="true"> Status Keputusan </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1_1_1">
                                
                                <div class="form-body form-horizontal">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Nomor</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="no_sk" maxlength="64" id="field_cr_no_sk" class="form-control" value="<?php echo isset($bkn['nomorSk']) ? $bkn['nomorSk'] : set_value('no_sk'); ?>" placeholder="No SK" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Tanggal</label>
                                                <div class="col-md-8">
                                                    <?php
                                                    $tglsk = isset($bkn['tanggalSk'])?explode("-",$bkn['tanggalSk']):NULL;
                                                    $formattgl = '';
                                                    if ($tglsk) {
                                                        $formattgl = $tglsk[2]."/".$tglsk[1]."/".$tglsk[0];
                                                    }
                                                    ?>
                                                    <input type="text" name="tgl_sk" id="field_cr_tgl_sk" class="form-control" value="<?php echo isset($formattgl) ? $formattgl : set_value('tgl_sk'); ?>" placeholder="Tgl SK" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Keterangan</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="keterangan" maxlength="300" id="field_cr_keterangan" class="form-control" value="<?php echo set_value('keterangan'); ?>" placeholder="Keterangan" />
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
            <!--/row-->

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
</script>