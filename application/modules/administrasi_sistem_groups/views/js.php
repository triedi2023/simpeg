<script type="text/javascript">
    var datasearch = function (data) {
        data.nama_group = $('#search_nama_group').val();
        data.status = $('#search_status').val();
    }
    datatable($('div.table-container').attr('data-url'),datasearch);
</script>