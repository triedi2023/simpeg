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
                                                    <div class="col-md-3"><h3>Data Pendidikan Simpeg</h3></div>
                                                    <div class="col-md-3 text-right"><h3><button type="submit" value="toSimpeg" name="action" class="btn btn-sm green-meadow m-icon"> <i class="m-icon-swapleft m-icon-white"></i> Migrasi Ke SIMPEG Dari BKN </button></h3></div>
                                                    <div class="col-md-3"><h3><!--button type="submit" value="toBkn" name="action" class="btn btn-sm red m-icon"> Migrasi Ke BKN Dari Simpeg <i class="m-icon-swapright m-icon-white"></i></button --></h3></div>
                                                    <div class="col-md-3 text-right"><h3>Data Pendidikan BKN</h3></div>
                                                </div>
                                                
                                                <?php for($i=0;$i<max(count($simpeg),count($bkn));$i++) { ?>
                                                    <div class="well">
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tingkat Pendidikan</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->TINGKAT_PENDIDIKAN)?$simpeg[$i]->TINGKAT_PENDIDIKAN:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['tkPendidikanId']:NULL; ?>" name="simpeg_tkt_pend[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Tingkat Pendidikan
                                                                                <input type="hidden" class="form-control" value="data_pendidikan" name="integrasi" />
                                                                                <input type="hidden" class="form-control" value="<?php echo $pegawainipnew; ?>" name="id_pegawai_simpeg" />
                                                                                <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>" name="id_pegawai[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />

                                                                                <input type="checkbox" class="form-control" value="tkt_pend" name="pilih[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tingkat Pendidikan</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn[$i])?$bkn[$i]['tkPendidikanNama']:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->ID_BKN)?$simpeg[$i]->ID_BKN:NULL; ?>" name="bkn_tkt_pend[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tahun Lulus</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->THN_LULUS)?$simpeg[$i]->THN_LULUS:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['tahunLulus']:NULL; ?>" name="simpeg_thn_lulus[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> Tahun Lulus
                                                                                <input type="checkbox" class="form-control" value="thn_lulus" name="pilih[<?php echo isset($simpeg[$i]->ID) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Tahun Lulus</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn[$i])?$bkn[$i]['tahunLulus']:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->THN_LULUS)?$simpeg[$i]->THN_LULUS:NULL; ?>" name="bkn_thn_lulus[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>No Ijasah</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($simpeg[$i]->NO_STTB)?$simpeg[$i]->NO_STTB:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($bkn[$i])?$bkn[$i]['nomorIjasah']:NULL; ?>" name="simpeg_no_ijasah[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Pilih</label>
                                                                    <div class="form-control" style="background-color: #e9edef">
                                                                        <?php if ((isset($simpeg[$i]) && !empty($simpeg[$i]->ID)) && (isset($bkn[$i]) && !empty($bkn[$i]['id']))) { ?>
                                                                            <label class="mt-checkbox mt-checkbox-outline"> No Ijasah
                                                                                <input type="checkbox" class="form-control" value="no_ijasah" name="pilih[<?php echo isset($simpeg[$i]->ID) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>][]" />
                                                                                <span style="border: 1px solid #000;"></span>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>No Ijasah</label>
                                                                    <div class="form-control">
                                                                        <?php echo isset($bkn[$i])?$bkn[$i]['nomorIjasah']:NULL; ?>
                                                                        <input type="hidden" class="form-control" value="<?php echo isset($simpeg[$i]->NO_STTB)?$simpeg[$i]->NO_STTB:NULL; ?>" name="bkn_no_ijasah[<?php echo isset($simpeg[$i]) ? (!empty($simpeg[$i]->ID) ? $simpeg[$i]->ID : '') : ''; ?>]" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <?php if (empty($simpeg[$i]->TINGKAT_PENDIDIKAN) && !empty($bkn[$i]['tkPendidikanId']) && empty($simpeg[$i]->THN_LULUS) && !empty($bkn[$i]['tahunLulus'])): ?>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button type="button" class="btn btn-block yellow-crusta popuplarge" data-url="<?php echo site_url('integrasi_bkn/tambah_pendidikan_form?ambil='.(isset($bkn[$i]['id']) ? $bkn[$i]['id'] : null)) ?>" data-id="<?php echo $pegawaiid ?>"><i class="m-icon-swapleft m-icon-white"></i> Tambahkan Ke Simpeg</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        
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