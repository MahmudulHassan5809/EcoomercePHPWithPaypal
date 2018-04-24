<?php require_once '../resources/config.php'; ?>

<?php include(TEMPLATE_FRONT.DS."header.php"); ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <h1>A Warm Welcome!</h1>
       </header>

        <hr>

        <!-- Title -->
      
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">

            <?php get_shop_products(); ?>

        </div>
        <!-- /.row -->

       

    </div>
    <!-- /.container -->

 <?php include(TEMPLATE_FRONT.DS."footer.php"); ?>  