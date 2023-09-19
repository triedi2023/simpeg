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
                                    <a href="javascript:;">Pegawai</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <span><?= $title_utama ?></span>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Jenis Cuti</label>
                                            <select name="search_jenis_cuti" id="search_jenis_cuti" class="form-control" style="width: 100%">
                                                <option value=""> - Pilih -</option>
                                                <?php if ($list_jenis_cuti): ?>
                                                    <?php foreach ($list_jenis_cuti as $val): ?>
                                                        <option value="<?= $val['ID']; ?>"><?= $val['NAMA']; ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">NIP</label>
                                            <input type="text" id="search_nip" name="search_nip" class="form-control" />
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
                                                <i class="fa fa-th"></i> <?= $title_utama ?> 
                                            </div>
                                            <div class="actions"></div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-container" data-url="<?php echo site_url('daftar_cuti/ajax_list') ?>">
                                                <table class="defaultgridview table table-striped table-bordered table-hover order-column dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="width: 10%"> No </th>
                                                            <th class="text-center">Tanggal Pengajuan</th>
                                                            <th class="text-center">Jenis Cuti</th>
                                                            <th class="text-center">NIP</th>
                                                            <th class="text-center">Nama</th>
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