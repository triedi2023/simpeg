<script type="text/javascript">
    $("select#tingkat_golongan").select2();
    $('body').on('submit', "form#formpencarian", function (e) {
        open_loading();
        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data: {nip: $("input#nip").val()},
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
    
    $('body').on('click', "a.btnexportdrh", function (e) {
        window.open($(this).attr('data-url') + '?nip=' + $(this).attr('data-id'));
        return false;
    });
    
    $('body').on('click', '.popuplarge', function (e) {
        open_loading();

        var urlnya = $(this).attr('data-url');
        var setelement = $(this).attr('data-id');

        $.ajax({
            type: "POST",
            url: urlnya,
            data: {setelementnya: setelement},
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
    
    $('body').on('click', 'a.btnpopupsearch', function (e) {
        if ($("div#divsearchpopup").is(":visible")) {
            $("div#divsearchpopup").attr('style', 'display:none');
        } else {
            $("div#divsearchpopup").attr('style', '');
        }
    });
    
    $('body').on('click', 'a.popuppilihpegawai', function (e) {
        $("input[name='nip']").val($(this).attr("data-nip"));
        $("div#tampungnama").html($(this).attr("data-nama"));
        $("div#tampungnama").show();
        $("#large").modal('hide');
    });
</script>