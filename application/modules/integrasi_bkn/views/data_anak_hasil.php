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
                                <?php if ($this->session->get_userdata()['idgroup'] != 3) { ?>
                                    <li>
                                        <a href="javascript:;">Beranda</a>
                                        <i class="fa fa-angle-right"></i>
                                    </li>
                                <?php } ?>
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
                        <div class="page-content-inner-detail">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="portlet box blue-dark">
                                        <div class="portlet-title">
                                            <div class="caption"><i class="fa fa-th"></i> Integrasi SIMPEG BKN</div>
                                            <div class="actions">&nbsp;</div>
                                        </div>
                                        <div class="portlet-body">
                                            <form action="<?php echo site_url('integrasi_bkn/proses'); ?>" method="post">

                                                <?php if ($this->session->flashdata('pesan')) { ?>
                                                    <?php echo $this->session->flashdata('pesan'); ?>
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-md-3"><h3>Data Anak Simpeg</h3></div>
                                                    <div class="col-md-3 text-right"><h3><button type="submit" value="toSimpeg" name="action" class="btn btn-sm green-meadow m-icon"> <i class="m-icon-swapleft m-icon-white"></i> Migrasi Ke SIMPEG Dari BKN </button></h3></div>
                                                    <div class="col-md-3"><h3><!--button type="submit" value="toBkn" name="action" class="btn btn-sm red m-icon"> Migrasi Ke BKN Dari Simpeg <i class="m-icon-swapright m-icon-white"></i></button --></h3></div>
                                                    <div class="col-md-3 text-right"><h3>Data Anak BKN</h3></div>
                                                </div>

                                                <?php for ($i = 0; $i < max(count($simpeg), count($bkn['listAnak'])); $i++) { ?>
                                                    <div class="well">

                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Status Anak</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->STATUS_ANAK) ? $simpeg[$i]->STATUS_ANAK : NULL) : NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['listAnak'][$i]) ? $bkn['listAnak'][$i]['jenisAnak'] : NULL; ?>" name="simpeg_status_anak[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn['listAnak'][$i]) && !empty($bkn['listAnak'][$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Status Anak
                                                                                <input type="hidden" class="form-control" value="data_anak" name="integrasi" />
                                                                                <input type="hidden" class="form-control" value="<?php echo $pegawainipnew; ?>" name="id_pegawai_simpeg" />
                                                                                <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>" name="id_pegawai[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />

                                                                                <input type="checkbox" class="form-control" value="status_anak" name="pilih[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Status Anak</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn['listAnak'][$i]) ? $bkn['listAnak'][$i]['jenisAnak'] : NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->STATUS_ANAK) ? $simpeg[$i]->STATUS_ANAK : NULL) : NULL; ?>" name="bkn_status_anak[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Nama</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->NAMA) ? $simpeg[$i]->NAMA : NULL) : NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['listAnak'][$i]) ? $bkn['listAnak'][$i]['nama'] : NULL; ?>" name="simpeg_nama[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn['listAnak'][$i]) && !empty($bkn['listAnak'][$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Nama
                                                                                <input type="checkbox" class="form-control" value="nama" name="pilih[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Nama</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn['listAnak'][$i]) ? $bkn['listAnak'][$i]['nama'] : NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->NAMA) ? $simpeg[$i]->NAMA : NULL) : NULL; ?>" name="bkn_nama" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Jenis Kelamin</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->NAMA) ? ($simpeg[$i]->SEX == "P" ? 'Wanita' : 'Pria') : NULL) : NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['listAnak'][$i]) ? $bkn['listAnak'][$i]['jenisKelamin'] : NULL; ?>" name="simpeg_jk[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn['listAnak'][$i]) && !empty($bkn['listAnak'][$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Jenis Kelamin
                                                                                <input type="checkbox" class="form-control" value="jk" name="pilih[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Jenis Kelamin</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn['listAnak'][$i]) ? $bkn['listAnak'][$i]['jenisKelamin'] : NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->NAMA) ? ($simpeg[$i]->SEX == "P" ? 'Wanita' : 'Pria') : NULL) : NULL; ?>" name="bkn_jk" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tempat Lahir</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->TEMPAT_LHR) ? $simpeg[$i]->TEMPAT_LHR : NULL) : NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['listAnak'][$i]) ? $bkn['listAnak'][$i]['tempatLahir'] : NULL; ?>" name="simpeg_tpt_lahir[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn['listAnak'][$i]) && !empty($bkn['listAnak'][$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Tempat Lahir
                                                                                <input type="checkbox" class="form-control" value="tpt_lahir" name="pilih[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tempat Lahir</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn['listAnak'][$i]) ? $bkn['listAnak'][$i]['tempatLahir'] : NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->TEMPAT_LHR) ? $simpeg[$i]->TEMPAT_LHR : NULL) : NULL; ?>" name="bkn_tpt_lahir" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tanggal Lahir</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->TGL_LAHIR2) ? $simpeg[$i]->TGL_LAHIR2 : NULL) : NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn['listAnak'][$i]) ? str_replace("-", "/", $bkn['listAnak'][$i]['tglLahir']) : NULL; ?>" name="simpeg_tgl_lahir[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn['listAnak'][$i]) && !empty($bkn['listAnak'][$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Tanggal Lahir
                                                                                <input type="checkbox" class="form-control" value="tgl_lahir" name="pilih[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tanggal Lahir</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn['listAnak'][$i]) ? str_replace("-", "/", $bkn['listAnak'][$i]['tglLahir']) : NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->TGL_LAHIR2) ? $simpeg[$i]->TGL_LAHIR2 : NULL) : NULL; ?>" name="bkn_tgl_lahir" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php if (empty($simpeg[$i]->TGL_LAHIR2) && empty($simpeg[$i]->NAMA)): ?>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button type="button" class="btn btn-block yellow-crusta popuplarge" data-url="<?php echo site_url('integrasi_bkn/tambah_anak_form?ambil='.$bkn['listAnak'][$i]['id']) ?>" data-id="<?php echo $pegawaiid ?>"><i class="m-icon-swapleft m-icon-white"></i> Tambahkan Ke Simpeg</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php } ?>
                                                <div class="row">&nbsp;</div>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 align-left">
                                                        <button type="button" onclick="window.location.href='<?php echo site_url('/integrasi_bkn/parameter?nip_pegawai='.$bkn['nipBaru']) ?>'" class="btn btn-block dark">Batal / Kembali</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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