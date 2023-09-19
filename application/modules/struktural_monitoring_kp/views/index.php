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
                                    <form action="#" class="form-horizontal" id="formpencarian" data-url="<?php echo site_url("struktural_monitoring_kp/pencarian_proses") ?>">
                                        <div class="form-body">
                                            <?php $this->load->view('system/unitkerja_form-horizontal_filter'); ?>
                                            <hr />
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Jenis KP</label>
                                                        <div class="col-md-7">
                                                            <select name="jenis_pangkat" id="jenis_pangkat" class="form-control" style="width: 100%">
                                                                <option value="1">&nbsp;Reguler</option>
                                                                <option value="2">&nbsp;Pilihan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Golongan Ruang</label>
                                                        <div class="col-md-7">
                                                            <select name="gol_pangkat" id="gol_pangkat" class="form-control" style="width: 100%">
                                                                <option value="">- Pilih Golongan Ruang -</option>
                                                                <?php if ($list_golongan_pangkat): ?>
                                                                    <?php foreach ($list_golongan_pangkat as $val): ?>
                                                                        <option value="<?php echo $val['ID'] ?>"><?php echo $val['NAMA'] ?></option>
                                                                    <?php endforeach ?>
                                                                <?php endif ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Eselon</label>
                                                        <div class="col-md-7">
                                                            <select name="eselon_id" id="eselon_id" class="form-control" style="width: 100%">
                                                                <option value="">- Pilih Eselon -</option>
                                                                <?php if ($list_eselon_struktural): ?>
                                                                    <?php foreach ($list_eselon_struktural as $val): ?>
                                                                        <option value="<?php echo $val['ID'] ?>"><?php echo $val['NAMA'] ?></option>
                                                                    <?php endforeach ?>
                                                                <?php endif ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Bulan / Tahun</label>
                                                        <div class="col-md-3">
                                                            <select name="bulan" id="bulan" class="form-control" style="width: 100%">
                                                                <option value="04">April</option>
                                                                <option value="10">Oktober</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select name="tahun" id="tahun" class="form-control" style="width: 100%">
                                                                <?php for ($t=2010;$t<=2030;$t++) { ?>
                                                                    <?php
                                                                    $selec = '';
                                                                    if ($t==date('Y'))
                                                                        $selec = 'selected=""';
                                                                    ?>
                                                                    <option <?=$selec;?> value="<?=$t?>"><?=$t?></option>
                                                                <?php } ?>
                                                            </select>
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