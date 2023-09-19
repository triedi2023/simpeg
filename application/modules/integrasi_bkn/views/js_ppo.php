<script type="text/javascript">
    var datasearch = function (data) {
        data.tgl_awal = $('#search_tgl_awal').val();
        data.tgl_akhir = $('#search_tgl_akhir').val();
    }
//    datatable($('div.table-container-kpo').attr('data-url'), datasearch, [[4, 'desc'], [7, 'desc']]);
    var $datatable = $('table.defaultgridview').DataTable({
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
            }, {
                'targets': [0],
                'className': 'text-center'
            }],
        "order": [[3, 'desc'], [4, 'desc'], [7, 'desc']],
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
            url: "<?php echo site_url('integrasi_bkn/ajax_list_pposk') ?>",
            type: 'POST',
            data: datasearch
        }
    });
    $('body').on('submit', 'form.formfilter', function (e) {
        open_loading();
        $datatable.ajax.reload();
        $('html, body').animate({scrollTop: $('div.portlet-title').offset().top}, 1000);
        close_loading();
        return false;
    });

    $('body').on('click', 'button.btnsearchno', function (e) {
        open_loading();
        $('form.formfilter')[0].reset();
        $("select").val('').trigger('change');
        $datatable.ajax.reload();
        $('#qualitySelectorDrop').removeClass('active');
        close_loading();
        return false;
    });
    $("input#search_tgl_awal").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#search_tgl_akhir").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>