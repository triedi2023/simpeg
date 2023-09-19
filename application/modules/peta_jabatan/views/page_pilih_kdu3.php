0[[SPLIT]]
<select name="kdu4" id="kdu4" <?= $eselon2 ?> style="max-width: none;width: 225px;" >
    <option value="000">- Pilih Pelaksana -</option>
    <?php foreach ($list_struktur_es4 as $r) {
        ?>
        <option value="<?= $r['kdu4'] ?>"><?= $r['nmunit'] ?></option>
    <?php } ?>
</select>
[[SPLIT]] 