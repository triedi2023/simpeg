0[[SPLIT]]
<select name="kdu5" id="kdu5" <?php echo $eselon2 ?> style="max-width: none;width: 225px;" >
    <option value="00">- Pilih Pelaksana (Eselon V) -</option>
    <?php foreach ($list_struktur_es5 as $r) { ?>
        <option value="<?php echo $r['kdu5'] ?>"><?php echo $r['nmunit'] ?></option>
    <?php } ?>
</select>
[[SPLIT]] 