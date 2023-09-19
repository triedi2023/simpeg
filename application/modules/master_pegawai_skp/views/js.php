<script type="text/javascript">
    var gambar_hapus = '<?php echo base_url(); ?>/assets/img/delete2.png';
    
    var datasearch = function (data) {
        data.tkt_pendidikan = $('#search_tkt_pendidikan').val();
        data.status = $('#search_status').val();
    }
    datatable($('div.table-container').attr('data-url'), datasearch, [0,4]);
    $("div.toolbar").html('<a href="javascript:;" data-url="<?php echo site_url('master_pegawai_skp/tambah_form'); ?>" class="btndefaultshowtambahubah btn blue btn-sm btn-circle"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Tambah Data</a>');

    $("body").on('click', "a[id^='create_data_detail']", function () {
        var tetap = $(this).attr('class');
        var jmldatatambah = $("textarea[id^='" + tetap + "pokok']").length;
        jmldata = jmldatatambah + 1;

        if (tetap == "utama_") {
            $('<tr class="center">\n' +
                    '<td>\n' +
                    '<a href="javascript:void(0)" class="' + tetap + '" name="tambah data" title="tambah data" id="hapus_data_detail">\n' +
                    '<img border="0" src="' + gambar_hapus + '">\n' +
                    '</a>\n' +
                    '</td>\n' +
                    '<td>' + jmldata + '</td>\n' +
                    '<td>\n' +
                    '<textarea placeholder="Kegiatan Tugas Pokok Jabatan" id="' + tetap + 'pokok[' + jmldatatambah + ']" class="form-control" name="' + tetap + 'pokok[' + jmldatatambah + ']"></textarea>\n' +
                    '</td>\n' +
                    '<td>\n' +
                    '<input type="text" size="2" class="form-control" onkeypress="return decimalonly(event)" value="0" placeholder="AK" id="' + tetap + 'ak[' + jmldatatambah + ']" name="' + tetap + 'ak[' + jmldatatambah + ']" />\n' +
                    '</td>\n' +
                    '<td>\n' +
                    '<input type="text" class="form-control" size="5" onkeypress="return decimalonly(event)" placeholder="Kuantitas" id="' + tetap + 'kuantitas[' + jmldatatambah + ']" name="' + tetap + 'kuantitas[' + jmldatatambah + ']" />\n' +
                    '<select class="utama_satuan_' + jmldatatambah + ' form-control" id="' + tetap + 'satuan[' + jmldatatambah + ']" name="' + tetap + 'satuan[' + jmldatatambah + ']"></select>\n' +
                    '</td>\n' +
                    '<td>\n' +
                    '<input type="text" class="form-control" onkeypress="return decimalonly(event)" size="5" value="0" placeholder="Kualitas" id="' + tetap + 'kualitas[' + jmldatatambah + ']" name="' + tetap + 'kualitas[' + jmldatatambah + ']" />\n' +
                    '</td>\n' +
                    '<td>\n' +
                    '<select class="utama_waktu_' + jmldatatambah + ' form-control" id="' + tetap + 'waktu[' + jmldatatambah + ']" name="' + tetap + 'waktu[' + jmldatatambah + ']"></select>\n' +
                    '</td>\n' +
                    '<td>\n' +
                    '<input onkeypress="return decimalonly(event)" type="text" class="form-control" size="5" value="0" placeholder="Biaya" id="' + tetap + 'biaya[' + jmldatatambah + ']" name="' + tetap + 'biaya[' + jmldatatambah + ']" />\n' +
                    '</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '</tr>').insertBefore('#acuan_' + tetap);
            var copyacuansatuan = $("#acuan_satuan").clone().html();
            $(copyacuansatuan).appendTo("select.utama_satuan_" + jmldatatambah);
            var copyacuanwaktu = $(".utama_waktu_0").clone().html();
            $(copyacuanwaktu).appendTo("select.utama_waktu_" + jmldatatambah);
        } else {
            $('<tr class="center">\n' +
                    '<td>\n' +
                    '<a href="javascript:void(0)" class="' + tetap + '" name="tambah data" title="tambah data" id="hapus_data_detail">\n' +
                    '<img border="0" src="' + gambar_hapus + '">\n' +
                    '</a>\n' +
                    '</td>\n' +
                    '<td>' + jmldata + '</td>\n' +
                    '<td>\n' +
                    '<textarea placeholder="Kegiatan Tugas Pokok Jabatan" class="form-control" id="' + tetap + 'pokok[' + jmldatatambah + ']" name="' + tetap + 'pokok[' + jmldatatambah + ']"></textarea>\n' +
                    '</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '<td>&nbsp;</td>\n' +
                    '</tr>').insertBefore('#acuan_' + tetap);
        }
        return false;
    });
    
    $("body").on('click', "a.popuppilihpegawaiak", function () {
        $("input#field_cr_nip_pejabat_penilai").val($(this).attr('data-nip'));
        $("p#nama_pejabat_penilai").text($(this).attr('data-nama'));
        $("p#pangkatgol_pejabat_penilai").text($(this).attr('data-pangkatgol'));
        $("input[name='pangkatgol_pejabat_penilai_input']").val($(this).attr('data-pangkatgol'));
        $("p#jabatan_pejabat_penilai").text($(this).attr('data-njabatan'));
        $("input[name='jabatan_pejabat_penilai_input']").val($(this).attr('data-njabatan'));
        $("#large").modal('hide');
    });
    $("body").on('click', "a.popuppilihpegawai", function () {
        $("input#field_cr_nip_atasan_pejabat_penilai").val($(this).attr('data-nip'));
        $("p#nama_atasan_pejabat_penilai").text($(this).attr('data-nama'));
        $("p#pangkatgol_atasan_pejabat_penilai").text($(this).attr('data-pangkatgol'));
        $("input[name='pangkatgol_atasan_pejabat_penilai_input']").val($(this).attr('data-pangkatgol'));
        $("p#jabatan_atasan_pejabat_penilai").text($(this).attr('data-njabatan'));
        $("input[name='jabatan_atasan_pejabat_penilai_input']").val($(this).attr('data-njabatan'));
        $("#large").modal('hide');
    });
</script>