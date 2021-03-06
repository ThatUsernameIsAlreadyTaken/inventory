<?php
	$page_title = 'All Product';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(2);

	$product = find_by_id('products',(int)$_GET['id']);
	$all_categories = find_all('categories');
	$all_photo = find_all('media');
	$all_stock = find_all('stock');
	if( ! $product )
	{
		$session->msg("d","Missing product id.");
		//  redirect('products.php');
	}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
	<div class="col-md-6">
		<?php echo display_msg($msg); ?>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<strong>
					<span class="glyphicon glyphicon-th"></span>
					<span>Product Detail</span>
				</strong>
			</div>

			<div class="panel-body">
				<div class="row">
					<div class="col-md-1">
					</div>
					<div class="col-md-6">
						<h4><?php echo remove_junk(first_character($product['name']));?></h4>
						<div><label>Description:</label></div>
						<div><?php echo remove_junk($product['description']); ?></div>
					</div>
					<div class="col-md-1">
					</div>
					<div class="col-md-4">
						<?php
						foreach ($all_photo as $photo)
						{
							if ( $product['media_id'] == $photo['id'] )
							{
							?>
							<img class="img-thumbnail" src="uploads/products/<?php echo $photo['file_name']; ?>" alt="">
						<?php
							}
						}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-1">
					</div>
					<div class="col-md-10">
						<div class="text-center"><label></label></div>
					</div>
				</div>
				<?php
				foreach ($all_categories as $category )
				{
					if ( $product['category_id'] == $category['id'] )
					{
						break;
					}
				}
				?>


				<div class="row">
					<div class="col-md-1">
					</div>
					<div class="col-md-10">
				<!--     *************************     -->
						<div class="panel-body">
							<ul>
								<li class="text-left"> Category: <?php echo remove_junk($category['name']); ?></li>
								<li class="text-left"> Location: <?php echo remove_junk($product['location']); ?></li>
								<li class="text-left"> GPC P/N: <?php echo remove_junk($product['gpc_number']); ?></li>
								<li class="text-left"> Stock: <?php echo remove_junk($product['quantity']); ?></li>
								<li class="text-left"> Min Quantity: <?php echo remove_junk($product['min']); ?></li>
								<li class="text-left"> Max Quantity: <?php echo remove_junk($product['max']); ?></li>
								<li class="text-left"> Item Cost: <?php echo remove_junk($product['item_cost']); ?></li>
								<li class="text-left"> Manufacturer: <?php echo remove_junk($product['manufacturer']); ?></li>
								<li class="text-left"> Manufacturer P/N: <?php echo remove_junk($product['manufacturernumber']); ?></li>
								<li class="text-left"> Supplier: <?php echo remove_junk($product['supplier']); ?></li>
								<li class="text-left"> Alternate Manufacturer: <?php echo remove_junk($product['alt_manufacturer']); ?></li>
								<li class="text-left"> Alternate Manufacturer P/N: <?php echo remove_junk($product['alt_manufacturernumber']); ?></li>
								<li class="text-left"> Alternate Supplier: <?php echo remove_junk($product['alt_supplier']); ?></li>
								<li class="text-left"> Notes: <?php echo remove_junk($product['notes']); ?></li>
								<li class="text-left"> Critical Item: <?php if ($product['crit'] < '1') { echo "no";} else { echo "yes";}; ?></li>
								<li class="text-left"> Product Added: <?php echo read_date($product['date']); ?></li>
								<li class="text-left"> Line: <?php echo remove_junk($product['Line']); ?></li>
								<li class="text-left"> Machine: <?php echo read_date($product['Machine']); ?></li>
								<li class="text-left"> Actions: 
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
								</li>
							</ul>
<!--     ***********************************************     -->
							<td class="text-center"> 
							</td>
						</div>
					</div>
				</div>
			</div>

			<?php
			//	print "<pre>";
			//	print_r($product);
			//	print "</pre>\n";
			?>

		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<strong>
					<span class="glyphicon glyphicon-th"></span>
					<span>Inventory Movement</span>
				</strong>
			</div>
			<?php
				foreach ( $all_stock as $stock )
				{
					if ( $stock['product_id'] == $product['id'] ){
						echo " ";
						echo $stock['date'];
						echo " ";
						echo "Quantity Taken: ";
						echo $stock['quantity'];
						echo " ";
						echo "Comments: ";
						echo $stock['comments'];
						echo "</br>";
					}
				}
			?>
		</div>
	</div>
</div>
<?php include_once('layouts/footer.php'); ?>
