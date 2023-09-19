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
                                <div class="col-md-9">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <select name="trlokasi_id" id="field_trlokasi_id" class="form-control btn-xs" style="width: 100%">
                                                        <?php if (!empty($this->session->userdata('trlokasi_id')) && $this->session->userdata('idgroup') == 1) { ?>
                                                            <option value="">- Pilih Lokasi Kerja -</option>
                                                        <?php } ?>
                                                        <?php echo $list_lokasi; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="kdu1" id="field_kdu1" class="form-control btn-xs" style="width: 100%">
                                                        <?php if (!empty($this->session->userdata('kdu1')) && $this->session->userdata('idgroup') == 1) { ?>
                                                            <option value="">- Pilih Jabatan Pimpinan Tinggi Madya -</option>
                                                        <?php } ?>
                                                        <?php if (isset($list_kdu1)): ?>
                                                            <?php foreach ($list_kdu1 as $val): ?>
                                                                <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                                                            <?php endforeach ?>
                                                        <?php endif ?>
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
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <select name="tipe" id="tipe" data-url="<?php echo site_url('beranda/content') ?>" class="form-control btn-xs" style="width: 100%">
                                                        <option value="1">- Grafik -</option>
                                                        <option value="2">&nbsp;Jabatan Struktural</option>
                                                        <option value="3">&nbsp;Jabatan Fungsional Tertentu</option>
                                                        <option value="4">&nbsp;Jabatan Fungsional Umum</option>
                                                        <option value="5">&nbsp;Diklat PIM</option>
                                                        <option value="6">&nbsp;Pendidikan</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <a href="javascript:;" data-url="<?php echo site_url('beranda/setup_content_beranda') ?>" data-id="0" class="btn btn-circle btn-sm dark popupstack">Setup</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row contentberanda">
                                <div class="col-md-9 berandacontent">
                                    <?php $this->load->view('beranda/chart_index'); ?>
                                </div>
                                <div class="col-md-3">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">NOTIFIKASI</h3>
                                        </div>
                                        <div class="panel-body"> 
                                            <div class="panel-group accordion" id="accordion3">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a style="font-size: 12px;" class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1"> Ulang tahun hari ini <span class="badge badge-danger" style="background-color: red;color: #fff; font-weight: bolder;"> <?php echo count($jml_ultah_hari_ini) ?> </span> </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_3_1" class="panel-collapse collapse">
                                                        <div class="panel-body" style="padding: 1px;">
                                                            <?php if ($jml_ultah_hari_ini): ?>
                                                                <div class="list-group" style="margin-bottom: 1px">
                                                                    <?php
                                                                    $c = 1;
                                                                    foreach ($jml_ultah_hari_ini as $val):
                                                                        ?>
                                                                        <?php
                                                                        $nama = ((!empty($val['GELAR_DEPAN'])) ? $val['GELAR_DEPAN'] . " " : "") . ($val['NAMA']) . ((!empty($val['GELAR_BLKG'])) ? " " . $val['GELAR_BLKG'] : '');
                                                                        ?>
                                                                        <a class="list-group-item popupstack <?php echo ($c % 2 == 0) ? 'list-group-item-info' : ''; ?>" data-id="<?php echo $val['ID']; ?>" data-url="<?php echo site_url('beranda/profileultah'); ?>" href="javascript:;"><?php echo $nama . "<br />" . $val['NIPNEW'] . "<br />" . $val['TGLLAHIR'] ?></a>
                                                                        <?php
                                                                        $c++;
                                                                    endforeach;
                                                                    ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a style="font-size: 12px;" class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2"> Jabatan Struktural yang kosong <span class="badge badge-danger" style="background-color: red;color: #fff; font-weight: bolder;"><?php echo count($data_jab_stuktural_kosong); ?></span> </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_3_2" class="panel-collapse collapse">
                                                        <div class="panel-body" style="padding: 1px;">
                                                            <?php if ($data_jab_stuktural_kosong): ?>
                                                                <div class="list-group" style="margin-bottom: 1px">
                                                                    <?php
                                                                    $c = 1;
                                                                    foreach ($data_jab_stuktural_kosong as $val):
                                                                        ?>
                                                                        <a class="list-group-item <?php echo ($c % 2 == 0) ? 'list-group-item-info' : ''; ?>" href="javascript:;"><?php echo ($val['KDU1'] == '00') ? $val['NM_STUKTUR'] . " " . $this->config->item('instansi_panjang') : $val['NM_STUKTUR']; ?></a>
                                                                        <?php
                                                                        $c++;
                                                                    endforeach;
                                                                    ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a style="font-size: 12px;" class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_3"> Pensiun <span class="badge badge-danger" style="background-color: red;color: #fff; font-weight: bolder;"><?php echo $total_pensiun; ?></span> </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_3_3" class="panel-collapse collapse">
                                                        <div class="panel-body" style="padding: 1px;">
                                                            <?php if ($data_pensiun): ?>
                                                                <div class="list-group" style="margin-bottom: 1px">
                                                                    <?php
                                                                    $c = 1;
                                                                    foreach ($data_pensiun as $val):
                                                                        ?>
                                                                        <a class="list-group-item popuplarge <?php echo ($c % 2 == 0) ? 'list-group-item-info' : ''; ?>" href="javascript:;" data-id="<?php echo $val['BULAN_PENSIUN']; ?>" data-indetify="notifpensiun" data-url="<?php echo site_url('daftar_pensiun/listpensiun'); ?>"><?php echo month_indo($val['BULAN_PENSIUN']) . "-" . date('Y'); ?> <span class="badge badge-danger"><?= $val['JML'] ?></span></a>
                                                                        <?php
                                                                        $c++;
                                                                    endforeach;
                                                                    ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a style="font-size: 12px;" class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_4"> Kenaikan Pangkat <span class="badge badge-danger" style="background-color: red;color: #fff; font-weight: bolder;"><?php echo count($kp1) + count($kp2); ?></span> </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_3_4" class="panel-collapse collapse">
                                                        <div class="panel-body" style="padding: 1px;">
                                                            <div class="list-group" style="margin-bottom: 1px">
                                                                <?php // if (count($kp1) > 0): ?>
                                                                    <a class="list-group-item popuplarge" data-indetify="notifkp" href="javascript:;" data-id="<?php echo $periode_angkat1['tahun'] . "-" . $periode_angkat1['bulan'] . "-01"; ?>" data-url="<?php echo site_url('daftar_kp/listkp'); ?>"><?php echo month_indo($periode_angkat1['bulan']) . "-" . $periode_angkat1['tahun']; ?> <span class="badge badge-danger"><?= count($kp1) ?></span></a>
                                                                <?php // endif; ?>

                                                                <?php // if (count($kp2) > 0): ?>
                                                                    <a class="list-group-item popuplarge list-group-item-info" data-indetify="notifkp" href="javascript:;" data-id="<?php echo $periode_angkat2['tahun'] . "-" . $periode_angkat2['bulan'] . "-01"; ?>" data-url="<?php echo site_url('daftar_kp/listkp'); ?>"><?php echo month_indo($periode_angkat2['bulan']) . "-" . $periode_angkat2['tahun']; ?> <span class="badge badge-danger"><?= count($kp2) ?></span></a>
                                                                <?php // endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div -->
                                            </div>
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