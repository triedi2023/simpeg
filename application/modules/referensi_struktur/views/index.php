<div class="page-wrapper-row full-height">
    <div class="page-wrapper-middle">
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <!-- BEGIN PAGE HEAD-->
                <div class="page-head">
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
                                    <a href="javascript:;">Referensi</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <a href="javascript:;">Organisasi</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <span><?= $title_utama ?></span>
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet box blue-dark">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-th"></i> Data Referensi <?= $title_utama ?> 
                                            </div>
                                            <div class="actions"></div>
                                        </div>
                                        <div class="portlet-body">
                                            <ul id="tabstrukturorganisasi" class="nav nav-pills">
                                                <li class="active">
                                                    <a eselon="1" href="<?php echo site_url("referensi_struktur/index_eselon_1"); ?>" data-toggle="tabs"> Eselon 1 </a>
                                                </li>
                                                <li>
                                                    <a eselon="2" href="<?php echo site_url("referensi_struktur/index_eselon_2"); ?>" data-toggle="tabs"> Eselon 2 </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo site_url('referensi_struktur/index_eselon_3') ?>" data-toggle="tabs"> Eselon 3 </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo site_url('referensi_struktur/index_eselon_4') ?>" data-toggle="tabs"> Eselon 4 </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo site_url('referensi_struktur/index_eselon_5') ?>" data-toggle="tabs"> Eselon 5 </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane fade active in portlet-title" id="tab_2_1">

                                                </div>
                                            </div>
                                        </div>
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