<?php
$thnjabatan = '';
if (isset($model['TMT_CPNS2']) && !empty($model['TMT_CPNS2'])) {
    $thnjabatan = explode("/", $model['TMT_CPNS2'])[2];
}
?>
<div class="form">
    <?php echo form_open("://", ["class" => "formdetailpegawaiwithoutlist horizontal-form", 'data-identify' => 'cpns', 'data-url' => site_url('master_pegawai/master_pegawai_cpns/ubah_proses?id=' . $data_pegawai['ID'])]); ?>
    <div class="form-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Status Kepegawaian <span class="required" aria-required="true"> * </span></label>
                    <select name="trstatuskepegawaian_id" id="field_c_trstatuskepegawaian_id" class="form-control" style="width: 100%"></select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">NIP Lama <span class="required" aria-required="true"> * </span></label>
                    <input type="text" readonly="" name="nipold" minlength="4" maxlength="18" id="field_c_nipold" class="form-control" value="<?php echo isset($data_pegawai['NIP']) ? $data_pegawai['NIP'] : set_value('nipold'); ?>" placeholder="NIP Lama" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">NIP Baru / NRP <span class="required" aria-required="true"> * </span></label>
                    <input type="text" readonly="" name="nipnew" id="field_c_nipnew" minlength="18" maxlength="18" class="form-control" value="<?php echo isset($data_pegawai['NIPNEW']) ? $data_pegawai['NIPNEW'] : set_value('nipnew'); ?>" placeholder="NIP Baru" />
                </div>
            </div>
            <!--/span-->
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Gelar Depan</label>
                    <input type="text" readonly="" name="gelar_dpn" id="field_c_gelar_dpn" class="form-control" value="<?php echo isset($data_pegawai['GELAR_DEPAN']) ? $data_pegawai['GELAR_DEPAN'] : set_value('gelar_dpn'); ?>" placeholder="Gelar Depan" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Nama Lengkap <span class="required" aria-required="true"> * </span></label>
                    <input type="text" readonly="" name="nama_lengkap" id="field_c_nama_lengkap" class="form-control" value="<?php echo isset($data_pegawai['NAMA']) ? $data_pegawai['NAMA'] : set_value('nama_lengkap'); ?>" placeholder="Nama Lengkap" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Gelar Belakang</label>
                    <input type="text" readonly="" name="gelar_blkg" id="field_c_nipnew" class="form-control" value="<?php echo isset($data_pegawai['GELAR_BLKG']) ? $data_pegawai['GELAR_BLKG'] : set_value('gelar_blkg'); ?>" placeholder="Gelar Belakang" />
                </div>
            </div>
            <!--/span-->
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Pangkat</label>
                    <select name="pangkat" id="field_c_pangkat" class="form-control" style="width: 100%">
                        <option value="">- Pilih Pangkat -</option>
                        <?php if (isset($list_golongan_pangkat)): ?>
                            <?php foreach ($list_golongan_pangkat as $val): ?>
                                <?php
                                $selec = '';
                                if ($val['ID'] == $pangkat_cpns['TRGOLONGAN_ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Tingkat Pendidikan</label>
                    <select name="tktpendidikan_id" id="field_c_tktpendidikan_id" class="form-control" style="width: 100%">
                        <option value="">- Pilih Tingkat Pendidikan -</option>
                        <?php if (isset($list_pendidikan)): ?>
                            <?php foreach ($list_pendidikan as $val): ?>
                                <?php
                                $selec = '';
                                if ($val['ID'] == $data_cpns['TRTKTPENDIDIKAN_ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>
            <!--/span-->
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">TMT (CPNS / Pengangkatan)</label>
                    <input type="text" name="tmt_cpns" id="field_c_tmt_cpns" class="form-control" value="<?php echo isset($data_cpns['TMT_CPNS2']) ? $data_cpns['TMT_CPNS2'] : set_value('tmt_cpns'); ?>" placeholder="TMT CPNS" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">TMT Kerja</label>
                    <input type="text" name="tmt_kerja" id="field_c_tmt_kerja" class="form-control" value="<?php echo isset($data_cpns['TMT_KERJA2']) ? $data_cpns['TMT_KERJA2'] : set_value('tmt_kerja'); ?>" placeholder="TMT Kerja" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Tgl Lahir</label>
                    <input type="text" name="tgl_lahir" disabled="" id="field_c_tgl_lahir" class="form-control" value="<?php echo isset($data_pegawai['TGLLAHIR']) ? $data_pegawai['TGLLAHIR'] : set_value('tgl_lahir'); ?>" placeholder="Tgl Lahir" />
                </div>
            </div>
            <!--/span-->
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Eselon</label>
                    <select name="eselon" id="field_c_eselon_id" class="form-control" style="width: 100%">
                        <option value="">- Pilih Eselon -</option>
                        <?php if (isset($list_eselon)): ?>
                            <?php foreach ($list_eselon as $val): ?>
                                <?php
                                $selec = '';
                                if ($val['ID'] == $data_cpns['TRESELON_ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Jabatan</label>
                    <select name="jabatan_id" id="field_c_jabatan_id" class="form-control" style="width: 100%">
                        <option value="">- Pilih Jabatan -</option>
                        <?php if (isset($list_jabatan)): ?>
                            <?php foreach ($list_jabatan as $val): ?>
                                <?php
                                $selec = '';
                                if ($val['ID'] == $data_cpns['TRJABATAN_ID'])
                                    $selec = 'selected=""';
                                ?>
                                <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="control-label">Jabatan (Tanpa Kode Ref)</label>
                    <input type="text" name="jabatan_nokoderef" id="field_cr_jabatan_nokoderef" class="form-control" value="<?php echo isset($data_cpns['NAMA_JABATAN_NOKODEREF']) ? $data_cpns['NAMA_JABATAN_NOKODEREF'] : set_value('jabatan_nokoderef'); ?>" placeholder="Jabatan Tanpa Kode Ref" />
                </div>
            </div>
            <!--/span-->
        </div>
        <!--/row-->
        <div class="row">
            <div class="col-md-12">&nbsp;</div>
            <div class="col-md-12">&nbsp;</div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tabbable-custom nav-justified">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active">
                            <a href="#tab_1_1_1" data-toggle="tab" aria-expanded="true"> Unit Kerja </a>
                        </li>
                        <li class="">
                            <a href="#tab_1_1_2" data-toggle="tab" aria-expanded="false"> Masa Kerja Tambahan </a>
                        </li>
                        <li class="">
                            <a href="#tab_1_1_3" data-toggle="tab" aria-expanded="false"> Surat Keputusan </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1_1">
                            <div class="form-body form-horizontal">
                                <?php $this->load->view('system/unitkerja_form-horizontal'); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Unit Kerja (Tanpa Kode Referensi)</label>
                                            <div class="col-md-7">
                                                <input type="text" name="unitkerjanokoderef" id="field_c_unitkerjanokoderef" class="form-control" value="<?php echo (isset($data_cpns['UNITKERJA_NOKODEREF']) && $thnjabatan < 2017) ? $data_cpns['UNITKERJA_NOKODEREF'] : set_value('unitkerjanokoderef'); ?>" placeholder="Unit Kerja (Tanpa Kode Referensi)" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_1_2">
                            <div class="form-body form-horizontal">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Fiktif</label>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <input type="text" name="fiktif_thn" id="field_c_fiktif_thn" class="form-control" value="<?php echo isset($data_cpns['FIKTIF_TAHUN']) ? $data_cpns['FIKTIF_TAHUN'] : 0; ?>" placeholder="Fiktif Tahun" />
                                                    <span class="input-group-addon">Thn.</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <input type="text" name="fiktif_bln" id="field_c_fiktif_bln" class="form-control" value="<?php echo isset($data_cpns['FIKTIF_BULAN']) ? $data_cpns['FIKTIF_BULAN'] : 0; ?>" placeholder="Fiktif Bulan" />
                                                    <span class="input-group-addon">Bln.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Honorer</label>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <input type="text" name="honorer_thn" id="field_c_honorer_thn" class="form-control" value="<?php echo isset($data_cpns['HONORER_TAHUN']) ? $data_cpns['HONORER_TAHUN'] : 0; ?>" placeholder="Honorer Tahun" />
                                                    <span class="input-group-addon">Thn.</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <input type="text" name="honorer_bln" id="field_c_honorer_bln" class="form-control" value="<?php echo isset($data_cpns['HONORER_BULAN']) ? $data_cpns['HONORER_BULAN'] : 0; ?>" placeholder="Honorer Bulan" />
                                                    <span class="input-group-addon">Bln.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Swasta</label>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <input type="text" name="swasta_thn" id="field_c_swasta_thn" class="form-control" value="<?php echo isset($data_cpns['SWASTA_TAHUN']) ? $data_cpns['SWASTA_TAHUN'] : 0; ?>" placeholder="Swasta Tahun" />
                                                    <span class="input-group-addon">Thn.</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <input type="text" name="swasta_bln" id="field_c_swasta_bln" class="form-control" value="<?php echo isset($data_cpns['SWASTA_BULAN']) ? $data_cpns['SWASTA_BULAN'] : 0; ?>" placeholder="Swasta Bulan" />
                                                    <span class="input-group-addon">Bln.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">MK Total</label>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <input type="text" name="mk_thn" id="field_c_mk_thn" class="form-control" placeholder="0" value="<?php echo isset($data_cpns['THN_MASAKERJA']) ? $data_cpns['THN_MASAKERJA'] : 0; ?>" readonly="" />
                                                    <span class="input-group-addon">Thn.</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <input type="text" name="mk_bln" id="field_c_mk_bln" class="form-control" placeholder="0" value="<?php echo isset($data_cpns['BLN_MASAKERJA']) ? $data_cpns['BLN_MASAKERJA'] : 0; ?>" readonly="" />
                                                    <span class="input-group-addon">Bln.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_1_3">
                            <div class="form-body form-horizontal">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Nomor</label>
                                            <div class="col-md-8">
                                                <input type="text" name="no_sk" maxlength="500" id="field_c_no_sk" class="form-control" value="<?php echo isset($pangkat_cpns['NO_SK']) ? $pangkat_cpns['NO_SK'] : set_value('no_sk'); ?>" placeholder="No SK" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Tanggal</label>
                                            <div class="col-md-8">
                                                <input type="text" name="tgl_sk" id="field_c_tgl_sk" class="form-control" value="<?php echo isset($pangkat_cpns['TGL_SK']) ? $pangkat_cpns['TGL_SK'] : set_value('tgl_sk'); ?>" placeholder="Tgl SK" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Pejabat</label>
                                            <div class="col-md-8">
                                                <input type="text" name="pejabat_sk" maxlength="500" id="field_c_pejabat_sk" class="form-control" value="<?php echo isset($pangkat_cpns['PEJABAT_SK']) ? $pangkat_cpns['PEJABAT_SK'] : set_value('pejabat_sk'); ?>" placeholder="Pejabat SK" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">SK CPNS</label>
                                            <div class="col-md-8">
                                                <input type="file" name="doc_sk" id="field_c_doc_sk" class="form-control" value="" placeholder="Dokumen SK" />
                                                <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                                            </div>
                                            <?php if (!empty($pangkat_cpns['DOC_SKPANGKAT']) && $pangkat_cpns['DOC_SKPANGKAT'] <> '') { ?>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_pangkat/view_dokumen?id='.$pangkat_cpns['ID']); ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') { ?>
    <div class="form-actions">
        <!-- div class="pull-left">
            <button type="button" class="btn default"><i class="fa fa-close"></i> Batal</button>
        </div -->
        <div class="pull-right">
            <button type="submit" class="btn btn-warning btn-circle blue-chambray"><i class="fa fa-check"></i> Simpan</button>
        </div>
    </div>
    <?php } ?>
    <?php echo form_close(); ?>
</div>
<script>
    $("select#field_c_trstatuskepegawaian_id").select2({
        data: <?= $list_status_kepegawaian ?>,
        disabled: true
    });
    $('select#field_c_trstatuskepegawaian_id').val('<?php echo $data_pegawai['TRSTATUSKEPEGAWAIAN_ID'];?>').trigger('change');
    <?php if (isset($list_lokasi_tree)) { ?>
        $("select#field_c_trlokasi_id").select2({
            data: <?= $list_lokasi_tree ?>
        });
    <?php } else { ?>
        $("select#field_c_trlokasi_id").select2();
    <?php } ?>
    $("select#field_c_pangkat").select2();
    $("select#field_c_tktpendidikan_id").select2();
    $("select#field_c_eselon_id").select2();
    $("select#field_c_jabatan_id").select2();
    $("select#field_c_kdu1").select2();
    $("select#field_c_kdu2").select2();
    $("select#field_c_kdu3").select2();
    $("select#field_c_kdu4").select2();
    $("select#field_c_kdu5").select2();
    $("input#field_c_tmt_cpns").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_c_tmt_kerja").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_c_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_c_tgl_lahir").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y') - 10)) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>