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
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_hari_libur/ubah_proses?id=' . $id) : site_url('referensi_hari_libur/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Jenis Libur <span class="required" aria-required="true"> * </span></label>
                            <select name="jenis_libur" id="field_cr_jenis_libur" class="form-control" style="width: 100%">
                                <option value=""> - Pilih -</option>
                                <?php if ($list_jenis_libur): ?>
                                <?php foreach ($list_jenis_libur as $val): ?>
                                    <?php
                                    $selected = "";
                                    if (isset($model) && $val['ID'] == $model->TRJENISLIBUR_ID)
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
                            <label class="control-label">Tanggal <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="tanggal" maxlength="10" id="field_cr_tanggal" class="form-control" value="<?php echo isset($id) ? $model->TGL_LIBUR2 : set_value('tanggal'); ?>" placeholder="Tanggal" />
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
    $("select#field_cr_jk").select2();
    $("input#field_cr_tanggal").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>