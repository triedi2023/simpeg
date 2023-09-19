<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue-dark">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-th"></i> <?= $title_utama ?>
                </div>
                <div class="actions"></div>
            </div>
            <div class="portlet-body">
                <div class="table-container" data-url="<?php echo site_url('master_pegawai/ajax_list_fungsional') ?>">
                    <table class="defaultgridview table table-striped table-bordered table-hover order-column dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%"> No </th>
                                <th class="text-center">NAMA</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Golongan</th>
                                <th class="text-center">TMT Golongan</th>
                                <th class="text-center">Jabatan - Unit Organisasi</th>
                                <th class="text-center" style="width: 5%">TMT Jabatan</th>
                                <th class="text-center" style="width: 13%">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>