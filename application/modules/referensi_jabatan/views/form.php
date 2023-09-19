<div class="col-md-12">
    <div class="portlet box yellow-gold">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Form <?= $title_form; ?> Referensi <?= $title_utama ?>
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => isset($id) ? site_url('referensi_jabatan/ubah_proses?id=' . $id) : site_url('referensi_jabatan/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Jabatan <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="jabatan" id="field_cr_jabatan" class="form-control" value="<?php echo isset($id) ? $model->JABATAN : set_value('jabatan'); ?>" placeholder="Jabatan" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Keterangan</label>
                            <input type="text" name="keterangan" id="field_cr_keterangan" class="form-control" value="<?php echo isset($id) ? $model->KETERANGAN : set_value('keterangan'); ?>" placeholder="Keterangan" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Kelompok Fungsional</label>
                            <select name="kelompok_fungsional" id="field_cr_kelompok_fungsional" style="width: 100%" class="form-control">
                                <option value="">- Pilih Kelompok Fungsional -</option>
                                <?php if (isset($list_kelompok_fungsional)): ?>
                                    <?php foreach ($list_kelompok_fungsional as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model->TRKELOMPOKFUNGSIONAL_ID)
                                            $selected = 'selected=""';
                                        ?>
                                        <option <?= $selected ?> value="<?=$val['ID']?>"><?=$val['NAMA']?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Tingkat Fungsional</label>
                            <select name="tingkat_fungsional" id="field_cr_tingkat_fungsional" style="width: 100%" class="form-control">
                                <option value="">- Pilih Tingkat Fungsional -</option>
                                <?php if (isset($list_tingkat_fungsional)): ?>
                                    <?php foreach ($list_tingkat_fungsional as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model->TRTINGKATFUNGSIONAL_ID)
                                            $selected = 'selected=""';
                                        ?>
                                        <option <?= $selected ?> value="<?=$val['ID']?>"><?=$val['NAMA']?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Golongan Terendah</label>
                            <select name="gol_terendah" id="field_cr_gol_terendah" style="width: 100%" class="form-control">
                                <option value="">- Pilih Golongan Terendah -</option>
                                <?php if (isset($list_golongan_pangkat)): ?>
                                    <?php foreach ($list_golongan_pangkat as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model->TRGOLONGAN_ID_R)
                                            $selected = 'selected=""';
                                        ?>
                                        <option <?= $selected ?> value="<?=$val['ID']?>"><?=$val['NAMA']?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Golongan Tertinggi</label>
                            <select name="gol_tertinggi" id="field_cr_gol_tertinggi" style="width: 100%" class="form-control">
                                <option value="">- Pilih Golongan Tertinggi -</option>
                                <?php if (isset($list_golongan_pangkat)): ?>
                                    <?php foreach ($list_golongan_pangkat as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model->TRGOLONGAN_ID_T)
                                            $selected = 'selected=""';
                                        ?>
                                        <option <?= $selected ?> value="<?=$val['ID']?>"><?=$val['NAMA']?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Eselon <span class="required" aria-required="true"> * </span></label>
                            <select name="eselon" id="field_cr_eselon" style="width: 100%" class="form-control">
                                <option value="">- Pilih Eselon -</option>
                                <?php if (isset($list_eselon)): ?>
                                    <?php foreach ($list_eselon as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model->TRESELON_ID)
                                            $selected = 'selected=""';
                                        ?>
                                        <option <?= $selected ?> value="<?=$val['ID']?>"><?=$val['NAMA']?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Usia Pensiun <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="usia_pensiun" id="field_cr_usia_pensiun" class="form-control" value="<?php echo isset($id) ? $model->USIA_PENSIUN : 58; ?>" placeholder="Usia Pensiun" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Tunjangan</label>
                            <input type="text" name="tunjangan" id="field_cr_tunjangan" class="form-control" value="<?php echo isset($id) ? $model->TUNJANGAN : set_value('tunjangan'); ?>" placeholder="Tunjangan" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">AK Minimal</label>
                            <input type="text" name="ak_minimal" id="field_cr_ak_minimal" class="form-control" value="<?php echo isset($id) ? $model->AK_MINIMAL : set_value('ak_minimal'); ?>" placeholder="AK Minimal" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Tingkat Pendidikan</label>
                            <select name="tingkat_pendidikan" id="field_cr_tingkat_pendidikan" style="width: 100%" class="form-control">
                                <option value="">- Pilih Tingkat Pendidikan -</option>
                                <?php if (isset($list_pendidikan)): ?>
                                    <?php foreach ($list_pendidikan as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model->TRTINGKATPENDIDIKAN_ID)
                                            $selected = 'selected=""';
                                        ?>
                                        <option <?= $selected ?> value="<?=$val['ID']?>"><?=$val['NAMA']?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Status <span class="required" aria-required="true"> * </span></label>
                            <select name="status" id="field_cr_status" style="width: 100%" class="form-control">
                                <?php foreach ($this->config->item('statusA') as $key => $val): ?>
                                    <?php
                                    $selected = "";
                                    if (isset($model) && $key == $model->STATUS)
                                        $selected = 'selected=""';
                                    ?>
                                    <option <?= $selected ?> value="<?= $key; ?>"><?= $val; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">ID JABFUNG Tertentu BKN</label>
                            <input type="text" name="idbknt" id="field_cr_idbknf" class="form-control" value="<?php echo isset($id) ? $model->ID_JABFUNGT_BKN : set_value('idbknt'); ?>" minlength="1" placeholder="ID JABFUNG Tertentu" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">ID JABFUNG Umum BKN</label>
                            <input type="text" name="idbknu" id="field_cr_idbknu" class="form-control" value="<?php echo isset($id) ? $model->ID_JABFUNGU_BKN : set_value('idbknu'); ?>" minlength="1" placeholder="ID JABFUNG Umun" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">ID Struktural BKN</label>
                            <input type="text" name="idstrukturalbkn" id="field_cr_idstrukturalbkn" class="form-control" value="<?php echo isset($id) ? $model->ID_STRUKTURAL_BKN : set_value('idstrukturalbkn'); ?>" minlength="1" placeholder="ID Struktural BKN" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Nama Jabatan</label>
                            <input type="text" name="namabkn" id="field_cr_namabkn" class="form-control" value="<?php echo isset($id) ? $model->NAMA_BKN : set_value('namabkn'); ?>" minlength="1" placeholder="Nama Jabatan" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Kode Cepat</label>
                            <input type="text" name="kdcepat" id="field_cr_kdcepat" class="form-control" value="<?php echo isset($id) ? $model->CEPAT_KODE : set_value('kdcepat'); ?>" minlength="1" placeholder="Kode Cepat" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">ID Kelompok Jabatan Fungsional Tertentu</label>
                            <input type="text" name="idkeljab" id="field_cr_idkeljab" class="form-control" value="<?php echo isset($id) ? $model->KEL_JABATAN_ID : set_value('idkeljab'); ?>" minlength="1" placeholder="ID Kelompok Jabatan Fungsional Tertentu" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Jenjang</label>
                            <input type="text" name="jenjang" id="field_cr_jenjang" class="form-control" value="<?php echo isset($id) ? $model->JENJANG : set_value('jenjang'); ?>" minlength="1" placeholder="Jenjang Fungsional Tertentu" />
                        </div>
                    </div>
                </div>
                <!--/row-->
            </div>
            <div class="form-actions">
                <div class="pull-left">
                    <button type="button" class="btn default btnbatalformcu"><i class="fa fa-close"></i> Batal</button>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-warning btn-circle"><i class="fa fa-check"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
            <!-- END FORM-->
        </div>
    </div>
</div>
<script>
    $("select#field_cr_kelompok_fungsional").select2();
    $("select#field_cr_tingkat_fungsional").select2();
    $("select#field_cr_gol_terendah").select2();
    $("select#field_cr_gol_tertinggi").select2();
    $("select#field_cr_eselon").select2();
    $("select#field_cr_tingkat_pendidikan").select2();
    <?php if (isset($id)) { ?>
        $("select#field_cr_tipe_pangkat").val(<?php echo $model->ID ?>).trigger('change');
    <?php } ?>
</script>