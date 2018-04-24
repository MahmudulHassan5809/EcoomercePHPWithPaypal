<?php require_once '../resources/config.php'; ?>

<?php
if (isset($_GET['add'])) {

	$query = query("SELECT * FROM products WHERE product_id = " . escape_string($_GET['add']). " ");
	confirm($query);
	while ($row = fetch_array($query)) {
		if ($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]) {
			$_SESSION['product_' . $_GET['add']] +=1;
			redirect("checkout.php");
		}else{
			set_message("We Only Have ". $row['product_quantity'] . " " . "Available");
			redirect("checkout.php");
		}
	}
	// $_SESSION['product_' . $_GET['add']] +=1;
	// echo $_SESSION['product_' . $_GET['add']];
	//redirect("index.php");
}


if (isset($_GET['remove'])) {
	if($_SESSION['product_' . $_GET['remove']] > 0)
	{
		$_SESSION['product_' . $_GET['remove']]--;
		redirect("checkout.php");
    }
	else if($_SESSION['product_' . $_GET['remove']] < 0){
		
		set_message("Your Cant Decrement less than 1");
		redirect("checkout.php");
	}
}

if (isset($_GET['delete'])) {
   
   $_SESSION['product_' . $_GET['delete']] = '0';
   unset($_SESSION['item_total']);
   unset($_SESSION['total_quantity']);
   redirect("checkout.php");


}	


function cart(){
    $total = 0;
    $item_total = 0;
    foreach ($_SESSION as $name => $value) {
    if($value > 0){ 
    if (substr($name, 0 , 8) == 'product_'){
    $length = strlen(strlen($name) - 8);
    $id = substr($name, 8 , $length);
    $id = escape_string($id);
    $query = query("SELECT * FROM products WHERE product_id = '$id'");
	confirm($query);
	while ($row = fetch_array($query)) {
		$sub = $row['product_price'] * $value;
		$item_total += $value;
		$product = <<<DELIMETER
	<tr>
        <td>{$row['product_title']}</td>
        <td>&#36;{$row['product_price']}</td>
        <td>{$value}</td>
        <td>&#36;{$sub}</td>
        <td>
     <a class="btn btn-success" href="cart.php?add={$row['product_id']}"><span class="glyphicon glyphicon-plus"></span></a>
     <a class='btn btn-warning' href="cart.php?remove={$row['product_id']}"><span class='glyphicon glyphicon-minus'></span></a>
     <a class='btn btn-danger' href='cart.php?delete={$row['product_id']}'><span class='glyphicon glyphicon-remove'></a>
        </td>
    </tr>
DELIMETER;
      echo $product;
      $total = $total + $sub;

     }
     $_SESSION['item_total'] = $total;
     $_SESSION['total_quantity'] = $item_total;
    }

  }

 }
}







?>