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
                                                    <div class="col-md-3"><h3>Data CTLN Simpeg</h3></div>
                                                    <div class="col-md-3 text-right"><h3><!-- button type="submit" value="toSimpeg" name="action" class="btn btn-sm green-meadow m-icon"> <i class="m-icon-swapleft m-icon-white"></i> Migrasi Ke SIMPEG Dari BKN </button></h3 --></div>
                                                    <div class="col-md-3"><h3><!--button type="submit" value="toBkn" name="action" class="btn btn-sm red m-icon"> Migrasi Ke BKN Dari Simpeg <i class="m-icon-swapright m-icon-white"></i></button --></h3></div>
                                                    <div class="col-md-3 text-right"><h3>Data CTLN BKN</h3></div>
                                                </div>
                                                
                                                <?php for($i=0;$i<max(count($simpeg),count($bkn));$i++) { ?>
                                                    <div class="well">
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>CTLN</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->NAMA_BKN)?$simpeg[$i]->NAMA_BKN:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['jenisHukuman']:NULL; ?>" name="simpeg_jenis_huk[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline">Jenis Hukuman
                                                                                <input type="hidden" class="form-control" value="data_hukdis" name="integrasi" />
                                                                                <input type="hidden" class="form-control" value="<?php echo $pegawainipnew; ?>" name="id_pegawai_simpeg" />
                                                                                <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>" name="id_pegawai[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />

                                                                                <input type="checkbox" class="form-control" value="jenis_huk" name="pilih[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>CTLN</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn[$i])?$bkn[$i]['jenisHukumanNama']:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->PERIODE_TAHUN)?$simpeg[$i]->PERIODE_TAHUN:NULL; ?>" name="bkn_jenis_huk[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tgl Awal</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->TMT_HKMN)?$simpeg[$i]->TMT_HKMN:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['hukumanTanggal']:NULL; ?>" name="simpeg_tgl_hukum[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> TMT Hukuman
                                                                                <input type="checkbox" class="form-control" value="tgl_hukum" name="pilih[<?php echo isset($simpeg[$i]->ID) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tgl Awal</label>
                                                                    <div class="form-control">
                                                                        <?php
                                                                        $tglhukawal = isset($bkn[$i])?explode("-",$bkn[$i]['hukumanTanggal']):NULL;
                                                                        $formattglawal = '';
                                                                        if ($tglhukawal) {
                                                                            $formattglawal = $tglhukawal[2]."/".$tglhukawal[1]."/".$tglhukawal[0];
                                                                        }
                                                                        ?>
                                                                        <?php echo $formattglawal; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->TMT_HKMN)?$simpeg[$i]->TMT_HKMN:NULL; ?>" name="bkn_tgl_hukum[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tgl Akhir</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->AKHIR_HKMN)?$simpeg[$i]->AKHIR_HKMN:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['akhirHukumTanggal']:NULL; ?>" name="simpeg_tgl_hukum_akhir[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Akhir Hukuman
                                                                                <input type="checkbox" class="form-control" value="tgl_hukum_akhir" name="pilih[<?php echo isset($simpeg[$i]->ID) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tgl Akhir</label>
                                                                    <div class="form-control">
                                                                        <?php
                                                                        $tglhukakhir = isset($bkn[$i])?explode("-",$bkn[$i]['akhirHukumTanggal']):NULL;
                                                                        $formattglakhir = '';
                                                                        if ($tglhukakhir) {
                                                                            $formattglakhir = $tglhukakhir[2]."/".$tglhukakhir[1]."/".$tglhukakhir[0];
                                                                        }
                                                                        ?>
                                                                        <?php echo $formattglakhir; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->AKHIR_HKMN)?$simpeg[$i]->AKHIR_HKMN:NULL; ?>" name="bkn_tgl_hukum_akhir[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>No SK</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->NO_SK)?$simpeg[$i]->NO_SK:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['skNomor']:NULL; ?>" name="simpeg_no_sk[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> No SK
                                                                                <input type="checkbox" class="form-control" value="no_sk" name="pilih[<?php echo isset($simpeg[$i]->ID) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>No SK</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn[$i])?$bkn[$i]['skNomor']:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->NO_SK)?$simpeg[$i]->NO_SK:NULL; ?>" name="bkn_no_sk[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tgl SK</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->TGL_SK)?$simpeg[$i]->TGL_SK:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['skTanggal']:NULL; ?>" name="simpeg_tgl_sk[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Tgl SK
                                                                                <input type="checkbox" class="form-control" value="tgl_sk" name="pilih[<?php echo isset($simpeg[$i]->ID) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tgl SK</label>
                                                                    <div class="form-control">
                                                                        <?php
                                                                        $tglsk = isset($bkn[$i])?explode("-",$bkn[$i]['skTanggal']):NULL;
                                                                        $formattglsk = '';
                                                                        if ($tglsk) {
                                                                            $formattglsk = $tglsk[2]."/".$tglsk[1]."/".$tglsk[0];
                                                                        }
                                                                        ?>
                                                                        <?php echo $formattglsk; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->TGL_SK)?$simpeg[$i]->TGL_SK:NULL; ?>" name="bkn_tgl_sk[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <?php if (empty($simpeg[$i]->ID_BKN) && !empty($bkn[$i]['jenisHukuman'])): ?>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button type="button" class="btn btn-block yellow-crusta popuplarge" data-url="<?php echo site_url('integrasi_bkn/tambah_hukdis_form?ambil='.(isset($bkn[$i]['id']) ? $bkn[$i]['id'] : null)) ?>" data-id="<?php echo $pegawaiid ?>"><i class="m-icon-swapleft m-icon-white"></i> Tambahkan Ke Simpeg</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                    </div>
                                                <?php } ?>
                                                <?php if (count($simpeg) == 0 && count($bkn) == 0) { ?>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="form-control">Maaf data tidak ditemukan</div>
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