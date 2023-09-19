<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Pasangan 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_pasangan/tambah_proses?id='.$id) : site_url('master_pegawai/master_pegawai_pasangan/ubah_proses?id='.$id."&kode=".$model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Status Pasangan <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="jenis_pasangan" id="field_cr_jenis_pasangan" class="form-control" style="width: 100%">
                            <?php if (isset($list_jenis_pasangan)): ?>
                                <?php foreach ($list_jenis_pasangan as $val): ?>
                                    <?php
                                    $selec = '';
                                    if ($val['ID'] == $model['JENIS_PASANGAN'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Pasangan Ke <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="pasangan_ke" id="field_cr_pasangan_ke" class="form-control" value="<?php echo isset($model['PASANGAN_KE']) ? $model['PASANGAN_KE'] : $pasangan_ke; ?>" placeholder="Pasangan Ke" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Pekerjaan</label>
                    <div class="col-md-8">
                        <select name="trpekerjaan_id" id="field_cr_trpekerjaan_id" class="form-control" style="width: 100%">
                            <option value="">- Pilih Pekerjaan Pasangan -</option>
                            <?php if (isset($list_pekerjaan)): ?>
                                <?php foreach ($list_pekerjaan as $val): ?>
                                    <?php
                                    $selec = '';
                                    if ($val['ID'] == $model['TRPEKERJAAN_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group pasangan_pns" <?php echo (!empty($model['TRPEKERJAAN_ID']) && $model['TRPEKERJAAN_ID'] == 1) ? '' : 'style="display: none"';?>>
                    <label class="control-label col-md-3">NIP <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="nip" maxlength="16" id="field_cr_nip" class="form-control" value="<?php echo isset($model['NIP']) ? $model['NIP'] : set_value('nip'); ?>" placeholder="NIP" />
                        <input type="hidden" name="nik" maxlength="18" id="field_cr_nik" class="form-control" value="<?php echo isset($model['NIK']) ? $model['NIP'] : set_value('nik'); ?>" placeholder="NIK" />
                    </div>
                    <div class="col-md-1">
                        <a href="javascript:;" data-id="" class="popuplarge btn btn-circle btn-icon-only yellow" title="Cari Pegawai" data-modal-title="Daftar Pegawai" data-url="<?php echo site_url("daftar_pegawai/listpegawai?sex=".$list_jenis_pasangan[0]['ID']); ?>"><i class="fa fa-group"></i></a>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Nama Lengkap <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="nama_lengkap" maxlength="100" id="field_cr_nama_lengkap" class="form-control" value="<?php echo isset($model['NAMA']) ? $model['NAMA'] : set_value('nama_lengkap'); ?>" placeholder="Nama Lengkap" />
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
                    <label class="control-label col-md-3">Tanggal Nikah</label>
                    <div class="col-md-3">
                        <input type="text" name="tanggal_nikah" id="field_cr_tanggal_nikah" class="form-control" value="<?php echo isset($model['TGL_NIKAH2']) ? $model['TGL_NIKAH2'] : set_value('tanggal_nikah'); ?>" placeholder="Tanggal Nikah" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Karis</label>
                    <div class="col-md-3">
                        <input type="text" name="karis" id="field_cr_karis" class="form-control" value="<?php echo isset($model['KARIS']) ? $model['KARIS'] : set_value('karis'); ?>" placeholder="No Karis" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Dokumen Akta Nikah</label>
                    <div class="col-md-8">
                        <input type="file" name="doc_akta" id="field_cr_doc_akta" class="form-control" value="<?php echo set_value('doc_akta'); ?>" placeholder="Dokumen Akta Nikah" />
                        <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                    </div>
                    <?php if (!empty($model['DOC_AKTENIKAH']) && $model['DOC_AKTENIKAH'] <> '') { ?>
                        <div class="col-md-1">
                            <a href="javascript:;" data-url="<?php echo base_url() ?>master_pegawai/master_pegawai_pasangan/view_dokumen?id=<?php echo $model['ID'] ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                <i class="fa fa-file-pdf-o"></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Keterangan</label>
                    <div class="col-md-8">
                        <textarea name="keterangan" id="field_cr_keterangan" class="form-control" placeholder="Keterangan"><?php echo isset($model['KET']) ? $model['KET'] : set_value('keterangan'); ?></textarea>
                    </div>
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
    $("select#field_cr_jenis_pasangan").select2();
    $("select#field_cr_trpekerjaan_id").select2();
    $("input#field_cr_tanggal_lahir").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y') - 10)) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tanggal_nikah").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>