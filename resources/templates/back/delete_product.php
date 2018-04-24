<?php 

require_once("../../config.php");
if (isset($_GET['id'])) {
	$id = escape_string($_GET['id']);
	$query = query("DELETE FROM products WHERE product_id ='$id'");
	confirm($query);
	set_message("Product is Deleted");
	redirect("../../../public/admin/index.php?products");
}else{
   redirect("../../../public/admin/index.php?products");
}


?>