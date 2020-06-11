<?php
  ob_start(); 
   require("includes.php");
include('TCPDF/examples/tcpdf_include.php');
 include('TCPDF/tcpdf.php');
  ob_start();
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

 
  $emailAddress = $_POST['email_address'];   
  
  $quotationId = $_POST['id'];
   		
 $param = array('tableName'=>TBL_QUOTATION,'fields'=>array('*'),'condition'=>array('id'=>$quotationId.'-INT'));
 $rsQuotation = Table::getData($param);
	 
	foreach($rsQuotation as $K=>$V)  $$K=$V;
					
	$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'condition'=>array('id'=>$lead_id.'-INT'));
	$rsLeads = Table::getData($param);	
	
	
	$emailcontent = array();
	$emailcontent['CLIENT_EMAIL'] = $leads->lead_email;
	$emailcontent['CLIENT_NAME'] = $rsLeads->lead_fname.' '.$rsLeads->lead_lname; 
    $emailcontent['CLIENT_PHONE'] = $leads->lead_phone;
    $introductionDetails = $introduction;  
  foreach($emailcontent as $key => $value) {
	 	 $introduction = str_replace('['.$key.']', $value, $introduction);
		} 	
	
	
	$packageObj = new Packages; 
 
 $html='<table  border="0" cellspacing="0" cellpadding="0" width="100%" style="width: 100%;border: 1px solid #0a58a1;margin: auto;">
 <tbody><tr>
  <td style="background:#ffffff;padding:18.75pt 18.75pt 18.75pt 18.75pt">
  <p class="MsoNormal" align="center" style="text-align:center"><a href="https://www.bizplaneasy.com/" target="_blank"><span style="text-decoration:none"><img border="0" width="239" id="m_-4734976795238509399_x0000_i1025" src="https://mastermindsolutionsonline.com/bizplan/assets/images/logo.png" class="CToWUd"></span></a><u></u><u></u></p>
  </td>
 </tr>
 <tr style="height:11.25pt">
  <td style="background:#0a58a1;padding:0cm 0cm 0cm 0cm;height:11.25pt"></td>
 </tr>
 <tr>
  <td style="background:white;">
  <table width="100%">
 <tr><td style="padding:10px; padding-left:0px;"><strong>Quotation '.customizeSerial($rsQuotation->id).' &nbsp;&nbsp; |&nbsp;&nbsp; Date : '.date('m/d/Y',strtotime($sent_date)).'</strong></td>
 
</tr>  

<tr><td style="padding:10px;padding-bottom:20px; padding-left:0px;"><br/>'.$introduction.'<br/> </td></tr>'; 

$param = array('tableName'=>TBL_QUOTATION_LINE_ITEM,'fields'=>array('*'),'condition'=>array('quotation_id'=>$id.'-INT'));
			$rsQuotationLineItem = Table::getData($param); 	
					if(count($rsQuotationLineItem)>0) {
		   foreach($rsQuotationLineItem as $key=>$val) {  
		     if($val->category_id>0) { 
  
 $html.='<tr> <td colspan="2" style="padding:10px;background-color: #1e6db6;color: #fff; padding-left:0px;"> 
 <table style="width:100%;padding:5px;">
 <tr><td style="color: #fff;">  Services Requested : </td>   
   <td style="text-align:right;padding-right:5px;color: #fff;">Price  </td></tr> 
 </table> 
 </td></tr>';
 
					break; } } }
					
$html.='<tr><td style="padding:10px;padding-bottom:0px; padding-left:0px;" colspan="2">';
 $html.='<table style="width:100%;padding:5px;">';
	$param = array('tableName'=>TBL_QUOTATION_LINE_ITEM,'fields'=>array('*'),'condition'=>array('quotation_id'=>$id.'-INT'));
			$rsQuotationLineItem = Table::getData($param); 	
					if(count($rsQuotationLineItem)>0) {
		   foreach($rsQuotationLineItem as $key=>$val) {    
		    
			$category_id = $val->category_id;
			$service_id = $val->service_id;
			  if($category_id>0) {  
  
  $html.='<tr><td >'.$val->line_item.' &nbsp;&nbsp;&nbsp;  '.$val->line_desc.' </td> <td style="text-align:right;padding-right:5px;">   '.money($val->line_amount,'$').'</td></tr>';
   } } }
  $html.='</table>';           
		  
 $html.='</td></tr>';   

	$param = array('tableName'=>TBL_QUOTATION_LINE_ITEM,'fields'=>array('*'),'condition'=>array('quotation_id'=>$id.'-INT'));
	$rsQuotationLineItem = Table::getData($param);
			if(count($rsQuotationLineItem)>0) {  
			 foreach($rsQuotationLineItem as $K=>$V) {  
			 if($V->package_id>0) {	
  
			break; } } }
			
 
