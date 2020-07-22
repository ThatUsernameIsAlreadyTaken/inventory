<?php
  $page_title = 'Item Check Out';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
  
  $all_orders = find_all('checkout');
  $order_id = last_id('checkout');
  $new_order_id = $order_id[id] + 1;

?>

<!--     *************************     -->

<?php
 if(isset($_POST['add_order'])){
	$req_fields = array( 'item','line','machine','reason','employee','q_taken');
   validate_fields($req_fields);
	$item = remove_junk($db->escape($_POST['item']));
	$line = remove_junk($db->escape($_POST['line']));
	$machine = remove_junk($db->escape($_POST['machine']));
	$reason = remove_junk($db->escape($_POST['reason']));
	$employee = remove_junk($db->escape($_POST['employee']));
	$q_taken = remove_junk($db->escape($_POST['q_taken']));
	$current_date    = make_date();
   if(empty($errors))
   {
      $sql  = "INSERT INTO checkout (item,line,machine,reason,date,employee,q_taken)";
      $sql .= " VALUES ('{$item}','{$line}','{$machine}','{$reason}','{$current_date}','{$employee}','{$q_taken}')";
      if($db->query($sql))
      {
        $session->msg("s", "Successfully Signed out item");
		$product = find_by_gpcnum("products", $item);
		$q_before = $product[quantity];
		$q_result = $q_before - $q_taken;
		$sql = "UPDATE products SET";
        $sql .= " quantity='{$q_result}'";
        $sql .= " WHERE id='{$product['id']}'";
		$result = $db->query($sql);
		redirect( 'add_order.php' , false);
      } else {
        $session->msg("d", "Sorry Failed to insert.");
	 redirect( 'add_order.php' , false);
      }
   } else {
     $session->msg("d", $errors);
	 redirect( 'add_order.php' , false);
   }
 }
/**
	print "<pre>";
	print_r($all_orders);
	print "</pre>\n";
**/

?>

<!--     *************************     -->

<?php include_once('layouts/header.php'); ?>


<div class="login-page">
    <div class="text-center">
<!--     *************************     -->
       <h2>Check Out Item</h3>
       <h3>#<?php echo $new_order_id;?></h3>
<!--     *************************     -->
     </div>
     <?php echo display_msg($msg); ?>

      <form method="post" action="" class="clearfix">
<!--     *************************     -->
        <div class="form-group">
        </div>
<!--     ************************* employee number   -->
        <div class="form-group">
              <label for="name" class="control-label">Employee Number</label>
              <input type="text" class="form-control" name="employee" placeholder="Employee Number">
        </div>
<!--     ************************* reason  -->
           <div class="form-group">
                    <select class="form-control" name="reason">
                      <option value="">Select Reason</option>
                      <option value="Down">Down</option>
                      <option value="PM">PM</option>
                      <option value="Misc">Misc</option>
                    </select>
           </div>
		   
			<div class="form-group">
				<input type="number" min="1" class="form-control" name="q_taken" placeholder="quantity taken">
			</div>
		   
<!--     ************************* line and machine-->
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
					   <input type="text" class="form-control" name="line" placeholder="line">
					</div>
					<div class="col-md-6">
					   <input type="text" class="form-control" name="machine" placeholder="machine">
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<input type="number" class="form-control" name="item" placeholder="GPC item number">
				</div>
			</div>

<!--     ************************* <div class="col-md-4">    -->
        <div class="form-group clearfix">
			<div class="row">
				<div class="pull-left">
					<button type="submit" name="add_order" class="btn btn-info">submit Item taken</button>
				</div>
			</div>
        </div>
    </form>
</div>

<?php include_once('layouts/footer.php'); ?>
