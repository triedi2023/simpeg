<script type="text/javascript">
    
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

        var urlnya = $(this).attr('data-url');
        var idnya = $(this).attr('data-id');

        $.ajax({
            type: "POST",
            url: urlnya,
            data: {id: idnya},
            dataType: "html",
            cache: false
        }).done(function (result) {
            $('div#modal-content-large').empty();
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

</script>