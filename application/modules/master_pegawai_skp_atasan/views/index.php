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
                                    <a href="javascript:;">Pegawai</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <a href="javascript:;">SKP</a>
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
                            <div class="prosesdefaultcreateupdate row"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet box blue-dark">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-th"></i> Data <?= $title_utama ?> Pegawai
                                            </div>
                                            <div class="actions"></div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-container" data-url="<?php echo site_url('master_pegawai_skp_atasan/ajax_list') ?>">
                                                <table class="defaultgridview table table-striped table-bordered table-hover order-column dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="width: 5%"> No </th>
                                                            <th class="text-center" style="width: 15%">Periode</th>
                                                            <th class="text-center" style="width: 15%">Pangkat / Golongan</th>
                                                            <th class="text-center">Jabatan</th>
                                                            <th class="text-center" style="width: 5%">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                </table>
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