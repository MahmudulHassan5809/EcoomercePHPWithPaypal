<?php require_once '../../resources/config.php'; ?>

<?php include(TEMPLATE_BACK.DS."header.php"); ?>
<?php
if (!isset($_SESSION['login']) &&($_SESSION['login'] != true)) {
      redirect("../../public");
}





?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
              
                <!-- /.row -->

                 <!-- FIRST ROW WITH PANELS -->
               <?php 
                if (($_SERVER['REQUEST_URI'] == "/EcommerceDiaz/public/admin/")  or ($_SERVER['REQUEST_URI'] == "/EcommerceDiaz/public/admin/index.php") ) {
                   include(TEMPLATE_BACK.DS."admin_content.php");
                }
                if (isset($_GET['orders'])) {
                   include(TEMPLATE_BACK.DS."orders.php");
                }
                if (isset($_GET['products'])) {
                   include(TEMPLATE_BACK.DS."products.php");
                }
                if (isset($_GET['add_products'])) {
                   include(TEMPLATE_BACK.DS."add_product.php");
                }
                if (isset($_GET['categories'])) {
                   include(TEMPLATE_BACK.DS."categories.php");
                }
                if (isset($_GET['edit_product'])) {
                   include(TEMPLATE_BACK.DS."edit_product.php");
                }
                if (isset($_GET['users'])) {
                   include(TEMPLATE_BACK.DS."users.php");
                }
                if (isset($_GET['add_user'])) {
                   include(TEMPLATE_BACK.DS."add_user.php");
                }
                if (isset($_GET['reports'])) {
                   include(TEMPLATE_BACK.DS."reports.php");
                }
                


               ?>
                <!-- /.row -->
              

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    
<?php include(TEMPLATE_BACK.DS."footer.php"); ?>