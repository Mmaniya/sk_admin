<?php


include "includes.php";
ini_set('display_errors',1);
$invoiceObj = new Invoice();
$invoice_id = $invoiceObj->invoice_id= $invoice_id;
$invoiceServices = $invoiceObj->getInvoiceDetails();

$invPaymentId = $invoice_payment_id;
$qry = "SELECT * from 	`".TBL_INVOICE_PAYMENT."` where id = ".$invPaymentId;
$rsPayment =  dB::sExecuteSql($qry);



if (!class_exists('TCPDF')) {
  
   // include_once('../TCPDF/tcpdf.php');
	include_once('../TCPDF/examples/tcpdf_include.php');


    class MYPDF extends TCPDF {

    //Page header
    public function Header() {
       
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
}


  
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('BizplanEasy Automation Engine');
$pdf->SetTitle('BizplanEasy Invoice');
$pdf->SetSubject('BizplanEasy Invoice'.$invoice_id);
$pdf->SetKeywords('Invoice, PDF, Auto Generation');


// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
//$pdf->SetFont('times', 'BI', 12); 
// add a page
$pdf->AddPage(); 
  //$pdf->Image('http://mastermindsolutionsonline.com/tamayohomes/wp-content/uploads/PDF_EXTENDED_TEMPLATES/pdf_img/neighborhood.png', '', '', 180, 40, '', '', 'T', false, 800, '', false, false, 0, false, false, false);


  $html=array();
  
  
  $html[0]='
  <div class="invoice-box" style="max-width: 800px; margin: auto; padding: 10px;  border: 1px solid #eee;  box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px;line-height: 24px; font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;color: #555;">';
  
   $html[1]='
 <table  cellspacing="3" cellpadding="15" style="width: 100%;line-height: inherit;text-align: left;">';
 
 
 if(!$installmentPayment) {
       $html[2]='       <tr class="top">
                <td colspan="2">
                    <table style="width: 100%;line-height: inherit;text-align: left;">
                        <tr>
                            <td class="title" style="font-size: 45px; color: #333;vertical-align: top;">
                                <img src="https://www.bizplaneasy.com/images/bizplaneasylogo2014.png" style="width:260px; max-width:270px;height:77px;">
                            </td>
                            
                            <td style="padding: 5px;vertical-align:top;text-align: right;line-height:20px;">
                                support@bizplaneasy.com<br/>877-533-2075 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
			
			            
            <tr class="information">
                <td colspan="2">
                    <table style="width: 100%;line-height: inherit;text-align: left;">
					     <tr>
                            <td style="vertical-align: top; line-height:20px;text-align: left;">[CLIENT_NAME] <br />[CLIENT_PHONE]<br/>[CLIENT_EMAIL] 
                            </td>
                            
                            <td style="padding: 5px;vertical-align: top;text-align: right;line-height:20px;">
                               [SENT_DATE] <br/>   Invoice Id: [INVOICE_ID]
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>';
 }else {
	 
	   $html[2]='       <tr class="top">
                <td colspan="2">
                    <table style="width: 100%;line-height: inherit;text-align: left;">
                        <tr>
                            <td class="title" style="font-size: 45px; color: #333;vertical-align: top;">
                                <img src="https://www.bizplaneasy.com/images/bizplaneasylogo2014.png" style="width:260px; max-width:270px;height:77px;">
                            </td>
                            
                            <td style="padding: 5px;vertical-align:top;text-align: right;line-height:20px;">
                                support@bizplaneasy.com<br/>877-533-2075 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
			
			            
            <tr class="information">
                <td colspan="2">
                    <table style="width: 100%;line-height: inherit;text-align: left;">
					     <tr>
                            <td style="vertical-align: top; line-height:20px;text-align: left;">[CLIENT_NAME] <br />[CLIENT_PHONE]<br/>[CLIENT_EMAIL] 
                            </td>
                            
                            <td style="padding: 5px;vertical-align: top;text-align: right;line-height:20px;">
                               [SENT_DATE] <br/>   Invoice Id: [INVOICE_ID] <br/> Payment Receipt Id: [INVOICE_PAYMENT_ID]
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>';
 }
        $client = $invoiceServices['client'];
	$search = array('[CLIENT_NAME]', '[CLIENT_PHONE]', '[CLIENT_EMAIL]', '[SENT_DATE]', '[INVOICE_ID]','[INVOICE_PAYMENT_ID]');
$replace = array($client['name'],$client['phone'],$client['email'],$invoiceServices['sent_date'],$invoice_id,$invoicePaymentId);		
			
       $html[2] = str_replace($search, $replace, $html[2]);
	    $emailSubject = $invoiceServices['services']['email_subject'];
		  unset($invoiceServices['services']['email_subject']);
		
	
            $html[3]='     <tr class="heading">
                <td style="width:65%;padding: 5px;vertical-align: top;background-color: rgb(238, 238, 238); border-bottom: 1px solid #ddd;  font-weight: bold;">
                    Services
                </td>
                
                <td style="width:35%;padding: 5px;vertical-align: top;background-color:rgb(238, 238, 238); border-bottom: 1px solid #ddd;  font-weight: bold;text-align: right;">
                    Price
                </td>
            </tr>';
			
			
           if(!$installmentPayment) {
	   
		foreach($invoiceServices['services'] as $K=>$V) {	
		
		$html[3].='<tr class="item"><td style="width:65%;padding: 5px;vertical-align: top;line-height:15px;border-bottom: 1px solid #eee;">'.$V['item_name'].' <br/><span style="padding-top:10px;font-size:13px;line-height:20px;color:#2a2b2a"><i>'.$V['item_desc'].'</span></i>';
		
		if(count($V['services'])>0) {
		 	$html[3].='<ul>';
			foreach($V['services'] as $K1=>$V1) {
	        	$html[3].='<li style="line-height:22px; font-size:14px"><em>'.$V1.'</em></li>';		
			}
			$html[3].='</ul>';
			
		}
		$html[3].='</td><td style="padding: 5px;vertical-align: top;border-bottom: 1px solid #eee;text-align: right;line-height:15px;">'.$V['item_amount'].'</td></tr>';
		
		}
            
			
			
			
			$amountDtls = $invoiceServices['amount_details'];
			
		$html[3].='
            
            <tr class="total">

                
                <td colspan="2" style="padding: 5px;vertical-align: top;border-top: 2px solid #eee;font-weight: bold;text-align: right;">
                   Total: '.$invoiceServices['amount_details']['total_amount'].'</td></tr>';
				   
				   if($amountDtls['is_discount']=='Y' && $amountDtls['discount']['code']!='') {
					  
					  $discountCode =$amountDtls['discount']['code']; 
					  $discountValue =$amountDtls['discount']['value']; 
					  $discountAmt =$amountDtls['discount']['amount']; 

	$html[3].='<tr class="total">

                
                <td colspan="2" style="padding: 5px;vertical-align: top;border-top: 2px solid #eee;font-weight: bold;text-align: right;">
                   Discount ('.$discountValue.') : - '.$discountAmt.'</td></tr>';
				      
					   
					   
				   }
				    
					
				 	$html[3].='   <tr class="total">
             
                
                <td colspan="2" style="padding: 5px;vertical-align: top;border-top: 2px solid #eee;font-weight: bold;text-align: right;">
                   Final Total: '.$invoiceServices['amount_details']['final_amount'].'</td></tr>
				   
				   
				        <tr class="total">   <td colspan="2" style="padding: 5px;vertical-align: top;border-top: 2px solid #eee;font-weight: bold;text-align: right;">
                   Amount Paid: '.money($rsPayment->amount_paid,'$').'</td></tr>';
				   
				  if($rsPayment->balance_amount>0) { 
				     $html[3].= '<tr class="total"><td colspan="2" style="padding: 5px;vertical-align: top;border-top: 2px solid #eee;font-weight: bold;text-align: right;">
                   Balance Amount: '.money($rsPayment->balance_amount,'$').'</td></tr>';  
				  }
				   
				   
		 } else {		   
				   
				 
            $html[3]='     <tr class="heading">
                <td style="width:65%;padding: 5px;vertical-align: top;background-color: rgb(238, 238, 238); border-bottom: 1px solid #ddd;  font-weight: bold;">
                    Installment Payment for Invoice Id: '.$client_id.'
                </td>
                
                <td style="width:35%;padding: 5px;vertical-align: top;background-color:rgb(238, 238, 238); border-bottom: 1px solid #ddd;  font-weight: bold;text-align: right;">
                   '.money($rsPayment->amount_paid,'$').'
                </td>
            </tr>';  
				   
			 }	   
				   
				   $html[3].='</table>';
				   
	
		 
		 
		 
	
				   
				      $pdfHtml = implode('',$html);
					  				   $pdf->writeHTML($pdfHtml, true, false, true, false, '');
				
  


  
				   
				   if($rsPayment->balance_amount>0 && is_array($invoiceServices['amount_details']['installment'])){   $pdf->AddPage(); 
				     $html[4]='<div class="invoice-box" style="max-width: 800px; margin: auto; padding: 10px;  border: 1px solid #eee;  box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px;line-height: 24px; font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;color: #555;">';
					 
					  $html[5]='
 <table  cellspacing="3" cellpadding="15" style="width: 100%;line-height: inherit;text-align: left;">
<tr class="top">
                <td colspan="2">
                    <table style="width: 100%;line-height: inherit;text-align: left;">
                        <tr>
                            <td class="title" style="font-size: 45px; color: #333;padding: 5px;vertical-align: top;">
                                <img src="https://www.bizplaneasy.com/images/bizplaneasylogo2014.png" style="width:260px; max-width:270px;height:77px;">
                            </td>
                            
                            <td style="padding: 5px;vertical-align:top;text-align: right;line-height:20px;">
                                support@bizplaneasy.com<br/>877-533-2075 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
			  </table>';
					 
			 $html[6]='		 
 <table  cellspacing="3" cellpadding="15" style="width: 100%;line-height: inherit;text-align: left;"><tr>
                <td colspan="2" style="line-height:25px; padding: 5px;vertical-align: top;border-top: 2px solid #eee;text-align: left;" >
					 We are happy to provide you with installment options. Below is your installment schedule of payments for your reference:</td></tr>';
  $html[6].='     <tr class="heading">
                <td style="width:65%;padding: 5px;vertical-align: top;background-color: rgb(238, 238, 238); border-bottom: 1px solid #ddd;  font-weight: bold;">
                    Installment Date
                </td>
                
                <td style="width:35%;padding: 5px;vertical-align: top;background-color:rgb(238, 238, 238); border-bottom: 1px solid #ddd;  font-weight: bold;text-align: right;">
                    Amount to be Paid
                </td>
            </tr>';		
		 $installment = $invoiceServices['amount_details']['installment'];
		 
            foreach($installment['schedule'] as $K=>$V) { 
			if($V['is_paid']=='N') {
         $html[6].=' <tr> <td style="padding: 5px;vertical-align: top;border-top: 2px solid #eee;font-weight: bold;text-align: left;"> '.$V['installment_date']. '</td><td style="padding: 5px;vertical-align: top;border-top: 2px solid #eee;font-weight: bold;text-align: right;">'. $V['installment_amount'].'</td></tr>';


			}
		    }  
			
			         $html[6].='</table>';

				   }
				   
				   
				   
				    
 $html[6].='<table  cellspacing="3" cellpadding="15" style="width: 100%;line-height: inherit;text-align: left;"><tr>
                <td colspan="2" style="line-height:25px; padding: 5px;vertical-align: top;border-top: 2px solid #eee;text-align: left;" ><span style="padding-left:10px;">Thank you for choosing BizPlanEasy for your services.  <br/><br/></span>
				
				<span style="font-size:12px"><em>This is computer generated invoice. Does not require a signature.</em></span>

				  </td></tr></table> '; 
 
	$finaldtls = $html[4].$html[5].$html[6];     
	$pdf->writeHTML($finaldtls, true, false, true, false, '');

// ---------------------------------------------------------

ob_end_clean();
ob_clean(); 

if($installmentPayment) 
$fileName = 'Installment_Receipt'.customizeSerial($invoice_payment_id);
else
$fileName = customizeSerial($invoice_id);
$pdf->Output($_SERVER['DOCUMENT_ROOT']."test/invoice_pdf/".$fileName.".pdf", "F");
$outputFile = "invoice_pdf/".$fileName.".pdf";
?>