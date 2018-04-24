<?php require_once 'config.php'; ?>

<?php
if (isset($_GET['add'])) {

	$query = query("SELECT * FROM products WHERE product_id = " . escape_string($_GET['add']). " ");
	confirm($query);
	while ($row = fetch_array($query)) {
		if ($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]) {
			$_SESSION['product_' . $_GET['add']] +=1;
			redirect("../public/checkout.php");
		}else{
			set_message("We Only Have ". $row['product_quantity'] . " " . "Available");
			redirect("../public/checkout.php");
		}
	}
	
}


if (isset($_GET['remove'])) {

	$_SESSION['product_' . $_GET['remove']]--;
	if($_SESSION['product_' . $_GET['remove']] < 1)
	{
		redirect("checkout.php");
		set_message("Your Cant Decrement less than 1");
		unset($_SESSION['item_total']);
        unset($_SESSION['total_quantity']);
        
		
    }
    redirect("../public/checkout.php");
	
}

if (isset($_GET['delete'])) {
   
   $_SESSION['product_' . $_GET['delete']] = '0';
   unset($_SESSION['item_total']);
   unset($_SESSION['total_quantity']);
   redirect("../public/checkout.php");


}	


function cart(){
    
    $total = 0;
    $item_total = 0;
    //paypal variable
    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $quantity = 1;
    //End Paypal Variable
    foreach ($_SESSION as $name => $value) {
    if($value > 0){ 
    if (substr($name, 0 , 8) == 'product_'){
    // $length = strlen(strlen($name) - 8);
    // $id = substr($name, 8 , $length);
    $myArray = explode('_', $name);
    
    $id = escape_string($myArray[1]);
    $query = query("SELECT * FROM products WHERE product_id = '$id'");
	$confirm = confirm($query);
	
	while ($row = fetch_array($query)) {
		$sub = $row['product_price'] * $value;
		$item_total += $value;
    $product_image = display_image($row['product_image']);
		$product = <<<DELIMETER
	<tr>
        <td>{$row['product_title']}<br>

        <img src="../resources/{$product_image}" width="80px">

        </td>
        <td>&#36;{$row['product_price']}</td>
        <td>{$value}</td>
        <td>&#36;{$sub}</td>
        <td>
     <a class="btn btn-success" href="../resources/cart.php?add={$row['product_id']}"><span class="glyphicon glyphicon-plus"></span></a>
     <a class='btn btn-warning' href="../resources/cart.php?remove={$row['product_id']}"><span class='glyphicon glyphicon-minus'></span></a>
     <a class='btn btn-danger' href='../resources/cart.php?delete={$row['product_id']}'><span class='glyphicon glyphicon-remove'></a>
        </td>
    </tr>
  <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
  <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
  <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
  <input type="hidden" name="quantity_{$quantity}" value="{$value}">

DELIMETER;
      echo $product;
      $total = $total + $sub;
      //paypal
      $item_name++;
      $item_number++;
      $amount++;
      $quantity++;
      //end paypal
      
     }
     
     $_SESSION['item_total'] = $total;
     $_SESSION['total_quantity'] = $item_total;
    }
   
  }

 }
}


function show_paypal(){
  if (isset($_SESSION['total_quantity']) && ($_SESSION['total_quantity']) >=1) {
    
  
  $paypal_button = <<<DELIMETER
   
   <input type="image" name="upload"
    src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
    alt="PayPal - The safer, easier way to pay online">

DELIMETER;

return $paypal_button;
    }
}



function process_transaction(){
   
   if (isset($_GET['tx'])) {
   $amount = $_GET['amt'];
   $currency = $_GET['cc'];
   $tracsaction = $_GET['tx'];
   $status = $_GET['st'];
    
    $total = 0;
    $item_total = 0;
    
    foreach ($_SESSION as $name => $value) {
    if($value > 0){ 
    if (substr($name, 0 , 8) == 'product_'){
    $length = strlen(strlen($name) - 8);
    $id = substr($name, 8 , $length);
    $id = escape_string($id);
    
    $send_query = query("INSERT INTO orders (order_amount,order_transaction,order_status,order_currency) 
           VALUES('$amount','$tracsaction','$currency','$status')");
    $last_id = last_id(); 
    confirm($send_query);



    $query = query("SELECT * FROM products WHERE product_id = '$id'");
    $confirm = confirm($query);
  
  while ($row = fetch_array($query)) {
    $sub = $row['product_price'] * $value;
    $item_total += $value;
    $total = $total + $sub;
    $price = $row['product_price'];
    $product_title = $row['product_title'] ;

    
    $insert_reports = query("INSERT INTO reports (product_id,order_id,product_price,product_title,product_quantity ) 
           VALUES('$id','$last_id','$price','$product_title','$item_total')");
    confirm($insert_reports);

      
      }
       $item_total;
     
     }
   
   }

  }
   session_destroy();
 }
 else
{
  redirect("index.php");
}

 
}







?>