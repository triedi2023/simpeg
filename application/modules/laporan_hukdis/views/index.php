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
                                    <a href="javascript:;">Laporan</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
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
                        <div class="page-content-inner">
                            <div class="m-heading-1 border-green m-bordered">
                                <h3>Parameter</h3>
                                <div class="form">
                                    <form action="#" class="form-horizontal" id="formpencarian" data-url="<?php echo site_url("laporan_hukdis/pencarian_proses") ?>">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Tingkat Hukuman</label>
                                                        <div class="col-md-7">
                                                            <select name="tingkat_hukdis" id="tingkat_hukdis" class="form-control" style="width: 100%">
                                                                <option value="">- pilih -</option>
                                                                <?php if ($list_tkt_hukdis): ?>
                                                                    <?php foreach ($list_tkt_hukdis as $val): ?>
                                                                        <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Bentuk</label>
                                                        <div class="col-md-9">
                                                            <input type="checkbox" id="bentuk_laporan" class="make-switch" data-on-text="&nbsp;Komposisi&nbsp;" data-off-text="&nbsp;Daftar&nbsp;" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="reset" class="btn default">Reset</button>
                                                    <button type="submit" class="btn blue">Tampilkan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row hasilfilter" style="display: none"></div>
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