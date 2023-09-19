<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Pendidikan 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", "data-identify"=>"updatependidikanpegawai", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_pendidikan/tambah_proses?id='.$id) : site_url('master_pegawai/master_pegawai_pendidikan/ubah_proses?id='.$id)]); ?>
            <div class="form-body">

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
                    <div class="col-md-2 option-pendidikan" <?php echo (!empty($model['TRTINGKATPENDIDIKAN_ID']) && $model['TRTINGKATPENDIDIKAN_ID'] < '9') ? '' : 'style="display: none"';?>>
                        <a href="javascript:;" class="popuplarge btn btn-circle btn-icon-only yellow" title="Cari Universitas" data-modal-title="Daftar Universitas" data-url="<?php echo site_url("daftar_universitas/listuniversitas")?>"><i class="fa fa-university"></i></a>
                    </div>
                </div>
                
                <div class="form-group option-pendidikan" <?php echo (!empty($model['TRTINGKATPENDIDIKAN_ID']) && $model['TRTINGKATPENDIDIKAN_ID'] < '11') ? '' : 'style="display: none"';?>>
                    <label class="control-label col-md-3">Fakultas / Jurusan</label>
                    <div class="col-md-3" id="jurusansmksma" <?php echo (!empty($model['TRTINGKATPENDIDIKAN_ID']) && $model['TRTINGKATPENDIDIKAN_ID'] == '11') ? 'style="display: none"' : '';?>>
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
                    <div class="col-md-4 jurusansmksma" <?php echo (!empty($model['TRTINGKATPENDIDIKAN_ID']) && $model['TRTINGKATPENDIDIKAN_ID'] == '11') ? 'style="display: none"' : '';?>>
                        <input type="text" name="jurusan" <?php echo (!empty($model['TRTINGKATPENDIDIKAN_ID']) && $model['TRTINGKATPENDIDIKAN_ID'] < '9') ? 'readonly=""' : '';?> maxlength="200" id="field_cr_jurusan" class="form-control" value="<?php echo isset($list_jurusan[0]['NAMA']) ? $list_jurusan[0]['NAMA'] : set_value('jurusan'); ?>" placeholder="Nama Jurusan" />
                        <input type="hidden" name="jurusan_id" maxlength="4" id="field_cr_jurusan_id" class="form-control" value="<?php echo isset($model['TRJURUSAN_ID']) ? $model['TRJURUSAN_ID'] : set_value('jurusan_id'); ?>" />
                    </div>
                    <div class="col-md-2" id="jurusansmksma" <?php echo (!empty($model['TRTINGKATPENDIDIKAN_ID']) && $model['TRTINGKATPENDIDIKAN_ID'] == '11') ? 'style="display: none"' : '';?>>
                        <a href="javascript:;" class="popuplarge btn btn-circle btn-icon-only yellow" title="Cari Jurusan" data-modal-title="Daftar Jurusan" data-url="<?php echo site_url("daftar_jurusan/listjurusan")?>"><i class="fa fa-graduation-cap"></i></a>
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
                    <label class="control-label col-md-3">Tahun Lulus</label>
                    <div class="col-md-8">
                        <input type="text" name="tahun_lulus" id="field_cr_tahun_lulus" class="form-control" value="<?php echo isset($model['THN_LULUS']) ? $model['THN_LULUS'] : set_value('tahun_lulus'); ?>" placeholder="Tahun Lulus" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">No Ijasah</label>
                    <div class="col-md-8">
                        <input type="text" name="no_ijasah" id="field_cr_no_ijasah" class="form-control" value="<?php echo isset($model['NO_STTB']) ? $model['NO_STTB'] : set_value('no_ijasah'); ?>" placeholder="No Ijasah" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Nama Pimpinan Lembaga</label>
                    <div class="col-md-8">
                        <input type="text" name="nama_pimpinan" id="field_cr_nama_pimpinan" class="form-control" value="<?php echo isset($model['NAMA_DIREKTUR']) ? $model['NAMA_DIREKTUR'] : set_value('nama_pimpinan'); ?>" placeholder="Nama Pimpinan Lembaga" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tgl Ijasah</label>
                    <div class="col-md-8">
                        <input type="text" name="tgl_ijasah" maxlength="50" id="field_cr_tgl_ijasah" class="form-control" value="<?php echo isset($model['TGL_IJAZAH2']) ? $model['TGL_IJAZAH2'] : set_value('tgl_ijasah'); ?>" placeholder="Tgl Ijasah" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Dokumen Ijasah</label>
                    <div class="col-md-8">
                        <input type="file" name="doc_ijasah" id="field_cr_doc_ijasah" class="form-control" value="<?php echo set_value('doc_ijasah'); ?>" placeholder="Dokumen Ijasah" />
                        <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                    </div>
                    <?php if (!empty($model['DOC_IJASAH']) && $model['DOC_IJASAH'] <> '') { ?>
                        <div class="col-md-1">
                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_pendidikan/view_dokumen?id='.$model['ID']) ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                <i class="fa fa-file-pdf-o"></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <!--/row-->
            </div>
            
            <?php if ($this->session->userdata('idgroup') != '' && in_array($this->session->userdata('idgroup'),['1','2'])) { ?>
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
    $("select#field_cr_negara").select2();
    $("select#field_cr_fakultas").select2();
    $("input#field_cr_tgl_ijasah").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>