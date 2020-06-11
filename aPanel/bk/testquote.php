<?php

include "includes.php";
ini_set('display_errors',1);



$quotationId = $_REQUEST['id'];
$quoteObj = new Quotation();
$quoteObj->quotation_id= $quotationId;
$quoteServices = $quoteObj->getQuoteDetails();
print_r($quoteServices);
exit();
if (!class_exists('TCPDF')) {
  
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

  ob_start();


  
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Bizplan Easy');
$pdf->SetTitle('Bizplan Easy');
$pdf->SetSubject('Bizplan Easy');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');


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

 $introduction = strtr($quoteServices['introduction'], array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />'));
 
  $introHtml ='
  <div class="invoice-box" style="max-width: 800px; margin: auto; padding: 10px;  border: 1px solid #eee;  box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px;line-height: 24px; font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;color: #555;">
 
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
			
			 <tr class="information">
                <td colspan="2">
                    <table style="width: 100%;line-height: inherit;text-align: left;">
					     <tr>
                            <td style="vertical-align: top; line-height:20px;text-align: left;">[CLIENT_NAME] <br />[CLIENT_PHONE]<br/>[CLIENT_EMAIL] 
                            </td>
                            
                            <td style="padding: 5px;vertical-align: top;text-align: right;line-height:20px;">
                               [SENT_DATE] 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
			
			 <tr class="information">
                <td colspan="2">
                    <table style="width: 100%;line-height: inherit;text-align: left;">
					     <tr>
                            <td style="vertical-align: top; line-height:20px;text-align: justify;" colspan="2">
							
							<strong>Subject:</strong> '.$quoteServices['services']['email_subject'].' <br/><br/> '.$introduction.'
							
							
			
			
			
			
			 </td>
                        </tr>
                    </table>
                </td>
            </tr>
			
			</table>';
			
			
			
	$client = $quoteServices['client'];
	$search = array('[CLIENT_NAME]', '[CLIENT_PHONE]', '[CLIENT_EMAIL]', '[SENT_DATE]');
	$replace = array($client['name'],$client['phone'],$client['email'],$quoteServices['sent_date']);		
		$introHtml = str_replace($search, $replace, $introHtml);
			$intro=$introHtml.'</div>';
	$pdf->writeHTML($intro, true, false, true, false, '');	
		
  

$pdf->AddPage(); 
  

  $html=array();
  
  
  $html[0]='
  <div class="invoice-box" style="max-width: 800px; margin: auto; padding: 10px;  border: 1px solid #eee;  box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px;line-height: 24px; font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;color: #555;">';
  
   $html[1]='
 <table  cellspacing="3" cellpadding="15" style="width: 100%;line-height: inherit;text-align: left;">';
 
       $html[2]='       <tr class="top">
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
			
			            
            <tr class="information">
                <td colspan="2">
                    <table style="width: 100%;line-height: inherit;text-align: left;">
					     <tr>
                            <td style="vertical-align: top; line-height:20px;text-align: left;">[CLIENT_NAME] <br />[CLIENT_PHONE]<br/>[CLIENT_EMAIL] 
                            </td>
                            
                            <td style="padding: 5px;vertical-align: top;text-align: right;line-height:20px;">
                               [SENT_DATE] <br/>   Quotation Id: Q00[QUOTATION_ID]
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>';
            
      
            $html[3]='     <tr class="heading">
                <td style="width:65%;padding: 5px;vertical-align: top;background-color: rgb(238, 238, 238); border-bottom: 1px solid #ddd;  font-weight: bold;">
                    Services
                </td>
                
                <td style="width:35%;padding: 5px;vertical-align: top;background-color:rgb(238, 238, 238); border-bottom: 1px solid #ddd;  font-weight: bold;text-align: right;">
                    Price
                </td>
            </tr>';
			
			
            $client = $quoteServices['client'];
	$search = array('[CLIENT_NAME]', '[CLIENT_PHONE]', '[CLIENT_EMAIL]', '[SENT_DATE]', '[QUOTATION_ID]');
$replace = array($client['name'],$client['phone'],$client['email'],$quoteServices['sent_date'],$quotationId);		
			
       $html[2] = str_replace($search, $replace, $html[2]);
	   $emailSubject = $quoteServices['services']['email_subject'];
	   unset($quoteServices['services']['email_subject']);
		foreach($quoteServices['services'] as $K=>$V) {	
	
		if($V['item_name']!='') {
		$html[3].='<tr class="item"><td style="width:65%;padding: 5px;vertical-align: top;line-height:15px;border-bottom: 1px solid #eee;">'.$V['item_name'].$K;
		if(count($V['services'])>0) {
		 	$html[3].='<ul>';
			foreach($V['services'] as $K1=>$V1) {
	        	$html[3].='<li style="line-height:22px; font-size:14px"><em>'.$V1.'</em></li>';		
			}
			$html[3].='</ul>';
			
		}
		$html[3].='</td><td style="padding: 5px;vertical-align: top;border-bottom: 1px solid #eee;text-align: right;line-height:15px;">'.$V['item_amount'].'</td></tr>';
			echo '-'.$K.'=';
		}
		}
            
			$amountDtls = $quoteServices['amount_details'];
			
		$html[3].='
            
            <tr class="total">

                
                <td colspan="2" style="padding: 5px;vertical-align: top;border-top: 2px solid #eee;font-weight: bold;text-align: right;">
                   Total: '.$quoteServices['amount_details']['total_amount'].'</td></tr>';
				   
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
                   Final Total: '.$quoteServices['amount_details']['final_amount'].'</td></tr>';
				   
				   $html[3].='</table> 
				   <span style="font-size:12px"><em>This is computer generated quotation. Does not require a signature.</em></span>
				   </div> '; 
 
      $pdfHtml = implode('',$html);
	  unset($html[0]);
	 unset($html[2]);
 $emailHtml = $introHtml.implode('',$html);

		$pdf->writeHTML($pdfHtml, true, false, true, false, '');


// ---------------------------------------------------------

ob_end_clean();
ob_clean(); 
$fileName = customizeSerial($quotationId);
$pdf->Output(dirname(__FILE__)."/quotation_pdf/".$fileName.".pdf", "F");
$outputFile = "quotation_pdf/".$fileName.".pdf";

?>
<label class="col-md-6 col-form-label">Pdf generated for Quotation for : <?php echo $rsLeads->lead_fname.' '.$rsLeads->lead_lname; ?> </label>   
				<label class="col-md-6 col-form-label">#Quotation ID : <?php echo customizeSerial($id);?> </label>   :::
<?php
echo '<h2> Click <a href="'.$outputFile.'" target="_blank">here</a> to download the PDF file. </h2>';
?>
