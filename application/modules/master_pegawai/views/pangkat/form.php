<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Pangkat 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-identify' => 'updatepangkatpegawai', 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_pangkat/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_pangkat/ubah_proses?id=' . $model['TMPEGAWAI_ID'] . "&kode=" . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-4">Golongan / Pangkat <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-6">
                        <select name="golpangkat" id="field_cr_golpangkat" class="form-control" style="width: 100%">
                            <?php if (isset($list_golongan_pangkat)): ?>
                                <?php foreach ($list_golongan_pangkat as $val): ?>
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
                    <label class="control-label col-md-4">TMT Golongan <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-6">
                        <input type="text" name="tmt_golongan" id="field_cr_tmt_golongan" class="form-control" value="<?php echo isset($model['TMT_GOL2']) ? $model['TMT_GOL2'] : set_value('tmt_golongan'); ?>" placeholder="TMT Golongan" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Jenis Pangkat</label>
                    <div class="col-md-6">
                        <select name="jeniskenaikanpangkat" id="field_cr_jeniskenaikanpangkat" class="form-control" style="width: 100%">
                            <?php if (isset($list_jenis_kenaikan_pangkat)): ?>
                                <?php foreach ($list_jenis_kenaikan_pangkat as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model['TRJENISKENAIKANPANGKAT_ID']) && $val['ID'] == $model['TRJENISKENAIKANPANGKAT_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-md-4">MK Tambahan</label>
                    <div class="col-md-2">
                        <div class="input-group">
                            <input type="text" name="mk_thn" id="field_c_mk_thn" class="form-control" placeholder="0" value="<?php echo isset($model['THN_GOL']) ? $model['THN_GOL'] : 0; ?>" />
                            <span class="input-group-addon">Thn.</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <input type="text" name="mk_bln" id="field_c_mk_bln" class="form-control" placeholder="0" value="<?php echo isset($model['BLN_GOL']) ? $model['BLN_GOL'] : 0; ?>" />
                            <span class="input-group-addon">Bln.</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Peraturan Yang Dijadikan Dasar</label>
                    <div class="col-md-6">
                        <input type="text" name="peraturan" maxlength="64" id="field_cr_peraturan" class="form-control" value="<?php echo isset($model['DASAR_PANGKAT']) ? $model['DASAR_PANGKAT'] : set_value('peraturan'); ?>" placeholder="Peraturan Yang Dijadikan Dasar" />
                    </div>
                </div>

                <h3 class="form-section"> &nbsp;Surat Keputusan </h3>

                <div class="form-group">
                    <label class="control-label col-md-4">No SK</label>
                    <div class="col-md-6">
                        <input type="text" name="no_sk" maxlength="100" id="field_cr_no_sk" class="form-control" value="<?php echo isset($model['NO_SK']) ? $model['NO_SK'] : set_value('no_sk'); ?>" placeholder="NO SK" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Tgl SK</label>
                    <div class="col-md-6">
                        <input type="text" name="tgl_sk" maxlength="100" id="field_cr_tgl_sk" class="form-control" value="<?php echo isset($model['TGL_SK2']) ? $model['TGL_SK2'] : set_value('tgl_sk'); ?>" placeholder="TGL SK" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Pejabat</label>
                    <div class="col-md-6">
                        <input type="text" name="pejabat" maxlength="100" id="field_cr_pejabat" class="form-control" value="<?php echo isset($model['PEJABAT_SK']) ? $model['PEJABAT_SK'] : set_value('pejabat'); ?>" placeholder="Pejabat" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">Dokumen SK Pangkat</label>
                    <div class="col-md-6">
                        <input type="file" name="doc_sk" maxlength="100" id="field_doc_sk" class="form-control" />
                        <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                    </div>
                    <?php if (!empty($model['DOC_SKPANGKAT']) && $model['DOC_SKPANGKAT'] <> '') { ?>
                        <div class="col-md-1">
                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_pangkat/view_dokumen?id='.$model['ID']); ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                <i class="fa fa-file-pdf-o"></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <!--/row-->
            </div>
            
            <?php if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') { ?>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
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
    $("select#field_cr_golpangkat").select2();
    $("select#field_cr_jeniskenaikanpangkat").select2();
    $("input#field_cr_tmt_golongan").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>