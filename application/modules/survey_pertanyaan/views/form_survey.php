<div class="col-md-12">
    <div class="portlet box yellow-gold">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Form <?= $title_form; ?> Survey
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => site_url('survey_pertanyaan/ubah_proses_pertanyaan?id=' . $id)]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Judul <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="judul" id="field_cr_judul" class="form-control" value="<?php echo isset($id) ? $model->JUDUL : set_value('judul'); ?>" placeholder="Judul" />
                        </div>
                    </div>
                    <!-- div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Status <span class="required" aria-required="true"> * </span></label>
                            <select name="status" id="field_cr_status" class="form-control">
                                <option value="">- Pilih -</option>
                                <?php // foreach ([1=>'Uji Coba',2=>'Pelaksanaan'] as $key => $val): ?>
                                    <?php
//                                    $selected = "";
//                                    if (isset($model) && $key == $model->STATUS)
//                                        $selected = 'selected=""';
                                    ?>
                                    <option <?php // echo $selected?> value="<?php // echo $key;?>"><?php // echo $val;?></option>
                                <?php // endforeach ?>
                            </select>
                        </div>
                    </div -->
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Tanggal Mulai <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="tgl_mulai" id="field_cr_tgl_mulai" class="form-control" value="<?php echo isset($id) ? $model->START_DATE : set_value('tgl_mulai'); ?>" placeholder="Tanggal Mulai" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Tanggal Selesai <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="tgl_selesai" id="field_cr_tgl_selesai" class="form-control" value="<?php echo isset($id) ? $model->END_DATE : set_value('tgl_selesai'); ?>" placeholder="Tanggal Selesai" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="control-label">Keterangan</label>
                            <textarea name="keterangan" id="field_cr_keterangan" class="form-control" placeholder="Keterangan"><?php echo isset($id) ? $model->KETERANGAN : set_value('keterangan'); ?></textarea>
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
<script type="text/javascript">
    $("input#field_cr_tgl_mulai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_selesai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', startDate: '+0d'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>