<?php 
 
 function redirect($location){
 	header("Location: $location");
 }

function query($sql){
	global $connection;

	return mysqli_query($connection,$sql);
}

function confirm($result){
	global $connection;
	if (!$result) {
		die("QUERY FAILED".mysqli_error($connection));
	}
}

function escape_string($string){
	global $connection;
	
	return mysqli_real_escape_string($connection,$string);
	
}


function fetch_array($send_query){
	global $connection;
	
	return mysqli_fetch_array($send_query);
	
}

function textShorten($text, $limit = 400){
      $text = $text. " ";
      $text = substr($text, 0, $limit);
      $text = substr($text, 0, strrpos($text, ' '));
      $text = $text.".....";
      return $text;
     }

$textShorten = 'textShorten';

function set_message($msg){
   if (!empty($msg)) {
   	  $_SESSION['msg'] = $msg; 
   	}else{
   		$msg = "";
   	}
}

function display_message(){
	if (isset($_SESSION['msg'])) {
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
}


function last_id(){
	global $connection;
	$last_id = mysqli_insert_id($connection);
	return $last_id;
}



//Fornt End Functions

//get Products

function get_products(){
	$query = query("SELECT * FROM products");
	confirm($query);
	while ($row = fetch_array($query)) {
		$product_image = display_image($row['product_image']);
		$product = <<<DELIMETER
          
      <div class="col-sm-4 col-lg-4 col-md-4">
        <div class="thumbnail">
            <a href="item.php?id={$row['product_id']}"><img src="../resources/{$product_image}" alt=""></a>
            <div class="caption">
                <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                </h4>
                <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add To Cart</a>
            </div>
            
        </div>
    </div>
DELIMETER;
 echo $product;

	}
	

}

//get categories
function get_categories(){

	$query = query("SELECT * FROM categories");
	confirm($query);
	    
	while ($row = mysqli_fetch_array($query)) {
	  echo	"<a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>";
	}
}

//get category products

function get_category_products(){
	global $textShorten;
	$query = query("SELECT * FROM products WHERE product_cat_id = " . escape_string($_GET['id']). " ");
	confirm($query);
	while ($row = fetch_array($query)) {
		$product_image = display_image($row['product_image']);
		$category_product = <<<DELIMETER

          
<div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
        <img src="../resources/{$product_image}" alt="">
        <div class="caption">
            <h3>{$row['product_title']}</h3>
            <p>{$textShorten($row['short_desc'],50)}</p>
            <p>
                <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
            </p>
        </div>
    </div>
</div>
DELIMETER;

echo $category_product;
	}
}

//Shop Page

function get_shop_products(){
	global $textShorten;
	$query = query("SELECT * FROM products");
	confirm($query);
	while ($row = fetch_array($query)) {
		$product_image = display_image($row['product_image']);
		$category_product = <<<DELIMETER
          
<div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
        <img src="../resources/{$product_image}" alt="">
        <div class="caption">
            <h3>{$row['product_title']}</h3>
            <p>{$textShorten($row['short_desc'],50)}</p>
            <p>
                <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
            </p>
        </div>
    </div>
</div>
DELIMETER;

echo $category_product;
	}
}


//Login Functions

function login_user(){
	if (isset($_POST['submit'])) {
		$username = escape_string($_POST['user_name']);
		$userpass = escape_string($_POST['user_pass']);
		$query = query("SELECT * FROM users WHERE user_name= '$username' AND user_pass='$userpass'");
		confirm($query);
		if (mysqli_num_rows($query) == 0) {
			set_message("Your or Password is Wrong!..");
			redirect("login.php");
		}else{
			$_SESSION['username'] = $username;
			$_SESSION['login']  = true;
			redirect("admin");
		}

	}
}

//Send Message contact Page

function send_message(){
	if (isset($_POST['submit'])) {
		$to = "mahmudul.hassan240@gmail.com";
        $name = escape_string($_POST['name']);
		$email = escape_string($_POST['email']);
		$subject = escape_string($_POST['subject']);
		$message = escape_string($_POST['message']);

		$headres = "From: {$name} {$email}";

		$result = mail($to,$subject,$message,$headres);

		if (!$result) {
			echo "Error";
		}else{
			echo "Sent";
		}

	}
}






//end fornt end functions

//Back End Functions 

//display orders in admin
function display_orders(){
	$query = query("SELECT * FROM orders");
	confirm($query);
	while ($row = fetch_array($query)) {
		$ordrs = <<<DELIMETER
           <tr>
           <td>{$row['order_id']}</td>
            <td>{$row['order_amount']}</td>
			<td>{$row['order_transaction']}</td>
            <td>{$row['order_currency']}</td>
            <td>{$row['order_status']}</td>
            <td><a href="../../resources/templates/back/delete_order.php?id={$row['order_id']}" class="glyphicon glyphicon-remove btn btn-danger"><a></td>
           </tr>

DELIMETER;

echo $ordrs;
	}
}

//display products in admin

function display_products(){
	$query = query("SELECT * FROM products");
	confirm($query);
	while ($row = fetch_array($query)) {
		$category = show_product_category_title($row['product_cat_id']);
		$product_image = display_image($row['product_image']);
		$products = <<<DELIMETER
          <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']}<br>
              <img src="../../resources/{$product_image}" width="100px" alt="">
            </td>
            <td>{$category}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td>
              <a href="index.php?edit_product&id={$row['product_id']}" class="glyphicon glyphicon-pencil btn btn-success">Edit<a>
              <a href="../../resources/templates/back/delete_product.php?id={$row['product_id']}" class="glyphicon glyphicon-remove btn btn-danger"><a>

            </td>
        </tr>

DELIMETER;

echo $products;
	}
}

//add product in admin 

function add_products(){
	if (isset($_POST['publish'])) {

		$product_title = escape_string($_POST['product_title']);
		$product_cat_id = escape_string($_POST['product_cat_id']);
		$product_price = escape_string($_POST['product_price']);
		$product_description = escape_string($_POST['product_description']);
		$short_desc = escape_string($_POST['short_desc']);
		$product_quantity = escape_string($_POST['product_quantity']);

		$product_image = $_FILES['file']['name'];
		$image_temp_location = $_FILES['file']['tmp_name'];

		move_uploaded_file($image_temp_location,UPLOAD_PATH.DS.$product_image);

		$query = query("INSERT INTO products 
			          (product_title,product_cat_id,product_price,product_quantity,product_description,
			          short_desc,product_image) 
                      VALUES('$product_title','$product_cat_id','$product_price','$product_quantity',
                            '$product_description','$short_desc','$product_image')");
		
		$last_id = last_id();
		confirm($query);
		set_message("New Product With id '$last_id' Was Added");
		redirect("index.php?products");


	}
}

//show categories in admin

function get_categories_add_product(){

	$query = query("SELECT * FROM categories");
	confirm($query);
	    
	while ($row = mysqli_fetch_array($query)) {
	  echo	"<option value='{$row['cat_id']}'>{$row['cat_title']}</option>";
	}
}


//show product category title

function show_product_category_title($product_cat_id){
	$query = query("SELECT * FROM categories where cat_id = '$product_cat_id'");
	confirm($query);
	while ($row = fetch_array($query)) {
		return $row['cat_title'];
	}
}

// display_image

function display_image($picture){
	return 'upload'. DS . $picture;
}


//edit products in admin

function update_products($id){
	if (isset($_POST['update'])) {
        $id = escape_string($id);
		$product_title = escape_string($_POST['product_title']);
		$product_cat_id = escape_string($_POST['product_cat_id']);
		$product_price = escape_string($_POST['product_price']);
		$product_description = escape_string($_POST['product_description']);
		$short_desc = escape_string($_POST['short_desc']);
		$product_quantity = escape_string($_POST['product_quantity']);

		$product_image = $_FILES['file']['name'];
		$image_temp_location = $_FILES['file']['tmp_name'];
        
        if (empty($product_image)) {
        	$query = query("UPDATE products 
			          SET 
			          product_title='$product_title',
                      product_cat_id='$product_cat_id',
                      product_price='$product_price',
                      product_description='$product_description',
                      short_desc='$short_desc',
                      product_quantity='$product_quantity'
                      
                      WHERE product_id = '$id'
			          ");
		
		
		confirm($query);
        }else{
		move_uploaded_file($image_temp_location,UPLOAD_PATH.DS.$product_image);
           
		$query = query("UPDATE products 
			          SET 
			          product_title='$product_title',
                      product_cat_id='$product_cat_id',
                      product_price='$product_price',
                      product_description='$product_description',
                      short_desc='$short_desc',
                      product_quantity='$product_quantity',
                      product_image='$product_image'
                      WHERE product_id = '$id'
			          ");
		
		
		confirm($query);
	}
		set_message("Product is Updated Successfully");
		redirect("index.php?products");


	}
}


//show categories 
function show_categories_in_admin()
{
  $query = query("SELECT * FROM categories");
  confirm($query);
  while ($row = fetch_array($query)) {
  	 $cat_id = $row['cat_id'];
  	 $cat_title = $row['cat_title'];

  	$category_display = <<<DELIMETER
      <tr>
        <td>{$cat_id}</td>
        <td>{$cat_title}</td>
        <td>
           <a href="../../resources/templates/back/edit_cat?id={$row['cat_id']}" class="glyphicon glyphicon-pencil btn btn-success">Edit<a>
            <a href="../../resources/templates/back/delete_cat.php?id={$row['cat_id']}" class="glyphicon glyphicon-remove btn btn-danger"><a>
        </td>
      </tr>
DELIMETER;
echo $category_display;
  }
}

//add category

function add_category(){
	if (isset($_POST['add_category'])) {
		$cat_title = escape_string($_POST['cat_title']);
		$query = query("INSERT INTO categories(cat_title) VALUES('$cat_title')");
		confirm($query);
		set_message("Category is Added");
		
	}
}

//admin users 

function display_users()
{
  $query = query("SELECT * FROM users");
  confirm($query);
  while ($row = fetch_array($query)) {
  	 $user_id = $row['user_id'];
  	 $user_name = $row['user_name'];
  	 $user_pass = $row['user_pass'];
  	 $user_email = $row['user_email'];

  	$user_display = <<<DELIMETER
      <tr>
        <td>{$user_id}</td>
        <td>{$user_name}</td>
       
        <td>{$user_email}</td>
        <td>
           <a href="../../resources/templates/back/edit_user.php?id={$row['user_id']}" class="glyphicon glyphicon-pencil btn btn-success">Edit<a>
            <a href="../../resources/templates/back/delete_user.php?id={$row['user_id']}" class="glyphicon glyphicon-remove btn btn-danger"><a>
        </td>
      </tr>
DELIMETER;
echo $user_display;
  }
}

function add_user() {


if(isset($_POST['add_user'])) {


$username   = escape_string($_POST['username']);
$email      = escape_string($_POST['email']);
$password   = escape_string($_POST['password']);
// $user_photo = escape_string($_FILES['file']['name']);
// $photo_temp = escape_string($_FILES['file']['tmp_name']);


// move_uploaded_file($photo_temp, UPLOAD_DIRECTORY . DS . $user_photo);


$query = query("INSERT INTO users(user_name,user_email,user_pass) VALUES('{$username}','{$email}','{$password}')");
confirm($query);

set_message("USER CREATED");

redirect("index.php?users");



}



}


function get_reports(){


$query = query(" SELECT * FROM reports");
confirm($query);

while($row = fetch_array($query)) {


$report = <<<DELIMETER

        <tr>
             <td>{$row['report_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['order_id']}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_title']}
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_report.php?id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

DELIMETER;

echo $report;


        }





}




?>