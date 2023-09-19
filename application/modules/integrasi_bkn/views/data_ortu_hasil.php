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
                                                    <div class="col-md-3"><h3>Data Orang Tua Simpeg</h3></div>
                                                    <div class="col-md-3 text-right"><h3><button type="submit" value="toSimpeg" name="action" class="btn btn-sm green-meadow m-icon"> <i class="m-icon-swapleft m-icon-white"></i> Migrasi Ke SIMPEG Dari BKN </button></h3></div>
                                                    <div class="col-md-3"><h3><!--button type="submit" value="toBkn" name="action" class="btn btn-sm red m-icon"> Migrasi Ke BKN Dari Simpeg <i class="m-icon-swapright m-icon-white"></i></button --></h3></div>
                                                    <div class="col-md-3 text-right"><h3>Data Orang Tua BKN</h3></div>
                                                </div>
                                                
                                                <div class="well">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Nama Ayah</label>
                                                                <div class="form-control">
                                                                    <?php echo isset($simpeg) ? $simpeg[0]->NAMA : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($bkn['ayah']) ? $bkn['ayah']['nama'] : NULL; ?>" name="simpeg_nama_ayah" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Pilih</label>
                                                                <div class="form-control" style="background-color: #e9edef">
                                                                    <label class="mt-checkbox mt-checkbox-outline"> Nama Ayah
                                                                        <input type="hidden" class="form-control" value="data_ortu" name="integrasi" />
                                                                        <input type="hidden" class="form-control" value="<?php echo $pegawainipnew; ?>" name="id_pegawai_simpeg" />
                                                                        <input type="hidden" class="form-control" value="<?php echo $simpeg[0]->ID; ?>" name="id_pegawai_simpeg_ayah" />
                                                                        <input type="hidden" class="form-control" value="<?php echo $simpeg[1]->ID; ?>" name="id_pegawai_simpeg_ibu" />
                                                                        <input type="checkbox" class="form-control" value="nama_ayah" name="pilih[]" />
                                                                        <span style="border: 1px solid #000;"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Nama Ayah</label>
                                                                <div class="form-control">
                                                                    <?php echo isset($bkn['ayah']) ? $bkn['ayah']['nama'] : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($simpeg) ? $simpeg[0]->NAMA : NULL; ?>" name="bkn_nama_ayah" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Tanggal Lahir Ayah</label>
                                                                <div class="form-control">
                                                                    <?php echo isset($simpeg[0]) ? $simpeg[0]->TGL_LAHIR : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($bkn['ayah']) ? str_replace("-", "/", $bkn['ayah']['tglLahir']) : NULL; ?>" name="simpeg_tgl_lahir_ayah" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Pilih</label>
                                                                <div class="form-control" style="background-color: #e9edef">
                                                                    <label class="mt-checkbox mt-checkbox-outline"> Tanggal Lahir Ayah
                                                                        <input type="checkbox" class="form-control" value="tgl_lahir_ayah" name="pilih[]" />
                                                                        <span style="border: 1px solid #000;"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Tanggal Lahir Ayah</label>
                                                                <div class="form-control">
                                                                    <?php echo isset($bkn['ayah']) ? str_replace('-','/',$bkn['ayah']['tglLahir']) : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($simpeg[0]) ? $simpeg[0]->TGL_LAHIR : NULL; ?>" name="bkn_tgl_lahir_ayah" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    
                                                    <?php if (!$bknadadisimpegayah): ?>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-block yellow-crusta popuplarge" data-url="<?php echo site_url('integrasi_bkn/tambah_ortu_form?kode=1') ?>" data-id="<?php echo $pegawaiid ?>"><i class="m-icon-swapleft m-icon-white"></i> Tambahkan Ke Simpeg</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                </div>
                                                
                                                <div class="well">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Nama Ibu</label>
                                                                <div class="form-control">
                                                                    <?php echo isset($simpeg[1]) ? $simpeg[1]->NAMA : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($bkn['ibu']) ? $bkn['ibu']['nama'] : NULL; ?>" name="simpeg_nama_ibu" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Pilih</label>
                                                                <div class="form-control" style="background-color: #e9edef">
                                                                    <label class="mt-checkbox mt-checkbox-outline"> Nama Ibu
                                                                        <input type="checkbox" class="form-control" value="nama_ibu" name="pilih[]" />
                                                                        <span style="border: 1px solid #000;"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Nama Ibu</label>
                                                                <div class="form-control">
                                                                    <?php echo isset($bkn['ibu']) ? $bkn['ibu']['nama'] : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($simpeg) ? $simpeg[1]->NAMA : NULL; ?>" name="bkn_nama_ibu" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Tanggal Lahir Ibu</label>
                                                                <div class="form-control">
                                                                    <?php echo isset($simpeg[0]) ? $simpeg[1]->TGL_LAHIR : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($bkn['ibu']) ? $bkn['ibu']['tglLahir'] : NULL; ?>" name="simpeg_tgl_lahir_ibu" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Pilih</label>
                                                                <div class="form-control" style="background-color: #e9edef">
                                                                    <label class="mt-checkbox mt-checkbox-outline"> Tanggal Lahir Ibu
                                                                        <input type="checkbox" class="form-control" value="tgl_lahir_ibu" name="pilih[]" />
                                                                        <span style="border: 1px solid #000;"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Tanggal Lahir</label>
                                                                <div class="form-control">
                                                                    <?php echo isset($bkn['ibu']) ? str_replace('-','/',$bkn['ibu']['tglLahir']) : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($simpeg[1]) ? $simpeg[1]->TGL_LAHIR : NULL; ?>" name="bkn_tgl_lahir_ibu" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    
                                                    <?php if (!$bknadadisimpegibu): ?>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-block yellow-crusta popuplarge" data-url="<?php echo site_url('integrasi_bkn/tambah_ortu_form?kode=2') ?>" data-id="<?php echo $pegawaiid ?>"><i class="m-icon-swapleft m-icon-white"></i> Tambahkan Ke Simpeg</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
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