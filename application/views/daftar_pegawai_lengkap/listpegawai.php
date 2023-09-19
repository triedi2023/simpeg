<div class="modal-header bg-yellow-soft bg-font-yellow-soft" style="padding: 10px">
    <i class="bg-font-blue-madison font-lg icon-close pull-right" title="Tutup" style="line-height: 26px;cursor: pointer" data-dismiss="modal" aria-hidden="true"></i>
    <h4 class="modal-title bg-font-blue-madison font-lg sbold pull-left">Daftar Pegawai</h4>
</div>
<div class="modal-body">
    <div class="m-heading-1 border-yellow-haze m-bordered" style="display: none">
        <form class="form-inline popupformfilter" role="form" action="javascript:;">
            <div class="form-group">
                <label class="sr-only">NIP Atau Nama Pegawai</label>
                <input type="text" class="form-control input-xlarge" id="nama_nip" name="nama_nip" placeholder="Cari berdasarkan NIP atau Nama">
            </div>
            <button type="submit" class="btn btn-default blue-madison">Cari</button>
        </form>
    </div>
    <div class="panel-success">
        <div class="table-container" data-url="<?php echo site_url('daftar_pegawai_lengkap/ajax_listpegawai') ?>">
            <table class="table popuplistpegawai table table-striped table-bordered table-hover order-column dataTable no-footer">
                <thead>
                    <tr class="bg-yellow-haze bg-font-yellow-haze">
                        <th style="width: 5%" class="text-center" style="width: 5%"> No </th>
                        <th style="width: 15%" class="text-center" style="width: 20%"> Foto </th>
                        <th class="text-center"> Keterangan </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
</div>
<script>
    var datasearch = function (data) {
        data.tipe = <?php echo ($tipe) ? $tipe : 3 ?>;
        data.jabatan = '<?php echo ($jabatan) ? $jabatan : 0 ?>';
        data.trlokasi_id = '<?php echo ($trlokasi_id) ? $trlokasi_id : '' ?>';
        data.kdu1 = '<?php echo ($kdu1) ? $kdu1 : '' ?>';
        data.kdu2 = '<?php echo ($kdu2) ? $kdu2 : '' ?>';
        data.kdu3 = '<?php echo ($kdu3) ? $kdu3 : '' ?>';
        data.kdu4 = '<?php echo ($kdu4) ? $kdu4 : '' ?>';
        data.kdu5 = '<?php echo ($kdu5) ? $kdu5 : '' ?>';
        data.nama_nip = $("input#nama_nip").val();
    }
    var $popuplistpegawai = $('table.popuplistpegawai').DataTable({
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
        "order": [[ 2, "asc"]],
        "columnDefs": [
            {// set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
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
            url: '<?php echo site_url('daftar_pegawai_lengkap/ajax_listpegawai') ?>',
            type: 'POST',
            data: datasearch
        }
    });
    $("div.iconsearchpopup").html('<a href="javascript:;" class="btndownloadexcel btn green-haze btn-sm btn-circle" title="Cetak Excel"><i class="fa fa-file-excel-o"></i></a>&nbsp;<a href="javascript:;" title="Pencarian" class="btnpopupsearch btn blue btn-sm btn-circle"><i class="fa fa-search"></i></a>');
    $('body').on('click','a.btndownloadexcel',function(e) {
        e.stopImmediatePropagation();
        var datatable = $popuplistpegawai.ajax.params();
        var tipe = datatable.tipe;
        var jabatan = datatable.jabatan;
        var trlokasi_id = datatable.trlokasi_id;
        var kdu1 = datatable.kdu1;
        var kdu2 = datatable.kdu2;
        var kdu3 = datatable.kdu3;
        var kdu4 = datatable.kdu4;
        var kdu5 = datatable.kdu5;
        window.open('<?php echo site_url('daftar_pegawai_lengkap/cetak_excel') ?>?tipe='+tipe+'&jabatan='+jabatan+'&trlokasi_id='+trlokasi_id+'&kdu1='+kdu1+'&kdu2='+kdu2+'&kdu3='+kdu3+'&kdu4='+kdu4+'&kdu5='+kdu5);
        return false;
    });
    $('body').on('submit', 'form.popupformfilter', function (e) {
        e.stopImmediatePropagation();
        $popuplistpegawai.ajax.reload();
        return false;
    });
</script>