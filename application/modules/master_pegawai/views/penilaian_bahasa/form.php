<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Penilaian Bahasa 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_penilaian_bahasa/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_penilaian_bahasa/ubah_proses?id=' . $model['TMPEGAWAI_ID'] . "&kode=" . $model['ID'])]); ?>
            <div class="form-body">
                
                <div class="form-group">
                    <label class="control-label col-md-3">Jenis Bahasa <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-7">
                        <select name="jenis_bahasa" id="field_cr_jenis_bahasa" class="form-control" style="width: 100%">
                            <?php if (isset($list_jenis_bahasa)): ?>
                                <?php foreach ($list_jenis_bahasa as $val): ?>
                                    <?php
                                    $selec = '';
                                    if ($val['ID'] == $model['TRJENISBAHASA_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Nama Bahasa <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-7">
                        <input type="text" name="nama_bahasa" maxlength="255" id="field_cr_nama_bahasa" class="form-control" value="<?php echo isset($model['NAMA_BAHASA']) ? $model['NAMA_BAHASA'] : set_value('nama_bahasa'); ?>" placeholder="Nama Bahasa" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Tujuan</label>
                    <div class="col-md-7">
                        <input type="text" name="tujuan" maxlength="100" id="field_cr_tujuan" class="form-control" value="<?php echo isset($model['TUJUAN']) ? $model['TUJUAN'] : set_value('tujuan'); ?>" placeholder="Tujuan" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Nilai</label>
                    <div class="col-md-7">
                        <input type="text" name="nilai" maxlength="3" id="field_cr_nilai" class="form-control" value="<?php echo isset($model['NILAI']) ? $model['NILAI'] : set_value('nilai'); ?>" placeholder="Nilai" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal Test <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-7">
                        <input type="text" name="tgl_test" maxlength="10" id="field_cr_tgl_test" class="form-control" value="<?php echo isset($model['TGL_TEST2']) ? $model['TGL_TEST2'] : set_value('tgl_test'); ?>" placeholder="Tanggal Test" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal Berlaku <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-7">
                        <input type="text" name="tgl_berlaku" maxlength="10" id="field_cr_tgl_berlaku" class="form-control" value="<?php echo isset($model['TGL_BERLAKU2']) ? $model['TGL_BERLAKU2'] : set_value('tgl_berlaku'); ?>" placeholder="Tanggal Berlaku" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Lembaga Penyelenggara</label>
                    <div class="col-md-7">
                        <input type="text" name="lembaga" maxlength="100" id="field_cr_lembaga" class="form-control" value="<?php echo isset($model['PENYELENGGARA']) ? $model['PENYELENGGARA'] : set_value('lembaga'); ?>" placeholder="Lembaga Penyelenggara" />
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
    $("select#field_cr_jenis_bahasa").select2();
    $("input#field_cr_tgl_test").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_berlaku").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>