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
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_tingkat_pendidikan/ubah_proses?id='.$id) : site_url('referensi_tingkat_pendidikan/tambah_proses')]); ?>
            <div class="form-body">
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label"><?=$title_utama;?> <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="tingkat_pendidikan" id="field_cr_tingkat_pendidikan" class="form-control" value="<?php echo isset($id) ? $model->TINGKAT_PENDIDIKAN : set_value('tingkat_pendidikan'); ?>" maxlength="50" minlength="2" placeholder="<?=$title_utama;?>" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Keterangan <span class="required" aria-required="true"> * </span></label>
                            <textarea name="keterangan" id="field_cr_keterangan" class="form-control" placeholder="Keterangan"><?php echo isset($id) ? $model->KETERANGAN : set_value('keterangan'); ?></textarea>
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
                                    <option <?=$selected?> value="<?=$key;?>"><?=$val;?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
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
                            <label class="control-label">Group ID BKN</label>
                            <input type="text" name="groupidbkn" id="field_cr_groupidbkn" class="form-control" value="<?php echo isset($id) ? $model->GROUP_ID_BKN : set_value('groupidbkn'); ?>" minlength="1" placeholder="GROUP ID BKN" />
                        </div>
                    </div>
                </div>
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