<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Jabatan 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_sisa_cuti/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_sisa_cuti/ubah_proses?id=' . $model['TMPEGAWAI_ID'] . "&kode=" . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Cuti <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <select name="cuti_id" id="field_cr_cuti" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_cuti)): ?>
                                <?php foreach ($list_cuti as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model['TMCUTI_ID']) && $val['ID'] == $model['TMCUTI_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Tahun <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <select name="tahun" id="field_cr_tahun" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                                <?php for ($t=date('Y');$t>=2020;$t--): ?>
                                    <?php
                                    $selec = '';
                                    if ($t == date('Y'))
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $t ?>"><?= $t ?></option>
                                <?php endfor ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Sisa Cuti</label>
                    <div class="col-md-4">
                        <input type="text" name="sisa_cuti" maxlength="3" id="field_cr_sisa_cuti" class="form-control" value="<?php echo isset($model['SISA_CUTI']) ? $model['SISA_CUTI'] : set_value('sisa_cuti'); ?>" placeholder="SISA CUTI" />
                    </div>
                </div>

                <!--/row-->
            </div>
            
            <?php if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') { ?>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
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
    $("select#field_cr_cuti").select2();
    $("select#field_cr_tahun").select2();
</script>