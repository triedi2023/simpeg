<script type="text/javascript">
    $("body").on('change', 'select#search_trlokasi_id', function () {
        if ($(this).val() != "" && $(this).attr('data-edit') != 1) {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu1") ?>',
                data: {lokasi_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#search_kdu1").empty();
                $("select#search_kdu1").select2({data: response.data});
                <?php if (!empty($this->session->userdata('kdu1')) && $this->session->userdata('idgroup') == 2) { ?>
                    $("select#search_kdu1").trigger('change');
                <?php } ?>
                $("select#search_kdu2").empty();
                $("select#search_kdu2").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Pratama -'}]});
                $("select#search_kdu3").empty();
                $("select#search_kdu3").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
                $("select#search_kdu4").empty();
                $("select#search_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select#search_kdu5").empty();
                $("select#search_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Pimpinan Tinggi Madya");
            });
        } else {
            $("select#search_kdu1").empty();
            $("select#search_kdu1").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Madya -'}]});
            $("select#search_kdu2").empty();
            $("select#search_kdu2").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Pratama -'}]});
            $("select#search_kdu3").empty();
            $("select#search_kdu3").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
            $("select#search_kdu4").empty();
            $("select#search_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
            $("select#search_kdu5").empty();
            $("select#search_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
        }
        return false;
    });

    $("body").on('change', 'select#search_kdu1', function () {
        if ($(this).val() != "" && $("select#search_trlokasi_id").val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu2") ?>',
                data: {lokasi_id: $("select#search_trlokasi_id").val(), kdu1_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#search_kdu2").empty();
                $("select#search_kdu2").select2({data: response.data});
                <?php if (!empty($this->session->userdata('kdu2')) && $this->session->userdata('idgroup') == 2) { ?>
                    $("select#search_kdu2").trigger('change');
                <?php } ?>
                $("select#search_kdu3").empty();
                $("select#search_kdu3").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
                $("select#search_kdu4").empty();
                $("select#search_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select#search_kdu5").empty();
                $("select#search_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Pimpinan Tinggi Pratama");
            });
        }
        return false;
    });
    $("body").on('change', 'select#search_kdu2', function () {
        if ($(this).val() != "" && $("select#search_trlokasi_id").val() != "" && $("select#search_kdu1").val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu3") ?>',
                data: {lokasi_id: $("select#search_trlokasi_id").val(), kdu1_id: $("select#search_kdu1").val(), kdu2_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#search_kdu3").empty();
                $("select#search_kdu3").select2({data: response.data});
                <?php if (!empty($this->session->userdata('kdu3')) && $this->session->userdata('idgroup') == 2) { ?>
                    $("select#search_kdu3").trigger('change');
                <?php } ?>
                $("select#search_kdu4").empty();
                $("select#search_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select#search_kdu5").empty();
                $("select#search_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Administrator");
            });
        }
        return false;
    });
    $("body").on('change', 'select#search_kdu3', function () {
        if ($(this).val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu4") ?>',
                data: {lokasi_id: $("select#search_trlokasi_id").val(), kdu1_id: $("select#search_kdu1").val(), kdu2_id: $("select#search_kdu2").val(), kdu3_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#search_kdu4").empty();
                $("select#search_kdu4").select2({data: response.data});
                <?php if (!empty($this->session->userdata('kdu4')) && $this->session->userdata('idgroup') == 2) { ?>
                    $("select#search_kdu4").trigger('change');
                <?php } ?>
                $("select#search_kdu5").empty();
                $("select#search_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Pengawas");
            });
        }
        return false;
    });
    $("body").on('change', 'select#search_kdu4', function () {
        if ($(this).val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu5") ?>',
                data: {lokasi_id: $("select#search_trlokasi_id").val(), kdu1_id: $("select#search_kdu1").val(), kdu2_id: $("select#search_kdu2").val(), kdu3_id: $("select#search_kdu3").val(), kdu4_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#search_kdu5").empty();
                $("select#search_kdu5").select2({data: response.data});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Pelaksana (Eselon V)");
            });
        }
        return false;
    });
    
    $("select#search_trlokasi_id").select2({data: <?php echo $list_lokasi ?>,allowClear: true});
    <?php if (!empty($this->session->userdata('trlokasi_id')) && $this->session->userdata('idgroup') == 2) { ?>
        $("select#search_trlokasi_id").val(<?php echo $this->session->userdata('trlokasi_id'); ?>).trigger('change');
    <?php } ?>
    $("select#search_kdu1").select2({allowClear: true});
    $("select#search_kdu2").select2({allowClear: true});
    $("select#search_kdu3").select2({allowClear: true});
    $("select#search_kdu4").select2({allowClear: true});
    $("select#search_kdu5").select2({allowClear: true});
</script>