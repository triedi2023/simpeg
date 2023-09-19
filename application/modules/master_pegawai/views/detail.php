<?php
$namapegawai = (!empty($data_pegawai['GELAR_DEPAN'])) ? $data_pegawai['GELAR_DEPAN'] . " " : "";
$namapegawai .= $data_pegawai['NAMA'];
$namapegawai .= (!empty($data_pegawai['GELAR_BLKG'])) ? ", " . $data_pegawai['GELAR_BLKG'] : "";
?>
<style>
    .profile-pic {
        position: relative;
        display: inline-block;
    }

    .profile-pic:hover .editpic {
        display: block;
    }

    .editpic {
        padding-top: 7px;	
        padding-right: 7px;
        position: absolute;
        right: 0;
        top: 0;
        display: none;
    }

    .editpic a {
        color: #000;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet ">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic profile-pic">
                    <img src="<?php echo base_url() ?>_uploads/photo_pegawai/thumbs/<?php echo $foto."?v=".uniqid(); ?>" class="img-responsive potopp" alt="" />
                    <?php if (in_array($this->session->userdata('idgroup'),[1,2])) { ?>
                        <div class="editpic"><a href="javascript:;" data-url="<?php echo base_url()."master_pegawai/ubahfoto?id=".$data_pegawai['ID'] ?>" class="popuplarge" title="Ubah Foto"><i class="fa fa-pencil fa-lg"></i></a></div>
                    <?php } ?>
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> <?= $namapegawai; ?> </div>
                    <div class="profile-usertitle-job"> <?php echo $data_pegawai['NIPNEW'] ?> </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu" style="margin-top: 1px;padding-bottom: 1px">&nbsp;</div>
                <!-- END MENU -->
            </div>
            <!-- END PORTLET MAIN -->
            <!-- PORTLET MAIN -->
            <div class="portlet light ">
                <div>
                    <h4 class="profile-desc-title">Pangkat</h4>
                    <span class="profile-desc-text text-right profile-pangkat" style="float: right"> <?php echo isset($pangkat_pegawai) ? $pangkat_pegawai : '-' ?> </span>
                    <br />
                    <h4 class="profile-desc-title">Golongan Ruang</h4>
                    <span class="profile-desc-text text-right profile-gol" style="float: right"> <?php echo isset($gol_pegawai) ? $gol_pegawai : '-' ?> </span>
                    <br />
                    <h4 class="profile-desc-title">Jabatan</h4>
                    <span class="profile-desc-text text-right profile-jabatan" style="float: right"> <?php echo isset($jabatan_pegawai) ? $jabatan_pegawai : '-' ?> </span>
                    <br />
                    <h4 class="profile-desc-title">Pendidikan</h4>
                    <span class="profile-desc-text text-right profile-pendidikan" style="float: right;"> <?php echo isset($pendidikan_pegawai) ? $pendidikan_pegawai : '-' ?> </span>

                    <div class="margin-top-20 profile-desc-link">&nbsp;</div>
                </div>
            </div>
            <!-- END PORTLET MAIN -->
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Biodata</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active dropdown">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 12px;font-weight: 500"> Data Pokok
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="#tab_1_1" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/biodata?id=' . $data_pegawai['ID']) ?>"> Biodata </a>
                                        </li>
                                        <?php if (isset($data_pegawai['TRSTATUSPERNIKAHAN_ID']) && !empty($data_pegawai['TRSTATUSPERNIKAHAN_ID']) && $data_pegawai['TRSTATUSPERNIKAHAN_ID'] != 'B') { ?> 
                                        <li>
                                            <a href="#tab_1_2" tab-menu-detail="pegawai" tabindex="-2" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_pasangan?id=' . $data_pegawai['ID']) ?>"> Data Pasangan </a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_3" tab-menu-detail="pegawai" tabindex="-3" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_anak?id=' . $data_pegawai['ID']) ?>"> Data Anak </a>
                                        </li>
                                        <?php } ?>
                                        <li>
                                            <a href="#tab_1_4" tab-menu-detail="pegawai" tabindex="-4" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_ortu?id=' . $data_pegawai['ID']) ?>"> Data Orang Tua </a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_5" tab-menu-detail="pegawai" tabindex="-5" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_saudara?id=' . $data_pegawai['ID']) ?>"> Data Saudara </a>
                                        </li>
                                    </ul>
                                </li>
                                <?php if ($data_pegawai): ?>
                                    <?php if ($data_pegawai['TRSTATUSKEPEGAWAIAN_ID'] == '1'): ?>
                                        <li class="dropdown">
                                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 12px"> CPNS / PNS
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="#tab_2_1" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_cpns?id=' . $data_pegawai['ID']) ?>"> CPNS </a>
                                                </li>
                                                <li>
                                                    <a href="#tab_2_2" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_pns?id=' . $data_pegawai['ID']) ?>"> PNS </a>
                                                </li>
                                            </ul>
                                        </li>
                                    <?php elseif (in_array($data_pegawai['TRSTATUSKEPEGAWAIAN_ID'], ['2'])): ?>
                                        <li>
                                            <a href="#tab_2_1" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_cpns?id=' . $data_pegawai['ID']) ?>"> Polri </a>
                                        </li>
                                    <?php elseif (in_array($data_pegawai['TRSTATUSKEPEGAWAIAN_ID'], ['4', '5', '6'])): ?>
                                        <li class="dropdown">
                                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 12px"> TNI
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="#tab_2_1" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_cpns?id=' . $data_pegawai['ID']) ?>">
                                                        <?php
                                                        if ($data_pegawai['TRSTATUSKEPEGAWAIAN_ID'] == '4'):
                                                            echo 'AD';
                                                        elseif ($data_pegawai['TRSTATUSKEPEGAWAIAN_ID'] == '5'):
                                                            echo 'AU';
                                                        elseif ($data_pegawai['TRSTATUSKEPEGAWAIAN_ID'] == '6'):
                                                            echo 'AL';
                                                        endif;
                                                        ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <li class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 12px"> Riwayat
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="#tab_3_1" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_pangkat?id=' . $data_pegawai['ID']) ?>"> Pangkat </a>
                                        </li>
                                        <li>
                                            <a href="#tab_3_2" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_jabatan?id=' . $data_pegawai['ID']) ?>"> Jabatan </a>
                                        </li>
                                        <li>
                                            <a href="#tab_3_3" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_pendidikan?id=' . $data_pegawai['ID']) ?>"> Pendidikan </a>
                                        </li>
                                        <li>
                                            <a href="#tab_3_13" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_gaji?id=' . $data_pegawai['ID']) ?>"> Gaji </a>
                                        </li>
                                        <li>
                                            <a href="#tab_3_4" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_belajar?id=' . $data_pegawai['ID']) ?>"> Tugas / Ijin Belajar </a>
                                        </li>
                                        <li>
                                            <a href="#tab_3_5" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_seminar?id=' . $data_pegawai['ID']) ?>"> Seminar </a>
                                        </li>
                                        <li>
                                            <a href="#tab_3_6" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_organisasi?id=' . $data_pegawai['ID']) ?>"> Organisasi </a>
                                        </li>
                                        <li>
                                            <a href="#tab_3_7" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_kunjungan_ln?id=' . $data_pegawai['ID']) ?>"> Luar Negeri </a>
                                        </li>
                                        <li>
                                            <a href="#tab_3_8" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_penghargaan?id=' . $data_pegawai['ID']) ?>"> Penghargaan </a>
                                        </li>
                                        <li>
                                            <a href="#tab_3_9" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_sanksi?id=' . $data_pegawai['ID']) ?>"> Sanksi </a>
                                        </li>
                                        <li>
                                            <a href="#tab_3_10" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_cuti?id=' . $data_pegawai['ID']) ?>"> Cuti </a>
                                        </li>
                                        <li>
                                            <a href="#tab_3_11" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_fungsional?id=' . $data_pegawai['ID']) ?>"> Fungsional </a>
                                        </li>
                                        <li>
                                            <a href="#tab_3_12" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_ket_lain?id=' . $data_pegawai['ID']) ?>"> Keterangan Lain </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 12px"> Diklat PNS
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="#tab_4_1" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_diklat_prajabatan?id=' . $data_pegawai['ID']) ?>"> Pra Jabatan </a>
                                        </li>
                                        <li>
                                            <a href="#tab_4_2" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_diklat_penjenjangan?id=' . $data_pegawai['ID']) ?>"> Kepemimpinan </a>
                                        </li>
                                        <li>
                                            <a href="#tab_4_3" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_diklat_teknis?id=' . $data_pegawai['ID']) ?>"> Teknis </a>
                                        </li>
                                        <li>
                                            <a href="#tab_4_4" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_diklat_fungsional?id=' . $data_pegawai['ID']) ?>"> Fungsional </a>
                                        </li>
                                        <li>
                                            <a href="#tab_4_5" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_diklat_lain?id=' . $data_pegawai['ID']) ?>"> Lain / Umum </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 12px"> Kinerja
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="#tab_5_1" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_ak?id=' . $data_pegawai['ID']) ?>"> Angka Kredit </a>
                                        </li>
                                        <li>
                                            <a href="#tab_5_2" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_skp?id=' . $data_pegawai['ID']) ?>"> SKP </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- li class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 12px"> Penilaian
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="#tab_6_1" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_penilaian_pat?id=' . $data_pegawai['ID']) ?>"> PAT </a>
                                        </li>
                                        <li>
                                            <a href="#tab_6_2" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_penilaian_bahasa?id=' . $data_pegawai['ID']) ?>"> Bahasa </a>
                                        </li>
                                        <li>
                                            <a href="#tab_6_3" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_penilaian_tpa?id=' . $data_pegawai['ID']) ?>"> TPA </a>
                                        </li>
                                        <li>
                                            <a href="#tab_6_4" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_penilaian_kepangkatan?id=' . $data_pegawai['ID']) ?>"> Kepangkatan </a>
                                        </li>
                                    </ul>
                                </li -->
                                <li>
                                    <a href="#tab_7_1" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" aria-expanded="true" data-url="<?php echo site_url('master_pegawai/master_pegawai_drh?id=' . $data_pegawai['ID']) ?>"> DRH </a>
                                </li>
                                <?php if (in_array($data_pegawai['TRSTATUSKEPEGAWAIAN_ID'], ['1'])): ?>
                                    <li>
                                        <a href="#tab_8_1" tab-menu-detail="pegawai" tabindex="-1" data-toggle="tab" data-url="<?php echo site_url('master_pegawai/master_pegawai_sisa_cuti?id=' . $data_pegawai['ID']) ?>"> Sisa Cuti </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane active" id="tab_content">
                                    <?php echo $this->load->view($biodata) ?>
                                </div>
                                <!-- END PERSONAL INFO TAB -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>