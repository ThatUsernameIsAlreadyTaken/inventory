<?php
  $page_title = 'Edit product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$product = find_by_id('products',(int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
if(!$product){
  $session->msg("d","Missing product id.");
  redirect('products.php');
}
?>
<?php
 if(isset($_POST['product'])){
    $req_fields = array('product-title','product-category','product-quantity','gpc_number', 'manufacturernumber', 'manufacturer', 'supplier', 'crit' );
    validate_fields($req_fields);

   if(empty($errors)){
       $p_name  = remove_junk($db->escape($_POST['product-title']));

      if (is_null($_POST['product-desc']) || $_POST['product-desc'] === "") {
         $p_desc  =  'none';
       } else { 
       $p_desc  = remove_junk($db->escape($_POST['product-desc']));
	}

      if (is_null($_POST['product-location']) || $_POST['product-location'] === "") {
         $p_loc  =  'NA';
       } else {
		$p_loc  = remove_junk($db->escape($_POST['product-location']));
		}	

		$p_cat   = (int)$_POST['product-category'];
		$p_qty   = remove_junk($db->escape($_POST['product-quantity']));
		$p_gpc_number   = remove_junk($db->escape($_POST['gpc_number']));
		$p_min   = remove_junk($db->escape($_POST['min']));
		$p_max   = remove_junk($db->escape($_POST['max']));
		$p_gpc_number   = remove_junk($db->escape($_POST['gpc_number']));
		$p_crit  = remove_junk($db->escape($_POST['crit']));
		$p_manufacturer  = remove_junk($db->escape($_POST['manufacturer']));
		$p_manufacturernumber  = remove_junk($db->escape($_POST['manufacturernumber']));
		$p_supplier  = remove_junk($db->escape($_POST['supplier']));
		$p_alt_manu  = remove_junk($db->escape($_POST['alt_manufacturer']));
		$p_alt_manunum  = remove_junk($db->escape($_POST['alt_manufacturernumber']));
		$p_alt_supplier  = remove_junk($db->escape($_POST['alt_supplier']));
		$p_notes  = remove_junk($db->escape($_POST['notes']));
		$p_item_cost  = remove_junk($db->escape($_POST['item_cost']));
		$p_line  = remove_junk($db->escape($_POST['line']));
		$p_machine  = remove_junk($db->escape($_POST['machine']));

       if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
         $media_id = '0';
       } else {
         $media_id = remove_junk($db->escape($_POST['product-photo']));
       }
       $query   = "UPDATE products SET";
       $query  .=" name ='{$p_name}', description ='{$p_desc}',location ='{$p_loc}', quantity ='{$p_qty}',";
       $query  .=" gpc_number ='{$p_gpc_number}',category_id ='{$p_cat}',media_id ='{$media_id}',";
	   $query  .=" min ='{$p_min}', max ='{$p_max}',manufacturer ='{$p_manufacturer}',manufacturernumber ='{$p_manufacturernumber}',";
	   $query  .=" supplier ='{$p_supplier}', alt_manufacturer ='{$p_alt_manufacturer}', alt_manufacturernumber ='{$p_alt_manufacturernumber}',";
	   $query  .=" alt_supplier ='{$p_alt_supplier}', notes ='{$p_notes}', crit ='{$p_crit}', line ='{$p_line}',  machine ='{$p_machine}',";
	   $query  .=" item_cost ='{$p_item_cost}'";
       $query  .=" WHERE id ='{$product['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Product updated ");
                 redirect('products.php', false);
               } else {
                 $session->msg('d',' Sorry failed to updated!');
                 redirect('edit_product.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_product.php?id='.$product['id'], false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Edit Product</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($product['name']);?>">
               </div>
              </div>


              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-desc" value="<?php echo remove_junk($product['description']);?>" placeholder="Product Description">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-location" value="<?php echo remove_junk($product['location']);?>" placeholder="Product Location">
               </div>
              </div>


              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-category">
                    <option value=""> Select a category</option>
                   <?php  foreach ($all_categories as $cat): ?>
                     <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['category_id'] === $cat['id']): echo "selected"; endif; ?> >
                       <?php echo remove_junk($cat['name']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="product-photo">
                      <option value=""> No image</option>
                      <?php  foreach ($all_photo as $photo): ?>
                        <option value="<?php echo (int)$photo['id'];?>" <?php if($product['media_id'] === $photo['id']): echo "selected"; endif; ?> >
                          <?php echo $photo['file_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="qty">GPC Number</label>
								<div class="input-group">
									<input type="text" class="form-control" name="gpc_number" value="<?php echo remove_junk($product['gpc_number']);?>">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							<label for="qty">Quantity</label>
								<div class="input-group">
									<input type="number" class="form-control" name="product-quantity" value="<?php echo remove_junk($product['quantity']); ?>">
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="qty">Min Quantity</label>
								<div class="input-group">
									<input type="number" class="form-control" name="min" value="<?php echo remove_junk($product['min']);?>">
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="qty">Max Quantity</label>
								<div class="input-group">
									<input type="number" class="form-control" name="max" value="<?php echo remove_junk($product['max']);?>">
								</div>
							</div>
						</div>
				   </div>
				</div>
				
<!--     *************************  manufacturer and supplier   -->				
				
				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
							<label for="manufacturer">Manufacturer</label>
								<div class="input-group">
									<input type="text" class="form-control" name="manufacturer" value="<?php echo remove_junk($product['manufacturer']); ?>">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="qty">Manufacturer number</label>
								<div class="input-group">
									<input type="text" class="form-control" name="manufacturernumber" value="<?php echo remove_junk($product['manufacturernumber']);?>">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="qty">Supplier</label>
								<div class="input-group">
									<input type="text" class="form-control" name="supplier" value="<?php echo remove_junk($product['supplier']);?>">
								</div>
							</div>
						</div>
				   </div>
				</div>
				
<!--     ************************* Alternate manufacturer and supplier   -->				
				
				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
							<label for="manufacturer">Alternate Manufacturer</label>
								<div class="input-group">
									<input type="text" class="form-control" name="alt_manufacturer" value="<?php echo remove_junk($product['alt_manufacturer']); ?>">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="qty">Alternate Manufacturer number</label>
								<div class="input-group">
									<input type="text" class="form-control" name="alt_manufacturernumber" value="<?php echo remove_junk($product['alt_manufacturernumber']);?>">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="qty">Alternate Supplier</label>
								<div class="input-group">
									<input type="text" class="form-control" name="alt_supplier" value="<?php echo remove_junk($product['alt_supplier']);?>">
								</div>
							</div>
						</div>
				   </div>
				</div>
				
<!--     ************************* item_cost and crit  -->				
				
				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="item_cost">Item Cost</label>
								<div class="input-group">
									<input type="text" class="form-control" name="item_cost" value="<?php echo remove_junk($product['item_cost']);?>">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="crit">Critical Consumable</label>
								<select class="form-control" name="crit">
									<option value="">Select True or False</option>
									<option value=1>True</option>
									<option value=0>False</option>
								</select>
							</div>
						</div>
				   </div>
				</div>
				
<!--     ************************* notes   -->				
			
				<div class="form-group">
					<div class="row">
						<label for="qty">Notes</label>
						<div class="input-group">
							<input type="text" class="form-control" name="notes" value="<?php echo remove_junk($product['notes']);?>">
						</div>
					</div>
				</div>
              <button type="submit" name="product" class="btn btn-danger">Update</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
