<script type="text/javascript">
    $("select#sex").select2();
    $("select#bulan_cpns").select2();
    $("select#bulan_pns").select2();
    $("select#fak").select2();
    $("select#kode_diklat_teknis").select2();
    $("select#prov_unit_kerja").select2();
    $("select#jabatan").select2();
    $("select#kelfung_serbaguna").select2();
    $("select#xhr_prop_lahir").select2();
    $("select#receiver_kablahir").select2();
    $("select#nama_diklat_teknis").select2();
    $("select#tktpdk").select2();
    $("input#tmt_eselon").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#tmt_gol").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#tmt_jabatan").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#tgl_lahir").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#range_tgl_lahir_1").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#range_tgl_lahir_2").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $('#select1').multiSelect();
    var checkBoxArray = function (input_checkbox) {
        cbArray = [];
        var data;
        jQuery.each(jQuery(input_checkbox), function (idx, val) {
            cbArray.push(val.value);
        });

        return cbArray;
    }
    $('body').on('submit', "form#formpencarian", function (e) {
        open_loading();

        var params = {};
        params.judul = jQuery('input#judul').val();
        params.awal_data = jQuery('input#awal_data').val();
        params.halaman = jQuery('input#halaman').val();

        var whrClause = {};
        whrClause.nama = jQuery('input#nama').val();
        whrClause.nip = jQuery('input#nip').val();
        whrClause.sex = jQuery('select#sex').val();
        whrClause.gol_darah = checkBoxArray('input[name=gol_darah]:checked');
        whrClause.cpns = {bln: jQuery('select#bulan_cpns').val(), thn: jQuery('input#tahun_cpns').val(), sk_cpns: jQuery('input#skcpns').val()};
        whrClause.pns = {bln: jQuery('select#bulan_pns').val(), thn: jQuery('input#tahun_pns').val(), sk_pns: jQuery('input#skpns').val()};
        whrClause.pend = {tktpdk: checkBoxArray('input[name=pend_terakhir]:checked'),
            lbgpdk: jQuery('input#nm_pendk').val(),
            fakpdk: jQuery('select#fak').val(),
            jurpdk: jQuery('input#jurpdk').val(),
            thnpdk: jQuery('input#thn_pend_akhir').val()
        };
        whrClause.eselon = {eselon: checkBoxArray('input[name=eselon]:checked'), tmtesel: jQuery('input#tmt_eselon').val()};
        whrClause.gol = {polri: checkBoxArray('input[name=pgkt_polri]:checked'), pns: checkBoxArray('input[name=pgkt_pns]:checked'), tmtgol: jQuery('input#tmt_gol').val()};
        whrClause.pim = {namapim: checkBoxArray('input[name=dik_pim_akhir]:checked'), thnpim: jQuery('input#thn_diklat_pim').val()};
        whrClause.diklatteknis = {keldiknis: jQuery('select#kode_diklat_teknis').val(), sekdiknis: jQuery('select#kode_sektor_teknis').val(), namadiknis: jQuery('select#nama_diklat_teknis').val(), ketdiklatteknis: $("input#ket_diklat_teknis").val()};
        whrClause.nama_diklat_lain = jQuery('input#diklatlainlain').val();
        whrClause.kerja = {jabat: jQuery('select#jabatan').val(), propunit: jQuery('select#prov_unit_kerja').val(), kelfgs: jQuery('select#kelfung_serbaguna').val(), tmtjab: jQuery('input#tmt_jabatan').val()};
        whrClause.sts_kawin = checkBoxArray('input[name=sts_nikah]:checked');
        whrClause.agama = checkBoxArray('input[name=agama]:checked');
        whrClause.tgllahir = jQuery('input#tgl_lahir').val();
        whrClause.range_tgllahir_1 = jQuery('input#range_tgl_lahir_1').val();
        whrClause.range_tgllahir_2 = jQuery('input#range_tgl_lahir_2').val();
        whrClause.usia1 = jQuery('input#usia1').val();
        whrClause.usia2 = jQuery('input#usia2').val();
        whrClause.propinsi = jQuery('select#xhr_prop_lahir').val();
        whrClause.kablahir = jQuery('select#receiver_kablahir').val();
//        whrClause.tktpdk = jQuery('select#tktpdk').val();

        whrClause.kodepos = jQuery('input#pos').val();

        whrClause.hobi = jQuery('input#hobi').val();
        whrClause.telp_hp = jQuery('input#tlp').val();
        whrClause.warna_kulit = jQuery('input#warna_kulit').val();
        whrClause.karpeg = jQuery('input#no_karpeg').val();
        whrClause.askes = jQuery('input#no_askes').val();
        whrClause.taspen = jQuery('input#no_taspen').val();
        whrClause.karis = jQuery('input#no_korpri').val();
        whrClause.no_ktp = jQuery('input#no_ktp').val();

        whrClause.lok = jQuery('select#search_trlokasi_id').val();
        whrClause.kdu1 = jQuery('select#search_kdu1').val();
        whrClause.kdu2 = jQuery('select#search_kdu2').val();
        whrClause.kdu3 = jQuery('select#search_kdu3').val();
        whrClause.kdu4 = jQuery('select#search_kdu4').val();
        whrClause.kdu5 = jQuery('select#search_kdu5').val();
        var riwayatpdk = jQuery('select#tktpdk').val();
        if (riwayatpdk != null && riwayatpdk != "") {
//            if (tktpdk == '11' || tktpdk == '12' || tktpdk == '13') {
                whrClause.rwytpdk = {tktpdk: riwayatpdk};
//                whrClause.rwytpdk = {tktpdk: tktpdk, nama_lbgpdk: jQuery('input#nama_lbgpdk').val()};
//            } else {
//                whrClause.rwytpdk = {tktpdk: tktpdk, nama_lbgpdk: jQuery('input#nama_lbgpdk').val(), fakpdk: jQuery('select#fakpdk').val(), jurpdk: jQuery('input#nama_jurpdk').val()};
//            }
        } else {
            whrClause.rwytpdk = null;
        }

        params.whereColumn = whrClause;
        params.selectColumn = jQuery('#select1').val();
        document.cookie = "params=" + JSON.parse(JSON.stringify(params));

        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data: {params: JSON.parse(JSON.stringify(params))},
            cache: false
        }).done(function (result) {
            $('div.hasilfilter').empty();
            $('div.hasilfilter').html(result);
            $('div.hasilfilter').show();
            $("html, body").animate({scrollTop: $('div#parameterpencarian').offset().top}, 100);
            $("div#parameterpencarian").hide();
            close_loading();
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal menampilkan halaman");
        });
        return false;
    });

    $('body').on('click', '.btnkembali', function (e) {
        $('div.hasilfilter').empty();
        $('div.hasilfilter').hide();
        $("div#parameterpencarian").show();
        $("html, body").animate({scrollTop: $('div#parameterpencarian').offset().top}, 100);
    });
    $('body').on('click', 'a.btnpopupsearch', function (e) {
        if ($("div#divsearchpopup").is(":visible")) {
            $("div#divsearchpopup").attr('style', 'display:none');
        } else {
            $("div#divsearchpopup").attr('style', '');
        }
    });
    $('body').on('submit', 'form#popupformpencarianuniversitas', function (e) {
        $popuplistuniversitas.ajax.reload();
        return false;
    });
    $("body").on('click', 'a.popuppilihuniversitas', function () {
        $("input#nm_pendk").val($(this).attr('data-nama'));
        $("input#lbg_pendk").val($(this).attr('data-id'));
        $("#large").modal('hide');
    });
    $('body').on('submit', 'form#popupformpencarianjurusan', function (e) {
        $popuplistjurusan.ajax.reload();
        return false;
    });
    $("body").on('click', 'a.popuppilihjurusan', function () {
        $("input#nama_jurpdk").val($(this).attr('data-nama'));
        $("input#jurpdk").val($(this).attr('data-id'));
        $("#large").modal('hide');
    });
    $('body').on('click', '.popuplarge', function (e) {
        open_loading();

        var urlnya = $(this).attr('data-url');

        $.ajax({
            type: "POST",
            url: urlnya,
            dataType: "html",
            cache: false
        }).done(function (result) {
            $('div#modal-content-large').html(result);
        }).fail(function () {
            toastr.error("Maaf, Gagal menampilkan halaman");
        });

        $("#large").modal('show');
        close_loading();
        return false;
    });
    $("body").on('change', "select#xhr_prop_lahir", function () {
        var pilihan = $(this).val();
        if (pilihan == "") {
            $("select#receiver_kablahir").empty();
            $("select#receiver_kablahir").select2({data: [{'id': '', 'text': '- Pilih Kabupaten Lahir -'}]}).trigger('change');
            return false;
        }
        $.ajax({
            type: "GET",
            url: '<?php echo site_url("referensi/getkabupaten") ?>',
            data: {id: pilihan},
            dataType: "json"
        }).done(function (response) {
            $("select#receiver_kablahir").empty();
            $("select#receiver_kablahir").select2({data: response.data}).trigger('change');
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal memanggil data kabupaten lahir");
        });
        return false;
    });
    
    $('body').on('click', "a.btnexport", function (e) {
        open_loading();

        var params = {};
        params.judul = jQuery('input#judul').val();
        params.awal_data = jQuery('input#awal_data').val();
        params.halaman = jQuery('input#halaman').val();

        var whrClause = {};
        whrClause.nama = jQuery('input#nama').val();
        whrClause.nip = jQuery('input#nip').val();
        whrClause.sex = jQuery('select#sex').val();
        whrClause.gol_darah = checkBoxArray('input[name=gol_darah]:checked');
        whrClause.cpns = {bln: jQuery('select#bulan_cpns').val(), thn: jQuery('input#tahun_cpns').val(), sk_cpns: jQuery('input#skcpns').val()};
        whrClause.pns = {bln: jQuery('select#bulan_pns').val(), thn: jQuery('input#tahun_pns').val(), sk_pns: jQuery('input#skpns').val()};
        whrClause.pend = {tktpdk: checkBoxArray('input[name=pend_terakhir]:checked'),
            lbgpdk: jQuery('input#nm_pendk').val(),
            fakpdk: jQuery('select#fak').val(),
            jurpdk: jQuery('input#jurpdk').val(),
            thnpdk: jQuery('input#thn_pend_akhir').val()
        };
        whrClause.eselon = {eselon: checkBoxArray('input[name=eselon]:checked'), tmtesel: jQuery('input#tmt_eselon').val()};
        whrClause.gol = {polri: checkBoxArray('input[name=pgkt_polri]:checked'), pns: checkBoxArray('input[name=pgkt_pns]:checked'), tmtgol: jQuery('input#tmt_gol').val()};
        whrClause.pim = {namapim: checkBoxArray('input[name=dik_pim_akhir]:checked'), thnpim: jQuery('input#thn_diklat_pim').val()};
        whrClause.diklatteknis = {keldiknis: jQuery('select#kode_diklat_teknis').val(), sekdiknis: jQuery('select#kode_sektor_teknis').val(), namadiknis: jQuery('select#nama_diklat_teknis').val()};
        whrClause.nama_diklat_lain = jQuery('input#diklatlainlain').val();
        whrClause.kerja = {jabat: jQuery('select#jabatan').val(), propunit: jQuery('select#prov_unit_kerja').val(), kelfgs: jQuery('select#kelfung_serbaguna').val(), tmtjab: jQuery('input#tmt_jabatan').val()};
        whrClause.sts_kawin = checkBoxArray('input[name=sts_nikah]:checked');
        whrClause.agama = checkBoxArray('input[name=agama]:checked');
        whrClause.tgllahir = jQuery('input#tgl_lahir').val();
        whrClause.range_tgllahir_1 = jQuery('input#range_tgl_lahir_1').val();
        whrClause.range_tgllahir_2 = jQuery('input#range_tgl_lahir_2').val();
        whrClause.usia1 = jQuery('input#usia1').val();
        whrClause.usia2 = jQuery('input#usia2').val();
        whrClause.propinsi = jQuery('select#xhr_prop_lahir').val();
        whrClause.kablahir = jQuery('select#receiver_kablahir').val();
//        whrClause.tktpdk = jQuery('select#tktpdk').val();

        whrClause.kodepos = jQuery('input#pos').val();

        whrClause.hobi = jQuery('input#hobi').val();
        whrClause.telp_hp = jQuery('input#tlp').val();
        whrClause.warna_kulit = jQuery('input#warna_kulit').val();
        whrClause.karpeg = jQuery('input#no_karpeg').val();
        whrClause.askes = jQuery('input#no_askes').val();
        whrClause.taspen = jQuery('input#no_taspen').val();
        whrClause.karis = jQuery('input#no_korpri').val();
        whrClause.no_ktp = jQuery('input#no_ktp').val();

        whrClause.lok = jQuery('select#search_trlokasi_id').val();
        whrClause.kdu1 = jQuery('select#search_kdu1').val();
        whrClause.kdu2 = jQuery('select#search_kdu2').val();
        whrClause.kdu3 = jQuery('select#search_kdu3').val();
        whrClause.kdu4 = jQuery('select#search_kdu4').val();
        whrClause.kdu5 = jQuery('select#search_kdu5').val();
        var tktpdk = jQuery('select#tktpdk').val();
        if (tktpdk != null && tktpdk != "") {
            if (tktpdk == '11' || tktpdk == '12' || tktpdk == '13') {
                whrClause.rwytpdk = {tktpdk: tktpdk, nama_lbgpdk: jQuery('input#nama_lbgpdk').val()};
            } else {
                whrClause.rwytpdk = {tktpdk: tktpdk, nama_lbgpdk: jQuery('input#nama_lbgpdk').val(), fakpdk: jQuery('select#fakpdk').val(), jurpdk: jQuery('input#nama_jurpdk').val()};
            }
        } else {
            whrClause.rwytpdk = null;
        }

        params.whereColumn = whrClause;
        params.selectColumn = jQuery('#select1').val();
        document.cookie = "params=" + JSON.parse(JSON.stringify(params));

        window.open($(this).attr('data-url')+'?params='+JSON.stringify(params));
        close_loading();
    });
</script>