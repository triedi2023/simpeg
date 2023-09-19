<div class="page-wrapper-row full-height">
    <div class="page-wrapper-middle">
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <!-- BEGIN PAGE HEAD-->
                <div class="page-head" style="line-height: 1">
                    <div class="container-fluid">
                        <!-- BEGIN PAGE TITLE -->
                        <div class="page-title">
                            <!-- BEGIN PAGE BREADCRUMBS -->
                            <ul class="page-breadcrumb breadcrumb">
                                <li>
                                    <a href="javascript:;">Beranda</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <a href="javascript:;">Laporan</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <span><?= $title_utama; ?></span>
                                </li>
                            </ul>
                            <!-- END PAGE BREADCRUMBS -->
                        </div>
                        <!-- END PAGE TITLE -->
                    </div>
                </div>
                <!-- END PAGE HEAD-->
                <!-- BEGIN PAGE CONTENT BODY -->
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="page-content-inner">
                            <div id="parameterpencarian" class="m-heading-1 border-green m-bordered">
                                <h3>Parameter</h3>
                                <div class="form">
                                    <form action="javascript:;" class="form-horizontal form-row-seperated" id="formpencarian" data-url="<?php echo site_url("laporan_serbaguna/pencarian_proses") ?>">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Judul Laporan</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="judul" id="judul" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="display: none">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Awal Data</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" value="1" name="awal_data" id="awal_data" />
                                                    </div>
                                                    <label class="control-label col-md-1" style="text-align: left">Akhir Data</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="halaman" value="<?php echo $jmlpegawai ?>" id="halaman" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Nama</label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="nama" id="nama" />
                                                        <span class="help-block"> Pisah Dengan Koma (,) </span>
                                                    </div>
                                                    <label class="control-label col-md-1">NIP</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="nip" id="nip" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Jenis Kelamin</label>
                                                    <div class="col-md-3">
                                                        <select name="sex" id="sex" class="form-control" style="width: 100%">
                                                            <option value="">- Pilih -</option>
                                                            <?php if (isset($list_jk)): ?>
                                                                <?php foreach ($list_jk as $val): ?>
                                                                    <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>
                                                    <label class="col-md-1 control-label" style="text-align: left">Gol. Darah</label>
                                                    <div class="col-md-4">
                                                        <div class="mt-checkbox-inline">
                                                            <?php if ($list_gol_darah): ?>
                                                                <?php foreach ($list_gol_darah as $val): ?>
                                                                    <label class="mt-checkbox mt-checkbox-outline">
                                                                        <input type="checkbox" id="gol_darah" name="gol_darah" value="<?= $val['ID'] ?>" /> <?= $val['NAMA'] ?>
                                                                        <span></span>
                                                                    </label>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">CPNS</label>
                                                    <div class="col-md-2">
                                                        <select name="bulan_cpns" id="bulan_cpns" class="form-control" style="width: 100%">
                                                            <option value="">- Bulan -</option>
                                                            <?php if (isset($list_bulan)): ?>
                                                                <?php foreach ($list_bulan as $val): ?>
                                                                    <option value="<?= $val['kode'] ?>"><?= $val['nama'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>
                                                    <label class="control-label col-md-1">Tahun</label>
                                                    <div class="col-md-1">
                                                        <input type="text" class="form-control" maxlength="4" name="tahun_cpns" placeholder="YYYY" id="tahun_cpns" />
                                                    </div>
                                                    <label class="control-label col-md-1">SK</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="skcpns" placeholder="Nomor SK CPNS" id="skcpns" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="display: none">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">PNS</label>
                                                    <div class="col-md-2">
                                                        <select name="bulan_pns" id="bulan_pns" class="form-control" style="width: 100%">
                                                            <option value="">- Bulan -</option>
                                                            <?php if (isset($list_bulan)): ?>
                                                                <?php foreach ($list_bulan as $val): ?>
                                                                    <option value="<?= $val['kode'] ?>"><?= $val['nama'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>
                                                    <label class="control-label col-md-1">Tahun</label>
                                                    <div class="col-md-1">
                                                        <input type="text" class="form-control" maxlength="4" name="tahun_pns" placeholder="YYYY" id="tahun_pns" />
                                                    </div>
                                                    <label class="control-label col-md-1">SK</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="skpns" placeholder="Nomor SK PNS" id="skpns" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Agama</label>
                                                    <div class="col-md-9">
                                                        <div class="mt-checkbox-inline">
                                                            <?php if ($list_agama): ?>
                                                                <?php foreach ($list_agama as $val): ?>
                                                                    <label class="mt-checkbox mt-checkbox-outline">
                                                                        <input type="checkbox" id="agama" name="agama" value="<?= $val['ID'] ?>" /> <?= $val['NAMA'] ?>
                                                                        <span></span>
                                                                    </label>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Pendidikan Terakhir</label>
                                                    <div class="col-md-9">
                                                        <div class="mt-checkbox-inline">
                                                            <?php if ($list_pendidikan): ?>
                                                                <?php foreach ($list_pendidikan as $val): ?>
                                                                    <label class="mt-checkbox mt-checkbox-outline">
                                                                        <input type="checkbox" id="pend_terakhir" name="pend_terakhir" value="<?= $val['ID'] ?>" /> <?= $val['NAMA'] ?>
                                                                        <span></span>
                                                                    </label>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Lbg.pendidikan / Fakultas / Jurusan</label>
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <input id="lbg_pendk" class="form-control" name="lbg_pendk" type="hidden" size="10" />
                                                                <input type="text" name="nm_pendk" maxlength="255" id="nm_pendk" class="form-control" readonly="" placeholder="Nama Lembaga" />
                                                            </div>
                                                            <div class="col-md-1" style="text-align: left;width: 5.3%">
                                                                <a href="javascript:;" class="popuplarge btn btn-circle btn-icon-only yellow" title="Cari Universitas" data-modal-title="Daftar Universitas" data-url="<?php echo site_url("daftar_universitas/listuniversitas") ?>"><i class="fa fa-university"></i></a>
                                                            </div>
                                                            <div class="col-md-2" style="width: 22%">
                                                                <select name="fak" id="fak" class="form-control" style="width: 100%">
                                                                    <option value="">- Fakultas -</option>
                                                                    <?php if (isset($list_fakultas)): ?>
                                                                        <?php foreach ($list_fakultas as $val): ?>
                                                                            <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input id="jurpdk" class="form-control" name="jurpdk" type="hidden" />
                                                                <input type="text" name="nama_jurpdk" maxlength="255" id="nama_jurpdk" class="form-control" readonly="" placeholder="Nama Jurusan" />
                                                            </div>
                                                            <div class="col-md-1 pull-right" style="text-align: left;width: 5.3%;">
                                                                <a href="javascript:;" class="popuplarge btn btn-circle btn-icon-only yellow" title="Cari Jurusan" data-modal-title="Daftar Jurusan" data-url="<?php echo site_url("daftar_jurusan/listjurusan") ?>"><i class="fa fa-university"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Tahun Kelulusan Pend.terakhir	</label>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" maxlength="4" placeholder="YYYY" name="thn_pend_akhir" id="thn_pend_akhir" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Eselon</label>
                                                    <div class="col-md-9">
                                                        <div class="mt-checkbox-inline">
                                                            <?php if ($list_eselon): ?>
                                                                <?php foreach ($list_eselon as $val): ?>
                                                                    <label class="mt-checkbox mt-checkbox-outline">
                                                                        <input type="checkbox" id="eselon" name="eselon" value="<?= $val['ID'] ?>" /> <?= $val['NAMA'] ?>
                                                                        <span></span>
                                                                    </label>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">TMT Eselon</label>
                                                    <div class="col-md-2">    
                                                        <input type="text" class="form-control" placeholder="DD/MM/YYYY" id="tmt_eselon" name="tmt_eselon" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Jenis (Diklat Teknis)</label>
                                                    <div class="col-md-2">
                                                        <select name="kode_diklat_teknis" id="kode_diklat_teknis" class="form-control" style="width: 100%">
                                                            <option value="">- Pilih -</option>
                                                            <?php if (isset($list_kelompok_diklat_teknis)): ?>
                                                                <?php foreach ($list_kelompok_diklat_teknis as $val): ?>
                                                                    <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>
                                                    <label class="col-md-2 control-label" style="text-align: left;width: 9%;vertical-align: middle">Kelompok</label>
                                                    <div class="col-md-2">
                                                        <select name="nama_diklat_teknis" id="nama_diklat_teknis" class="form-control" style="width: 100%">
                                                            <option value="">- Pilih -</option>
                                                            <?php if (isset($list_diklat_teknis)): ?>
                                                                <?php foreach ($list_diklat_teknis as $val): ?>
                                                                    <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>
                                                    <label class="col-md-1 control-label" style="text-align: left;width: 9%;vertical-align: middle">Nama</label>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" placeholder="Diklat Teknis" id="ket_diklat_teknis" name="ket_diklat_teknis" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Nama Diklat Lain</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="diklatlainlain" maxlength="255" id="diklatlainlain" class="form-control" placeholder="Nama Diklat Lain" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Pangkat Terakhir</label>
                                                    <div class="col-md-9">
                                                        <div class="mt-checkbox-inline">
                                                            <?php if ($list_golongan_pangkat): ?>
                                                                <?php foreach ($list_golongan_pangkat as $val): ?>
                                                                    <label class="mt-checkbox mt-checkbox-outline">
                                                                        <input type="checkbox" id="pgkt_pns" name="pgkt_pns" value="<?= $val['ID'] ?>" /> <?= $val['NAMA'] ?>
                                                                        <span></span>
                                                                    </label>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">TMT Golongan</label>
                                                    <div class="col-md-2">    
                                                        <input type="text" class="form-control" placeholder="DD/MM/YYYY" id="tmt_gol" name="tmt_gol" value="" />
                                                    </div>
                                                    <label class="col-md-3 control-label">TMT Jabatan</label>
                                                    <div class="col-md-2">    
                                                        <input type="text" class="form-control" placeholder="DD/MM/YYYY" id="tmt_jabatan" name="tmt_jabatan" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Diklat PIM.terakhir</label>
                                                    <div class="col-md-9">
                                                        <div class="mt-checkbox-inline">
                                                            <?php if ($list_tingkat_diklat_kepemimpinan): ?>
                                                                <?php foreach ($list_tingkat_diklat_kepemimpinan as $val): ?>
                                                                    <label class="mt-checkbox mt-checkbox-outline">
                                                                        <input type="checkbox" id="dik_pim_akhir" name="dik_pim_akhir" value="<?= $val['ID'] ?>" /> <?= $val['NAMA'] ?>
                                                                        <span></span>
                                                                    </label>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Tahun Diklat pim.terakhir</label>
                                                    <div class="col-md-2">
                                                        <input type="text" name="thn_diklat_pim" maxlength="4" id="thn_diklat_pim" class="form-control" placeholder="YYYY" />
                                                    </div>
                                                    <label class="col-md-3 control-label">Provinsi Unit Kerja</label>
                                                    <div class="col-md-3">
                                                        <select name="prov_unit_kerja" id="prov_unit_kerja" class="form-control" style="width: 100%">
                                                            <option value="">- Pilih -</option>
                                                            <?php if (isset($list_provinsi)): ?>
                                                                <?php foreach ($list_provinsi as $val): ?>
                                                                    <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
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
                                                    <label class="col-md-3 control-label">Jabatan</label>
                                                    <div class="col-md-3">
                                                        <select name="jabatan" id="jabatan" class="form-control" style="width: 100%">
                                                            <option value="">- Pilih -</option>
                                                            <?php if (isset($list_jabatan)): ?>
                                                                <?php foreach ($list_jabatan as $val): ?>
                                                                    <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>
                                                    <label class="col-md-3 control-label">Kelompok Fungsional</label>
                                                    <div class="col-md-3">
                                                        <select name="kelfung_serbaguna" id="kelfung_serbaguna" class="form-control" style="width: 100%">
                                                            <option value="">- Pilih -</option>
                                                            <?php if (isset($list_kelompok_fungsional)): ?>
                                                                <?php foreach ($list_kelompok_fungsional as $val): ?>
                                                                    <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
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
                                                    <label class="col-md-3 control-label">Status Perkawinan</label>
                                                    <div class="col-md-4">
                                                        <div class="mt-checkbox-inline">
                                                            <?php if ($list_sts_nikah): ?>
                                                                <?php foreach ($list_sts_nikah as $val): ?>
                                                                    <label class="mt-checkbox mt-checkbox-outline">
                                                                        <input type="checkbox" id="sts_nikah" name="sts_nikah" value="<?= $val['ID'] ?>" /> <?= $val['NAMA'] ?>
                                                                        <span></span>
                                                                    </label>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <label class="col-md-2 control-label" style="width: 10%">Tanggal Lahir</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" placeholder="DD/MM/YYYY" id="tgl_lahir" name="tgl_lahir" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Usia</label>
                                                    <div class="col-md-1">
                                                        <input type="text" name="usia1" id="usia1" class="form-control" />
                                                    </div>
                                                    <label class="col-md-1 control-label" style="padding-left: 2px;text-align: left;width: 2%">S/D</label>
                                                    <div class="col-md-1">
                                                        <input type="text" name="usia2" id="usia2" class="form-control" />
                                                    </div>
                                                    <label class="col-md-2 control-label" style="width: 10%">Range</label>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" placeholder="DD/MM/YYYY" id="range_tgl_lahir_1" name="range_tgl_lahir_1" value="" />
                                                    </div>
                                                    <label class="col-md-1 control-label" style="padding-left: 2px;text-align: left;width: 2%">S/D</label>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" placeholder="DD/MM/YYYY" id="range_tgl_lahir_2" name="range_tgl_lahir_2" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Provinsi Tempat lahir</label>
                                                    <div class="col-md-3">
                                                        <select name="xhr_prop_lahir" id="xhr_prop_lahir" class="form-control" style="width: 100%">
                                                            <option value="">- Pilih -</option>
                                                            <?php if (isset($list_provinsi)): ?>
                                                                <?php foreach ($list_provinsi as $val): ?>
                                                                    <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>
                                                    <label class="col-md-2 control-label">Kabupaten</label>
                                                    <div class="col-md-3">
                                                        <select name="receiver_kablahir" id="receiver_kablahir" class="form-control" style="width: 100%">
                                                            <option value="">- Pilih -</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Tlp / HP</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" placeholder="No Tlp / HP" id="tlp" name="tlp" value="" />
                                                    </div>
                                                    <label class="col-md-2 control-label">Kode Pos</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" placeholder="Kode Pos" id="tlp" name="pos" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Hobi</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" placeholder="Hobi" id="hobi" name="hobi" value="" />
                                                    </div>
                                                    <label class="col-md-2 control-label">Warna Kulit</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" placeholder="Warna Kulit" id="warna_kulit" name="warna_kulit" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">No.KARPEG</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" placeholder="No Karpeg" id="no_karpeg" name="no_karpeg" value="" />
                                                    </div>
                                                    <label class="col-md-2 control-label">No.ASKES</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" placeholder="No ASKES" id="no_askes" name="no_askes" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">No. TASPEN</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" placeholder="No TASPEN" id="no_taspen" name="no_taspen" value="" />
                                                    </div>
                                                    <label class="col-md-2 control-label">No. KTP</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" placeholder="No KTP" id="no_ktp" name="no_ktp" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="tabbable-custom nav-justified">
                                                    <ul class="nav nav-tabs nav-justified">
                                                        <li class="active">
                                                            <a href="#tab_1_1_1" data-toggle="tab" aria-expanded="true"> Unit Kerja </a>
                                                        </li>
                                                        <li class="">
                                                            <a href="#tab_1_1_2" data-toggle="tab" aria-expanded="false"> Riwayat Pendidikan </a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab_1_1_1">
                                                            <div class="form-body form-horizontal">
                                                                <?php $this->load->view('system/unitkerja_form-horizontal_filter'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="tab_1_1_2">
                                                            <div class="form-body form-horizontal">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-3">Tingkat</label>
                                                                            <div class="col-md-2">
                                                                                <select name="tktpdk" id="tktpdk" class="form-control" style="width: 100%">
                                                                                    <option value="">- Pilih -</option>
                                                                                    <?php if (isset($list_pendidikan)): ?>
                                                                                        <?php foreach ($list_pendidikan as $val): ?>
                                                                                            <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                                                        <?php endforeach ?>
                                                                                    <?php endif ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--/row-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Judul Kolom</label>
                                                    <div class="col-md-9">
                                                        <select multiple="multiple" class="multi-select" id="select1" name="select1">
                                                            <?php if ($colSelect): ?>
                                                                <?php foreach ($colSelect as $key => $val) { ?>
                                                                    <option value="<?= $key ?>"><?= $val ?></option>
                                                                <?php } ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn blue">Tampilkan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row hasilfilter" style="display: none"></div>
                        </div>
                        <!-- END PAGE CONTENT INNER -->
                    </div>
                </div>
                <!-- END PAGE CONTENT BODY -->
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
    </div>
</div>