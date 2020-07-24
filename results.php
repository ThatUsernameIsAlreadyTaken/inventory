<?php
	$page_title = 'Search Results';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(1);

	$all_categories = find_all('categories');
	$all_products = find_all('products');
	$s_term = $_GET['id']
?>
<?php include_once('layouts/header.php'); ?>
<?php 
	foreach ($all_products as $product):
		$try1 = stristr($product['gpc_number'],$s_term);
		echo $try1;
		//echo $product[name];
		//echo ", ";
		//echo $product[gpc_number];
		//echo ", ";
		//echo $product[location];
		echo "</br>";
	endforeach;
?>