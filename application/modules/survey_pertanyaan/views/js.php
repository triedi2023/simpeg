<script type="text/javascript">
    var datasearch = function (data) {
        data.judul = $('#search_judul').val();
        data.keterangan = $('#search_keterangan').val();
    }
    datatable($('div.table-container').attr('data-url'), datasearch);
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('survey_pertanyaan/tambah_form'); ?>" class="btndefaultshowtambahubah btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
</script>