<script type="text/javascript">
    $("select#field_trlokasi_id").select2({data: <?php echo $list_lokasi ?>});
    $("select#field_kdu1").select2();
    $("select#field_kdu2").select2();
    $("select#field_kdu3").select2();
    $("select#field_kdu4").select2();
    $("select#field_kdu5").select2();
</script>
<script type="text/javascript">
    $("body").on('change', 'select#field_trlokasi_id', function () {
        if ($(this).val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu1") ?>',
                data: {lokasi_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#field_kdu1").empty();
                $("select#field_kdu1").select2({data: response.data});
                $("select#field_kdu2").empty();
                $("select#field_kdu2").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Pratama -'}]});
                $("select#field_kdu3").empty();
                $("select#field_kdu3").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
                $("select#field_kdu4").empty();
                $("select#field_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select#field_kdu5").empty();
                $("select#field_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Pimpinan Tinggi Madya");
            });
        } else {
            $("select#field_kdu1").empty();
            $("select#field_kdu1").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Madya -'}]});
            $("select#field_kdu2").empty();
            $("select#field_kdu2").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Pimpinan Tinggi Pratama -'}]});
            $("select#field_kdu3").empty();
            $("select#field_kdu3").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
            $("select#field_kdu4").empty();
            $("select#field_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
            $("select#field_kdu5").empty();
            $("select#field_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
        }
        return false;
    });
    $("body").on('change', 'select#field_kdu1', function () {
        if ($(this).val() != "" && $("select#field_trlokasi_id").val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu2") ?>',
                data: {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#field_kdu2").empty();
                $("select#field_kdu2").select2({data: response.data});
                $("select#field_kdu3").empty();
                $("select#field_kdu3").select2({data: [{'id': '-1', 'text': '- Pilih Jabatan Administrator -'}]});
                $("select#field_kdu4").empty();
                $("select#field_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select#field_kdu5").empty();
                $("select#field_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Pimpinan Tinggi Pratama");
            });

            var kiriman = {lok: $("select#field_trlokasi_id").val(),kdu1: $("select#field_kdu1").val()};
            view(kiriman, "<?php echo site_url("peta_jabatan/view_master") ?>");
        }
        return false;
    });

    $("body").on('change', 'select#field_kdu2', function () {
        if ($(this).val() != "" && $("select#field_trlokasi_id").val() != "" && $("select#field_kdu1").val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu3") ?>',
                data: {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#field_kdu3").empty();
                $("select#field_kdu3").select2({data: response.data});
                $("select#field_kdu4").empty();
                $("select#field_kdu4").select2({data: [{'id': '-1', 'text': '- Pilih Pengawas -'}]});
                $("select#field_kdu5").empty();
                $("select#field_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                close_loading();
                toastr.error("Maaf, Gagal memanggil data Unit Jabatan Administrator");
            });

            var kiriman = {lok: $("select#field_trlokasi_id").val(),kdu1: $("select#field_kdu1").val(),kdu2: $(this).val()};
            view(kiriman, "<?php echo site_url("peta_jabatan/view_master") ?>");
        }

        return false;
    });
    $("body").on('change', 'select#field_kdu3', function () {
        if ($(this).val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu4") ?>',
                data: {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $("select#field_kdu2").val(), kdu3_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#field_kdu4").empty();
                $("select#field_kdu4").select2({data: response.data});
                $("select#field_kdu5").empty();
                $("select#field_kdu5").select2({data: [{'id': '-1', 'text': '- Pilih Pelaksana (Eselon V) -'}]});
            }).fail(function () {
                toastr.error("Maaf, Gagal memanggil data Unit Pengawas");
            });
            
            var kiriman = {lok: $("select#field_trlokasi_id").val(),kdu1: $("select#field_kdu1").val(),kdu2: $("select#field_kdu2").val(),kdu3: $(this).val()};
            view(kiriman, "<?php echo site_url("peta_jabatan/view_master") ?>");
        }

        return false;
    });
    $("body").on('change', 'select#field_kdu4', function () {
        if ($(this).val() != "") {
            $.ajax({
                type: "GET",
                url: '<?php echo site_url("referensi/getstrukturkdu5") ?>',
                data: {lokasi_id: $("select#field_trlokasi_id").val(), kdu1_id: $("select#field_kdu1").val(), kdu2_id: $("select#field_kdu2").val(), kdu3_id: $("select#field_kdu3").val(), kdu4_id: $(this).val()},
                dataType: "json"
            }).done(function (response) {
                $("select#field_kdu5").empty();
                $("select#field_kdu5").select2({data: response.data});
            }).fail(function () {
                toastr.error("Maaf, Gagal memanggil data Unit Pelaksana (Eselon V)");
            });
            
            var kiriman = {lok: $("select#field_trlokasi_id").val(),kdu1: $("select#field_kdu1").val(),kdu2: $("select#field_kdu2").val(),kdu3:$("select#field_kdu3").val(),kdu4: $(this).val()};
            view(kiriman, "<?php echo site_url("peta_jabatan/view_master") ?>");
        }
        return false;
    });

    $("body").on('change', 'select#field_kdu5', function () {
        if ($(this).val() != "") {
            var kiriman = {lok: $("select#field_trlokasi_id").val(),kdu1: $("select#field_kdu1").val(),kdu2: $("select#field_kdu2").val(),kdu3:$("select#field_kdu3").val(),kdu4: $("select#field_kdu4").val(),kdu5: $(this).val()};
            view(kiriman, '<?php echo site_url("peta_jabatan/view_detail") ?>');
        }
        return false;
    });

    function view(str, urlnya) {
        open_loading();
        $.post(urlnya, str, function (data) {
            $("#tampungstruktur").contents().find("body").html(data);
            $("#tampungstruktur").contents().find('.view-detail,.view-back').on("click", function (e) {
                var get_id = $(this).attr('data-id');
                var get_url = $(this).attr('data-url');
                view({uid:get_id},get_url);
            });
            close_loading();
        }, 'html');
        return false;
//        open_loading();
//        if (window.XMLHttpRequest)
//        {// code for IE7+, Firefox, Chrome, Opera, Safari
//            xmlhttp = new XMLHttpRequest();
//        } else
//        {// code for IE6, IE5
//            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//        }
//
//        terms = str;
////        xmlhttp.onreadystatechange = function ()
////        {
////            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
////            {
////                document.getElementById('tampungstruktur').innerHTML = "";
////                jQuery.noConflict();
////                (function ($) {
////                    $('#upload_target').append(xmlhttp.responseText);
////                })(jQuery);
////            }
////        }
//
//        alert(document.getElementById('tampungstruktur').innerHTML);
//        xmlhttp.open("POST", urlnya, true);
//        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
//        xmlhttp.onreadystatechange = function () {
//            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
////                document.getElementById('tampungstruktur').contentWindow.document.body.innerHTML = xmlhttp.responseText;
////                jQuery.noConflict();
//                document.getElementById('tampungstruktur').innerHTML = "";
//                jQuery.noConflict();
//                (function ($) {
//                    alert(xmlhttp.responseText);
//                    $('#tampungstruktur').append(xmlhttp.responseText);
////                    alert(xmlhttp.responseText);
//                })(jQuery);
//            }
//        }
//        xmlhttp.send(terms);
//        close_loading();
//        return false;
    }

//    var myFrame = document.getElementById('tampungstruktur');
//    myFrame.contentWindow.foo = function () {
//        alert("Look at me, executed inside an iframe!");
//    }

//    frames['tampungstruktur'].haha();
//    var aa = document.getElementById('tampungstruktur');
//    aa.contentWindow.defaultView.myFunction();
//.//    window.frames['tampungstruktur'].haha;

//    document.getElementById("tampungstruktur").contentWindow.haha();
//    document.all.tampungstruktur.haha();
//    document.all.frames.tampungstruktur.haha();
//    document.all.tampungstruktur.contentWindow.haha();        
//    if (typeof (window.frames[0].haha()) === "function") {
//        alert('sdgasg');
//    } else {
//        alert("resultFrame.haha NOT found");
//    }
//    iframe.contentDocument.myFunction();
//    document.getElementById("tampungstruktur").contentWindow.haha();
</script>