<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Organisasi 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_organisasi/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_organisasi/ubah_proses?id=' . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Jenis Organisasi <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="jenis_organisasi" id="field_cr_jenis_organisasi" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_organisasi)): ?>
                                <?php foreach ($list_organisasi as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRJENISORGANISASI_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Nama Organisasi <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="nama_organisasi" maxlength="128" id="field_cr_nama_organisasi" class="form-control" value="<?php echo isset($model['NAMA_ORG']) ? $model['NAMA_ORG'] : set_value('nama_organisasi'); ?>" placeholder="Nama Organisasi" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Jabatan Dalam Organisasi</label>
                    <div class="col-md-8">
                        <input type="text" name="jbtn_organisasi" maxlength="64" id="field_cr_jbtn_organisasi" class="form-control" value="<?php echo isset($model['JABATAN_ORG']) ? $model['JABATAN_ORG'] : set_value('jbtn_organisasi'); ?>" placeholder="Jabatan Organisasi" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Tempat Organisasi</label>
                    <div class="col-md-8">
                        <input type="text" name="tempat_organisasi" maxlength="128" id="field_cr_tempat_organisasi" class="form-control" value="<?php echo isset($model['TEMPAT_ORG']) ? $model['TEMPAT_ORG'] : set_value('tempat_organisasi'); ?>" placeholder="Tempat Organisasi" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tahun Terdaftar / S/D</label>
                    <div class="col-md-4">
                        <input type="text" name="awal" maxlength="4" id="field_cr_awal" class="form-control" value="<?php echo isset($model['THN_TERDAFTAR']) ? $model['THN_TERDAFTAR'] : set_value('awal'); ?>" placeholder="Tahun Terdaftar" />
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="akhir" maxlength="4" id="field_cr_akhir" class="form-control" value="<?php echo isset($model['THN_SELESAI']) ? $model['THN_SELESAI'] : set_value('akhir'); ?>" placeholder="Sampai Dengan" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Nama Pimpinan Organisasi</label>
                    <div class="col-md-8">
                        <input type="text" name="pimpinan" maxlength="100" id="field_cr_pimpinan" class="form-control" value="<?php echo isset($model['PIMPINAN_ORG']) ? $model['PIMPINAN_ORG'] : set_value('pimpinan'); ?>" placeholder="Nama Pimpinan Organisasi" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Keterangan</label>
                    <div class="col-md-8">
                        <textarea name="keterangan" id="field_cr_keterangan" class="form-control" placeholder="Keterangan"><?php echo isset($model['KET']) ? $model['KET'] : set_value('keterangan'); ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Sertifikat</label>
                    <div class="col-md-8">
                        <input type="file" name="doc_sk" id="field_c_doc_sk" class="form-control" value="" placeholder="Dokumen Sertifikat" />
                        <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                    </div>
                    <?php if (!empty($model['DOC_SERTIFIKAT']) && $model['DOC_SERTIFIKAT'] <> '') { ?>
                        <div class="col-md-1">
                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_organisasi/view_dokumen?id='.$model['ID']) ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
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
    $("select#field_cr_jenis_organisasi").select2();
    $("input#field_cr_awal").datepicker({autoclose: true, language: "id", format: 'yyyy', startView: "years", minViewMode: "years", endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("9999", {placeholder: 'YYYY'});
    $("input#field_cr_akhir").datepicker({autoclose: true, language: "id", format: 'yyyy', startView: "years", minViewMode: "years", endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("9999", {placeholder: 'YYYY'});
</script>