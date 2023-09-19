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
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_pangkat/ubah_proses?id=' . $id) : site_url('referensi_pangkat/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Tipe Pangkat <span class="required" aria-required="true"> * </span></label>
                            <select name="tipe_pangkat" style="width: 100%" id="field_cr_tipe_pangkat" class="form-control"></select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Kelompok Golongan <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="gol" id="field_cr_gol" class="form-control" value="<?php echo isset($id) ? $model->GOL : set_value('gol'); ?>" placeholder="Kelompok Golongan" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Golongan <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="golongan" id="field_cr_golongan" class="form-control" value="<?php echo isset($id) ? $model->GOLONGAN : set_value('golongan'); ?>" placeholder="Golongan" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Pangkat <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="pangkat" id="field_cr_pangkat" class="form-control" value="<?php echo isset($id) ? $model->PANGKAT : set_value('pangkat'); ?>" placeholder="Pangkat" />
                        </div>
                    </div>
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">ID BKN</label>
                            <input type="text" name="idbkn" id="field_cr_idbkn" class="form-control" value="<?php echo isset($id) ? $model->ID_BKN : set_value('idbkn'); ?>" maxlength="3" minlength="1" placeholder="ID BKN" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Nama BKN</label>
                            <input type="text" name="namabkn" id="field_cr_namabkn" class="form-control" value="<?php echo isset($id) ? $model->NAMA_BKN : set_value('namabkn'); ?>" minlength="1" placeholder="NAMA BKN" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Pangkat BKN</label>
                            <input type="text" name="pangkatbkn" id="field_cr_pangkatbkn" class="form-control" value="<?php echo isset($id) ? $model->PANGKAT_BKN : set_value('pangkatbkn'); ?>" minlength="1" placeholder="PANGKAT BKN" />
                        </div>
                    </div>
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
    $("select#field_cr_tipe_pangkat").select2({
        data: <?= $list_status_kepegawaian ?>
    });
    <?php if (isset($id)) { ?>
        $("select#field_cr_tipe_pangkat").val(<?php echo $model->TRSTATUSKEPEGAWAIAN_ID ?>).trigger('change');
    <?php } ?>
</script>
