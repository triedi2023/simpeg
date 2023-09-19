<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Keterangan Lain 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_ket_lain/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_ket_lain/ubah_proses?id=' . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Keterangan <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="keterangan" maxlength="300" id="field_cr_keterangan" class="form-control" value="<?php echo isset($model['KETERANGAN']) ? $model['KETERANGAN'] : set_value('keterangan'); ?>" placeholder="Keterangan" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Pejabat <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="pejabat" maxlength="64" id="field_cr_pejabat" class="form-control" value="<?php echo isset($model['PEJABAT_SK']) ? $model['PEJABAT_SK'] : set_value('pejabat'); ?>" placeholder="Pejabat" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Nomor <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="no_sk" maxlength="64" id="field_cr_no_sk" class="form-control" value="<?php echo isset($model['NO_SK']) ? $model['NO_SK'] : set_value('no_sk'); ?>" placeholder="No SK" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="tanggal" maxlength="10" id="field_cr_tanggal" class="form-control" value="<?php echo isset($model['TGL_SK']) ? $model['TGL_SK'] : set_value('tanggal'); ?>" placeholder="Tanggal" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Dokumen</label>
                    <div class="col-md-8">
                        <input type="file" name="doc_sk" id="field_c_doc_sk" class="form-control" value="" placeholder="Dokumen" />
                        <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                    </div>
                    <?php if (!empty($model['DOC_KETLAIN']) && $model['DOC_KETLAIN'] <> '') { ?>
                        <div class="col-md-1">
                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_ket_lain/view_dokumen?id='.$model['ID']) ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                <i class="fa fa-file-pdf-o"></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <!--/row-->
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="button" class="btn default btnbatalformcudetailpegawai"><i class="fa fa-close"></i> Batal</button>
                        <button type="submit" class="btn btn-warning btn-circle blue-chambray"><i class="fa fa-check"> </i>Simpan</button>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script>
    $("input#field_cr_tanggal").datepicker({autoclose: true, language: "id", format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>