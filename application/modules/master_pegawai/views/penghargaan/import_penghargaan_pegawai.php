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
                                    <a href="javascript:;">Import</a>
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
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="portlet box yellow-gold">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-gift"></i>Form Import <?= $title_form; ?> Status PNS Via File Excel
                                            </div>
                                            <div class="tools">&nbsp;</div>
                                        </div>
                                        <div class="portlet-body form">
                                            
                                            <!-- BEGIN FORM-->
                                            <?php echo form_open(site_url('master_pegawai/master_pegawai_penghargaan/import_penghargaan_pegawai'), ["class" => "horizontal-form", "enctype" => 'multipart/form-data']); ?>
                                            <div class="form-body">
                                                
                                                <?php if ($this->session->flashdata('pesan')) { ?>
                                                    <?php echo $this->session->flashdata('pesan'); ?>
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label">Unduh Format Excel <span class="required" aria-required="true"> * </span></label><br />
                                                            <a target="_blank" href="<?php echo site_url('master_pegawai/master_pegawai_penghargaan/format_excel_penghargaan') ?>" class="btn btn-transparent red btn-outline btn-circle btn-sm" title="Unduh Format Excel"><i class="fa fa-file-excel-o"></i></a>
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label class="control-label">File Excel <span class="required" aria-required="true"> * </span></label>
                                                            <input type="file" name="file_excel" id="field_file_excel" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                </div>
                                                <!--/row-->
                                            </div>
                                            <div class="form-actions">
                                                <div class="pull-left">&nbsp;</div>
                                                <div class="pull-right">
                                                    <button type="submit" class="btn btn-warning btn-circle"><i class="fa fa-check"></i> Unggah</button>
                                                </div>
                                            </div>
                                            <?php echo form_close(); ?>
                                            <!-- END FORM-->
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