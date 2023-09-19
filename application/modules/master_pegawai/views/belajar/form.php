<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Tugas / Ijin Belajar 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_belajar/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_belajar/ubah_proses?id=' . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Kelompok <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="kelompok" id="field_cr_kelompok" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_status_belajar)): ?>
                                <?php foreach ($list_status_belajar as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRSTATUSBELAJAR_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tingkat Pendidikan <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="tkt_pendidikan" id="field_cr_tkt_pendidikan" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_pendidikan)): ?>
                                <?php foreach ($list_pendidikan as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRTINGKATPENDIDIKAN_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Nama Lembaga / Universitas <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-7">
                        <input type="text" name="nama_lbg" maxlength="255" id="field_cr_nama_lbg" class="form-control" value="<?php echo isset($model['NAMA_LBGPDK']) ? $model['NAMA_LBGPDK'] : set_value('nama_lbg'); ?>" placeholder="Nama Lembaga / Sekolah / Perguruan Tinggi" />
                        <input type="hidden" name="universitas_id" readonly="" maxlength="4" id="field_cr_universitas_id" class="form-control" value="<?php echo isset($model['TRUNIVERSITAS_ID']) ? $model['TRUNIVERSITAS_ID'] : set_value('universitas_id'); ?>" />
                    </div>
                    <div class="col-md-2 option-pendidikan" <?php echo (!empty($model['TRTINGKATPENDIDIKAN_ID']) && $model['TRTINGKATPENDIDIKAN_ID'] < '9') ? '' : 'style="display: none"'; ?>>
                        <a href="javascript:;" class="popuplarge btn btn-circle btn-icon-only yellow" title="Cari Universitas" data-modal-title="Daftar Universitas" data-url="<?php echo site_url("daftar_universitas/listuniversitas") ?>"><i class="fa fa-university"></i></a>
                    </div>
                </div>

                <div class="form-group option-pendidikan" <?php echo (!empty($model['TRTINGKATPENDIDIKAN_ID']) && $model['TRTINGKATPENDIDIKAN_ID'] < '9') ? '' : 'style="display: none"'; ?>>
                    <label class="control-label col-md-3">Fakultas / Jurusan</label>
                    <div class="col-md-3">
                        <select name="fakultas" id="field_cr_fakultas" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_fakultas)): ?>
                                <?php foreach ($list_fakultas as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRFAKULTAS_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="jurusan" readonly="" maxlength="200" id="field_cr_jurusan" class="form-control" value="<?php echo isset($list_jurusan[0]['NAMA']) ? $list_jurusan[0]['NAMA'] : set_value('jurusan'); ?>" placeholder="Nama Jurusan" />
                        <input type="hidden" name="jurusan_id" maxlength="4" id="field_cr_jurusan_id" class="form-control" value="<?php echo isset($model['TRJURUSAN_ID']) ? $model['TRJURUSAN_ID'] : set_value('jurusan_id'); ?>" />
                    </div>
                    <div class="col-md-2">
                        <a href="javascript:;" class="popuplarge btn btn-circle btn-icon-only yellow" title="Cari Jurusan" data-modal-title="Daftar Jurusan" data-url="<?php echo site_url("daftar_jurusan/listjurusan") ?>"><i class="fa fa-graduation-cap"></i></a>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Negara</label>
                    <div class="col-md-8">
                        <select name="negara" id="field_cr_negara" class="form-control" style="width: 100%">
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
                    <label class="control-label col-md-3">Status <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="kondisi" id="field_cr_kondisi" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_kondisi_belajar)): ?>
                                <?php foreach ($list_kondisi_belajar as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRKONDISIBELAJAR_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Masa Studi</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="masa_std" maxlength="2" id="field_cr_masa_std" class="form-control" value="<?php echo isset($model['MASA_SK']) ? $model['MASA_SK'] : set_value('nama_lbg'); ?>" placeholder="Masa Study" />
                            <span class="input-group-addon">Tahun</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal Mulai</label>
                    <div class="col-md-3">
                        <input type="text" name="tgl_mulai" maxlength="10" id="field_cr_tgl_mulai" class="form-control" value="<?php echo isset($model['START_SK2']) ? $model['START_SK2'] : set_value('tgl_mulai'); ?>" placeholder="Tanggal Mulai" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal Selesai</label>
                    <div class="col-md-3">
                        <input type="text" name="tgl_slesai" maxlength="10" id="field_cr_tgl_slesai" class="form-control" value="<?php echo isset($model['END_SK2']) ? $model['END_SK2'] : set_value('tgl_slesai'); ?>" placeholder="Tanggal Selesai" />
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
                                                    <label class="control-label col-md-3">Surat Keterangan Tugas / Ijin Belajar</label>
                                                    <div class="col-md-8">
                                                        <input type="file" name="doc_sk" id="field_c_doc_sk" class="form-control" value="" placeholder="Dokumen SK" />
                                                        <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                                                    </div>
                                                    <?php if (!empty($model['DOC_SK']) && $model['DOC_SK'] <> '') { ?>
                                                        <div class="col-md-1">
                                                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_belajar/view_dokumen?id='.$model['ID']) ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
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
    $("select#field_cr_tkt_pendidikan").select2();
    $("select#field_cr_kelompok").select2();
    $("select#field_cr_negara").select2();
    $("select#field_cr_fakultas").select2();
    $("select#field_cr_kondisi").select2();
    $("input#field_cr_tgl_mulai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_slesai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>