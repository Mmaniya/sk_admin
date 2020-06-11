<?php 
session_start();

   function main() { 
   
   	// 	 $invoiceObj = new Invoice();
    // 	 $invoiceObj->reportType='month';
    // 	 $invoiceObj->month =date('n',time());
    // 	 $stats=$invoiceObj->getSalesStatistics();
    // 	 $statArr = explode('::',$stats);
    //   $percent='40%';
    //   echo '<div style="width:40%"><div width="100%" style="background-color:#ccc"><div style="width:'.$percent.';background-color:#039cfd;height:35px;\">&nbsp;</div></div></div>';
            /*$param = array('tableName'=>'logs','fields'=>array('*'),'condition'=>array('id'=>'15-INT'),'showSql'=>'N');
            $rsRecords = Table::getData($param);
            echo urldecode($rsRecords->description);*/
   ?> 

<script>
   function dash_invoice_paymentDtls(invoicePaymentId,invoice_id) {
   	  //paramData = {'act':'show_dash_invoice_payment_details','invoice_id':invoice_id,'invoice_payment_id':invoicePaymentId};
   	  paramData = {'act':'show_invoice_payment_details','invoice_id':invoice_id};
   	  
             ajax({ 
               a:'invoices',
               b:$.param(paramData),
               c:function(){},
               d:function(data){   
   			  $('.right_bar_div').html(data);
   			  $('#con-close-modal').modal('show');
   			  
               }});	    	  
    }
   
   function showRevenue(rType) {
   	var optionName = $('#reportType').val();
   	if(optionName=='month') paramData = {'act':'show_revenue','type':optionName,'mn':$('#monthValue option:selected').val(),'rType':rType};
   	if(optionName=='date')	paramData = {'act':'show_revenue','type':optionName,'dateField':$('#dateField').val(),'rType':rType};
   	if(optionName=='range')	paramData = {'act':'show_revenue','type':optionName,'from_date':$('#from_date').val(),'to_date':$('#to_date').val(),'rType':rType};
   	if(optionName=='all')  paramData = {'act':'show_revenue','type':'all','rType':rType};
   	ajax({ 
   		a:'process',
   		b:$.param(paramData),
   		c:function(){},
   		d:function(data){
   			$('#table_div').html(data);	
   			$('#right_bar_div').html('');					
   		}});	
   	}
   
   
   function send_sms(id) {
   	
   	paramData = {'client_id':id,'type':'client'};
   	ajax({ 
   		a:'send_sms',
   		b:$.param(paramData),
   		c:function(){},
   		d:function(data){
   			$('.right_bar_div').html(data);	
   		  $('#con-close-modal').modal('show'); 		   
   		}});	
   }
   
   
     function show_invoice_paymentDtls(invoice_id) {
   	  paramData = {'act':'show_invoice_payment_details','invoice_id':invoice_id};
             ajax({ 
               a:'invoices',
               b:$.param(paramData),
               c:function(){},
               d:function(data){   
   			  $('.right_bar_div').html(data);
   			  $('#con-close-modal').modal('show');
   			  
               }});	    	  
    }
   
   
   function showInstallment() {
   	var optionName = $('#reportType').val();
   	if(optionName=='month') paramData = {'act':'show_installment','type':optionName,'mn':$('#monthValue option:selected').val()};
   	if(optionName=='date')	paramData = {'act':'show_installment','type':optionName,'dateField':$('#dateField').val()};
   	if(optionName=='range')	paramData = {'act':'show_installment','type':optionName,'from_date':$('#from_date').val(),'to_date':$('#to_date').val()};
   	if(optionName=='all')  paramData = {'act':'show_installment','type':'all'};
   	ajax({ 
   		a:'process',
   		b:$.param(paramData),
   		c:function(){},
   		d:function(data){
               //alert(data);
   			$('#table_div').html(data);	
   			$('#right_bar_div').html('');					
   		}});	
   	}
   
     function showPendingInstallment() {
   	paramData = {'act':'show_pending_installment'};
   	ajax({ 
   		a:'process',
   		b:$.param(paramData),
   		c:function(){},
   		d:function(data){
               //alert(data);
   			$('#table_div').html(data);	
   			$('#right_bar_div').html('');					
   		}});	
     }
   
   function showInvoices() {
   	var optionName = $('#reportType').val();
   	if(optionName=='month') paramData = {'act':'show_invoices','type':optionName,'mn':$('#monthValue option:selected').val()};
   	if(optionName=='date')	paramData = {'act':'show_invoices','type':optionName,'dateField':$('#dateField').val()};
   	if(optionName=='range')	paramData = {'act':'show_invoices','type':optionName,'from_date':$('#from_date').val(),'to_date':$('#to_date').val()};
   	if(optionName=='all')  paramData = {'act':'show_invoices','type':'all'};
   	ajax({ 
   		a:'process',
   		b:$.param(paramData),
   		c:function(){},
   		d:function(data){
   			$('#table_div').html(data);	
   			$('#right_bar_div').html('');					
   		}});	
   	}
   
   
   
   function showLeads() {
   	var optionName = $('#reportType').val();
   	if(optionName=='month') paramData = {'act':'show_dash_leads','type':optionName,'mn':$('#monthValue option:selected').val()};
   	if(optionName=='date')	paramData = {'act':'show_dash_leads','type':optionName,'dateField':$('#dateField').val()};
   	if(optionName=='range')	paramData = {'act':'show_dash_leads','type':optionName,'from_date':$('#from_date').val(),'to_date':$('#to_date').val()};
   	if(optionName=='all')  paramData = {'act':'show_dash_leads','type':'all'};
   	ajax({ 
   		a:'process',
   		b:$.param(paramData),
   		c:function(){},
   		d:function(data){		
   			$('#table_div').html(data);
   			$('#right_bar_div').html('');						
   		}});	
   	}
   	
    
   
   function showOptions(){
   	var optionName = $('#reportType').val();
   	$('.reportOptions').hide();
   	$('#'+optionName+'_div').show();
   	
   	if(optionName=='month') {
   	getStatistics('month',$('#monthValue option:selected').val())	
   	}
   	if(optionName=='all') {
   		getStatistics('all','');
   	}
   	 }
   function getStatistics(type,value) {
       $('#table_div').html('');
   	if(type=='month')	paramData = {'act':'get_statistics','type':type,'month':value,'mn':$('#monthValue option:selected').text()};
   	if(type=='date')	paramData = {'act':'get_statistics','type':type,'dateField':value};
   	if(type=='range')	paramData = {'act':'get_statistics','type':type,'from_date':$('#from_date').val(),'to_date':$('#to_date').val()};
   	if(type=='all')  paramData = {'act':'get_statistics'};
   	ajax({ 
   		a:'process',
   		b:$.param(paramData),
   		c:function(){},
   		d:function(data){
   		
   			dataArr = data.split('::');
   			$('#total_leads').html(dataArr[0]);
   			$('#revenue').html(dataArr[2]);
   			$('#total_invoice').html(dataArr[1]);
   			$('#conversion').html(dataArr[3]);	
   			$('#stat_heading').html(dataArr[4]);	
   			$('#installments').html(dataArr[5]);	
   			$('#installmentAmount').html(dataArr[6]);            
   		}});	
    }
    
   function showSendEmail(id,email_type,param_type) {
   
      if(param_type=='I') paramData = {'act':'showSendEmail','invoice_id':id,param_type:param_type,'email_type':email_type};
      if(param_type=='C') paramData = {'act':'showSendEmail','client_id':id,param_type:param_type,'email_type':email_type};
      if(param_type=='IS') paramData = {'act':'showSendEmail','installment_id':id,param_type:param_type,'email_type':email_type};
      if(param_type=='L') paramData = {'act':'showSendEmail','lead_id':id,param_type:param_type,'email_type':email_type};
      if(param_type=='IP') paramData = {'act':'showSendEmail','invoice_payment_id':id,param_type:param_type,'email_type':email_type}; //invoice payment
   
   	ajax({ 
   		a:'process',
   		b:$.param(paramData), 
   		c:function(){},
   		d:function(data){ 		
   		  $('.right_bar_div').html(data);	
             $('#con-close-modal').modal('show');		  
   		}});	
   } 
    
   function showQuestionnaireCmts(invLineItemId,documentId,questionnaireId) {
   	 paramData = {'act':'showQuestionnaireCmts','invoice_line_item_id': invLineItemId,"document_id":documentId,"questionnaire_id":questionnaireId,'dashboard':1};
             ajax({ 
               a:'process',
               b:$.param(paramData),
               c:function(){},
               d:function(data){  
                   $('.commentBlock').html(data);	 
                   $('#dashb_con-close-modal').modal('show');
                   $("html, body").animate({ scrollTop: $("#lastCId").offset().top }, "slow");             
                   
               }}); 
   }
   
   $(document).on('click', '.datepicker', function(){
      $(this).datepicker({
         changeMonth: true,
         changeYear: true
        }).focus();
      $(this).removeClass('datepicker'); });
</script>                  
<?php } include 'template.php'; ?>