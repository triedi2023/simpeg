<script type="text/javascript">
    $("body").on('change', 'select#search_kdu3_id', function () {
        if ($(this).val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu4") ?>',
                data: {lokasi_id: $("select#search_lokasi_id").val(), kdu1_id: $("select#search_kdu1_id").val(), kdu2_id: $("select#search_kdu2_id").val(), kdu3_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#search_kdu4_id").empty();
                $("select#search_kdu4_id").select2({data: response.data});
                <?php if (!empty($this->session->userdata('kdu3')) && $this->session->userdata('idgroup') == 2 && $this->session->userdata('kdu3') == '017') { ?>
                    $("select#search_kdu4_id").trigger('change');
                <?php } ?>
                $("select#search_kdu5_id").empty();
                $("select#search_kdu5_id").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                toastr.error("Maaf, Gagal memanggil data Unit Pengawas");
            });
        }

        return false;
    });
    
    $("body").on('change', 'select#search_kdu2_id', function () {
        if ($(this).val() != "" && $("select#search_lokasi_id").val() != "" && $("select#search_kdu1_id").val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu3") ?>',
                data: {lokasi_id: $("select#search_lokasi_id").val(), kdu1_id: $("select#search_kdu1_id").val(), kdu2_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#search_kdu3_id").empty();
                $("select#search_kdu3_id").select2({data: response.data});
                <?php if (!empty($this->session->userdata('kdu2')) && $this->session->userdata('trlokasi_id') > 2 && $this->session->userdata('idgroup') == 2) { ?>
                    $("select#search_kdu3_id").trigger('change');
                <?php } ?>
                $("select#search_kdu4_id").empty();
                $("select#search_kdu4_id").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select#search_kdu5_id").empty();
                $("select#search_kdu5_id").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Administrator");
            });
        }

        return false;
    });
    
    $("body").on('change', 'select#search_kdu1_id', function () {
        if ($(this).val() != "" && $("select#search_lokasi_id").val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu2") ?>',
                data: {lokasi_id: $("select#search_lokasi_id").val(), kdu1_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#search_kdu2_id").empty();
                $("select#search_kdu2_id").select2({data: response.data});
                <?php if (!empty($this->session->userdata('kdu2')) && $this->session->userdata('idgroup') == 2) { ?>
                    $("select#search_kdu2_id").trigger('change');
                <?php } ?>
                $("select#search_kdu3_id").empty();
                $("select#search_kdu3_id").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
                $("select#search_kdu4_id").empty();
                $("select#search_kdu4_id").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select#search_kdu5_id").empty();
                $("select#search_kdu5_id").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Pimpinan Tinggi Pratama");
            });
        }
        return false;
    });
    
    $("body").on('change', 'select#search_lokasi_id', function () {
        if ($(this).val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu1") ?>',
                data: {lokasi_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#search_kdu1_id").empty();
                $("select#search_kdu1_id").select2({data: response.data});
                <?php if (!empty($this->session->userdata('kdu1')) && $this->session->userdata('idgroup') == 2) { ?>
                    $("select#search_kdu1_id").trigger('change');
                <?php } ?>
                $("select#search_kdu2_id").empty();
                $("select#search_kdu2_id").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Pratama -'}]});
                $("select#search_kdu3_id").empty();
                $("select#search_kdu3_id").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
                $("select#search_kdu4_id").empty();
                $("select#search_kdu4_id").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select#search_kdu5_id").empty();
                $("select#search_kdu5_id").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Pimpinan Tinggi Madya");
            });
        } else {
            $("select#search_kdu1_id").empty();
            $("select#search_kdu1_id").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Madya -'}]});
            $("select#search_kdu2_id").empty();
            $("select#search_kdu2_id").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Pratama -'}]});
            $("select#search_kdu3_id").empty();
            $("select#search_kdu3_id").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
            $("select#search_kdu4_id").empty();
            $("select#search_kdu4_id").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
            $("select#search_kdu5_id").empty();
            $("select#search_kdu5_id").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
        }
        return false;
    });
    
    $("select#search_lokasi_id").select2({data:<?php echo isset($list_lokasi_filter) ? $list_lokasi_filter : '[]'; ?>,allowClear: true});
    <?php if (!empty($this->session->userdata('trlokasi_id')) && $this->session->userdata('idgroup') == 2) { ?>
        $("select#search_lokasi_id").val(<?php echo $this->session->userdata('trlokasi_id'); ?>).trigger('change');
    <?php } ?>
    $("select#search_statuskepeg_id").select2({data:<?php echo isset($list_status_kepegawaian_filter) ? $list_status_kepegawaian_filter : '[]'; ?>,allowClear: true});
    $("select#search_gol_id").select2();
    $("select#search_kdu1_id").select2();
    if ($("select#search_eselon_id").length > 0) {
        $("select#search_eselon_id").select2();
    }
    if ($("select#search_kel_fung_id").length > 0) {
        $("select#search_kel_fung_id").select2();
    }
    $("select#search_kdu2_id").select2();
    if ($("select#search_jabatan_id").length > 0) {
        $("select#search_jabatan_id").select2();
    }
    $("select#search_status_nikah_id").select2();
    $("select#search_kdu3_id").select2();
    $("select#search_pendidikan_id").select2();
    $("select#search_jk_id").select2();
    $("select#search_kdu4_id").select2();
    $("select#search_diklatpim_id").select2();
    $("select#search_kdu5_id").select2();
    var datasearch = function (data) {
        data.nip = $('input#search_nip').val();
        data.nama = $('input#search_nama').val();
        <?php if (!empty($this->session->userdata('trlokasi_id')) && $this->session->userdata('idgroup') == 2) { ?>
            data.lokasi_id = <?php echo $this->session->userdata('trlokasi_id'); ?>;
        <?php } else { ?>
            data.lokasi_id = $('select#search_lokasi_id').val();
        <?php } ?>
        data.statpeg_id = $('select#search_statuskepeg_id').val();
        data.gol_id = $('select#search_gol_id').val();
        <?php if (!empty($this->session->userdata('kdu1')) && $this->session->userdata('idgroup') == 2) { ?>
            data.kdu1_id = '<?php echo $this->session->userdata('kdu1'); ?>';
        <?php } else { ?>
            data.kdu1_id = $('select#search_kdu1_id').val();
        <?php } ?>
        if ($("select#search_eselon_id").length > 0) {
            data.eselon_id = $('select#search_eselon_id').val();
        }
        if ($("select#search_kel_fung_id").length > 0) {
            data.kel_fung_id = $('select#search_kel_fung_id').val();
        }
        <?php if (!empty($this->session->userdata('kdu2')) && $this->session->userdata('idgroup') == 2) { ?>
            data.kdu2_id = '<?php echo $this->session->userdata('kdu2'); ?>';
        <?php } else { ?>
            data.kdu2_id = $('select#search_kdu2_id').val();
        <?php } ?>
        if ($("select#search_jabatan_id").length > 0) {
            data.jabatan_id = $('select#search_jabatan_id').val();
        }
        data.status_nikah_id = $('select#search_status_nikah_id').val();
        <?php if (!empty($this->session->userdata('kdu3')) && $this->session->userdata('trlokasi_id') > 2 && $this->session->userdata('idgroup') == 2) { ?>
            data.kdu3_id = '<?php echo $this->session->userdata('kdu3'); ?>';
        <?php } else { ?>
            data.kdu3_id = $('select#search_kdu3_id').val();
        <?php } ?>
        data.pendidikan_id = $('select#search_pendidikan_id').val();
        data.jk_id = $('select#search_jk_id').val();
        <?php if (!empty($this->session->userdata('kdu4')) && $this->session->userdata('idgroup') == 2 && $this->session->userdata('kdu3') == $this->session->userdata('config')['kelas_upt']) { ?>
            data.kdu4_id = '<?php echo $this->session->userdata('kdu4'); ?>';
        <?php } else { ?>
            data.kdu4_id = $('select#search_kdu4_id').val();
        <?php } ?>
        data.diklatpim_id = $('select#search_diklatpim_id').val();
        if ($("#search_pegawaibaru").length > 0) {
            data.pegawaibaru = $('#search_pegawaibaru').is(':checked');
        }
        data.kdu5_id = $('select#search_kdu5_id').val();
    }
    datatable($('div.table-container').attr('data-url'), datasearch, [0,3,4,6,7]);
    <?php if (isset($create) && $create && $create == 1 && $this->session->get_userdata()['idgroup'] != 3) { ?>
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('master_pegawai/tambah_form'); ?>" class="btntambahpegawai btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
    <?php } ?>
    $('body').on('click', 'a.btntambahpegawai', function () {
        open_loading();
        $.ajax({
            type: "GET",
            url: $(this).attr('data-url'),
            dataType: "html",
            cache: false
        }).done(function (result) {
            $('div.page-content-inner-detail').empty();
            $('div.page-content-inner-detail').html(result);
            $('div.page-content-inner-detail').show();
            $("html, body").animate({scrollTop: $('div.page-content-inner-detail').offset().top}, 100);
            $('div.page-content-inner-list').hide();
            
            $('#qualitySelectorDrop').removeClass('active');
            $('div.page-content-inner-list').hide();
            $('a#expandDropDown').hide();
            $('a#backlist').show();
            close_loading();
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal menampilkan halaman");
        });
        return false;
    });

    $('body').on('click', 'a#backlist', function () {
        $('div.page-content-inner-list').show();
        $('div.page-content-inner-detail').empty();
        $('div.page-content-inner-detail').hide();
        $('a#expandDropDown').show();
        $('a#backlist').hide();
    });
    $('body').on('click', 'a.btndetailpegawai', function () {
        open_loading();
        $.ajax({
            type: "GET",
            url: $(this).attr('data-url'),
            dataType: "html",
            cache: false
        }).done(function (result) {
            $('div.page-content-inner-detail').empty();
            $('div.page-content-inner-detail').html(result);
            $('div.page-content-inner-detail').show();
            $('#qualitySelectorDrop').removeClass('active');
            $("html, body").animate({scrollTop: $('div.page-content-inner-detail').offset().top}, 100);
            $('div.page-content-inner-list').hide();
            $('a#expandDropDown').hide();
            $('a#backlist').show();
            close_loading();
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal menampilkan halaman");
        });
        return false;
    });

    $("body").on('change', "select#field_c_trprovinsilahir_id", function () {
        var pilihan = $(this).val();
        if (pilihan == "") {
            $("select#field_c_trkabupatenlahir_id").empty();
            $("select#field_c_trkabupatenlahir_id").select2({data: [{'id': '', 'text': '- Pilih Kabupaten Lahir -'}]}).trigger('change');
            return false;
        }
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getkabupaten") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#field_c_trkabupatenlahir_id").empty();
            $("select#field_c_trkabupatenlahir_id").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data kabupaten lahir");
        });
        return false;
    });

    $("body").on('change', "select#field_c_trprovinsitinggal_id", function () {
        var pilihan = $(this).val();
        if (pilihan == "") {
            $("select#field_c_trkabupatentinggal_id").empty();
            $("select#field_c_trkabupatentinggal_id").select2({data: [{'id': '', 'text': '- Pilih Kabupaten Tempat Tinggal -'}]}).trigger('change');
            return false;
        }

        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getkabupaten") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#field_c_trkabupatentinggal_id").empty();
            $("select#field_c_trkabupatentinggal_id").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data kabupaten tempat tinggal");
        });
        return false;
    });

    $('body').on('submit', 'form#formunggahfoto', function (e) {
        open_loading();
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data: new FormData($(this)[0]),
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json"
        }).done(function (response) {
            $("img.img-responsive").removeAttr("src").attr("src", "<?php echo base_url() ?>_uploads/photo_pegawai/thumbs/"+response.data+'?'+(new Date()).getTime());
        });
        close_loading();
        $("#large").modal('hide');
        return false;
    });
    $('body').on('submit', 'form.formcreatepegawai', function (e) {
        open_loading();
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data: new FormData($(this)[0]),
            async: true,
            processData: false,
            cache: false,
            contentType: false,
            dataType: "json"
        }).done(function (response) {
            if (response.status == 1) {
                note_sukses('div.portlet-body', response.cu);
                $('form.formcreatepegawai')[0].reset();
                $('form.formcreatepegawai :input').attr('');
                $("[id^='field_c_']").each(function () {
                    $(this).closest('div.form-group').removeClass('has-error');
                    if ($(this).closest('div').children().last().attr('class') == 'help-block') {
                        $(this).closest('div').children().last().remove();
                    }
                });
                $("select").val('').trigger('change');
                $("html, body").animate({scrollTop: 230}, 100);
            } else if (response.status == 2) {
                note_gagal('div.portlet-body', response.cu);
            } else {
                $.each(response.errors, function (key, value) {
                    $("#field_c_" + key).closest('div.form-group').addClass('has-error');
                    if ($("#field_c_" + key).closest('div').children().last().attr('class') == 'help-block') {
                        $("#field_c_" + key).closest('div').children().last().remove();
                    }
                    $('<span class="help-block">' + value + '</span>').insertAfter($("#field_c_" + key).closest('div').children().last());
                });
                $("html, body").animate({scrollTop: $('form.formcreatepegawai').offset().top}, 100);
            }
            close_loading();
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal menambahkan data pegawai");
        });
        return false;
    });

    $('body').on('submit', 'form.formdetailpegawaiwithoutlist', function (e) {
        open_loading();
        e.preventDefault();
        var $identify = $(this).attr("data-identify");

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
                note_sukses('div#tab_content', response.cu);
                $('input#field_c_doc_karpeg').val('');
                $('input#field_c_doc_karisu').val('');
                $('input#field_c_doc_tapen').val('');
                $('input#field_c_doc_ktp').val('');
                $('input#field_c_doc_npwp').val('');
                $('input#field_c_doc_askes').val('');
                $('input#doc_sk').val('');
                $("[id^='field_c_']").each(function () {
                    $(this).closest('div.form-group').removeClass('has-error');
                    if ($(this).closest('div').children().last().attr('class') == 'help-block') {
                        $(this).closest('div').children().last().remove();
                    }
                });
                
                if ($identify == 'cpns') {
                    var datanya = response.pangkat;
                    var pecah = datanya.split(";");
                    $("span.profile-pangkat").text(' ' + pecah[0] + ' ');
                    $("span.profile-gol").text(' ' + pecah[1] + ' ');
                }
                if ($identify == 'cpns') {
                    $("span.profile-jabatan").text(' ' + response.jabatan + ' ');
                }
                
                $("html, body").animate({scrollTop: 230}, 100);
            } else if (response.status == 2) {
                note_gagal('div#tab_content', response.cu);
                $("html, body").animate({scrollTop: 230}, 100);
            } else {
                $.each(response.errors, function (key, value) {
                    $("#field_c_" + key).closest('div.form-group').addClass('has-error');
                    if ($("#field_c_" + key).closest('div').children().last().attr('class') == 'help-block') {
                        $("#field_c_" + key).closest('div').children().last().remove();
                    }
                    $('<span class="help-block">' + value + '</span>').insertAfter($("#field_c_" + key).closest('div').children().last());
                });
                $("html, body").animate({scrollTop: 230}, 100);
            }
            close_loading();
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal menambahkan data pegawai");
        });
        return false;
    });

    $('body').on('click', '[tab-menu-detail="pegawai"]', function (e) {
        var $this = $(this), loadurl = $this.attr('data-url');
        $('span.caption-subject').html($this.text());
        close_loading();
        $.get(loadurl, function (data) {
            $("div#tab_content").html(data);
        });
        close_loading();
    });

    $('body').on('click', 'a.btndefaultshowtambahubahdetailpegawai', function () {
        open_loading();
        $.ajax({
            type: "GET",
            url: $(this).attr('data-url'),
            dataType: "html",
            cache: false
        }).done(function (result) {
            $('div.prosesdefaultcreateupdatedetailpegawai').empty();
            $('div.prosesdefaultcreateupdatedetailpegawai').html(result);
            $('div.prosesdefaultcreateupdatedetailpegawai').show();
            $("html, body").animate({scrollTop: 320}, 100);
            close_loading();
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal menampilkan halaman");
        });
        return false;
    });

    $('body').on('click', '.btnbatalformcudetailpegawai', function (e) {
        $("div.prosesdefaultcreateupdatedetailpegawai").hide();
        $("div.prosesdefaultcreateupdatedetailpegawai").empty();
        $("html, body").animate({scrollTop: $('div.tab-content').offset().top}, 100);
    });
    
    $('body').on('submit', 'form.formdetailpegawaiwithlist', function (e) {
        open_loading();
        e.preventDefault();
        var $identify = $(this).attr("data-identify");

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
                $("div.prosesdefaultcreateupdatedetailpegawai").empty();
                $("div.prosesdefaultcreateupdatedetailpegawai").hide();
                note_sukses('div.listdetailpegawai', response.cu);
                $("[id^='field_cr_']").each(function () {
                    $(this).closest('div.form-group').removeClass('has-error');
                    if ($(this).closest('div').children().last().attr('class') == 'help-block') {
                        $(this).closest('div').children().last().remove();
                    }
                });
                if ($identify == 'updatepangkatpegawai') {
                    var datanya = response.data;
                    var pecah = datanya.split(";");
                    $("span.profile-pangkat").text(' ' + pecah[0] + ' ');
                    $("span.profile-gol").text(' ' + pecah[1] + ' ');
                }
                if ($identify == 'updatejabatanpegawai') {
                    $("span.profile-jabatan").text(' ' + response.data + ' ');
                }
                if ($identify == 'updatependidikanpegawai') {
                    $("span.profile-pendidikan").text(' ' + response.data + ' ');
                }
                $("html, body").animate({scrollTop: 250}, 100);
                $datatablesdetailpegawai.ajax.reload();
            } else if (response.status == 2) {
                note_gagal('div.listdetailpegawai', response.cu);
                $("html, body").animate({scrollTop: 250}, 100);
            } else {
                $.each(response.errors, function (key, value) {
                    $("#field_cr_" + key).closest('div.form-group').addClass('has-error');
                    if ($("#field_cr_" + key).closest('div').children().last().attr('class') == 'help-block') {
                        $("#field_cr_" + key).closest('div').children().last().remove();
                    }
                    $('<span class="help-block">' + value + '</span>').insertAfter($("#field_cr_" + key).closest('div').children().last());
                });
                $("html, body").animate({scrollTop: 320}, 100);
            }
            close_loading();
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal menambahkan data");
        });
        return false;
    });

    $('body').on('click', ".hapusdataperrowlistdetailpegawai", function () {
        var $dataurl = $(this).attr('data-url');
        var $dataid = $(this).attr('data-id');
        var $identify = $(this).attr("data-identify");

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
                            note_sukses('div.listdetailpegawai', 'di hapus');
                            if ($identify == 'updatepangkatpegawai') {
                                var datanya = response.data;
                                var pecah = datanya.split(";");
                                $("span.profile-pangkat").text(' ' + pecah[0] + ' ');
                                $("span.profile-gol").text(' ' + pecah[1] + ' ');
                            }
                            if ($identify == 'updatejabatanpegawai') {
                                $("span.profile-jabatan").text(' ' + response.data + ' ');
                            }
                            if ($identify == 'updatependidikanpegawai') {
                                $("span.profile-pendidikan").text(' ' + response.data + ' ');
                            }
                            $datatablesdetailpegawai.ajax.reload();
                        } else if (response.status == 2) {
                            note_gagal('div.listdetailpegawai', 'di hapus');
                        }
                        close_loading();
                    }).fail(function () {
                        close_loading();
                        note_gagal('div.listdetailpegawai', 'di hapus');
                    });
                }
            }
        });
    });

    $("body").on('change', 'select#field_cr_trpekerjaan_id', function () {
        if ($(this).val() == 1) {
            $("div.pasangan_pns").show();
        } else {
            $("div.pasangan_pns").hide();
            $("input#field_cr_nip").val('');
            $("input#field_cr_nama_lengkap").val('');
            $("input#field_cr_tanggal_lahir").val('');
            $("input#field_cr_tempat_lahir").val('');
            $("input#field_cr_nik").val('');
        }
    });

    $("body").on('click', 'a.popuppilihpegawai', function () {
        $("input#field_cr_nip").val($(this).attr('data-nip'));
        $("input#field_cr_nama_lengkap").val($(this).attr('data-nama'));
        $("input#field_cr_tanggal_lahir").val($(this).attr('data-tgllahir'));
        $("input#field_cr_tempat_lahir").val($(this).attr('data-tptlahir'));
        $("input#field_cr_nik").val($(this).attr('data-nik'));
        $("#large").modal('hide');
    });
    
    $("body").on('click', 'a.popuppilihatasanpegawaicuti', function () {
        $("input#field_cr_nip_atasan").val($(this).attr('data-nip'));
        $("input#field_cr_nama_atasan").val($(this).attr('data-nama'));
        $("input#field_cr_jabatan_atasan").val($(this).attr('data-njabatan'));
        $("input#field_cr_idgolpangkat_atasan").val($(this).attr('data-idpangkatgol'));
        $("input#field_cr_golpangkat_atasan").val($(this).attr('data-pangkatgol'));
        $("input#field_cr_eselon_atasan").val($(this).attr('data-treselonid'));
        $("input#field_cr_id_jabatan_atasan").val($(this).attr('data-trjabatanid'));
        $("input#field_cr_trlokasiid_atasan").val($(this).attr('data-trlokasiid'));
        $("input#field_cr_kdu1_atasan").val($(this).attr('data-kdu1'));
        $("input#field_cr_kdu2_atasan").val($(this).attr('data-kdu2'));
        $("input#field_cr_kdu3_atasan").val($(this).attr('data-kdu3'));
        $("input#field_cr_kdu4_atasan").val($(this).attr('data-kdu4'));
        $("input#field_cr_kdu5_atasan").val($(this).attr('data-kdu5'));
        $("#large").modal('hide');
    });
    
    $("body").on('click', 'a.popuppilihatasanpenilaicuti', function () {
        $("input#field_cr_nip_penilai_atasan").val($(this).attr('data-nip'));
        $("input#field_cr_nama_penilai_atasan").val($(this).attr('data-nama'));
        $("input#field_cr_jabatan_penilai_atasan").val($(this).attr('data-njabatan'));
        $("input#field_cr_idgolpangkat_penilai_atasan").val($(this).attr('data-idpangkatgol'));
        $("input#field_cr_golpangkat_penilai_atasan").val($(this).attr('data-pangkatgol'));
        $("input#field_cr_eselon_penilai_atasan").val($(this).attr('data-treselonid'));
        $("input#field_cr_id_jabatan_penilai_atasan").val($(this).attr('data-trjabatanid'));
        $("input#field_cr_trlokasiid_penilai_atasan").val($(this).attr('data-trlokasiid'));
        $("input#field_cr_kdu1_penilai_atasan").val($(this).attr('data-kdu1'));
        $("input#field_cr_kdu2_penilai_atasan").val($(this).attr('data-kdu2'));
        $("input#field_cr_kdu3_penilai_atasan").val($(this).attr('data-kdu3'));
        $("input#field_cr_kdu4_penilai_atasan").val($(this).attr('data-kdu4'));
        $("input#field_cr_kdu5_penilai_atasan").val($(this).attr('data-kdu5'));
        $("#large").modal('hide');
    });

    $("body").on('click', 'a.popuppilihpegawaiak', function () {
        $("input#field_cr_nip_pejabat").val($(this).attr('data-nip'));
        $("input#field_cr_pejabat_sk").val($(this).attr('data-nama'));
        $("input#field_cr_nama_pejabat").val($(this).attr('data-njabatan'));
        $("#large").modal('hide');
    });

    $("body").on('click', 'a.popuppilihuniversitas', function () {
        $("input#field_cr_nama_lbg").val($(this).attr('data-nama'));
        $("input#field_cr_universitas_id").val($(this).attr('data-id'));
        $("#large").modal('hide');
    });

    $("body").on('click', 'a.popuppilihjurusan', function () {
        $("input#field_cr_jurusan").val($(this).attr('data-nama'));
        $("input#field_cr_jurusan_id").val($(this).attr('data-id'));
        $("#large").modal('hide');
    });

    $("body").on('change', 'select#field_cr_tkt_pendidikan', function () {
        if ($(this).val() < 9) {
            $("div.jurusansmksma").attr('class','col-md-4 jurusansmksma');
            $("div#jurusansmksma").show();
            $("input#field_cr_jurusan").attr('readonly','readonly');
            $("div.option-pendidikan").show();
        } else {
            if ($(this).val() == 11) {
                $("div.jurusansmksma").attr('class','col-md-8 jurusansmksma');
                $("div#jurusansmksma").hide();
                $("input#field_cr_jurusan").removeAttr('readonly');
            } else {
                $("div.option-pendidikan").hide();
            }
        }
    });

    $("body").on('change', 'select#field_cr_jenis_tandajasa', function () {
        var pilihan = $(this).val();
        if (pilihan == "") {
            $("select#field_cr_nama_tandajasa").empty();
            $("select#field_cr_nama_tandajasa").select2({data: [{'id': '', 'text': '- Pilih Nama Tanda Jasa -'}]}).trigger('change');
            return false;
        }
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getnamatandajasa") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#field_cr_nama_tandajasa").empty();
            $("select#field_cr_nama_tandajasa").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data nama tanda jasa");
        });
        return false;
    });

    $("body").on('change', 'select#field_cr_tingkat_hukuman', function () {
        var pilihan = $(this).val();
        if (pilihan == "") {
            $("select#field_cr_jenis_hukuman").empty();
            $("select#field_cr_jenis_hukuman").select2({data: [{'id': '', 'text': '- Pilih Jenis Hukuman -'}]}).trigger('change');
            return false;
        }
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getjenishukuman") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#field_cr_jenis_hukuman").empty();
            $("select#field_cr_jenis_hukuman").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data nama jenis hukuman");
        });
        return false;
    });

    $("body").on('change', "input[name='tgl_mulai_cuti'],input[name='tgl_selesai_cuti']", function (e) {
        e.preventDefault();
        e.stopPropagation();
        if ($('select#field_cr_jenis_cuti').val() == "") {
            $("input[name='tgl_mulai_cuti']").val('');
            $("input[name='tgl_selesai_cuti']").val('');
            return false;
        }
        var tglawal = $("input[name='tgl_mulai_cuti']").val();
        var tglakhir = $("input[name='tgl_selesai_cuti']").val();
        var jeniscuti = 0;
        if ($("select#field_cr_jenis_cuti").length > 0) {
            jeniscuti = $("select#field_cr_jenis_cuti").val();
        }
        if (tglawal == "") {
            $("input[name='tgl_selesai_cuti']").val('');
            return false;
        }
        if (tglakhir == "") {
            tglakhir = tglawal;
            $("input[name='tgl_selesai_cuti']").val(tglawal);
        }

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: '<?php echo site_url("master_pegawai/master_pegawai_cuti/jmlharicuti") ?>',
            data: {tglawal: tglawal, tglakhir: tglakhir, jeniscuti: jeniscuti},
            success: function (response) {
                if ($("input#field_cr_lama_cuti").length > 0) {
                    $("input#field_cr_lama_cuti").val(response.jmlhari);
                } else {
                    $("input[id='field_cr_lama_cuti']").val(response.jmlhari);
                }
                if (response.larangancuti > 0) {
                    $("span.msglarangancuti").show();
                    $("span.msglarangancuti").text('Maaf tanggal tsb dilarang untuk cuti');
                    $("input[name='tgl_mulai_cuti']").val('');
                    $("input[name='tgl_selesai_cuti']").val('');
                    $("input[id='field_cr_lama_cuti']").val('');
                } else {
                    $("span.msglarangancuti").hide();
                    $("span.msglarangancuti").text('');
                }
            }
        });
        
        e.stopImmediatePropagation();
        return false;
    });

    $("body").on('change', 'select#field_cr_kelompok', function () {
        var pilihan = $(this).val();
        if (pilihan == "") {
            $("select#field_cr_nama_diklat").empty();
            $("select#field_cr_nama_diklat").select2({data: [{'id': '', 'text': '- Pilih Nama Diklat -'}]}).trigger('change');
            return false;
        }
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getnamadiklat") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#field_cr_nama_diklat").empty();
            $("select#field_cr_nama_diklat").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data nama diklat teknis");
        });
        return false;
    });
    $("body").on('change', 'select#field_cr_tingkat,select#field_cr_jenis_diklat', function () {
        var pilihan = $('select#field_cr_tingkat').val();
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getjenjangdiklatfungsional") ?>',
            data: {id: pilihan, jenis_diklat: $("select#field_cr_jenis_diklat").val()},
            dataType: "json"
        }).done(function (response) {
            $("select#field_cr_jenjang").empty();
            $("select#field_cr_jenjang").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data nama diklat fungsional");
        });
        return false;
    });
    $("body").on('change', 'select#field_cr_eselon_id', function () {
        var pilihan = $('select#field_cr_eselon_id').val();
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getjabatan") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#field_cr_jabatan_id").empty();
            $("select#field_cr_jabatan_id").select2({data: [{'id': '', 'text': '- Pilih Jabatan -'}]}).trigger('change');
            $("select#field_cr_jabatan_id").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data nama jabatan");
        });
        return false;
    });
    $("body").on('change', 'select#field_cr_status', function () {
        var pilihan = $('select#field_cr_status').val();
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getalasanstatusfungsional") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#field_cr_alasan").empty();
            $("select#field_cr_alasan").select2({data: [{'id': '', 'text': '- Pilih Alasan -'}]}).trigger('change');
            $("select#field_cr_alasan").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data nama jabatan");
        });
        return false;
    });
    $("body").on('change', 'select#field_c_eselon_id', function () {
        var pilihan = $('select#field_c_eselon_id').val();
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getjabatan") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#field_c_jabatan_id").empty();
            $("select#field_c_jabatan_id").select2({data: [{'id': '', 'text': '- Pilih Jabatan -'}]}).trigger('change');
            $("select#field_c_jabatan_id").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data nama jabatan");
        });
        return false;
    });
    
    $('body').on('submit', 'form#popupformpencarianuniversitas', function (e) {
        $popuplistuniversitas.ajax.reload();
        return false;
    });
    $('body').on('submit', 'form#popupformpencarianjurusan', function (e) {
        $popuplistjurusan.ajax.reload();
        return false;
    });
    
    $("body").on('change', 'select#search_eselon_id', function () {
        var pilihan = $('select#search_eselon_id').val();
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getjabatan") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#search_jabatan_id").empty();
            $("select#search_jabatan_id").select2({data: [{'id': '-1', 'text': '- Pilih -'}]}).trigger('change');
            $("select#search_jabatan_id").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data nama jabatan");
        });
        return false;
    });
    
    $("body").on('change', 'select#search_statuskepeg_id', function () {
        var pilihan = $('select#search_statuskepeg_id').val();
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getgolonganbystatus") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#search_gol_id").empty();
            $("select#search_gol_id").select2({data: [{'id': '-1', 'text': '- Pilih -'}]}).trigger('change');
            $("select#search_gol_id").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data nama golongan");
        });
        return false;
    });

    
    $("body").on('change', 'select#search_kdu4_id', function () {
        if ($(this).val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu5") ?>',
                data: {lokasi_id: $("select#search_lokasi_id").val(), kdu1_id: $("select#search_kdu1_id").val(), kdu2_id: $("select#search_kdu2_id").val(), kdu3_id: $("select#search_kdu3_id").val(), kdu4_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#search_kdu5_id").empty();
                $("select#search_kdu5_id").select2({data: response.data});
            }).fail(function () {
                toastr.error("Maaf, Gagal memanggil data Unit Pelaksana (Eselon V)");
            });
        }
        return false;
    });
    
    $('body').on('click', "a.btnexport", function (e) {
        window.open($(this).attr('data-url')+'?nip='+$('input#search_nip').val()+'&nama='+$('input#search_nama').val()
        +'&lokasi_id='+$('select#search_lokasi_id').val()+'&statpeg_id='+$('select#search_statuskepeg_id').val()
        +'&gol_id='+$('select#search_gol_id').val()+'&kdu1_id='+$('select#search_kdu1_id').val()+'&eselon_id='+$('select#search_eselon_id').val()
        +'&kel_fung_id='+$('select#search_kel_fung_id').val()+'&kdu2_id='+$('select#search_kdu2_id').val()
        +'&jabatan_id='+$('select#search_jabatan_id').val()+'&status_nikah_id='+$('select#search_status_nikah_id').val()
        +'&kdu3_id='+$('select#search_kdu3_id').val()+'&pendidikan_id='+$('select#search_pendidikan_id').val()
        +'&jk_id='+$('select#search_jk_id').val()+'&kdu4_id='+$('select#search_kdu4_id').val()
        +'&diklatpim_id='+$('select#search_diklatpim_id').val()+'&pegawaibaru='+$('#search_pegawaibaru').is(':checked')
        +'&kdu5_id='+$('select#search_kdu5_id').val());
        return false;
    });
    
    $('body').on('click', "a.btnexportdrh", function (e) {
        window.open($(this).attr('data-url') + '?nip=' + $(this).attr('data-id'));
        return false;
    });
    
    $('body').on('click', "a.btnexportdrhsp", function (e) {
        window.open($(this).attr('data-url'));
        return false;
    });

</script>