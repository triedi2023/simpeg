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
                                <li>
                                    <a href="javascript:;">Beranda</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <a href="javascript:;">Administrasi sistem</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <span><?=$title_utama?></span>
                                </li>
                            </ul>
                            <!-- END PAGE BREADCRUMBS -->
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
                        <div class="page-toolbar">
                            <!-- BEGIN THEME PANEL -->
                            <div class="btn-group btn-theme-panel">
                                <a href="javascript:;" class="btn dropdown-toggle" data-toggle="dropdown" id="expandDropDown">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </div>
                            <!-- END THEME PANEL -->
                        </div>
                        <!-- END PAGE TOOLBAR -->
                    </div>
                </div>
                <div class="drop-row" id="qualitySelectorDrop">
                    <div class="drop-search">
                        <div class="container-fluid">
                            <form action="javascript:;" class="formfilter">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Username</label>
                                            <input type="text" id="search_username" placeholder="Username" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">NIP</label>
                                            <input type="text" id="search_nip" placeholder="NIP" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Nama Lengkap</label>
                                            <input type="text" id="search_nama_lengkap" placeholder="Nama Lengkap" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Deskripsi</label>
                                            <input type="text" id="search_deskripsi" placeholder="Waktu" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Group</label>
                                            <select id="search_group" class="form-control">
                                                <option value="">- Pilih -</option>
                                                <?php if ($list_group): ?>
                                                    <?php foreach ($list_group as $val): ?>
                                                        <option value="<?= $val['NAMA']; ?>"><?= $val['NAMA']; ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
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
                        <div class="page-content-inner">
                            <div class="prosesdefaultcreateupdate row"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet box blue-dark">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-th"></i> Data Administrasi Sistem <?= $title_utama ?>
                                            </div>
                                            <div class="actions"></div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-container" data-url="<?php echo site_url('administrasi_sistem_aktivitas/ajax_list') ?>">
                                                <table class="defaultgridview table table-striped table-bordered table-hover order-column dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="width: 5%"> No </th>
                                                            <th class="text-center">Username</th>
                                                            <th class="text-center">NIP</th>
                                                            <th class="text-center">Nama Lengkap</th>
                                                            <th class="text-center">Waktu</th>
                                                            <th class="text-center">Aksi</th>
                                                            <th class="text-center">Group</th>
                                                            <th class="text-center">Deskripsi</th>
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