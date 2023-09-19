0[[SPLIT]]
<select name="kdu2" id="kdu2" <?= $eselon2 ?> style="max-width: none;width: 225px;" >
    <?php if (empty($kdu1group)): ?>
        <option value="00">- Pilih Jabatan Pimpinan Tinggi Pratama -</option>
    <?php endif; ?>
    <?php foreach ($list_struktur_es2 as $r) { ?>
        <option value="<?= $r['kdu2'] ?>"><?= $r['nmunit'] ?></option>
    <?php } ?>
</select>
[[SPLIT]] 
