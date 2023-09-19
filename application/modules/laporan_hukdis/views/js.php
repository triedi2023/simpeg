<script type="text/javascript">
    $("select#tingkat_hukdis").select2();
    $('body').on('submit', "form#formpencarian", function (e) {
        open_loading();
        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data:{tingkat_hukdis:$("select#tingkat_hukdis").val(),bentuk_laporan:$(".make-switch").bootstrapSwitch('state')},
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
        window.open($(this).attr('data-url')+'?tingkat_hukdis='+$("select#tingkat_hukdis").val()+'&bentuk_laporan='+$(".make-switch").bootstrapSwitch('state'));
        return false;
    });
</script>