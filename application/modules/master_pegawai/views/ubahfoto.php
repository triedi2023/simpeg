<div class="modal-header bg-yellow-soft bg-font-yellow-soft" style="padding: 10px">
    <i class="bg-font-blue-madison font-lg icon-close pull-right" style="line-height: 26px;cursor: pointer" data-dismiss="modal" aria-hidden="true"></i>
    <h4 class="modal-title bg-font-blue-madison font-lg sbold pull-left">Ubah Foto Pegawai</h4>
</div>
<div class="modal-body">
    <form action="javascript:;" id="formunggahfoto" data-url="<?php echo base_url()."master_pegawai/ubahfoto?id=".$id ?>" class="form-horizontal">
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-3 control-label">Foto</label>
                <div class="col-md-8">
                    <input type="file" class="form-control" name="foto" placeholder="Enter text" />
                    <span class="help-block text-danger"> Gambar Yang Di Upload Maximal ukuran file 1Mb dan format jpeg / jpg / png. </span>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-4">
                    <button type="submit" class="btn green">Unggah</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
</div>