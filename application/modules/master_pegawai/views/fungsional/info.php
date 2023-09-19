<div class="modal-header bg-yellow-soft bg-font-yellow-soft" style="padding: 10px">
    <i class="bg-font-blue-madison font-lg icon-close pull-right" style="line-height: 26px;cursor: pointer" data-dismiss="modal" aria-hidden="true"></i>
    <h4 class="modal-title bg-font-blue-madison font-lg sbold pull-left">Info Pemutakhir Data</h4>
</div>
<div class="modal-body">
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form class="form-horizontal" role="form">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama Pengisi Data :</label>
                            <div class="col-md-8">
                                <?php
                                $nama = ((!empty($model['GELAR_DEPANC'])) ? $model['GELAR_DEPANC'] . " " : "") . ($model['NAMAC']) . ((!empty($model['GELAR_BLKGC'])) ? ", " . $model['GELAR_BLKGC'] : '');
                                ?>
                                <p class="form-control-static"> <?=($nama) ? $nama : 'Administrator'?> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label class="control-label col-md-4">Tanggal Pengisi Data :</label>
                            <div class="col-md-8">
                                <p class="form-control-static"> <?=($model['CREATED_DATE2']) ? $model['CREATED_DATE2'] : '17/12/2018 13:26:00'?> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama Peng- Update Data :</label>
                            <div class="col-md-8">
                                <?php
                                $nama2 = ((!empty($model['GELAR_DEPANU'])) ? $model['GELAR_DEPANU'] . " " : "") . ($model['NAMAU']) . ((!empty($model['GELAR_BLKGU'])) ? ", " . $model['GELAR_BLKGU'] : '');
                                ?>
                                <p class="form-control-static"> <?=($nama2) ? $nama2 : 'Administrator'?> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label class="control-label col-md-4">Tanggal Update Data :</label>
                            <div class="col-md-8">
                                <p class="form-control-static"> <?=($model['UPDATED_DATE2']) ? $model['UPDATED_DATE2'] : '17/12/2018 13:26:00'?> </p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
</div>