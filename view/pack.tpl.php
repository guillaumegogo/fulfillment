
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>SnL packing calculator</title>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script>
function resetForm(form) {
	// clearing inputs
	var inputs = form.getElementsByTagName('input');
	for (var i = 0; i<inputs.length; i++) {
		inputs[i].value = '';
	}
	return false;
}	
function hidendisplay() {
	var x = document.getElementById("hidden");
	if (x.style.display === "none") {
		x.style.display = "block";
	} else {
		x.style.display = "none";
	}
} 
	</script>
</head>
<body>

<div class="row">
	<div class="column">
		<h2>Boxes dimension</h2>
		
		<form action="?" method="post">
			
		Container: <input type="text" name="cl" value="<?php echo $container['length'];?>"> 
			<input type="text" name="cw" value="<?php echo $container['width'];?>"> &nbsp;&nbsp;&nbsp;<br>
		
		<?php
		$nb_boites=40;
		for($i=0; $i<$nb_boites; $i++){
			$l=$w=$h=null;
			$l=$brut_boxes[$i][0]; $w=$brut_boxes[$i][1]; $h=$brut_boxes[$i][2]; 
			if($i==10) echo "<a onclick='hidendisplay()'>+</a> <div class='hidden' id='hidden'>";
		?>
		
		Box<?php if($i<9) echo "0"; echo $i+1;?>: 
			<input type="text" name="l[]" value="<?php echo $l?>"> 
			<input type="text" name="w[]" value="<?php echo $w?>"> 
			<input type="text" name="h[]" value="<?php echo $h?>"> <br>

		<?php }
		echo "</div>";
		?>
		
		<div style="margin:1em;">
			<small>(<a href="?c=random">random</a>)</small>
			<button class="btn-bleu" type="submit" value="Submit">Submit</button>
		</div>
		</form>
	</div>
	
	<div class="column" style="width:70%">

<?php if(!is_null($boxes)){ ?>
	<h2>Packed boxes</h2>
	
	<p>Suggested case: 
		<b><?=ceil($ctnr[0]);?>x<?=ceil($ctnr[1]);?>x<?=ceil($ctnr[2]);?></b> <small>&rarr; <a href="https://www.uline.ca/product/GuidedNav?t=184360&dup=pano&S=4%3b<?=ceil($ctnr[0])?>%2c10%3b<?=ceil($ctnr[1])?>%2c15%3b<?=ceil($ctnr[2])?>" target="_blank">check uline</a></small>
	</p><p>
		<?= $p_num_boxes; ?> boxes volume: <?= intval($p_volume); ?> / case volume: <?= $ctnr_volume; ?> = wasted: <span style="color: hsl(0, 100%, <?= $w_percent / 2; ?>%);"><b><?= $w_percent; ?>%</b></span>
	</p>

	<div id="pack-container">
		<span class="title">Stack</span>
		<span class="description"><?= $c_size['length'];?>x<?= $c_size['width'];?>x<?= $c_size['height'];?> (volume: <?= intval($c_volume); ?>)</span><!--
		<span class="description">Surface <?php echo $c_size['length']*$c_size['width']; ?></span>-->
	
		<?php for($i = 0; $i < $c_levels; $i++): ?>
		<div class="level">
			<span class="title">Level <?php echo $i; ?></span>
			<?php $ld = $lp->get_level_dimensions($i); ?>
			<span class="description">height <?php echo $ld['height']; ?></span>
			<div class="boxes">
				<?php foreach($p_boxes[$i] as $k => $box): ?>
				<div class="box">
					<span class="title">Box <?php echo $k; ?></span>
					<span class="description"><?php echo $box['length']; ?>x<?php echo $box['width']; ?>x<?php echo $box['height']; ?></span>
					<!--<span class="description"><?php echo $box['length'] * $box['width']; ?></span>-->
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endfor; ?>
	</div>
		
		<?php if(!is_null($others)){ ?>
		<p>Alternative(s):<ol>
		<?php foreach($others as $o){ ?>
			<li><?= $o[0]."x".$o[1]."x".$o[2] ?> (vol: <?= $o[3] ?>, w: <?= $o[4] ?>%) <small>&rarr; <a href="https://www.uline.ca/product/GuidedNav?t=184360&dup=pano&S=4%3b<?=$o[0]?>%2c10%3b<?=$o[1]?>%2c15%3b<?=$o[2]?>" target="_blank">check uline</a></small></li>
		<?php } ?>
		</ol></p>
	<?php }
	} ?>
	</div>
</div>

<div class="row center">
	<button type="button" onclick="window.location.href='pack.php'" >Reset</button>
	<button type="button" onclick="window.location.href='index.htm'" >Home</button>
</div>
	
</body>
</html>

<?php 
// print_r($others);
?>