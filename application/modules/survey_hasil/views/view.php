<?php
$color = ['bg-blue-chambray bg-font-blue-chambray', 'bg-blue bg-font-blue', 'bg-green-seagreen bg-font-green-seagreen', 'bg-grey-salsa bg-font-grey-salsa', 'bg-yellow-soft bg-font-yellow-soft', 'bg-purple-sharp bg-font-purple-sharp'];
?>
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
                                        <a href="javascript:;">Survei</a>
                                        <i class="fa fa-angle-right"></i>
                                    </li>
                                    <li>
                                        <span><?= $title_utama ?></span>
                                    </li>
                                </ul>
                                <!-- END PAGE BREADCRUMBS -->
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
                            <?php if ($hasil_pilihan): ?>
                                <?php foreach ($hasil_pilihan as $val): ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                        <div class="col-md-12"><?php echo $val['pertanyaan'] ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="portlet light ">
                                                <div class="portlet-body">
                                                    <?php if ($val['hasil']): ?>
                                                        <?php
                                                        $hasiltotal = 0;
                                                        foreach ($val['hasil'] as $hasil):
                                                            $hasiltotal += $hasil['CAPAIAN'];
                                                        endforeach;
                                                        $j = 0;
                                                        ?>
                                                        <?php foreach ($val['hasil'] as $hasil): ?>
                                                            <?php
                                                            $hitung = ($hasil['CAPAIAN'] * 100) / $hasiltotal;
                                                            ?>
                                                            <span class="sr-only"> <?php echo number_format($hitung,2); ?>% Complete (success) </span> <?php echo $hasil['JAWABAN'] ?> ( <?php echo number_format($hitung,2); ?> ) %
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-success <?php echo $color[$j] ?>" role="progressbar" aria-valuenow="<?php echo number_format($hitung,2); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo number_format($hitung,2); ?>%">
                                                                    <span class="sr-only"> <?php echo number_format($hitung,2); ?>% Complete (success) </span> <?php echo number_format($hitung,2); ?>%
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $j++;
                                                        endforeach;
                                                        ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>

                            <?php endif; ?>
                            <?php if ($hasil_isian): ?>
                                <?php foreach ($hasil_isian as $val): ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                        <div class="col-md-12"><?php echo $val['pertanyaan'] ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($val['hasil']): ?>
                                        <?php foreach ($val['hasil'] as $hasil): ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="portlet light ">
                                                        <div class="portlet-body">
                                                            <?php echo $hasil['TRSURVEY_JAWABAN'] ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $j++;
                                        endforeach;
                                        ?>
                                    <?php endif; ?>
                                <?php endforeach ?>

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