<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Fungsional Pegawai
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_fungsional/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_fungsional/ubah_proses?id=' . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Nama Jabatan <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="jabatan_id" id="field_cr_jabatan_id" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_jabatan_pegawai)): ?>
                                <?php foreach ($list_jabatan_pegawai as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model['TRJABATAN_ID']) && $val['ID'] == $model['TRJABATAN_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Status <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="status" id="field_cr_status" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_status_fungsional)): ?>
                                <?php foreach ($list_status_fungsional as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRSTATUSFUNGSIONAL_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Alasan <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="alasan" id="field_cr_alasan" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_status_alasan_fungsional)): ?>
                                <?php foreach ($list_status_alasan_fungsional as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRALASANSTATUSFUNGSIONAL_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">TMT</label>
                    <div class="col-md-4">
                        <input type="text" name="tgl_mulai" maxlength="10" id="field_cr_tgl_mulai" class="form-control" value="<?php echo isset($model['TMT_JABATAN2']) ? $model['TMT_JABATAN2'] : set_value('tgl_mulai'); ?>" placeholder="Tanggal Mulai" />
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="tgl_slesai" maxlength="10" id="field_cr_tgl_slesai" class="form-control" value="<?php echo isset($model['TGL_AKHIR2']) ? $model['TGL_AKHIR2'] : set_value('tgl_slesai'); ?>" placeholder="Tanggal Selesai" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Jumlah Angka Kredit</label>
                    <div class="col-md-4">
                        <input type="text" name="angka_kredit" maxlength="8" id="field_cr_angka_kredit" class="form-control" value="<?php echo isset($model['A_KREDIT']) ? $model['A_KREDIT'] : set_value('nama_lbg'); ?>" placeholder="Angka Kredit" />
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
                                    <a href="#tab_1_1_1" data-toggle="tab" aria-expanded="true"> Surat Keputusan </a>
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
                                                        <input type="text" maxlength="10" name="tgl_sk" id="field_cr_tgl_sk" class="form-control" value="<?php echo isset($model['TGL_SK2']) ? $model['TGL_SK2'] : set_value('tgl_sk'); ?>" placeholder="Tgl SK" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Pejabat</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="pejabat_sk" maxlength="64" id="field_cr_pejabat_sk" class="form-control" value="<?php echo isset($model['PEJABAT_SK']) ? $model['PEJABAT_SK'] : set_value('pejabat_sk'); ?>" placeholder="Pejabat SK" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Lembaga</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="lembaga" maxlength="128" id="field_cr_lembaga" class="form-control" value="<?php echo isset($model['LEMBAGA']) ? $model['LEMBAGA'] : set_value('lembaga'); ?>" placeholder="Lembaga" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Dokumen SK</label>
                                                    <div class="col-md-8">
                                                        <input type="file" name="doc_sk" id="field_c_doc_sk" class="form-control" value="" placeholder="Dokumen SK" />
                                                        <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                                                    </div>
                                                    <?php if (!empty($model['DOC_RIWFUNGSIONAL']) && $model['DOC_RIWFUNGSIONAL'] <> '') { ?>
                                                        <div class="col-md-1">
                                                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_fungsional/view_dokumen?id=' . $model['ID']) ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
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
    $("select#field_cr_status").select2();
    $("select#field_cr_alasan").select2();
    $("select#field_cr_jabatan_id").select2({allowClear: true});
    $("input#field_cr_tgl_mulai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_slesai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>