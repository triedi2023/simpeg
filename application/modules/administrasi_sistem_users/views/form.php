<div class="col-md-12">
    <div class="portlet box yellow-gold">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Form <?= $title_form; ?> Administrasi Sistem <?= $title_utama; ?>
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <?php echo form_open("://", ["class" => "formcreateupdate form-horizontal", 'data-url' => isset($id) ? site_url('administrasi_sistem_users/ubah_proses?id=' . $id) : site_url('administrasi_sistem_users/tambah_proses')]); ?>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">Username <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-6">
                        <input type="text" name="username" readonly="" id="field_cr_username" class="form-control" value="<?php echo isset($id) ? $model->USERNAME : set_value('username'); ?>" maxlength="100" minlength="2" placeholder="Username" />
                    </div>
                    <div class="col-md-2">
                        <a href="javascript:;" class="popuplarge btn btn-circle btn-icon-only yellow" title="Cari Username" data-modal-title="Daftar Username" data-url="<?php echo site_url("daftar_user/listuser") ?>"><i class="fa fa-users"></i></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">NIP / Nama <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-3">
                        <input type="text" name="nip" readonly="" id="field_cr_nip" class="form-control" value="<?php echo isset($id) ? $model->JENIS_TANDA_JASA : set_value('jenis_tj'); ?>" maxlength="20" placeholder="NIP" />
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="nama" readonly="" id="field_cr_nama" class="form-control" value="<?php echo isset($id) ? $model->JENIS_TANDA_JASA : set_value('jenis_tj'); ?>" maxlength="200" minlength="1" placeholder="Nama Pegawai" />
                    </div>
                    <div class="col-md-2">
                        <a href="javascript:;" class="popuplarge btn btn-circle btn-icon-only yellow" data-id="popuppilihpegawaiak" title="Cari Pegawai" data-modal-title="Daftar Pegawai" data-url="<?php echo site_url("daftar_pegawai/listpegawai") ?>"><i class="fa fa-users"></i></a>
                    </div>
                </div>
                <!--/span-->
                <div class="form-group">
                    <label class="col-md-2 control-label">Group <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-3">
                        <select name="group" id="field_cr_group" class="form-control" style="width: 100%">
                            <?php foreach ($list_group as $val): ?>
                                <?php
                                $selected = "";
                                if (isset($model) && $key == $model->SYSTEMGROUP_ID)
                                    $selected = 'selected=""';
                                ?>
                                <option <?= $selected ?> value="<?= $val['ID']; ?>"><?= $val['NAMA']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Status <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-3">
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
            <div class="form-actions fluid">
                <div class="row">
                    <div class="col-md-offset-2 col-md-9">
                        <button type="button" class="btn default btnbatalformcu"><i class="fa fa-close"></i> Batal</button>
                        <button type="submit" class="btn btn-warning btn-circle"><i class="fa fa-check"></i> Simpan</button>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
            <!--/row-->
        </div>
        <!-- END FORM-->
    </div>
</div>
<script type="text/javascript">
    $("select#field_cr_group").select2();
    $("select#field_cr_status").select2();
</script>