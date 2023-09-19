<div class="col-md-12">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i><?php echo $title_form; ?> Data Cuti 
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <?php echo form_open("://", ["class" => "formdetailpegawaiwithlist form-horizontal",'name'=>'formdetailpegawaiwithlist', 'data-url' => !isset($model['ID']) ? site_url('master_pegawai/master_pegawai_cuti/tambah_proses?id=' . $id) : site_url('master_pegawai/master_pegawai_cuti/ubah_proses?id=' . $model['ID'])]); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3">Nama Cuti <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="jenis_cuti" id="field_cr_jenis_cuti" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_cuti)): ?>
                                <?php foreach ($list_cuti as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $val['ID'] == $model['TRCUTI_ID'])
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tgl Mulai <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="tgl_mulai_cuti" maxlength="10" id="field_cr_tgl_mulai_cuti" class="form-control" value="<?php echo isset($model['TGL_MULAI2']) ? $model['TGL_MULAI2'] : set_value('tgl_mulai_cuti'); ?>" placeholder="Tgl Mulai" />
                        <span class="form-text text-danger msglarangancuti" style="display: none"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Tgl Selesai <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <input type="text" name="tgl_selesai_cuti" maxlength="10" id="field_cr_tgl_selesai_cuti" class="form-control" value="<?php echo isset($model['TGL_AKHIR2']) ? $model['TGL_AKHIR2'] : set_value('tgl_selesai_cuti'); ?>" placeholder="Tgl Selesai" />
                        <span class="form-text text-danger msglarangancuti" style="display: none"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Lama Cuti</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" name="lama_cuti" maxlength="4" id="field_cr_lama_cuti" class="form-control" value="<?php echo isset($model['LAMA']) ? $model['LAMA'] : set_value('lama_cuti'); ?>" placeholder="Lama Cuti" />
                            <span class="input-group-addon">Hari</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tgl Pengajuan</label>
                    <div class="col-md-8">
                        <input type="text" name="tgl_pengajuan" maxlength="10" id="field_cr_tgl_pengajuan" class="form-control" value="<?php echo isset($model['TGL_PENGAJUAN2']) ? $model['TGL_PENGAJUAN2'] : set_value('tgl_pengajuan'); ?>" placeholder="Tgl Pengajuan" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Atasan Langsung</label>
                    <div class="col-md-4">
                        <input type="text" name="nip_atasan" readonly="" maxlength="18" id="field_cr_nip_atasan" class="form-control" value="<?php echo isset($model['NIP_ATASAN']) ? $model['NIP_ATASAN'] : set_value('nip_atasan'); ?>" placeholder="Atasan Langsung" />
                    </div>
                    <div class="col-md-1" style="text-align: left">
                        <a href="javascript:;" class="popuplarge btn btn-circle btn-icon-only yellow" title="Cari Pegawai" data-statement="popuppilihatasanpegawaicuti" data-modal-title="Daftar Pegawai" data-url="<?php echo site_url("daftar_pegawai/listpegawai") ?>"><i class="fa fa-group"></i></a>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Nama Atasan Langsung</label>
                    <div class="col-md-8">
                        <input type="text" name="nama_atasan" readonly="" maxlength="100" id="field_cr_nama_atasan" class="form-control" value="<?php echo isset($model['NAMA_ATASAN']) ? $model['NAMA_ATASAN'] : set_value('nama_atasan'); ?>" placeholder="Nama Atasan Langsung" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Jabatan Atasan Langsung</label>
                    <div class="col-md-8">
                        <input type="text" name="jabatan_atasan" maxlength="1000" readonly="" id="field_cr_jabatan_atasan" class="form-control" value="<?php echo isset($model['JABATAN_ATASAN']) ? $model['JABATAN_ATASAN'] : set_value('jabatan_atasan'); ?>" placeholder="Jabatan Atasan Langsung" />
                        <input type="hidden" name="idgolpangkat_atasan" maxlength="3" readonly="" id="field_cr_idgolpangkat_atasan" class="form-control" value="<?php echo isset($model['TRGOLONGANID_ATASAN']) ? $model['TRGOLONGANID_ATASAN'] : set_value('idgolpangkat_atasan'); ?>" placeholder="ID Golongan Atasan Langsung" />
                        <input type="hidden" name="golpangkat_atasan" maxlength="3" readonly="" id="field_cr_golpangkat_atasan" class="form-control" value="<?php echo isset($model['GOL_PANGKAT_ATASAN']) ? $model['GOL_PANGKAT_ATASAN'] : set_value('golpangkat_atasan'); ?>" placeholder="Golongan Atasan Langsung" />
                        <input type="hidden" name="eselon_atasan" maxlength="3" readonly="" id="field_cr_eselon_atasan" class="form-control" value="<?php echo isset($model['TRESELONID_ATASAN']) ? $model['TRESELONID_ATASAN'] : set_value('eselon_atasan'); ?>" placeholder="Eselon Atasan Langsung" />
                        <input type="hidden" name="id_jabatan_atasan" maxlength="4" readonly="" id="field_cr_id_jabatan_atasan" class="form-control" value="<?php echo isset($model['TRJABATANID_ATASAN']) ? $model['TRJABATANID_ATASAN'] : set_value('id_jabatan_atasan'); ?>" placeholder="ID Jabatan Atasan Langsung" />
                        <input type="hidden" name="trlokasiid_atasan" maxlength="4" readonly="" id="field_cr_trlokasiid_atasan" class="form-control" value="<?php echo isset($model['TRLOKASIID_ATASAN']) ? $model['TRLOKASIID_ATASAN'] : set_value('trlokasiid_atasan'); ?>" placeholder="Lokasi Atasan Langsung" />
                        <input type="hidden" name="kdu1_atasan" maxlength="2" readonly="" id="field_cr_kdu1_atasan" class="form-control" value="<?php echo isset($model['KDU1_ATASAN']) ? $model['KDU1_ATASAN'] : set_value('kdu1_atasan'); ?>" placeholder="kdu1 Atasan Langsung" />
                        <input type="hidden" name="kdu2_atasan" maxlength="2" readonly="" id="field_cr_kdu2_atasan" class="form-control" value="<?php echo isset($model['KDU2_ATASAN']) ? $model['KDU2_ATASAN'] : set_value('kdu2_atasan'); ?>" placeholder="kdu2 Atasan Langsung" />
                        <input type="hidden" name="kdu3_atasan" maxlength="3" readonly="" id="field_cr_kdu3_atasan" class="form-control" value="<?php echo isset($model['KDU3_ATASAN']) ? $model['KDU3_ATASAN'] : set_value('kdu3_atasan'); ?>" placeholder="kdu3 Atasan Langsung" />
                        <input type="hidden" name="kdu4_atasan" maxlength="3" readonly="" id="field_cr_kdu4_atasan" class="form-control" value="<?php echo isset($model['KDU4_ATASAN']) ? $model['KDU4_ATASAN'] : set_value('kdu4_atasan'); ?>" placeholder="kdu4 Atasan Langsung" />
                        <input type="hidden" name="kdu5_atasan" maxlength="2" readonly="" id="field_cr_kdu5_atasan" class="form-control" value="<?php echo isset($model['KDU5_ATASAN']) ? $model['KDU5_ATASAN'] : set_value('kdu5_atasan'); ?>" placeholder="kdu5 Atasan Langsung" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Atasan Penilai</label>
                    <div class="col-md-4">
                        <input type="text" name="nip_penilai_atasan" readonly="" maxlength="18" id="field_cr_nip_penilai_atasan" class="form-control" value="<?php echo isset($model['NIP_PEJABAT']) ? $model['NIP_PEJABAT'] : set_value('nip_penilai_atasan'); ?>" placeholder="Atasan Penilai" />
                    </div>
                    <div class="col-md-1" style="text-align: left">
                        <a href="javascript:;" class="popuplarge btn btn-circle btn-icon-only yellow" title="Cari Pegawai" data-statement="popuppilihatasanpenilaicuti" data-modal-title="Daftar Pegawai" data-url="<?php echo site_url("daftar_pegawai/listpegawai") ?>"><i class="fa fa-group"></i></a>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Nama Atasan Penilai</label>
                    <div class="col-md-8">
                        <input type="text" name="nama_penilai_atasan" readonly="" maxlength="100" id="field_cr_nama_penilai_atasan" class="form-control" value="<?php echo isset($model['NAMA_PEJABAT']) ? $model['NAMA_PEJABAT'] : set_value('nama_penilai_atasan'); ?>" placeholder="Nama Atasan Penilai" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Jabatan Atasan Penilai</label>
                    <div class="col-md-8">
                        <input type="text" name="jabatan_penilai_atasan" maxlength="1000" readonly="" id="field_cr_jabatan_penilai_atasan" class="form-control" value="<?php echo isset($model['JABATAN_PEJABAT']) ? $model['JABATAN_PEJABAT'] : set_value('jabatan_penilai_atasan'); ?>" placeholder="Jabatan Atasan Langsung" />
                        <input type="hidden" name="idgolpangkat_penilai_atasan" maxlength="3" readonly="" id="field_cr_idgolpangkat_penilai_atasan" class="form-control" value="<?php echo isset($model['TRGOLONGANID_PEJABAT']) ? $model['TRGOLONGANID_PEJABAT'] : set_value('idgolpangkat_penilai_atasan'); ?>" placeholder="ID Golongan Atasan Langsung" />
                        <input type="hidden" name="golpangkat_penilai_atasan" maxlength="3" readonly="" id="field_cr_golpangkat_penilai_atasan" class="form-control" value="<?php echo isset($model['GOL_PANGKAT_PEJABAT']) ? $model['GOL_PANGKAT_PEJABAT'] : set_value('golpangkat_penilai_atasan'); ?>" placeholder="Golongan Atasan Langsung" />
                        <input type="hidden" name="eselon_penilai_atasan" maxlength="3" readonly="" id="field_cr_eselon_penilai_atasan" class="form-control" value="<?php echo isset($model['TRESELONID_PEJABAT']) ? $model['TRESELONID_PEJABAT'] : set_value('eselon_penilai_atasan'); ?>" placeholder="Eselon Atasan Langsung" />
                        <input type="hidden" name="id_jabatan_penilai_atasan" maxlength="4" readonly="" id="field_cr_id_jabatan_penilai_atasan" class="form-control" value="<?php echo isset($model['TRJABATANID_PEJABAT']) ? $model['TRJABATANID_PEJABAT'] : set_value('id_jabatan_penilai_atasan'); ?>" placeholder="ID Jabatan Atasan Langsung" />
                        <input type="hidden" name="trlokasiid_penilai_atasan" maxlength="4" readonly="" id="field_cr_trlokasiid_penilai_atasan" class="form-control" value="<?php echo isset($model['TRLOKASIID_PEJABAT']) ? $model['TRLOKASIID_PEJABAT'] : set_value('trlokasiid_penilai_atasan'); ?>" placeholder="Lokasi Atasan Langsung" />
                        <input type="hidden" name="kdu1_penilai_atasan" maxlength="2" readonly="" id="field_cr_kdu1_penilai_atasan" class="form-control" value="<?php echo isset($model['KDU1_PEJABAT']) ? $model['KDU1_PEJABAT'] : set_value('kdu1_penilai_atasan'); ?>" placeholder="kdu1 Atasan Langsung" />
                        <input type="hidden" name="kdu2_penilai_atasan" maxlength="2" readonly="" id="field_cr_kdu2_penilai_atasan" class="form-control" value="<?php echo isset($model['KDU2_PEJABAT']) ? $model['KDU2_PEJABAT'] : set_value('kdu2_penilai_atasan'); ?>" placeholder="kdu2 Atasan Langsung" />
                        <input type="hidden" name="kdu3_penilai_atasan" maxlength="3" readonly="" id="field_cr_kdu3_penilai_atasan" class="form-control" value="<?php echo isset($model['KDU3_PEJABAT']) ? $model['KDU3_PEJABAT'] : set_value('kdu3_penilai_atasan'); ?>" placeholder="kdu3 Atasan Langsung" />
                        <input type="hidden" name="kdu4_penilai_atasan" maxlength="3" readonly="" id="field_cr_kdu4_penilai_atasan" class="form-control" value="<?php echo isset($model['KDU4_PEJABAT']) ? $model['KDU4_PEJABAT'] : set_value('kdu4_penilai_atasan'); ?>" placeholder="kdu4 Atasan Langsung" />
                        <input type="hidden" name="kdu5_penilai_atasan" maxlength="2" readonly="" id="field_cr_kdu5_penilai_atasan" class="form-control" value="<?php echo isset($model['KDU5_PEJABAT']) ? $model['KDU5_PEJABAT'] : set_value('kdu5_penilai_atasan'); ?>" placeholder="kdu5 Atasan Langsung" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Kab / Kota Pengajuan Cuti</label>
                    <div class="col-md-8">
                        <input type="text" name="kota" maxlength="100" id="field_cr_kota" class="form-control" value="<?php echo isset($model['KOTA']) ? $model['KOTA'] : set_value('kota'); ?>" placeholder="Kota" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Alamat Cuti</label>
                    <div class="col-md-8">
                        <textarea name="alamat_cuti" maxlength="500" id="field_cr_alamat_cuti" class="form-control" placeholder="Alamat Cuti"><?php echo isset($model['ALAMAT_CUTI']) ? $model['ALAMAT_CUTI'] : set_value('alamat_cuti'); ?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Keperluan Cuti</label>
                    <div class="col-md-8">
                        <textarea name="keperluan_cuti" maxlength="500" id="field_cr_keperluan_cuti" class="form-control" placeholder="Keperluan Cuti"><?php echo isset($model['KEPERLUAN']) ? $model['KEPERLUAN'] : set_value('keperluan_cuti'); ?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">No. SK Persetujuan</label>
                    <div class="col-md-8">
                        <input type="text" name="no_sk" maxlength="60" id="field_cr_no_sk" class="form-control" value="<?php echo isset($model['SK_PERSETUJUAN']) ? $model['SK_PERSETUJUAN'] : set_value('no_sk'); ?>" placeholder="No SK" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Tgl SK</label>
                    <div class="col-md-8">
                        <input type="text" name="tgl_sk" maxlength="10" id="field_cr_tgl_sk" class="form-control" value="<?php echo isset($model['TGL_PERSETUJUAN']) ? $model['TGL_PERSETUJUAN'] : set_value('tgl_sk'); ?>" placeholder="Tgl SK" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Tahun</label>
                    <div class="col-md-8">
                        <input type="text" name="tahun" maxlength="4" id="field_cr_tahun" class="form-control" value="<?php echo isset($model['TAHUN']) ? $model['TAHUN'] : date("Y"); ?>" placeholder="Tahun" />
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
    $("select#field_cr_jenis_cuti").select2();
    $("input#field_cr_tgl_mulai_cuti").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy'}).on('changeDate', function(selected){
        var minDate = new Date(selected.date.valueOf());
        $("input#field_cr_tgl_selesai_cuti").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy'});
        $("input#field_cr_tgl_selesai_cuti").datepicker('setStartDate', minDate);
        $("input#field_cr_tgl_selesai_cuti").datepicker('setDate', minDate);
    });
    $("input#field_cr_tgl_mulai_cuti").inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_selesai_cuti").inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_pengajuan").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tahun").datepicker({autoclose: true, language: "id", format: 'yyyy', startView: "years", minViewMode: "years", endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("9999", {placeholder: 'YYYY'});
</script>