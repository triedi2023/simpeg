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
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_jenis_cuti/ubah_proses?id=' . $id) : site_url('referensi_jenis_cuti/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Nama Cuti <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="nama_cuti" id="field_cr_nama_cuti" class="form-control" value="<?php echo isset($id) ? $model->NAMA_CUTI : set_value('nama_cuti'); ?>" placeholder="Nama Cuti" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Jumlah Hari Cuti</label>
                            <input type="text" name="jml_cuti" id="field_cr_jml_cuti" class="form-control" value="<?php echo isset($id) ? $model->JMLHARI : set_value('jml_cuti'); ?>" placeholder="Jml Cuti" />
                        </div>
                    </div>
                </div>
                    
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Jenis Kelamin</label>
                            <select name="jk" id="field_cr_jk" class="form-control" style="width: 100%">
                                <option value=""> - Pilih -</option>
                                <?php foreach ($this->config->item('list_jk') as $val): ?>
                                    <?php
                                    $selected = "";
                                    if (isset($model) && $val['ID'] == $model->SEX)
                                        $selected = 'selected=""';
                                    ?>
                                    <option <?= $selected ?> value="<?= $val['ID']; ?>"><?= $val['NAMA']; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
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
    $("select#field_cr_nama_cuti").select2();
    $("select#field_cr_jk").select2();
    $("select#field_cr_status").select2();
</script>