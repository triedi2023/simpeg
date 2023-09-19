<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Angka Kredit
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_ak/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_ak/ubah_proses?id=' . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Tahun Penilaian <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="tahun_penilaian" id="field_cr_tahun_penilaian" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_tahun)): ?>
                                <?php foreach ($list_tahun as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val == $model['TAHUN_KREDIT'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val ?>"><?= $val ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Jabatan <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="jabatan" id="field_cr_jabatan" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_jabatan_pegawai)): ?>
                                <?php foreach ($list_jabatan_pegawai as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRJABATAN_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Nilai Utama <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="nilai_utama" maxlength="7" id="field_cr_nilai_utama" class="form-control" value="<?php echo isset($model['AK_UTAMA']) ? $model['AK_UTAMA'] : set_value('nilai_utama'); ?>" placeholder="Nilai Utama" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Nilai Penunjang <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="nilai_penunjang" maxlength="7" id="field_cr_nilai_penunjang" class="form-control" value="<?php echo isset($model['AK_PENUNJANG']) ? $model['AK_PENUNJANG'] : set_value('nilai_penunjang'); ?>" placeholder="Nilai Penunjang" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Lembaga</label>
                    <div class="col-md-7">
                        <input type="text" name="lembaga" maxlength="150" id="field_cr_lembaga" class="form-control" value="<?php echo isset($model['LEMBAGA']) ? $model['LEMBAGA'] : set_value('lembaga'); ?>" placeholder="Lembaga" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Periode</label>
                    <div class="col-md-3">
                        <input type="text" name="tgl_mulai" maxlength="10" id="field_cr_tgl_mulai" class="form-control" value="<?php echo isset($model['PERIODE_AWAL2']) ? $model['PERIODE_AWAL2'] : set_value('tgl_mulai'); ?>" placeholder="Tanggal Mulai" />
                    </div>
                    <div style="margin-left: 0px;margin-right: 0px;padding-left: 0px;padding-right: 0px;width: 2%;vertical-align: middle" class="col-md-1">S/D</div>
                    <div class="col-md-3">
                        <input type="text" name="tgl_slesai" maxlength="10" id="field_cr_tgl_slesai" class="form-control" value="<?php echo isset($model['PERIODE_AKHIR2']) ? $model['PERIODE_AKHIR2'] : set_value('tgl_slesai'); ?>" placeholder="Tanggal Selesai" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">&nbsp;</div>
                    <div class="col-md-12">&nbsp;</div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="tabbable-custom nav-justified">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active">
                                    <a href="#tab_1_1_1" data-toggle="tab" aria-expanded="true"> Status Keputusan </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_1_1">
                                    <div class="form-body form-horizontal">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Nomor</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="no_sk" maxlength="64" id="field_cr_no_sk" class="form-control" value="<?php echo isset($model['NO_SK']) ? $model['NO_SK'] : set_value('no_sk'); ?>" placeholder="No SK" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Tanggal</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="tgl_sk" id="field_cr_tgl_sk" class="form-control" value="<?php echo isset($model['TGL_SK2']) ? $model['TGL_SK2'] : set_value('tgl_sk'); ?>" placeholder="Tgl SK" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Keterangan</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="keterangan" maxlength="300" id="field_cr_keterangan" class="form-control" value="<?php echo isset($model['KETERANGAN']) ? $model['KETERANGAN'] : set_value('keterangan'); ?>" placeholder="Keterangan" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Nama Pejabat</label>
                                                    <div class="col-md-7">
                                                        <input type="text" name="pejabat_sk" maxlength="300" id="field_cr_pejabat_sk" class="form-control" value="<?php echo isset($model['NAMA_PEJABAT_SK']) ? $model['NAMA_PEJABAT_SK'] : set_value('pejabat_sk'); ?>" placeholder="Nama Pejabat" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="javascript:;" class="popuplarge btn btn-circle btn-icon-only yellow" data-id="popuppilihpegawaiak" title="Pegawai Internal" data-modal-title="Daftar Pegawai" data-url="<?php echo site_url("daftar_pegawai/listpegawai") ?>"><i class="fa fa-group"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">NIP Pejabat</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="nip_pejabat" maxlength="18" id="field_cr_nip_pejabat" class="form-control" value="<?php echo isset($model['NIP_PEJABAT_SK']) ? $model['NIP_PEJABAT_SK'] : set_value('nip_pejabat'); ?>" placeholder="NIP Pejabat" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Nama Jabatan</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="nama_pejabat" maxlength="150" id="field_cr_nama_pejabat" class="form-control" value="<?php echo isset($model['PEJABAT_SK']) ? $model['PEJABAT_SK'] : set_value('nama_pejabat'); ?>" placeholder="Nama Jabatan" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Dokumen</label>
                                                    <div class="col-md-8">
                                                        <input type="file" name="doc_sk" id="field_c_doc_sk" class="form-control" value="" placeholder="Dokumen" />
                                                        <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                                                    </div>
                                                    <?php if (!empty($model['DOC_AK']) && $model['DOC_AK'] <> '') { ?>
                                                        <div class="col-md-1">
                                                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_ak/view_dokumen?id='.$model['ID']) ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                                                <i class="fa fa-file-pdf-o"></i>
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    $("select#field_cr_tahun_penilaian").select2();
    $("select#field_cr_jabatan").select2();
    $("input#field_cr_tgl_mulai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_slesai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>