<?php
 require("includes.php");

 if($_SESSION['user_id']=='') {
	header('location: index.php');
	exit();	
 }
  

 ?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <title>Dashboard - Bizplan Easy</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="assets/js/jquery.min.js"></script>	
        <script src="assets/js/modernizr.min.js"></script>        	
        <script src="assets/js/default.js"></script>     
		
		<link rel="stylesheet" href="assets/autocomplete/jquery-ui.css">
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
		<script type="text/javascript" src="assets/autocomplete/jquery-ui.min.js"></script>
	  
    </head>
    <body class="fixed-left">   
<div class="modal-popup"></div>    
        <!-- Begin page -->
        <div id="wrapper">
            <!-- Top Bar Start -->
            <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="e_dashboard.php" class="logo"><i class="mdi mdi-radar"></i> <span>Bizplan Easy</span></a>
                    </div>
                </div>
                <!-- Button mobile view to collapse sidebar menu -->
                <nav class="navbar-custom">
                    <ul class="list-inline float-right mb-0">
                        <!--<li class="list-inline-item notification-list hide-phone">
                            <a class="nav-link waves-light waves-effect" href="#" id="btn-fullscreen">
                                <i class="mdi mdi-crop-free noti-icon"></i>
                            </a>
                        </li>-->
 

                        <li class="list-inline-item dropdown notification-list">
                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <!--<img src="assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle">-->
								<p>My Account</p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="text-overflow"><small>Welcome <?php echo $_SESSION['name']; ?></small> </h5>
                                </div>
 
                                <!-- item-->
                                <a href="e_update_profile.php" class="dropdown-item notify-item">
                                    <i class="mdi mdi-settings"></i> <span>Profile</span>
                                </a>
								 
								
								 <a href="logout.php" class="dropdown-item notify-item"><i class="mdi mdi-logout"></i> <span>Logout</span></a>

                            </div>
                        </li>

                    </ul>

                    <ul class="list-inline menu-left mb-0">
                        <li class="float-left">
                            <button class="button-menu-mobile open-left waves-light waves-effect">
                                <i class="mdi mdi-menu"></i>
                            </button>
                        </li>
                         
                    </ul>

                </nav>

            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title">Main</li>

                            <li>
                                <a href="e_dashboard.php" class="waves-effect waves-primary">
                                    <i class="ti-home"></i><span> Dashboard </span>
                                </a>
                            </li>
							<li>
                                <a href="invoiceStatus.php" class="waves-effect waves-primary">
                                <i class="fas fa-tasks"></i><span><strong> Process Tracking </strong></span>
                                </a>
                            </li>
                            <li>
                                <a href="assigned_jobs.php" class="waves-effect waves-primary">
                                    <i class="ti-receipt"></i><span> Assigned Jobs </span>
                                </a>
                            </li>
							<li>
                                <a href="e_update_profile.php" class="waves-effect waves-primary">
                                    <i class="ti-user"></i><span> Profile </span>
                                </a>
                            </li> 
                        </ul>


                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        <div class="content-page">                 
                <div class="content">
                    <div class="container-fluid">
         <?php main(); ?>
		   </div> 
		      </div>               
          <footer class="footer"><?php echo date('Y'); ?> ©  Bizplaneasy.com </footer>
            </div> 
         

        <!-- Plugins  -->   		 
		<script src="assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/detect.js"></script>
		<script src="assets/js/fastclick.js"></script>
		<script src="assets/js/jquery.slimscroll.js"></script>
		<script src="assets/js/jquery.blockUI.js"></script>
		<script src="assets/js/waves.js"></script>
		<script src="assets/js/wow.min.js"></script>
		<script src="assets/js/jquery.nicescroll.js"></script>
		<script src="assets/js/jquery.scrollTo.min.js"></script>
        <!--<script src="assets/pages/jquery.dashboard.js"></script> 
        <!-- Custom main Js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>  
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 
<script> var resizefunc = []; </script>

    </body>
</html>
