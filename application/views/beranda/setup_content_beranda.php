<div class="modal-header bg-yellow-soft bg-font-yellow-soft" style="padding: 10px">
    <i class="bg-font-blue-madison font-lg icon-close pull-right" style="line-height: 26px;cursor: pointer" data-dismiss="modal" aria-hidden="true"></i>
    <h4 class="modal-title bg-font-blue-madison font-lg sbold pull-left">Jenis Jabatan Grafik Beranda</h4>
</div>

<div class="modal-body">
    <div class="form">
        <form role="form">
            <div class="form-group">
                <div class="mt-checkbox-list">
                    <label class="mt-checkbox mt-checkbox-outline"> Pegawai Berdasarkan Jabatan Fungsional Umum
                        <input type="checkbox" class="checkboxsetupdashboard" value="1" name="setupdashboardfungsionalumum" <?php echo ($setup_dashboard && in_array(1, $setup_dashboard)) ? 'checked' : '' ?> />
                        <span></span>
                    </label>
                    <label class="mt-checkbox mt-checkbox-outline"> Pegawai Berdasarkan Jabatan Fungsional Khusus
                        <input type="checkbox" class="checkboxsetupdashboard" value="2" name="setupdashboardfungsionalkhusus" <?php echo ($setup_dashboard && in_array(2, $setup_dashboard)) ? 'checked' : '' ?> />
                        <span></span>
                    </label>
                    <label class="mt-checkbox mt-checkbox-outline"> Pegawai Berdasarkan Eselon
                        <input type="checkbox" class="checkboxsetupdashboard" value="3" name="setupdashboardeselon" <?php echo ($setup_dashboard && in_array(3, $setup_dashboard)) ? 'checked' : '' ?> />
                        <span></span>
                    </label>
                </div>
            </div>
        </form>
        <div class="alert alert-danger">
            <strong>*</strong> Maximal 2 Bentuk Grafik. 
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
</div>