<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Seminar 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_seminar/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_seminar/ubah_proses?id=' . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Jenis Kegiatan <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="jenis_kegiatan" id="field_cr_jenis_kegiatan" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_kegiatan)): ?>
                                <?php foreach ($list_kegiatan as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRJENISKEGIATAN_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Nama Kegiatan <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="nama_kegiatan" maxlength="255" id="field_cr_nama_kegiatan" class="form-control" value="<?php echo isset($model['NAMA_KEGIATAN']) ? $model['NAMA_KEGIATAN'] : set_value('nama_kegiatan'); ?>" placeholder="Nama Kegiatan" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Negara / Tempat</label>
                    <div class="col-md-4">
                        <select name="negara" id="field_cr_negara" class="form-control" style="width: 100%">
                            <?php if (isset($list_negara)): ?>
                                <?php foreach ($list_negara as $val): ?>
                                    <?php
                                    $selec = '';
                                    if ((isset($model) && $val['ID'] == $model['TRNEGARA_ID']) || ($val['ID'] == '071'))
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="tempat" maxlength="64" id="field_cr_tempat" class="form-control" value="<?php echo isset($model['TEMPAT']) ? $model['TEMPAT'] : set_value('tempat'); ?>" placeholder="Tempat" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Pembiayaan / Sponsor</label>
                    <div class="col-md-4">
                        <select name="pembiayaan" id="field_cr_pembiayaan" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_pembiayaan)): ?>
                                <?php foreach ($list_pembiayaan as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRJENISPEMBIAYAAN_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="sponsor" maxlength="100" id="field_cr_sponsor" class="form-control" value="<?php echo isset($model['SPONSOR']) ? $model['SPONSOR'] : set_value('sponsor'); ?>" placeholder="Sponsor" />
                    </div>
                </div>



                <div class="form-group">
                    <label class="control-label col-md-3">Kedudukan Dalam Kegiatan</label>
                    <div class="col-md-8">
                        <select name="kedudukan" id="field_cr_kedudukan" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_kedudukan)): ?>
                                <?php foreach ($list_kedudukan as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRKEDUDUKANDLMKEGIATAN_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal Mulai</label>
                    <div class="col-md-3">
                        <input type="text" name="tgl_mulai" maxlength="10" id="field_cr_tgl_mulai" class="form-control" value="<?php echo isset($model['TGL_MULAI2']) ? $model['TGL_MULAI2'] : set_value('tgl_mulai'); ?>" placeholder="Tanggal Mulai" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal Selesai</label>
                    <div class="col-md-3">
                        <input type="text" name="tgl_selesai" maxlength="10" id="field_cr_tgl_selesai" class="form-control" value="<?php echo isset($model['TGL_SELESAI2']) ? $model['TGL_SELESAI2'] : set_value('tgl_selesai'); ?>" placeholder="Tanggal Selesai" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Penyelenggara</label>
                    <div class="col-md-8">
                        <input type="text" name="penyelenggara" maxlength="255" id="field_cr_penyelenggara" class="form-control" value="<?php echo isset($model['PENYELENGGARA']) ? $model['PENYELENGGARA'] : set_value('penyelenggara'); ?>" placeholder="Penyelenggara" />
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
                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_seminar/view_dokumen?id='.$model['ID']) ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
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
    $("select#field_cr_jenis_kegiatan").select2();
    $("select#field_cr_negara").select2();
    $("select#field_cr_pembiayaan").select2();
    $("select#field_cr_kedudukan").select2();
    $("input#field_cr_tgl_mulai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_selesai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>