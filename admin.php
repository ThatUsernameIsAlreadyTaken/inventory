<?php
  $page_title = 'Admin Home Page';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
 $c_categorie     = count_by_id('categories');
 $c_product       = count_by_id('products');
 $c_sale          = count_by_id('sales');
 $c_user          = count_by_id('users');
 $recent_products = find_recent_product_added('10');
 $recent_sales    = find_recent_sale_added('10');
 $below_limit	  = find_below_min();
?>
<?php include_once('layouts/header.php'); ?>

<!--     *************************     -->
<div class="row">
	<div class="col-md-6">
		<?php echo display_msg($msg); ?>
	</div>
</div>
<!--     *************************     -->
<div class="row">
	<div class="col-md-3">
		<div class="panel panel-box clearfix">
			<div class="panel-icon pull-left bg-green">
				<i class="glyphicon glyphicon-user"></i>
			</div>
			<div class="panel-value pull-right">
				<h2 class="margin-top"> <?php  echo $c_user['total']; ?> </h2>
				<p class="text-muted">Users</p>
			</div>
		</div>
	</div>
	<!--     *************************     -->
	<div class="col-md-3">
		<div class="panel panel-box clearfix">
			<div class="panel-icon pull-left bg-red">
				<i class="glyphicon glyphicon-list"></i>
			</div>
			<div class="panel-value pull-right">
				<h2 class="margin-top"> <?php  echo $c_categorie['total']; ?> </h2>
				<p class="text-muted">Categories</p>
			</div>
		</div>
	</div>
	<!--     *************************     -->
	<div class="col-md-3">
		<div class="panel panel-box clearfix">
			<div class="panel-icon pull-left bg-blue">
				<i class="glyphicon glyphicon-shopping-cart"></i>
			</div>
			<div class="panel-value pull-right">
				<h2 class="margin-top"> <?php  echo $c_product['total']; ?> </h2>
				<p class="text-muted">Products</p>
			</div>
		</div>
	</div>
	<!--     *************************     -->
	<div class="col-md-3">
		<div class="panel panel-box clearfix">
			<div class="panel-icon pull-left bg-yellow">
				<i class="glyphicon glyphicon-usd"></i>
			</div>
			<div class="panel-value pull-right">
				<h2 class="margin-top"> <?php  echo $c_sale['total']; ?></h2>
				<p class="text-muted">Sales</p>
			</div>
		</div>
	</div>
</div>

<script>
	function closePanel()
		{
			var x = document.getElementById("myDIV");
			if (x.style.display === "none")
			{
				x.style.display = "block";
			} else {
			x.style.display = "none";
			}
		}
</script>

<div class="row" id="myDIV">
	<div class="col-md-12">
		<div class="panel">
			<div class="pull-right">
				<a href="#" onclick="closePanel();" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Close"><i class="glyphicon glyphicon-remove"></i></a>
			</div>
			<div class="jumbotron text-center">
				<h3>Welcome!</h3>Recently added bins below limit to admin page. Fixed singing out items not actually changing quantity in stock. Added CSV upload. Added inventory movement to product detail page.
			</div>
		</div>
	</div>
</div>
<!--     *************************     -->
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong>
					<span class="glyphicon glyphicon-th"></span>
					<span>Bins Below Min</span>
				</strong>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed">
					<thead>
						<tr>
							<th class="text-center" style="width: 50px;">#</th>
							<th>Product Name</th>
							<th>Item Quantity</th>
							<th>Critical Item</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($below_limit as  $recent_sale): ?>
						<tr>
							<td class="text-center"><?php echo count_id();?></td>
							<td>
								<a href="edit_product.php?id=<?php echo (int)$recent_sale['id']; ?>">
									<?php echo remove_junk($recent_sale['name']); ?>
								</a>
							</td>
							<td><?php echo remove_junk($recent_sale['quantity']); ?></td>
							<td><?php if ($recent_sale['crit'] < '1') { echo "No";} else { echo "Yes";}; ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!--     *************************     -->
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
			<strong>
			<span class="glyphicon glyphicon-th"></span>
			<span>Recently Added Products</span>
			</strong>
			</div>
			<div class="panel-body">
				<div class="list-group">
					<?php foreach ($recent_products as  $recent_product): ?>
						<a class="list-group-item clearfix" href="edit_product.php?id=<?php echo    (int)$recent_product['id'];?>">
							<h4 class="list-group-item-heading">
								<?php if($recent_product['media_id'] === '0'): ?>
									<img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
								<?php else: ?>
									<img class="img-avatar img-circle" src="uploads/products/<?php echo $recent_product['image'];?>" alt="" />
								<?php endif;?>
								<?php echo remove_junk(first_character($recent_product['name']));?>
								<span class="label label-warning pull-right">
								<?php echo (int)$recent_product['quantity']; ?>
								</span>
							</h4>
							<span class="list-group-item-text pull-right">
								<?php echo remove_junk(first_character($recent_product['category'])); ?>
							</span>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
</div>
<?php include_once('layouts/footer.php'); ?>
