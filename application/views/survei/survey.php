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
                                    <a href="javascript:;">Survei</a>
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
                            <?php if($this->session->flashdata('error')){ ?>
                                <div class="alert alert-danger">
                                    <strong>Maaf!</strong> anda belum menjawab semua pertanyaan. 
                                </div>
                            <?php } ?>
                            <?php if($this->session->flashdata('sukses')){ ?>
                                <div class="alert alert-success">
                                    <strong>Terima Kasih!</strong> Atas pertisipasi anda dalam survey ini.
                                </div>
                                <?php header("Refresh:10;url=".site_url('akses/logout')); ?>
                            <?php } ?>
                            <?php if ($survey): ?>
                                <?php echo form_open(site_url('survei/proses_survey')); ?>
                                <?php foreach ($survey as $val): ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                        <div class="col-md-12"><?php echo $val['JUDUL'] ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="portlet light ">
                                                <div class="portlet-title">
                                                    <div class="caption"><?php echo $val['KETERANGAN'] ?></div>
                                                </div>
                                                <div class="portlet-body">
                                                    <table class="table table-striped">
                                                        <?php if ($pertanyaan[$val['ID']]): ?>
                                                            <?php
                                                            $d = 1;
                                                            foreach ($pertanyaan[$val['ID']] as $isi):
                                                                ?>
                                                                <tr>
                                                                    <td style="width: 2%;"><?php echo $d ?>.</td>
                                                                    <td><?php echo $isi['pertanyaan'] ?></td>
                                                                </tr>
                                                                <?php if ($isi['tipe'] == 1 && $isi['jawaban']): ?>
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <div class="mt-radio-inline">
                                                                                <?php foreach ($isi['jawaban'] as $muatan): ?>
                                                                                    <label class="mt-radio">
                                                                                        <input type="radio" name="pertanyaan[<?php echo $isi['id'] ?>]" id="optionsRadios<?php $muatan['ID'] ?>" value="<?php echo $muatan['ID'] ?>"> <?php echo $muatan['JAWABAN'] ?>
                                                                                        <span></span>
                                                                                    </label>
                                                                                <?php endforeach; ?>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php else: ?>
                                                                    <tr>
                                                                        <td colspan="2"><textarea name="pertanyaan[<?php echo $isi['id'] ?>]" class="form-control"></textarea></td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <?php
                                                                $d++;
                                                            endforeach;
                                                            ?>
                                                            <tr>
                                                                <td class="text-center" colspan="2"><button type="submit" class="btn btn-warning btn-circle"><i class="fa fa-check"></i> Simpan</button></td>
                                                            </tr>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td>Maaf tidak ada pertanyaan</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                                <?php echo form_close(); ?>
                            <?php else: ?>
                                <div class="row">
                                    <div class="col-md-12">Maaf survey tidak tersedia</div>
                                </div>
                            <?php endif; ?>
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