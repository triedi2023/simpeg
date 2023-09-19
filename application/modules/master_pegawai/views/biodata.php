<div class="form">
    <?php echo form_open("://", ["class" => "formdetailpegawaiwithoutlist horizontal-form", 'data-url' => site_url('master_pegawai/ubah_datapokok_biodata?id=' . $data_pegawai['ID'])]); ?>
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
                    <input type="text" name="nipold" minlength="4" maxlength="18" id="field_c_nipold" class="form-control" value="<?php echo isset($data_pegawai['NIP']) ? $data_pegawai['NIP'] : set_value('nipold'); ?>" placeholder="NIP Lama" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">NIP Baru / NRP <span class="required" aria-required="true"> * </span></label>
                    <input type="text" name="nipnew" id="field_c_nipnew" minlength="4" maxlength="18" class="form-control" value="<?php echo isset($data_pegawai['NIPNEW']) ? $data_pegawai['NIPNEW'] : set_value('nipnew'); ?>" placeholder="NIP Baru" />
                </div>
            </div>
            <!--/span-->
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Gelar Depan</label>
                    <input type="text" name="gelar_dpn" <?php if ($this->session->userdata('idgroup') != 1) { ?> readonly="" <?php } ?> id="field_c_gelar_dpn" class="form-control" value="<?php echo isset($data_pegawai['GELAR_DEPAN']) ? $data_pegawai['GELAR_DEPAN'] : set_value('gelar_dpn'); ?>" placeholder="Gelar Depan" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Nama Lengkap <span class="required" aria-required="true"> * </span></label>
                    <input type="text" name="nama_lengkap" id="field_c_nama_lengkap" class="form-control" value="<?php echo isset($data_pegawai['NAMA']) ? $data_pegawai['NAMA'] : set_value('nama_lengkap'); ?>" placeholder="Nama Lengkap" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Gelar Belakang</label>
                    <input type="text" name="gelar_blkg" id="field_c_nipnew" <?php if ($this->session->userdata('idgroup') != 1) { ?> readonly="" <?php } ?> class="form-control" value="<?php echo isset($data_pegawai['GELAR_BLKG']) ? $data_pegawai['GELAR_BLKG'] : set_value('gelar_blkg'); ?>" placeholder="Gelar Belakang" />
                </div>
            </div>
            <!--/span-->
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Jenis Kelamin</label>
                    <select name="jk" id="field_c_jk" class="form-control" style="width: 100%">
                        <option value="">- Pilih Jenis Kelamin -</option>
                        <?php if (isset($list_jk)): ?>
                            <?php foreach ($list_jk as $val): ?>
                                <?php
                                $selec = '';
                                if ($val['ID'] == $data_pegawai['SEX'])
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
                    <label class="control-label">Status Perkawinan</label>
                    <select name="trstatuspernikahan_id" id="field_c_trstatuspernikahan_id" class="form-control" style="width: 100%">
                        <option value="">- Pilih Status Perkawinan -</option>
                        <?php if (isset($list_sts_nikah)): ?>
                            <?php foreach ($list_sts_nikah as $val): ?>
                                <?php
                                $selec = '';
                                if ($val['ID'] == $data_pegawai['TRSTATUSPERNIKAHAN_ID'])
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
                    <label class="control-label">Agama</label>
                    <select name="tragama_id" id="field_c_tragama_id" class="form-control" style="width: 100%">
                        <option value="">- Pilih Agama -</option>
                        <?php if (isset($list_agama)): ?>
                            <?php foreach ($list_agama as $val): ?>
                                <?php
                                $selec = '';
                                if ($val['ID'] == $data_pegawai['TRAGAMA_ID'])
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
                    <label class="control-label">Gol Darah</label>
                    <select name="gol_darah" id="field_c_gol_darah" class="form-control" style="width: 100%">
                        <option value="">- Pilih Gol Darah -</option>
                        <?php if (isset($list_gol_darah)): ?>
                            <?php foreach ($list_gol_darah as $val): ?>
                                <?php
                                $selec = '';
                                if ($val['ID'] == $data_pegawai['TRGOLDARAH_ID'])
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
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input type="email" name="email" id="field_c_email" class="form-control" value="<?php echo isset($data_pegawai['EMAIL']) ? $data_pegawai['EMAIL'] : set_value('email'); ?>" placeholder="Email" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Hobi</label>
                    <input type="text" name="hobi" id="field_c_hobi" class="form-control" value="<?php echo isset($data_pegawai['HOBI']) ? $data_pegawai['HOBI'] : set_value('hobi'); ?>" placeholder="Hobi" />
                </div>
            </div>
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
                            <a href="#tab_1_1_1" data-toggle="tab" aria-expanded="true"> Kelahiran </a>
                        </li>
                        <li class="">
                            <a href="#tab_1_1_2" data-toggle="tab" aria-expanded="false"> Keterangan Badan </a>
                        </li>
                        <li class="">
                            <a href="#tab_1_1_3" data-toggle="tab" aria-expanded="false"> Alamat </a>
                        </li>
                        <li class="">
                            <a href="#tab_1_1_4" data-toggle="tab" aria-expanded="false"> No Kartu </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1_1">
                            <div class="form-body form-horizontal">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Tempat Lahir</label>
                                            <div class="col-md-8">
                                                <input type="text" name="tpt_lahir" id="field_c_tpt_lahir" class="form-control" value="<?php echo isset($data_pegawai['TPTLAHIR']) ? $data_pegawai['TPTLAHIR'] : set_value('tpt_lahir'); ?>" placeholder="Tempat Lahir" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Provinsi Lahir</label>
                                            <div class="col-md-8">
                                                <select name="trprovinsilahir_id" id="field_c_trprovinsilahir_id" class="form-control" style="width: 100%">
                                                    <option value="">- Pilih Provinsi Lahir -</option>
                                                    <?php if (isset($list_provinsi)): ?>
                                                        <?php foreach ($list_provinsi as $val): ?>
                                                            <?php
                                                            $selec = '';
                                                            if ($val['ID'] == $data_pegawai['TRPROPINSI_ID_LAHIR'])
                                                                $selec = 'selected=""';
                                                            ?>
                                                            <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                        <?php endforeach ?>
                                                    <?php endif ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Kabupaten Lahir</label>
                                            <div class="col-md-8">
                                                <select name="trkabupatenlahir_id" id="field_c_trkabupatenlahir_id" class="form-control" style="width: 100%">
                                                    <option value="">- Pilih Kabupaten Lahir -</option>
                                                    <?php if (isset($list_kabupaten)): ?>
                                                        <?php foreach ($list_kabupaten as $val): ?>
                                                            <?php
                                                            $selec = '';
                                                            if ($val['ID'] == $data_pegawai['TRKABUPATEN_ID_LAHIR'])
                                                                $selec = 'selected=""';
                                                            ?>
                                                            <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                        <?php endforeach ?>
                                                    <?php endif ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Tanggal Lahir</label>
                                            <div class="col-md-8">
                                                <input type="text" name="tgllahir" id="field_c_tgllahir" class="form-control" value="<?php echo isset($data_pegawai['TGLLAHIR2']) ? $data_pegawai['TGLLAHIR2'] : set_value('tpt_lahir'); ?>" placeholder="Tgl Lahir" />
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Tinggi</label>
                                            <div class="col-md-9">
                                                <input type="text" name="tinggi_badan" id="field_c_tinggi_badan" class="form-control input-inline input-medium" value="<?php echo isset($data_pegawai['TINGGI_BADAN']) ? $data_pegawai['TINGGI_BADAN'] : set_value('tinggi_badan'); ?>" placeholder="Tinggi Badan" />
                                                <span class="help-inline"> cm </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Rambut</label>
                                            <div class="col-md-8">
                                                <input type="text" name="rambut" maxlength="35" id="field_c_rambut" class="form-control" value="<?php echo isset($data_pegawai['RAMBUT']) ? $data_pegawai['RAMBUT'] : set_value('rambut'); ?>" placeholder="Rambut" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Berat Badan</label>
                                            <div class="col-md-9">
                                                <input type="text" name="berat_badan" id="field_c_berat_badan" class="form-control input-inline input-medium" value="<?php echo isset($data_pegawai['BERAT_BADAN']) ? $data_pegawai['BERAT_BADAN'] : set_value('berat_badan'); ?>" placeholder="Berat Badan" />
                                                <span class="help-inline"> kg </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Bentuk Muka</label>
                                            <div class="col-md-8">
                                                <input type="text" name="bentuk_muka" maxlength="35" id="field_c_bentuk_muka" class="form-control" value="<?php echo isset($data_pegawai['BENTUK_MUKA']) ? $data_pegawai['BENTUK_MUKA'] : set_value('bentuk_muka'); ?>" placeholder="Bentuk Muka" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Ciri Khas</label>
                                            <div class="col-md-8">
                                                <input type="text" name="ciri_khas" maxlength="130" id="field_c_ciri_khas" class="form-control" value="<?php echo isset($data_pegawai['CIRI_KHAS']) ? $data_pegawai['CIRI_KHAS'] : set_value('ciri_khas'); ?>" placeholder="Ciri Khas" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Warna Kulit</label>
                                            <div class="col-md-8">
                                                <input type="text" name="warna_kulit" maxlength="35" id="field_c_warna_kulit" class="form-control" value="<?php echo isset($data_pegawai['WARNA_KULIT']) ? $data_pegawai['WARNA_KULIT'] : set_value('warna_kulit'); ?>" placeholder="Warna Kulit" />
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Jalan</label>
                                            <div class="col-md-8">
                                                <input type="text" name="alamat" maxlength="500" id="field_c_alamat" class="form-control" value="<?php echo isset($data_pegawai['ALAMAT']) ? $data_pegawai['ALAMAT'] : set_value('alamat'); ?>" placeholder="Jalan" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Propinsi</label>
                                            <div class="col-md-8">
                                                <select name="trprovinsitinggal_id" id="field_c_trprovinsitinggal_id" style="width: 100%" class="form-control" style="width: 100%">
                                                    <option value="">- Pilih Provinsi Tempat Tinggal -</option>
                                                    <?php if (isset($list_provinsi)): ?>
                                                        <?php foreach ($list_provinsi as $val): ?>
                                                            <?php
                                                            $selec = '';
                                                            if ($val['ID'] == $data_pegawai['PROPINSI'])
                                                                $selec = 'selected=""';
                                                            ?>
                                                            <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                        <?php endforeach ?>
                                                    <?php endif ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">RT / RW</label>
                                            <div class="col-md-4">
                                                <input type="text" maxlength="16" name="rt" id="field_c_rt" class="form-control" value="<?php echo isset($data_pegawai['RT']) ? $data_pegawai['RT'] : set_value('rt'); ?>" placeholder="RT" />
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" maxlength="4" name="rw" id="field_c_rw" class="form-control" value="<?php echo isset($data_pegawai['RW']) ? $data_pegawai['RW'] : set_value('rw'); ?>" placeholder="RW" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Kabupaten</label>
                                            <div class="col-md-8">
                                                <select name="trkabupatentinggal_id" id="field_c_trkabupatentinggal_id" style="width: 100%" class="form-control" style="width: 100%">
                                                    <option value="">- Pilih Kabupaten Tempat Tinggal -</option>
                                                    <?php if (isset($list_kabupaten_tempattinggal)): ?>
                                                        <?php foreach ($list_kabupaten_tempattinggal as $val): ?>
                                                            <?php
                                                            $selec = '';
                                                            if ($val['ID'] == $data_pegawai['KABUPATEN'])
                                                                $selec = 'selected=""';
                                                            ?>
                                                            <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                        <?php endforeach ?>
                                                    <?php endif ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Kelurahan / Desa</label>
                                            <div class="col-md-8">
                                                <input type="text" name="kelurahan" id="field_c_kelurahan" class="form-control" value="<?php echo isset($data_pegawai['KELURAHAN']) ? $data_pegawai['KELURAHAN'] : set_value('kelurahan'); ?>" placeholder="Kelurahan" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Kode Pos</label>
                                            <div class="col-md-8">
                                                <input type="text" name="kodepos" id="field_c_kodepos" class="form-control" value="<?php echo isset($data_pegawai['KODEPOS']) ? $data_pegawai['KODEPOS'] : set_value('kodepos'); ?>" placeholder="Kode Pos" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Kecamatan</label>
                                            <div class="col-md-8">
                                                <input type="text" name="kecamatan" id="field_c_kecamatan" class="form-control" value="<?php echo isset($data_pegawai['KECAMATAN']) ? $data_pegawai['KECAMATAN'] : set_value('kecamatan'); ?>" placeholder="Kecamatan" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Telp / HP</label>
                                            <div class="col-md-4">
                                                <input type="text" name="telp_rmh" id="field_c_telp_rmh" class="form-control" value="<?php echo isset($data_pegawai['TELP_RMH']) ? $data_pegawai['TELP_RMH'] : set_value('telp_rmh'); ?>" placeholder="No Tlp" />
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="telp_hp" id="field_c_telp_hp" class="form-control" value="<?php echo isset($data_pegawai['TELP_HP']) ? $data_pegawai['TELP_HP'] : set_value('telp_hp'); ?>" placeholder="No Hp" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_1_4">
                            <div class="form-body form-horizontal">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">No. Karpeg</label>
                                            <div class="col-md-8">
                                                <input type="text" maxlength="64" name="no_karpeg" id="field_c_no_karpeg" class="form-control" value="<?php echo isset($data_pegawai['NO_KARPEG']) ? $data_pegawai['NO_KARPEG'] : set_value('no_karpeg'); ?>" placeholder="Nomor Karpeg" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Dokumen Karpeg</label>
                                            <div class="col-md-8">
                                                <input type="file" name="doc_karpeg" id="field_c_doc_karpeg" class="form-control" value="<?php echo set_value('doc_karpeg'); ?>" placeholder="Dokumen Karpeg" />
                                                <span class="help-block text-danger"> Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb. </span>
                                            </div>
                                            <?php if (!empty($data_pegawai['DOC_KARPEG']) && $data_pegawai['DOC_KARPEG'] <> '') { ?>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-url="<?php echo base_url()."master_pegawai/view_dokumen?id=".$data_pegawai['ID']."&dokumen=doc_karpeg&v=".uniqid() ?>" target="_blank" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull" data-modal-title='Daftar Universitas'>
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">No. Karis / Karsu</label>
                                            <div class="col-md-8">
                                                <input type="text" maxlength="64" name="no_karisu" id="field_c_no_karisu" class="form-control" value="<?php echo isset($data_pegawai['NO_KARIS']) ? $data_pegawai['NO_KARIS'] : set_value('no_karisu'); ?>" placeholder="Nomor Karis / Karsu" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Dokumen Karis / Karsu</label>
                                            <div class="col-md-8">
                                                <input type="file" name="doc_karisu" id="field_c_doc_karisu" class="form-control" value="<?php echo set_value('doc_karisu'); ?>" placeholder="Dokumen Karis / Karsu" />
                                                <span class="help-block text-danger"> Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb. </span>
                                            </div>
                                            <?php if (!empty($data_pegawai['DOC_KARIS']) && $data_pegawai['DOC_KARIS'] <> '') { ?>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-url="<?php echo base_url()."master_pegawai/view_dokumen?id=".$data_pegawai['ID']."&dokumen=doc_karis&v=".uniqid() ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">No. Taspen</label>
                                            <div class="col-md-8">
                                                <input type="text" maxlength="64" name="no_tapen" id="field_c_no_tapen" class="form-control" value="<?php echo isset($data_pegawai['NO_TASPEN']) ? $data_pegawai['NO_TASPEN'] : set_value('no_tapen'); ?>" placeholder="Nomor Tapen" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Dokumen Taspen</label>
                                            <div class="col-md-8">
                                                <input type="file" name="doc_tapen" id="field_c_doc_tapen" class="form-control" value="<?php echo set_value('doc_tapen'); ?>" placeholder="Dokumen Tapen" />
                                                <span class="help-block text-danger"> Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb. </span>
                                            </div>
                                            <?php if (!empty($data_pegawai['DOC_TASPEN']) && $data_pegawai['DOC_TASPEN'] <> '') { ?>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-url="<?php echo base_url()."master_pegawai/view_dokumen?id=".$data_pegawai['ID']."&dokumen=doc_tapen&v=".uniqid() ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">No. KTP</label>
                                            <div class="col-md-8">
                                                <input type="text" maxlength="36" name="no_ktp" id="field_c_no_ktp" class="form-control" value="<?php echo isset($data_pegawai['NO_KTP']) ? $data_pegawai['NO_KTP'] : set_value('no_ktp'); ?>" placeholder="Nomor KTP" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Dokumen KTP</label>
                                            <div class="col-md-8">
                                                <input type="file" name="doc_ktp" id="field_c_doc_ktp" class="form-control" value="<?php echo set_value('doc_ktp'); ?>" placeholder="Dokumen KTP" />
                                                <span class="help-block text-danger"> Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb. </span>
                                            </div>
                                            <?php if (!empty($data_pegawai['DOC_KTP']) && $data_pegawai['DOC_KTP'] <> '') { ?>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-url="<?php echo base_url()."master_pegawai/view_dokumen?id=".$data_pegawai['ID']."&dokumen=doc_ktp&v=".uniqid() ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">No. NPWP</label>
                                            <div class="col-md-8">
                                                <input type="text" maxlength="36" name="no_npwp" id="field_c_no_npwp" class="form-control" value="<?php echo isset($data_pegawai['NO_NPWP']) ? $data_pegawai['NO_NPWP'] : set_value('no_npwp'); ?>" placeholder="Nomor NPWP" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Dokumen NPWP</label>
                                            <div class="col-md-8">
                                                <input type="file" name="doc_npwp" id="field_c_doc_npwp" class="form-control" value="<?php echo set_value('doc_npwp'); ?>" placeholder="Dokumen NPWP" />
                                                <span class="help-block text-danger"> Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb. </span>
                                            </div>
                                            <?php if (!empty($data_pegawai['DOC_NPWP']) && $data_pegawai['DOC_NPWP'] <> '') { ?>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-url="<?php echo base_url()."master_pegawai/view_dokumen?id=".$data_pegawai['ID']."&dokumen=doc_npwp&v=".uniqid() ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">No. Askes</label>
                                            <div class="col-md-8">
                                                <input type="text" maxlength="64" name="no_askes" id="field_c_no_askes" class="form-control" value="<?php echo isset($data_pegawai['NO_ASKES']) ? $data_pegawai['NO_ASKES'] : set_value('no_askes'); ?>" placeholder="Nomor Askes" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Dokumen Askes</label>
                                            <div class="col-md-8">
                                                <input type="file" name="doc_askes" id="field_c_doc_askes" class="form-control" value="<?php echo set_value('doc_askes'); ?>" placeholder="Dokumen Askes" />
                                                <span class="help-block text-danger"> Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb. </span>
                                            </div>
                                            <?php if (!empty($data_pegawai['DOC_ASKES']) && $data_pegawai['DOC_ASKES'] <> '') { ?>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-url="<?php echo base_url()."master_pegawai/view_dokumen?id=".$data_pegawai['ID']."&dokumen=doc_askes&v=".uniqid() ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">No. BPJS</label>
                                            <div class="col-md-8">
                                                <input type="text" maxlength="64" name="no_bpjs" id="field_c_no_bpjs" class="form-control" value="<?php echo isset($data_pegawai['NO_BPJS']) ? $data_pegawai['NO_BPJS'] : set_value('no_bpjs'); ?>" placeholder="Nomor Bpjs" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Dokumen BPJS</label>
                                            <div class="col-md-8">
                                                <input type="file" name="doc_bpjs" id="field_c_doc_bpjs" class="form-control" value="<?php echo set_value('doc_bpjs'); ?>" placeholder="Dokumen bpjs" />
                                                <span class="help-block text-danger"> Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb. </span>
                                            </div>
                                            <?php if (!empty($data_pegawai['DOC_BPJS']) && $data_pegawai['DOC_BPJS'] <> '') { ?>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-url="<?php echo base_url()."master_pegawai/view_dokumen?id=".$data_pegawai['ID']."&dokumen=doc_bpjs&v=".uniqid() ?>" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
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

    <?php if ($this->session->userdata('idgroup') != '' && !in_array($this->session->userdata('idgroup'), ['3'])) { ?>
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
        data: <?= $list_status_kepegawaian ?>
    });
    $('select#field_c_trstatuskepegawaian_id').val('<?php echo $data_pegawai['TRSTATUSKEPEGAWAIAN_ID'];?>').trigger('change');
    $("select#field_c_jk").select2();
    $("select#field_c_tragama_id").select2();
    $("select#field_c_gol_darah").select2();
    $("select#field_c_trstatuspernikahan_id").select2();
    $("select#field_c_trprovinsilahir_id").select2();
    $("select#field_c_trkabupatenlahir_id").select2();
    $("select#field_c_trprovinsitinggal_id").select2();
    $("select#field_c_trkabupatentinggal_id").select2();
    $("input#field_c_tgllahir").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y') - 10)) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>