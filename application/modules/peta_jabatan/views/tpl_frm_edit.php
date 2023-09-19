	<?php echo form_open($form_action, $form); ?>
	<?php echo form_fieldset('Update Unit', array('id'=>'new-client-fieldset')); ?>
  
  <div class="field required-field">
		<?php echo form_label($id_parent['alt'], $id_parent['id']); ?>
		<div class="field-inner">
			<select name="id_parent" id="id_parent">
				<option value="">ROOT</option>
        <?php echo buildOptionTreeUnitKerjaSelected($treeMenu, $is_sub=FALSE, $row['id_parent'], $row['posisi']); ?>
			</select>
    </div>
  </div>
  
  <div class="field required-field">
		<?php echo form_label($kd_unit['alt'], $kd_unit['id'])?>
    <div class="field-inner">
			<?php echo form_input($kd_unit)?>
    </div>
  </div>
  
	<div class="field">
		<?php echo form_label($nm_unit['alt'], $nm_unit['id']); ?>
    <div class="field-inner">
			<?php echo form_input($nm_unit); ?>
    </div>
  </div>
  
	<div class="field-inner">
		<div class="field_button">
			<?php echo form_input($submit);?> atau 
			<!--a href="< ?php echo anchor('ref_satuan_kerja/ref_satuan_kerja/add/'.$row['modul_id']?>">Batal</a-->
			<?php echo anchor('ref_satuan_kerja/ref_satuan_kerja/add/', 'Batal', 'class=" btn_action btn_false"'); ?>
		</div>
	</div>
  
	<?php echo form_fieldset_close(); ?>
	<?php echo form_close(); ?>