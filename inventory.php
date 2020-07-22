<?php
	$page_title = 'Inventory Updater';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(1);
?>

<?php
	if(isset($_POST['update_inv']))
	{
		$req_fields = array('quantity','gpc_number');
		validate_fields($req_fields);
		if(empty($errors))
		{
			$p_qty  = remove_junk($db->escape($_POST['quantity']));
			$p_gpc_number   = remove_junk($db->escape($_POST['gpc_number']));
			$query  = "UPDATE products set quantity={$p_qty} WHERE gpc_number={$p_gpc_number}";
			if($db->query($query))
			{
				$session->msg('s',"Inventory Updated.");
				redirect('inventory.php', false);
			}else{
				echo "that didnt work";
			}
		}
	}
?>
<?php include_once('layouts/header.php'); ?>

<div class="login-page">
    <div class="text-center">
		<form method="post" action="" class="clearfix">
			<div class="form-group">
				<div class="row">
					<div class="col-md-16">
						<div class="input-group">
							<span class="input-group-addon">
								<i>Quantity</i>
							</span>
							<input type="number" class="form-control" name="quantity" placeholder="Product Quantity">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-16">
						<div class="input-group">
							<span class="input-group-addon">
								<i>GPC Item Number</i>
							</span>
							<input type="number" class="form-control" name="gpc_number" placeholder="gpc_number">
						</div>
					</div>
				</div>
				<div class="form-group clearfix">
					<button type="submit" name="update_inv" class="btn btn-info">Update</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include_once('layouts/footer.php'); ?>