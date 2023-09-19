<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Tambah Data Pendidikan Dari BKN</h4>
</div>
<?php echo form_open(site_url('integrasi_bkn/tambah_pendidikan_proses?id=' . $id), ["class" => "formtambahbkn form-horizontal"]); ?>
<div class="modal-body">
    <div class="form">

        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-3">Tingkat Pendidikan <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-8">
                    <select name="tkt_pendidikan" id="field_cr_tkt_pendidikan" class="form-control" style="width: 100%">
                        <option value="">- Pilih -</option>
                        <?php if (isset($list_pendidikan)): ?>
                            <?php foreach ($list_pendidikan as $val): ?>
                                <?php
                                $selec = '';
                                if (isset($tingkatpendidikan) && $val['ID'] == $tingkatpendidikan['ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Negara</label>
                <div class="col-md-8">
                    <select name="negara" id="field_cr_negara" class="form-control" style="width: 100%">
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
                <label class="control-label col-md-3">Tahun Lulus</label>
                <div class="col-md-8">
                    <input type="text" name="tahun_lulus" id="field_cr_tahun_lulus" class="form-control" value="<?php echo isset($bkn['tahunLulus']) ? $bkn['tahunLulus'] : set_value('tahun_lulus'); ?>" placeholder="Tahun Lulus" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">No Ijasah</label>
                <div class="col-md-8">
                    <input type="text" name="no_ijasah" id="field_cr_no_ijasah" class="form-control" value="<?php echo isset($bkn['no_ijasah']) ? $bkn['no_ijasah'] : set_value('no_ijasah'); ?>" placeholder="No Ijasah" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Nama Pimpinan Lembaga</label>
                <div class="col-md-8">
                    <input type="text" name="nama_pimpinan" id="field_cr_nama_pimpinan" class="form-control" value="<?php echo isset($model['NAMA_DIREKTUR']) ? $model['NAMA_DIREKTUR'] : set_value('nama_pimpinan'); ?>" placeholder="Nama Pimpinan Lembaga" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Tgl Ijasah</label>
                <div class="col-md-8">
                    <input type="text" name="tgl_ijasah" maxlength="50" id="field_cr_tgl_ijasah" class="form-control" value="<?php echo isset($model['TGL_IJAZAH2']) ? $model['TGL_IJAZAH2'] : set_value('tgl_ijasah'); ?>" placeholder="Tgl Ijasah" />
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
    $("select#field_cr_tkt_pendidikan").select2();
    $("select#field_cr_negara").select2();
    $("input#field_cr_tgl_ijasah").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>