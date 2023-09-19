<div class="row">
    <div class="col-md-12">
        <div class="panel panel-warning">
            <div class="panel-heading" style="color: #000;">
                <div class="row">
                    <div class="col-md-10"><h3 class="panel-title">Pegawai Berdasarkan Diklat Kepemimpinan</h3></div>
                    <div class="col-md-2 pull-right" style="text-align: right"><a class="cetakjabatan" data-url="<?php echo base_url()."beranda/content_excel?tipe=5" ?>" href="javascript:;">Cetak Excel</a></div>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-scrollable">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="text-center"> No </th>
                                <th class="text-center"> Diklat PIM </th>
                                <th class="text-center"> Jumlah </th>
                                <th class="text-center"> Persen </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($model): ?>
                                <?php $jmltotal = 0; $i=1; foreach ($model as $val): ?>
                                    <tr>
                                        <td class="text-center"> <?=$i;?> </td>
                                        <td class="text-left"> <?php echo $val['NAMA_JENJANG'];?> </td>
                                        <td class="text-center"> <a href="javascript:;" data-indetify="contentjabatan" class="popuplarge" data-url="<?php echo site_url('daftar_pegawai_lengkap/listpegawai?tipe=5&id='.$val['ID']); ?>"><?php echo $val['JML'];?> Pegawai</a> </td>
                                        <td class="text-center"> <?php echo round(($val['JML'] * 100) / $total, 2);?> % </td>
                                    </tr>
                                <?php $i++;$jmltotal += ($val['JML'] * 100) / $total; endforeach; ?>
                                <tr>
                                    <td class="text-center" colspan="2"> Total </td>
                                    <td class="text-center"> <?php echo $total;?> Pegawai </td>
                                    <td class="text-center"> <?php echo $jmltotal;?> % </td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4"> Maaf data tidak ditemukan </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>