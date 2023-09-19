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
                                            <form action="javascript:;">
                                                <div class="row">
                                                    <div class="col-md-6"><h3>Data Kursus Simpeg</h3></div>
                                                    <div class="col-md-6"><h3>Data Kursus BKN</h3></div>
                                                </div>
                                                <?php for($i=0;$i<max(count($simpeg),count($bkn));$i++) { ?>
                                                    <div class="well">
                                                        <div class="row">
                                                            <?php if (isset($simpeg[$i])) { ?>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Jenis Kegiatan</label>
                                                                        <div class="form-control"><?php echo isset($simpeg[$i])?$simpeg[$i]->JENIS_KEGIATAN:NULL; ?></div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if (isset($bkn[$i])) { ?>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Jenis Kegiatan</label>
                                                                        <div class="form-control"><?php echo isset($bkn[$i])?$bkn[$i]['jenisKursusSertifikat']:NULL; ?></div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="row">
                                                            <?php if (isset($simpeg[$i])) { ?>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Nama Kegiatan</label>
                                                                        <div class="form-control"><?php echo isset($simpeg[$i])?$simpeg[$i]->NAMA_KEGIATAN:NULL; ?></div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if (isset($bkn[$i])) { ?>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Nama Kegiatan</label>
                                                                        <div class="form-control"><?php echo isset($bkn[$i])?$bkn[$i]['namaKursus']:NULL; ?></div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
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