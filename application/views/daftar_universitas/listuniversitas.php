<div class="modal-header bg-yellow-soft bg-font-yellow-soft" style="padding: 10px">
    <i class="bg-font-blue-madison font-lg icon-close pull-right" style="line-height: 26px;cursor: pointer" data-dismiss="modal" aria-hidden="true"></i>
    <h4 class="modal-title bg-font-blue-madison font-lg sbold pull-left">Daftar Universitas</h4>
</div>
<div class="modal-body">
    <div class="m-heading-1 border-yellow-haze m-bordered" id="divsearchpopup" style="display: none">
        <form class="form-inline popupformfilter" id="popupformpencarianuniversitas" role="form" action="javascript:;">
            <div class="form-group">
                <label class="sr-only" for="nama_nip">Nama</label>
                <input type="nama_univ" class="form-control input-xlarge" id="nama_univ" placeholder="Cari berdasarkan Nama Universitas">
            </div>
            <button type="submit" class="btn btn-default blue-madison">Cari</button>
        </form>
    </div>
    <div class="panel-success">
        <div class="table-container" data-url="<?php echo site_url('daftar_universitas/ajax_listuniversitas') ?>">
            <table class="table popuplistuniversitas table table-striped table-bordered table-hover order-column dataTable no-footer">
                <thead>
                    <tr class="bg-yellow-haze bg-font-yellow-haze">
                        <th style="width: 5%" class="text-center"> NO </th>
                        <th class="text-center"> Nama Universitas </th>
                        <th class="text-center"> Singkatan </th>
                        <th style="width: 5%" class="text-center"> Aksi </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3"> Maaf data tidak ditemukan </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
</div>
<script>
    var datasearch = function (data) {
        data.nama_univ = $("input#nama_univ").val();
    }
    var $popuplistuniversitas = $('table.popuplistuniversitas').DataTable({
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
        "order": [[ 1, "asc"]],
        "columnDefs": [{// set default column settings
                'orderable': false,
                'targets': [0,3]
            }, {
                "searchable": false,
                "targets": [0,3]
            },{
                'targets': [0,3],
                'className': 'text-center'
            }],
        "sDom": "<'row'<'col-sm-10'pli><'col-sm-2'<\"toolbar pull-right iconsearchpopup\">>><'table-scrollable't><'row'<'col-sm-12 pull-right'pli>>",
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
            url: '<?php echo site_url('daftar_universitas/ajax_listuniversitas') ?>',
            type: 'POST',
            data: datasearch
        }
    });
    $("div.iconsearchpopup").html('<a href="javascript:;" title="Cari" class="btnpopupsearch btn blue btn-sm btn-circle"><i class="fa fa fa-search"></i></a>');
</script>