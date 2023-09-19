<script type="text/javascript">
    var datasearch = function (data) {
        data.jenis_kegiatan = $('#search_jenis_kegiatan').val();
        data.status = $('#search_status').val();
    }
    datatable($('div.table-container').attr('data-url'),datasearch);
</script>