<?php
	$page_title = 'All Product';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(2);

	$all_categories = find_all('categories');
	$all_products = find_all('products');

	if ( isset($_POST['update_category'] ) )
	{
	  $products = find_products_by_category((int)$_POST['product-category']);
	} else {
	  $products = join_product_table();
	}

	if(isset($_POST['search']))
	{
		if(empty($errors))
		{
			$search = remove_junk($db->escape($_POST['search-text']));
			redirect("results.php?id={$search}", false);
		}
	}
?>

<!--     *************************     -->

<?php include_once('layouts/header.php'); ?>
<div class="row">
	<div class="col-md-6">
		<?php echo display_msg($msg); ?>
		<form method="post" action="">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-btn">
						<button type="submit" name="update_category" class="btn btn-primary">Update Category</button>
					</span>
					<select class="form-control" name="product-category">
						<option value="">Select Product Category</option>
						<?php  foreach ($all_categories as $cat): ?>
						<option value="<?php echo (int)$cat['id'] ?>">
							<?php echo $cat['name'] ?>
						</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-6">
		<form method="post" action="">
			<div class="form-group">
				<div class="input-group">
					<input type="text" class="form-control" name="search-text" placeholder="Search">
					<span class="input-group-btn">
						<button type="submit" name="search" class="btn btn-primary">Search</button>
					</span>
				</div>
			</div>
		</form>
	</div>
</div>    
<div class="row">
	<div class="col-md-16">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<div class="form-group">
					<div class="input-group">
						<strong>
							<span class="glyphicon glyphicon-th"></span>
							<?php
							if ( isset($_POST['update_category'] ) )
							{
									  echo "<span>Products by Category</span>";
							} else {
									  echo "<span>All Products</span>";
							}
							?>
						</strong>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="text-center" style="width: 50px;">#</th>
							<th class="text-center" style="width: 10%;"> Category </th>
							<th> Product Title </th>
							<th> Photo</th>
							<th class="text-center" style="width: 10%;"> Location </th>
							<th class="text-center" style="width: 50px;"> Stock </th>
							<th class="text-center" style="width: 50px;"> Min </th>
							<th class="text-center" style="width: 50px;"> Max </th>
							<th class="text-center" style="width: 10%;"> GPC P/N </th>
							<th class="text-center" style="width: 10%;"> Manufacturer P/N </th>
							<th class="text-center" style="width: 10%;"> Product Added </th>
							<th class="text-center" style="width: 100px;"> Actions </th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($products as $product):?>
							<tr>
								<td class="text-center"><?php echo count_id();?></td>
								<td class="text-center"> <?php echo remove_junk($product['category']); ?></td>
								<td><a href="view_product.php?id=<?php echo (int)$product['id'];?>"><?php echo remove_junk($product['name']); ?></a></td>
								<td>
									<?php if($product['media_id'] === '0'): ?>
									<img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
									<?php else: ?>
									<img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
									<?php endif; ?>
								</td>
								<td class="text-center"> <?php echo remove_junk($product['location']); ?></td>
								<td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
								<td class="text-center"> <?php echo remove_junk($product['min']); ?></td>
								<td class="text-center"> <?php echo remove_junk($product['max']); ?></td>
								<td class="text-center"> <?php echo remove_junk($product['gpc_number']); ?></td>
								<td class="text-center"> <?php echo remove_junk($product['manufacturernumber']); ?></td>
								<td class="text-center"> <?php echo read_date($product['date']); ?></td>
								<td class="text-center">
									<div class="btn-group">
										<a href="add_stock.php?id=<?php echo (int)$product['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Add">
											<span class="glyphicon glyphicon-edit"></span>
										</a>
										<a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
											<span class="glyphicon glyphicon-edit"></span>
										</a>
										<a href="delete_product.php?id=<?php echo (int)$product['id'];?>" onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
											<span class="glyphicon glyphicon-trash"></span>
										</a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php
		//	print "<pre>";
		//	print_r($products);
		//	print "</pre>\n";
		?>

		<?php
		//	print "<pre>";
		//	print_r($_POST);
		//	print "</pre>\n";
		?>
	</div>
</div>
<?php include_once('layouts/footer.php'); ?>
