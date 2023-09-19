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
                                                    <div class="col-md-3"><h3>Data Pasangan Simpeg</h3></div>
                                                    <div class="col-md-3 text-right"><h3><button type="submit" value="toSimpeg" name="action" class="btn btn-sm green-meadow m-icon"> <i class="m-icon-swapleft m-icon-white"></i> Migrasi Ke SIMPEG Dari BKN </button></h3></div>
                                                    <div class="col-md-3"><h3><!--button type="submit" value="toBkn" name="action" class="btn btn-sm red m-icon"> Migrasi Ke BKN Dari Simpeg <i class="m-icon-swapright m-icon-white"></i></button --></h3></div>
                                                    <div class="col-md-3 text-right"><h3>Data Pasangan BKN</h3></div>
                                                </div>
                                                
                                                <div class="well">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Nama</label>
                                                                <div class="form-control">
                                                                    <?php echo isset($simpeg[0]) ? $simpeg[0]->NAMA : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($bkn['listPasangan'][0]) ? $bkn['listPasangan'][0]['dataOrang']['nama'] : NULL; ?>" name="simpeg_nama" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Pilih</label>
                                                                <div class="form-control" style="background-color: #e9edef">
                                                                    <label class="mt-checkbox mt-checkbox-outline"> Nama
                                                                        <input type="hidden" class="form-control" value="data_pasangan" name="integrasi" />
                                                                        <input type="hidden" class="form-control" value="<?php echo $pegawainipnew; ?>" name="id_pegawai_simpeg" />
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[0]) ? $simpeg[0]->ID : ''; ?>" name="id_pegawai" />
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
                                                                    <?php echo isset($bkn['listPasangan'][0]) ? $bkn['listPasangan'][0]['dataOrang']['nama'] : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($simpeg[0]) ? $simpeg[0]->NAMA : NULL; ?>" name="bkn_nama" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Tempat Lahir</label>
                                                                <div class="form-control">
                                                                    <?php echo isset($simpeg[0]) ? $simpeg[0]->TEMPAT_LHR : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($bkn['listPasangan'][0]) ? $bkn['listPasangan'][0]['dataOrang']['tempatLahir'] : NULL; ?>" name="simpeg_tempat_lahir" />
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
                                                                    <?php echo isset($bkn['listPasangan'][0]) ? $bkn['listPasangan'][0]['dataOrang']['tempatLahir'] : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($simpeg[0]) ? $simpeg[0]->TEMPAT_LHR : NULL; ?>" name="bkn_tempat_lahir" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Tanggal Lahir</label>
                                                                <div class="form-control">
                                                                    <?php echo isset($simpeg[0]) ? $simpeg[0]->TGL_LAHIR2 : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($bkn['listPasangan'][0]) ? str_replace("-","/",$bkn['listPasangan'][0]['dataOrang']['tglLahir']) : NULL; ?>" name="simpeg_tanggal_lahir" />
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
                                                                    <?php echo isset($bkn['listPasangan'][0]) ? str_replace("-","/",$bkn['listPasangan'][0]['dataOrang']['tglLahir']) : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($simpeg[0]) ? $simpeg[0]->TGL_LAHIR2 : NULL; ?>" name="bkn_tanggal_lahir" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Tanggal Nikah</label>
                                                                <div class="form-control">
                                                                    <?php
                                                                    $tglnikahbkn = isset($bkn['listPasangan'][0]['dataPernikahan']['tgglMenikah']) ? explode("-", $bkn['listPasangan'][0]['dataPernikahan']['tgglMenikah']) : [];
                                                                    $formattglnikah = (isset($tglnikahbkn[2]) ? $tglnikahbkn[2]."/" : "").(isset($tglnikahbkn[1]) ? $tglnikahbkn[1]."/" : "").(isset($tglnikahbkn[0]) ? $tglnikahbkn[0] : "")
                                                                    ?>
                                                                    <?php echo isset($simpeg[0]) ? $simpeg[0]->TGL_NIKAH2 : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo $formattglnikah; ?>" name="simpeg_tgl_nikah" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Pilih</label>
                                                                <div class="form-control" style="background-color: #e9edef">
                                                                    <label class="mt-checkbox mt-checkbox-outline"> Tanggal Nikah
                                                                        <input type="checkbox" class="form-control" value="tanggal_nikah" name="pilih[]" />
                                                                        <span style="border: 1px solid #000;"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Tanggal Nikah</label>
                                                                <div class="form-control">
                                                                    <?php echo isset($bkn['listPasangan'][0]) ? $formattglnikah : NULL; ?>
                                                                    <input type="hidden" class="form-control" value="<?php echo isset($simpeg[0]) ? $simpeg[0]->TGL_NIKAH2 : NULL; ?>" name="bkn_tgl_nikah" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php if (!$bknadadisimpeg): ?>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-block yellow-crusta popuplarge" data-url="<?php echo site_url('integrasi_bkn/tambah_pasangan_form') ?>" data-id="<?php echo $pegawaiid ?>"><i class="m-icon-swapleft m-icon-white"></i> Tambahkan Ke Simpeg</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
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