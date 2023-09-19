0[[SPLIT]] 
<select name="kdu1" id="kdu1" >
<option value="">-Pilih Eselon-</option>
<?php foreach ($list_struktur_es1 as $r)
	{ ?>
	<option value="<?=$r['kdu1']?>"><?=$r['nmunit']?></option>
<?php	} ?>
</select>
[[SPLIT]] 
<?php 
foreach($data_master as $r) { 
	if($r['spesial']=='Y' AND $r['leher'] <> 'Y' ){
		$spesial[]=$r;
		$leher='N';
	}else if($r['spesial']=='Y' AND $r['leher'] == 'Y' ){
		$spesial[]=$r;
		$leher='Y';
	}else{
		$general[]=$r;
	}
}

if(count($spesial) > 0  AND $leher <> 'Y') { 
	$c_spesial="spesial_level";
}else if(count($spesial) > 0  AND $leher == 'Y') { 
	$c_spesial="spesial_solid";
}else{
	$c_spesial="";
}
?>
<?php if(count($general)<>0){$class_width=(count($general)*184); } else { $class_width=184; } ?>
<div class="<?=$c_spesial?>">
		<div class="menteri" style="width:<?=$class_width?>px;">
				<div class="box_item">
					<div class="item_menteri">
						<h2><?=$menteri?></h2>
						<img class="photo" src="<?=base_url()?>_uploads/photo_pegawai/thumbs/<?=$menteri_desc['foto']?>" />
						<div class="desc">
						<h3><?=$menteri_desc['nama']?></h3>
						</div>
					</div>
				</div>
			
			<div class="spesial">
				<?php 
				$i=1;
				foreach($spesial as $r){	
				//if($r['leher']=='Y'){ $leher='leher'; } else { $leher=''; }
				
				if($i==1 AND count($spesial) <> 1){
					$class="level1 level1_first";
					$clear="N";
				}else if($i==count($spesial) AND count($spesial) <> 1){
					$class="level1 level1_last";
					$clear="Y";
				}else if(count($spesial) ==1){
					$class="level1 single";
					$clear="Y";
				}else{
					$class="level1";
					$clear="N";
				}
				?>
				<div class="<?=$class?>">
					<div class="box_item">
					<div class="item_level2 color-<?=$r['tktesel']?>">
						<a class="view-detail" href="../master/edit.php?id=<?=$r['id']?>" title="Lihat Detail">
							<h2><?=$r['jabatan']?><br><?=$r['nmunit']?></h2>
						</a>
						<a href="<?=base_url()?><?=$r['url_link']?>?keepThis=true&type=image&TB_iframe=1&width=1024&height=566&modal=true"  class="thickbox "> 
							<img class="photo" src="<?=base_url()?>_uploads/photo_pegawai/thumbs/<?=$r['foto']?>" />
						
							<div class="desc">
								<h3><?=$r['nama']?></h3>
								<h3>NIP.&nbsp;<?=$r['nip']?></h3>
								<h3>Eselon. / TMT. <?=$r['tmtjab']?></h3>
								<h3>Lhr. <?=$r['tmtjab']?></h3>
							</div>
						</a>
						
					</div>
					</div>
				</div>
				<?php if($clear=='Y'){ ?><div class="clear"></div><?php } ?>
				<?php 
					if($r['leher'] <> 'Y'){
					$i++; 
					}
				} 
				?>
			</div>
			
			<div class="general">
				<div class="blok_org">
					<?php 
					$i=1;
					foreach($general as $r){	
					
					if($i==1 AND count($general) <> 1){
						$class="level2 level2_first";
						$clear="N";
					}else if($i==count($general) AND count($general) <> 1){
						$class="level2 level2_last";
						$clear="Y";
					}else if(count($general) == 1){
						$class="level2 single";
						$clear="Y";
					}else{
						$class="level2";
						$clear="N";
					}
					?>
					<div class="<?=$class?>">
						<div class="box_item">
						<div class="item_level2 color-<?=$r['tktesel']?>">
							<a class="view-detail" href="../master/edit.php?id=<?=$r['id']?>" title="Lihat Detail">
							<h2><?=$r['jabatan']?><br><?=$r['nmunit']?></h2>
							</a>
							<a href="<?=base_url()?><?=$r['url_link']?>?keepThis=true&type=image&TB_iframe=1&width=1024&height=566&modal=true"  class="thickbox "> 
								<img class="photo" src="<?=base_url()?>_uploads/photo_pegawai/thumbs/<?=$r['foto']?>" />
							
							<div class="desc">
								<h3><?=$r['nama']?></h3>
								<h3>NIP.&nbsp;<?=$r['nip']?></h3>
								<h3>Eselon. / TMT. <?=$r['tmtjab']?></h3>
								<h3>Lhr. <?=$r['tmtjab']?></h3>
							</div>
							</a>
							
						</div>
						</div>
					</div>
					<?php if($clear=='Y'){ ?><div class="clear"></div><?php } ?>
					<?php $i++; } ?>
				</div>
			</div>

		</div>
</div>
<script type="text/javascript" src="<?=base_url();?>asset/js/thickbox/thickbox.js"></script>