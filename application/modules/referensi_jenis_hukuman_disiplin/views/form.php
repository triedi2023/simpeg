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
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_jenis_hukuman_disiplin/ubah_proses?id=' . $id) : site_url('referensi_jenis_hukuman_disiplin/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Tingkat Hukdis <span class="required" aria-required="true"> * </span></label>
                            <select name="tkthukdis_id" id="field_cr_tkthukdis_id" class="form-control">
                                <?php if ($list_tkt_hukdis): ?>
                                    <?php foreach ($list_tkt_hukdis as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model->TRTKTHUKUMANDISIPLIN_ID)
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
                            <label class="control-label">Jenis Hukdis <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="jenis_hukdis" id="field_cr_jenis_hukdis" class="form-control" value="<?php echo isset($id) ? $model->JENIS_HUKDIS : set_value('jenis_hukdis'); ?>" placeholder="Jenis Hukdis" />
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
                            <input type="text" name="id_bkn" id="field_cr_id_bkn" class="form-control" value="<?php echo isset($id) ? $model->ID_BKN : set_value('id_bkn'); ?>" placeholder="ID BKN" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="control-label">NAMA BKN</label>
                            <input type="text" name="nama_bkn" id="field_cr_nama_bkn" class="form-control" value="<?php echo isset($id) ? $model->NAMA_BKN : set_value('nama_bkn'); ?>" placeholder="Nama BKN" />
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