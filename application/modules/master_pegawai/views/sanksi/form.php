<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Sanksi 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_sanksi/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_sanksi/ubah_proses?id=' . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Tingkat Hukuman <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="tingkat_hukuman" id="field_cr_tingkat_hukuman" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_tkt_hukdis)): ?>
                                <?php foreach ($list_tkt_hukdis as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRTKTHUKUMANDISIPLIN_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Jenis Hukuman <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="jenis_hukuman" id="field_cr_jenis_hukuman" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_jenis_hukdis)): ?>
                                <?php foreach ($list_jenis_hukdis as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRJENISHUKUMANDISIPLIN_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Alasan Hukuman</label>
                    <div class="col-md-8">
                        <textarea name="alasan_hukuman" maxlength="3000" id="field_cr_alasan_hukuman" class="form-control" placeholder="Alasan Hukuman"><?php echo isset($model['ALASAN_HKMN']) ? $model['ALASAN_HKMN'] : set_value('alasan_hukuman'); ?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">TMT Hukuman</label>
                    <div class="col-md-8">
                        <input type="text" name="tmt_hukuman" maxlength="10" id="field_cr_tmt_hukuman" class="form-control" value="<?php echo isset($model['TMT_HKMN2']) ? $model['TMT_HKMN2'] : set_value('tmt_hukuman'); ?>" placeholder="Tmt Hukuman" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Akhir Hukuman</label>
                    <div class="col-md-8">
                        <input type="text" name="akhir_hukuman" maxlength="10" id="field_cr_akhir_hukuman" class="form-control" value="<?php echo isset($model['AKHIR_HKMN2']) ? $model['AKHIR_HKMN2'] : set_value('akhir_hukuman'); ?>" placeholder="Akhir Hukuman" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-4 bold">SURAT KEPUTUSAN</label>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">No SK</label>
                    <div class="col-md-6">
                        <input type="text" name="no_sk" maxlength="100" id="field_cr_no_sk" class="form-control" value="<?php echo isset($model['NO_SK']) ? $model['NO_SK'] : set_value('no_sk'); ?>" placeholder="NO SK" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tgl SK</label>
                    <div class="col-md-6">
                        <input type="text" name="tgl_sk" maxlength="100" id="field_cr_tgl_sk" class="form-control" value="<?php echo isset($model['TGL_SK2']) ? $model['TGL_SK2'] : set_value('tgl_sk'); ?>" placeholder="TGL SK" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Pejabat</label>
                    <div class="col-md-6">
                        <input type="text" name="pejabat" maxlength="100" id="field_cr_pejabat" class="form-control" value="<?php echo isset($model['PJBT_SK']) ? $model['PJBT_SK'] : set_value('pejabat'); ?>" placeholder="Pejabat" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Dokumen</label>
                    <div class="col-md-8">
                        <input type="file" name="doc_sk" id="field_c_doc_sk" class="form-control" value="" placeholder="Dokumen" />
                        <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                    </div>
                    <?php if (!empty($model['DOC_SANKSI']) && $model['DOC_SANKSI'] <> '') { ?>
                        <div class="col-md-1">
                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_sanksi/view_dokumen?id='.$model['ID']) ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                <i class="fa fa-file-pdf-o"></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="tabbable-custom nav-justified">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active">
                                    <a href="#tab_1_1_1" data-toggle="tab" aria-expanded="true"> Unit Kerja </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_1_1">
                                    <div class="form-body form-horizontal">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Lokasi Kerja</label>
                                                    <div class="col-md-7">
                                                        <select name="trlokasi_id" id="field_cr_trlokasi_id" data-edit="<?php echo isset($model['KDU1']) ? 1 : '' ?>" class="form-control struktur_lokasi" style="width: 100%">
                                                            <option value="">- Pilih Lokasi Kerja -</option>
                                                            <?php if (isset($model['TRLOKASI_ID']) && !empty($model['TRLOKASI_ID'])) { echo $list_lokasi; } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Unit Jabatan Pimpinan Tinggi Madya</label>
                                                    <div class="col-md-7">
                                                        <select name="kdu1" id="field_cr_kdu1" class="form-control struktur_kdu1" style="width: 100%">
                                                            <option value="">- Pilih Jabatan Pimpinan Tinggi Madya -</option>
                                                            <?php if (isset($list_kdu1)): ?>
                                                                <?php foreach ($list_kdu1 as $val): ?>
                                                                    <?php
                                                                    $selec = '';
                                                                    if (isset($model['KDU1']) && $val['ID'] == $model['KDU1'])
                                                                        $selec = 'selected=""';
                                                                    ?>
                                                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Unit Jabatan Pimpinan Tinggi Pratama</label>
                                                    <div class="col-md-7">
                                                        <select name="kdu2" id="field_cr_kdu2" class="form-control struktur_kdu2" style="width: 100%">
                                                            <option value="">- Pilih Jabatan Pimpinan Tinggi Pratama -</option>
                                                            <?php if (isset($list_kdu2)): ?>
                                                                <?php foreach ($list_kdu2 as $val): ?>
                                                                    <?php
                                                                    $selec = '';
                                                                    if (isset($model['KDU2']) && $val['ID'] == $model['KDU2'])
                                                                        $selec = 'selected=""';
                                                                    ?>
                                                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Unit Jabatan Administrator</label>
                                                    <div class="col-md-7">
                                                        <select name="kdu3" id="field_cr_kdu3" class="form-control struktur_kdu3" style="width: 100%">
                                                            <option value="">- Pilih Jabatan Administrator -</option>
                                                            <?php if (isset($list_kdu3)): ?>
                                                                <?php foreach ($list_kdu3 as $val): ?>
                                                                    <?php
                                                                    $selec = '';
                                                                    if (isset($model['KDU3']) && $val['ID'] == $model['KDU3'])
                                                                        $selec = 'selected=""';
                                                                    ?>
                                                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Unit Pengawas</label>
                                                    <div class="col-md-7">
                                                        <select name="kdu4" id="field_cr_kdu4" class="form-control struktur_kdu4" style="width: 100%">
                                                            <option value="">- Pilih Pengawas -</option>
                                                            <?php if (isset($list_kdu4)): ?>
                                                                <?php foreach ($list_kdu4 as $val): ?>
                                                                    <?php
                                                                    $selec = '';
                                                                    if (isset($model['KDU4']) && $val['ID'] == $model['KDU4'])
                                                                        $selec = 'selected=""';
                                                                    ?>
                                                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Unit Pelaksana (Eselon V)</label>
                                                    <div class="col-md-7">
                                                        <select name="kdu5" id="field_cr_kdu5" class="form-control struktur_kdu5" style="width: 100%">
                                                            <option value="">- Pilih Pelaksana (Eselon V) -</option>
                                                            <?php if (isset($list_kdu5)): ?>
                                                                <?php foreach ($list_kdu5 as $val): ?>
                                                                    <?php
                                                                    $selec = '';
                                                                    if (isset($model['KDU5']) && $val['ID'] == $model['KDU5'])
                                                                        $selec = 'selected=""';
                                                                    ?>
                                                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Unit Kerja (Tanpa Kode Referensi)</label>
                                                    <div class="col-md-7">
                                                        <input type="text" name="unitkerjanokoderef" id="field_c_unitkerjanokoderef" class="form-control" value="<?php echo isset($data_pegawai['UNITKERJA_NOKODEREF']) ? $data_pegawai['UNITKERJA_NOKODEREF'] : set_value('unitkerjanokoderef'); ?>" placeholder="Unit Kerja (Tanpa Kode Referensi)" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/row-->
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
    $("select#field_cr_tingkat_hukuman").select2();
    $("select#field_cr_jenis_hukuman").select2();
    $("input#field_cr_tmt_hukuman").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_akhir_hukuman").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    <?php if (isset($model['TRLOKASI_ID'])) { ?>
        $("select#field_cr_trlokasi_id").select2({allowClear: true});
    <?php } else { ?>
        $("select#field_cr_trlokasi_id").select2({
            data: <?php echo $list_lokasi ?>,
            allowClear: true
        });
    <?php } ?>
    $("select#field_cr_kdu1").select2({allowClear: true});
    $("select#field_cr_kdu2").select2({allowClear: true});
    $("select#field_cr_kdu3").select2({allowClear: true});
    $("select#field_cr_kdu4").select2({allowClear: true});
    $("select#field_cr_kdu5").select2({allowClear: true});
</script>