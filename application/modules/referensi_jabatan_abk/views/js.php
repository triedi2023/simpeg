<script type="text/javascript">
    var datasearch = function (data) {
        data.nama_jabatan = $('#search_nama_jabatan').val();
    }
    datatable($('div.table-container').attr('data-url'), datasearch);
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('referensi_jabatan_abk/tambah_form'); ?>" class="btndefaultshowtambahubah btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
</script>