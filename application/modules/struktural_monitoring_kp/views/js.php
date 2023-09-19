<script type="text/javascript">
    $("select#jenis_pangkat").select2();
    $("select#gol_pangkat").select2();
    $("select#eselon_id").select2();
    $("select#bulan").select2();
    $("select#tahun").select2();
    $('body').on('submit', "form#formpencarian", function (e) {
        open_loading();
        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data:{trlokasi_id:$("select#search_trlokasi_id").val(),kdu1_id:$("select#search_kdu1").val(),
            kdu2_id:$("select#search_kdu2").val(),kdu3_id:$("select#search_kdu3").val(),kdu4_id:$("select#search_kdu4").val(),
            kdu5_id:$("select#search_kdu5").val(),jenis_pangkat:$("select#jenis_pangkat").val(),gol_pangkat:$("select#gol_pangkat").val(),
            eselon_id:$("select#eselon_id").val(),bulan:$("select#bulan").val(),tahun:$("select#tahun").val()},
            dataType: "html",
            cache: false
        }).done(function (result) {
            $('div.hasilfilter').empty();
            $('div.hasilfilter').html(result);
            $('div.hasilfilter').show();
            $("html, body").animate({scrollTop: $('div.hasilfilter').offset().top}, 100);
            close_loading();
        }).fail(function () {
            close_loading();
            toastr.error("Maaf, Gagal menampilkan halaman");
        });
        return false;
    });
    $('body').on('click', "a.btnexport", function (e) {
        window.open($(this).attr('data-url')+'?trlokasi_id='+$("select#search_trlokasi_id").val()+'&kdu1_id='+$("select#search_kdu1").val()+'&kdu2_id='+$("select#search_kdu2").val()+'&kdu3_id='+$("select#search_kdu3").val()+'&kdu4_id='+$("select#search_kdu4").val()+'&kdu5_id='+$("select#search_kdu5").val()+'&jenis_pangkat='+$("select#jenis_pangkat").val()+
        '&gol_pangkat='+$("select#gol_pangkat").val()+'&eselon_id='+$("select#eselon_id").val()+'&bulan='+$("select#bulan").val()+'&tahun='+$("select#tahun").val());
        return false;
    });
</script>