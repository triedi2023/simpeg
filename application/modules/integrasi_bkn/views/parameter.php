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
                                <h3>Modul</h3>
                                <div class="form">
                                    <ol>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_pokok&nip_pegawai=".$nip_pegawai ?>">Data Pokok</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_ortu&nip_pegawai=".$nip_pegawai ?>">Data Orang Tua</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_pasangan&nip_pegawai=".$nip_pegawai ?>">Data Pasangan</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_anak&nip_pegawai=".$nip_pegawai ?>">Data Anak</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_pangkat&nip_pegawai=".$nip_pegawai ?>">Pangkat</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_jabatan&nip_pegawai=".$nip_pegawai ?>">Jabatan</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_pendidikan&nip_pegawai=".$nip_pegawai ?>">Pendidikan</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_kursus&nip_pegawai=".$nip_pegawai ?>">Kursus</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_penghargaan&nip_pegawai=".$nip_pegawai ?>">Penghargaan</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_diklat&nip_pegawai=".$nip_pegawai ?>">Diklat</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_angkakredit&nip_pegawai=".$nip_pegawai ?>">Angka Kredit</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_skp&nip_pegawai=".$nip_pegawai ?>">SKP</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_hukdis&nip_pegawai=".$nip_pegawai ?>">Hukuman Disiplin</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_pemberhentian&nip_pegawai=".$nip_pegawai ?>">Pemberhentian</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_pindahinstansi&nip_pegawai=".$nip_pegawai ?>">Pindah Instansi</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_masakerja&nip_pegawai=".$nip_pegawai ?>">Masa Kerja</a></li>
                                        <!-- li><a href="<?php // echo base_url()."integrasi_bkn/hasil?kriteria=data_pnsunor&nip_pegawai=".$nip_pegawai ?>">PNS Unor</a></li -->
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_ctln&nip_pegawai=".$nip_pegawai ?>">CTLN</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_updated_sapk" ?>">Peremajaan Dari SAPK</a></li>
                                        <!-- li><a href="<?php // echo base_url()."integrasi_bkn/hasil?kriteria=data_updated_hist_sapk" ?>">Peremajaan Dari SAPK Hist</a></li -->
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_kposk" ?>">KPO SK</a></li>
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_ppo" ?>">PPO Data</a></li>
                                        <!-- li><a href="<?php // echo base_url()."integrasi_bkn/hasil?kriteria=data_ppo_hist" ?>">PPO Hist</a></li -->
                                        <li><a href="<?php echo base_url()."integrasi_bkn/hasil?kriteria=data_ppowafat" ?>">PPO Wafat</a></li>
                                    </ol>
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