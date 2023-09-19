<?php
ini_set('error_reporting', 0);
?>
<div class="container">
    <div class="innercontainer">
        <div id="contents ">
            <div id="contents-wrapper">
                <div id="container" class="clearfix">
                    <div id="center" class="column">
                        <div id="center-wrapper">
                            <div id="receiver_org">
                                <?php
                                foreach ($data_master as $r) {
                                    if ($r['SPESIAL'] == 'Y' AND $r['LEHER'] <> 'Y') {
                                        $spesial[] = $r;
                                        $leher = 'N';
                                    } else if ($r['SPESIAL'] == 'Y' AND $r['LEHER'] == 'Y') {
                                        $spesial[] = $r;
                                        $leher = 'Y';
                                    } else {
                                        $general[] = $r;
                                    }
                                }

                                if (count($spesial) > 0 AND $leher <> 'Y') {
                                    $c_spesial = "spesial_level";
                                } else if (count($spesial) > 0 AND $leher == 'Y') {
                                    $c_spesial = "spesial_solid";
                                } else {
                                    $c_spesial = "";
                                }
                                ?>
                                <?php
                                if (count($general) <> 0) {
                                    $class_width = (count($general) * 185);
                                } else {
                                    $class_width = 185;
                                }
                                ?>
<!-- script type="text/javascript" src="<?php // echo base_url();       ?>asset/js/thickbox/thickbox.js"></script -->
                                <div class="<?php echo $c_spesial ?> top_level">
                                    <!--div class="menteri" style="width:< ?=$class_width?>px;"
                                    <!--div class="box_item">
                                            <div class="item_menteri">
                                                    <h2>< ?=$menteri?></h2> 
                                                    <img class="photo" src="< ?=base_url()?>_uploads/photo_pegawai/thumbs/< ?=$menteri_desc['FOTO']?>" />
                                                    <div class="desc">
                                                            <h3>< ?=$menteri_desc['NAMAPEGAWAI']?></h3>
                                                    </div>
                                            </div>
                                    </div-->
                                    <!--<div class="level1" style="width:<?php // echo $class_width       ?>px;">-->
                                    <div class="level1" style="width:<?= $class_width ?>px;">
                                        <div class="box_item">
                                            <div class="item_level1 color-<?= $data_first['TKTESELON'] ?>">
                                                <h2><? //=$data_first['jabatan']                     ?><?= $data_first['NMUNIT'] ?></h2>
                                                <a href="javascript:;"> 
                                                    <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $data_first['FOTO'] ?>" />

                                                    <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $data_first['FOTO'] ?>" />
                                                    <div class="desc">
                                                        <h3><?= empty($data_first['GELAR_DEPAN']) ? '' : $data_first['GELAR_DEPAN'] . ' ' ?><?= $data_first['NAMAPEGAWAI'] ?><?= empty($data_first['GELAR_BLKG']) ? '' : ', ' . $data_first['GELAR_BLKG'] ?></h3>
                                                        <h3>NIP.&nbsp;<?= $data_first['NIPNEW'] ?></h3>
                                                        <!-- h3>Eselon. / TMT. <?php // echo $data_first['tmtjab']     ?></h3 -->
                                                        <!-- h3>Lhr. <?php // echo $data_first['TGLLAHIR']     ?></h3 -->
                                                        <?php
                                                        $masajab = "";
                                                        if (!empty($data_first['tmtjab'])) {
                                                            $umur = get_umur_jab(validateDate($data_first['tmtjab']));
                                                            $masajab = $umur['years'] . " Th. " . $umur['months'] . " Bl. " . $umur['days'] . " hr.";
                                                        }
                                                        ?>
                                                        <!-- h3>Masa Jab. <?php // echo $masajab ?></h3-->
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="border_spesial_level_r"><div></div></div>
                                        <div class="border_spesial_solid_r"><div></div></div>
                                        <div class="bsolid"><div></div></div>
                                        <div class="spesial">
                                            <?php
                                            $i = 1;
                                            foreach ($spesial as $r) {
                                                //if($r['leher']=='Y'){ $leher='leher'; } else { $leher=''; }

                                                if ($i == 1 AND count($spesial) <> 1) {
                                                    $class = "level2 level2_first";
                                                    $clear = "N";
                                                } else if ($i == count($spesial) AND count($spesial) <> 1) {
                                                    $class = "level2 level2_last";
                                                    $clear = "Y";
                                                } else if (count($spesial) == 1) {
                                                    $class = "level2 single";
                                                    $clear = "Y";
                                                } else {
                                                    $class = "level2";
                                                    $clear = "N";
                                                }
                                                ?>
                                                <div class="<?= $class ?>">
                                                    <div class="rsolid"><div></div></div>
                                                    <div class="box_item">
                                                        <div class="item_level2 color-<?= $r['TKTESELON'] ?>">
                                                            <a class="view-detail" href="javascript:;" data-id="<?= $r['ID'] ?>" data-url="<?php echo base_url()."peta_jabatan/view_detail" ?>" title="Lihat Detail">
                                                                <h2><? //=$r['jabatan']                     ?><?= $r['NMUNIT'] ?></h2>
                                                            </a>
                                                            <a class="view-detail" href="javascript:;" data-id="<?= $r['ID'] ?>" data-url="<?php echo base_url()."peta_jabatan/view_detail" ?>" title="Lihat Detail">
                                                                <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $r['FOTO'] ?>" />

                                                                <div class="desc">
                                                                    <h3><?= empty($r['GELAR_DEPAN']) ? '' : $r['GELAR_DEPAN'] . ' ' ?><?= $r['NAMAPEGAWAI'] ?><?= empty($r['GELAR_BLKG']) ? '' : ', ' . $r['GELAR_BLKG'] ?></h3>
                                                                    <h3>NIP.&nbsp;<?= $r['NIPNEW'] ?></h3>
                                                                    <!-- h3>Eselon. / TMT. <?php // echo $r['tmtjab']     ?></h3 -->
                                                                    <!-- h3>Lhr. <?php // echo $r['TGLLAHIR']     ?></h3 -->
                                                                    <?php
                                                                    $masajab = "";
                                                                    if (!empty($r['tmtjab'])) {
                                                                        $umur = get_umur_jab(validateDate($r['tmtjab']));
                                                                        $masajab = $umur['years'] . " Th. " . $umur['months'] . " Bl. " . $umur['days'] . " hr.";
                                                                    }
                                                                    ?>
                                                                    <h3>Masa Jab. <?= $masajab ?></h3>
                                                                </div>
                                                            </a>

                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if ($clear == 'Y') { ?><div class="clear"></div><?php } ?>
                                                <?php
                                                if ($r['leher'] <> 'Y') {
                                                    $i++;
                                                }
                                            }
                                            ?>
                                        </div>

                                        <div class="general">
                                            <div class="blok_org">
                                                <?php
                                                $i = 1;
                                                foreach ($general as $r) {

                                                    if ($i == 1 AND count($general) <> 1) {
                                                        $class = "level2 level2_first";
                                                        $clear = "N";
                                                    } else if ($i == count($general) AND count($general) <> 1) {
                                                        $class = "level2 level2_last";
                                                        $clear = "Y";
                                                    } else if (count($general) == 1) {
                                                        $class = "level2 single";
                                                        $clear = "Y";
                                                    } else {
                                                        $class = "level2";
                                                        $clear = "N";
                                                    }
                                                    ?>
                                                    <div class="<?= $class ?>">
                                                        <div class="tsolid"></div>
                                                        <div class="box_item">
                                                            <div class="item_level2 color-<?= $r['TKTESELON'] ?>">
                                                                <a class="view-detail" href="javascript:;" data-id="<?= $r['ID'] ?>" data-url="<?php echo base_url()."peta_jabatan/view_detail" ?>" title="Lihat Detail">
                                                                    <h2><? //=$r['jabatan']                     ?><?= $r['NMUNIT'] ?></h2>
                                                                </a>
                                                                <a class="view-detail" href="javascript:;" data-id="<?= $r['ID'] ?>" data-url="<?php echo base_url()."peta_jabatan/view_detail" ?>" title="Lihat Detail">
                                                                    <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $r['FOTO'] ?>" />

                                                                    <div class="desc">
                                                                        <h3><?= empty($r['GELAR_DEPAN']) ? '' : $r['GELAR_DEPAN'] . ' ' ?><?= $r['NAMAPEGAWAI'] ?><?= empty($r['GELAR_BLKG']) ? '' : ', ' . $r['GELAR_BLKG'] ?></h3>
                                                                        <h3>NIP.&nbsp;<?= $r['NIPNEW'] ?></h3>
                                                                        <!-- h3>Eselon. / TMT. <?php // echo $r['tmtjab']     ?></h3 -->
                                                                        <!-- h3>Lhr. <?php // echo $r['TGLLAHIR']     ?></h3 -->
                                                                        <?php
                                                                        $masajab = "";
                                                                        if (!empty($r['tmtjab'])) {
                                                                            $umur = get_umur_jab(validateDate($r['tmtjab']));
                                                                            $masajab = $umur['years'] . " Th. " . $umur['months'] . " Bl. " . $umur['days'] . " hr.";
                                                                        }
                                                                        ?>
                                                                        <h3>Masa Jab. <?= $masajab ?></h3>
                                                                    </div>
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if ($clear == 'Y') { ?><div class="clear"></div><?php } ?>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!--/div-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>