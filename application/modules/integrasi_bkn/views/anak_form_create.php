<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Tambah Data Anak Dari BKN</h4>
</div>
<?php echo form_open(site_url('integrasi_bkn/tambah_anak_proses?id=' . $id), ["class" => "formtambahbkn form-horizontal"]); ?>
<div class="modal-body">
    <div class="form">

        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-3">Status Anak <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-8">
                    <select name="status_anak" id="field_cr_status_anak" class="form-control" style="width: 100%">
                        <?php if (isset($list_sts_anak)): ?>
                            <?php foreach ($list_sts_anak as $val): ?>
                                <?php
                                $selec = '';
                                if (isset($model) && $val['ID'] == $model['TRSTATUSANAK_ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Nama Lengkap <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-8">
                    <input type="text" name="nama_lengkap" maxlength="100" id="field_cr_nama_lengkap" class="form-control" value="<?php echo isset($bkn['nama']) ? $bkn['nama'] : set_value('nama_lengkap'); ?>" placeholder="Nama Lengkap" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Jenis Kelamin</label>
                <div class="col-md-8">
                    <select name="jk" id="field_cr_jk" class="form-control" style="width: 100%">
                        <option value="">- Pilih Jenis Kelamin -</option>
                        <?php if (isset($list_jk)): ?>
                            <?php foreach ($list_jk as $val): ?>
                                <?php
                                $selec = '';
                                if (isset($bkn) && $bkn['jenisKelamin'] == $val['NAMA'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Tempat Lahir</label>
                <div class="col-md-8">
                    <input type="text" name="tempat_lahir" maxlength="50" id="field_cr_tempat_lahir" class="form-control" value="<?php echo isset($bkn['tempatLahir']) ? $bkn['tempatLahir'] : set_value('tempat_lahir'); ?>" placeholder="Tempat Lahir" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Tanggal Lahir</label>
                <div class="col-md-3">
                    <input type="text" name="tanggal_lahir" id="field_cr_tanggal_lahir" class="form-control" value="<?php echo isset($bkn['tglLahir']) ? str_replace("-",'/',$bkn['tglLahir']) : set_value('tanggal_lahir'); ?>" placeholder="Tanggal Lahir" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Pekerjaan</label>
                <div class="col-md-3">
                    <input type="text" name="pekerjaan" id="field_cr_pekerjaan" class="form-control" value="<?php echo isset($model['PEKERJAAN']) ? $model['PEKERJAAN'] : set_value('pekerjaan'); ?>" placeholder="Pekerjaan" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Keterangan</label>
                <div class="col-md-8">
                    <textarea name="keterangan" id="field_cr_keterangan" class="form-control" placeholder="Keterangan"><?php echo isset($model['KETERANGAN']) ? $model['KETERANGAN'] : set_value('keterangan'); ?></textarea>
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