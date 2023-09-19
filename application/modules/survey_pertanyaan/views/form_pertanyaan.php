<div class="col-md-12">
    <div class="portlet box yellow-gold">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Form <?= $title_form; ?> Pertanyaan
            </div>
            <div class="tools">&nbsp;</div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <?php echo form_open("://", ["class" => "formcreateupdate horizontal-form", 'data-url' => site_url('survey_pertanyaan/ubah_proses?id=' . $id)]); ?>
            <div class="form-body">

                <?php if (isset($pertanyaan)): ?>
                    <?php $p=1; foreach ($pertanyaan as $tanya): ?>
                        <div class="row data_number" data-number="<?php echo $p ?>">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="control-label">Pertanyaan <span class="required" aria-required="true"> * </span></label>
                                            <input type="text" name="pertanyaan[<?php echo $p ?>]" id="field_cr_pertanyaan" class="form-control" value="<?php echo $tanya['PERTANYAAN']; ?>" placeholder="Pertanyaan" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Tipe Jawaban <span class="required" aria-required="true"> * </span></label>
                                            <select name="tipe_jawaban[<?php echo $p ?>]" class="form-control">
                                                <option value="">- Pilih -</option>
                                                <option value="1" <?php echo ($tanya['TIPE_JAWABAN'] == 1) ? 'selected=""' : '' ?>>Pilihan</option>
                                                <option value="2" <?php echo ($tanya['TIPE_JAWABAN'] == 2) ? 'selected=""' : '' ?>>Isian</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <div class="form-group">
                                            <label class="control-label">Aksi</label><br />
                                            <a href="javascript:;" data-url="<?php echo site_url(); ?>" class="btnhapuspertanyaan btn btn-icon-only red form-control"><i class="fa fa-minus-circle"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($jawaban && $tanya['TIPE_JAWABAN'] == 1): ?>
                                    <?php $k=1; foreach ($jawaban[$tanya['ID']] as $wab): ?>
                                        <div class="row">
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label class="control-label">Jawaban <span class="required" aria-required="true"> * </span></label>
                                                    <input type="text" name="jawaban[<?php echo $p ?>][]" id="field_cr_jawaban" class="form-control" value="<?php echo $wab['JAWABAN'] ?>" placeholder="Jawaban">
                                                </div>
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <div class="form-group">
                                                    <label class="control-label">Tindakan</label><br>
                                                    <a href="javascript:;" class="<?php echo $k==1 ? 'btntambahjawaban' : 'btnhapusjawaban' ?> btn btn-circle btn-icon-only <?php echo $k==1 ? 'bg-blue-dark bg-font-blue-dark' : 'bg-red-soft bg-font-red-soft' ?> form-control"><i class="fa fa-<?php echo $k==1 ? 'plus' : 'minus' ?>-circle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php $k++;endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php $p++;endforeach; ?>
                <?php endif; ?>

                <div class="row data_number" data-number="<?php echo $p; ?>">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Pertanyaan <span class="required" aria-required="true"> * </span></label>
                                    <input type="text" name="pertanyaan[<?php echo $p ?>]" id="field_cr_pertanyaan" class="form-control" value="" placeholder="Pertanyaan" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Tipe Jawaban <span class="required" aria-required="true"> * </span></label>
                                    <select name="tipe_jawaban[0]" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <option value="1">Pilihan</option>
                                        <option value="2">Isian</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 text-center">
                                <div class="form-group">
                                    <label class="control-label">Aksi</label><br />
                                    <a href="javascript:;" data-url="<?php echo site_url(); ?>" class="btntambahpertanyaan btn btn-icon-only blue form-control"><i class="fa fa-plus-circle"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/row-->
            </div>
            <div class="form-actions">
                <div class="pull-left">
                    <button type="button" class="btn default btnbatalformcu"><i class="fa fa-close"></i> Batal</button>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-warning btn-circle"><i class="fa fa-check"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
            <!-- END FORM-->
        </div>
    </div>
