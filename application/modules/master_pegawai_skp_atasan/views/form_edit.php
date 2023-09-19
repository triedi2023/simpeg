<div class="col-md-12">
    <div class="portlet box yellow-gold">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Form <?= $title_form; ?> Referensi <?= $title_utama; ?>
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <select name="acuan_satuan" id="acuan_satuan" style="display: none;">
                <?php foreach ($list_satuan_skp as $value): ?>
                    <option value="<?php echo $value['ID'] ?>"><?php echo $value['NAMA'] ?></option>
                <?php endforeach; ?>
            </select>
            <?php
            $arraybulan = [
                1 => '1 Bulan',
                2 => '2 Bulan',
                3 => '3 Bulan',
                4 => '4 Bulan',
                5 => '5 Bulan',
                6 => '6 Bulan',
                7 => '7 Bulan',
                8 => '8 Bulan',
                9 => '9 Bulan',
                10 => '10 Bulan',
                11 => '11 Bulan',
                12 => '12 Bulan',
            ];
            ?>
            <!-- BEGIN FORM-->
            <?php echo form_open("://", ["class" => "formcreateupdate form-horizontal", 'data-url' => isset($id) ? site_url('master_pegawai_skp/ubah_proses?id=' . $id) : site_url('master_pegawai_skp/tambah_proses')]); ?>
            <div class="form-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 pull-left">Periode Penilaian <span class="required" aria-required="true"> * </span></label>
                            <div class="col-xs-2">
                                <select id="periode_awal" name="periode_awal" class="form-control">
                                    <?php foreach ($list_bulan as $key => $val): ?>
                                        <option value="<?php echo $val['kode'] ?>"><?php echo $val['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-xs-1 text-center"><p class="form-control-static">S/D</p></div>
                            <div class="col-xs-2">
                                <select id="periode_akhir" name="periode_akhir" class="form-control">
                                    <?php foreach ($list_bulan_desc as $key => $val): ?>
                                        <option value="<?php echo $val['kode'] ?>"><?php echo $val['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-xs-2">
                                <select id="periode_tahun" name="periode_tahun" class="form-control">
                                    <?php for ($year = date('Y') + 1; $year >= 2012; $year--): ?>
                                        <?php
                                        $selec = '';
                                        if ($year == date('Y'))
                                            $selec = 'selected=""';
                                        ?>
                                        <option <?php echo $selec; ?> value="<?php echo $year ?>"><?php echo $year ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="text-center bg-yellow bg-font-yellow">PEGAWAI NEGERI SIPIL YANG DINILAI</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 pull-left">Nama</label>
                            <div class="col-md-8">
                                <?php $nama = ((!empty($data_pegawai['GELAR_DEPAN'])) ? $data_pegawai['GELAR_DEPAN'] . " " : "") . ($data_pegawai['NAMA']) . ((!empty($data_pegawai['GELAR_BLKG'])) ? ", " . $data_pegawai['GELAR_BLKG'] : ''); ?>
                                <p class="form-control-static"><?php echo $nama ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 pull-left">NIP</label>
                            <div class="col-md-8">
                                <p class="form-control-static"><?php echo $data_pegawai['NIPNEW'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 pull-left">Pangkat / Gol. Ruang</label>
                            <div class="col-md-8">
                                <p class="form-control-static"><?php echo $data_pegawai['TRSTATUSKEPEGAWAIAN_ID'] == 1 ? $data_pegawai['PANGKAT'] . " (" . $data_pegawai['GOLONGAN'] . ")" : $data_pegawai['PANGKAT'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 pull-left">Jabatan</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="nama_pejabat_penilai"><?php echo $data_pegawai['N_JABATAN'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="text-center bg-blue bg-font-blue">PEJABAT PENILAI</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="text-center bg-green bg-font-green">ATASAN PEJABAT PENILAI</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 pull-left">NIP / NRP</label>
                            <div class="col-md-5">
                                <input type="text" name="nip_pejabat_penilai" id="field_cr_nip_pejabat_penilai" class="form-control" value="<?php echo isset($model) ? $model->NIP_PEJABAT_PENILAI : ''; ?>" placeholder="NIP / NRP" readonly="" />
                            </div>
                            <div class="col-md-1" style="text-align: left">
                                <a href="javascript:;" class="popuplarge btn btn-circle btn-icon-only yellow" title="Cari Pegawai" data-id="popuppilihpegawai" data-modal-title="Daftar Universitas" data-url="<?php echo site_url("daftar_pegawai/listpegawai") ?>"><i class="fa fa-group"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 pull-left">NIP / NRP</label>
                            <div class="col-md-5">
                                <input type="text" name="nip_atasan_pejabat_penilai" id="field_cr_nip_atasan_pejabat_penilai" class="form-control" value="<?php echo isset($model) ? $model->NIP_ATASAN_PEJABAT_PENILAI : ''; ?>" placeholder="NIP / NRP" readonly="" />
                            </div>
                            <div class="col-md-1" style="text-align: left">
                                <a href="javascript:;" class="popuplarge btn btn-circle btn-icon-only yellow" title="Cari Pegawai" data-id="" data-modal-title="Daftar Universitas" data-url="<?php echo site_url("daftar_pegawai/listpegawai") ?>"><i class="fa fa-group"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 pull-left">Nama</label>
                            <div class="col-md-8">
                                <?php $nama2 = isset($model) ? ((!empty($model->GELAR_DEPAN2)) ? $model->GELAR_DEPAN2 . " " : "") . ($model->NAMA2) . ((!empty($model->GELAR_BLKG2)) ? ", " . $model->GELAR_BLKG2 : '') : ''; ?>
                                <p class="form-control-static" id="nama_pejabat_penilai"><?= $nama2 ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 pull-left">Nama</label>
                            <div class="col-md-8">
                                <?php $nama3 = isset($model) ? ((!empty($model->GELAR_DEPAN3)) ? $model->GELAR_DEPAN3 . " " : "") . ($model->NAMA3) . ((!empty($model->GELAR_BLKG3)) ? ", " . $model->GELAR_BLKG3 : '') : ''; ?>
                                <p class="form-control-static" id="nama_atasan_pejabat_penilai"><?= $nama3 ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 pull-left">Pangkat / Gol. Ruang</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="pangkatgol_pejabat_penilai"><?php echo isset($model) ? $model->PANGKAT_PEJABAT_PENILAI . " (" . $model->GOLONGAN_PEJABAT_PENILAI . ")" : ''; ?></p>
                                <input type="hidden" name="pangkatgol_pejabat_penilai_input" value="<?php echo isset($model) ? $model->PANGKAT_PEJABAT_PENILAI . " (" . $model->GOLONGAN_PEJABAT_PENILAI . ")" : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 pull-left">Pangkat / Gol. Ruang</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="pangkatgol_atasan_pejabat_penilai"><?php echo isset($model) ? $model->PANGKAT_ATASAN_PEJABAT_PENILAI . " (" . $model->GOLONGAN_ATASAN_PJBT_PENILAI . ")" : ''; ?></p>
                                <input type="hidden" name="pangkatgol_atasan_pejabat_penilai_input" value="<?php echo isset($model) ? $model->PANGKAT_ATASAN_PEJABAT_PENILAI . " (" . $model->GOLONGAN_ATASAN_PJBT_PENILAI . ")" : ''; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 pull-left">Jabatan</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="jabatan_pejabat_penilai"><?php echo isset($model) ? $model->JABATAN_PEJABAT_PENILAI : ''; ?></p>
                                <input type="hidden" name="jabatan_pejabat_penilai_input" value="<?php echo isset($model) ? $model->JABATAN_PEJABAT_PENILAI : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 pull-left">Jabatan</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="jabatan_atasan_pejabat_penilai"><?php echo isset($model) ? $model->JABATAN_ATASAN_PJBT_PENILAI : ''; ?></p>
                                <input type="hidden" name="jabatan_atasan_pejabat_penilai_input" value="<?php echo isset($model) ? $model->JABATAN_ATASAN_PJBT_PENILAI : ''; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <!--/row-->

                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">Kegiatan Dan Penilaian SKP</div>
                            </div>
                            <div class="portlet-body">
                                <div class="tabbable-custom nav-justified">
                                    <ul class="nav nav-tabs nav-justified">
                                        <li class="active">
                                            <a href="#tab_1_1_1" data-toggle="tab"> SKP </a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_1_2" data-toggle="tab"> Penilaian Kerja </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" style="overflow-x: scroll">
                                        <div class="tab-pane active" id="tab_1_1_1" style="width: 1500px;">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="vertical-align: middle;text-align: center;width:4%">Aksi</th>
                                                        <th rowspan="2" style="vertical-align: middle;text-align: center;width:3%">No</th>
                                                        <th rowspan="2" style="vertical-align: middle;text-align: center;width:20%">Kegiatan Tugas Pokok Jabatan</th>
                                                        <th rowspan="2" style="vertical-align: middle;text-align: center;width:7%">AK</th>
                                                        <th colspan="4" style="vertical-align: middle;text-align: center;">Target</th>
                                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">AK</th>
                                                        <th colspan="4" style="vertical-align: middle;text-align: center;">Realisasi</th>
                                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Perhitungan</th>
                                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Nilai Capaian SKP</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="vertical-align: middle;text-align: center;width: 10%">Kuantitas/<br />Output</th>
                                                        <th style="vertical-align: middle;text-align: center;width: 10%">Kualitas/<br />Mutu</th>
                                                        <th style="vertical-align: middle;text-align: center;width:10%">Waktu</th>
                                                        <th style="vertical-align: middle;text-align: center;width:10%">Biaya</th>
                                                        <th style="vertical-align: middle;text-align: center;width:450px !important">Kuantitas/<br />Output</th>
                                                        <th style="vertical-align: middle;text-align: center;width:450px !important">Kualitas/<br />Mutu</th>
                                                        <th style="vertical-align: middle;text-align: center;width:450px !important">Waktu</th>
                                                        <th style="vertical-align: middle;text-align: center;width:450px !important">Biaya</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">0</th>
                                                        <th class="text-center">1</th>
                                                        <th class="text-center">2</th>
                                                        <th class="text-center">3</th>
                                                        <th class="text-center">4</th>
                                                        <th class="text-center">5</th>
                                                        <th class="text-center">6</th>
                                                        <th class="text-center">7</th>
                                                        <th class="text-center">8</th>
                                                        <th class="text-center">9</th>
                                                        <th class="text-center">10</th>
                                                        <th class="text-center">11</th>
                                                        <th class="text-center">12</th>
                                                        <th class="text-center">13</th>
                                                        <th class="text-center">14</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="15">&nbsp;UNSUR UTAMA</td>
                                                    </tr>
                                                    <?php if ($utama): ?>
                                                        <?php
                                                        $k = 0;
                                                        foreach ($utama['utama_pokok'] as $val):
                                                            ?>
                                                            <tr class="center">
                                                                <td>
                                                                    <a href="javascript:void(0)" class="utama_" name="tambah data" title="tambah data" id="create_data_detail">
                                                                        <img border="0" src="<?php echo base_url(); ?>/assets/img/create.png">
                                                                    </a>
                                                                </td>
                                                                <td><?php echo $k+1; ?></td>
                                                                <td>
                                                                    <textarea placeholder="Kegiatan Tugas Pokok Jabatan" class="form-control" id="utama_pokok[0]" name="utama_pokok[0]"><?php echo $val['TEXT_ARRAY']; ?></textarea>
                                                                </td>
                                                                <td>
                                                                    <input onkeypress="return decimalonly(event)" type="text" size="2" placeholder="AK" id="utama_ak[0]" value="<?php echo isset($utama['utama_ak'][$k]) ? $utama['utama_ak'][$k]['NUMERIC_ARRAY'] : '' ?>" class="form-control" name="utama_ak[0]" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" onkeypress="return decimalonly(event)" size="5" placeholder="Kuantitas" style="display: inline" class="form-control" id="utama_kuantitas[0]" value="<?php echo isset($utama['utama_kuantitas'][$k]) ? $utama['utama_kuantitas'][$k]['INTEGER_ARRAY'] : '' ?>" name="utama_kuantitas[0]" />
                                                                    <select class="utama_satuan_0 form-control" style="display: inline" name="utama_satuan[0]" id="utama_satuan[0]">
                                                                        <?php foreach ($list_satuan_skp as $value): ?>
                                                                            <?php
                                                                            $selec = '';
                                                                            if (isset($utama['utama_satuan'][$k]) && $utama['utama_satuan'][$k]['INTEGER_ARRAY'] == $value['ID'])
                                                                                $selec = 'selected=""';
                                                                            ?>
                                                                            <option <?php echo $selec; ?> value="<?php echo $value['ID'] ?>"><?php echo $value['NAMA'] ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" size="5" onkeypress="return decimalonly(event)" placeholder="Kualitas" id="utama_kualitas[0]" class="form-control" name="utama_kualitas[0]" value="<?php echo isset($utama['utama_kualitas'][$k]) ? $utama['utama_kualitas'][$k]['INTEGER_ARRAY'] : '' ?>" />
                                                                </td>
                                                                <td>
                                                                    <select class="utama_waktu_0 form-control" id="utama_waktu[0]" name="utama_waktu[0]">
                                                                        <?php foreach ($arraybulan as $key => $isi): ?>
                                                                            <?php
                                                                            $selec = '';
                                                                            if (isset($utama['utama_waktu'][$k]) && $utama['utama_waktu'][$k]['INTEGER_ARRAY'] == $key)
                                                                                $selec = 'selected=""';
                                                                            ?>
                                                                            <option <?php echo $selec; ?> value="<?php echo $key ?>"><?php echo $isi ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" size="5" class="form-control" onkeypress="return decimalonly(event)" placeholder="Biaya" id="utama_biaya[0]" name="utama_biaya[0]" value="<?php echo isset($utama['utama_biaya'][$k]) ? $utama['utama_biaya'][$k]['INTEGER_ARRAY'] : '' ?>" />
                                                                </td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                            <?php
                                                            $k++;
                                                        endforeach;
                                                        ?>
                                                    <?php else: ?>
                                                        <tr class="center">
                                                            <td>
                                                                <a href="javascript:void(0)" class="utama_" name="tambah data" title="tambah data" id="create_data_detail">
                                                                    <img border="0" src="<?php echo base_url(); ?>/assets/img/create.png">
                                                                </a>
                                                            </td>
                                                            <td>1</td>
                                                            <td>
                                                                <textarea placeholder="Kegiatan Tugas Pokok Jabatan" class="form-control" id="utama_pokok[0]" name="utama_pokok[0]"></textarea>
                                                            </td>
                                                            <td>
                                                                <input onkeypress="return decimalonly(event)" type="text" size="2" placeholder="AK" id="utama_ak[0]" class="form-control" name="utama_ak[0]" />
                                                            </td>
                                                            <td>
                                                                <input type="text" onkeypress="return decimalonly(event)" size="5" placeholder="Kuantitas" style="display: inline" class="form-control" id="utama_kuantitas[0]" name="utama_kuantitas[0]" />
                                                                <select class="utama_satuan_0 form-control" style="display: inline" name="utama_satuan[0]" id="utama_satuan[0]">
                                                                    <?php foreach ($list_satuan_skp as $value): ?>
                                                                        <option value="<?php echo $value['ID'] ?>"><?php echo $value['NAMA'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" size="5" onkeypress="return decimalonly(event)" placeholder="Kualitas" id="utama_kualitas[0]" class="form-control" name="utama_kualitas[0]" />
                                                            </td>
                                                            <td>
                                                                <select class="utama_waktu_0 form-control" id="utama_waktu[0]" name="utama_waktu[0]">
                                                                    <option value="1">1 Bulan</option>
                                                                    <option value="2">2 Bulan</option>
                                                                    <option value="3">3 Bulan</option>
                                                                    <option value="4">4 Bulan</option>
                                                                    <option value="5">5 Bulan</option>
                                                                    <option value="6">6 Bulan</option>
                                                                    <option value="7">7 Bulan</option>
                                                                    <option value="8">8 Bulan</option>
                                                                    <option value="9">9 Bulan</option>
                                                                    <option value="10">10 Bulan</option>
                                                                    <option value="11">11 Bulan</option>
                                                                    <option value="12">12 Bulan</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" size="5" class="form-control" onkeypress="return decimalonly(event)" placeholder="Biaya" id="utama_biaya[0]" name="utama_biaya[0]" />
                                                            </td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <tr id="acuan_utama_">
                                                        <td colspan="15">&nbsp;UNSUR TUGAS TAMBAHAN</td>
                                                    </tr>
                                                    <?php if ($tambahan): ?>
                                                        <?php
                                                        $k = 1;
                                                        foreach ($tambahan as $val):
                                                            ?>
                                                            <tr class="center">
                                                                <td>
                                                                    <a href="javascript:void(0)" class="tambahan_" name="tambah data" title="tambah data" id="create_data_detail">
                                                                        <img border="0" src="<?php echo base_url(); ?>/assets/img/create.png" />
                                                                    </a>
                                                                </td>
                                                                <td><?php echo $k ?></td>
                                                                <td>
                                                                    <textarea placeholder="Kegiatan Tugas Pokok Jabatan" class="form-control" id="tambahan_pokok[0]" name="tambahan_pokok[0]"><?php echo $val['TEXT_ARRAY']; ?></textarea>
                                                                </td>
                                                                <td>&nbsp;</td>
                                                                <td colspan="4">&minus;</td>
                                                                <td>&nbsp;</td>
                                                                <td colspan="4">&minus;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        <?php $k++;endforeach; ?>
                                                    <?php else: ?>
                                                        <tr class="center">
                                                            <td>
                                                                <a href="javascript:void(0)" class="tambahan_" name="tambah data" title="tambah data" id="create_data_detail">
                                                                    <img border="0" src="<?php echo base_url(); ?>/assets/img/create.png">
                                                                </a>
                                                            </td>
                                                            <td>1</td>
                                                            <td>
                                                                <textarea placeholder="Kegiatan Tugas Pokok Jabatan" class="form-control" id="tambahan_pokok[0]" name="tambahan_pokok[0]"></textarea>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                            <td colspan="4">&minus;</td>
                                                            <td>&nbsp;</td>
                                                            <td colspan="4">&minus;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <tr id="acuan_tambahan_">
                                                        <td colspan="15">&nbsp;UNSUR KREATIVITAS</td>
                                                    </tr>
                                                    <?php if ($kreativitas): ?>
                                                        <?php
                                                        $k = 1;
                                                        foreach ($kreativitas as $val):
                                                            ?>
                                                            <tr class="center">
                                                                <td>
                                                                    <a href="javascript:void(0)" class="kreativitas_" name="tambah data" title="tambah data" id="create_data_detail">
                                                                        <img border="0" src="<?php echo base_url(); ?>/assets/img/create.png" />
                                                                    </a>
                                                                </td>
                                                                <td><?php echo $k ?></td>
                                                                <td>
                                                                    <textarea placeholder="Kegiatan Tugas Pokok Jabatan" id="kreativitas_pokok[0]" class="form-control" name="kreativitas_pokok[0]"><?php echo $val['TEXT_ARRAY']; ?></textarea>
                                                                </td>
                                                                <td>&nbsp;</td>
                                                                <td colspan="4">&minus;</td>
                                                                <td>&nbsp;</td>
                                                                <td colspan="4">&minus;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        <?php $k++;endforeach; ?>
                                                    <?php else: ?>
                                                        <tr class="center">
                                                            <td>
                                                                <a href="javascript:void(0)" class="kreativitas_" name="tambah data" title="tambah data" id="create_data_detail">
                                                                    <img border="0" src="<?php echo base_url(); ?>/assets/img/create.png">
                                                                </a>
                                                            </td>
                                                            <td>1</td>
                                                            <td>
                                                                <textarea placeholder="Kegiatan Tugas Pokok Jabatan" id="kreativitas_pokok[0]" class="form-control" name="kreativitas_pokok[0]"></textarea>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                            <td colspan="4">&minus;</td>
                                                            <td>&nbsp;</td>
                                                            <td colspan="4">&minus;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <tr id="acuan_kreativitas_">
                                                        <td colspan="15">&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tab_1_1_2">
                                            <table style="width: 100%" class="table table-bordered table-hover">
                                                <colgroup>
                                                    <col style="width: 10%" />
                                                    <col style="width: 45%" />
                                                    <col style="width: 15%" />
                                                    <col style="width: 15%" />
                                                    <col style="width: 15%" />
                                                </colgroup>
                                                <thead>
                                                    <tr>
                                                        <th colspan="4" style="vertical-align: middle;text-align: center;">UNSUR YANG DINILAI</th>
                                                        <th style="vertical-align: middle;text-align: center;">JUMLAH</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="4">Sasaran Kerja PNS (SKP) </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="9">Perilaku Kerja</td>
                                                        <td>1.&nbsp;Orientasi Pelayanan</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2.&nbsp;Integritas</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3.&nbsp;Komitmen</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4.&nbsp;Disiplin</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5.&nbsp;Kerjasama</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>6.&nbsp;Kepemimpinan</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>7.&nbsp;Jumlah</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>8.&nbsp;Nilai rata - rata</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>9.&nbsp;Nilai perilaku kerja</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="center" colspan="4">&nbsp;Nilai Prestasi Kerja</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="pull-left">
                    <button type="button" class="btn default btnbatalformcu"><i class="fa fa-close"></i> Batal</button>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-warning btn-circle"><i class="fa fa-check"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
            <!-- END FORM-->
        </div>
    </div>
</div>