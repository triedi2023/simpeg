<?php
header("Content-Type: application/vnd.ms-word");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Report.doc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title><?= $title; ?></title>
        <?php $this->load->view('head_admin'); ?>
        <link type="text/css" rel="stylesheet" href="<?= base_url(); ?>asset/theme/blue/app/css/organisasi.css"/>
        <link href="<?php echo base_url(); ?>asset/theme/blue/app/css/organisasi_print.css" media="print" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php
        foreach ($data_master as $r) {
            if ($r['posisi_leher'] == 'R') {
                $leher_r[] = $r;
            } else if ($r['posisi_leher'] == 'L') {
                $leher_l[] = $r;
            } else if ($r['posisi_leher'] == 'S') {
                $staff_ahli[] = $r;
            } else {
                $general[] = $r;
            }
        }
//                                    print '<pre>';
//                                    print_r($leher_r);
        if (count($leher_r) > 0 AND count($leher_l) > 0) {
            $spesial_r = "spesial_r";
            $spesial_l = "spesial_l";
        } else if (count($leher_r) > 0 AND count($leher_l) == 0) {
            $spesial_r = "spesial_r";
            $spesial_l = "";
        } else if (count($leher_r) == 0 AND count($leher_l) > 0) {
            $spesial_r = "";
            $spesial_l = "spesial_l";
        } else {
            $spesial_r = "";
            $spesial_l = "";
        }
        if (count($leher_r[0]['detail']) > 0) {
            $spesial_footer = "spesial_footer";
        } else {
            $spesial_footer = "";
        }

        if (count($staff_ahli) > 0) {
            $spesial_staff_ahli = "spesial_staff_ahli";
        } else {
            $spesial_staff_ahli = "";
        }
        //print "<pre>";
        //print_r($data_master);
        //print "</pre>";
        ?>
        <?php
        if (count($general) % 2 <> 0 AND count($leher_r[0]['detail']) <> 0) {
            $tambah = 200;
        } else {
            $tambah = 0;
        }
        if (count($general) <> 0) {
            $class_width = (count($general) * 200) + $tambah;
        } else {
            $class_width = 200 + $tambah;
        }
        ?>
        <div id="receiver_org">
            <div class="<?= $spesial_r ?> <?= $spesial_l ?> <?= $spesial_footer ?> <?= $spesial_staff_ahli ?>">
                <div class="menteri" style="width:<?= $class_width ?>px;">

                    <div class="box_item">
                        <div class="item_menteri">
                            <div class="right">
                                <h2 style="color:#fff"><?= "KEPALA BASARNAS" ?></h2>
                                <img class="photo" src="<?= base_url() ?>_uploads/photo_menteri/thumbs/<?php echo $menteri['foto'] ?>" />
                                <!--<div class="desc">-->
                                    <!--<h3><?php // echo $menteri['nama']         ?></h3>-->
                                <!--</div>-->
                            </div>
                            <div class="left">
                                <!--<h2><?php //  $wmenteri         ?></h2>-->
                                <h2 style="color: #fff;"><?php echo empty($menteri['gelar_depan']) ? '' : $menteri['gelar_depan'] . " "; ?><?php echo $menteri['nama'] ?><?php echo empty($menteri['gelar_blkg']) ? '' : " " . $menteri['gelar_blkg']; ?></h2>
                                <!--<img class="photo" src="<?php //  base_url()         ?>_uploads/photo_pegawai/thumbs/<?php // $wmenteri_desc['foto']         ?>" />-->
                                <!--<div class="desc">-->
                                    <!--<h3><?php // $wmenteri_desc['nama']         ?></h3>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                    <div class="level_staff_ahli">
                        <div class="rsolid"></div>
                        <div class="staff_title"><div class="inner_title"><h1>Staf Ahli</h1></div><div class="lsolid">&lt;</div></div>								
                        <div class="box_item" style="padding-top:-10px;margin-top:-30px">
                            <div class="item_staff_ahli">
                                <div class="left">
                                    <ul>
                                        <?php
                                        $j = 1;
                                        foreach ($staff_ahli as $s) {
                                            ?>
                                            <li> <?= $s['nmunit'] ?><br><b><?= empty($s['gelar_depan']) ? '' : $s['gelar_depan'] . ' ' ?><?= $s['nama'] ?><?= empty($s['gelar_blkg']) ? '' : ', ' . $s['gelar_blkg'] ?></b></li>
                                            <?php
                                            $j++;
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bsolid"><div></div></div>
                    <div class="level_spesial_box">
                        <div class="level_spesial_l">
                            <div class="hsolid_c_r">
                                <div></div>
                            </div>
                            <div class="box_item">
                                <div class="item_spesial_l color-<?= $leher_l[0]['tktesel'] ?>">
                                    <h2><? //=$leher_l[0]['jabatan']                             ?><?= $leher_l[0]['nmunit'] ?></h2>

                                    <a href="<?= base_url() ?><?= $leher_l[0]['url_link'] ?>?keepThis=true&type=image&TB_iframe=1&width=1024&height=566&modal=true"  class="thickbox "> 
                                        <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $leher_l[0]['foto'] ?>" />

                                        <div class="desc">
                                            <h3><?= empty($leher_l[0]['gelar_depan']) ? '' : $leher_l[0]['gelar_depan'] . ' ' ?><?= $leher_l[0]['nama'] ?><?= empty($leher_l[0]['gelar_blkg']) ? '' : ', ' . $leher_l[0]['gelar_blkg'] ?></h3>
                                            <h3><?= $leher_l[0]['nip'] ?></h3>
                                            <h3><?php echo $leher_l[0]['pangkatgol'] ?></h3>
                                            <!-- h3>Lhr. <?php // echo $leher_l[0]['tgllahir']    ?></h3 -->
                                            <?php
//                                                                        $masajab = "";
//                                                                        if (!empty($leher_l[0]['tmtjab'])) {
//                                                                            $umur = get_umur_jab(validateDate($leher_l[0]['tmtjab']));
//                                                                            $masajab = $umur['years'] . " Th. " . $umur['months'] . " Bl. " . $umur['days'] . " hr.";
//                                                                        }
                                            ?>
                                            <!-- h3>Masa Jab. <?php // echo $masajab    ?></h3 -->
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="level_spesial_r">
                            <div class="hsolid_c_l">
                                <div></div>
                            </div>
                            <div class="box_item">
                                <div class="item_spesial_r color-<?= $leher_r[0]['tktesel'] ?>">
                                    <h2><? //=$leher_r[0]['jabatan']   ?><?= $leher_r[0]['nmunit'] ?></h2>

                                    <a href="<?= base_url() ?><?= $leher_r[0]['url_link'] ?>?keepThis=true&type=image&TB_iframe=1&width=1024&height=566&modal=true"  class="thickbox "> 
                                        <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $leher_r[0]['foto'] ?>" />

                                        <div class="desc">
                                            <h3><?= empty($leher_r[0]['gelar_depan']) ? '' : $leher_r[0]['gelar_depan'] . ' ' ?><?= $leher_r[0]['nama'] ?><?= empty($leher_r[0]['gelar_blkg']) ? '' : ', ' . $leher_r[0]['gelar_blkg'] ?></h3>
                                            <h3><?= $leher_r[0]['nip'] ?></h3>
                                            <h3><?= $leher_r[0]['pangkatgol'] ?></h3>
                                            <!-- h3>Lhr. <?php // echo $leher_r[0]['tgllahir']    ?></h3 -->
                                            <?php
//                                                                        $masajab = "";
//                                                                        if (!empty($leher_r[0]['tmtjab'])) {
//                                                                            $umur = get_umur_jab(validateDate($leher_r[0]['tmtjab']));
//                                                                            $masajab = $umur['years'] . " Th. " . $umur['months'] . " Bl. " . $umur['days'] . " hr.";
//                                                                        }
                                            ?>
                                            <!-- h3>Masa Jab. <?php // echo $masajab    ?></h3 -->
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="hfooter_c">
                        <div></div>
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
                                        <div class="item_level2 color-<?= $r['tktesel'] ?>">
                                            <h2><? //=$r['jabatan']        ?><?= $r['nmunit'] ?></h2>
                                            <a href="<?= base_url() ?><?= $r['url_link'] ?>?keepThis=true&type=image&TB_iframe=1&width=1024&height=566&modal=true"  class="thickbox "> 
                                                <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $r['foto'] ?>" />

                                                <div class="desc">
                                                    <h3><?= empty($r['gelar_depan']) ? '' : $r['gelar_depan'] . ' ' ?><?= $r['nama'] ?><?= empty($r['gelar_blkg']) ? '' : ', ' . $r['gelar_blkg'] ?></h3>
                                                    <h3><?= $r['nip'] ?></h3>
                                                    <h3><?= $r['pangkatgol'] ?></h3>
                                                    <!-- h3>Lhr. <?php // echo $r['tgllahir']    ?></h3 -->
                                                    <?php
//                                                                                $masajab = "";
//                                                                                if (!empty($r['tmtjab'])) {
//                                                                                    $umur = get_umur_jab(validateDate($r['tmtjab']));
//                                                                                    $masajab = $umur['years'] . " Th. " . $umur['months'] . " Bl. " . $umur['days'] . " hr.";
//                                                                                }
                                                    ?>
                                                    <!-- h3>Masa Jab. <?php // echo $masajab    ?></h3 -->
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

                    <div class="class_spesial_footer">
                        <?php
                        if (count($leher_r[0]['detail']) <> 0) {
                            $class_width_footer = (count($leher_r[0]['detail']) * 200);
                        } else {
                            $class_width_footer = 200;
                        }
                        ?>
                        <div class="blok_org" style="width:<?= $class_width_footer ?>px;">
                            <?php
                            $i = 1;
                            foreach ($leher_r[0]['detail'] as $r) {

                                if ($i == 1 AND count($leher_r[0]['detail']) <> 1) {
                                    $class_footer = "level_spesial_footer level_spesial_footer_first";
                                    $clear = "N";
                                } else if ($i == count($leher_r[0]['detail']) AND count($leher_r[0]['detail']) <> 1) {
                                    $class_footer = "level_spesial_footer level_spesial_footer_last";
                                    $clear = "Y";
                                } else if (count($general) == 1) {
                                    $class_footer = "level_spesial_footer single";
                                    $clear = "Y";
                                } else {
                                    $class_footer = "level_spesial_footer";
                                    $clear = "N";
                                }
                                ?>
                                <div class="<?= $class_footer ?>">
                                    <div class="tsolid"></div>
                                    <div class="box_item">
                                        <div class="item_spesial_footer color-<?= $r['tktesel'] ?>">
                                            <h2><? //=$r['jabatan']                             ?><?= $r['nmunit'] ?></h2>
                                            <a href="<?= base_url() ?><?= $r['url_link'] ?>?keepThis=true&type=image&TB_iframe=1&width=1024&height=566&modal=true"  class="thickbox "> 
                                                <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $r['foto'] ?>" />

                                                <div class="desc">
                                                    <h3><?= empty($r['gelar_depan']) ? '' : $r['gelar_depan'] . ' ' ?><?= $r['nama'] ?><?= empty($r['gelar_blkg']) ? '' : ', ' . $r['gelar_blkg'] ?></h3>
                                                    <h3><?= $r['nip'] ?> </h3>
                                                    <h3><?= $r['pangkatgol'] ?></h3>
                                                    <!-- h3>Lhr. <?= $r['tgllahir'] ?></h3 -->
                                                    <?php
//                                                                                $masajab = "";
//                                                                                if (!empty($r['tmtjab'])) {
//                                                                                    $umur = get_umur_jab(validateDate($r['tmtjab']));
//                                                                                    $masajab = $umur['years'] . " Th. " . $umur['months'] . " Bl. " . $umur['days'] . " hr.";
//                                                                                }
                                                    ?>
                                                    <!-- h3>Masa Jab. <?php // echo $masajab    ?></h3 -->
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
                    <?php if (count($leher_r[0]['detail']) > 0) { ?>
                        <div class="jalur_koor_t_r"><div></div></div>
                        <div class="jalur_koor_c_r"><div></div></div>
                        <div class="jalur_koor_b_r"><div></div></div>
                            <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>