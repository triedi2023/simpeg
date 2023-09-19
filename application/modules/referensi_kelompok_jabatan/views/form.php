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
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_kelompok_jabatan/ubah_proses?id=' . $id) : site_url('referensi_kelompok_jabatan/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Eselon <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="eselon" id="field_cr_eselon" class="form-control" value="<?php echo isset($id) ? $model->ESELON : set_value('eselon'); ?>" maxlength="30" minlength="1" placeholder="Eselon" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Singkatan / Keterangan <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="singkatan" id="field_cr_singkatan" class="form-control" value="<?php echo isset($id) ? $model->SINGKATAN : set_value('singkatan'); ?>" maxlength="20" minlength="1" placeholder="Singkatan" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Tingkat <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="tkteselon" id="field_cr_tkteselon" class="form-control" value="<?php echo isset($id) ? $model->TKTESELON : set_value('tkteselon'); ?>" maxlength="2" minlength="1" placeholder="Tingkat Eselon" />
                        </div>
                    </div>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">ID BKN</label>
                            <input type="text" name="idbkn" id="field_cr_idbkn" class="form-control" value="<?php echo isset($id) ? $model->ID_BKN : set_value('idbkn'); ?>" maxlength="2" minlength="1" placeholder="ID BKN" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">ID Group BKN</label>
                            <input type="text" name="idgroupbkn" id="field_cr_idgroupbkn" class="form-control" value="<?php echo isset($id) ? $model->ID_BKN_GROUP : set_value('idgroupbkn'); ?>" maxlength="15" minlength="1" placeholder="ID GROUP BKN" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">NAMA Eselon BKN</label>
                            <input type="text" name="namabkn" id="field_cr_namabkn" class="form-control" value="<?php echo isset($id) ? $model->NAMA_BKN : set_value('namabkn'); ?>" minlength="1" placeholder="NAMA Eselon BKN" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Jabatan BKN</label>
                            <input type="text" name="jabatanbkn" id="field_cr_jabatanbkn" class="form-control" value="<?php echo isset($id) ? $model->JABATAN_BKN : set_value('jabatanbkn'); ?>" placeholder="Jabatan BKN" />
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