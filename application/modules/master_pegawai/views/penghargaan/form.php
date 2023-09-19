<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Penghargaan 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_penghargaan/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_penghargaan/ubah_proses?id=' . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Jenis Tanda Jasa <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="jenis_tandajasa" id="field_cr_jenis_tandajasa" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_jenis_tanda_jasa)): ?>
                                <?php foreach ($list_jenis_tanda_jasa as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRJENISTANDAJASA_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Nama Tanda Jasa <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="nama_tandajasa" id="field_cr_nama_tandajasa" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_tanda_jasa)): ?>
                                <?php foreach ($list_tanda_jasa as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRTANDAJASA_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Nomor</label>
                    <div class="col-md-8">
                        <input type="text" name="nomor" maxlength="100" id="field_cr_nomor" class="form-control" value="<?php echo isset($model['NOMOR']) ? $model['NOMOR'] : set_value('nomor'); ?>" placeholder="Nomor" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Tahun</label>
                    <div class="col-md-8">
                        <input type="text" name="tahun" maxlength="4" id="field_cr_tahun" class="form-control" value="<?php echo isset($model['THN_PRLHN']) ? $model['THN_PRLHN'] : set_value('tahun'); ?>" placeholder="Tahun" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal</label>
                    <div class="col-md-8">
                        <input type="text" name="tanggal" maxlength="10" id="field_cr_tanggal" class="form-control" value="<?php echo isset($model['TGL_PENGHARGAAN2']) ? $model['TGL_PENGHARGAAN2'] : set_value('tanggal'); ?>" placeholder="Tanggal" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Negara</label>
                    <div class="col-md-8">
                        <select name="negara" id="field_cr_negara" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_negara)): ?>
                                <?php foreach ($list_negara as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRNEGARA_ID'])
                                        $selec = 'selected=""';
                                    elseif (!isset ($model) && $val['ID'] == '071')
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Instansi</label>
                    <div class="col-md-8">
                        <input type="text" name="instansi" maxlength="100" id="field_cr_instansi" class="form-control" value="<?php echo isset($model['INSTANSI']) ? $model['INSTANSI'] : set_value('instansi'); ?>" placeholder="Instansi" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Dokumen / Sertifikat</label>
                    <div class="col-md-8">
                        <input type="file" name="doc_sk" id="field_c_doc_sk" class="form-control" value="" placeholder="Dokumen Sertifikat" />
                        <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                    </div>
                    <?php if (!empty($model['DOC_SERTIFIKAT']) && $model['DOC_SERTIFIKAT'] <> '') { ?>
                        <div class="col-md-1">
                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_penghargaan/view_dokumen?id='.$model['ID']) ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
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
    $("select#field_cr_jenis_tandajasa").select2();
    $("select#field_cr_nama_tandajasa").select2();
    $("select#field_cr_negara").select2();
    $("input#field_cr_tahun").datepicker({autoclose: true, language: "id", format: 'yyyy', startView: "years", minViewMode: "years", endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("9999", {placeholder: 'YYYY'});
    $("input#field_cr_tanggal").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>