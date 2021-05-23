<?php
include("admin/inc/config.php");

$name = strtolower($_GET["q"]);
$p_name= "%".$name."%";
if (!$name) return;

$statement = $pdo->prepare("SELECT p_id as id, p_name as name, concat('assets/uploads/',p_featured_photo) as image, format(p_current_price,0) as price FROM tbl_product WHERE p_name like ?");
$statement->execute(array($p_name));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
	
	$products[]=$row;
	
}


print json_encode($products);
?>