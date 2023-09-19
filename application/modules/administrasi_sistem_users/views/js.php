<script type="text/javascript">
    var datasearch = function (data) {
        data.username = $('#search_username').val();
        data.nip = $('#search_nip').val();
        data.nama = $('#search_nama').val();
        data.group = $('#search_group').val();
        data.status = $('#search_status').val();
    }
    datatable($('div.table-container').attr('data-url'),datasearch,[0,1,6,7]);
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('administrasi_sistem_users/tambah_form'); ?>" class="btndefaultshowtambahubah btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
    $('body').on('click', 'a.popuppilihpegawaiak', function (e) {
        $("input[name='nip']").val($(this).attr("data-nip"));
        $("input[name='nama']").val($(this).attr("data-nama"));
        $("#large").modal('hide');
    });
    $('body').on('click', 'a.popuppilihuserid', function (e) {
        $("input[name='username']").val($(this).attr("data-userid"));
        $("#large").modal('hide');
    });
</script>