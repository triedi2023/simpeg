<link href="<?php echo base_url() ?>assets/css/profile.min.css" rel="stylesheet" type="text/css" />
<div class="light profile-sidebar-portlet mt-element-ribbon light portlet-fit">
    <div class="ribbon ribbon-border-hor ribbon-clip ribbon-color-danger ribbon-border-dash-hor uppercase">
        <div class="ribbon-sub ribbon-clip"></div> PROFILE YANG BER-ULANG TAHUN HARI INI
    </div>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <!-- PORTLET MAIN -->
            <div class="portlet">

                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img style="width: 40%; height: 40%" src="<?php echo base_url();?>_uploads/photo_pegawai/thumbs/<?php echo $get_profile['FOTO']; ?>" class="img-responsive" alt="" />
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <?php
                    $nama = ((!empty($get_profile['GELAR_DEPAN'])) ? $get_profile['GELAR_DEPAN'] . " " : "") . ($get_profile['NAMA']) . ((!empty($get_profile['GELAR_BLKG'])) ? " " . $get_profile['GELAR_BLKG'] : '');
                    ?>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> <?php echo $nama ?> </div>
                    <div class="profile-usertitle-job"> <?php echo $get_profile['NIPNEW'] ?> </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li class="active">
                            <a href="javascript:;">Tempat Lahir <i class="fa fa-angle-right"></i> <?php echo $get_profile['TPTLAHIR'] ?></a>
                        </li>
                        <li class="active">
                            <a href="javascript:;">Tanggal Lahir <i class="fa fa-angle-right"></i> <?php echo $get_profile['TGLLAHIR'] ?></a>
                        </li>
                        <li class="active">
                            <a href="javascript:;">Alamat <i class="fa fa-angle-right"></i> <?php echo $get_profile['ALAMAT'] ?></a>
                        </li>
                        <li class="active">
                            <a href="javascript:;">No Hp <i class="fa fa-angle-right"></i> <?php echo $get_profile['TELP_HP'] ?></a>
                        </li>
                        <li class="active">
                            <a href="javascript:;">Pangkat / Golongan <i class="fa fa-angle-right"></i> <?php echo ($get_profile['TRSTATUSKEPEGAWAIAN_ID']=='1') ? $get_profile['PANGKAT']." (".$get_profile['GOLONGAN'].")" : $get_profile['PANGKAT'] ?></a>
                        </li>
                        <li class="active">
                            <a href="javascript:;">Jabatan <i class="fa fa-angle-right"></i> <?php echo $get_profile['N_JABATAN'] ?></a>
                        </li>
                    </ul>
                </div>
                <!-- END MENU -->
            </div>
            <!-- END PORTLET MAIN -->
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
</div>