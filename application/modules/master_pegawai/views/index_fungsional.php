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
                                    <a href="javascript:;">Fungsional</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <span><?= $title_utama; ?></span>
                                </li>
                            </ul>
                            <!-- END PAGE BREADCRUMBS -->
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
                        <?php if ($this->session->get_userdata()['idgroup'] != 3) { ?>
                        <div class="page-toolbar">
                            <!-- BEGIN THEME PANEL -->
                            <div class="btn-group btn-theme-panel">
                                <a href="javascript:;" class="btn dropdown-toggle" id="expandDropDown">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </div>
                            <!-- END THEME PANEL -->
                        </div>
                        <?php } ?>
                        <!-- END PAGE TOOLBAR -->
                    </div>
                </div>
                <div class="drop-row" id="qualitySelectorDrop">
                    <div class="drop-search">
                        <div class="container-fluid">
                            <form action="javascript:;" class="formfilter">
                                <h3>Pencarian Data</h3>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="NIP Lama / NIP Baru" id="search_nip" class="form-control" value="" placeholder="NIP" />
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="Nama Pegawai" id="search_nama" class="form-control" value="" placeholder="Nama Pegawai" />
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="trlokasi_id" id="search_lokasi_id" class="form-control" style="width: 100%">
                                                <option value="">- Pilih Lokasi Kerja -</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="statuskepeg_id" id="search_statuskepeg_id" class="form-control" style="width: 100%">
                                                <option value="">- Pilih Status Kepegawaian -</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="diklatpim_id" id="search_diklatpim_id" class="form-control" style="width: 100%">
                                                <option value="">- Pilih Diklat PIM -</option>
                                                <?php if ($list_tingkat_diklat_kepemimpinan_filter): ?>
                                                    <?php foreach ($list_tingkat_diklat_kepemimpinan_filter as $val): ?>
                                                        <option value="<?php echo $val['ID'] ?>"><?php echo $val['NAMA'] ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="kdu1_id" id="search_kdu1_id" class="form-control" style="width: 100%">
                                                <option value="">- Pilih Jabatan Pimpinan Tinggi Madya -</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="gol_id" id="search_gol_id" class="form-control" style="width: 100%">
                                                <option value="">- Pilih Golongan -</option>
                                                <?php if ($list_golongan_pangkat_filter): ?>
                                                    <?php foreach ($list_golongan_pangkat_filter as $val): ?>
                                                        <option value="<?php echo $val['ID'] ?>"><?php echo $val['NAMA'] ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="status_nikah_id" id="search_status_nikah_id" class="form-control" style="width: 100%">
                                                <option value="">- Pilih Status Pernikahan -</option>
                                                <?php if ($list_sts_nikah_filter): ?>
                                                    <?php foreach ($list_sts_nikah_filter as $val): ?>
                                                        <option value="<?php echo $val['ID'] ?>"><?php echo $val['NAMA'] ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="kdu2_id" id="search_kdu2_id" class="form-control" style="width: 100%">
                                                <option value="">- Pilih Jabatan Pimpinan Tinggi Madya -</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="pendidikan_id" id="search_pendidikan_id" class="form-control" style="width: 100%">
                                                <option value="">- Pilih Pendidikan -</option>
                                                <?php if ($list_pendidikan_filter): ?>
                                                    <?php foreach ($list_pendidikan_filter as $val): ?>
                                                        <option value="<?php echo $val['ID'] ?>"><?php echo $val['NAMA'] ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="jk_id" id="search_jk_id" class="form-control" style="width: 100%">
                                                <option value="">- Pilih Jenis Kelamin -</option>
                                                <?php if ($list_jk_filter): ?>
                                                    <?php foreach ($list_jk_filter as $val): ?>
                                                        <option value="<?php echo $val['ID'] ?>"><?php echo $val['NAMA'] ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="kdu3_id" id="search_kdu3_id" class="form-control" style="width: 100%">
                                                <option value="">- Pilih Jabatan Administrator -</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="kel_fung_id" id="search_kel_fung_id" class="form-control" style="width: 100%">
                                                <option value="">- Pilih Kelompok Fungsional -</option>
                                                <?php if ($list_kelompok_fungsional_filter): ?>
                                                    <?php foreach ($list_kelompok_fungsional_filter as $val): ?>
                                                        <option value="<?php echo $val['ID'] ?>"><?php echo $val['NAMA'] ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">&nbsp;</div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="kdu4_id" id="search_kdu4_id" class="form-control" style="width: 100%">
                                                <option value="">- Pilih Pengawas -</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">&nbsp;</div>
                                    <div class="col-md-4">
                                        <div class="form-group" style="display: none">
                                            <div class="md-checkbox-list">
                                                <div class="md-checkbox">
                                                    <input type="checkbox" id="search_pegawaibaru" class="md-check">
                                                    <label for="search_pegawaibaru">
                                                        <span class="inc"></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Pegawai Baru 
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="kdu5_id" id="search_kdu5_id" class="form-control" style="width: 100%">
                                                <option value="">- Pilih Pelaksana (Eselon V) -</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">&nbsp;</div>
                                <div class="row">
                                    <div class="col-xs-6 align-left">
                                        <button type="reset" class="btnsearchno btn default">Batal</button>
                                    </div>
                                    <div class="col-xs-6 align-right">
                                        <button type="submit" class="btnsearchyes btn blue-madison">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END PAGE HEAD-->
                <!-- BEGIN PAGE CONTENT BODY -->
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="page-content-inner-detail" style="display: none"></div>
                        
                        <div class="page-content-inner">
                            <?php $this->load->view('master_pegawai/listpegawai_fungsional'); ?>
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