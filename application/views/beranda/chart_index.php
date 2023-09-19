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
                        <div class="col-md-2 pull-right" style="text-align: right"><a class="cetakjabatan" data-url="<?php echo base_url() . "beranda/content_excel?tipe=4" ?>" href="javascript:;">Cetak Excel</a></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="chart_7" class="barchart" style="height: 500px;overflow: visible;"> </div>
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
                        <div class="col-md-2 pull-right" style="text-align: right"><a class="cetakjabatan" data-url="<?php echo base_url() . "beranda/content_excel?tipe=3" ?>" href="javascript:;">Cetak Excel</a></div>
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
                        <div class="col-md-2 pull-right" style="text-align: right"><a class="cetakjabatan" data-url="<?php echo base_url() . "beranda/content_excel?tipe=2" ?>" href="javascript:;">Cetak Excel</a></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="chart_5" class="chart" style="height: 300px;"> </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>