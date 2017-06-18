
<div class="navs"style=" width:600px;height:20px;">
	<?php foreach($data as $val) {?>
		<?php $nav_name = unserialize($val['nav_name']) ?>
		  
		  <?php foreach($nav_name as $v){?>
		  <li  style="list-style-type:none;float:left"><a href="<?= $v['nav_url'] ?> " <?php if($v['is_new'] == 1){echo 'target="_blank"';} ?> ><?= $v['nav_name'] ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>			
		 <?php } ?>

	<?php } ?>
</div>
<script>

	$('.navs').css({
				background:"<?=$data[0]['nav_color']?>",
				textAlign :"<?=$data[0]['position']?>",
		})
	$('.navs li>a').css({
				color:"<?= $data[0]['font_color']?>",
				fontSize:"<?= $data[0]['font_size']?>",	
	})
</script>