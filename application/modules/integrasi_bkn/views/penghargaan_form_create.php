<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Tambah Data Penghargaan Dari BKN</h4>
</div>
<?php echo form_open(site_url('integrasi_bkn/tambah_penghargaan_proses?id=' . $id), ["class" => "formtambahbkn form-horizontal"]); ?>
<div class="modal-body">
    <div class="form">

        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-3">Jenis Tanda Jasa <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-8">
                    <select name="jenis_tandajasa" id="field_cr_jenis_tandajasa" class="form-control" style="width: 100%">
                        <option value="">- Pilih -</option>
                        <?php if (isset($list_jenis_tanda_jasa)): ?>
                            <?php foreach ($list_jenis_tanda_jasa as $val): ?>
                                <?php
                                $selec = '';
                                if (isset($refbkn) && $val['ID'] == $refbkn['TRJENISTANDAJASA_ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Nama Tanda Jasa <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-8">
                    <select name="nama_tandajasa" id="field_cr_nama_tandajasa" class="form-control" style="width: 100%">
                        <option value="">- Pilih -</option>
                        <?php if (isset($list_tanda_jasa)): ?>
                            <?php foreach ($list_tanda_jasa as $val): ?>
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
                <label class="control-label col-md-3">Nomor</label>
                <div class="col-md-8">
                    <input type="text" name="nomor" maxlength="100" id="field_cr_nomor" class="form-control" value="<?php echo isset($bkn['skNomor']) ? $bkn['skNomor'] : set_value('nomor'); ?>" placeholder="Nomor" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Tahun</label>
                <div class="col-md-8">
                    <input type="text" name="tahun" maxlength="4" id="field_cr_tahun" class="form-control" value="<?php echo isset($bkn['tahun']) ? $bkn['tahun'] : set_value('tahun'); ?>" placeholder="Tahun" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Tanggal</label>
                <div class="col-md-8">
                    <input type="text" name="tanggal" maxlength="10" id="field_cr_tanggal" class="form-control" value="<?php echo set_value('tanggal'); ?>" placeholder="Tanggal" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Negara</label>
                <div class="col-md-8">
                    <select name="negara" id="field_cr_negara" class="form-control" style="width: 100%">
                        <option value="">- Pilih -</option>
                        <?php if (isset($list_negara)): ?>
                            <?php foreach ($list_negara as $val): ?>
                                <?php
                                $selec = '';
                                if (isset($model) && $val['ID'] == $model['TRNEGARA_ID'])
                                    $selec = 'selected=""';
                                elseif (!isset($model) && $val['ID'] == '071')
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Instansi</label>
                <div class="col-md-8">
                    <input type="text" name="instansi" maxlength="100" id="field_cr_instansi" class="form-control" value="<?php echo isset($model['INSTANSI']) ? $model['INSTANSI'] : set_value('instansi'); ?>" placeholder="Instansi" />
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
    $("select#field_cr_jenis_tandajasa").select2();
    $("select#field_cr_nama_tandajasa").select2();
    $("select#field_cr_negara").select2();
    $("input#field_cr_tahun").datepicker({autoclose: true, language: "id", format: 'yyyy', startView: "years", minViewMode: "years", endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("9999", {placeholder: 'YYYY'});
    $("input#field_cr_tanggal").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>