</div>
<script type="text/javascript">
    $('body').on('click', 'a.btntambahpertanyaan', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idenumber = 0;
        $('div.data_number').each(function () {
            var value = parseFloat($(this).attr('data-number'));
            idenumber = (value > idenumber) ? value : idenumber;
        });
        var inputhtml = '<div class="row data_number" data-number="' + (idenumber + 1) + '">\n';
        inputhtml += '<div class="col-md-12">';
        inputhtml += '<div class="row">';
        inputhtml += '<div class="col-md-9">';
        inputhtml += '<div class="form-group">';
        inputhtml += '<label class="control-label">Pertanyaan <span class="required" aria-required="true"> * </span></label>';
        inputhtml += '<input type="text" name="pertanyaan[' + (idenumber + 1) + ']" id="field_cr_pertanyaan" class="form-control" value="" placeholder="Pertanyaan" />';
        inputhtml += '</div>';
        inputhtml += '</div>';
        inputhtml += '<div class="col-md-2">';
        inputhtml += '<div class="form-group">';
        inputhtml += '<label class="control-label">Tipe Jawaban <span class="required" aria-required="true"> * </span></label>';
        inputhtml += '<select name="tipe_jawaban[' + (idenumber + 1) + ']" class="form-control">';
        inputhtml += '<option value="">- Pilih -</option>';
        inputhtml += '<option value="1">Pilihan</option>';
        inputhtml += '<option value="2">Isian</option>';
        inputhtml += '</select>';
        inputhtml += '</div>';
        inputhtml += '</div>';
        inputhtml += '<div class="col-md-1 text-center">';
        inputhtml += '<div class="form-group">';
        inputhtml += '<label class="control-label">Aksi</label><br />';
        inputhtml += '<a href="javascript:;" class="btnhapuspertanyaan btn btn-icon-only red form-control"><i class="fa fa-minus-circle"></i></a>';
        inputhtml += '</div>';
        inputhtml += '</div>';
        inputhtml += '</div>';
        inputhtml += '</div>';
        inputhtml += '</div>';
        $("div.form-body").last().append(inputhtml);
    });
    $('body').on('click', 'a.btnhapuspertanyaan', function (e) {
        e.preventDefault();
        $(this).closest('div.row').closest('div.col-md-12').closest('div.row').remove();
    });
    $('body').on('change', 'select[name^="tipe_jawaban"]', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var check = $(this).closest('div.row').next();
        var idenumber = $(this).closest('div.row').closest('div.col-md-12').closest('div.row').attr('data-number');
        if ($(this).val() == 1) {
            var inputhtml = '<div class="row">\n';
            inputhtml += '<div class="col-md-11">\n';
            inputhtml += '<div class="form-group">\n';
            inputhtml += '<label class="control-label">Jawaban <span class="required" aria-required="true"> * </span></label>\n';
            inputhtml += '<input type="text" name="jawaban[' + idenumber + '][]" id="field_cr_jawaban" class="form-control" value="" placeholder="Jawaban" />\n';
            inputhtml += '</div>\n';
            inputhtml += '</div>\n';
            inputhtml += '<div class="col-md-1 text-center">\n';
            inputhtml += '<div class="form-group">\n';
            inputhtml += '<label class="control-label">Tindakan</label><br />\n';
            inputhtml += '<a href="javascript:;" class="btntambahjawaban btn btn-circle btn-icon-only bg-blue-dark bg-font-blue-dark form-control"><i class="fa fa-plus-circle"></i></a>\n';
            inputhtml += '</div>\n';
            inputhtml += '</div>\n';
            inputhtml += '</div>\n';
            $(inputhtml).insertAfter($(this).closest('div.row'));
        } else {
            if (check.length > 0) {
                $(this).closest('div.row').nextAll().remove();
            }
        }

    });
    $('body').on('click', 'a.btntambahjawaban', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idenumber = $(this).closest('div.row').closest('div.col-md-12').closest('div.row').attr('data-number');
        var inputhtml = '<div class="row">\n';
        inputhtml += '<div class="col-md-11">\n';
        inputhtml += '<div class="form-group">\n';
        inputhtml += '<input type="text" name="jawaban[' + idenumber + '][]" id="field_cr_jawaban" class="form-control" value="" placeholder="Jawaban" />\n';
        inputhtml += '</div>\n';
        inputhtml += '</div>\n';
        inputhtml += '<div class="col-md-1 text-center">\n';
        inputhtml += '<div class="form-group">\n';
        inputhtml += '<a href="javascript:;" class="btnhapusjawaban btn btn-circle btn-icon-only bg-red-soft bg-font-red-soft form-control"><i class="fa fa-minus-circle"></i></a>\n';
        inputhtml += '</div>\n';
        inputhtml += '</div>\n';
        inputhtml += '</div>\n';
        $(this).parent().parent().parent().parent().last().append(inputhtml);
    });
    $('body').on('click', 'a.btnhapusjawaban', function (e) {
        e.preventDefault();
        $(this).closest('div.row').remove();
    });
    $("input#field_cr_tgl_mulai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', startDate: '+0d'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_cr_tgl_selesai").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', startDate: '+0d'}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>