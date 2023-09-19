<script type="text/javascript">
    $('body').on('click', 'a[data-toggle="tabs"]', function (e) {
        var $this = $(this), loadurl = $this.attr('href'), $eselon = $this.attr('eselon');

        $("ul#tabstrukturorganisasi").each(function () {
            $("li").removeClass('active');
        });

        $this.closest('li').addClass('active');

        $.ajax({
            type: "GET",
            url: loadurl,
            cache: false,
            contentType: false,
            dataType: "html"
        }).done(function (data) {
            $("div#tab_2_1").html(data);
        });

        return false;
    });

    $('body').on('click', ".btnbatalformcu", function (e) {
        $("div.prosesdefaultcreateupdate").hide();
        $("div.prosesdefaultcreateupdate").empty();
        $("html, body").animate({scrollTop: $('div.prosesdefaultcreateupdate').offset().top}, 100);
    });
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
        return false;
    });

    $("body").on('change', "select#field_cr_eselon", function () {
        var pilihan = $(this).val();
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getjabatan") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#field_cr_jabatan").empty().trigger('change');
            $("select#field_cr_jabatan").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data kabupaten");
        });
        return false;
    });

    $("body").on('change', "select#field_cr_provinsi", function () {
        var pilihan = $(this).val();
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getkabupaten") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#field_cr_kabupaten").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data kabupaten");
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
                            $('table.defaultgridview').DataTable().ajax.reload();
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
    })

    /*
     * Eselon I
     */
    $('body').ready(function (e) {
        $.ajax({
            type: "GET",
            url: '<?php echo site_url('referensi_struktur/index_eselon_1') ?>',
            dataType: "html"
        }).done(function (data) {
            $("div#tab_2_1").html(data);
        });

        return false;
    });

    $("body").on('change', "select#search_lok_eselon1", function () {
        $datatablestruktur1.ajax.reload();
        $('div.prosesdefaultcreateupdate').empty();
        $('div.prosesdefaultcreateupdate').hide();
    });

    $('body').on('submit', 'form.formcreateupdatestruktur1', function (e) {
        open_loading();
        e.preventDefault();

        var form = new FormData();
        form.append('nmunit', $("input#field_cr_nmunit").val());
        form.append('provinsi', $("select#field_cr_provinsi").val());
        form.append('kabupaten', $("select#field_cr_kabupaten").val());
        form.append('eselon', $("select#field_cr_eselon").val());
        form.append('jabatan', $("select#field_cr_jabatan").val());
        form.append('alamat', $("textarea#field_cr_alamat").val());
        form.append('keterangan', $("textarea#field_cr_keterangan").val());
        form.append('status', $("select#field_cr_status").val());
        form.append('trlokasi_id', $("select#search_lok_eselon1").val());
        form.append('kd_satker', $("input#field_cr_kd_satker").val());
        form.append('idbkn', $("input#field_cr_idbkn").val());
        form.append('namaunor', $("input#field_cr_namaunor").val());
        form.append('eselonbkn', $("select#field_cr_eselonbkn").val());
        form.append('kodecptbkn', $("input#field_cr_kodecptbkn").val());
        form.append('namajbtbkn', $("input#field_cr_namajbtbkn").val());
        form.append('idatasanbkn', $("input#field_cr_idatasanbkn").val());
        form.append('instansiidbkn', $("input#field_cr_instansiidbkn").val());
        form.append('nonpnsbkn', $("input#field_cr_nonpnsbkn").val());
        form.append('pnsbkn', $("input#field_crpnsbkn").val());
        form.append('jenisunorbkn', $("input#field_cr_jenisunorbkn").val());
        form.append('unorindukbkn', $("input#field_cr_unorindukbkn").val());

        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data: form,
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json"
        }).done(function (response) {
            if (response.status == 1) {
                note_sukses('div.table-container', response.cu);
                $('div.prosesdefaultcreateupdate').empty();
                $('div.prosesdefaultcreateupdate').hide();
                $('table.defaultgridview').DataTable().ajax.reload()
            } else if (response.status == 2) {
                $('div.prosesdefaultcreateupdate').empty();
                $('div.prosesdefaultcreateupdate').hide();
                note_gagal('div.table-container', response.cu);
            } else {
                $.each(response.errors, function (key, value) {
                    $("#field_cr_" + key).closest('div.form-group').addClass('has-error');
                    if ($("#field_cr_" + key).closest('div.form-group').children().last().attr('class') == 'help-block') {
                        $("#field_cr_" + key).closest('div.form-group').children().last().remove();
                    }
                    $('<span class="help-block">' + value + '</span>').insertAfter($("#field_cr_" + key).closest('div.form-group').children().last());
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

    /*
     * Eselon II
     */
    $("body").on('change', "select#search_lok_eselon2", function () {
        var pilihan = $(this).val();
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi_struktur/geteselonistruktur2") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#search_kdu1_eselon2").empty().trigger('change');
            $("select#search_kdu1_eselon2").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data eselon I");
        });
        return false;
    });

    $("body").on('change', "select#search_lok_eselon2,select#search_kdu1_eselon2", function () {
        $datatablestruktur2.ajax.reload();
        $('div.prosesdefaultcreateupdate').empty();
        $('div.prosesdefaultcreateupdate').hide();
    });

    $('body').on('submit', 'form.formcreateupdatestruktur2', function (e) {
        open_loading();
        e.preventDefault();

        var form = new FormData();
        form.append('nmunit', $("input#field_cr_nmunit").val());
        form.append('provinsi', $("select#field_cr_provinsi").val());
        form.append('kabupaten', $("select#field_cr_kabupaten").val());
        form.append('eselon', $("select#field_cr_eselon").val());
        form.append('jabatan', $("select#field_cr_jabatan").val());
        form.append('alamat', $("textarea#field_cr_alamat").val());
        form.append('keterangan', $("textarea#field_cr_keterangan").val());
        form.append('status', $("select#field_cr_status").val());
        form.append('trlokasi_id', $("select#search_lok_eselon2").val());
        form.append('kdu1', $("select#search_kdu1_eselon2").val());
        form.append('kd_satker', $("input#field_cr_kd_satker").val());
        form.append('idbkn', $("input#field_cr_idbkn").val());
        form.append('namaunor', $("input#field_cr_namaunor").val());
        form.append('eselonbkn', $("select#field_cr_eselonbkn").val());
        form.append('kodecptbkn', $("input#field_cr_kodecptbkn").val());
        form.append('namajbtbkn', $("input#field_cr_namajbtbkn").val());
        form.append('idatasanbkn', $("input#field_cr_idatasanbkn").val());
        form.append('instansiidbkn', $("input#field_cr_instansiidbkn").val());
        form.append('nonpnsbkn', $("input#field_cr_nonpnsbkn").val());
        form.append('pnsbkn', $("input#field_crpnsbkn").val());
        form.append('jenisunorbkn', $("input#field_cr_jenisunorbkn").val());
        form.append('unorindukbkn', $("input#field_cr_unorindukbkn").val());

        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data: form,
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
            } else if (response.status == 2) {
                $('div.prosesdefaultcreateupdate').empty();
                $('div.prosesdefaultcreateupdate').hide();
                note_gagal('div.table-container', response.cu);
            } else {
                $.each(response.errors, function (key, value) {
                    $("#field_cr_" + key).closest('div.form-group').addClass('has-error');
                    if ($("#field_cr_" + key).closest('div.form-group').children().last().attr('class') == 'help-block') {
                        $("#field_cr_" + key).closest('div.form-group').children().last().remove();
                    }
                    $('<span class="help-block">' + value + '</span>').insertAfter($("#field_cr_" + key).closest('div.form-group').children().last());
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

    /*
     * Eselon III
     */
    $("body").on('change', "select#search_lok_eselon3", function () {
        var pilihan = $(this).val();

        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi_struktur/geteselonistruktur3") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#search_kdu1_eselon3").empty();
            $("select#search_kdu1_eselon3").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data eselon I");
        });
        return false;
    });

    $("body").on('change', "select#search_kdu1_eselon3", function () {
        var pilihan = $(this).val();

        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi_struktur/geteseloniistruktur3") ?>',
            data: {id:$("select#search_lok_eselon3").val(),kdu1: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#search_kdu2_eselon3").empty();
            $("select#search_kdu2_eselon3").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data eselon I");
        });
        
        return false;
    });

    $("body").on('change', "select#search_kdu2_eselon3", function () {
        $datatablestruktur3.ajax.reload();
        $('div.prosesdefaultcreateupdate').empty();
        $('div.prosesdefaultcreateupdate').hide();
    });

    $('body').on('submit', 'form.formcreateupdatestruktur3', function (e) {
        open_loading();
        e.preventDefault();

        var form = new FormData();
        form.append('nmunit', $("input#field_cr_nmunit").val());
        form.append('provinsi', $("select#field_cr_provinsi").val());
        form.append('kabupaten', $("select#field_cr_kabupaten").val());
        form.append('eselon', $("select#field_cr_eselon").val());
        form.append('jabatan', $("select#field_cr_jabatan").val());
        form.append('alamat', $("textarea#field_cr_alamat").val());
        form.append('keterangan', $("textarea#field_cr_keterangan").val());
        form.append('status', $("select#field_cr_status").val());
        form.append('trlokasi_id', $("select#search_lok_eselon3").val());
        form.append('kdu1', $("select#search_kdu1_eselon3").val());
        form.append('kdu2', $("select#search_kdu2_eselon3").val());
        form.append('kd_satker', $("input#field_cr_kd_satker").val());
        form.append('idbkn', $("input#field_cr_idbkn").val());
        form.append('namaunor', $("input#field_cr_namaunor").val());
        form.append('eselonbkn', $("select#field_cr_eselonbkn").val());
        form.append('kodecptbkn', $("input#field_cr_kodecptbkn").val());
        form.append('namajbtbkn', $("input#field_cr_namajbtbkn").val());
        form.append('idatasanbkn', $("input#field_cr_idatasanbkn").val());
        form.append('instansiidbkn', $("input#field_cr_instansiidbkn").val());
        form.append('nonpnsbkn', $("input#field_cr_nonpnsbkn").val());
        form.append('pnsbkn', $("input#field_crpnsbkn").val());
        form.append('jenisunorbkn', $("input#field_cr_jenisunorbkn").val());
        form.append('unorindukbkn', $("input#field_cr_unorindukbkn").val());

        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data: form,
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
            } else if (response.status == 2) {
                $('div.prosesdefaultcreateupdate').empty();
                $('div.prosesdefaultcreateupdate').hide();
                note_gagal('div.table-container', response.cu);
            } else {
                $.each(response.errors, function (key, value) {
                    $("#field_cr_" + key).closest('div.form-group').addClass('has-error');
                    if ($("#field_cr_" + key).closest('div.form-group').children().last().attr('class') == 'help-block') {
                        $("#field_cr_" + key).closest('div.form-group').children().last().remove();
                    }
                    $('<span class="help-block">' + value + '</span>').insertAfter($("#field_cr_" + key).closest('div.form-group').children().last());
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
    
    /*
     * Eselon IV
     */
    $("body").on('change', "select#search_lok_eselon4", function () {
        var pilihan = $(this).val();

        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi_struktur/geteselonistruktur4") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#search_kdu1_eselon4").empty();
            $("select#search_kdu1_eselon4").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data eselon I");
        });
        return false;
    });

    $("body").on('change', "select#search_kdu1_eselon4", function () {
        var pilihan = $(this).val();

        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi_struktur/geteseloniistruktur4") ?>',
            data: {id:$("select#search_lok_eselon4").val(),kdu1: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#search_kdu2_eselon4").empty();
            $("select#search_kdu2_eselon4").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data eselon I");
        });
        
        return false;
    });
    
    $("body").on('change', "select#search_kdu2_eselon4", function () {
        var pilihan = $(this).val();

        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi_struktur/geteseloniiistruktur4") ?>',
            data: {id:$("select#search_lok_eselon4").val(),kdu1:$("select#search_kdu1_eselon4").val(),kdu2: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#search_kdu3_eselon4").empty();
            $("select#search_kdu3_eselon4").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data eselon I");
        });
        
        return false;
    });

    $("body").on('change', "select#search_kdu3_eselon4", function () {
        $datatablestruktur4.ajax.reload();
        $('div.prosesdefaultcreateupdate').empty();
        $('div.prosesdefaultcreateupdate').hide();
    });

    $('body').on('submit', 'form.formcreateupdatestruktur4', function (e) {
        open_loading();
        e.preventDefault();

        var form = new FormData();
        form.append('nmunit', $("input#field_cr_nmunit").val());
        form.append('provinsi', $("select#field_cr_provinsi").val());
        form.append('kabupaten', $("select#field_cr_kabupaten").val());
        form.append('eselon', $("select#field_cr_eselon").val());
        form.append('jabatan', $("select#field_cr_jabatan").val());
        form.append('alamat', $("textarea#field_cr_alamat").val());
        form.append('keterangan', $("textarea#field_cr_keterangan").val());
        form.append('status', $("select#field_cr_status").val());
        form.append('trlokasi_id', $("select#search_lok_eselon4").val());
        form.append('kdu1', $("select#search_kdu1_eselon4").val());
        form.append('kdu2', $("select#search_kdu2_eselon4").val());
        form.append('kdu3', $("select#search_kdu3_eselon4").val());
        form.append('kd_satker', $("input#field_cr_kd_satker").val());
        form.append('idbkn', $("input#field_cr_idbkn").val());
        form.append('namaunor', $("input#field_cr_namaunor").val());
        form.append('eselonbkn', $("select#field_cr_eselonbkn").val());
        form.append('kodecptbkn', $("input#field_cr_kodecptbkn").val());
        form.append('namajbtbkn', $("input#field_cr_namajbtbkn").val());
        form.append('idatasanbkn', $("input#field_cr_idatasanbkn").val());
        form.append('instansiidbkn', $("input#field_cr_instansiidbkn").val());
        form.append('nonpnsbkn', $("input#field_cr_nonpnsbkn").val());
        form.append('pnsbkn', $("input#field_crpnsbkn").val());
        form.append('jenisunorbkn', $("input#field_cr_jenisunorbkn").val());
        form.append('unorindukbkn', $("input#field_cr_unorindukbkn").val());

        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data: form,
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json"
        }).done(function (response) {
            if (response.status == 1) {
                note_sukses('div.table-container', response.cu);
                $('div.prosesdefaultcreateupdate').empty();
                $('div.prosesdefaultcreateupdate').hide();
                $('table.defaultgridview').DataTable().ajax.reload()
            } else if (response.status == 2) {
                $('div.prosesdefaultcreateupdate').empty();
                $('div.prosesdefaultcreateupdate').hide();
                note_gagal('div.table-container', response.cu);
            } else {
                $.each(response.errors, function (key, value) {
                    $("#field_cr_" + key).closest('div.form-group').addClass('has-error');
                    if ($("#field_cr_" + key).closest('div.form-group').children().last().attr('class') == 'help-block') {
                        $("#field_cr_" + key).closest('div.form-group').children().last().remove();
                    }
                    $('<span class="help-block">' + value + '</span>').insertAfter($("#field_cr_" + key).closest('div.form-group').children().last());
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
    
    /*
     * Eselon V
     */
    $("body").on('change', "select#search_lok_eselon5", function () {
        var pilihan = $(this).val();

        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi_struktur/geteselonistruktur5") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#search_kdu1_eselon5").empty();
            $("select#search_kdu1_eselon5").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data eselon I");
        });
        return false;
    });

    $("body").on('change', "select#search_kdu1_eselon5", function () {
        var pilihan = $(this).val();

        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi_struktur/geteseloniistruktur5") ?>',
            data: {id:$("select#search_lok_eselon5").val(),kdu1: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#search_kdu2_eselon5").empty();
            $("select#search_kdu2_eselon5").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data eselon I");
        });
        
        return false;
    });
    
    $("body").on('change', "select#search_kdu2_eselon5", function () {
        var pilihan = $(this).val();

        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi_struktur/geteseloniiistruktur5") ?>',
            data: {id:$("select#search_lok_eselon5").val(),kdu1:$("select#search_kdu1_eselon5").val(),kdu2: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#search_kdu3_eselon5").empty();
            $("select#search_kdu3_eselon5").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data eselon I");
        });
        
        return false;
    });
    
    $("body").on('change', "select#search_kdu3_eselon5", function () {
        var pilihan = $(this).val();

        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi_struktur/geteselonivstruktur5") ?>',
            data: {id:$("select#search_lok_eselon5").val(),kdu1:$("select#search_kdu1_eselon5").val(),kdu2:$("select#search_kdu2_eselon5").val(),kdu3: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#search_kdu4_eselon5").empty();
            $("select#search_kdu4_eselon5").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data eselon I");
        });
        
        return false;
    });

    $("body").on('change', "select#search_kdu4_eselon5", function () {
        $datatablestruktur5.ajax.reload();
        $('div.prosesdefaultcreateupdate').empty();
        $('div.prosesdefaultcreateupdate').hide();
    });

    $('body').on('submit', 'form.formcreateupdatestruktur5', function (e) {
        open_loading();
        e.preventDefault();

        var form = new FormData();
        form.append('nmunit', $("input#field_cr_nmunit").val());
        form.append('provinsi', $("select#field_cr_provinsi").val());
        form.append('kabupaten', $("select#field_cr_kabupaten").val());
        form.append('eselon', $("select#field_cr_eselon").val());
        form.append('jabatan', $("select#field_cr_jabatan").val());
        form.append('alamat', $("textarea#field_cr_alamat").val());
        form.append('keterangan', $("textarea#field_cr_keterangan").val());
        form.append('status', $("select#field_cr_status").val());
        form.append('trlokasi_id', $("select#search_lok_eselon5").val());
        form.append('kdu1', $("select#search_kdu1_eselon5").val());
        form.append('kdu2', $("select#search_kdu2_eselon5").val());
        form.append('kdu3', $("select#search_kdu3_eselon5").val());
        form.append('kdu4', $("select#search_kdu4_eselon5").val());
        form.append('kd_satker', $("input#field_cr_kd_satker").val());
        form.append('idbkn', $("input#field_cr_idbkn").val());
        form.append('namaunor', $("input#field_cr_namaunor").val());
        form.append('eselonbkn', $("select#field_cr_eselonbkn").val());
        form.append('kodecptbkn', $("input#field_cr_kodecptbkn").val());
        form.append('namajbtbkn', $("input#field_cr_namajbtbkn").val());
        form.append('idatasanbkn', $("input#field_cr_idatasanbkn").val());
        form.append('instansiidbkn', $("input#field_cr_instansiidbkn").val());
        form.append('nonpnsbkn', $("input#field_cr_nonpnsbkn").val());
        form.append('pnsbkn', $("input#field_crpnsbkn").val());
        form.append('jenisunorbkn', $("input#field_cr_jenisunorbkn").val());
        form.append('unorindukbkn', $("input#field_cr_unorindukbkn").val());

        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data: form,
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
            } else if (response.status == 2) {
                $('div.prosesdefaultcreateupdate').empty();
                $('div.prosesdefaultcreateupdate').hide();
                note_gagal('div.table-container', response.cu);
            } else {
                $.each(response.errors, function (key, value) {
                    $("#field_cr_" + key).closest('div.form-group').addClass('has-error');
                    if ($("#field_cr_" + key).closest('div.form-group').children().last().attr('class') == 'help-block') {
                        $("#field_cr_" + key).closest('div.form-group').children().last().remove();
                    }
                    $('<span class="help-block">' + value + '</span>').insertAfter($("#field_cr_" + key).closest('div.form-group').children().last());
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
</script>