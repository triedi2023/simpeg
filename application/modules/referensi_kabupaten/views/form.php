<div class="col-md-12">
    <div class="portlet box yellow-gold">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Form <?=$title_form;?> Referensi <?=$title_utama?>
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_kabupaten/ubah_proses?id='.$id) : site_url('referensi_kabupaten/tambah_proses')]); ?>
            <div class="form-body">
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Provinsi <span class="required" aria-required="true"> * </span></label>
                            <select name="provinsi" id="field_cr_provinsi" class="form-control">
                                <?php foreach ($list_provinsi as $val): ?>
                                    <?php
                                    $selected = "";
                                    if (isset($model) && $val['ID'] == $model->TRPROPINSI_ID)
                                        $selected = 'selected=""';
                                    ?>
                                    <option <?=$selected?> value="<?=$val['ID'];?>"><?=$val['NAMA'];?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Nama Kabupaten / Kota <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="kabupaten" id="field_cr_kabupaten" class="form-control" value="<?php echo isset($id) ? $model->KABUPATEN : set_value('kabupaten'); ?>" placeholder="Nama Kabupaten" />
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
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">ID BKN</label>
                            <input type="text" name="idbkn" id="field_cr_idbkn" class="form-control" value="<?php echo isset($id) ? $model->ID_BKN : set_value('idbkn'); ?>" placeholder="ID BKN" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">ID Lokasi BKN</label>
                            <input type="text" name="idlokasibkn" id="field_cr_idlokasibkn" class="form-control" value="<?php echo isset($id) ? $model->LOKASI_ID_BKN : set_value('idlokasibkn'); ?>" placeholder="ID Lokasi BKN" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Nama BKN</label>
                            <input type="text" name="namabkn" id="field_cr_namabkn" class="form-control" value="<?php echo isset($id) ? $model->NAMA_BKN : set_value('namabkn'); ?>" placeholder="Nama BKN" />
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