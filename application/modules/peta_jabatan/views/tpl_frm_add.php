	<?php echo form_open($form_action, $form); ?>
	<?php echo form_fieldset('Tambah Unit Kerja', array('id'=>'new-client-fieldset')); ?>
 
  <div class="field required-field">
    <?php //echo $frm_fakultas; ?>

      <?php echo form_label($id_parent['alt'], $id_parent['id']); ?>
      <div class="field-inner">
        <select name="id_parent" id="id_parent">
				<option value="">ROOT</option>
        <?php echo buildOptionTreeUnitKerja($treeMenu, $is_sub=FALSE); ?>				
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
		<?php echo form_input($submit);?>
	</div>
  </div>
	<?php echo form_fieldset_close(); ?>
	<?php echo form_close(); ?>

<?php  //print('<pre>'); print_r($list_parent); print('</pre>'); ?>