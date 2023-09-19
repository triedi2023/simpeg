<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Tambah Data Hukuman Disiplin Dari BKN</h4>
</div>
<?php echo form_open(site_url('integrasi_bkn/tambah_penghargaan_proses?id=' . $id), ["class" => "formtambahbkn form-horizontal"]); ?>
<div class="modal-body">
    <div class="form">

        <div class="form-body">

            <div class="form-group">
                    <label class="control-label col-md-3">Tingkat Hukuman <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="tingkat_hukuman" id="field_cr_tingkat_hukuman" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_tkt_hukdis)): ?>
                                <?php foreach ($list_tkt_hukdis as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($idtingkathukdis) && $val['ID'] == $idtingkathukdis)
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Jenis Hukuman <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-8">
                        <select name="jenis_hukuman" id="field_cr_jenis_hukuman" class="form-control" style="width: 100%">
                            <option value="">- Pilih -</option>
                            <?php if (isset($list_jenis_hukdis)): ?>
                                <?php foreach ($list_jenis_hukdis as $val): ?>
                                    <?php
                                    $selec = '';
                                    if (isset($idjenishukdis) && $val['ID'] == $idjenishukdis)
                                        $selec = 'selected=""';
                                    ?>
                                    <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Alasan Hukuman</label>
                    <div class="col-md-8">
                        <textarea name="alasan_hukuman" maxlength="3000" id="field_cr_alasan_hukuman" class="form-control" placeholder="Alasan Hukuman"><?php echo isset($bkn['alasanHukumanDisiplin']) ? $bkn['alasanHukumanDisiplin'] : set_value('alasan_hukuman'); ?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">TMT Hukuman</label>
                    <div class="col-md-8">
                        <?php
                        $tglawal = isset($bkn['hukumanTanggal'])?explode("-",$bkn['hukumanTanggal']):NULL;
                        $formattglawal = '';
                        if ($tglawal) {
                            $formattglawal = $tglawal[2]."/".$tglawal[1]."/".$tglawal[0];
                        }
                        ?>
                        <input type="text" name="tmt_hukuman" maxlength="10" id="field_cr_tmt_hukuman" class="form-control" value="<?php echo $formattglawal; ?>" placeholder="Tmt Hukuman" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Akhir Hukuman</label>
                    <div class="col-md-8">
                        <?php
                        $tglakhir = isset($bkn['akhirHukumTanggal'])?explode("-",$bkn['akhirHukumTanggal']):NULL;
                        $formattglakhir = '';
                        if ($tglakhir) {
                            $formattglakhir = $tglakhir[2]."/".$tglakhir[1]."/".$tglakhir[0];
                        }
                        ?>
                        <input type="text" name="akhir_hukuman" maxlength="10" id="field_cr_akhir_hukuman" class="form-control" value="<?php echo $formattglakhir; ?>" placeholder="Akhir Hukuman" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-4 bold">SURAT KEPUTUSAN</label>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">No SK</label>
                    <div class="col-md-6">
                        <input type="text" name="no_sk" maxlength="100" id="field_cr_no_sk" class="form-control" value="<?php echo isset($bkn['skNomor']) ? $bkn['skNomor'] : set_value('no_sk'); ?>" placeholder="NO SK" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Tgl SK</label>
                    <div class="col-md-6">
                        <?php
                        $tglsk = isset($bkn['skTanggal'])?explode("-",$bkn['skTanggal']):NULL;
                        $formattglsk = '';
                        if ($tglsk) {
                            $formattglsk = $tglsk[2]."/".$tglsk[1]."/".$tglsk[0];
                        }
                        ?>
                        <input type="text" name="tgl_sk" maxlength="100" id="field_cr_tgl_sk" class="form-control" value="<?php echo $formattglsk; ?>" placeholder="TGL SK" />
                    </div>
                </div>

            <!--/row-->
        </div>

    </div>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-6 text-left">
            <button type="button" data-dismiss="modal" class="btn default btnbatalformcudetailpegawai text-left"><i class="fa fa-close"></i> Batal</button>
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-warning btn-circle blue-chambray"><i class="fa fa-check"></i> Simpan</button>
        </div>
    </div>
</div>
<?php echo form_close(); ?>