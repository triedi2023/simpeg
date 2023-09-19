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
                                                    <div class="col-md-3"><h3>Data SKP Simpeg</h3></div>
                                                    <div class="col-md-3 text-right"><h3><button type="submit" value="toSimpeg" name="action" class="btn btn-sm green-meadow m-icon"> <i class="m-icon-swapleft m-icon-white"></i> Migrasi Ke SIMPEG Dari BKN </button></h3></div>
                                                    <div class="col-md-3"><h3><button type="submit" value="toBkn" name="action" class="btn btn-sm red m-icon"> Migrasi Ke BKN Dari Simpeg <i class="m-icon-swapright m-icon-white"></i></button> </h3></div>
                                                    <div class="col-md-3 text-right"><h3>Data SKP BKN</h3></div>
                                                </div>
                                                
                                                <?php for($i=0;$i<max(count($simpeg),count($bkn));$i++) { ?>
                                                    <div class="well">
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tahun Penilaian</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->PERIODE_TAHUN)?$simpeg[$i]->PERIODE_TAHUN:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['tahun']:NULL; ?>" name="simpeg_tahun_nilai[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Pilih
                                                                                <input type="hidden" class="form-control" value="data_skp" name="integrasi" />
                                                                                <input type="hidden" class="form-control" value="<?php echo $pegawainipnew; ?>" name="id_pegawai_simpeg" />
                                                                                <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>" name="id_pegawai[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                                <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i]['id']) ? $bkn[$i]['id'] : ''; ?>" name="id_bkn[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />

                                                                                <input type="checkbox" class="form-control" value="tahun_nilai" name="pilih[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tahun Penilaian</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn[$i])?$bkn[$i]['tahun']:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->PERIODE_TAHUN)?$simpeg[$i]->PERIODE_TAHUN:NULL; ?>" name="bkn_tahun_nilai[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Nilai SKP</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->NILAI_AKHIR)?$simpeg[$i]->NILAI_AKHIR:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['nilaiSkp']:NULL; ?>" name="simpeg_nilai_skp[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <!-- div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php // if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Nilai SKP
                                                                                <input type="checkbox" class="form-control" value="nilai_skp" name="pilih[<?php // echo isset($simpeg[$i]->ID) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php // } ?>
                                                                    </div>
                                                                </div -->
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Nilai SKP</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn[$i])?$bkn[$i]['nilaiSkp']:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->NILAI_AKHIR)?$simpeg[$i]->NILAI_AKHIR:NULL; ?>" name="bkn_nilai_skp[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Orientasi Pelayanan</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->ORIENTASI_PELAYANAN)?$simpeg[$i]->ORIENTASI_PELAYANAN:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['orientasiPelayanan']:NULL; ?>" name="simpeg_orientasi[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <!-- div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php // if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Orien Pelayanan
                                                                                <input type="checkbox" class="form-control" value="orientasi" name="pilih[<?php // echo isset($simpeg[$i]->ID) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php // } ?>
                                                                    </div>
                                                                </div  -->
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Orientasi Pelayanan</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn[$i])?$bkn[$i]['orientasiPelayanan']:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->ORIENTASI_PELAYANAN)?$simpeg[$i]->ORIENTASI_PELAYANAN:NULL; ?>" name="bkn_orientasi[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Integritas</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->INTEGRITAS)?$simpeg[$i]->INTEGRITAS:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['integritas']:NULL; ?>" name="simpeg_integritas[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <!-- div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php // if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Integritas
                                                                                <input type="checkbox" class="form-control" value="integritas" name="pilih[<?php // echo isset($simpeg[$i]->ID) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php // } ?>
                                                                    </div>
                                                                </div  -->
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Integritas</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn[$i])?$bkn[$i]['integritas']:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->INTEGRITAS)?$simpeg[$i]->INTEGRITAS:NULL; ?>" name="bkn_integritas[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Komitmen</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->KOMITMEN)?$simpeg[$i]->KOMITMEN:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['komitmen']:NULL; ?>" name="simpeg_komitmen[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <!-- div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php // if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Komitmen
                                                                                <input type="checkbox" class="form-control" value="komitmen" name="pilih[<?php // echo isset($simpeg[$i]->ID) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php // } ?>
                                                                    </div>
                                                                </div -->
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Komitmen</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn[$i])?$bkn[$i]['komitmen']:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->KOMITMEN)?$simpeg[$i]->KOMITMEN:NULL; ?>" name="bkn_komitmen[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Disiplin</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->DISIPLIN)?$simpeg[$i]->DISIPLIN:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['disiplin']:NULL; ?>" name="simpeg_disiplin[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <!-- div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php // if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Disiplin
                                                                                <input type="checkbox" class="form-control" value="disiplin" name="pilih[<?php // echo isset($simpeg[$i]->ID) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php // } ?>
                                                                    </div>
                                                                </div -->
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Disiplin</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn[$i])?$bkn[$i]['disiplin']:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->DISIPLIN)?$simpeg[$i]->DISIPLIN:NULL; ?>" name="bkn_disiplin[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Kerjasama</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->KERJASAMA)?$simpeg[$i]->KERJASAMA:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['kerjasama']:NULL; ?>" name="simpeg_kerjasama[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <!-- div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php // if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Kerjasama
                                                                                <input type="checkbox" class="form-control" value="kerjasama" name="pilih[<?php // echo isset($simpeg[$i]->ID) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php // } ?>
                                                                    </div>
                                                                </div -->
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Kerjasama</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn[$i])?$bkn[$i]['kerjasama']:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->KERJASAMA)?$simpeg[$i]->KERJASAMA:NULL; ?>" name="bkn_kerjasama[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Kepemimpinan</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->KEPEMIMPINAN)?$simpeg[$i]->KEPEMIMPINAN:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['kepemimpinan']:NULL; ?>" name="simpeg_kepemimpinan[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <!-- div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Kepemimpinan
                                                                                <input type="checkbox" class="form-control" value="kepemimpinan" name="pilih[<?php echo isset($simpeg[$i]->ID) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div -->
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Kepemimpinan</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn[$i])?$bkn[$i]['kepemimpinan']:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->KEPEMIMPINAN)?$simpeg[$i]->KEPEMIMPINAN:NULL; ?>" name="bkn_kepemimpinan[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <?php if (empty($simpeg[$i]->PERIODE_TAHUN) && !empty($bkn[$i]['tahun'])): ?>
                                                                    <div class="form-group">
                                                                        <button type="button" class="btn btn-block yellow-crusta popuplarge" data-url="<?php echo site_url('integrasi_bkn/tambah_skp_form?ambil='.(isset($bkn[$i]['id']) ? $bkn[$i]['id'] : null)) ?>" data-id="<?php echo $pegawaiid ?>"><i class="m-icon-swapleft m-icon-white"></i> Tambahkan Ke Simpeg</button>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <?php // if (!empty($simpeg[$i]->PERIODE_TAHUN) && empty($bkn[$i]['tahun'])): ?>
                                                                    <!-- div class="form-group">
                                                                        <button type="button" class="btn btn-block yellow-soft" data-url="<?php // echo site_url('integrasi_bkn/tambah_skp_form?ambil='.(isset($simpeg[$i]->ID) ? $simpeg[$i]->ID : null)) ?>" data-id="<?php echo $pegawaiid ?>"><i class="m-icon-swapright m-icon-white"></i> Tambahkan Ke BKN <?php // echo $simpeg[$i]->ID ?></button>
                                                                    </div -->
                                                                <?php // endif; ?>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                <?php } ?>
                                                <div class="row">&nbsp;</div>
                                                <div class="row">
                                                    <div class="col-xs-12 align-right">
                                                        <button type="button" onclick="window.location.href='<?php echo site_url('/integrasi_bkn/parameter?nip_pegawai='.$pegawainipnew) ?>'" class="btn btn-block dark">Batal / Kembali</button>
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