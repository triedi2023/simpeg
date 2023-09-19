<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data SKP 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_dp3/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_dp3/ubah_proses?id=' . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Tahun Penilaian <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="tahun_penilaian" maxlength="4" id="field_cr_tahun_penilaian" class="form-control" value="<?php echo isset($model['TAHUN_PENILAIAN']) ? $model['TAHUN_PENILAIAN'] : set_value('tahun_penilaian'); ?>" placeholder="Tahun Penilaian" />
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
                                    <option <?= $selec ?> value="<?= $val['TRJABATAN_ID'] ?>"><?= $val['N_JABATAN'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
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
                                    <a href="#tab_1_1_1" data-toggle="tab" aria-expanded="true"> Materi </a>
                                </li>
                                <li class="">
                                    <a href="#tab_1_1_2" data-toggle="tab" aria-expanded="true"> Pejabat Penilai </a>
                                </li>
                                <li class="">
                                    <a href="#tab_1_1_3" data-toggle="tab" aria-expanded=""> Atasan Pejabat Penilai </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_1_1">
                                    <div class="form-body form-horizontal">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Kesetiaan <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="kesetiaan" maxlength="7" id="field_cr_kesetiaan" class="form-control" value="<?php echo isset($model['N_KESETIAAN']) ? $model['N_KESETIAAN'] : 0; ?>" placeholder="Kesetiaan" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Prestasi Kerja <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="prestasi_kerja" maxlength="7" id="field_cr_prestasi_kerja" class="form-control" value="<?php echo isset($model['N_PRESTASI_KERJA']) ? $model['N_PRESTASI_KERJA'] : 0; ?>" placeholder="Prestasi Kerja" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Tanggung Jawab <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="tanggung_jawab" maxlength="7" id="field_cr_tanggung_jawab" class="form-control" value="<?php echo isset($model['N_TANGGUNG_JAWAB']) ? $model['N_TANGGUNG_JAWAB'] : 0; ?>" placeholder="Tanggung Jawab" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Ketaatan <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="ketaatan" maxlength="7" id="field_cr_ketaatan" class="form-control" value="<?php echo isset($model['N_KETAATAN']) ? $model['N_KETAATAN'] : 0; ?>" placeholder="Ketaatan" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Kejujuran <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="kejujuran" maxlength="7" id="field_cr_kejujuran" class="form-control" value="<?php echo isset($model['N_KEJUJURAN']) ? $model['N_KEJUJURAN'] : 0; ?>" placeholder="Kejujuran" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Kerja Sama <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="kerja_sama" maxlength="7" id="field_cr_kerja_sama" class="form-control" value="<?php echo isset($model['N_KERJASAMA']) ? $model['N_KERJASAMA'] : 0; ?>" placeholder="Kerja Sama" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Prakarsa <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="prakarsa" maxlength="7" id="field_cr_prakarsa" class="form-control" value="<?php echo isset($model['N_PRAKARSA']) ? $model['N_PRAKARSA'] : 0; ?>" placeholder="Prakarsa" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Kepemimpinan <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="kepemimpinan" maxlength="7" id="field_cr_kepemimpinan" class="form-control" value="<?php echo isset($model['N_KEPEMIMPINAN']) ? $model['N_KEPEMIMPINAN'] : 0; ?>" placeholder="Kepemimpinan" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_1_1_2">
                                    <div class="form-body form-horizontal">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">NIP</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="nip_pejabat" maxlength="18" id="field_cr_nip_pejabat" class="form-control" value="<?php echo isset($model['NIP_PJBT']) ? $model['NIP_PJBT'] : set_value('nip_pejabat'); ?>" placeholder="NIP Pejabat" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Nama</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="nama_pejabat" maxlength="150" id="field_cr_nama_pejabat" class="form-control" value="<?php echo isset($model['NAMA_PJBT']) ? $model['NAMA_PJBT'] : set_value('nama_pejabat'); ?>" placeholder="Nama Pejabat" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Jabatan</label>
                                                    <div class="col-md-7">
                                                        <input type="text" name="pejabat_sk" maxlength="300" id="field_cr_pejabat_sk" class="form-control" value="<?php echo isset($model['JABATAN_PJBT']) ? $model['JABATAN_PJBT'] : set_value('pejabat_sk'); ?>" placeholder="Jabatan Pejabat" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_1_1_3">
                                    <div class="form-body form-horizontal">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">NIP</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="nip_a_pejabat" maxlength="18" id="field_cr_nip_a_pejabat" class="form-control" value="<?php echo isset($model['NIP_A_PJBT']) ? $model['NIP_A_PJBT'] : set_value('nip_a_pejabat'); ?>" placeholder="NIP Pejabat" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Nama</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="nama_a_pejabat" maxlength="150" id="field_cr_nama_a_pejabat" class="form-control" value="<?php echo isset($model['NAMA_A_PJBT']) ? $model['NAMA_A_PJBT'] : set_value('nama_a_pejabat'); ?>" placeholder="Nama Pejabat" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Jabatan</label>
                                                    <div class="col-md-7">
                                                        <input type="text" name="pejabat_a_sk" maxlength="300" id="field_cr_pejabat_a_sk" class="form-control" value="<?php echo isset($model['JABATAN_A_PJBT']) ? $model['JABATAN_A_PJBT'] : set_value('pejabat_a_sk'); ?>" placeholder="Jabatan Pejabat" />
                                                    </div>
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
    $("select#field_cr_jabatan").select2();
    $("input#field_cr_tahun_penilaian").datepicker({autoclose: true, language: "id", format: 'yyyy', startView: "years", minViewMode: "years", endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("9999", {placeholder: 'YYYY'});
</script>