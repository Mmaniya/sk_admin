 <?php 
 function main() { 

  
  $invoiceObj = new Invoice();
  $statistics=$invoiceObj->getEmployeeInvoiceStatistics();
  $statistics=explode("::",$statistics);

  ?>
	<div class="row">
        <div class="col-sm-12">
        <div class="page-title-box">
        <h4 class="page-title">Welcome  <?php echo $_SESSION['name']; ?>!</h4>
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="clearfix"></div>
        </div>
        </div>
        </div>
        <div class="row pt-3">

        <div class="col-lg-4 col-xl-3">
        <div class="widget-bg-color-icon card-box">
        <div class="bg-icon bg-icon-success pull-left">
          <i class="fas fa-calendar-day"></i>
        </div>
        <div class="text-right">
            <h3 class="text-dark m-t-10"><b class="counter" style="cursor:pointer" onclick="showInvoices('today')" id="today_count"><?=$statistics[0]?></b></h3>
            <p class="text-muted mb-0">Today's Due</p>
        </div>
        <div class="clearfix"></div>
        </div>
        </div>
        
        <div class="col-lg-4 col-xl-3">
        <div class="widget-bg-color-icon card-box fadeInDown animated">
        <div class="bg-icon bg-icon-primary pull-left">
          <i class="fas fa-calendar-week"></i>
        </div>
        <div class="text-right">
            <h3 class="text-dark m-t-10"><b class="counter" style="cursor:pointer" onclick="showInvoices('week')" id="weekly_count"><?=$statistics[1]?></b></h3>
            <p class="text-muted mb-0">Weekly Due</p>
        </div>
        <div class="clearfix"></div>
        </div>
        </div>
                
        
        <div class="col-lg-4 col-xl-3">
        <div class="widget-bg-color-icon card-box">
        <div class="bg-icon bg-icon-warning pull-left">
          <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="text-right">
            <h3 class="text-dark m-t-10"><b class="counter"  style="cursor:pointer" onclick="showInvoices('month')"  id="monthly_count"><?=$statistics[2]?></b></h3>
            <p class="text-muted mb-0">Monthly Due</p>
        </div>
        <div class="clearfix"></div>
        </div>
        </div>
                
        <div class="col-lg-4 col-xl-3">
        <div class="widget-bg-color-icon card-box">
        <div class="bg-icon bg-icon-danger pull-left">
        <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="text-right">
            <h3 class="text-dark m-t-10"><b class="counter"  style="cursor:pointer" onclick="showInvoices('overdue')"  id="overdue_count"><?=$statistics[3]?></b></h3>
            <p class="text-muted mb-0">Overdue</p>
        </div>
        <div class="clearfix"></div>
        </div>
        </div>        
        
        </div>
        
        <div class="row pt-3">
        <div class="col-md-7 bg-white border table_div" id="table_div">
      
        </div>
         <div class="col-md-5 bg-white border"><span class="right_bar_div" id="right_bar_div"> </span>
      
          <span class="library_div"></span> </div>
        </div>
        <Script>
         function showInvoices(type){
         paramData = {'act':'show_e_invoices','type':type};
            ajax({ 
              a:'process',
              b:$.param(paramData),
              c:function(){},
              d:function(data){		
                $('#table_div').html(data);
                $('#right_bar_div').html('');						
              }});	
          }
         
        </script>
 <?php      
 } include 'e_template.php'; ?>
 
  