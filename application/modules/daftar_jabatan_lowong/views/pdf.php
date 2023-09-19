<style>
    .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
        line-height: 0.5;
    }
</style>
<?php
$nmstruktur = '<h3 class="text-center">' . $this->config->item('instansi_panjang') . "</h3>";
if ($struktur):
    $nmstruktur = '';
    $pecah = explode(", ", $struktur['NMSTRUKTUR']);
    $nm4 = '';
    if (isset($pecah[0]) && !empty($pecah[0])) {
        $nmstruktur .= '<h3 class="text-center">' . $pecah[0] . "</h3>";
    }
    $nm3 = '';
    if (isset($pecah[1]) && !empty($pecah[1])) {
        $nmstruktur .= '<h3 class="text-center">' . $pecah[1] . "</h3>";
    }
    $nm2 = '';
    if (isset($pecah[2]) && !empty($pecah[2])) {
        $nmstruktur .= '<h3 class="text-center">' . $pecah[2] . "</h3>";
    }
    $nm1 = '';
    if (isset($pecah[3]) && !empty($pecah[3])) {
        $nmstruktur .= '<h3 class="text-center">' . $pecah[3] . "</h3>";
    }
    $nm0 = '';
    if (isset($pecah[4]) && !empty($pecah[4])) {
        $nmstruktur .= '<h3 class="text-center">' . $pecah[4] . "</h3>";
    }
    $nmstruktur .= '<h3 class="text-center">' . $this->config->item('instansi_panjang') . "</h3>";
endif;
?>
<div class="col-md-12">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">&nbsp;</div>
            <div class="actions"></div>
        </div>
        <div class="portlet-body">
            <h2 class="text-center">Daftar Jabatan Lowong</h2>
            <?php echo $nmstruktur; ?>
            <h4 class="text-center">Periode <?php echo month_indo(date('m')) . " " . date("Y") ?></h4>
            <br />
            <div class="table-scrollable">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center"> No </th>
                            <th class="text-center"> Jabatan </th>
                            <th class="text-center"> Lamanya Jabatan Lowong </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($model): ?>
                            <?php
                            $t = 1;
                            foreach ($model as $val):
                                ?>
                                <tr>
                                    <td class="text-center"> <?php echo $t ?> </td>
                                    <td> <?php echo $val['NMJABATAN'] ?> </td>
                                    <td class="text-center"> <?php echo $val['LAMA_LOWONG'] ?> </td>
                                </tr>
                                <?php
                                $t++;
                            endforeach
                            ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3"> Maaf data tidak ditemukan </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>