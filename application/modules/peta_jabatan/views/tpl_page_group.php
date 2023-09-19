<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title><?= $title; ?></title>
        <?php $this->load->view('head_admin'); ?>
        <link type="text/css" rel="stylesheet" href="<?= base_url(); ?>asset/theme/blue/app/css/organisasi.css"/>
        <link href="<?php echo base_url(); ?>asset/theme/blue/app/css/organisasi_print.css" media="print" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            var gAutoPrint = true;
            function printSpecial()
            {
                if (document.getElementById != null)
                {
                    var html = '<HTML>\n<HEAD>\n';

                    if (document.getElementsByTagName != null)
                    {
                        var headTags = document.getElementsByTagName("head");
                        if (headTags.length > 0)
                            html += headTags[0].innerHTML;
                    }

                    html += '\n</HE>\n<BODY>\n';

                    var printReadyElem = document.getElementById("printReady");

                    if (printReadyElem != null)
                    {
                        html += printReadyElem.innerHTML;
                    } else
                    {
                        alert("Could not find the printReady function");
                        return;
                    }

                    html += '\n</BO>\n</HT>';

                    var printWin = window.open("", "printSpecial");
                    printWin.document.open();
                    printWin.document.write(html);
                    printWin.document.close();
                    if (gAutoPrint)
                        printWin.print();
                } else
                {
                    alert("The print ready feature is only available if you are using an browser. Please update your browswer.");
                }
            }
            jQuery(document).ready(function () {

                jQuery("select#lok").live('change', function () {
                    jQuery('#loading-mask').toggle();

                    $("select#kdu1").empty().append('<option value="00">- Pilih Jabatan Pimpinan Tinggi Madya -</option>');
                    $("select#kdu2").empty().append('<option value="00">- Pilih Jabatan Pimpinan Tinggi Pratama -</option>');
                    $("select#kdu3").empty().append('<option value="000">- Jabatan Administrator -</option>');
                    $("select#kdu4").empty().append('<option value="000">- Pilih Pelaksana -</option>');
                    $("select#kdu5").empty().append('<option value="00">- Pilih Pelaksana (Eselon V) -</option>');

                    jQuery.post("<?= base_url() . 'peta_jabatan/pilih_lokasi'; ?>",
                            {
                                'action': 'select_lok',
                                'cookie': encodeURIComponent(document.cookie),
                                'lok': jQuery("#lok").val(),
                                'kdu1': jQuery("#kdu1").val(),
                            },
                            function (response)
                            {
//                                response = response.substr(0, response.length - 1);
                                response = response.substr(1);
                                response = response.split('[[SPLIT]]');
                                jQuery("#receiver_kdu1").fadeOut(200,
                                        function () {
                                            jQuery("#receiver_kdu1").html(response[1]);
                                            jQuery("#receiver_kdu1").fadeIn(200);
                                            jQuery("#receiver_org").html(response[2]);
                                            jQuery("#receiver_org").fadeIn(200);
                                            jQuery('#loading-mask').hide();
                                        }
                                );
                            });
                    return false;
                });

                jQuery("select#kdu1").live('change', function () {
                    jQuery('#loading-mask').toggle();

                    if ($(this).val() == "00" || $(this).val() == "") {
                        $("select#kdu2").empty().append('<option value="00">- Pilih Jabatan Pimpinan Tinggi Pratama -</option>');
                        $("select#kdu3").empty().append('<option value="000">- Jabatan Administrator -</option>');
                        $("select#kdu4").empty().append('<option value="000">- Pilih Pelaksana -</option>');
                        $("select#kdu5").empty().append('<option value="00">- Pilih Pelaksana (Eselon V) -</option>');
                    }

                    jQuery.post("<?= site_url() . 'peta_jabatan/peta_jabatan/pilih_kdu1'; ?>", {
                        'action': 'view_kdu1',
                        'lok': jQuery("#lok").val(),
                        'kdu1': jQuery("#kdu1").val(),
                        'kdu2': jQuery("#kdu2").val(),
                        'kdu3': jQuery("#kdu3").val(),
                        'kdu4': jQuery("#kdu4").val(),
                        'kdu5': jQuery("#kdu5").val()
                    }, function (response) {
                        response = response.substr(0, response.length - 1);
                        response = response.split('[[SPLIT]]');
                        jQuery("#receiver_kdu2").fadeOut(200, function () {
                            jQuery("#receiver_kdu2").html(response[1]);
                            jQuery("#receiver_kdu2").fadeIn(200);
                            jQuery('#loading-mask').hide();
                        });
                    });
                    jQuery.post("<?= site_url() . 'peta_jabatan/peta_jabatan/view_master'; ?>", {
                        'action': 'kdu1',
                        'lok': jQuery('select#lok').val(),
                        'kdu1': jQuery('select#kdu1').val(),
                        'kdu2': jQuery('select#kdu2').val(),
                        'kdu3': jQuery('select#kdu3').val(),
                        'kdu4': jQuery('select#kdu4').val(),
                        'kdu5': jQuery('select#kdu5').val()
                    }, function (response) {
                        response = response.substr(1);
                        response = response.split('[[SPLIT]]');
                        jQuery("#receiver_org").fadeOut(200, function () {
                            //jQuery('#loading-mask').toggle();
                            jQuery("#receiver_org").html(response[1]);
                            jQuery("#receiver_org").slideDown(200);
//                            jQuery('#loading-mask').hide();
                        });
                    });
                    return false;
                });

                jQuery("select#kdu2").live('change', function () {
                    jQuery('#loading-mask').toggle();

                    if ($(this).val() == "00" || $(this).val() == "") {
                        $("select#kdu3").empty().append('<option value="000">- Jabatan Administrator -</option>');
                        $("select#kdu4").empty().append('<option value="000">- Pilih Pelaksana -</option>');
                        $("select#kdu5").empty().append('<option value="00">- Pilih Pelaksana (Eselon V) -</option>');
                    }

                    jQuery.post("<?= site_url() . 'peta_jabatan/peta_jabatan/pilih_kdu2'; ?>", {
                        'action': 'view_kdu2',
                        'lok': jQuery("#lok").val(),
                        'kdu1': jQuery("#kdu1").val(),
                        'kdu2': jQuery("#kdu2").val(),
                        'kdu3': jQuery("#kdu3").val(),
                        'kdu4': jQuery("#kdu4").val(),
                        'kdu5': jQuery("#kdu5").val()
                    }, function (response) {
                        response = response.substr(0, response.length - 1);
                        response = response.split('[[SPLIT]]');
                        jQuery("#receiver_kdu3").fadeOut(200, function () {
                            jQuery("#receiver_kdu3").html(response[1]);
                            jQuery("#receiver_kdu3").fadeIn(200);
                        });
                    });
                    jQuery.post("<?= site_url() . 'peta_jabatan/peta_jabatan/view_master'; ?>", {
                        'action': 'kdu1',
                        'lok': jQuery('select#lok').val(),
                        'kdu1': jQuery('select#kdu1').val(),
                        'kdu2': jQuery('select#kdu2').val()
                    }, function (response) {
                        response = response.substr(1);
                        response = response.split('[[SPLIT]]');
                        jQuery("#receiver_org").fadeOut(200, function () {
                            jQuery("#receiver_org").html(response[1]);
                            jQuery("#receiver_org").slideDown(200);
                            jQuery('#loading-mask').hide();
                        });
                    });
                    return false;
                });

                jQuery("select#kdu3").live('change', function () {
                    jQuery('#loading-mask').toggle();
                    if ($(this).val() == "000" || $(this).val() == "") {
                        $("select#kdu4").empty().append('<option value="000">- Pilih Pelaksana -</option>');
                        $("select#kdu5").empty().append('<option value="00">- Pilih Pelaksana (Eselon V) -</option>');
                    }
                    jQuery.post("<?= site_url() . 'peta_jabatan/peta_jabatan/pilih_kdu3'; ?>", {
                        'action': 'view_kdu3',
                        'lok': jQuery("#lok").val(),
                        'kdu1': jQuery("#kdu1").val(),
                        'kdu2': jQuery("#kdu2").val(),
                        'kdu3': jQuery("#kdu3").val(),
                        'kdu4': jQuery("#kdu4").val(),
                        'kdu5': jQuery("#kdu5").val()
                    }, function (response) {
                        response = response.substr(0, response.length - 1);
                        response = response.split('[[SPLIT]]');
                        jQuery("#receiver_kdu4").fadeOut(200, function () {
                            jQuery("#receiver_kdu4").html(response[1]);
                            jQuery("#receiver_kdu4").fadeIn(200);
                            jQuery('#loading-mask').hide();
                        });
                    });
                    jQuery.post("<?= site_url() . 'peta_jabatan/peta_jabatan/view_master'; ?>", {
                        'action': 'kdu3',
                        'lok': jQuery('select#lok').val(),
                        'kdu1': jQuery('select#kdu1').val(),
                        'kdu2': jQuery('select#kdu2').val(),
                        'kdu3': jQuery('select#kdu3').val(),
                        'kdu4': jQuery('select#kdu4').val(),
                        'kdu5': jQuery('select#kdu5').val()
                    }, function (response) {
                        response = response.substr(1);
                        response = response.split('[[SPLIT]]');
                        jQuery("#receiver_org").fadeOut(200, function () {
                            jQuery('#loading-mask').toggle();
                            jQuery("#receiver_org").html(response[1]);
                            jQuery("#receiver_org").slideDown(200);
                            jQuery('#loading-mask').hide();
                        });
                    });
                    return false;
                });

                jQuery("select#kdu4").live('change', function () {
                    jQuery('#loading-mask').toggle();
                    if ($(this).val() == "000" || $(this).val() == "") {
                        $("select#kdu5").empty().append('<option value="00">- Pilih Pelaksana (Eselon V) -</option>');
                    } else {
                        jQuery.post("<?= site_url() . 'peta_jabatan/peta_jabatan/pilih_kdu4'; ?>", {
                            'action': 'view_kdu4',
                            'lok': jQuery("#lok").val(),
                            'kdu1': jQuery("#kdu1").val(),
                            'kdu2': jQuery("#kdu2").val(),
                            'kdu3': jQuery("#kdu3").val(),
                            'kdu4': jQuery("#kdu4").val(),
                            'kdu5': jQuery("#kdu5").val()
                        }, function (response) {
                            response = response.substr(0, response.length - 1);
                            response = response.split('[[SPLIT]]');
                            jQuery("#receiver_kdu5").fadeOut(200, function () {
                                jQuery("#receiver_kdu5").html(response[1]);
                                jQuery("#receiver_kdu5").fadeIn(200);
                                jQuery('#loading-mask').hide();
                            });
                        });
                    }

                    jQuery.post("<?= site_url() . 'peta_jabatan/peta_jabatan/view_master'; ?>", {
                        'action': 'kdu1',
                        'lok': jQuery('select#lok').val(),
                        'kdu1': jQuery('select#kdu1').val(),
                        'kdu2': jQuery('select#kdu2').val(),
                        'kdu3': jQuery('select#kdu3').val(),
                        'kdu4': jQuery('select#kdu4').val(),
                        'kdu5': jQuery('select#kdu5').val()
                    }, function (response) {
                        response = response.substr(1);
                        response = response.split('[[SPLIT]]');
                        jQuery("#receiver_org").fadeOut(200, function () {
                            jQuery('#loading-mask').toggle();
                            jQuery("#receiver_org").html(response[1]);
                            jQuery("#receiver_org").slideDown(200);
                            jQuery('#loading-mask').hide();
                        });
                    });

                    return false;
                });

                jQuery("select#kdu5").live('change', function () {
                    jQuery('#loading-mask').toggle();
                    jQuery.post("<?= site_url() . 'peta_jabatan/peta_jabatan/view_detail'; ?>", {
                        'action': 'kdu1',
                        'lok': jQuery('select#lok').val(),
                        'kdu1': jQuery('select#kdu1').val(),
                        'kdu2': jQuery('select#kdu2').val(),
                        'kdu3': jQuery('select#kdu3').val(),
                        'kdu4': jQuery('select#kdu4').val(),
                        'kdu5': jQuery('select#kdu5').val()
                    }, function (response) {
                        response = response.substr(1);
                        response = response.split('[[SPLIT]]');
                        jQuery("#receiver_org").fadeOut(200, function () {
                            jQuery('#loading-mask').toggle();
                            jQuery("#receiver_org").html(response[1]);
                            jQuery("#receiver_org").slideDown(200);
                            jQuery('#loading-mask').hide();
                        });
                    });
                    return false;
                });

                jQuery(".view-detail").live('click', function () {
                    jQuery('#loading-mask').toggle();
                    var get_id = jQuery(this).attr('href');
                    get_id = get_id.split('id=');
                    jQuery.post("<?= site_url() . 'peta_jabatan/peta_jabatan/view_detail'; ?>", {
                        'action': 'view-detail',
                        'uid': get_id[1]
                    }, function (response) {
                        response = response.substr(1);
                        response = response.split('[[SPLIT]]');
                        jQuery("#receiver_org").fadeOut(200, function () {
                            jQuery('#loading-mask').toggle();
                            jQuery("#receiver_org").html(response[1]);
                            jQuery("#receiver_org").slideDown(200);
                            jQuery('#loading-mask').hide();
                        });
                    });
                    return false;
                });

                jQuery(".view-back").live('click', function () {
                    jQuery('#loading-mask').toggle();
                    var get_id = jQuery(this).attr('href');
                    get_id = get_id.split('id=');
                    jQuery.post("<?= site_url() . 'peta_jabatan/peta_jabatan/view_back'; ?>", {
                        'action': 'view-back',
                        'uid': get_id[1]
                    }, function (response) {
                        response = response.substr(0, response.length - 1);
                        response = response.split('[[SPLIT]]');
                        jQuery("#receiver_org").fadeOut(200, function () {
                            jQuery('#loading-mask').toggle();
                            jQuery("#receiver_org").html(response[1]);
                            jQuery("#receiver_org").slideDown(200);
                            jQuery('#loading-mask').hide();
                        });
                    });
                    return false;
                });

            });
        </script>
    </head >
    <body> 
        <?php $this->load->view('header'); ?>
        <?php $this->load->view('menu'); ?>
        <div class="container">
            <div class="innercontainer">
                <?php $this->load->view('login_info'); ?>
                <div id="contents ">
                    <div id="contents-wrapper">
                        <div id="container" class="clearfix">
                            <div id="center" class="column">
                                <div id="center-wrapper">
                                    <div class="mod_head"> 
                                        <span class="mod_title"><?= $judul ?></span>
                                    </div>
                                    <div class="warna">
                                        <ul>
                                            <li class="menteri"><span></span><label>Kepala Basarnas</label></li>
                                            <li class="color-1"><span></span><label>Jabatan Pimpinan Tinggi Madya</label></li>
                                            <li class="color-2"><span></span><label>Jabatan Pimpinan Tinggi Pratama</label></li>
                                            <li class="color-3"><span></span><label>Jabatan Administrator</label></li>
                                            <li class="color-4"><span></span><label>Pelaksana</label></li>
                                            <li class="color-5"><span></span><label>Pelaksana (Eselon V)</label></li>
                                            <li class="color-6"><span></span><label>Staff</label></li>
                                        </ul>
                                    </div>
                                    <br /><br />
                                    <div class="filter_peta_jabatan">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td>
                                                    <select name="lok" id="lok">
                                                        <?php foreach ($list_loker as $r) { ?>
                                                            <?php
                                                            $selected = '';
                                                            if ($lokgroup == $r['kode']) {
                                                                $selected = 'selected="selected"';
                                                            }
                                                            ?>
                                                            <option <?php echo $selected; ?> value="<?= $r['kode'] ?>"><?= $r['nama'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div id="receiver_kdu1">
                                                        <select name="kdu1" id="kdu1" style="max-width: none;width: 225px;">
                                                            <?php if (empty($kdu1group)): ?>
                                                                <option value="">-Pilih Jabatan Pimpinan Tinggi Madya-</option>
                                                            <?php endif; ?>
                                                            <?php foreach ($list_struktur_es1 as $r) { ?>
                                                                <?php
                                                                $selected = '';
                                                                if ($kdu1group == $r['kdu1']) {
                                                                    $selected = 'selected="selected"';
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?= $r['kdu1'] ?>"><?= $r['nmunit'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div id="receiver_kdu2">
                                                        <select name="kdu2" id="kdu2" style="max-width: none;width: 225px;" >
                                                            <?php if (empty($kdu2group)): ?>
                                                                <option value="">-Pilih Jabatan Pimpinan Tinggi Pratama-</option>
                                                            <?php endif; ?>
                                                            <?php foreach ($list_struktur_es2 as $r) { ?>
                                                                <?php
                                                                $selected = '';
                                                                if ($kdu2group == $r['kdu2']) {
                                                                    $selected = 'selected="selected"';
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?= $r['kdu2'] ?>"><?= $r['nmunit'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div id="receiver_kdu3">
                                                        <select name="kdu3" id="kdu3" style="max-width: none;width: 225px;" >
                                                            <option value="">-Pilih Jabatan Administrator-</option>
                                                            <?php foreach ($list_struktur_es3 as $r) { ?>
                                                                <?php
                                                                $selected = '';
                                                                if ($kdu3group == $r['kdu3']) {
                                                                    $selected = 'selected="selected"';
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?= $r['kdu3'] ?>"><?= $r['nmunit'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div id="receiver_kdu4">
                                                        <select name="kdu4" id="kdu4" style="max-width: none;width: 225px;" >
                                                            <option value="">-Pilih Pelaksana-</option>
                                                            <?php foreach ($list_struktur_es4 as $r) { ?>
                                                                <?php
                                                                $selected = '';
                                                                if ($kdu4group == $r['kdu4']) {
                                                                    $selected = 'selected="selected"';
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?= $r['kdu4'] ?>"><?= $r['nmunit'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div id="receiver_kdu5">
                                                        <select name="kdu5" id="kdu5" style="max-width: none;width: 225px;" >
                                                            <option value="">-Pilih Pelaksana (Eselon V)-</option>
                                                            <?php foreach ($list_struktur_es5 as $r) { ?>
                                                                <?php
                                                                $selected = '';
                                                                if ($kdu5group == $r['kdu5']) {
                                                                    $selected = 'selected="selected"';
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?= $r['kdu5'] ?>"><?= $r['nmunit'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div id="receiver_org">
                                        <?php
                                        foreach ($data_master as $r) {
                                            if ($r['pelengkap'] == 'Y') {
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
                                                $class_width = (count($data_master) * 184);
                                            } else {
                                                $class_width = 184;
                                            }
                                            ?>
                                            <div class="level1 <?= $class_pelengkap ?> " style="width:<?= $class_width ?>px;">
                                                    <!--<div class="back"><a class="view-back" href="../master/edit.php?id=<?php // echo $data_first['id']    ?>" title="Kembali">Kembali</a></div>-->
                                                <div class="bsolid"></div>
                                                <div class="box_item">

                                                    <div class="item_level1 color-<?= $data_first['tktesel'] ?>">
                                                        <h2>
                                                            <? //=$data_first['jabatan']  ?>
                                                            <?= $data_first['nmunit'] ?>
                                                        </h2>
                                                        <a href="<?= base_url() ?><?= $data_first['url_link'] ?>?keepThis=true&type=image&TB_iframe=1&width=1024&height=566&modal=true"  class="thickbox "> <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $data_first['foto'] ?>" /> <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $data_first['foto'] ?>" />
                                                            <div class="desc">
                                                                <h3>
                                                                    <?= empty($data_first['gelar_depan']) ? '' : $data_first['gelar_depan'] . ' ' ?><?= $data_first['nama'] ?><?= empty($data_first['gelar_blkg']) ? '' : ', ' . $data_first['gelar_blkg'] ?>
                                                                </h3>
                                                                <h3>NIP.&nbsp;
                                                                    <?= $data_first['nip'] ?>
                                                                </h3>
                                                                <h3>Eselon. / TMT.
                                                                    <?= $data_first['tmtjab'] ?>
                                                                </h3>
                                                                <h3>Lhr.
                                                                    <?= $data_first['tgllahir'] ?>
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
                                                    if ($i == 1 AND $r['pelengkap'] <> 'Y' AND count($data_master) <> 1) {
                                                        $class = "level2 level2_first " . $not_child;
                                                    } else if ($r['pelengkap'] == 'Y' AND count($data_master) <> 1) {
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
                                                        <div class="box_item">
                                                            <?php if ($r['tktesel'] == '6') { ?>
                                                                <div class="item_level2 color-6"> 
                                                                    <?php if ($r['jabatan'] != "") { ?>
                                                                        <a href="<?= base_url() ?><?= $r['url_link'] ?>?keepThis=true&type=image&TB_iframe=1&width=1024&height=566&modal=true"  class="thickbox ">
                                                                            <h2><b><?= $r['jabatan'] ?><b><br>Jumlah : <?= $r['jumlah'] ?></h2>
                                                                                            </a>
                                                                                        <?php } else { ?>
                                                                                            <h2><b><?= $r['jabatan'] ?><b><br>Jumlah : <?= $r['jumlah'] ?></h2>
                                                                                                        <?php } ?> 
                                                                                                        </div>
                                                                                                    <?php } else { ?>
                                                                                                        <div class="item_level2 color-<?= $r['tktesel'] ?>"> 
                                                                                                            <a class="view-detail" href="../master/edit.php?id=<?= $r['id'] ?>" title="Lihat Detail">
                                                                                                                <h2><? //=$r['jabatan']   ?><?= $r['nmunit'] ?></h2>
                                                                                                            </a> <a href="<?= base_url() ?><?= $r['url_link'] ?>?keepThis=true&type=image&TB_iframe=1&width=1024&height=566&modal=true"  class="thickbox "> <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $r['foto'] ?>" />
                                                                                                                <div class="desc">
                                                                                                                    <h3><?= empty($r['gelar_depan']) ? '' : $r['gelar_depan'] . ' ' ?><?= $r['nama'] ?><?= empty($r['gelar_blkg']) ? '' : ', ' . $r['gelar_blkg'] ?></h3>
                                                                                                                    <h3>NIP.&nbsp;<?= $r['nip'] ?></h3>
                                                                                                                    <h3>Eselon. / TMT.<?= $r['tmtjab'] ?></h3>
                                                                                                                    <h3>Lhr.<?= $r['tgllahir'] ?></h3>
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
                                                                                                    <?php } ?>
                                                                                                </div><div class="bsolid"><div></div></div>
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
                                                                                                    <?php if (trim($r2['nmunit']) != '-') { ?>
                                                                                                        <div class="box_item">
                                                                                                            <?php if ($r2['tktesel'] == '6') { ?>
                                                                                                                <div class="item_level3 color-6">
                                                                                                                    <?php if ($r2['jabatan'] != "") { ?> 
                                                                                                                        <a href="<?= base_url() ?><?= $r2['url_link'] ?>?keepThis=true&type=image&TB_iframe=1&width=1024&height=566&modal=true"  class="thickbox ">
                                                                                                                            <h2><b><?= $r2['jabatan'] ?><b><br>Jumlah : <?= $r2['jumlah'] ?></h2>
                                                                                                                                            </a> 
                                                                                                                                        <?php } else { ?>
                                                                                                                                            <h2><b><?= $r2['jabatan'] ?><b><br>Jumlah : <?= $r2['jumlah'] ?></h2>
                                                                                                                                                        <?php } ?>
                                                                                                                                                        </div>
                                                                                                                                                    <?php } else { ?>

                                                                                                                                                        <div class="item_level3 color-<?= $r2['tktesel'] ?>"> 
                                                                                                                                                            <a class="view-detail" href="../master/edit.php?id=<?= $r2['id'] ?>" title="Lihat Detail">
                                                                                                                                                                <h2><? //=$r2['jabatan']  ?><?= $r2['nmunit'] ?></h2>
                                                                                                                                                            </a> 
                                                                                                                                                            <a href="<?= base_url() ?><?= $r2['url_link'] ?>?keepThis=true&type=image&TB_iframe=1&width=1024&height=566&modal=true"  class="thickbox "> <img class="photo" src="<?= base_url() ?>_uploads/photo_pegawai/thumbs/<?= $r2['foto'] ?>" />
                                                                                                                                                                <div class="desc">
                                                                                                                                                                    <h3>
                                                                                                                                                                        <?= empty($r2['gelar_depan']) ? '' : $r2['gelar_depan'] . ' ' ?><?= $r2['nama'] ?><?= empty($r2['gelar_blkg']) ? '' : ', ' . $r2['gelar_blkg'] ?>
                                                                                                                                                                    </h3>
                                                                                                                                                                    <h3>NIP.&nbsp;
                                                                                                                                                                        <?= $r2['nip'] ?>
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
                                                                                                                                                <?php } ?>
                                                                                                                                                </div>
                                                                                                                                                <?php
                                                                                                                                                $j++;
                                                                                                                                            }
                                                                                                                                            ?>
                                                                                                                                            </div>
                                                                                                                                            <?php
                                                                                                                                            if ($r['pelengkap'] <> 'Y') {
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
<?php $this->load->view('footer'); ?>
                                                                                                                                        </body>
                                                                                                                                        </html>
