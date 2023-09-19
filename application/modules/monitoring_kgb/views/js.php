<script type="text/javascript">
    $("select#gol_pangkat").select2();
    $("select#eselon_id").select2();
    $("select#bulan1").select2();
    $("select#tahun1").select2();
    $("select#bulan2").select2();
    $("select#tahun2").select2();
    $('body').on('submit', "form#formpencarian", function (e) {
        open_loading();
        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data:{trlokasi_id:$("select#search_trlokasi_id").val(),kdu1_id:$("select#search_kdu1").val(),
            kdu2_id:$("select#search_kdu2").val(),kdu3_id:$("select#search_kdu3").val(),kdu4_id:$("select#search_kdu4").val(),
            kdu5_id:$("select#search_kdu5").val(),gol_pangkat:$("select#gol_pangkat").val(),eselon_id:$("select#eselon_id").val(),
            bulan1:$("select#bulan1").val(),tahun1:$("select#tahun1").val(),bulan2:$("select#bulan2").val(),tahun2:$("select#tahun2").val()},
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
        window.open($(this).attr('data-url')+'?trlokasi_id='+$("select#search_trlokasi_id").val()+'&kdu1_id='+$("select#search_kdu1").val()+'&kdu2_id='+$("select#search_kdu2").val()+'&kdu3_id='+$("select#search_kdu3").val()+'&kdu4_id='+$("select#search_kdu4").val()+'&kdu5_id='+$("select#search_kdu5").val()+
        '&gol_pangkat='+$("select#gol_pangkat").val()+'&eselon_id='+$("select#eselon_id").val()+'&bulan1='+$("select#bulan1").val()+'&tahun1='+$("select#tahun1").val()+'&bulan2='+$("select#bulan2").val()+'&tahun2='+$("select#tahun2").val());
        return false;
    });
</script>