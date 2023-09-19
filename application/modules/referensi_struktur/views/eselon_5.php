<div class="m-heading-1 border-green m-bordered">
    <!-- BEGIN FORM-->
    <form action="#" class="form-horizontal">
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-3 control-label text-left">Lokasi</label>
                <div class="col-md-9">
                    <select name="search_lok_eselon5" id="search_lok_eselon5" class="form-control"></select>
                </div>
            </div>
            <div class="form-group last">
                <label class="col-md-3 control-label text-left">Eselon 1</label>
                <div class="col-md-9">
                    <select name="search_kdu1_eselon5" id="search_kdu1_eselon5" class="form-control">
                        <?php if (isset($list_kdu1)): ?>
                            <?php foreach ($list_kdu1 as $val): ?>
                                <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>
            <div class="form-group last">
                <label class="col-md-3 control-label text-left">Eselon 2</label>
                <div class="col-md-9">
                    <select name="search_kdu2_eselon5" id="search_kdu2_eselon5" class="form-control">
                        <?php if (isset($list_kdu2)): ?>
                            <?php foreach ($list_kdu2 as $val): ?>
                                <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>
            <div class="form-group last">
                <label class="col-md-3 control-label text-left">Eselon 3</label>
                <div class="col-md-9">
                    <select name="search_kdu3_eselon5" id="search_kdu3_eselon5" class="form-control">
                        <?php if (isset($list_kdu3)): ?>
                            <?php foreach ($list_kdu3 as $val): ?>
                                <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>
            <div class="form-group last">
                <label class="col-md-3 control-label text-left">Eselon 4</label>
                <div class="col-md-9">
                    <select name="search_kdu4_eselon5" id="search_kdu4_eselon5" class="form-control">
                        <?php if (isset($list_kdu4)): ?>
                            <?php foreach ($list_kdu4 as $val): ?>
                                <option value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>
        </div>
    </form>
    <!-- END FORM-->
</div>
<div class="prosesdefaultcreateupdate row"></div>
<div class="portlet box blue-dark">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-th"></i> Data Struktur Eselon 5
        </div>
        <div class="actions"></div>
    </div>
    <div class="portlet-body">
        <div class="table-container" data-url="<?php echo site_url('referensi_struktur/ajax_list_eselon_5') ?>">
            <table class="defaultgridview table table-striped table-bordered table-hover order-column dataTable no-footer">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10%"> No </th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Nama Unit Kerja</th>
                        <th class="text-center">Wilayah</th>
                        <th class="text-center">Eselon</th>
                        <th class="text-center">Jabatan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    $("select#search_lok_eselon5").select2({data: <?= $list_lokasi ?>});
    $("select#search_kdu1_eselon5").select2();
    $("select#search_kdu2_eselon5").select2();
    $("select#search_kdu3_eselon5").select2();
    $("select#search_kdu4_eselon5").select2();
    var datasearch = function (data) {
        data.trlokasi_id = $('select#search_lok_eselon5').val();
        data.kdu1 = $('select#search_kdu1_eselon5').val();
        data.kdu2 = $('select#search_kdu2_eselon5').val();
        data.kdu3 = $('select#search_kdu3_eselon5').val();
        data.kdu4 = $('select#search_kdu4_eselon5').val();
    }
    var $datatablestruktur5 = $('table.defaultgridview').DataTable({
        "language": {
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            },
            "emptyTable": "No data available in table",
            "info": "&nbsp;|&nbsp;Total _TOTAL_ data ditemukan.",
            "infoEmpty": "No records found",
            "infoFiltered": "",
            "lengthMenu": "Menampilkan _MENU_ per-Halaman",
            "c": "Search:",
            "zeroRecords": "No matching records found",
            "paginate": {
                "page": 'Halaman',
                "previous": "Prev",
                "next": "Next",
                "last": "Last",
                "first": "First",
                "pageOf": "Dari"
            }
        },
        "searching": false,
        "pagingType": "bootstrap_extended",
        "lengthMenu": [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, "All"] // change per page values here
        ],
        "pageLength": 10,
        "columnDefs": [{// set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
        "sDom": "<'row'<'col-sm-8'pli><'col-sm-4'<\"toolbar pull-right\">>><'table-scrollable't><'row'<'col-sm-12 pull-right'pli>>",
        buttons: [
            {
                text: 'My button',
                action: function (e, dt, node, config) {
                    alert('Button activated');
                }
            }
        ],
        serverSide: true,
        processing: true,
        ajax: {
            url: '<?php echo site_url('referensi_struktur/ajax_list_eselon_5') ?>',
            type: 'POST',
            data: datasearch
        }
    });
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('referensi_struktur/tambah_form_eselon_5'); ?>" class="btndefaultshowtambahubah btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
</script>