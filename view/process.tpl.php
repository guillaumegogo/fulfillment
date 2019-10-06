<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript">
function ik(id, val){
	document.getElementById(id).value = val;
}
	</script>
</head>

<body>
	<div class="row">
		<form action="#" method="post" name="upload_csv" enctype="multipart/form-data">
			<fieldset>
				<legend>Which boxes for this campaign?</legend>
				<!-- File Button -->
				<div class="form-group">
					<label class="control-label" for="filebutton">Select backer list</label>
					<div class="">
						<input type="file" name="file" id="file" class="input-large">
					</div>
				</div>
				<!-- File Button -->
				<div class="form-group">
					<label class="control-label">Optimize boxes <small>(longer !)</small></label>
					<div class="">
						<input type="checkbox" name="optimize" id="optimize" value="1" />
					</div>
				</div>
				<!-- File Button -->
				<div class="form-group">
					<label class="control-label">Priority to classic boxes</label>
					<div class="">
						<input type="checkbox" name="prefered" id="prefered" value="1" />
					</div>
				</div>
				<!-- Button -->
				<div class="center">
					<button type="submit" id="import" name="Import_csv" class="btn-bleu" data-loading-text="Loading...">Import</button>
				</div>
			</fieldset>
		</form>
	</div>
		   
<?php if($answers){ ?>
	<div class="row">
	<form action="#" method="post" name="valid_boxes">
	<fieldset>
		<legend>1. Here are the <?php if($optimize) echo "(optimized!)"; ?> boxes list</legend>
		
		<table id="result">
		<thead>
			<tr>
			<th scope="col">dimension</th>
			<th scope="col">d.weight</th>
			<th scope="col">qty</th>
			<th scope="col">boxes</th>
			<th scope="col">configs list</th>
			<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
<?php
$i=0;
foreach($answers as $key => $answer){

	if ($answer['label']=="multipieces") $dim_weight = "";
	else $dim_weight=round($answer['l']*$answer['w']*$answer['h']/305,1);
?>
			<tr>
			<td nowrap><?=$answer['label']?></td>
			<td class="small" style="text-align:center" nowrap><?=$dim_weight?></td>
			<td style="text-align:center" nowrap><input class="hidden" name="last[<?=$answer['label']?>][nb]" value="<?=$answer['nb']?>">
				<?=$answer['nb']?></td>
			<td nowrap>
				<input type='button' onclick='ik("i<?=++$i?>", "<?=$answer['label']?>");' value='>'>
				<input type="text" id="i<?=$i?>" name="last[<?=$answer['label']?>][box]" class="larger" value="<?php echo $_POST["last"][$answer['label']]["box"]; ?>"> 
			</td>
			<td class="xsmall">
				<?php foreach($answer['configs'] as $config=>$detail){?>
					<?=$detail['description'];?> (<a href="pack.php?c=<?=urlencode(serialize($detail['boxes']))?>" target="_blank">check</a>) <input class="hidden" name="last[<?=$answer['label']?>][configs][]" value="<?=$config?>">
				<?php } ?>
			</td>
			</tr>
<?php
}
?>
		</tbody>
		</table>
		<!-- Button -->
		<div class="center">
			<button type="submit" id="submit" name="Submit_boxes" class="btn-bleu">Create files</button>
		</div>

	</fieldset>
	</form>
	</div>
<?php
}

if($file_list){ ?>
	<div class="row">
	<fieldset>
	<legend>2. Here are the files</legend>
		
		<table class="table table-striped" id="result">
		<thead>
			<tr>
			<th scope="col">Case</th>
			<th scope="col">Qty</th>
			<th scope="col">CSV</th>
			</tr>
		</thead>
		<tbody>
<?php
foreach($file_list as $k => $box){
?>
			<tr>
			<td><?=$k?></td>
			<td><?=$box['nb']?></td>
			<td><a href="file.php?c=<?=urlencode(str_replace(' ','',implode(',',$box['configs'])))?>">Download</a></td>
			</tr>
<?php
}
?>
		</tbody>
		</table>
	</fieldset>
	</div>
<?php
}
?>

	<div class="row center">
		<button type="button" onclick="window.location.href='process.php'" >Reset</button>
		<button type="button" onclick="window.location.href='index.htm'" >Home</button>
	</div>
</body>
</html>

<small><pre><?php 
//print_r($file_list);

//print_r($configs);
//print_r($_POST);

//print_r($answers);
?></pre></small>