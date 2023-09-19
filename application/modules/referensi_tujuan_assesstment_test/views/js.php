<script type="text/javascript">
    var datasearch = function (data) {
        data.tujuan_assesstment = $('#search_tujuan_assesstment').val();
        data.status = $('#search_status').val();
    }
    datatable($('div.table-container').attr('data-url'),datasearch);
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('referensi_tujuan_assesstment_test/tambah_form'); ?>" class="btndefaultshowtambahubah btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
</script>