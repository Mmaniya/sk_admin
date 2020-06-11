<?php
   require("includes.php");
   
   $file =basename(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH),".php"); 
   
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
      <title>Dashboard - BJP HOME</title>
      <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
      <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
      <link href="assets/css/custom.css" rel="stylesheet" type="text/css">
      <link href="assets/css/multiselectbootsrap.css" rel="stylesheet" type="text/css">
      <link href="assets/css/style.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
      <script src="assets/js/jquery.min.js"></script>	
      <script src="assets/js/modernizr.min.js"></script>        	
      <script src="assets/js/default.js"></script> 
      <link href='assets/autocomplete/jquery-ui.css' rel='stylesheet' type='text/css'>
      <script src='assets/autocomplete/jquery-ui.min.js' type='text/javascript'></script> 
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
      <script type="text/javascript" src="assets/autocomplete/jquery-ui.min.js"></script>
      <style>
         .scrollToTop {
         margin: 0 30px 20px 0;
         text-align: center;
         text-decoration: none;
         position: fixed;
         bottom: 0;
         right: 0;
         display: none;
         }
      </style>
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
               <a href="dashboard.php" class="logo"><i class="mdi mdi-radar"></i> <span>Bharatiya Janata Party</span></a>
            </div>
         </div>
         <!-- Button mobile view to collapse sidebar menu -->
         <nav class="navbar-custom">
            <ul class="list-inline float-right mb-0">
               <li class="list-inline-item notification-list hide-phone">
                  <a class="nav-link waves-light waves-effect" href="#" id="btn-fullscreen">
                  <i class="mdi mdi-crop-free noti-icon"></i>
                  </a>
               </li>
               <li class="list-inline-item dropdown notification-list">
                  <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                     aria-haspopup="false" aria-expanded="false">
                  <img src="assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle">
                  </a>
                  <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">
                     <!-- item-->
                     <div class="dropdown-item noti-title">
                        <h5 class="text-overflow"><small>Welcome <?php echo $_SESSION['name']; ?></small> </h5>
                     </div>
                     <!-- item-->
                     <a href="settings.php" class="dropdown-item notify-item">
                     <i class="mdi mdi-settings"></i> <span>Settings</span>
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
                     <a href="dashboard.php" class="waves-effect waves-primary">
                     <i class="ti-home"></i><span> Dashboard </span>
                     </a>
                  </li>
                  <li class="has_sub">
                     <a href="javascript:void(0);" class="waves-effect waves-primary">
                     <i class="fa fa-bell"></i> <span> Office Bearers </span>
                     <span class="menu-arrow"></span>
                     </a>
                     <ul class="list-unstyled">
                        <li> <a href="officebearers.php">Add New Office Bearers</a></li>
                        <!-- <li> <a href="officebearersview.php">Office Bearers List</a></li> -->
                        <li> <a href="officebearerstable.php">Office Bearers List</a></li>
                     </ul>
                  </li>
                  <li class="has_sub">
                     <a href="javascript:void(0);" class="waves-effect waves-primary">
                     <i class="ti-settings"></i> <span> Settings </span>
                     <span class="menu-arrow"></span>
                     </a>
                     <ul class="list-unstyled">
                           <?php if ($_SESSION['user_id']  == '1'){ ?>
                            <li> <a href="addnewrole.php">BJP Role</a></li>  
                            <li>
                              <a href="district/index.php" class="waves-effect waves-primary">District</a>
                            </li>
                            <li>
                              <a href="mpconstant.php" class="waves-effect waves-primary">MP Constituency</a>
                            </li>
                            <li>
                              <a href="lgconstant.php" class="waves-effect waves-primary">LG Constituency</a>
                            </li>
                            <li>
                              <a href="mandal.php" class="waves-effect waves-primary">Mandal</a>
                            </li>
                            <li>
                              <a href="ward.php" class="waves-effect waves-primary">Ward</a>
                            </li>
                           <?php } ?>
                           <!-- <li> <a href="email_template.php">Email Template</a></li> -->
                           <!-- <li><a href="district/adddistrict.php">Add District</a></li> -->
                     </ul>
                  </li>
                     <!-- <li>
                        <a href="district.php" class="waves-effect waves-primary">
                        <i class="fa fa-map-marker "></i><span>District</span>
                        </a>
                     </li> -->
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
         <footer class="footer"><?php echo date('Y'); ?> ©  BJP.com <span style="float:right; cursor:pointer" class="scrollToTop">Top <i class="fas fa-arrow-up" style="color:#039CFD; font-size:14px"></i></span></footer>
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
      <script src="assets/js/multiselectdropdown.js"></script>
         <!-- Custom main Js -->
      <script src="assets/js/jquery.core.js"></script>
      <script src="assets/js/jquery.app.js"></script>  
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script> var resizefunc = []; </script>
      <Script>
         $(document).ready(function($) {
         
         var visible = false;
         //Check to see if the window is top if not then display button
         $(window).scroll(function() {
          var scrollTop = $(this).scrollTop();
          if (!visible && scrollTop > 100) {
            $(".scrollToTop").fadeIn();
            visible = true;
          } else if (visible && scrollTop <= 100) {
            $(".scrollToTop").fadeOut();
            visible = false;
          }
         });
         
         //Click event to scroll to top
         $(".scrollToTop").click(function() {
          $("html, body").animate({
            scrollTop: 0
          }, 800);
          return false;
         });
         
         });
         
         function viewLogs(id,type)
         {
             paramData = {'act':'show_log','id':id,'type':type};
             ajax({
                 a:'invoiceStatus',
                 b:$.param(paramData),
                 c:function(){},
                 d:function(data){
                     $('.right_bar_div').html(data);
                     ajax({
                         a:'process',
                         b:$.param(paramData),
                         c:function(){},
                         d:function(data){
                             //alert(data);
                             $('.log_div').html(data);
                             $('.accordion').accordion();
                         }
                     });
                     $('#logs_modal').modal('show');
                 }});
         }
      </script>
   </body>
</html>