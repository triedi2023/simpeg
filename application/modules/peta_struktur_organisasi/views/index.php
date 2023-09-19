<style>
    iframe{
        height: 100%;
        overflow: hidden;
        width: 100%;
        margin: 0;
        padding: 0;
    }
</style>
<script>
    function resizeIframe(obj) {
        obj.style.height = obj.contentWindow.document.body.scrollHeight + 30 + 'px';
    }
</script>
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
                                    <a href="javascript:;">Struktural</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <a href="javascript:;">Peta Jabatan</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <span><?= $title_utama; ?></span>
                                </li>
                            </ul>
                            <!-- END PAGE BREADCRUMBS -->
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
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
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <select name="trlokasi_id" id="field_trlokasi_id" class="form-control btn-xs" style="width: 100%">
                                                        <option value="">- Pilih Lokasi Kerja -</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="kdu1" id="field_kdu1" class="form-control btn-xs" style="width: 100%">
                                                        <option value="">- Pilih Jabatan Pimpinan Tinggi Madya -</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="kdu2" id="field_kdu2" class="form-control btn-xs" style="width: 100%">
                                                        <option value="">- Pilih Jabatan Pimpinan Tinggi Pratama -</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="kdu3" id="field_kdu3" class="form-control btn-xs" style="width: 100%">
                                                        <option value="">- Pilih Jabatan Administrator -</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="kdu4" id="field_kdu4" class="form-control btn-xs" style="width: 100%">
                                                        <option value="">- Pilih Pengawas -</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="kdu5" id="field_kdu5" class="form-control btn-xs" style="width: 100%">
                                                        <option value="">- Pilih Pelaksana (Eselon V) -</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <iframe id="tampungstruktur" class="tampungstruktur" src="<?php echo base_url() . 'peta_jabatan/index' ?>" frameborder="no" onload="resizeIframe(this)"></iframe>
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