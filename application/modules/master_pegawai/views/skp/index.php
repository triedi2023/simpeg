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
                <div class="listdetailpegawai table-container" data-url="<?php echo site_url('master_pegawai/master_pegawai_skp/ajax_list?id=' . $id) ?>">
                    <table class="defaultgridviewdetailpegawai table table-striped table-bordered table-hover order-column dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%"> No </th>
                                <th class="text-center" style="width: 20%">Periode</th>
                                <th class="text-center" style="width: 20%">Pangkat / Golongan</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center" style="width: 10%">Aksi</th>
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
        "order": [[1, "asc"]],
        "columnDefs": [{// set default column settings
                'orderable': false,
                'targets': [0, 4]
            }, {
                "searchable": false,
                "targets": [0, 4]
            }, {
                'targets': [0, 4],
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
            url: '<?php echo site_url('master_pegawai/master_pegawai_skp/ajax_list?id=' . $id) ?>',
            type: 'POST',
            data: datasearch
        }
    });
    <?php if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') { ?>
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_skp/tambah_form?id=' . $id); ?>" class="btndefaultshowtambahubahdetailpegawai btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
    <?php } ?>
    $("body").on('change',"input#field_cr_isi_orientasi_pelayanan,input#field_cr_isi_integritas,input#field_cr_isi_komitmen,input#field_cr_isi_disiplin,input#field_cr_isi_kerjasama,input#field_cr_isi_kepemimpinan", function () {
        var jmlsemuanya = Number($("input#field_cr_isi_orientasi_pelayanan").val()) + Number($("input#field_cr_isi_integritas").val()) + Number($("input#field_cr_isi_komitmen").val()) +
                Number($("input#field_cr_isi_disiplin").val()) + Number($("input#field_cr_isi_kerjasama").val()) + Number($("input#field_cr_isi_kepemimpinan").val());
        var bnykprilakukerja = 0;
        $("input[id^='field_cr_isi_']").each(function () {
            if ($(this).val() != "")
                bnykprilakukerja = bnykprilakukerja + 1;
        });
        var total1 = jmlsemuanya / bnykprilakukerja;
        var total2 = ((jmlsemuanya / bnykprilakukerja) * 40) / 100;
        var hasilakhirskp = Number($("th#nilaiskpakhirasli").text());
        $("p#jumlahprilakukerja").text(jmlsemuanya.toFixed(2));
        $("p#nilairataprilakukerja").text(total1.toFixed(2));
        $("p#nilaiprilakukerja").text(total1.toFixed(2) + ' x 40%');
        $("p#textnilaiprilakukerja").text(total2.toFixed(2));

        var isikategori = $(this).attr('data-class').split("-");
        var valuekategori = '';
        if ($(this).val() >= 91 && $(this).val() <= 100) {
            valuekategori = "Sangat Baik";
        } else if ($(this).val() >= 76 && $(this).val() <= 90) {
            valuekategori = "Baik";
        } else if ($(this).val() >= 61 && $(this).val() <= 75) {
            valuekategori = "Cukup";
        } else if ($(this).val() >= 51 && $(this).val() <= 60) {
            valuekategori = "Kurang";
        } else if ($(this).val() != "" && $(this).val() <= 50) {
            valuekategori = "Buruk";
        } else if ($(this).val() == "") {
            valuekategori = "";
        }
        $("#field_cr_kategori_" + isikategori[1]).val(valuekategori);
    });
</script>