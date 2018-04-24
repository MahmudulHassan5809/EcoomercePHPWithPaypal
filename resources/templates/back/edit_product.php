<?php 

if (isset($_GET['id'])) {
  $id = escape_string($_GET['id']);
  $query = query("SELECT * FROM products WHERE product_id='$id'");
  confirm($query);
  while ($row = fetch_array($query)) {
    
    $product_title = $row['product_title'];
    $product_cat_id = $row['product_cat_id'];
    $product_price = $row['product_price'];
    $product_description = $row['product_description'];
    $short_desc = $row['short_desc'];
    $product_quantity = $row['product_quantity'];
    $product_image = $row['product_image'];
  }

  update_products($id); 
}


?>

<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Edit Product

</h1>
<h3 class="text-center bg-success"><?php display_message(); ?></h3>
</div>
               


<form action="" method="post" enctype="multipart/form-data">
 

<div class="col-md-8">

<div class="form-group">
    <label for="product-title">Product Title </label>
        <input type="text" name="product_title" value="<?php echo $product_title; ?>" class="form-control">
       
    </div>


    <div class="form-group">
           <label for="product-title">Product Description</label>
      <textarea name="product_description" id=""  cols="30" rows="10" class="form-control">
        <?php echo $product_description; ?>
      </textarea>
    </div>



    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-price">Product Price</label>
        <input type="number" name="product_price" value="<?php echo $product_price; ?>" class="form-control" size="60">
      </div>
    </div>


   <div class="form-group">
           <label for="product-title">Short Description</label>
      <textarea name="short_desc" id="" cols="30" rows="3" class="form-control">
        
        <?php echo $short_desc; ?>

      </textarea>
    </div>

    
     

</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">

     
     <div class="form-group">
       <input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">
        <input type="submit" name="update" class="btn btn-primary btn-lg" value="Update">
    </div>


     <!-- Product Categories-->

    <div class="form-group">
         <label for="product-title">Product Category</label>
         
        <select name="product_cat_id" id="" class="form-control">
            <option value="<?php echo $product_cat_id ; ?>"><?php echo show_product_category_title($product_cat_id); ?></option>
            <?php get_categories_add_product(); ?>
           
        </select>


</div>





    <!-- Product Brands-->


    <div class="form-group">
      <label for="product-title">Product Quantity</label>
        <input type="number" name="product_quantity" value="<?php echo $product_quantity; ?>" class="form-control">
    </div>


<!-- Product Tags -->


    <!-- <div class="form-group">
          <label for="product-title">Product Keywords</label>
          <hr>
        <input type="text" name="product_tags" class="form-control">
    </div> -->

    <!-- Product Image -->
    <div class="form-group">
        <label for="product-title">Product Image</label>
        <input type="file" name="file"><br>
        <img src="../../resources/<?php echo display_image($product_image); ?>" width="100px" alt="">
      
    </div>



</aside><!--SIDEBAR-->


    
</form>



