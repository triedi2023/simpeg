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
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_jenjang_tingkat_fungsional/ubah_proses?id=' . $id) : site_url('referensi_jenjang_tingkat_fungsional/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Tingkat <span class="required" aria-required="true"> * </span></label>
                            <select name="tingkat" id="field_cr_tingkat" class="form-control" style="width: 100%">
                                <?php if ($list_penjenjangan_fungsional): ?>
                                <?php foreach ($list_penjenjangan_fungsional as $val): ?>
                                    <?php
                                    $selected = "";
                                    if (isset($model) && $val['ID'] == $model->KODE_JENIS)
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
                            <label class="control-label">Jenjang <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="jenjang" maxlength="30" id="field_cr_jenjang" class="form-control" value="<?php echo isset($id) ? $model->NAMA_PENJENJANGAN : set_value('Jenjang'); ?>" placeholder="Jenjang" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Status <span class="required" aria-required="true"> * </span></label>
                            <select name="status" id="field_cr_status" class="form-control" style="width: 100%">
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
    $("select#field_cr_status").select2();
</script>