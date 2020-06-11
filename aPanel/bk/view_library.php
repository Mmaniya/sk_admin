<?php 
include 'includes.php';



 $libCatId = $_POST['category_id'];
    $param = array('tableName'=>TBL_LIBRARY,'fields'=>array('*'),'condition'=>array('lib_category_id'=>$libCatId.'-INT'));
	$rsCategory = Table::getData($param);
 
  $contentLoadId  = $_POST['content_load_id'];
	
	?>

<div class="card-box">
<h4 class="m-t-3 header-title">Quotations Library     <span class="pull-right" onclick="closeLibraryDiv()" style="cursor:pointer">[X]</span></h4>

<?php     $i = 0;
if(count($rsCategory)>0) {
	   foreach($rsCategory as $key=>$val) {
 $bg='';  $i++;   
 if ($i % 2 == 1 && $i != count($rsLibrary)) { $bg = ' rgba(0, 0, 0, 0.03)';   }
		   ?>
<div class="row right_border tb_row" style="background-color:<?php echo $bg; ?> ">
  
  <div class="col-md-10 colBorder"><strong><?php echo $val->title; ?> </strong><br/><small><?php echo $val->content; ?></small> </div>
  <div class="col-md-2 colBorder">
   <a href="javascript:void(0)" class="a_tag btn btn-primary" onclick="selectContent(<?php echo $val->id; ?>,'<?php echo $contentLoadId; ?>')">Select</a></div>
    <div class="col-md-12"><hr/> </div>
	<div style="display:none;" class="content_html_<?php echo $val->id; ?>"><?php echo $val->content.'&#13;&#10;&#13;&#10;'; ?></div>
</div> 
<?php }  } ?>
 </div>
  
 
 
 <script>  
 function selectContent(id,content_load_id) {
	 var content = $('.content_html_'+id).html();  	
  textareaValue  =  $('#'+content_load_id).val();
  
	 $('#'+content_load_id).val(textareaValue+content);
	   
 }
</script>


<style>
.right_bar_div .card-box { background-color:#fff; }
.right_bar_div .form-group { margin-bottom: 0px; }
.right_bar_div hr { margin-top: 0.5rem; margin-bottom: 0.5rem;  border: 0; border-top: 1px solid rgba(0,0,0,.1);}
textarea{border:1px solid #cfcfcf;}
.right_bar_div  .col-form-label {text-align:right; }
@media screen and (max-width: 768px) { .right_bar_div  .paddingTop { margin-top:20px; }
.right_bar_div  .removebtn { margin-top:10px; float:right; }
}</style>