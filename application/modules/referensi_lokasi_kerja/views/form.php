<div class="col-md-12">
    <div class="portlet box yellow-gold">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Form <?= $title_form; ?> Referensi <?= $title_utama; ?>
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_lokasi_kerja/ubah_proses?id=' . $id) : site_url('referensi_lokasi_kerja/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Parent <span class="required" aria-required="true"> * </span></label>
                            <select name="parent_id" id="field_cr_parent_id" class="form-control">
                                <option value="">- Root -</option>
                                <?php if ($list_lokasi_kerja): ?>
                                    <?php foreach ($list_lokasi_kerja as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model->PARENT_ID)
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
                            <label class="control-label">Lokasi Kerja / Peraturan <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="lokasi_kerja" id="field_cr_lokasi_kerja" class="form-control" value="<?php echo isset($id) ? $model->NAMA_LOKASI : set_value('lokasi_kerja'); ?>" maxlength="50" minlength="2" placeholder="Lokasi Kerja" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">ID BKN <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="idbkn" id="field_cr_idbkn" class="form-control" value="<?php echo isset($id) && isset($model->ID_BKN) ? $model->ID_BKN : set_value('idbkn'); ?>" maxlength="32" minlength="2" placeholder="ID BKN" />
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