$html.='<tr><td style="padding:10px;padding-bottom:0px; padding-left:0px;" colspan="2">';
 $html.='<table style="width:100%;padding:5px;padding-bottom:20px;">';

  $param = array('tableName'=>TBL_QUOTATION_LINE_ITEM,'fields'=>array('*'),'condition'=>array('quotation_id'=>$id.'-INT'));
			$rsQuotationLineItem = Table::getData($param);
					if(count($rsQuotationLineItem)>0) {
		   foreach($rsQuotationLineItem as $key=>$val) {    
		    		 $packagePrice =  $val->package_price;
			$package_id = $val->package_id;
			  if($package_id>0) { 				  
  $html.='<tr><td>';
  $param = array('tableName'=>TBL_PACKAGES,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$package_id.'-INT'));
			    $rsPackages = Table::getData($param);
         $html.=$rsPackages->package_name.'<br/>'; 
  
   $packageObj->package_id= $val->package_services;
              $rsPackageServices = $packageObj->getPackageServicesByIds();
			  if(count($rsPackageServices)>0) {
			  foreach($rsPackageServices as $key=>$val) {
      $html.=''.$val->service_name.'<br/>';
			  }} 
  
  $html.='</td> <td style="text-align:right;padding-right:5px;">   '.money($packagePrice,'$').'</td></tr>';  
  $$packagePrice='';
} } }   

 $html.='</table> </td></tr>';    
 
  
    
 
 $html.='<tr> <td colspan="2" style="background-color:rgb(245, 245, 245);padding:10px; padding-left:0px;"> 
 <table style="width:100%;padding:5px;background-color:rgb(245, 245, 245)">
 <tr><td> Total : </td>   
   <td style="text-align:right;padding-right:5px;">'.money($quotation_amount,'$').'</td></tr> 
 </table> 
 </td></tr>';
 
 if($is_discount=='Y') {
	 
	  if($discount_type=='P') { $discount_type = $discount_value.'%'; }
	   if($discount_type=='F') { $discount_type = money($discount_value,'$'); }
  
 $html.='<tr> <td colspan="2" style="padding:10px; padding-left:0px;"> 
 <table style="width:100%;padding:5px; padding-left:0px;">
 <tr><td> DISCOUNT : '.$discount_code.' - '.$discount_type.'  </td>   
   <td style="text-align:right;padding-right:5px;">'.money($discount_amount,'$').'</td></tr> 
 </table> 
 </td></tr>';
  }
  
   $html.='<tr> <td colspan="2" style="background-color:rgb(245, 245, 245);padding:10px; padding-left:0px;"> 
 <table style="width:100%;padding:5px;background-color:rgb(245, 245, 245);">
 <tr><td> Final Total : </td>   
   <td style="text-align:right;padding-right:5px;">'.money($final_amount,'$').'</td></tr> 
 </table> 
 </td></tr>';
  
 
  if($installment=='Y') { 
  $html.='<tr><td colspan="2" style=" padding-left:0px;margin-left:0px;"> 
 <table style="width:100%;padding:10px; padding-left:0px;margin-left:0px;">
 <tr>
  <td style="padding:10px;  background-color: #1e6db6;color: #fff;margin-left:0px;" colspan="4"><strong>Installment :</strong> </td>
 </tr> 
 
 <tr>
  <td style="padding:10px; padding-left:0px;margin-left:0px;"  colspan="4">Down Payment   : '.money($installment_downpayment,'$').'  &nbsp;&nbsp;&nbsp; Installment Amount : '.money($installment_amount,'$').'  </td>
 </tr>
 
 <tr>
  <td style="padding:10px; padding-left:0px;margin-left:0px;"  colspan="4">Installment Period  : '.$installment_period.' Months  &nbsp;&nbsp;&nbsp; Start date  : '.date('m/d/Y',strtotime($installment_start_date)).'  &nbsp;&nbsp;&nbsp; End date : '.date('m/d/Y',strtotime($installment_end_date)).' </td>
 </tr> 
 </table> 
 </td></tr>';
  }
  
 
   

$html.='<tr>
  <td style="padding:30px;">  </td>
 </tr> 

  </table>   
  </td>
 </tr>
 <tr style="height:11.25pt">
  <td style="background:#0a58a1;padding:0cm 0cm 0cm 0cm;height:11.25pt"></td>
 </tr>
 <tr>
  <td style="background:#ffffff;padding:18.75pt 18.75pt 18.75pt 18.75pt">
  <p class="MsoNormal" align="center" style="text-align:center"><img border="0" width="180" id="m_-4734976795238509399_x0000_i1026" src="https://mastermindsolutionsonline.com/bizplan/assets/images/logo.png" class="CToWUd"><u></u><u></u></p>
   
  <h2 align="center" style="margin:0cm;margin-bottom:.0001pt;text-align:center;line-height:25.5pt;color:#000 !important" id="m_-4734976795238509399m_4959467253987482879ab_heading"><span style="font-size:9.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;font-weight:normal;color:#000000 !important;">Copyright &copy;	2001-2019 BizPlanEasy, Inc.<u></u><u></u></span></h2>
  </td>
 </tr>
</tbody></table>';
  
	
	$pdf->writeHTML($html, true, false, true, false, '');

	 

// ---------------------------------------------------------

ob_end_clean();
ob_clean(); 
//Close and output PDF document
//$pdf->Output('example_003.pdf', 'D');
	$fileName = customizeSerial($rsQuotation->id);
	$pdf->Output(dirname(__FILE__)."/quotation_pdf/".$fileName.".pdf", "F");
 
 
	$mail = new PHPMailer();                    
	$mail->From = FROM_EMAIL;
	$mail->FromName = FROM_NAME;
	//$mail->AddAddress('support@mastermindsolutionsonline.com');
	$mail->AddAddress($emailAddress);
	$mail->AddAttachment(dirname(__FILE__)."/quotation_pdf/".$fileName.".pdf");
	$mail->Subject = $subject;                  
	$mail->Body = $html;
	$mail->ishtml(true);
	 if(!$mail->Send())
	{
	   echo "Message could not be sent. <p>";
	   echo $emailError = "Mailer Error: " . $mail->ErrorInfo;
	   $is_email_sent = 'Y';
	}
	else
	{
	  echo 'Quotation Sent Successfully';
	}   
	
	

