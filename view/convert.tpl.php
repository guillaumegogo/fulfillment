<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="row">
		<form class="form-horizontal" action="#" method="post" name="upload_csv" enctype="multipart/form-data">
			<fieldset>
				<legend>Backer list converter</legend>
				<!-- File Button -->
				<div class="form-group">
					<label class=" control-label" for="filebutton">Select File</label>
					<div class="">
						<input type="file" name="file" id="file" class="input-large">
					</div>
				</div>
				<div class="form-group">
					<label class=" control-label">Multiline&rarr;Singleline </label>
					<div class="">
						<input type="radio" name="to" id="to" value="singleline" checked />
					</div>
				</div>
				<div class="form-group">
					<label class=" control-label">Singleline&rarr;Multiline</label>
					<div class="">
						<input type="radio" name="to" id="to" value="multiline" disabled />
					</div>
				</div>
				<!-- Button -->
				<div class="center">
					<button type="submit" id="import" name="Import_csv" class="btn-bleu" data-loading-text="Loading...">Import</button>
				</div>
			</fieldset>
		</form>
	</div>
	<div class="row center">
		<button type="button" onclick="window.location.href='convert.php'" >Reset</button>
		<button type="button" onclick="window.location.href='index.htm'" >Home</button>
	</div>
</body>
</html>