<script type="text/javascript">
    function datatable(dataurl, datasearch, headercenter) {
        var setheader = [0];
        if (typeof headercenter !== 'undefined') {
            setheader = headercenter;
        }
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
                },{
                'targets': setheader,
                'className': 'text-center'
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
                url: dataurl,
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
    }

    $('body').on('click', "a.btndefaultshowtambahubah", function (e) {
        open_loading();
        $.ajax({
            type: "GET",
            url: $(this).attr('data-url'),
            dataType: "html",
            cache: false
        }).done(function (result) {
            $('div.prosesdefaultcreateupdate').empty();
            $('div.prosesdefaultcreateupdate').html(result);
            $('div.prosesdefaultcreateupdate').show();
            $("html, body").animate({scrollTop: $('div.prosesdefaultcreateupdate').offset().top}, 100);
            close_loading();
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal menampilkan halaman");
//            console.log("error");
        });
        $('#qualitySelectorDrop').removeClass('active');
        $("#expandDropDown").toggleClass('drop');
        return false;
    });

    $('body').on('submit', 'form.formcreateupdate', function (e) {
        open_loading();
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data: new FormData($(this)[0]),
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json"
        }).done(function (response) {
            if (response.status == 1) {
                note_sukses('div.table-container', response.cu);
                $('div.prosesdefaultcreateupdate').empty();
                $('div.prosesdefaultcreateupdate').hide();
                $('table.defaultgridview').DataTable().ajax.reload();
                $("[id^='field_cr_']").each(function () {
                    $(this).closest('div.form-group').removeClass('has-error');
                    if ($(this).closest('div').children().last().attr('class') == 'help-block') {
                        $(this).closest('div').children().last().remove();
                    }
                });
            } else if (response.status == 2) {
                $('div.prosesdefaultcreateupdate').empty();
                $('div.prosesdefaultcreateupdate').hide();
                note_gagal('div.table-container', response.cu);
            } else {
                $.each(response.errors, function (key, value) {
                    $("#field_cr_" + key).closest('div.form-group').addClass('has-error');
                    if ($("#field_cr_" + key).closest('div').children().last().attr('class') == 'help-block') {
                        $("#field_cr_" + key).closest('div').children().last().remove();
                    }
                    $('<span class="help-block">' + value + '</span>').insertAfter($("#field_cr_" + key).closest('div').children().last());
                });
            }
            close_loading();
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal menambahkan atau mengubah data");
//            console.log("error");
        });
        return false;
    });

    $('body').on('click', ".hapusdataperrow", function () {
        var $dataurl = $(this).attr('data-url');
        var $dataid = $(this).attr('data-id');

        bootbox.confirm({
            message: "Apakah data ini akan di hapus???",
            buttons: {
                confirm: {
                    label: 'Ya',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Tidak',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result == true) {
                    open_loading();
                    $.ajax({
                        type: "POST",
                        url: $dataurl,
                        data: {id: $dataid},
                        dataType: "json"
                    }).done(function (response) {
                        if (response.status == 1) {
                            note_sukses('div.table-container', 'di hapus');
                            $('table.defaultgridview').DataTable().ajax.reload()
                        } else if (response.status == 2) {
                            note_gagal('div.table-container', 'di hapus');
                        }
                        close_loading();
                    }).fail(function () {
                        close_loading();
                        note_gagal('div.table-container', 'di hapus');
                    });
                }
            }
        });
    });

    $('body').on('click', '.popupsmall', function (e) {
        open_loading();

        var urlnya = $(this).attr('data-url');

        $.ajax({
            type: "POST",
            url: urlnya,
            dataType: "html",
            cache: false
        }).done(function (result) {
            $('div#modal-content-small').html(result);
        }).fail(function () {
            toastr.error("Maaf, Gagal menampilkan halaman");
        });

        $("#small").modal('show');
        close_loading();
        return false;
    });
    
    $('body').on('click', '.popuplarge', function (e) {
        open_loading();

        var urlnya = $(this).attr('data-url');
        var idnya = $(this).attr('data-id');
        var setelement = '';
        if (idnya == "") {
            setelement = "popuppilihpegawai";
        } else {
            if (typeof $(this).attr('data-statement') != 'undefined') {
                setelement = $(this).attr('data-statement');
            } else {
                setelement = "popuppilihpegawaiak";
            }
        }

        $.ajax({
            type: "POST",
            url: urlnya,
            data: {setelementnya: setelement},
            dataType: "html",
            cache: false
        }).done(function (result) {
            $('div#modal-content-large').html(result);
        }).fail(function () {
            toastr.error("Maaf, Gagal menampilkan halaman");
        });

        $("#large").modal('show');
        close_loading();
        return false;
    });
    
    $('body').on('click', '.popupfull', function (e) {
        open_loading();

        var urlnya = $(this).attr('data-url');

        $.ajax({
            type: "POST",
            url: urlnya,
            dataType: "html",
            cache: false
        }).done(function (result) {
            $('div#modal-content-full').html(result);
        }).fail(function () {
            toastr.error("Maaf, Gagal menampilkan halaman");
        });

        $("#full").modal('show');
        close_loading();
        return false;
    });

    $("body").on('change', 'select.struktur_lokasi', function () {
        if ($(this).val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturjabatankdu1") ?>',
                data: {lokasi_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select.struktur_kdu1").empty();
                $("select.struktur_kdu1").select2({data: response.data});
                $("select.struktur_kdu2").empty();
                $("select.struktur_kdu2").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Pratama -'}]});
                $("select.struktur_kdu3").empty();
                $("select.struktur_kdu3").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
                $("select.struktur_kdu4").empty();
                $("select.struktur_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select.struktur_kdu5").empty();
                $("select.struktur_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Pimpinan Tinggi Madya");
            });
        } else {
            $("select.struktur_kdu1").empty();
            $("select.struktur_kdu1").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Madya -'}]});
            $("select.struktur_kdu2").empty();
            $("select.struktur_kdu2").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Pratama -'}]});
            $("select.struktur_kdu3").empty();
            $("select.struktur_kdu3").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
            $("select.struktur_kdu4").empty();
            $("select.struktur_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
            $("select.struktur_kdu5").empty();
            $("select.struktur_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
        }
        return false;
    });

    $("body").on('change', 'select.struktur_kdu1', function () {
        if ($(this).val() != "" && $("select.struktur_lokasi").val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturjabatankdu2") ?>',
                data: {lokasi_id: $("select.struktur_lokasi").val(), kdu1_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select.struktur_kdu2").empty();
                $("select.struktur_kdu2").select2({data: response.data});
                $("select.struktur_kdu3").empty();
                $("select.struktur_kdu3").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
                $("select.struktur_kdu4").empty();
                $("select.struktur_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select.struktur_kdu5").empty();
                $("select.struktur_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Pimpinan Tinggi Pratama");
            });
        }
        return false;
    });
    $("body").on('change', 'select.struktur_kdu2', function () {
        if ($(this).val() != "" && $("select.struktur_lokasi").val() != "" && $("select.struktur_kdu1").val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturjabatankdu3") ?>',
                data: {lokasi_id: $("select.struktur_lokasi").val(), kdu1_id: $("select.struktur_kdu1").val(), kdu2_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select.struktur_kdu3").empty();
                $("select.struktur_kdu3").select2({data: response.data});
                $("select.struktur_kdu4").empty();
                $("select.struktur_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select.struktur_kdu5").empty();
                $("select.struktur_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Administrator");
            });
        }
        return false;
    });
    $("body").on('change', 'select.struktur_kdu3', function () {
        if ($(this).val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturjabatankdu4") ?>',
                data: {lokasi_id: $("select.struktur_lokasi").val(), kdu1_id: $("select.struktur_kdu1").val(), kdu2_id: $("select.struktur_kdu2").val(), kdu3_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select.struktur_kdu4").empty();
                $("select.struktur_kdu4").select2({data: response.data});
                $("select.struktur_kdu5").empty();
                $("select.struktur_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Pengawas");
            });
        }
        return false;
    });
    $("body").on('change', 'select.struktur_kdu4', function () {
        if ($(this).val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturjabatankdu5") ?>',
                data: {lokasi_id: $("select.struktur_lokasi").val(), kdu1_id: $("select.struktur_kdu1").val(), kdu2_id: $("select.struktur_kdu2").val(), kdu3_id: $("select.struktur_kdu3").val(), kdu4_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select.struktur_kdu5").empty();
                $("select.struktur_kdu5").select2({data: response.data});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Pelaksana (Eselon V)");
            });
        }
        return false;
    });
    $("body").on('click', '.btnbatalformcu', function () {
        $("div.prosesdefaultcreateupdate").hide();
        $("div.prosesdefaultcreateupdate").empty();
        $("html, body").animate({scrollTop: $('div.portlet-title').offset().top}, 100);
    });
    
    $('body').on('click', 'a.btnpopupsearch', function (e) {
        if ($("div#divsearchpopup").is(":visible")) {
            $("div#divsearchpopup").attr('style', 'display:none');
        } else {
            $("div#divsearchpopup").attr('style', '');
        }
    });
</script>