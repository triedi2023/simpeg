<script type="text/javascript">
    $("select#jenis_keluaran").select2();
    $('body').on('submit', "form#formpencarian", function (e) {
        open_loading();
        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
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
        window.open($(this).attr('data-url'));
        return false;
    });
    $('body').on('click', '.popuplarge', function (e) {
        open_loading();
        
        var urlnya = $(this).attr('data-url');
        var getcpns = 'tidak';
        if (typeof($(this).attr('data-cpns')) != "undefined") {
            getcpns = $(this).attr('data-cpns');
        }
        var datanyanih = {golongan: $(this).attr('data-gol'), lokasi_id: $(this).attr('data-lok'), kdu1_id: $(this).attr('data-kdu1'), kdu2_id: $(this).attr('data-kdu2'), kdu3_id: $(this).attr('data-kdu3'), kdu4_id: $(this).attr('data-kdu4'), kdu5_id: $(this).attr('data-kdu5'), cpns: getcpns};

        $.ajax({
            type: "POST",
            url: urlnya,
            data: datanyanih,
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
</script>