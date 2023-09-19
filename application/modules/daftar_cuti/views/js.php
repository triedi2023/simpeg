<script type="text/javascript">
    var datasearch = function (data) {
        data.jenis_libur = $('#search_jenis_libur').val();
        data.status = $('#search_status').val();
    }
    datatable($('div.table-container').attr('data-url'),datasearch);
</script>