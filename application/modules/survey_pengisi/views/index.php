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
                                    <li>
                                        <a href="javascript:;">Administrasi sistem</a>
                                        <i class="fa fa-angle-right"></i>
                                    </li>
                                    <li>
                                        <a href="javascript:;">Survey</a>
                                        <i class="fa fa-angle-right"></i>
                                    </li>
                                    <li>
                                        <span><?= $title_utama; ?></span>
                                    </li>
                                <?php } ?>
                            </ul>
                            <!-- END PAGE BREADCRUMBS -->
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
                        <?php if ($this->session->get_userdata()['idgroup'] != 3) { ?>
                            <div class="page-toolbar">
                                <!-- BEGIN THEME PANEL -->
                                <div class="btn-group btn-theme-panel">
                                    <a href="javascript:;" title="Kembali" class="btn dropdown-toggle" style="display: none" id="backlist">
                                        <i class="icon-logout"></i>
                                    </a>
                                    <a href="javascript:;" class="btn dropdown-toggle" id="expandDropDown">
                                        <i class="icon-magnifier"></i>
                                    </a>
                                </div>
                                <!-- END THEME PANEL -->
                            </div>
                        <?php } ?>
                        <!-- END PAGE TOOLBAR -->
                    </div>
                </div>
                <div class="drop-row" id="qualitySelectorDrop">
                    <div class="drop-search">
                        <div class="container-fluid">
                            <form action="javascript:;" class="formfilter">
                                <h3>Pencarian Data</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="NIP Lama / NIP Baru" id="search_nip" class="form-control" value="" placeholder="NIP" />
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="Nama Pegawai" id="search_nama" class="form-control" value="" placeholder="Nama Pegawai" />
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">&nbsp;</div>
                                <div class="row">
                                    <div class="col-xs-6 align-left">
                                        <button type="reset" class="btnsearchno btn default">Batal</button>
                                    </div>
                                    <div class="col-xs-6 align-right">
                                        <button type="submit" class="btnsearchyes btn blue-madison">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END PAGE HEAD-->
                <!-- BEGIN PAGE CONTENT BODY -->
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="page-content-inner-detail" style="display: none"></div>

                        <div class="page-content-inner-list">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet box blue-dark">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-th"></i> <?= $title_utama ?>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-container" data-url="<?php echo site_url('survey_pengisi/ajax_list?id='.$id) ?>">
                                                <table class="defaultgridview table table-striped table-bordered table-hover order-column dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="width: 5%"> No </th>
                                                            <th class="text-center">NAMA</th>
                                                            <th class="text-center">NIP</th>
                                                            <th class="text-center">Golongan</th>
                                                            <th class="text-center">TMT Golongan</th>
                                                            <th class="text-center">Jabatan - Unit Organisasi</th>
                                                            <th class="text-center">TMT Jabatan</th>
                                                            <th class="text-center">Tanggal Survey</th>
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