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
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_alasan_status_fungsional/ubah_proses?id=' . $id) : site_url('referensi_alasan_status_fungsional/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Status Fungsional <span class="required" aria-required="true"> * </span></label>
                            <select name="status_fung" id="field_cr_status_fung" class="form-control" style="width: 100%">
                                <?php if ($list_status_fungsional): ?>
                                    <?php foreach ($list_status_fungsional as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model->TRSTATUSFUNGSIONAL_ID)
                                            $selected = 'selected=""';
                                        ?>
                                        <option <?= $selected ?> value="<?= $val['ID']; ?>"><?= $val['NAMA']; ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Alasan <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="alasan_statusfungsional" id="field_cr_alasan_statusfungsional" class="form-control" value="<?php echo isset($id) ? $model->ALASAN_STATUS_FUNGSIONAL : set_value('alasan_statusfungsional'); ?>" placeholder="Status Fungsional" />
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-2">
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
<script>
    $("select#field_cr_status_fung").select2();
    $("select#field_cr_status").select2();
</script>