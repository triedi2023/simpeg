<div class="col-md-12">
    <div class="portlet box yellow-gold">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Form <?= $title_form; ?> Referensi <?= $title_utama ?>
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_gaji/ubah_proses?id=' . $id) : site_url('referensi_gaji/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Pangkat / Golongan <span class="required" aria-required="true"> * </span></label>
                            <select name="golongan_id" id="field_cr_golongan_id" class="form-control">
                                <?php if ($list_golongan_pangkat): ?>
                                    <?php foreach ($list_golongan_pangkat as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model->TRGOLONGAN_ID)
                                            $selected = 'selected=""';
                                        ?>
                                        <option <?= $selected ?> value="<?= $val['ID']; ?>"><?= $val['NAMA']; ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">MKG <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="mkg" id="field_cr_mkg" class="form-control" value="<?php echo isset($id) ? $model->MKG : set_value('mkg'); ?>" placeholder="MKG" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Gapok <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="gapok" id="field_cr_gapok" class="form-control" value="<?php echo isset($id) ? $model->GAPOK : set_value('gapok'); ?>" placeholder="Gaji Pokok" />
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Status <span class="required" aria-required="true"> * </span></label>
                            <select name="status" id="field_cr_status" class="form-control">
                                <?php foreach ($this->config->item('statusA') as $key => $val): ?>
                                    <?php
                                    $selected = "";
                                    if (isset($model) && $key == $model->STATUS)
                                        $selected = 'selected=""';
                                    ?>
                                    <option <?= $selected ?> value="<?= $key; ?>"><?= $val; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
            </div>
            <div class="form-actions">
                <div class="pull-left">
                    <button type="button" class="btn default btnbatalformcu"><i class="fa fa-close"></i> Batal</button>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-warning btn-circle"><i class="fa fa-check"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
            <!-- END FORM-->
        </div>
    </div>
</div>