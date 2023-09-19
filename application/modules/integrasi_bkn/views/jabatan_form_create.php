<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Tambah Data SKP Dari BKN</h4>
</div>
<?php echo form_open(site_url('integrasi_bkn/tambah_jabatan_proses?id=' . $id), ["class" => "formtambahbkn form-horizontal"]); ?>
<div class="modal-body">
    <div class="form">

        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-3">Eselon <span class="required" aria-required="true"> * </span> / TMT Eselon</label>
                <div class="col-md-4">
                    <select name="eselon_id" id="field_cr_eselon_id" class="form-control" style="width: 100%">
                        <option value="">- Pilih -</option>
                        <?php if (isset($list_eselon)): ?>
                            <?php foreach ($list_eselon as $val): ?>
                                <?php
                                $selec = '';
                                if (isset($model['TRESELON_ID']) && $val['ID'] == $model['TRESELON_ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="tmt_eselon" id="field_cr_tmt_eselon" class="form-control" value="<?php echo isset($model['TMT_ESELON2']) ? $model['TMT_ESELON2'] : set_value('tmt_eselon'); ?>" placeholder="TMT Eselon" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Nama Jabatan (Ref.)</label>
                <div class="col-md-6">
                    <select name="jabatan_id" id="field_cr_jabatan_id" class="form-control" style="width: 100%">
                        <option value="">- Pilih -</option>
                        <?php if (isset($list_jabatan)): ?>
                            <?php foreach ($list_jabatan as $val): ?>
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
                <label class="control-label col-md-3">Nama Jabatan (Tanpa Ref.)</label>
                <div class="col-md-6">
                    <input type="text" name="nama_jabatan" id="field_cr_nama_jabatan" class="form-control" value="<?php echo isset($model['K_JABATAN_NOKODE']) ? $model['K_JABATAN_NOKODE'] : set_value('nama_jabatan'); ?>" placeholder="Nama Jabatan (Tanpa Ref.)" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Keterangan Jabatan</label>
                <div class="col-md-6">
                    <select name="keteranganjabatan_id" id="field_cr_keteranganjabatan_id" class="form-control" style="width: 100%">
                        <option value="">- Pilih -</option>
                        <?php if (isset($list_keterangan_jabatan)): ?>
                            <?php foreach ($list_keterangan_jabatan as $val): ?>
                                <?php
                                $selec = '';
                                if (isset($model['TRKETERANGANJABATAN_ID']) && $val['ID'] == $model['TRKETERANGANJABATAN_ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">TMT Jabatan <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-3">
                    <input type="text" name="tmt_jabatan_awal" id="field_cr_tmt_jabatan_awal" maxlength="10" class="form-control" placeholder="TMT Jabatan Awal" value="<?php echo isset($bkn['tmtJabatan']) ? str_replace("-","/",$bkn['tmtJabatan']) : set_value('tmt_jabatan_awal'); ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Sampai Dengan</label>
                <div class="col-md-3">
                    <input type="text" name="tmt_jabatan_akhir" id="field_cr_tmt_jabatan_akhir" maxlength="10" class="form-control" placeholder="TMT Jabatan Akhir" value="<?php echo isset($model['TGL_AKHIR2']) ? $model['TGL_AKHIR2'] : set_value('tmt_jabatan_akhir'); ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Pangkat / Golongan</label>
                <div class="col-md-4">
                    <select name="pangkat_id" id="field_cr_pangkat_id" class="form-control" style="width: 100%">
                        <option value="">- Pilih -</option>
                        <?php if (isset($list_golongan)): ?>
                            <?php foreach ($list_golongan as $val): ?>
                                <?php
                                $selec = '';
                                if (isset($model['TRGOLONGAN_ID']) && $val['ID'] == $model['TRGOLONGAN_ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Jumlah Angkat Kredit</label>
                <div class="col-md-4">
                    <input type="text" name="jml_ak" maxlength="10" id="field_cr_jml_ak" class="form-control" value="<?php echo isset($model['A_KREDIT']) ? $model['A_KREDIT'] : set_value('jml_ak'); ?>" placeholder="Jumlah Angka Kredit" />
                </div>
            </div>

            <div class="form-group">&nbsp;</div>

            <div class="tabbable-custom nav-justified">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active">
                        <a href="#tab_1_1_1" data-toggle="tab" aria-expanded="true"> Unit Kerja </a>
                    </li>
                    <li class="">
                        <a href="#tab_1_1_2" data-toggle="tab" aria-expanded="false"> Surat Keputusan </a>
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
                                                <?php
                                                if (isset($model['TRLOKASI_ID']) && !empty($model['TRLOKASI_ID'])) {
                                                    echo $list_lokasi;
                                                }
                                                ?>
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
                                            <input type="text" name="unitkerjanokoderef" id="field_c_unitkerjanokoderef" class="form-control" value="<?php echo isset($unortanpakoderef) ? $unortanpakoderef : set_value('unitkerjanokoderef'); ?>" placeholder="Unit Kerja (Tanpa Kode Referensi)" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_1_1_2">
                        <div class="form-body form-horizontal">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nomor</label>
                                        <div class="col-md-8">
                                            <input type="text" name="no_sk" maxlength="100" id="field_cr_no_sk" class="form-control" value="<?php echo isset($bkn['nomorSk']) ? $bkn['nomorSk'] : set_value('no_sk'); ?>" placeholder="No SK" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Tanggal</label>
                                        <div class="col-md-8">
                                            <input type="text" name="tgl_sk" maxlength="10" id="field_cr_tgl_sk" class="form-control" value="<?php echo isset($bkn['tanggalSk']) ? $bkn['tanggalSk'] : set_value('tgl_sk'); ?>" placeholder="Tgl SK" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Pejabat</label>
                                        <div class="col-md-8">
                                            <input type="text" name="pejabat_sk" maxlength="100" id="field_c_pejabat_sk" class="form-control" value="<?php echo isset($model['PEJABAT_SK']) ? $model['PEJABAT_SK'] : set_value('pejabat_sk'); ?>" placeholder="Pejabat SK" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Keterangan</label>
                                        <div class="col-md-8">
                                            <input type="text" name="keterangan" maxlength="400" id="field_cr_keterangan" class="form-control" value="<?php echo isset($model['KETERANGAN']) ? $model['KETERANGAN'] : set_value('keterangan'); ?>" placeholder="Keterangan" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Tanggal Pelantikan</label>
                                        <div class="col-md-8">
                                            <input type="text" name="tgl_pelantikan" maxlength="10" id="field_cr_tgl_pelantikan" class="form-control" value="<?php echo isset($model['TGL_LANTIK2']) ? $model['TGL_LANTIK2'] : set_value('tgl_pelantikan'); ?>" placeholder="Tanggal Pelantikan" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Lokasi KPPN</label>
                                        <div class="col-md-8">
                                            <input type="text" name="lokasi_kppn" maxlength="64" id="field_cr_lokasi_kppn" class="form-control" value="<?php echo isset($model['KPPN']) ? $model['KPPN'] : set_value('lokasi_kppn'); ?>" placeholder="Lokasi KPPN" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Lokasi Taspen</label>
                                        <div class="col-md-8">
                                            <input type="text" name="lokasi_taspen" maxlength="64" id="field_cr_lokasi_taspen" class="form-control" value="<?php echo isset($model['LOK_TASPEN']) ? $model['LOK_TASPEN'] : set_value('lokasi_taspen'); ?>" placeholder="Lokasi Taspen" />
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
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-6 text-left">
            <button type="button" data-dismiss="modal" class="btn default btnbatalformcudetailpegawai text-left"><i class="fa fa-close"></i> Batal</button>
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-warning btn-circle blue-chambray"><i class="fa fa-check"></i> Simpan</button>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<script>
    $("select#field_cr_eselon_id").select2();
    $("select#field_cr_jabatan_id").select2();
    $("select#field_cr_pangkat_id").select2();
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
    $("input#field_cr_tmt_eselon").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tmt_golongan").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tmt_jabatan_awal").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tmt_jabatan_akhir").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_pelantikan").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>