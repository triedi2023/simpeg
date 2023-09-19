<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Tambah Data Pangkat Dari BKN</h4>
</div>
<?php echo form_open(site_url('integrasi_bkn/tambah_pangkat_proses?id=' . $id), ["class" => "formtambahbkn form-horizontal"]); ?>
<div class="modal-body">
    <div class="form">

        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-4">Golongan / Pangkat <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-6">
                    <select name="golpangkat" id="field_cr_golpangkat" class="form-control" style="width: 100%">
                        <?php if (isset($list_golongan_pangkat)): ?>
                            <?php foreach ($list_golongan_pangkat as $val): ?>
                                <?php
                                $selec = '';
                                if (isset($pangkatbkn['ID']) && $val['ID'] == $pangkatbkn['ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4">TMT Golongan<span class="required" aria-required="true"> * </span></label>
                <div class="col-md-6">
                    <input type="text" name="tmt_golongan" id="field_cr_tmt_golongan" class="form-control" value="<?php echo isset($bkn['TMT_GOLONGAN2']) ? $bkn['TMT_GOLONGAN2'] : set_value('tmt_golongan'); ?>" placeholder="TMT Golongan" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4">Jenis Pangkat</label>
                <div class="col-md-6">
                    <select name="jeniskenaikanpangkat" id="field_cr_jeniskenaikanpangkat" class="form-control" style="width: 100%">
                        <?php if (isset($list_jenis_kenaikan_pangkat)): ?>
                            <?php foreach ($list_jenis_kenaikan_pangkat as $val): ?>
                                <?php
                                $selec = '';
                                if (isset($jenispangkat['ID']) && $val['ID'] == $jenispangkat['ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4">MK Tambahan</label>
                <div class="col-md-2">
                    <div class="input-group">
                        <input type="text" name="mk_thn" id="field_c_mk_thn" class="form-control" placeholder="0" value="<?php echo 0; ?>" />
                        <span class="input-group-addon">Thn.</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <input type="text" name="mk_bln" id="field_c_mk_bln" class="form-control" placeholder="0" value="<?php echo $bkn['MK_GOL_BULAN']; ?>" />
                        <span class="input-group-addon">Bln.</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4">Peraturan Yang Dijadikan Dasar</label>
                <div class="col-md-6">
                    <input type="text" name="peraturan" maxlength="64" id="field_cr_peraturan" class="form-control" value="<?php echo set_value('peraturan'); ?>" placeholder="Peraturan Yang Dijadikan Dasar" />
                </div>
            </div>

            <h3 class="form-section"> &nbsp;Surat Keputusan </h3>

            <div class="form-group">
                <label class="control-label col-md-4">No SK</label>
                <div class="col-md-6">
                    <input type="text" name="no_sk" maxlength="100" id="field_cr_no_sk" class="form-control" value="<?php echo isset($bkn['NO_SK']) ? $bkn['NO_SK'] : set_value('no_sk'); ?>" placeholder="NO SK" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4">Tgl SK</label>
                <div class="col-md-6">
                    <input type="text" name="tgl_sk" maxlength="100" id="field_cr_tgl_sk" class="form-control" value="<?php echo isset($bkn['TGL_SK2']) ? $bkn['TGL_SK2'] : set_value('tgl_sk'); ?>" placeholder="TGL SK" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4">Pejabat</label>
                <div class="col-md-6">
                    <input type="text" name="pejabat" maxlength="100" id="field_cr_pejabat" class="form-control" value="<?php echo set_value('pejabat'); ?>" placeholder="Pejabat" />
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
            <?php if (isset($cekpangkat) && $cekpangkat == false) { ?>
                <button type="submit" class="btn btn-warning btn-circle blue-chambray"><i class="fa fa-check"></i> Simpan</button>
            <?php } else { ?>
                Data Pangkat Sudah Ada 
            <?php } ?>
        </div>
    </div>
</div>
<?php echo form_close(); ?>