<div class="modal-header bg-yellow-soft bg-font-yellow-soft" style="padding: 10px">
    <i class="bg-font-blue-madison font-lg icon-close pull-right" style="line-height: 26px;cursor: pointer" data-dismiss="modal" aria-hidden="true"></i>
    <h4 class="modal-title bg-font-blue-madison font-lg sbold pull-left">Verifikasi Pengajuan Cuti Pegawai</h4>
</div>
<?php echo form_open(site_url('pengajuan_cuti_pegawai/ubah_proses?id=' . $model['ID']), ["class" => "horizontal-form", 'name' => 'formverifikasicuti']); ?>
<div class="modal-body">
    <div class="form">
        <!-- BEGIN FORM-->

        <div class="form-body">

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Nama Cuti <span class="required" aria-required="true"> * </span></label>
                        <select name="jenis_cuti" id="field_cr_jenis_cuti" disabled="" class="form-control" style="width: 100%">
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
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Tgl Pengajuan</label>
                        <input type="text" name="tgl_pengajuan" readonly="" maxlength="10" id="field_cr_tgl_pengajuan" class="form-control" value="<?php echo isset($model['TGL_PENGAJUAN2']) ? $model['TGL_PENGAJUAN2'] : set_value('tgl_pengajuan'); ?>" placeholder="Tgl Pengajuan" />
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Tgl Mulai <span class="required" aria-required="true"> * </span></label>
                        <input type="text" name="tgl_mulai_cuti" readonly="" maxlength="10" id="field_cr_tgl_mulai_cuti" class="form-control" value="<?php echo isset($model['TGL_MULAI2']) ? $model['TGL_MULAI2'] : set_value('tgl_mulai_cuti'); ?>" placeholder="Tgl Mulai" />
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Tgl Selesai <span class="required" aria-required="true"> * </span></label>
                        <input type="text" name="tgl_selesai_cuti" readonly="" maxlength="10" id="field_cr_tgl_selesai_cuti" class="form-control" value="<?php echo isset($model['TGL_AKHIR2']) ? $model['TGL_AKHIR2'] : set_value('tgl_selesai_cuti'); ?>" placeholder="Tgl Selesai" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Lama Cuti</label>
                        <div class="input-group">
                            <input type="text" name="lama_cuti" maxlength="4" readonly="" id="field_cr_lama_cuti" class="form-control" value="<?php echo isset($model['LAMA']) ? $model['LAMA'] : set_value('lama_cuti'); ?>" placeholder="Lama Cuti" />
                            <span class="input-group-addon">Hari</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Atasan Langsung</label>
                        <input type="text" name="nip_atasan" readonly="" maxlength="18" id="field_cr_nip_atasan" class="form-control" value="<?php echo isset($model['NIP_ATASAN']) ? $model['NIP_ATASAN'] : set_value('nip_atasan'); ?>" placeholder="Atasan Langsung" />
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Nama Atasan Langsung</label>
                        <input type="text" name="nama_atasan" readonly="" maxlength="100" id="field_cr_nama_atasan" class="form-control" value="<?php echo isset($model['NAMA_ATASAN']) ? $model['NAMA_ATASAN'] : set_value('nama_atasan'); ?>" placeholder="Nama Atasan Langsung" />
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Jabatan Atasan Langsung</label>
                        <textarea name="jabatan_atasan" maxlength="1000" readonly="" id="field_cr_jabatan_atasan" class="form-control" placeholder="Jabatan Atasan Langsung"><?php echo isset($model['JABATAN_ATASAN']) ? $model['JABATAN_ATASAN'] : set_value('jabatan_atasan'); ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Atasan Penilai</label>
                        <input type="text" name="nip_penilai_atasan" readonly="" maxlength="18" id="field_cr_nip_penilai_atasan" class="form-control" value="<?php echo isset($model['NIP_PEJABAT']) ? $model['NIP_PEJABAT'] : set_value('nip_penilai_atasan'); ?>" placeholder="Atasan Penilai" />
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Nama Atasan Penilai</label>
                        <input type="text" name="nama_penilai_atasan" readonly="" maxlength="100" id="field_cr_nama_penilai_atasan" class="form-control" value="<?php echo isset($model['NAMA_PEJABAT']) ? $model['NAMA_PEJABAT'] : set_value('nama_penilai_atasan'); ?>" placeholder="Nama Atasan Penilai" />
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Jabatan Atasan Penilai</label>
                        <textarea type="text" name="jabatan_penilai_atasan" maxlength="1000" readonly="" id="field_cr_jabatan_penilai_atasan" class="form-control" placeholder="Jabatan Atasan Langsung"><?php echo isset($model['JABATAN_PEJABAT']) ? $model['JABATAN_PEJABAT'] : set_value('jabatan_penilai_atasan'); ?></textarea>
                    </div>
                </div>
            </div>
                
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Kab / Kota Pengajuan Cuti</label>
                        <input type="text" name="kota" maxlength="100" readonly="" id="field_cr_kota" class="form-control" value="<?php echo isset($model['KOTA']) ? $model['KOTA'] : set_value('kota'); ?>" placeholder="Kota" />
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Alamat Cuti</label>
                        <textarea name="alamat_cuti" maxlength="500" readonly="" id="field_cr_alamat_cuti" class="form-control" placeholder="Alamat Cuti"><?php echo isset($model['ALAMAT_CUTI']) ? $model['ALAMAT_CUTI'] : set_value('alamat_cuti'); ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Keperluan Cuti</label>
                        <textarea name="keperluan_cuti" maxlength="500" readonly="" id="field_cr_keperluan_cuti" class="form-control" placeholder="Keperluan Cuti"><?php echo isset($model['KEPERLUAN']) ? $model['KEPERLUAN'] : set_value('keperluan_cuti'); ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <?php
                        $statusverifikasi = '';
                        $alasanverifikasi = '';
                        $bingkai = '';
                        $sket = '';

                        if (isset($model['STATUS']) && $model['STATUS'] == 1) {
                            $statusverifikasi = 'verifikasi_atasan';
                            $alasanverifikasi = 'alasan_atasan';
                            $bingkai = 'VERIFIKASI_ALASAN';
                            $sket = 'VERIFIKASI_ATASAN';
                        }
                        if (isset($model['STATUS']) && $model['STATUS'] == 2) {
                            $statusverifikasi = 'verifikasi_pejabat';
                            $alasanverifikasi = 'alasan_pejabat';
                            $bingkai = 'VERIFIKASI_PEJABAT_ALASAN';
                            $sket = 'VERIFIKASI_PEJABAT';
                        }
                        ?>
                        <label class="control-label">Verifikasi Cuti <span class="required" aria-required="true"> * </span></label>
                        <select name="<?php echo $statusverifikasi ?>" id="field_cr_<?php echo $statusverifikasi ?>" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($daftar_verifikasi_cuti)): ?>
                                <?php foreach ($daftar_verifikasi_cuti as $key => $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($model) && $key == $sket)
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?php echo $selec ?> value="<?= $key ?>"><?= $val ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label class="control-label">Alasan</label>
                        <textarea name="<?php echo $alasanverifikasi ?>" maxlength="1000" id="field_cr_<?php echo $alasanverifikasi ?>" class="form-control" placeholder="Alasan"><?php echo isset($model[$bingkai]) ? $model[$bingkai] : set_value($alasanverifikasi); ?></textarea>
                    </div>
                </div>
            </div>

            <!--/row-->
        </div>
        <!-- END FORM-->
    </div>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-6 left text-left">
            <button type="button" class="btn dark btn-outline btn-circle" data-dismiss="modal">Tutup</button>
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-warning btn-circle blue-chambray"><i class="fa fa-check"> </i>Simpan</button>
        </div>
    </div>
</div>
<?php echo form_close(); ?>