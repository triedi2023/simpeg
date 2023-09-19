<style>
    .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
        line-height: 0.5;
    }
</style>
<?php
$base_url = base_url();
$nmstruktur = '<h2 class="text-center">' . $this->config->item('instansi_panjang') . "</h2>"
?>
<div class="col-md-12">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">
                <div class="btn-group btn-group-devided" data-toggle="buttons">
                    <a class="btn btn-transparent dark btn-outline btn-circle btn-sm btnkembali">
                        <i class="fa fa-backward"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="actions">
                <div class="btn-group btn-group-devided" data-toggle="buttons">
                    <a class="btn btn-transparent red btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url('laporan_serbaguna/export_excel'); ?>">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <h1 class="text-center"><?php echo (isset($params['judul']) && !empty($params['judul'])) ? $params['judul'] : 'Laporan Serbaguna' ?></h1>
            <h3 class="text-center">Periode <?php echo month_indo(date('m')) . " " . date("Y") ?></h3>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered table-hover table-striped table-advance">
                    <thead>
                        <tr>
                            <?php
                            if (count($data_grid) > 0) {
                                $r = array();
                                foreach ($data_grid as $row) {
                                    $r = $row;
                                    break;
                                }
                                ?>
                                <td>NO</td>
                                <?php foreach ($r as $key => $val) { ?>
                                    <th><?= $colSelect[strtolower($key)]; ?></th>
                                    <?php
                                }
                            } else {
                                ?>
                                <td>Data Tidak Ada</td> 
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($data_grid as $r) {
                            $colIdx = 1;
                            ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <?php foreach ($r as $g => $c) { ?>
                                    <td><?= $c ?></td>
                                <?php } ?>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>