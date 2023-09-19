<div class="prosesdefaultcreateupdatedetailpegawai row" style="display: none"></div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue-dark">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-th"></i> Daftar <?= $title_utama ?>
                </div>
                <div class="actions"></div>
            </div>
            <div class="portlet-body">
                <div class="listdetailpegawai table-container" data-url="<?php echo site_url('master_pegawai/master_pegawai_jabatan/ajax_list?id='.$id) ?>">
                    <table class="defaultgridviewdetailpegawai table table-striped table-bordered table-hover order-column dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 6%"> No </th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center">No SK Jabatan</th>
                                <th class="text-center">TMT Jabatan</th>
                                <th class="text-center">Keterangan Jabatan</th>
                                <th class="text-center" style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var datasearch = function (data) {
        data.pegawai_id = <?php echo $id ?>;
    }
    var $datatablesdetailpegawai = $('table.defaultgridviewdetailpegawai').DataTable({
        "language": {
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            },
            "emptyTable": "No data available in table",
            "info": "&nbsp;|&nbsp;Total _TOTAL_ data ditemukan.",
            "infoEmpty": "<?php echo $this->config->item('infoEmpty_datatable') ?>",
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
        "order": [[ 3, "desc" ]],
        "searching": false,
        "pagingType": "bootstrap_extended",
        "lengthMenu": [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, "All"] // change per page values here
        ],
        "pageLength": 10,
        "columnDefs": [{// set default column settings
                'orderable': false,
                'targets': [0,4]
            }, {
                "searchable": false,
                "targets": [0,4]
            },{
                'targets': [0,3,4],
                'className': 'text-center'
            }],
        "sDom": "<'row'<'col-sm-10'pli><'col-sm-2'<\"toolbar pull-right\">>><'table-scrollable't><'row'<'col-sm-12 pull-right'pli>>",
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
            url: '<?php echo site_url('master_pegawai/master_pegawai_jabatan/ajax_list?id='.$id) ?>',
            type: 'POST',
            data: datasearch
        }
    });
    
    <?php if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') { ?>
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_jabatan/tambah_form?id='.$id); ?>" class="btndefaultshowtambahubahdetailpegawai btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
    <?php } ?>
</script>