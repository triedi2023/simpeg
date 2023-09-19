<script type="text/javascript">
    var datasearch = function (data) {
        data.nip = $('#search_nip').val();
        data.nama = $('#search_nama').val();
    }
    datatable($('div.table-container').attr('data-url'), datasearch);
</script>