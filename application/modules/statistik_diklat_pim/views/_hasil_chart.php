<style>
    .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
        line-height: 0.5;
    }
</style>
<?php
$nmstruktur = '<h2 class="text-center">' . $this->config->item('instansi_panjang') . "</h2>";
if ($struktur):
    $nmstruktur = '';
    $pecah = explode(", ", $struktur['NMSTRUKTUR']);
    $nm4 = '';
    if (isset($pecah[0]) && !empty($pecah[0])) {
        $nmstruktur .= '<h2 class="text-center">' . $pecah[0] . "</h2>";
    }
    $nm3 = '';
    if (isset($pecah[1]) && !empty($pecah[1])) {
        $nmstruktur .= '<h2 class="text-center">' . $pecah[1] . "</h2>";
    }
    $nm2 = '';
    if (isset($pecah[2]) && !empty($pecah[2])) {
        $nmstruktur .= '<h2 class="text-center">' . $pecah[2] . "</h2>";
    }
    $nm1 = '';
    if (isset($pecah[3]) && !empty($pecah[3])) {
        $nmstruktur .= '<h2 class="text-center">' . $pecah[3] . "</h2>";
    }
    $nm0 = '';
    if (isset($pecah[4]) && !empty($pecah[4])) {
        $nmstruktur .= '<h2 class="text-center">' . $pecah[4] . "</h2>";
    }
    $nmstruktur .= '<h2 class="text-center">' . $this->config->item('instansi_panjang') . "</h2>";
endif;
?>
<div class="col-md-12">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">&nbsp;</div>
            <div class="actions">
                <div class="btn-group btn-group-devided" data-toggle="buttons">
                    <!-- a class="btn btn-transparent red btn-outline btn-circle btn-sm">
                        <i class="fa fa-print"></i> Print
                    </a -->
                    <!-- a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php // echo site_url("daftar_nominatif/export_excel")    ?>">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </a -->
                    <!-- a class="btn btn-transparent red btn-outline btn-circle btn-sm">
                        <i class="fa fa-file-pdf-o"></i> Pdf
                    </a -->
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <h1 class="text-center">Komposisi Pegawai Berdasarkan Diklat PIM</h1>
            <?php echo $nmstruktur; ?>
            <h3 class="text-center">Periode <?php echo date("Y") ?></h3>
            <br />
            <div id="chart" class="barchart" style="height: 400px;"> </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>
<script>
    var ChartsAmcharts = function () {
        var d = function () {
            var e = AmCharts.makeChart("chart", {type: "pie", theme: "light", fontFamily: "Open Sans", color: "#888",
                dataProvider: <?= isset($model) ? $model : '[]' ?>,
                valueField: "value", titleField: "diklat", outlineAlpha: .1, bullet: "round", bulletSize: 20, bulletAlpha: 0, depth3D: 20, radius: 200, autoMargins: false,
                balloonText: "[[title]]<br><span style='font-size:10px'><b>[[value]]</b> ([[percents]]%)</span>", angle: 50,
                exportConfig: {menuItems: [{icon: "/lib/3/images/export.png", format: "png"}]}});
            $("#chart").closest(".portlet").find(".fullscreen").click(function () {
                e.invalidateSize()
            })
        };
        return{init: function () {
                d()
            }}
    }();
    $(document).ready(function () {
        ChartsAmcharts.init()
    });
</script>