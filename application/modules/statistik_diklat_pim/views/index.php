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
                                    <a href="javascript:;">Statistik</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <a href="javascript:;">Diklat</a>
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
                                    <form action="#" class="form-horizontal" id="formpencarian" data-url="<?php echo site_url("statistik_diklat_pim/pencarian_proses") ?>">
                                        <div class="form-body">
                                            <?php $this->load->view('system/unitkerja_form-horizontal_filter'); ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Jenis Keluaran</label>
                                                        <div class="col-md-7">
                                                            <select name="jenis_keluaran" id="jenis_keluaran" class="form-control" style="width: 100%">
                                                                <option value="2">- Grafik -</option>
                                                                <option value="1">- Matrik -</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row viewbentuk" style="display: none;">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Bentuk Keluaran</label>
                                                        <div class="col-md-4">
                                                            <label for="bentukid_1">
                                                                <input type="radio" name="bentuk" id="bentukid_1" value="1"/> Menurut DIKLATPIM per Lokasi Unit Kerja
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="bentukid_2">
                                                                <input type="radio" name="bentuk" id="bentukid_2" value="2"/> Menurut DIKLATPIM per Eselon
                                                            </label>
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