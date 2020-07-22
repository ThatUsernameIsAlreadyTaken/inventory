<title>CSV Upload</title>

<?php
	require_once('includes/load.php');
	page_require_level(1);
	if(isset($_POST["Import"])){
		$filename=$_FILES["file"]["tmp_name"];    
		if($_FILES["file"]["size"] > 0)
		{
			echo "starting";
			$file = fopen($filename, "r");
			while (($getData = fgetcsv($file, 1000, ",")) !== FALSE)
			{
				$p_cat = 87;
				$p_date = make_date();
				$sql  = "INSERT into products(name,description,location,quantity,min,max,gpc_number,category_id,date,manufacturer,manufacturernumber,supplier,crit)";
				$sql .= " values ('".$getData[0]."','".$getData[1]."','".$getData[2]."',".$getData[3].",".$getData[4].",".$getData[5].",'".$getData[6]."','{$p_cat}','{$p_date}','".$getData[7]."','".$getData[8]."','".$getData[9]."','".$getData[10]."')";				
				if($db->query($sql))
				{
					echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"products.php\"
						</script>";    
				}
				else {
					echo "<script type=\"text/javascript\">
						alert(\"I dont understand whats going on here.\");
						window.location = \"products.php\"
						</script>";
				}
			}
			fclose($file);
		}
		else {
			echo "nothing worked";
		}
	}
?>