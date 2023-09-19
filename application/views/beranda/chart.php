<style>
    .barchart {
        width: 950px;
        margin: 0px 0px 0px 0px;
        overflow: visible;
    }
</style>
<?php if ($setup_dashboard && in_array(1, $setup_dashboard)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading" style="color: #000;">
                    <div class="row">
                        <div class="col-md-10"><h3 class="panel-title">Pegawai Berdasarkan Jabatan Fungsional Umum</h3></div>
                        <div class="col-md-2 pull-right" style="text-align: right"><a class="cetakjabatan" data-url="<?php echo base_url()."beranda/content_excel?tipe=4" ?>" href="javascript:;">Cetak Excel</a></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="chart_7" class="barchart" style="height: 400px;"> </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($setup_dashboard && in_array(2, $setup_dashboard)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading" style="color: #000;">
                    <div class="row">
                        <div class="col-md-10"><h3 class="panel-title">Pegawai Berdasarkan Jabatan Fungsional Tertentu</h3></div>
                        <div class="col-md-2 pull-right" style="text-align: right"><a class="cetakjabatan" data-url="<?php echo base_url()."beranda/content_excel?tipe=3" ?>" href="javascript:;">Cetak Excel</a></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="chart_3" class="chart" style="height: 400px;"> </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($setup_dashboard && in_array(3, $setup_dashboard)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading" style="color: #000;">
                    <div class="row">
                        <div class="col-md-10"><h3 class="panel-title">Pegawai Berdasarkan Eselon</h3></div>
                        <div class="col-md-2 pull-right" style="text-align: right"><a class="cetakjabatan" data-url="<?php echo base_url()."beranda/content_excel?tipe=2" ?>" href="javascript:;">Cetak Excel</a></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="chart_5" class="chart" style="height: 300px;"> </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<script>
    var ChartsAmcharts = function () {
        var d = function () {
            var e = AmCharts.makeChart("chart_7", {type: "pie", theme: "light", fontFamily: "Open Sans", color: "#888",
                dataProvider: <?= isset($jml_jabatan_umum) ? $jml_jabatan_umum : '[]' ?>,
                valueField: "value", titleField: "jabatan", outlineAlpha: .4, depth3D: 15,
                balloonText: "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>", angle: 30,
                exportConfig: {menuItems: [{icon: "/lib/3/images/export.png", format: "png"}]}});
            $("#chart_7").closest(".portlet").find(".fullscreen").click(function () {
                e.invalidateSize()
            })
        }, e = function () {
            var e = AmCharts.makeChart("chart_3", {type: "pie", theme: "light", fontFamily: "Open Sans", color: "#888",
                dataProvider: <?= isset($jml_jabatan_khusus) ? $jml_jabatan_khusus : '[]' ?>,
                valueField: "value", titleField: "jabatan", outlineAlpha: .4, depth3D: 20,
                balloonText: "[[title]]<br><span style='font-size:10px'><b>[[value]]</b> ([[percents]]%)</span>", angle: 50,
                exportConfig: {menuItems: [{icon: "/lib/3/images/export.png", format: "png"}]}});
            $("#chart_3").closest(".portlet").find(".fullscreen").click(function () {
                e.invalidateSize()
            })
        }, o = function () {
            var e = AmCharts.makeChart("chart_5", {theme: "light", type: "serial", columnWidth: 0.5, startDuration: 2, fontFamily: "Open Sans",
                color: "#888", dataProvider: <?php echo isset($jml_jabatan_eselon) ? $jml_jabatan_eselon : '[]' ?>, valueAxes: [{position: "left", axisAlpha: 0, gridAlpha: 0}], graphs: [{balloonText: "[[category]]: <b>[[value]]</b>", colorField: "color", fillAlphas: .85, lineAlpha: .1, type: "column", topRadius: 1, valueField: "value"}], depth3D: 150, angle: 20, chartCursor: {categoryBalloonEnabled: !1, cursorAlpha: 0, zoomable: !1}, categoryField: "jabatan", categoryAxis: {gridPosition: "start", axisAlpha: 0, gridAlpha: 0}, exportConfig: {menuTop: "20px", menuRight: "20px", menuItems: [{icon: "/lib/3/images/export.png", format: "png"}]}}, 0);
            $("#chart_5").closest(".portlet").find(".fullscreen").click(function () {
                e.invalidateSize()
            })
        };
        return{init: function () {
                d(), o(), e()
            }}
    }();
    $(document).ready(function () {
        ChartsAmcharts.init()
    });
</script>