<script type="text/javascript">
    var datasearch = function (data) {
        data.nama_jenjang = $('#search_jenjang').val();
        data.level = $('#search_level').val();
        data.status = $('#search_status').val();
    }
    datatable($('div.table-container').attr('data-url'),datasearch);
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('referensi_tkt_diklat_pim/tambah_form'); ?>" class="btndefaultshowtambahubah btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
    $(function(){
        $("#level_pim,#field_cr_level_pim").inputmask({mask:"9",repeat:10,greedy:!1});
    })
</script>