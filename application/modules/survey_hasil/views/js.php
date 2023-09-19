<script type="text/javascript">
    var datasearch = function (data) {
        data.judul = $('#search_judul').val();
        data.keterangan = $('#search_keterangan').val();
    }
    datatable($('div.table-container').attr('data-url'), datasearch);
</script>