<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Diklat Lain 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal", 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_diklat_lain/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_diklat_lain/ubah_proses?id=' . $model['TMPEGAWAI_ID'] . "&kode=" . $model['ID'])]); ?>
            <div class="form-body">
                
                <div class="form-group">
                    <label class="control-label col-md-3">Nama Diklat <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-7">
                        <input type="text" name="nama_diklat" maxlength="350" id="field_cr_nama_diklat" class="form-control" value="<?php echo isset($model['NAMA_DIKLAT']) ? $model['NAMA_DIKLAT'] : set_value('nama_diklat'); ?>" placeholder="Nama Diklat" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Negara</label>
                    <div class="col-md-3">
                        <select name="negara" id="field_cr_negara" class="form-control" style="width: 100%">
                            <?php if (isset($list_negara)): ?>
                                <?php foreach ($list_negara as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset ($model) && $val['ID'] == $model['TRNEGARA_ID'])
                                        $selec = 'selected=""';
                                    elseif (!isset ($model) && $val['ID'] == '071')
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Lama Diklat (JPL)</label>
                    <div class="col-md-2">
                        <input type="text" name="jpl" maxlength="5" id="field_cr_jpl" class="form-control" value="<?php echo isset($model['JPL']) ? $model['JPL'] : set_value('jpl'); ?>" placeholder="JPL" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Penyelenggara</label>
                    <div class="col-md-7">
                        <input type="text" name="penyelenggara" maxlength="255" id="field_cr_penyelenggara" class="form-control" value="<?php echo isset($model['PENYELENGGARA']) ? $model['PENYELENGGARA'] : set_value('penyelenggara'); ?>" placeholder="Penyelenggara" />
                    </div>
                </div>

                <h3 class="form-section text-center"> SERTIFIKAT / STTPP </h3>

                <div class="form-group">
                    <label class="control-label col-md-3">Nomor</label>
                    <div class="col-md-7">
                        <input type="text" name="no_sk" maxlength="100" id="field_cr_no_sk" class="form-control" value="<?php echo isset($model['NO_STTPP']) ? $model['NO_STTPP'] : set_value('no_sk'); ?>" placeholder="NO SK" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal</label>
                    <div class="col-md-7">
                        <input type="text" name="tgl_sk" maxlength="100" id="field_cr_tgl_sk" class="form-control" value="<?php echo isset($model['TGL_STTPP2']) ? $model['TGL_STTPP2'] : set_value('tgl_sk'); ?>" placeholder="TGL SK" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Pejabat</label>
                    <div class="col-md-7">
                        <input type="text" name="pejabat" maxlength="100" id="field_cr_pejabat" class="form-control" value="<?php echo isset($model['PJBT_STTPP']) ? $model['PJBT_STTPP'] : set_value('pejabat'); ?>" placeholder="Pejabat" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Dokumen</label>
                    <div class="col-md-7">
                        <input type="file" name="doc_sk" maxlength="100" id="field_doc_sk" class="form-control" />
                        <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                    </div>
                    <?php if (!empty($model['DOC_DIKLATLAIN']) && $model['DOC_DIKLATLAIN'] <> '') { ?>
                        <div class="col-md-1">
                            <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_diklat_lain/view_dokumen?id='.$model['ID']) ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
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
    $("select#field_cr_negara").select2();
    $("input#field_cr_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>