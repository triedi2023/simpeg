<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Tambah Data Diklat Dari BKN</h4>
</div>
<?php echo form_open(site_url('integrasi_bkn/tambah_diklat_proses?id=' . $id), ["class" => "formtambahbkn form-horizontal"]); ?>
<div class="modal-body">
    <div class="form">

        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-3">Penjenjangan <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-7">
                    <select name="penjenjangan" id="field_cr_penjenjangan" class="form-control" style="width: 100%">
                        <?php if (isset($list_tingkat_diklat_kepemimpinan)): ?>
                            <?php foreach ($list_tingkat_diklat_kepemimpinan as $val): ?>
                                <?php
                                $selec = '';
                                if (isset($refbkn) && $val['ID'] == $refbkn['ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Angkatan / Tahun</label>
                <div class="col-md-3">
                    <input type="text" name="angkatan" maxlength="8" id="field_cr_angkatan" class="form-control" value="<?php echo set_value('angkatan'); ?>" placeholder="Angkatan" />
                </div>
                <div class="col-md-3">
                    <input type="text" name="tahun" maxlength="4" id="field_cr_tahun" class="form-control" value="<?php echo isset($bkn['tahun']) ? $bkn['tahun'] : set_value('tahun'); ?>" placeholder="Tahun" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Lama Diklat (JPL)</label>
                <div class="col-md-2">
                    <input type="text" name="jpl" maxlength="4" id="field_cr_jpl" class="form-control" value="<?php echo set_value('jpl'); ?>" placeholder="JPL" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Penyelenggara</label>
                <div class="col-md-7">
                    <input type="text" name="penyelenggara" maxlength="128" id="field_cr_penyelenggara" class="form-control" value="<?php echo set_value('penyelenggara'); ?>" placeholder="Penyelenggara" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Peringkat</label>
                <div class="col-md-7">
                    <input type="text" name="peringkat" maxlength="8" id="field_cr_peringkat" class="form-control" value="<?php echo set_value('peringkat'); ?>" placeholder="peringkat" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Predikat Kelulusan</label>
                <div class="col-md-7">
                    <select name="kelulusan" id="field_cr_kelulusan" class="form-control" style="width: 100%">
                        <option value="">- Pilih Predikat Kelulusan -</option>
                        <?php if (isset($list_kualifikasi_kelulusan)): ?>
                            <?php foreach ($list_kualifikasi_kelulusan as $val): ?>
                                <?php
                                $selec = '';
                                if ($val['ID'] == $model['TRPREDIKATKELULUSAN_ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <h3 class="form-section text-center"> SERTIFIKAT / STTPP </h3>

            <div class="form-group">
                <label class="control-label col-md-3">Nomor</label>
                <div class="col-md-7">
                    <input type="text" name="no_sk" maxlength="100" id="field_cr_no_sk" class="form-control" value="<?php echo isset($bkn['nomor']) ? $bkn['nomor'] : set_value('no_sk'); ?>" placeholder="NO SK" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Tanggal</label>
                <div class="col-md-7">
                    <input type="text" name="tgl_sk" maxlength="100" id="field_cr_tgl_sk" class="form-control" value="<?php echo set_value('tgl_sk'); ?>" placeholder="TGL SK" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Pejabat</label>
                <div class="col-md-7">
                    <input type="text" name="pejabat" maxlength="100" id="field_cr_pejabat" class="form-control" value="<?php echo isset($model['PJBT_STTPP']) ? $model['PJBT_STTPP'] : set_value('pejabat'); ?>" placeholder="Pejabat" />
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
    $("select#field_cr_penjenjangan").select2();
    $("select#field_cr_kelulusan").select2();
    $("input#field_cr_tahun").datepicker({autoclose: true, language: "id", format: 'yyyy', startView: "years", minViewMode: "years", endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("9999", {placeholder: 'YYYY'});
    $("input#field_cr_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>