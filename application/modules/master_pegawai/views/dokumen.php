<div class="modal-header bg-yellow-soft bg-font-yellow-soft" style="padding: 10px">
    <i class="bg-font-blue-madison font-lg icon-close pull-right" style="line-height: 26px;cursor: pointer" data-dismiss="modal" aria-hidden="true"></i>
    <h4 class="modal-title bg-font-blue-madison font-lg sbold pull-left">Dokumen Pegawai</h4>
</div>
<?php if ($file) { ?>
    <div class="modal-body modaldokumen"></div>
<?php } else { ?>
    <div class="modal-body">
        <div class="alert alert-danger">
            <strong>Maaf!</strong> File tidak ditemukan. 
        </div>
    </div>
<?php } ?>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
</div>