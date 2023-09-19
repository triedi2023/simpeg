<div class="col-md-12">
    <div class="portlet box yellow-gold">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Form <?=$title_form;?> Referensi <?=$title_utama;?>
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_tkt_hukuman_disiplin/ubah_proses?id='.$id) : site_url('referensi_tkt_hukuman_disiplin/tambah_proses')]); ?>
            <div class="form-body">
                
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="control-label"><?=$title_utama;?> <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="tkt_hukuman" id="field_cr_tkt_hukuman" class="form-control" value="<?php echo isset($id) ? $model->TKT_HUKUMAN_DISIPLIN : set_value('nama_kelompok'); ?>" maxlength="50" minlength="2" placeholder="<?=$title_utama;?>" />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="control-label">ID BKN <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="id_bkn" id="field_cr_id_bkn" class="form-control" value="<?php echo isset($id) ? $model->ID_BKN : set_value('id_bkn'); ?>" maxlength="1" minlength="1" placeholder="ID BKN" />
                        </div>
                    </div>
                    <!--/span-->
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
                                    <option <?=$selected?> value="<?=$key;?>"><?=$val;?></option>
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