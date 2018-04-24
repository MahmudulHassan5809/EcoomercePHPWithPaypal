<?php require_once '../../resources/config.php'; ?>

<?php include(TEMPLATE_BACK.DS."header.php"); ?>


        <div id="page-wrapper">

            <div class="container-fluid">



                    <div class="col-lg-12">
                      

                        <h1 class="page-header">
                            Users
                         
                        </h1>
                          <p class="bg-success">
                            <?php display_message() ;?>
                        </p>

                        <a href="index.php?add_user" class="btn btn-primary">Add User</a>


                        <div class="col-md-12">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        
                                        <th>Username</th>
                                        <th>Email</th>
                                       
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                               

                                    
                              <?php display_users(); ?>

                             


                                    
                                    
                                </tbody>
                            </table> <!--End of Table-->
                        

                        </div>










                        
                    </div>
    












            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include(TEMPLATE_BACK.DS."footer.php"); ?>
