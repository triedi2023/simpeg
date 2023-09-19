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
                                <?php // if ($this->session->get_userdata()['idgroup'] != 3) { ?>
                                    <li>
                                        <a href="javascript:;">Beranda</a>
                                        <i class="fa fa-angle-right"></i>
                                    </li>
                                <?php // } ?>
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
                        <div class="page-content-inner-list">
                            <div class="row">
                                <div class="container-fluid">
                                    <form action="<?php echo site_url('integrasi_bkn/proses'); ?>" method="post">
                                        
                                        <?php if ($this->session->flashdata('pesan')) { ?>
                                            <?php echo $this->session->flashdata('pesan'); ?>
                                        <?php } ?>
                                        
                                        <div class="row">
                                            <div class="col-md-3"><h3>Data Pokok Simpeg</h3></div>
                                            <div class="col-md-3 text-right"><h3><button type="submit" value="toSimpeg" name="action" class="btn btn-sm green-meadow m-icon"> <i class="m-icon-swapleft m-icon-white"></i> Migrasi Ke SIMPEG Dari BKN </button></h3></div>
                                            <div class="col-md-3"><!-- h3><button type="submit" value="toBkn" name="action" class="btn btn-sm red m-icon"> Migrasi Ke BKN Dari Simpeg <i class="m-icon-swapright m-icon-white"></i></button></h3 --></div>
                                            <div class="col-md-3 text-right"><h3>Data Pokok BKN</h3></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>NIP Lama</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['NIP'])?$simpeg['NIP']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['nipLama'])?$bkn['nipLama']:NULL; ?>" name="simpeg_nip_lama" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> NIP Lama
                                                            <input type="hidden" class="form-control" value="data_pokok" name="integrasi" />
                                                            <input type="hidden" class="form-control" value="<?php echo $simpeg['ID']; ?>" name="id_pegawai_simpeg" />
                                                            <input type="checkbox" class="form-control" value="nip_lama" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>NIP Lama</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['nipLama'])?$bkn['nipLama']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['NIP'])?$simpeg['NIP']:NULL; ?>" name="bkn_nip_lama" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>NIP Baru</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['NIPNEW'])?$simpeg['NIPNEW']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['nipBaru'])?$bkn['nipBaru']:NULL; ?>" name="simpeg_nip_baru" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> NIP Baru
                                                            <input type="checkbox" class="form-control" value="nip_baru" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>NIP Baru</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['nipBaru'])?$bkn['nipBaru']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['NIPNEW'])?$simpeg['NIPNEW']:NULL; ?>" name="bkn_nip_baru" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>ID BKN</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['ID_BKN'])?$simpeg['ID_BKN']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['id'])?$bkn['id']:NULL; ?>" name="simpeg_id_bkn" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> ID BKN
                                                            <input type="checkbox" class="form-control" value="id_bkn" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>ID BKN</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['id'])?$bkn['id']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['ID_BKN'])?$simpeg['ID_BKN']:NULL; ?>" name="bkn_id_bkn" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Gelar Depan</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['GELAR_DEPAN'])?$simpeg['GELAR_DEPAN']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['gelarDepan'])?$bkn['gelarDepan']:NULL; ?>" name="simpeg_gelar_depan" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> Gelar Depan
                                                            <input type="checkbox" class="form-control" value="gelar_depan" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Gelar Depan</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['gelarDepan'])?$bkn['gelarDepan']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['GELAR_DEPAN'])?$simpeg['GELAR_DEPAN']:NULL; ?>" name="bkn_gelar_depan" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['NAMA'])?$simpeg['NAMA']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['nama'])?$bkn['nama']:NULL; ?>" name="simpeg_nama" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> Nama
                                                            <input type="checkbox" class="form-control" value="nama" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['nama'])?$bkn['nama']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['NAMA'])?$simpeg['NAMA']:NULL; ?>" name="bkn_nama" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Gelar Belakang</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['GELAR_BLKG'])?$simpeg['GELAR_BLKG']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['gelarBelakang'])?$bkn['gelarBelakang']:NULL; ?>" name="simpeg_gelar_belakang" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> Gelar Belakang
                                                            <input type="checkbox" class="form-control" value="gelar_belakang" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Gelar Belakang</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['gelarBelakang'])?$bkn['gelarBelakang']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['GELAR_BLKG'])?$simpeg['GELAR_BLKG']:NULL; ?>" name="bkn_gelar_belakang" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tempat Lahir</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['TPTLAHIR'])?$simpeg['TPTLAHIR']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['tempatLahir'])?$bkn['tempatLahir']:NULL; ?>" name="simpeg_tempat_lahir" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> Tempat Lahir
                                                            <input type="checkbox" class="form-control" value="tempat_lahir" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tempat Lahir</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['tempatLahir'])?$bkn['tempatLahir']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['TPTLAHIR'])?$simpeg['TPTLAHIR']:NULL; ?>" name="bkn_tempat_lahir" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tanggal Lahir</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['TGLLAHIR2'])?$simpeg['TGLLAHIR2']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['tglLahir'])?$bkn['tglLahir']:NULL; ?>" name="simpeg_tanggal_lahir" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> Tanggal Lahir
                                                            <input type="checkbox" class="form-control" value="tanggal_lahir" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tanggal Lahir</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['tglLahir'])?$bkn['tglLahir']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['TGLLAHIR'])?$simpeg['TGLLAHIR']:NULL; ?>" name="bkn_tanggal_lahir" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Agama</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['TRAGAMA_ID'])?$daftar_agama[$simpeg['TRAGAMA_ID']]:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['agamaId'])?$bkn['agamaId']:NULL; ?>" name="simpeg_agama" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> Agama
                                                            <input type="checkbox" class="form-control" value="agama" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Agama</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['agama'])?$bkn['agama']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['TRAGAMA_ID'])?$simpeg['TRAGAMA_ID']:NULL; ?>" name="bkn_agama" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Jenis Kelamin</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['SEX'])?$this->config->item('daftar_jk')[$simpeg['SEX']]:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['jenisKelamin'])?$bkn['jenisKelamin']:NULL; ?>" name="simpeg_jk" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> Jenis Kelamin
                                                            <input type="checkbox" class="form-control" value="jk" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Jenis Kelamin</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['jenisKelamin'])?$bkn['jenisKelamin']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['SEX'])?$simpeg['SEX']:NULL; ?>" name="bkn_jk" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Status Perkawinan</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['TRSTATUSPERNIKAHAN_ID'])?$daftar_sts_nikah[$simpeg['TRSTATUSPERNIKAHAN_ID']]:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['jenisKawinId'])?$bkn['jenisKawinId']:NULL; ?>" name="simpeg_perkawinan" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> Status Perkawinan
                                                            <input type="checkbox" class="form-control" value="perkawinan" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Status Perkawinan</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['statusPerkawinan'])?$bkn['statusPerkawinan']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['TRSTATUSPERNIKAHAN_ID'])?$simpeg['TRSTATUSPERNIKAHAN_ID']:NULL; ?>" name="bkn_perkawinan" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['EMAIL'])?$simpeg['EMAIL']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['email'])?$bkn['email']:NULL; ?>" name="simpeg_email" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> Email
                                                            <input type="checkbox" class="form-control" value="email" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['email'])?$bkn['email']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['EMAIL'])?$simpeg['EMAIL']:NULL; ?>" name="bkn_email" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No HP</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['TELP_HP'])?$simpeg['TELP_HP']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['noHp'])?$bkn['noHp']:NULL; ?>" name="simpeg_no_hp" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> No HP
                                                            <input type="checkbox" class="form-control" value="no_hp" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No HP</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['noHp'])?$bkn['noHp']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['TELP_HP'])?$simpeg['TELP_HP']:NULL; ?>" name="bkn_no_hp" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No Telpon</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['TELP_RMH'])?$simpeg['TELP_RMH']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['noTelp'])?$bkn['noTelp']:NULL; ?>" name="simpeg_no_tlp" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> No Telpon
                                                            <input type="checkbox" class="form-control" value="no_tlp" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No Telpon</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['noTelp'])?$bkn['noTelp']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['TELP_RMH'])?$simpeg['TELP_RMH']:NULL; ?>" name="bkn_no_tlp" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>TMT CPNS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['TMT_CPNS2'])?$simpeg['TMT_CPNS2']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['tmtCpns'])?$bkn['tmtCpns']:NULL; ?>" name="simpeg_tmt_cpns" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> TMT CPNS
                                                            <input type="checkbox" class="form-control" value="tmt_cpns" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>TMT CPNS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['tmtCpns'])?$bkn['tmtCpns']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['TMT_CPNS2'])?$simpeg['TMT_CPNS2']:NULL; ?>" name="bkn_tmt_cpns" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No SK CPNS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['NO_SK_CPNS'])?$simpeg['NO_SK_CPNS']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['nomorSkCpns'])?$bkn['nomorSkCpns']:NULL; ?>" name="simpeg_no_sk_cpns" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> No SK CPNS
                                                            <input type="checkbox" class="form-control" value="no_sk_cpns" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No SK CPNS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['nomorSkCpns'])?$bkn['nomorSkCpns']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['NO_SK_CPNS'])?$simpeg['NO_SK_CPNS']:NULL; ?>" name="bkn_no_sk_cpns" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tgl SK CPNS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['TGL_SK_CPNS'])?$simpeg['TGL_SK_CPNS']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['tglSkCpns'])?$bkn['tglSkCpns']:NULL; ?>" name="simpeg_tgl_sk_cpns" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> Tgl SK CPNS
                                                            <input type="checkbox" class="form-control" value="tgl_sk_cpns" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tgl SK CPNS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['tglSkCpns'])?$bkn['tglSkCpns']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['TGL_SK_CPNS'])?$simpeg['TGL_SK_CPNS']:NULL; ?>" name="bkn_tgl_sk_cpns" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>MK Bulan</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['TGL_SK_CPNS'])?$simpeg['TGL_SK_CPNS']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['mkBulan'])?$bkn['mkBulan']:NULL; ?>" name="simpeg_mk_bulan" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> MK Bulan
                                                            <input type="checkbox" class="form-control" value="mk_bulan" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>MK Bulan</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['tglSkCpns'])?$bkn['tglSkCpns']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['TGL_SK_CPNS'])?$simpeg['TGL_SK_CPNS']:NULL; ?>" name="bkn_tgl_sk_cpns" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>TMT PNS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['TMT_PNS'])?$simpeg['TMT_PNS']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['tmtPns'])?$bkn['tmtPns']:NULL; ?>" name="simpeg_tmt_pns" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> TMT PNS
                                                            <input type="checkbox" class="form-control" value="tmt_pns" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>TMT PNS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['tmtPns'])?$bkn['tmtPns']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['TMT_PNS'])?$simpeg['TMT_PNS']:NULL; ?>" name="bkn_tmt_pns" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No SK PNS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['NO_SK_PNS'])?$simpeg['NO_SK_PNS']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['nomorSkPns'])?$bkn['nomorSkPns']:NULL; ?>" name="simpeg_no_sk_pns" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> No SK PNS
                                                            <input type="checkbox" class="form-control" value="no_sk_pns" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No SK PNS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['nomorSkPns'])?$bkn['nomorSkPns']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['NO_SK_PNS'])?$simpeg['NO_SK_PNS']:NULL; ?>" name="bkn_no_sk_pns" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tgl SK PNS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['TGL_SK_PNS'])?$simpeg['TGL_SK_PNS']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['tglSkPns'])?$bkn['tglSkPns']:NULL; ?>" name="simpeg_tgl_sk_pns" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> Tgl SK PNS
                                                            <input type="checkbox" class="form-control" value="tgl_sk_pns" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tgl SK PNS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['tglSkPns'])?$bkn['tglSkPns']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['TGL_SK_PNS'])?$simpeg['TGL_SK_PNS']:NULL; ?>" name="bkn_tgl_sk_pns" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No Surat Keterangan Dokter</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['NO_STLK'])?$simpeg['NO_STLK']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['noSuratKeteranganDokter'])?$bkn['noSuratKeteranganDokter']:NULL; ?>" name="simpeg_no_surat_dokter" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> No Surat
                                                            <input type="checkbox" class="form-control" value="no_surat_dokter" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No Surat Keterangan Dokter</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['noSuratKeteranganDokter'])?$bkn['noSuratKeteranganDokter']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['NO_STLK'])?$simpeg['NO_STLK']:NULL; ?>" name="bkn_no_surat_dokter" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tgl Surat Keterangan Dokter</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['TGL_STLK'])?$simpeg['TGL_STLK']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['tglSuratKeteranganDokter'])?$bkn['tglSuratKeteranganDokter']:NULL; ?>" name="simpeg_tgl_surat_dokter" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> Tgl Surat
                                                            <input type="checkbox" class="form-control" value="tgl_surat_dokter" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tgl Surat Keterangan Dokter</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['tglSuratKeteranganDokter'])?$bkn['tglSuratKeteranganDokter']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['TGL_STLK'])?$simpeg['TGL_STLK']:NULL; ?>" name="bkn_tgl_surat_dokter" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No Surat Bebas Napza</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['NO_NAPZA'])?$simpeg['NO_NAPZA']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['noSuratKeteranganBebasNarkoba'])?$bkn['noSuratKeteranganBebasNarkoba']:NULL; ?>" name="simpeg_no_surat_napza" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> No Surat
                                                            <input type="checkbox" class="form-control" value="no_surat_napza" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No Surat Bebas Napza</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['noSuratKeteranganBebasNarkoba'])?$bkn['noSuratKeteranganBebasNarkoba']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['NO_NAPZA'])?$simpeg['NO_NAPZA']:NULL; ?>" name="bkn_no_surat_napza" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tgl Surat Bebas Napza</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['TGL_NAPZA'])?$simpeg['TGL_NAPZA']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['tglSuratKeteranganBebasNarkoba'])?$bkn['tglSuratKeteranganBebasNarkoba']:NULL; ?>" name="simpeg_tgl_surat_napza" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> Tgl Surat
                                                            <input type="checkbox" class="form-control" value="tgl_surat_napza" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Tgl Surat Bebas Napza</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['tglSuratKeteranganBebasNarkoba'])?$bkn['tglSuratKeteranganBebasNarkoba']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['TGL_NAPZA'])?$simpeg['TGL_NAPZA']:NULL; ?>" name="bkn_tgl_surat_napza" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>NO KTP</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['NO_KTP'])?$simpeg['NO_KTP']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['nik'])?$bkn['nik']:NULL; ?>" name="simpeg_no_ktp" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> No KTP
                                                            <input type="checkbox" class="form-control" value="no_ktp" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No KTP</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['nik'])?$bkn['nik']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['NO_KTP'])?$simpeg['NO_KTP']:NULL; ?>" name="bkn_no_ktp" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No Karpeg</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['NO_KARPEG'])?$simpeg['NO_KARPEG']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['noSeriKarpeg'])?$bkn['noSeriKarpeg']:NULL; ?>" name="simpeg_no_karpeg" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> No Karpeg
                                                            <input type="checkbox" class="form-control" value="no_karpeg" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No Karpeg</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['noSeriKarpeg'])?$bkn['noSeriKarpeg']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['NO_KARPEG'])?$simpeg['NO_KARPEG']:NULL; ?>" name="bkn_no_karpeg" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No Taspen</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['NO_TASPEN'])?$simpeg['NO_TASPEN']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['noTaspen'])?$bkn['noTaspen']:NULL; ?>" name="simpeg_no_taspen" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> No Taspen
                                                            <input type="checkbox" class="form-control" value="no_taspen" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No Taspen</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['noTaspen'])?$bkn['noTaspen']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['NO_TASPEN'])?$simpeg['NO_TASPEN']:NULL; ?>" name="bkn_no_taspen" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No NPWP</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['NO_NPWP'])?$simpeg['NO_NPWP']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['noNpwp'])?$bkn['noNpwp']:NULL; ?>" name="simpeg_no_npwp" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> No NPWP
                                                            <input type="checkbox" class="form-control" value="no_npwp" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No NPWP</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['noNpwp'])?$bkn['noNpwp']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['NO_NPWP'])?$simpeg['NO_NPWP']:NULL; ?>" name="bkn_no_npwp" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No Askes</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['NO_ASKES'])?$simpeg['NO_ASKES']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['noAskes'])?$bkn['noAskes']:NULL; ?>" name="simpeg_no_askes" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> No Askes
                                                            <input type="checkbox" class="form-control" value="no_askes" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No Askes</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['noAskes'])?$bkn['noAskes']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['NO_ASKES'])?$simpeg['NO_ASKES']:NULL; ?>" name="bkn_no_askes" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No BPJS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($simpeg['NO_BPJS'])?$simpeg['NO_BPJS']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['bpjs'])?$bkn['bpjs']:NULL; ?>" name="simpeg_no_bpjs" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Pilih</label>
                                                    <div class="form-control" style="background-color: #e9edef">
                                                        <label class="mt-checkbox mt-checkbox-outline"> No BPJS
                                                            <input type="checkbox" class="form-control" value="no_bpjs" name="pilih[]" />
                                                            <span style="border: 1px solid #000;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>No BPJS</label>
                                                    <div class="form-control">
                                                        <?php echo isset($bkn['bpjs'])?$bkn['bpjs']:NULL; ?>
                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg['NO_BPJS'])?$simpeg['NO_BPJS']:NULL; ?>" name="bkn_no_bpjs" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 align-left">
                                                <button type="button" onclick="window.location.href='<?php echo site_url('/integrasi_bkn/parameter?nip_pegawai='.$bkn['nipBaru']) ?>'" class="btn btn-block dark">Batal / Kembali</button>
                                            </div>
                                            <!-- div class="col-xs-6 align-right">
                                                <button type="submit" class="btnsearchyes btn blue-madison">Proses</button>
                                            </div -->
                                        </div>
                                    </form>
                                </div>
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
</div>