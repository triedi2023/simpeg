<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Pasangan 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_anak/tambah_proses?id='.$id) : site_url('master_pegawai/master_pegawai_anak/ubah_proses?id='.$id."&kode=".$model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Status Anak <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="status_anak" id="field_cr_status_anak" class="form-control" style="width: 100%">
                            <?php if (isset($list_sts_anak)): ?>
                                <?php foreach ($list_sts_anak as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRSTATUSANAK_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Nama Lengkap <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="nama_lengkap" maxlength="100" id="field_cr_nama_lengkap" class="form-control" value="<?php echo isset($model['NAMA']) ? $model['NAMA'] : set_value('nama_lengkap'); ?>" placeholder="Nama Lengkap" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Jenis Kelamin</label>
                    <div class="col-md-8">
                        <select name="jk" id="field_cr_jk" class="form-control" style="width: 100%">
                            <option value="">- Pilih Jenis Kelamin -</option>
                            <?php if (isset($list_jk)): ?>
                                <?php foreach ($list_jk as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['SEX'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tempat Lahir</label>
                    <div class="col-md-8">
                        <input type="text" name="tempat_lahir" maxlength="50" id="field_cr_tempat_lahir" class="form-control" value="<?php echo isset($model['TEMPAT_LHR']) ? $model['TEMPAT_LHR'] : set_value('tempat_lahir'); ?>" placeholder="Tempat Lahir" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal Lahir</label>
                    <div class="col-md-3">
                        <input type="text" name="tanggal_lahir" id="field_cr_tanggal_lahir" class="form-control" value="<?php echo isset($model['TGL_LAHIR2']) ? $model['TGL_LAHIR2'] : set_value('tanggal_lahir'); ?>" placeholder="Tanggal Lahir" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Pekerjaan</label>
                    <div class="col-md-3">
                        <input type="text" name="pekerjaan" id="field_cr_pekerjaan" class="form-control" value="<?php echo isset($model['PEKERJAAN']) ? $model['PEKERJAAN'] : set_value('pekerjaan'); ?>" placeholder="Pekerjaan" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Keterangan</label>
                    <div class="col-md-8">
                        <textarea name="keterangan" id="field_cr_keterangan" class="form-control" placeholder="Keterangan"><?php echo isset($model['KETERANGAN']) ? $model['KETERANGAN'] : set_value('keterangan'); ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Dokumen Akta</label>
                    <div class="col-md-8">
                        <input type="file" name="doc_akta" id="field_cr_doc_akta" class="form-control" value="<?php echo set_value('doc_akta'); ?>" placeholder="Dokumen Akta" />
                        <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                    </div>
                    <?php if (!empty($model['DOC_AKTEANAK']) && $model['DOC_AKTEANAK'] <> '') { ?>
                        <div class="col-md-1">
                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_anak/view_dokumen?id='.$model['ID']); ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
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
                    <div class="col-md-offset-3 col-md-9">
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
    $("select#field_cr_status_anak").select2();
    $("select#field_cr_jk").select2();
    $("input#field_cr_tanggal_lahir").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>