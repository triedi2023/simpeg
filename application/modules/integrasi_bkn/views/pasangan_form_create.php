<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Tambah Data Pasangan Dari BKN</h4>
</div>
<?php echo form_open(site_url('integrasi_bkn/tambah_pasangan_proses?id=' . $id), ["class" => "formtambahbkn form-horizontal"]); ?>
<div class="modal-body">
    <div class="form">

        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-3">Status Pasangan <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-8">
                    <select name="jenis_pasangan" id="field_cr_jenis_pasangan" class="form-control" style="width: 100%">
                        <?php if (isset($list_jenis_pasangan)): ?>
                            <?php foreach ($list_jenis_pasangan as $val): ?>
                                <?php
                                $selec = '';
                                if ($val['ID'] == $model['JENIS_PASANGAN'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Pasangan Ke <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-8">
                    <input type="text" name="pasangan_ke" id="field_cr_pasangan_ke" class="form-control" value="<?php echo isset($model['PASANGAN_KE']) ? $model['PASANGAN_KE'] : $pasangan_ke; ?>" placeholder="Pasangan Ke" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Pekerjaan</label>
                <div class="col-md-8">
                    <select name="trpekerjaan_id" id="field_cr_trpekerjaan_id" class="form-control" style="width: 100%">
                        <option value="">- Pilih Pekerjaan Pasangan -</option>
                        <?php if (isset($list_pekerjaan)): ?>
                            <?php foreach ($list_pekerjaan as $val): ?>
                                <?php
                                $selec = '';
                                if ($val['ID'] == $model['TRPEKERJAAN_ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group pasangan_pns" <?php echo (!empty($model['TRPEKERJAAN_ID']) && $model['TRPEKERJAAN_ID'] == 1) ? '' : 'style="display: none"'; ?>>
                <label class="control-label col-md-3">NIP <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-4">
                    <input type="text" name="nip" maxlength="16" id="field_cr_nip" class="form-control" value="<?php echo isset($model['NIP']) ? $model['NIP'] : set_value('nip'); ?>" placeholder="NIP" />
                    <input type="hidden" name="nik" maxlength="18" id="field_cr_nik" class="form-control" value="<?php echo isset($model['NIK']) ? $model['NIP'] : set_value('nik'); ?>" placeholder="NIK" />
                </div>
                <div class="col-md-1">
                    <a href="javascript:;" data-id="" class="popuplarge btn btn-circle btn-icon-only yellow" title="Cari Pegawai" data-modal-title="Daftar Pegawai" data-url="<?php echo site_url("daftar_pegawai/listpegawai?sex=" . $list_jenis_pasangan[0]['ID']); ?>"><i class="fa fa-group"></i></a>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Nama Lengkap <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-8">
                    <input type="text" name="nama_lengkap" maxlength="100" id="field_cr_nama_lengkap" class="form-control" value="<?php echo isset($bkn['listPasangan']) ? $bkn['listPasangan'][0]['dataOrang']['nama'] : set_value('nama_lengkap'); ?>" placeholder="Nama Lengkap" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Tempat Lahir</label>
                <div class="col-md-8">
                    <input type="text" name="tempat_lahir" maxlength="50" id="field_cr_tempat_lahir" class="form-control" value="<?php echo isset($bkn['listPasangan']) ? $bkn['listPasangan'][0]['dataOrang']['tempatLahir'] : set_value('tempat_lahir'); ?>" placeholder="Tempat Lahir" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Tanggal Lahir</label>
                <div class="col-md-3">
                    <input type="text" name="tanggal_lahir" id="field_cr_tanggal_lahir" class="form-control" value="<?php echo isset($bkn['listPasangan'][0]['dataOrang']['tglLahir']) ? str_replace("-","/",$bkn['listPasangan'][0]['dataOrang']['tglLahir']) : set_value('tanggal_lahir'); ?>" placeholder="Tanggal Lahir" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Tanggal Nikah</label>
                <div class="col-md-3">
                    <?php
                    $tglnikahbkn = isset($bkn['listPasangan'][0]['dataPernikahan']['tgglMenikah']) ? explode("-", $bkn['listPasangan'][0]['dataPernikahan']['tgglMenikah']) : [];
                    $formattglnikah = (isset($tglnikahbkn[2]) ? $tglnikahbkn[2]."/" : "").(isset($tglnikahbkn[1]) ? $tglnikahbkn[1]."/" : "").(isset($tglnikahbkn[0]) ? $tglnikahbkn[0] : "")
                    ?>
                    <input type="text" name="tanggal_nikah" id="field_cr_tanggal_nikah" class="form-control" value="<?php echo $formattglnikah ? $formattglnikah : set_value('tanggal_nikah'); ?>" placeholder="Tanggal Nikah" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Keterangan</label>
                <div class="col-md-8">
                    <textarea name="keterangan" id="field_cr_keterangan" class="form-control" placeholder="Keterangan"><?php echo isset($model['KET']) ? $model['KET'] : set_value('keterangan'); ?></textarea>
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