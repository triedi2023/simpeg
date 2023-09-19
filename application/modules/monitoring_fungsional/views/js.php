<script type="text/javascript">
    $("select#kelompok_jabatan").select2();
    $("select#status").select2();
    $('body').on('submit', "form#formpencarian", function (e) {
        open_loading();
        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data:{trlokasi_id:$("select#search_trlokasi_id").val(),kdu1_id:$("select#search_kdu1").val(),
            kdu2_id:$("select#search_kdu2").val(),kdu3_id:$("select#search_kdu3").val(),kdu4_id:$("select#search_kdu4").val(),
            kdu5_id:$("select#search_kdu5").val(),kelompok_jabatan:$("select#kelompok_jabatan").val(),status:$("select#status").val()},
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
        '&kelompok_jabatan='+$("select#kelompok_jabatan").val()+'&status='+$("select#status").val());
        return false;
    });
</script>