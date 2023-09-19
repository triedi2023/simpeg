<script type="text/javascript">
    var datasearch = function (data) {
        data.search_jns_tanda_jasa = $('#search_jns_tanda_jasa').val();
        data.search_penerbit = $('#search_penerbit').val();
        data.search_penghargaan = $('#search_penghargaan').val();
        data.status = $('#search_status').val();
    }
    datatable($('div.table-container').attr('data-url'),datasearch);
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('referensi_tanda_jasa/tambah_form'); ?>" class="btndefaultshowtambahubah btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
</script>