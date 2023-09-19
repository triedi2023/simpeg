<script type="text/javascript">
    var datasearch = function (data) {
        data.agama = $('#search_agama').val();
        data.status = $('#search_status').val();
    }
    datatable($('div.table-container').attr('data-url'),datasearch);
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url("daftar_pegawai/listpegawai") ?>" data-id="popuppilihpegawai" class="popuppilihpegawainya btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
    
    $('body').on('click', '.popuppilihpegawainya', function (e) {
        e.stopImmediatePropagation();
        open_loading();

        var urlnya = $(this).attr('data-url');
        var setelement = $(this).attr('data-id');

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
    
    $('body').on('click', '.btnpopupsearch', function (e) {
        if ($("div#divsearchpopup").is(":visible")) {
            $("div#divsearchpopup").attr('style', '');
        } else {
            $("div#divsearchpopup").attr('style', 'display:none');
        }
    });
    
    $('body').on('click', 'a.popuppilihpegawai', function (e) {
        var nipnya = $(this).attr("data-nip");
        $.ajax({
            type: "POST",
            url: '<?php echo site_url('daftar_pegawai_bsg/tambah_proses') ?>',
            data: {nip: nipnya},
            dataType: "json",
            cache: false
        }).done(function (result) {
            if (result.status == 1) {
                toastr.success("Berhasil menambah pegawai");
            } else {
                toastr.error("Maaf, Gagal menambah pegawai");
            }
        }).fail(function () {
            toastr.error("Maaf, Gagal menampilkan halaman");
        });
        
        $('table.defaultgridview').DataTable().ajax.reload();
        
        $("#large").modal('hide');
        return false;
    });
</script>