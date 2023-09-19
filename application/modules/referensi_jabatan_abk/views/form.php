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
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_jabatan_abk/ubah_proses?id=' . $id) : site_url('referensi_jabatan_abk/tambah_proses')]); ?>
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Jabatan</label>
                            <select name="jabatan[]" multiple="" id="field_c_jabatan" style="width: 100%" class="form-control">
                                <?php if (isset($list_jabatan)): ?>
                                    <?php foreach ($list_jabatan as $val): ?>
                                        <option value="<?=$val['ID']?>"><?=$val['NAMA']?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
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
<script>
    $("select#field_c_jabatan").select2({placeholder: "Pilih Jabatan", multiple: true});
</script>