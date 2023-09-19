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
        <style>
            .pdfobject-container { 
                height: 40rem; border: 1rem solid rgba(0,0,0,.1); 
            }
        </style>
        <script type="text/javascript" charset="ISO-8859-1" src="<?php echo base_url(); ?>assets/js/pdfobject.min.js?v=<?php echo uniqid(); ?>"></script>
        <?php if ($file) { ?>
            <script>PDFObject.embed("<?php echo $file."?v=". uniqid() ?>", ".modaldokumen");</script>
        <?php } ?>
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
    </head>
    <!-- END HEAD -->

    <body>
        <?php $this->load->view($content); ?>
    </body>

</html>