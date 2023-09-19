<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue-dark">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-th"></i> <?= $title_utama ?>
                </div>
                <?php if ($this->session->get_userdata()['idgroup'] != 3) { ?>
                <div class="actions">
                    <a title="Cetak Excel" class="btn white btn-outline btn-circle btn-sm btnexport" data-url="<?php echo site_url("master_pegawai/export_excel") ?>">
                        <i class="fa fa-file-excel-o"></i> Cetak Excel
                    </a>
                </div>
                <?php } ?>
            </div>
            <div class="portlet-body">
                <div class="table-container" data-url="<?php echo site_url('master_pegawai/ajax_list') ?>">
                    <table class="defaultgridview table table-striped table-bordered table-hover order-column dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%"> No </th>
                                <th class="text-center">NAMA</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Golongan</th>
                                <th class="text-center">TMT Golongan</th>
                                <th class="text-center">Jabatan - Unit Organisasi</th>
                                <th class="text-center">TMT Jabatan</th>
                                <th class="text-center" style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>