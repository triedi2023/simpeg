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
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_hari_larangan_cuti/ubah_proses?id=' . $id) : site_url('referensi_hari_larangan_cuti/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Tanggal <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="tanggal" maxlength="10" id="field_cr_tanggal" class="form-control" value="<?php echo isset($id) ? $model->PERIODE_LARANGAN_CUTI2 : set_value('tanggal'); ?>" placeholder="Tanggal" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="control-label">Keterangan <span class="required" aria-required="true"> * </span></label>
                            <textarea name="keterangan" id="field_cr_keterangan" class="form-control" placeholder="Keterangan"><?php echo isset($id) ? $model->KETERANGAN : set_value('keterangan'); ?></textarea>
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
    $("select#field_cr_jk").select2();
    $("input#field_cr_tanggal").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>