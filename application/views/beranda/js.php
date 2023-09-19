<script type="text/javascript">
    $("body").on('change', 'select#field_trlokasi_id', function () {
        if ($(this).val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu1") ?>',
                data: {lokasi_id: $(this).val()},
                cache: false,
                dataType: "json"
            }).done(function (response) {
                $("select#field_kdu1").empty();
                $("select#field_kdu1").select2({data: response.data});
                <?php if (!empty($this->session->userdata('kdu1')) && $this->session->userdata('idgroup') == 2) { ?>
                    $("select#field_kdu1").trigger('change');
                <?php } ?>
                $("select#field_kdu2").empty();
                $("select#field_kdu2").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Pratama -'}]});
                $("select#field_kdu3").empty();
                $("select#field_kdu3").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
                $("select#field_kdu4").empty();
                $("select#field_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select#field_kdu5").empty();
                $("select#field_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Pimpinan Tinggi Madya");
            });

            $.ajax({
                type: "GET",
                url: '<?php echo site_url("beranda/isi") ?>',
                data: {lokasi_id: $("select#field_trlokasi_id").val()},
                cache: false,
                dataType: "html"
            }).done(function (response) {
                $("div.contentberanda").html(response);
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data isi");
            });
        } else {
            $("select#field_kdu1").empty();
            $("select#field_kdu1").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Madya -'}]});
            $("select#field_kdu2").empty();
            $("select#field_kdu2").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Pratama -'}]});
            $("select#field_kdu3").empty();
            $("select#field_kdu3").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
            $("select#field_kdu4").empty();
            $("select#field_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
            $("select#field_kdu5").empty();
            $("select#field_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
        }

        return false;
    });
    
    <?php if (!empty($this->session->userdata('trlokasi_id')) && $this->session->userdata('idgroup') == 2) { ?>
        $("select#field_trlokasi_id").trigger('change');
    <?php } ?>

    $("body").on('change', 'select#field_kdu1', function () {
        if ($(this).val() != "" && $("select#field_trlokasi_id").val() != "") {
            $("select#tipe").val('1').trigger('change');
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu2") ?>',
                data: {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $(this).val()},
                cache: false,
                dataType: "json"
            }).done(function (response) {
                $("select#field_kdu2").empty();
                $("select#field_kdu2").select2({data: response.data});
                <?php if (!empty($this->session->userdata('kdu2')) && $this->session->userdata('idgroup') == 2) { ?>
                    $("select#field_kdu2").trigger('change');
                <?php } ?>
                $("select#field_kdu3").empty();
                $("select#field_kdu3").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
                $("select#field_kdu4").empty();
                $("select#field_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select#field_kdu5").empty();
                $("select#field_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Pimpinan Tinggi Pratama");
            });

            $.ajax({
                type: "GET",
                url: '<?php echo site_url("beranda/isi") ?>',
                data: {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $(this).val()},
                cache: false,
                dataType: "html"
            }).done(function (response) {
                $("div.contentberanda").html(response);
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data isi");
            });
        }
        return false;
    });

    $("body").on('change', 'select#field_kdu2', function () {
        if ($(this).val() != "" && $("select#field_trlokasi_id").val() != "" && $("select#field_kdu1").val() != "") {
            $("select#tipe").val('1').trigger('change');
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu3") ?>',
                data: {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $(this).val()},
                cache: false,
                dataType: "json"
            }).done(function (response) {
                $("select#field_kdu3").empty();
                $("select#field_kdu3").select2({data: response.data});
                <?php if (!empty($this->session->userdata('kdu2')) && $this->session->userdata('idgroup') == 2) { ?>
                    $("select#field_kdu3").trigger('change');
                <?php } ?>
                $("select#field_kdu4").empty();
                $("select#field_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select#field_kdu5").empty();
                $("select#field_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Administrator");
            });

            $.ajax({
                type: "GET",
                url: '<?php echo site_url("beranda/isi") ?>',
                data: {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $(this).val()},
                cache: false,
                dataType: "html"
            }).done(function (response) {
                $("div.contentberanda").html(response);
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data isi");
            });
        }

        return false;
    });
    $("body").on('change', 'select#field_kdu3', function () {
        if ($(this).val() != "") {
            $("select#tipe").val('1').trigger('change');
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu4") ?>',
                data: {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $("select#field_kdu2").val(), kdu3_id: $(this).val()},
                cache: false,
                dataType: "json"
            }).done(function (response) {
                $("select#field_kdu4").empty();
                $("select#field_kdu4").select2({data: response.data});
                <?php if (!empty($this->session->userdata('kdu2')) && $this->session->userdata('idgroup') == 2) { ?>
                    $("select#field_kdu4").trigger('change');
                <?php } ?>
                $("select#field_kdu5").empty();
                $("select#field_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                toastr.error("Maaf, Gagal memanggil data Unit Pengawas");
            });

            $.ajax({
                type: "GET",
                url: '<?php echo site_url("beranda/isi") ?>',
                data: {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $("select#field_kdu2").val(), kdu3_id: $(this).val()},
                cache: false,
                dataType: "html"
            }).done(function (response) {
                $("div.contentberanda").html(response);
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data isi");
            });
        }

        return false;
    });
    $("body").on('change', 'select#field_kdu4', function () {
        if ($(this).val() != "") {
            $("select#tipe").val('1').trigger('change');
            
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu5") ?>',
                data: {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $("select#field_kdu2").val(), kdu3_id: $("select#field_kdu3").val(), kdu4_id: $(this).val()},
                cache: false,
                dataType: "json"
            }).done(function (response) {
                $("select#field_kdu5").empty();
                $("select#field_kdu5").select2({data: response.data});
            }).fail(function () {
                toastr.error("Maaf, Gagal memanggil data Unit Pelaksana (Eselon V)");
            });

            $.ajax({
                type: "GET",
                url: '<?php echo site_url("beranda/isi") ?>',
                data: {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $("select#field_kdu2").val(), kdu3_id: $("select#field_kdu3").val(), kdu4_id: $(this).val()},
                cache: false,
                dataType: "html"
            }).done(function (response) {
                $("div.contentberanda").html(response);
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data isi");
            });
        }
        return false;
    });

    $("body").on('change', 'select#field_kdu5', function () {
        if ($(this).val() != "") {
            $("select#tipe").val('1').trigger('change');
            
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("beranda/isi") ?>',
                data: {lok: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $("select#field_kdu2").val(), kdu3_id: $("select#field_kdu3").val(), kdu4_id: $("select#field_kdu4").val(), kdu5_id: $(this).val()},
                cache: false,
                dataType: "html"
            }).done(function (response) {
                $("div.contentberanda").html(response);
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data isi");
            });
        }
        return false;
    });

    $('body').on('click', 'a.btnpopupsearch', function (e) {
        if ($("div.m-heading-1").is(":visible")) {
            $("div.m-heading-1").attr('style', 'display:none');
        } else {
            $("div.m-heading-1").attr('style', '');
        }
        return false;
    });
    $('body').on('click', '.popupstack', function (e) {
        open_loading();

        var urlnya = $(this).attr('data-url');
        var idnya = $(this).attr('data-id');

        $.ajax({
            type: "POST",
            url: urlnya,
            data: {id: idnya},
            dataType: "html",
            cache: false
        }).done(function (result) {
            $('div#modal-content-stack').html(result);
        }).fail(function () {
            toastr.error("Maaf, Gagal menampilkan halaman");
        });

        $("#stack").modal('show');
        close_loading();
        return false;
    });

    $('body').on('click', '.popuplarge', function (e) {
        open_loading();

        var datanyanih = {periode: idnya};
        var urlnya = $(this).attr('data-url');
        var idnya = $(this).attr('data-id');
        if ($(this).attr('data-indetify') !== 'undefined' && $(this).attr('data-indetify') == "notifkp") {
            datanyanih = {periode: idnya, lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $("select#field_kdu2").val(), kdu3_id: $("select#field_kdu3").val(), kdu4_id: $("select#field_kdu4").val(), kdu5_id: $("select#field_kdu5").val()};
        }
        if ($(this).attr('data-indetify') !== 'undefined' && $(this).attr('data-indetify') == "contentjabatan") {
            datanyanih = {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $("select#field_kdu2").val(), kdu3_id: $("select#field_kdu3").val(), kdu4_id: $("select#field_kdu4").val(), kdu5_id: $("select#field_kdu5").val()};
        }
        if ($(this).attr('data-indetify') !== 'undefined' && $(this).attr('data-indetify') == "notifpensiun") {
            datanyanih = {bulan: $(this).attr('data-id'), lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $("select#field_kdu2").val(), kdu3_id: $("select#field_kdu3").val(), kdu4_id: $("select#field_kdu4").val(), kdu5_id: $("select#field_kdu5").val()};
        }

        $.ajax({
            type: "POST",
            url: urlnya,
            data: datanyanih,
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
        var idnya = $(this).attr('data-id');

        $.ajax({
            type: "POST",
            url: urlnya,
            data: {periode: idnya},
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

    $('body').on('submit', 'form.formfilter', function (e) {
        open_loading();
        $popuplistpegawai.ajax.reload();
        $('html, body').animate({scrollTop: $('div.portlet-title').offset().top}, 1000);
        close_loading();
        return false;
    });

    $('body').on('click', 'a.btnsetupdashboard', function (e) {
        open_loading();

        var urlnya = $(this).attr('data-url');

        $.ajax({
            type: "GET",
            url: urlnya,
            dataType: "html",
            cache: false
        }).done(function (result) {
            $('div.content_beranda').html(result);
        }).fail(function () {
            toastr.error("Maaf, Gagal menampilkan halaman");
        });

        close_loading();
        return false;
    });

    $('body').on('change', 'select#tipe', function (e) {
        open_loading();

        var urlnya = $(this).attr('data-url');

        $.ajax({
            type: "POST",
            url: urlnya,
            data: {tipe: $(this).val(), trlokasi_id: $("select#field_trlokasi_id").val(), kdu1: $("select#field_kdu1").val(),
                kdu2: $("select#field_kdu2").val(), kdu3: $("select#field_kdu3").val(), kdu4: $("select#field_kdu4").val(), kdu5: $("select#field_kdu5").val()},
            dataType: "html",
            cache: false
        }).done(function (result) {
            $('div.berandacontent').html(result);
        }).fail(function () {
            toastr.error("Maaf, Gagal menampilkan halaman");
        });

        close_loading();
        return false;
    });

    $("body").on('click', 'input.checkboxsetupdashboard', function () {
        var jmlpilihandashboard = [];
        if ($("input.checkboxsetupdashboard").filter(":checked").length < 3) {
            $("input.checkboxsetupdashboard").each(function (index, value) {
                if ($(this).is(":checked")) {
                    if (jmlpilihandashboard.length < 3) {
                        jmlpilihandashboard.push($(this).val());
                    }
                }
            });

            if (jmlpilihandashboard.length == 2) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url() . "beranda/simpansetupdashboard"; ?>',
                    data: {tipe: jmlpilihandashboard},
                    dataType: "json",
                    cache: false
                });

                $.ajax({
                    type: "GET",
                    url: '<?php echo site_url("beranda/isi") ?>',
                    data: {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $("select#field_kdu2").val(), kdu3_id: $("select#field_kdu3").val(), kdu4_id: $("select#field_kdu4").val(), kdu5_id: $("select#field_kdu5").val()},
                    cache: false,
                    dataType: "html"
                }).done(function (response) {
                    $("div.contentberanda").html(response);
                }).fail(function () {
                    close_loading();
                    toastr.error("Maaf, Gagal memanggil data isi");
                });
            }
        } else {
            return false;
        }
    });
    $('body').on('click', "a.cetakjabatan", function (e) {
        window.open($(this).attr('data-url')+'&trlokasi_id='+$("select#field_trlokasi_id").val()+'&kdu1='+$("select#field_kdu1").val()+'&kdu2='+$("select#field_kdu2").val()+'&kdu3='+$("select#field_kdu3").val()+'&kdu4='+$("select#field_kdu4").val()+'&kdu5='+$("select#field_kdu5").val());
        return false;
    });
    
    $("select#field_trlokasi_id").select2();
    $("select#field_kdu1").select2();
    $("select#field_kdu2").select2();
    $("select#field_kdu3").select2();
    $("select#field_kdu4").select2();
    $("select#field_kdu5").select2();
    $("select#tipe").select2();
</script>
<script>
    var ChartsAmcharts = function () {
        var d = function () {
            var e = AmCharts.makeChart("chart_7", {type: "pie", theme: "light", fontFamily: "Open Sans", color: "#888",
                dataProvider: <?= isset($jml_jabatan_umum) ? $jml_jabatan_umum : '[]' ?>,
                valueField: "value", titleField: "jabatan", outlineAlpha: .1, depth3D: 20, radius: 200, autoMargins: false,
                balloonText: "[[title]]<br><span style='font-size:10px'><b>[[value]]</b> ([[percents]]%)</span>", angle: 50,
                exportConfig: {menuItems: [{icon: "/lib/3/images/export.png", format: "png"}]}});
            $("#chart_7").closest(".portlet").find(".fullscreen").click(function () {
                e.invalidateSize()
            })
        }, e = function () {
            var e = AmCharts.makeChart("chart_3", {type: "pie", theme: "light", fontFamily: "Open Sans", color: "#888",
                dataProvider: <?= isset($jml_jabatan_khusus) ? $jml_jabatan_khusus : '[]' ?>,
                valueField: "value", titleField: "jabatan", outlineAlpha: .4, depth3D: 20,
                balloonText: "[[title]]<br><span style='font-size:10px'><b>[[value]]</b> ([[percents]]%)</span>", angle: 50,
                exportConfig: {menuItems: [{icon: "/lib/3/images/export.png", format: "png"}]}});
            $("#chart_3").closest(".portlet").find(".fullscreen").click(function () {
                e.invalidateSize()
            })
        }, o = function () {
            var e = AmCharts.makeChart("chart_5", {theme: "light", type: "serial", columnWidth: 0.5, startDuration: 2, fontFamily: "Open Sans",
                color: "#888", dataProvider: <?php echo isset($jml_jabatan_eselon) ? $jml_jabatan_eselon : '[]' ?>, valueAxes: [{position: "left", axisAlpha: 0, gridAlpha: 0}], graphs: [{balloonText: "[[category]]: <b>[[value]]</b>", colorField: "color", fillAlphas: .85, lineAlpha: .1, type: "column", topRadius: 1, valueField: "value"}], depth3D: 150, angle: 20, chartCursor: {categoryBalloonEnabled: !1, cursorAlpha: 0, zoomable: !1}, categoryField: "jabatan", categoryAxis: {gridPosition: "start", axisAlpha: 0, gridAlpha: 0}, exportConfig: {menuTop: "20px", menuRight: "20px", menuItems: [{icon: "/lib/3/images/export.png", format: "png"}]}}, 0);
            $("#chart_5").closest(".portlet").find(".fullscreen").click(function () {
                e.invalidateSize()
            })
        };
        return{init: function () {
                d(), o(), e()
            }}
    }();
    $(document).ready(function () {
        ChartsAmcharts.init()
    });
</script>