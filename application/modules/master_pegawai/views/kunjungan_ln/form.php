<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Kunjungan Luar Negeri 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_kunjungan_ln/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_kunjungan_ln/ubah_proses?id=' . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Nama Negara <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="negara" id="field_cr_negara" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_negara)): ?>
                                <?php foreach ($list_negara as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRNEGARA_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tujuan <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="tujuan" maxlength="255" id="field_cr_tujuan" class="form-control" value="<?php echo isset($model['TUJUAN']) ? $model['TUJUAN'] : set_value('tujuan'); ?>" placeholder="Tujuan" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Pembiayaan</label>
                    <div class="col-md-8">
                        <select name="pembiayaan" id="field_cr_pembiayaan" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_pembiayaan)): ?>
                                <?php foreach ($list_pembiayaan as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRJENISPEMBIAYAAN_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Sponsor</label>
                    <div class="col-md-8">
                        <input type="text" name="sponsor" maxlength="100" id="field_cr_sponsor" class="form-control" value="<?php echo isset($model['SPONSOR']) ? $model['SPONSOR'] : set_value('sponsor'); ?>" placeholder="Sponsor" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal Kunjungan</label>
                    <div class="col-md-4">
                        <input type="text" name="tgl_kunjungan" maxlength="10" id="field_cr_tgl_kunjungan" class="form-control" value="<?php echo isset($model['TGL_KJGN2']) ? $model['TGL_KJGN2'] : set_value('tgl_kunjungan'); ?>" placeholder="Tgl Kunjungan" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Lama Kunjungan</label>
                    <div class="col-md-2">
                        <div class="input-group">
                            <input type="text" name="hari" maxlength="3" id="field_cr_hari" class="form-control" value="<?php echo isset($model['WKTU_HARI']) ? $model['WKTU_HARI'] : set_value('hari'); ?>" placeholder="Hari" />
                            <span class="input-group-addon">Hari</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <input type="text" name="bulan" maxlength="3" id="field_cr_bulan" class="form-control" value="<?php echo isset($model['WKTU_BLN']) ? $model['WKTU_BLN'] : set_value('bulan'); ?>" placeholder="Bulan" />
                            <span class="input-group-addon">Bulan</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <input type="text" name="tahun" maxlength="3" id="field_cr_tahun" class="form-control" value="<?php echo isset($model['WKTU_THN']) ? $model['WKTU_THN'] : set_value('tahun'); ?>" placeholder="Tahun" />
                            <span class="input-group-addon">Tahun</span>
                        </div>
                    </div>
                </div>

                <!--/row-->
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="button" class="btn default"><i class="fa fa-close"></i> Batal</button>
                        <button type="submit" class="btn btn-warning btn-circle blue-chambray"><i class="fa fa-check"> </i>Simpan</button>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script>
    $("select#field_cr_negara").select2();
    $("select#field_cr_pembiayaan").select2();
    $("input#field_cr_tgl_kunjungan").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>