<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Penilaian PAT 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_penilaian_pat/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_penilaian_pat/ubah_proses?id=' . $model['TMPEGAWAI_ID'] . "&kode=" . $model['ID'])]); ?>
            <div class="form-body">
                
                <div class="form-group">
                    <label class="control-label col-md-3">Jenis Assesstment Test <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-7">
                        <select name="jenis_ass" id="field_cr_jenis_ass" class="form-control" style="width: 100%">
                            <?php if (isset($list_jenis_assessment_test)): ?>
                                <?php foreach ($list_jenis_assessment_test as $val): ?>
                                    <?php
                                    $selec = '';
                                    if ($val['ID'] == $model['TRJENISASSESSMENTTEST_ID'])
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
                    <div class="col-md-7">
                        <select name="tujuan" id="field_cr_tujuan" class="form-control" style="width: 100%">
                            <?php if (isset($list_tujuan_assessment_test)): ?>
                                <?php foreach ($list_tujuan_assessment_test as $val): ?>
                                    <?php
                                    $selec = '';
                                    if ($val['ID'] == $model['TRTUJUANASSESSMENTTEST_ID'])
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
                    <label class="control-label col-md-3">Rekomendasi <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-3">
                        <select name="rekomendasi" id="field_cr_rekomendasi" class="form-control" style="width: 100%">
                            <?php if (isset($list_rekomendasi)): ?>
                                <?php foreach ($list_rekomendasi as $val): ?>
                                    <?php
                                    $selec = '';
                                    if ($val['ID'] == $model['TRREKOMENDASI_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
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
    $("select#field_cr_jenis_ass").select2();
    $("select#field_cr_tujuan").select2();
    $("select#field_cr_rekomendasi").select2();
    $("input#field_cr_tgl_test").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>