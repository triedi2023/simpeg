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
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_status_kepegawaian/ubah_proses?id=' . $id) : site_url('referensi_status_kepegawaian/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Parent <span class="required" aria-required="true"> * </span></label>
                            <select name="parent_id" id="field_cr_parent_id" class="form-control">
                                <option value="">- Root -</option>
                                <?php if ($list_status_kepegawaian): ?>
                                    <?php foreach ($list_status_kepegawaian as $val): ?>
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Status Kepegawaian <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="status_kepegawaian" id="field_cr_status_kepegawaian" class="form-control" value="<?php echo isset($id) ? $model->STATUS_KEPEGAWAIAN : set_value('STATUS_KEPEGAWAIAN'); ?>" maxlength="50" minlength="2" placeholder="Status Kepegawaian" />
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-4">
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