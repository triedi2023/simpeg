<script type="text/javascript">
    var datasearch = function (data) {
        data.klpk_id = $('#search_klpk_id').val();
        data.namadiklat = $('#search_namadiklat').val();
        data.status = $('#search_status').val();
    }
    datatable($('div.table-container').attr('data-url'),datasearch);
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('referensi_diklat_teknis/tambah_form'); ?>" class="btndefaultshowtambahubah btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
</script>