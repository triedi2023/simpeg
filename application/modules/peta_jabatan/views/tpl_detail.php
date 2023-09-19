<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                                    if ($r['PELENGKAP'] == 'Y') {
                                        $pelengkap[] = $r;
                                    } else {
                                        $general[] = $r;
                                    }
                                }
                                if (count($pelengkap) > 0 AND count($general) <> 0) {
                                    $class_pelengkap = "direct";
                                } else if (count($pelengkap) > 0 AND count($general) == 0) {
                                    $class_pelengkap = "direct_single";
                                } else {
                                    $class_pelengkap = "";
                                }
                                ?>
                                <div>
                                    <?php
                                    if (count($data_master) <> 0) {
                                        $class_width = (count($data_master) * 185);
                                    } else {
                                        $class_width = 185;
                                    }
                                    ?>
                                    <div class="level1 <?= $class_pelengkap ?> " style="width:<?= $class_width ?>px;">
                                        <div class="back"><a class="view-back" href="javascript:;" data-id="<?= $data_first['ID'] ?>" data-url="<?php echo base_url()."peta_jabatan/view_back" ?>" title="Kembali">Kembali</a></div>
                                        <div class="bsolid"><div></div></div>
                                        <div class="box_item">

                                            <div class="item_level1 color-<?= $data_first['TKTESELON'] ?>">
                                                <h2>
                                                    <? //=$data_first['jabatan']  ?>
                                                    <?= $data_first['NMUNIT'] ?>
                                                </h2>
                                                <a href="javascript:;"> 
                                                    <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $data_first['FOTO'] ?>" /> 
                                                    <div class="desc">
                                                        <h3>
                                                            <?= empty($data_first['GELAR_DEPAN']) ? '' : $data_first['GELAR_DEPAN'] . ' ' ?><?= $data_first['NAMAPEGAWAI'] ?><?= empty($data_first['GELAR_BLKG']) ? '' : ', ' . $data_first['GELAR_BLKG'] ?>
                                                        </h3>
                                                        <h3>NIP.&nbsp;
                                                            <?= $data_first['NIPNEW'] ?>
                                                        </h3>
                                                        <h3>Eselon. / TMT.
                                                            <?= $data_first['TGLLAHIR'] ?>
                                                        </h3>
                                                        <h3>Lhr.
                                                            <?= $data_first['TGLLAHIR'] ?>
                                                        </h3>
                                                        <?php
                                                        $masajab = "";
                                                        if (!empty($data_first['tmtjab'])) {
                                                            $umur = get_umur_jab(validateDate($data_first['tmtjab']));
                                                            $masajab = $umur['years'] . " Th. " . $umur['months'] . " Bl. " . $umur['days'] . " hr.";
                                                        }
                                                        ?>
                                                        <h3>Masa Jab. <?= $masajab ?></h3>
                                                    </div>
                                                </a> </div>

                                        </div><div class="bsolid"><div></div></div>
                                        <div class="rsolid_direct"></div>
                                        <?php
                                        $i = 1;
                                        $ip = 0;
                                        foreach ($data_master as $r) {
                                            if (count($r['detail']) == 0) {
                                                $not_child = " not_child";
                                            } else {
                                                $not_child = "";
                                            }
                                            if ($i == 1 AND $r['PELENGKAP'] <> 'Y' AND count($data_master) <> 1) {
                                                $class = "level2 level2_first " . $not_child;
                                            } else if ($r['PELENGKAP'] == 'Y' AND count($data_master) <> 1) {
                                                $class = "level2 level2_direct " . $not_child;
                                            } else if ($i == count($data_master) - $ip AND count($data_master) <> 1) {
                                                $class = "level2 level2_last " . $not_child;
                                            } else if (count($data_master) == 1) {
                                                $class = "level2 single " . $not_child;
                                            } else {
                                                $class = "level2 " . $not_child;
                                            }
                                            ?>
                                            <div class="<?= $class ?>"><div class="tsolid"><div></div></div>
                                                <?php // if (trim($r2['nmunit']) != '-') { ?>
                                                <div class="box_item">
                                                    <?php if ($r['TKTESELON'] == '6') { ?>
                                                        <div class="item_level2 color-6"> 
                                                            <?php if ($r['JABATAN'] != "") { ?>
                                                                <!-- a href="<?php // echo base_url() ?><?php // echo $r['URL_LINK'] ?>?keepThis=true&type=image&TB_iframe=1&width=1024&height=566&modal=true"  class="thickbox " -->
                                                                <a href="javascript:;"  class="thickbox ">
                                                                    <h2><b><?= $r['JABATAN'] ?></b><br>Jumlah : <?= $r['JUMLAH'] ?></h2>
                                                                </a>
                                                            <?php } else { ?>
                                                                <h2><b><?= $r['JABATAN'] ?></b><br>Jumlah : <?= $r['JUMLAH'] ?></h2>
                                                            <?php } ?> 
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="item_level2 color-<?= $r['TKTESELON'] ?>"> 
                                                            <a class="view-detail" href="javascript:;" data-id="<?= $r['ID'] ?>" data-url="<?php echo base_url()."peta_jabatan/view_detail" ?>" title="Lihat Detail">
                                                                <h2><? // =$r['jabatan']   ?><?= $r['NMUNIT'] ?></h2>
                                                            </a>
                                                            <a class="view-detail" href="javascript:;" data-id="<?= $r['ID'] ?>" data-url="<?php echo base_url()."peta_jabatan/view_detail" ?>" title="Lihat Detail">
                                                                <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $r['FOTO'] ?>" />
                                                                <div class="desc">
                                                                    <h3><?= empty($r['GELAR_DEPAN']) ? '' : $r['GELAR_DEPAN'] . ' ' ?><?= $r['NAMAPEGAWAI'] ?><?= empty($r['GELAR_BLKG']) ? '' : ', ' . $r['GELAR_BLKG'] ?></h3>
                                                                    <h3>NIP.&nbsp;<?= $r['NIPNEW'] ?></h3>
                                                                    <!-- h3>Eselon. / TMT.<?php // echo $r['tmtjab']    ?></h3 -->
                                                                    <!-- h3>Lhr.<?php // echo $r['tgllahir']    ?></h3 --->
                                                                    <?php
//                                                                            $masajab = "";
//                                                                            if (!empty($r['tmtjab'])) {
//                                                                                $umur = get_umur_jab(validateDate($r['tmtjab']));
//                                                                                $masajab = $umur['years'] . " Th. " . $umur['months'] . " Bl. " . $umur['days'] . " hr.";
//                                                                            }
                                                                    ?>
                                                                    <!-- h3>Masa Jab. <?php // echo $masajab    ?></h3 -->
                                                                </div>
                                                            </a> 
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <?php // } ?>
                                                <div class="bsolid"><div></div></div>
                                                <?php
                                                $j = 1;
                                                foreach ($r['detail'] as $r2) {
                                                    if (count($r2['detail']) == 0) {
                                                        $not_child = " not_child";
                                                    } else {
                                                        $not_child = "";
                                                    }
                                                    if ($j == 1 AND count($r['detail']) <> 1) {
                                                        $class2 = "level3 level3_first " . $not_child;
                                                    } else if (($j == count($r['detail']))AND ( count($r['detail']) <> 1)) {
                                                        $class2 = "level3 level3_last " . $not_child;
                                                    } else if (count($r['detail']) == 1) {
                                                        $class2 = "level3 single " . $not_child;
                                                    } else {
                                                        $class2 = "level3 " . count($r['detail']) . '-' . $j . "  " . $not_child;
                                                    }
                                                    ?>
                                                    <div class="<?= $class2 ?>">
                                                        <div class="tsolid"><div></div></div>
                                                        <div class="lsolid"><div></div></div>
                                                        <?php // if (trim($r2['nmunit']) != '-') { ?>
                                                        <div class="box_item">
                                                            <?php if ($r2['TKTESELON'] == '6') { ?>
                                                                <div class="item_level3 color-6">
                                                                    <?php if ($r2['JABATAN'] != "") { ?> 
                                                                        <a href="<?= base_url() ?><?= $r2['URL_LINK'] ?>?keepThis=true&type=image&TB_iframe=1&width=1024&height=566&modal=true"  class="thickbox ">
                                                                            <h2><b><?= $r2['JABATAN'] ?></b><br>Jumlah : <?= $r2['JUMLAH'] ?></h2>
                                                                        </a> 
                                                                    <?php } else { ?>
                                                                        <h2><b><?= $r2['JABATAN'] ?></b><br>Jumlah : <?= $r2['JUMLAH'] ?></h2>
                                                                    <?php } ?>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="item_level3 color-<?= $r2['TKTESELON'] ?>"> 
                                                                    <a class="view-detail" href="javascript:;" data-id="<?= $r2['ID'] ?>" data-url="<?php echo base_url()."peta_jabatan/view_detail" ?>" title="Lihat Detail">
                                                                        <h2><? //=$r2['jabatan']                                      ?><?= $r2['NMUNIT'] ?></h2>
                                                                    </a> 
                                                                    <a class="view-detail" href="javascript:;" data-id="<?= $r2['ID'] ?>" data-url="<?php echo base_url()."peta_jabatan/view_detail" ?>" title="Lihat Detail">
                                                                        <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $r2['FOTO'] ?>" />
                                                                        <div class="desc">
                                                                            <h3>
                                                                                <?= empty($r2['GELAR_DEPAN']) ? '' : $r2['GELAR_DEPAN'] . ' ' ?><?= $r2['NAMAPEGAWAI'] ?><?= empty($r2['GELAR_BLKG']) ? '' : ', ' . $r2['GELAR_BLKG'] ?>
                                                                            </h3>
                                                                            <h3>NIP.&nbsp;
                                                                                <?= $r2['NIPNEW'] ?>
                                                                            </h3>
                                                                            <h3>Eselon. / TMT.
                                                                                <?= $r2['tmtjab'] ?>
                                                                            </h3>
                                                                            <h3>Lhr.
                                                                                <?= $r2['tgllahir'] ?>
                                                                            </h3>
                                                                            <?php
                                                                            $masajab = "";
                                                                            if (!empty($r2['tmtjab'])) {
                                                                                $umur = get_umur_jab(validateDate($r2['tmtjab']));
                                                                                $masajab = $umur['years'] . " Th. " . $umur['months'] . " Bl. " . $umur['days'] . " hr.";
                                                                            }
                                                                            ?>
                                                                            <h3>Masa Jab. <?= $masajab ?></h3>
                                                                        </div>
                                                                    </a> 
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <?php // } ?>
                                                    </div>
                                                    <?php
                                                    $j++;
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            if ($r['PELENGKAP'] <> 'Y') {
                                                $i++;
                                            } else {
                                                $ip++;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>