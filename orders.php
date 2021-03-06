<?php
  $page_title = 'All Sign Outs';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  
  $all_orders = find_all('checkout')
?>

<!--     *************************     -->


<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
  </div>

    <div class="col-md-9">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
<!--     *************************     -->
          <span>All Sign Outs</span>
<!--     *************************     -->
       </strong>
          <div class="pull-right">
            <a href="add_order.php" class="btn btn-primary">Go To Sign Out</a>
          </div>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th class="text-center" style="width: 50px;">Employee</th>
                    <th class="text-center" style="width: 50px;">Item number</th>
                    <th class="text-center" style="width: 50px;">Qty. Taken</th>
                    <th class="text-center" style="width: 50px;">Date</th>
                    <th class="text-center" style="width: 100px;">Reason</th>
					<th class="text-center" style="width: 100px;">Line</th>
					<th class="text-center" style="width: 100px;">Machine</th>
					<th class="text-center" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
<!--     *************************     -->
              <?php foreach ($all_orders as $checkout):?>
                <tr>
                    <td class="text-center">
					<a href="sales_by_order.php?id=<?php echo (int)$checkout['id'];?>">
					<?php echo $checkout['id'];?>
					</a>	
					</td>
                    <td class="text-center">
						<?php echo remove_junk(ucfirst($checkout['employee']));?>
					</td>
                    <td class="text-center">
						<?php echo remove_junk(ucfirst($checkout['item']));?>
					</td>
                    <td class="text-center">
						<?php echo remove_junk(ucfirst($checkout['q_taken']));?>
					</td>

                    <td class="text-center">
						<?php echo remove_junk(ucfirst($checkout['date']));?>
					</td>

                    <td class="text-center">
						<?php echo remove_junk(ucfirst($checkout['reason']));?>
					</td>
					
					<td class="text-center">
						<?php echo remove_junk(ucfirst($checkout['line']));?>
					</td>
					
					<td class="text-center">
						<?php echo remove_junk(ucfirst($checkout['machine']));?>
					</td>

                    <td class="text-center">
                      <div class="btn-group">
                        <a href="edit_order.php?id=<?php echo (int)$checkout['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a href="delete_order.php?id=<?php echo (int)$checkout['id'];?>" onClick="return confirm('Are you sure you want to delete?')" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                          <span class="glyphicon glyphicon-trash"></span>
                        </a>
                      </div>
                    </td>

                </tr>
              <?php endforeach; ?>
<!--     *************************     -->
            </tbody>
          </table>
       </div>
    </div>

<?php
/**
	print "<pre>";
	print_r($all_orders);
	print "</pre>\n";
**/
?>


    </div>
   </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
