0[[SPLIT]]
<select name="kdu3" id="kdu3" <?= $eselon2 ?> style="max-width: none;width: 225px;" >
    <option value="000">- Pilih Jabatan Administrator -</option>
    <?php foreach ($list_struktur_es3 as $r) { ?>
        <option value="<?= $r['kdu3'] ?>"><?= $r['nmunit'] ?></option>
    <?php } ?>
</select>
[[SPLIT]] 