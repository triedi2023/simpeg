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
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_tanda_jasa/ubah_proses?id=' . $id) : site_url('referensi_tanda_jasa/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Jenis Tanda Jasa <span class="required" aria-required="true"> * </span></label>
                            <select name="jenis_tanda_jasa" id="field_cr_jenis_tanda_jasa" class="form-control">
                                <?php if ($list_jenis_tanda_jasa): ?>
                                    <?php foreach ($list_jenis_tanda_jasa as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['NAMA'] == $model->TRJENISTANDAJASA_ID)
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"><?= $title_utama; ?> <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="tanda_jasa" id="field_cr_tanda_jasa" class="form-control" value="<?php echo isset($id) ? $model->TANDA_JASA : set_value('tanda_jasa'); ?>" maxlength="255" minlength="2" placeholder="<?= $title_utama; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Penerbit <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="penerbit" id="field_cr_penerbit" class="form-control" value="<?php echo isset($id) ? $model->PENERBIT : set_value('penerbit'); ?>" maxlength="255" minlength="2" placeholder="Penerbit" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">ID BKN</label>
                            <input type="text" name="idbkn" id="field_cr_idbkn" class="form-control" value="<?php echo isset($id) ? $model->ID_BKN : set_value('idbkn'); ?>" maxlength="3" minlength="1" placeholder="ID BKN" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">NAMA BKN</label>
                            <input type="text" name="namabkn" id="field_cr_namabkn" class="form-control" value="<?php echo isset($id) ? $model->NAMA_BKN : set_value('namabkn'); ?>" maxlength="50" minlength="1" placeholder="NAMA BKN" />
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