<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-4">Lokasi Kerja</label>
            <div class="col-md-7">
                <select name="trlokasi_id" id="field_c_trlokasi_id" class="form-control struktur_lokasi" style="width: 100%">
                    <option value="">- Pilih Lokasi Kerja -</option>
                    <?php
                    if (isset($model['TRLOKASI_ID']) && !empty($model['TRLOKASI_ID'])) {
                        echo $list_lokasi;
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-4">Unit Jabatan Pimpinan Tinggi Madya</label>
            <div class="col-md-7">
                <select name="kdu1" id="field_c_kdu1" class="form-control struktur_kdu1" style="width: 100%">
                    <option value="">- Pilih Jabatan Pimpinan Tinggi Madya -</option>
                    <?php if (isset($list_kdu1)): ?>
                        <?php foreach ($list_kdu1 as $val): ?>
                            <?php
                            $selec = '';
                            if (isset($model['KDU1']) && $val['ID'] == $model['KDU1'])
                                $selec = 'selected=""';
                            ?>
                            <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-4">Unit Jabatan Pimpinan Tinggi Pratama</label>
            <div class="col-md-7">
                <select name="kdu2" id="field_c_kdu2" class="form-control struktur_kdu2" style="width: 100%">
                    <option value="">- Pilih Jabatan Pimpinan Tinggi Pratama -</option>
                    <?php if (isset($list_kdu2)): ?>
                        <?php foreach ($list_kdu2 as $val): ?>
                            <?php
                            $selec = '';
                            if (isset($model['KDU2']) && $val['ID'] == $model['KDU2'])
                                $selec = 'selected=""';
                            ?>
                            <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-4">Unit Jabatan Administrator</label>
            <div class="col-md-7">
                <select name="kdu3" id="field_c_kdu3" class="form-control struktur_kdu3" style="width: 100%">
                    <option value="">- Pilih Jabatan Administrator -</option>
                    <?php if (isset($list_kdu3)): ?>
                        <?php foreach ($list_kdu3 as $val): ?>
                            <?php
                            $selec = '';
                            if (isset($model['KDU3']) && $val['ID'] == $model['KDU3'])
                                $selec = 'selected=""';
                            ?>
                            <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-4">Unit Pengawas</label>
            <div class="col-md-7">
                <select name="kdu4" id="field_c_kdu4" class="form-control struktur_kdu4" style="width: 100%">
                    <option value="">- Pilih Pengawas -</option>
                    <?php if (isset($list_kdu4)): ?>
                        <?php foreach ($list_kdu4 as $val): ?>
                            <?php
                            $selec = '';
                            if (isset($model['KDU4']) && $val['ID'] == $model['KDU4'])
                                $selec = 'selected=""';
                            ?>
                            <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-4">Unit Pelaksana (Eselon V)</label>
            <div class="col-md-7">
                <select name="kdu5" id="field_c_kdu5" class="form-control struktur_kdu5" style="width: 100%">
                    <option value="">- Pilih Pelaksana (Eselon V) -</option>
                    <?php if (isset($list_kdu5)): ?>
                        <?php foreach ($list_kdu5 as $val): ?>
                            <?php
                            $selec = '';
                            if (isset($model['KDU5']) && $val['ID'] == $model['KDU5'])
                                $selec = 'selected=""';
                            ?>
                            <option <?= $selec ?> value="<?= $val['ID'] ?>"><?= $val['NAMA'] ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
        </div>
    </div>
</div>