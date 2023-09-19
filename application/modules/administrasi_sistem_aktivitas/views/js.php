<script type="text/javascript">
    var datasearch = function (data) {
        data.username = $('#search_username').val();
        data.nip = $('#search_nip').val();
        data.nama = $('#search_nama_lengkap').val();
        data.deskripsi = $('#search_deskripsi').val();
        data.group = $('#search_group').val();
    }
    datatable($('div.table-container').attr('data-url'),datasearch);
</script>