<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Jabatan 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_gaji/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_gaji/ubah_proses?id=' . $model['TMPEGAWAI_ID'] . "&kode=" . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Pangkat / Golongan <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <select name="pangkat_id" id="field_cr_pangkat_id" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_golongan)): ?>
                                <?php foreach ($list_golongan as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model['TRGOLONGAN_ID']) && $val['ID'] == $model['TRGOLONGAN_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">TMT KGB <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-3">
                        <input type="text" name="tmt_kgb" id="field_cr_tmt_kgb" maxlength="10" class="form-control" placeholder="TMT KGB" value="<?php echo isset($model['TMT_KGB2']) ? $model['TMT_KGB2'] : set_value('tmt_kgb'); ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Gaji Baru</label>
                    <div class="col-md-4">
                        <input type="text" name="gaji_baru" maxlength="15" id="field_cr_gaji_baru" class="form-control" value="<?php echo isset($model['GAPOK']) ? $model['GAPOK'] : set_value('gaji_baru'); ?>" placeholder="Gaji Baru" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Pejabat SK</label>
                    <div class="col-md-4">
                        <input type="text" name="pejabat_sk" maxlength="300" id="field_cr_pejabat_sk" class="form-control" value="<?php echo isset($model['PEJABAT_SK']) ? $model['PEJABAT_SK'] : set_value('pejabat_sk'); ?>" placeholder="Pejabat SK" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">No SK</label>
                    <div class="col-md-4">
                        <input type="text" name="no_sk" maxlength="128" id="field_cr_no_sk" class="form-control" value="<?php echo isset($model['NO_SK']) ? $model['NO_SK'] : set_value('no_sk'); ?>" placeholder="NO SK" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal SK</label>
                    <div class="col-md-4">
                        <input type="text" name="tgl_sk" maxlength="10" id="field_cr_tgl_sk" class="form-control" value="<?php echo isset($model['TGL_SK2']) ? $model['TGL_SK2'] : set_value('tgl_sk'); ?>" placeholder="Tanggal SK" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">No SKEP</label>
                    <div class="col-md-4">
                        <input type="text" name="no_skep" maxlength="128" id="field_cr_no_skep" class="form-control" value="<?php echo isset($model['NO_SKEP']) ? $model['NO_SKEP'] : set_value('no_skep'); ?>" placeholder="NO SKEP" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal SKEP</label>
                    <div class="col-md-4">
                        <input type="text" name="tgl_skep" maxlength="10" id="field_cr_tgl_skep" class="form-control" value="<?php echo isset($model['TGL_SKEP2']) ? $model['TGL_SKEP2'] : set_value('tgl_skep'); ?>" placeholder="Tanggal SKEP" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tempat Penetapan</label>
                    <div class="col-md-4">
                        <input type="text" name="tempat" maxlength="128" id="field_cr_tempat" class="form-control" value="<?php echo isset($model['TEMPAT_PENETAPAN']) ? $model['TEMPAT_PENETAPAN'] : set_value('tempat'); ?>" placeholder="Tempat Penetapan" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">SK KGB</label>
                    <div class="col-md-8">
                        <input type="file" name="doc_sk" id="field_c_doc_sk" class="form-control" value="" placeholder="Dokumen SK" />
                        <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                    </div>
                    <?php if (!empty($model['DOC_SKKGB']) && $model['DOC_SKKGB'] <> '') { ?>
                        <div class="col-md-1">
                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_gaji/view_dokumen?id=' . $model['ID']); ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                <i class="fa fa-file-pdf-o"></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <!--/row-->
            </div>
            
            <?php if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') { ?>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <button type="button" class="btn default btnbatalformcudetailpegawai"><i class="fa fa-close"></i> Batal</button>
                        <button type="submit" class="btn btn-warning btn-circle blue-chambray"><i class="fa fa-check"> </i>Simpan</button>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script>
    $("select#field_cr_pangkat_id").select2();
    $("input#field_cr_tmt_kgb").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_skep").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>