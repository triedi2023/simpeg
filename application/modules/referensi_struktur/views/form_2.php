<div class="col-md-12">
    <div class="portlet box yellow-gold">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Form <?=$title_form;?> Referensi <?=$title_utama?> Eselon 2
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <?php echo form_open("://", ["class" => "formcreateupdatestruktur2 horizontal-form", 'data-url' => isset($id) ? site_url('referensi_struktur/ubah_proses?id='.$id) : site_url('referensi_struktur/tambah_proses_eselon_2')]); ?>
            <div class="form-body">
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Kode Satker</label>
                            <input type="text" name="kd_satker" id="field_cr_kd_satker" maxlength="6" class="form-control" value="<?php echo isset($id) ? $model['KD_SATKER'] : set_value('kd_satker'); ?>" placeholder="Kode Satker" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="control-label">Nama Unit Kerja <span class="required" aria-required="true"> * </span></label>
                            <input type="text" name="nmunit" id="field_cr_nmunit" class="form-control" value="<?php echo isset($id) ? $model['NMUNIT'] : set_value('nmunit'); ?>" placeholder="Nama Unit Kerja" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Provinsi</label>
                            <select name="provinsi" id="field_cr_provinsi" style="width: 100%" class="form-control">
                                <option value="">- Provinsi -</option>
                                <?php if (isset($list_provinsi)): ?>
                                    <?php foreach ($list_provinsi as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model['TRPROVINSI_ID'])
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
                            <label class="control-label">Kabupaten</label>
                            <select name="kabupaten" id="field_cr_kabupaten" style="width: 100%" class="form-control">
                                <?php if (isset($list_kabupaten)): ?>
                                    <?php foreach ($list_kabupaten as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model['TRKABUPATEN_ID'])
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
                            <label class="control-label">Eselon</label>
                            <select name="eselon" id="field_cr_eselon" style="width: 100%" class="form-control">
                                <option value="">- Eselon -</option>
                                <?php if (isset($list_eselon)): ?>
                                    <?php foreach ($list_eselon as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model['TRESELON_ID'])
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
                            <label class="control-label">Jabatan</label>
                            <select name="jabatan" id="field_cr_jabatan" style="width: 100%" class="form-control">
                                <?php if (isset($list_jabatan)): ?>
                                    <?php foreach ($list_jabatan as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model['TRJABATAN_ID'])
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Alamat</label>
                            <textarea name="alamat" id="field_cr_alamat" class="form-control" maxlength="500" placeholder="Alamat"><?php echo isset($id) ? $model['ALAMAT'] : set_value('nmunit'); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Keterangan</label>
                            <textarea name="keterangan" id="field_cr_keterangan" class="form-control" maxlength="500" placeholder="Keterangan"><?php echo isset($id) ? $model['KETERANGAN'] : set_value('keterangan'); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Status <span class="required" aria-required="true"> * </span></label>
                            <select name="status" id="field_cr_status" class="form-control">
                                <?php foreach ($this->config->item('statusB') as $key => $val): ?>
                                    <?php
                                    $selected = "";
                                    if (isset($model) && $key == $model['STATUS'])
                                        $selected = 'selected=""';
                                    ?>
                                    <option <?=$selected?> value="<?=$key;?>"><?=$val;?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">ID BKN</label>
                            <input type="text" name="idbkn" id="field_cr_idbkn" class="form-control" value="<?php echo isset($id) ? $model['ID_BKN'] : set_value('idbkn'); ?>" placeholder="ID BKN" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Nama Unor BKN</label>
                            <input type="text" name="namaunor" id="field_cr_namaunor" class="form-control" value="<?php echo isset($id) ? $model['NAMA_UNOR_BKN'] : set_value('namaunor'); ?>" placeholder="Nama Unor BKN" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Eselon BKN</label>
                            <select name="eselonbkn" id="field_cr_eselonbkn" style="width: 100%" class="form-control">
                                <option value="">- Eselon -</option>
                                <?php if (isset($list_eselon_bkn)): ?>
                                    <?php foreach ($list_eselon_bkn as $val): ?>
                                        <?php
                                        $selected = "";
                                        if (isset($model) && $val['ID'] == $model['ESELON_ID_BKN'])
                                            $selected = 'selected=""';
                                        ?>
                                        <option <?= $selected ?> value="<?=$val['ID']?>"><?=$val['NAMA']?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Nama Jabatan BKN</label>
                            <input type="text" name="namajbtbkn" id="field_cr_namajbtbkn" class="form-control" value="<?php echo isset($id) ? $model['NAMA_JABATAN_BKN'] : set_value('namajbtbkn'); ?>" placeholder="Nama Jabatan BKN" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Kode Cepat BKN</label>
                            <input type="text" name="kodecptbkn" id="field_cr_kodecptbkn" class="form-control" value="<?php echo isset($id) ? $model['KODE_CEPAT_BKN'] : set_value('kodecptbkn'); ?>" placeholder="Kode Cepat BKN" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">ID Atasan BKN</label>
                            <input type="text" name="idatasanbkn" id="field_cr_idatasanbkn" class="form-control" value="<?php echo isset($id) ? $model['DIATASAN_ID_BKN'] : set_value('idatasanbkn'); ?>" placeholder="ID Atasan BKN" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Instansi ID BKN</label>
                            <input type="text" name="instansiidbkn" id="field_cr_instansiidbkn" class="form-control" value="<?php echo isset($id) ? $model['INSTANSI_ID_BKN'] : set_value('instansiidbkn'); ?>" placeholder="Instansi ID BKN" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Pemimpin Non PNS BKN</label>
                            <input type="text" name="nonpnsbkn" id="field_cr_nonpnsbkn" class="form-control" value="<?php echo isset($id) ? $model['PEMIMPIN_NON_PNS_BKN'] : set_value('nonpnsbkn'); ?>" placeholder="Pemimpin Non PNS BKN" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Pemimpin PNS BKN</label>
                            <input type="text" name=pnsbkn" id="field_crpnsbkn" class="form-control" value="<?php echo isset($id) ? $model['PEMIMPIN_PNS_BKN'] : set_value('pnsbkn'); ?>" placeholder="Pemimpin PNS BKN" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Jenis Unor BKN</label>
                            <input type="text" name="jenisunorbkn" id="field_cr_jenisunorbkn" class="form-control" value="<?php echo isset($id) ? $model['JENIS_UNOR_BKN'] : set_value('jenisunorbkn'); ?>" placeholder="Jenis Unor BKN" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Unor Induk BKN</label>
                            <input type="text" name="unorindukbkn" id="field_cr_unorindukbkn" class="form-control" value="<?php echo isset($id) ? $model['UNOR_INDUK_BKN'] : set_value('unorindukbkn'); ?>" placeholder="Unor Induk BKN" />
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
<script type="text/javascript">
    $("select#field_cr_provinsi").select2();
    $("select#field_cr_jabatan").select2();
    $("select#field_cr_eselon").select2();
    $("select#field_cr_kabupaten").select2();
</script>