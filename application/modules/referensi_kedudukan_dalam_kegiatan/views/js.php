<script type="text/javascript">
    var datasearch = function (data) {
        data.kedudukan_dalam_kegiatan = $('#search_kedudukan_dalam_kegiatan').val();
        data.status = $('#search_status').val();
    }
    datatable($('div.table-container').attr('data-url'),datasearch);
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('referensi_kedudukan_dalam_kegiatan/tambah_form'); ?>" class="btndefaultshowtambahubah btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
</script>