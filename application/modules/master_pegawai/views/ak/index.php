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
                <div class="listdetailpegawai table-container" data-url="<?php echo site_url('master_pegawai/master_pegawai_ak/ajax_list?id='.$id) ?>">
                    <table class="defaultgridviewdetailpegawai table table-striped table-bordered table-hover order-column dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%"> No </th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center">Nilai Utama</th>
                                <th class="text-center">Nilai Penunjang</th>
                                <th class="text-center">Jumlah Nilai</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-center">Total</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th>&nbsp;</th>
                            </tr>
                        </tfoot>
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
            "infoEmpty": "&nbsp;|&nbsp;No records found",
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
        "order": [[ 1, "asc"]],
        "columnDefs": [{// set default column settings
                'orderable': false,
                'targets': [0,6]
            }, {
                "searchable": false,
                "targets": [0,6]
            },{
                'targets': [0,6],
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
            url: '<?php echo site_url('master_pegawai/master_pegawai_ak/ajax_list?id='.$id) ?>',
            type: 'POST',
            data: datasearch
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over this page
            pageTotal3 = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    var hasil = intVal(a) + intVal(b);
                    return hasil.toFixed(3);
                }, 0 );
                
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    var hasil = intVal(a) + intVal(b);
                    return hasil.toFixed(3);
                }, 0 );
                
            // Total over this page
            pageTotal5 = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    var hasil = intVal(a) + intVal(b);
                    return hasil.toFixed(3);
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
                pageTotal3
            );
            $( api.column( 4 ).footer() ).html(
                pageTotal
            );
            $( api.column( 5 ).footer() ).html(
                pageTotal5
            );
        }
    });
    <?php if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') { ?>
        $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_ak/tambah_form?id='.$id); ?>" class="btndefaultshowtambahubahdetailpegawai btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
    <?php } ?>
</script>