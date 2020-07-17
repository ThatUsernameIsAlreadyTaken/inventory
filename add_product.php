<?php
  $page_title = 'Add Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);

  $all_categories = find_all('categories');
  $all_photo = find_all('media');

?>


<?php
 if(isset($_POST['add_product'])){
   $req_fields = array('product-title','product-category','product-quantity','product-min','product-max','gpc_number','crit','manufacturer','manufacturernumber','supplier','item_cost' );
   validate_fields($req_fields);
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['product-title']));
     $p_desc  = remove_junk($db->escape($_POST['product-desc']));
     $p_loc  = remove_junk($db->escape($_POST['product-location']));
     $p_cat   = remove_junk($db->escape($_POST['product-category']));
     $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
     $p_min   = remove_junk($db->escape($_POST['product-min']));
     $p_max   = remove_junk($db->escape($_POST['product-max']));
     $p_gpc_number   = remove_junk($db->escape($_POST['gpc_number']));
     $p_crit  = remove_junk($db->escape($_POST['crit']));
     $p_manu  = remove_junk($db->escape($_POST['manufacturer']));
     $p_manunum  = remove_junk($db->escape($_POST['manufacturernumber']));
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
     $date    = make_date();
     $query  = "INSERT INTO products (";
     $query .=" name,description,location,quantity,min,max,gpc_number,category_id,media_id,date,manufacturer,manufacturernumber,supplier,alt_manufacturer,alt_manufacturernumber,alt_supplier,notes,item_cost,crit,line,machine";
     $query .=") VALUES (";
     $query .=" '{$p_name}', '{$p_desc}', '{$p_loc}', '{$p_qty}', '{$p_min}', '{$p_max}', '{$p_gpc_number}', '{$p_cat}', '{$media_id}', '{$date}', '{$p_manu}', '{$p_manunum}', '{$p_supplier}', '{$p_alt_manu}', '{$p_alt_manunum}', '{$p_alt_supplier}', '{$p_notes}', '{$p_item_cost}', '{$p_crit}', '{$p_line}', '{$p_machine}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
     if($db->query($query))
     {

   $product = last_id("products");
   $product_id = $product['id'];
	if ( $product_id == 0 )
	{
       $session->msg('d',' Sorry failed to added!');
       redirect('add_product.php', false);
   }

	$quantity = $p_qty;
       $cost = $p_buy;
  $comments = "initial stock";

      $sql  = "INSERT INTO stock (product_id,quantity,comments,date)";
      $sql .= " VALUES ('{$product_id}','{$quantity}','{$comments}','{$date}')";
          $result = $db->query($sql);
          if( $result && $db->affected_rows() === 1)
          {
       $session->msg('s',"Product added ");
       redirect('products.php', false);
   }
     } else {
       $session->msg('d',' Sorry failed to added!');
       redirect('add_product.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_product.php',false);
   }

 }

?>


<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<!--     *************************     -->
  <div class="row">
  <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
<!--     *************************     -->
            <span>Add New Product</span>
<!--     *************************     -->
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-16">
<!--     *************************     -->
          <form method="post" action="add_product.php" class="clearfix">
<!--     *************************     -->
              <div class="form-group">
                <div class="row">
<!--     *************************     -->
                  <div class="col-md-6">
                    <select class="form-control" name="product-category">
                      <option value="">Select Product Category</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="product-photo">
                      <option value="">Select Product Photo</option>
                    <?php  foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>">
                        <?php echo $photo['file_name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" placeholder="Product Title">
               </div>
              </div>


<!--     *************************  description  -->

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-desc" placeholder="Product Description">
               </div>
              </div>

<!--     *************************   bin location  -->

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-location" placeholder="Product Location">
               </div>
              </div>


<!--     *************************   Part number and crit  -->

            <div class="form-group">
                <div class="row">
					<div class="col-md-4">
						<div class="input-group">
							<span class="input-group-addon">
								<i>Critical Consumable?</i>
							</span>
							<input type="radio" class="form-control" name="crit" value=0>
							<label for=0>False</label>
							<input type="radio" class="form-control" name="crit" value=1>
							<label for=1>True</label>

						</div>
					</div>

                  <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                        <i>GPC P/N</i>
                     </span>
                     <input type="number" min="0" class="form-control" name="gpc_number" placeholder="GPC P/N">
                  </div>
                 </div>
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                        <i>Item Cost</i>
                     </span>
                     <input type="number" min="0" step="any" class="form-control" name="item_cost" placeholder="Item Cost">
                  </div>
                 </div>
               </div>
            </div>

<!--     *************************   Manufacturer information  -->

             <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Manufacturer</i>
                      </span>
                      <input type="text" min="0" class="form-control" name="manufacturer" placeholder="Manufacturer">
                   </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Manufacturer P/N</i>
                      </span>
                      <input type="text" class="form-control" name="manufacturernumber" placeholder="Manufacturer P/N">
                   </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Supplier</i>
                      </span>
                      <input type="text" class="form-control" name="supplier" placeholder="Supplier">
                   </div>
                  </div>
                 </div>
                </div>

 <!--     *************************  Alternate Manufacturer information  -->

                <div class="form-group">
                 <div class="row">
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Alt Manufacturer</i>
                      </span>
                      <input type="text" min="0" class="form-control" name="alt_manufacturer" placeholder="Alt Manufacturer">
                   </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Alt Manufacturer P/N</i>
                      </span>
                      <input type="text" class="form-control" name="alt_manufacturernumber" placeholder="Alt Manufacturer P/N">
                   </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Alt Supplier</i>
                      </span>
                      <input type="text" class="form-control" name="alt_supplier" placeholder="Alt Supplier">
                   </div>
                  </div>
                </div>
             </div>

<!--     *************************   Machine and Line  -->

            <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                        <i>Machine</i>
                     </span>
                     <input type="text" class="form-control" name="machine" placeholder="Machine">
                  </div>
                 </div>

                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Line</i>
                      </span>
                      <input type="text" class="form-control" name="line" placeholder="Line">
                   </div>
                  </div>
                </div>
             </div>

<!--     *************************  start of quantities   -->

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="product-quantity" placeholder="Product Quantity">
                  </div>
                 </div>

                 <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Min</i>
                      </span>
                      <input type="number" min="0" class="form-control" name="product-min" placeholder="Min">
                   </div>
                  </div>

                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i>Max</i>
                      </span>
                      <input type="number" min="0" class="form-control" name="product-max" placeholder="Max">
                   </div>
                  </div>
                </div>
               </div>

                <div class="form-group">
                    <div class="row">
                        <span class="input-group-addon">
                            <i>Notes</i>
                        </span>
                        <input type="text" class="form-control" name="notes" placeholder="Add Note">
                    </div>
                </div>

<!--     *************************  end of form    -->
         <div class="pull-right">
              <button type="submit" name="add_product" class="btn btn-danger">Add product</button>
         </div>

<!--     *************************     -->
          </form>

         </div>
        </div>
      </div>
<?php
//$product = last_id("products");
//$product_id = $product['id'];
//echo "product_id: " . $product_id;
?>

    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
