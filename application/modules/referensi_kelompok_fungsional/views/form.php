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
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_kelompok_fungsional/ubah_proses?id='.$id) : site_url('referensi_kelompok_fungsional/tambah_proses')]); ?>
            <div class="form-body">
                
                <div class="row">
                    <!-- div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Eselon</label>
                            <select name="eselon" id="field_cr_eselon" class="form-control">
                                <option value="">- Pilih -</option>
                                <?php // foreach ($list_eselon as $val): ?>
                                    <?php
//                                    $selected = "";
//                                    if (isset($model) && $val['ID'] == $model->TRESELON_ID)
//                                        $selected = 'selected=""';
                                    ?>
                                    <option <?php // echo $selected?> value="<?php // echo $val['ID'];?>"><?php // echo $val['NAMA'];?></option>
                                <?php // endforeach ?>
                            </select>
                        </div>
                    </div -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Kelompok Fungsional <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="kelompok_fungsional" id="field_cr_kelompok_fungsional" class="form-control" value="<?php echo isset($id) ? $model->KELOMPOK_FUNGSIONAL : set_value('kelompok_fungsional'); ?>" placeholder="Kelompok Fungsional" />
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
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">ID</label>
                            <input type="text" name="idbkn" id="field_cr_idbkn" class="form-control" value="<?php echo isset($id) ? $model->ID_BKN : set_value('idbkn'); ?>" minlength="1" placeholder="ID BKN" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">NAMA</label>
                            <input type="text" name="namabkn" id="field_cr_namabkn" class="form-control" value="<?php echo isset($id) ? $model->NAMA_BKN : set_value('namabkn'); ?>" minlength="1" placeholder="NAMA" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Jabatan</label>
                            <input type="text" name="jabatanbkn" id="field_cr_jabatanbkn" class="form-control" value="<?php echo isset($id) ? $model->JENIS_JABATAN_UMUM_BKN : set_value('jabatanbkn'); ?>" placeholder="Jabatan" />
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Rumpun</label>
                            <input type="text" name="rumpun" id="field_cr_rumpun" class="form-control" value="<?php echo isset($id) ? $model->RUMPUN_JABATAN_BKN : set_value('rumpun'); ?>" minlength="1" placeholder="Rumpun" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Pembina</label>
                            <input type="text" name="pembina" id="field_cr_pembina" class="form-control" value="<?php echo isset($id) ? $model->PEMBINA_BKN : set_value('pembina'); ?>" minlength="1" placeholder="Pembina" />
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