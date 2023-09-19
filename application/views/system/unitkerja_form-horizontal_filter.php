<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-3">Lokasi Kerja</label>
            <div class="col-md-7">
                <select name="search_trlokasi_id" id="search_trlokasi_id" class="form-control" style="width: 100%">
                    <?php if (!empty($this->session->userdata('trlokasi_id')) && $this->session->userdata('idgroup') == 1) { ?>
                        <option value="">- Pilih Lokasi Kerja -</option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-3">Unit Jabatan Pimpinan Tinggi Madya</label>
            <div class="col-md-7">
                <select name="search_kdu1" id="search_kdu1" class="form-control" style="width: 100%">
                    <?php if (!empty($this->session->userdata('trlokasi_id')) && $this->session->userdata('idgroup') == 1) { ?>
                        <option value="">- Pilih Jabatan Pimpinan Tinggi Madya -</option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-3">Unit Jabatan Pimpinan Tinggi Pratama</label>
            <div class="col-md-7">
                <select name="search_kdu2" id="search_kdu2" class="form-control" style="width: 100%">
                    <option value="">- Pilih Jabatan Pimpinan Tinggi Pratama -</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-3">Unit Jabatan Administrator</label>
            <div class="col-md-7">
                <select name="search_kdu3" id="search_kdu3" class="form-control" style="width: 100%">
                    <option value="">- Pilih Jabatan Administrator -</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-3">Unit Pengawas</label>
            <div class="col-md-7">
                <select name="search_kdu4" id="search_kdu4" class="form-control" style="width: 100%">
                    <option value="">- Pilih Pengawas -</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-3">Unit Pelaksana (Eselon V)</label>
            <div class="col-md-7">
                <select name="search_kdu5" id="search_kdu5" class="form-control" style="width: 100%">
                    <option value="">- Pilih Pelaksana (Eselon V) -</option>
                </select>
            </div>
        </div>
    </div>
</div>