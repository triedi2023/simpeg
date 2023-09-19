<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Penilaian Kepangkatan 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_penilaian_kepangkatan/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_penilaian_kepangkatan/ubah_proses?id=' . $model['TMPEGAWAI_ID'] . "&kode=" . $model['ID'])]); ?>
            <div class="form-body">
                
                <div class="form-group">
                    <label class="control-label col-md-3">Jenis Test <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-7">
                        <select name="jenis_kepangkatan" id="field_cr_jenis_kepangkatan" class="form-control" style="width: 100%">
                            <?php if (isset($list_jenis_data_kepangkatan)): ?>
                                <?php foreach ($list_jenis_data_kepangkatan as $val): ?>
                                    <?php
                                    $selec = '';
                                    if ($val['ID'] == $model['TRJENISDATA_KEPANGKATAN_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal Test <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-7">
                        <input type="text" name="tgl_test" maxlength="10" id="field_cr_tgl_test" class="form-control" value="<?php echo isset($model['TGL_TEST2']) ? $model['TGL_TEST2'] : set_value('tgl_test'); ?>" placeholder="Tanggal Test" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Tempat Test <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-7">
                        <input type="text" name="tempat_test" maxlength="100" id="field_cr_tempat_test" class="form-control" value="<?php echo isset($model['TEMPAT_TEST']) ? $model['TEMPAT_TEST'] : set_value('tempat_test'); ?>" placeholder="Tempat Test" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Hasil Test <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-7">
                        <input type="text" name="hasil_test" maxlength="3" id="field_cr_hasil_test" class="form-control" value="<?php echo isset($model['HASIL_TEST']) ? $model['HASIL_TEST'] : set_value('hasil_test'); ?>" placeholder="Hasil Test" />
                    </div>
                </div>
                
                <h3 class="text-center">Surat Keterangan Kelulusan</h3>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Nomor</label>
                    <div class="col-md-7">
                        <input type="text" name="nomor" maxlength="100" id="field_cr_nomor" class="form-control" value="<?php echo isset($model['NO_SKKLSN']) ? $model['NO_SKKLSN'] : set_value('nomor'); ?>" placeholder="Nomor" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal</label>
                    <div class="col-md-7">
                        <input type="text" name="tgl_sk" maxlength="10" id="field_cr_tgl_sk" class="form-control" value="<?php echo isset($model['TGL_SKKLSN2']) ? $model['TGL_SKKLSN2'] : set_value('tgl_sk'); ?>" placeholder="Tanggal" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Pejabat</label>
                    <div class="col-md-7">
                        <input type="text" name="pejabat" maxlength="100" id="field_cr_pejabat" class="form-control" value="<?php echo isset($model['PEJABAT_SKKLSN']) ? $model['PEJABAT_SKKLSN'] : set_value('pejabat'); ?>" placeholder="Pejabat" />
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
    $("select#field_cr_jenis_kepangkatan").select2();
    $("input#field_cr_tgl_test").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>