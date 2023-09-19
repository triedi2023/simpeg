<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title><?php echo isset($title) ? $title : $this->config->item('default_title') . " | " . $this->config->item('instansi_panjang'); ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Kepegawaian" name="description" />
        <meta content="Kepegawaian" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="<?php echo base_url() ?>assets/css/fonts.css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/font-awesome/css/font-awesome.min.css?v=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/simple-line-icons/simple-line-icons.min.css?v=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css?v=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/bootstrap-switch/css/bootstrap-switch.min.css?v=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo base_url() ?>assets/plugins/bootstrap-toastr/toastr.min.css?v=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/datatables/datatables.min.css?v=<?php echo uniqid(); ?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css?v=<?php echo uniqid(); ?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/select2/css/select2.min.css?v=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/select2/css/select2-bootstrap.min.css?v=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css" />
        <?php if (isset($plugin_css)): ?>
            <?php foreach ($plugin_css as $css): ?>
                <link href="<?php echo base_url() . $css ?>" rel="stylesheet" type="text/css" />
            <?php endforeach; ?>
        <?php endif; ?>
        <link href="<?php echo base_url() ?>assets/css/components.min.css?v=<?php echo uniqid(); ?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/plugins.min.css?v=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo base_url() ?>assets/css/layout.min.css?v=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/yellow-orange.min.css?v=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?php echo base_url() ?>assets/css/custom.min.css?v=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
    </head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid">
        <div class="page-wrapper">
            <?php $this->load->view('layouts/widget/main/header') ?>
            <?php $this->load->view($content); ?>
            <?php $this->load->view('layouts/widget/main/footer') ?>
        </div>
        <!--[if lt IE 9]>
        <script src="<?php echo base_url() ?>assets/js/respond.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/excanvas.min.js"></script> 
        <script src="<?php echo base_url() ?>assets/js/ie8.fix.min.js"></script> 
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url() ?>assets/js/jquery.min.js?v=<?php echo uniqid(); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js?v=<?php echo uniqid(); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js?v=<?php echo uniqid(); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.blockui.min.js?v=<?php echo uniqid(); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js?v=<?php echo uniqid(); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-toastr/toastr.min.js?v=<?php echo uniqid(); ?>" type="text/javascript"></script>
        <?php if (isset($plugin_js)): ?>
            <?php foreach ($plugin_js as $script): ?>
                <script type="text/javascript" src="<?php echo base_url() . $script; ?>?v=<?php echo uniqid(); ?>"></script>
            <?php endforeach; ?>
        <?php endif; ?>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url() ?>assets/js/app.min.js?v=<?php echo uniqid(); ?>" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url() ?>assets/js/layout.min.js?v=<?php echo uniqid(); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/demo.min.js?v=<?php echo uniqid(); ?>" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <?php if (isset($custom_js)): ?>
            <?php foreach ($custom_js as $script): ?>
                <?php $this->load->view($script); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </body>

</html>