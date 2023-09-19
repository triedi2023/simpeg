<div class="page-wrapper-row">
    <div class="page-wrapper-top">
        <!-- BEGIN HEADER -->
        <div class="page-header">
            <!-- BEGIN HEADER TOP -->
            <div class="page-header-top">
                <div class="container-fluid">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="<?php echo base_url(); ?>">
                            <img src="<?php echo base_url() ?>assets/img/logo_small.png" alt="logo" class="logo-default">
                        </a>
                    </div>
                    <div class="logo-text">
                        <h1>Sistem Informasi Manajemen Personil</h1>
                        <h3>Badan Nasional Pencarian dan Pertolongan</h3>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler"></a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <div class="logotextkanan">
                            Selamat Datang, <?php echo (!empty($this->session->userdata('nama')) ? $this->session->userdata('nama') : '') ?><br />
                            Anda login sebagai : <?php echo (!empty($this->session->userdata('group')) ? $this->session->userdata('group') : '') ?><br />
                            <a href="javascript:;">User Online</a> | <a href="<?php echo base_url()."akses/logout" ?>">Logout</a><br />
                        </div>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
            </div>
            <!-- END HEADER TOP -->
            <!-- BEGIN HEADER MENU -->
            <div class="page-header-menu">
                <div class="container-fluid">
                    <!-- BEGIN MEGA MENU -->
                    <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                    <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                    <div class="hor-menu">
                        <?php if (isset($_SESSION['menu'])): ?>
                            <?php echo $_SESSION['menu']; ?>
                        <?php endif; ?>
                    </div>
                    <!-- END MEGA MENU -->
                </div>
            </div>
            <!-- END HEADER MENU -->
        </div>
        <!-- END HEADER -->
    </div>
</div>