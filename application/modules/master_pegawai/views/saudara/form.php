<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Saudara 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_saudara/tambah_proses?id='.$id) : site_url('master_pegawai/master_pegawai_saudara/ubah_proses?id='.$id."&kode=".$model['ID'])]); ?>
            <div class="form-body">
                
                <div class="form-group">
                    <label class="control-label col-md-3">Nama Lengkap <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="nama_lengkap" maxlength="100" id="field_cr_nama_lengkap" class="form-control" value="<?php echo isset($model['NAMA']) ? $model['NAMA'] : set_value('nama_lengkap'); ?>" placeholder="Nama Lengkap" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Jenis Kelamin <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="jk" id="field_cr_jk" class="form-control" style="width: 100%">
                            <?php if (isset($list_jk)): ?>
                                <?php foreach ($list_jk as $val): ?>
                                    <?php
                                    $selec = '';
                                    if ($val['ID'] == $model['SEX'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal Lahir</label>
                    <div class="col-md-3">
                        <input type="text" name="tanggal_lahir" id="field_cr_tanggal_lahir" class="form-control" value="<?php echo isset($model['TGL_LAHIR2']) ? $model['TGL_LAHIR2'] : set_value('tanggal_lahir'); ?>" placeholder="Tanggal Lahir" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Pekerjaan</label>
                    <div class="col-md-8">
                        <input type="text" name="pekerjaan" maxlength="100" id="field_cr_pekerjaan" class="form-control" value="<?php echo isset($model['PEKERJAAN']) ? $model['PEKERJAAN'] : set_value('pekerjaan'); ?>" placeholder="Pekerjaan" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Keterangan</label>
                    <div class="col-md-8">
                        <textarea name="keterangan" id="field_cr_keterangan" class="form-control" placeholder="Keterangan"><?php echo isset($model['KETERANGAN']) ? $model['KETERANGAN'] : set_value('keterangan'); ?></textarea>
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
    $("select#field_cr_jk").select2();
    $("input#field_cr_tanggal_lahir").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>