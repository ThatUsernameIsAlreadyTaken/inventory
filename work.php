<?php
	require_once('includes/load.php');
	page_require_level(1);
?>

<div id="wrap">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<form class="form-horizontal" action="csv.php" method="post" name="upload_excel" enctype="multipart/form-data">
						<fieldset>
							<!-- Form Name -->
							<legend> Import item information to products</legend>
							<!-- File Button -->
							<div class="row">
								<div class="form-group">
									<label class="col-md-12 control-label" for="filebutton">Select File</label>
									<div class="col-md-4">
										<input type="file" name="file" id="file" class="input-large">
									</div>
								</div>
							</div>
							<!-- Button -->
							<div class="row">
								<div class="form-group">
									<label class="col-md-4 control-label" for="singlebutton">Import data</label>
									<div class="col-md-4">
										<button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>