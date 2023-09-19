<script type="text/javascript">
    var datasearch = function (data) {
        data.kelompok_jabatan = $('#search_kelompok_jabatan').val();
        data.kelompok_fungsional = $('#search_kelompok_fungsional').val();
        data.nama_jabatan = $('#search_nama_jabatan').val();
        data.tingkat_pendidikan = $('#search_tingkat_pendidikan').val();
        data.tingkat_fungsional = $('#search_tingkat_fungsional').val();
        data.status = $('#search_status').val();
    }
    datatable($('div.table-container').attr('data-url'), datasearch);
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('referensi_jabatan/tambah_form'); ?>" class="btndefaultshowtambahubah btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');
</script>