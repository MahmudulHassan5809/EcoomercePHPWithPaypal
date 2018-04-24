<?php 

require_once("../../config.php");
if (isset($_GET['id'])) {
	$id = escape_string($_GET['id']);
	$query = query("DELETE FROM categories WHERE cat_id ='$id'");
	confirm($query);
	set_message("Category is Deleted");
	redirect("../../../public/admin/index.php?categories");
}else{
   redirect("../../../public/admin/index.php?categories");
}


?>