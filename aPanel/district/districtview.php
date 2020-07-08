<!--======================================
   Name: Manikandan;
   Create: 5/6/2020;
   Update: 30/6/2020;
   Use: ADD DISTRICT
   =======================================-->
   <?php
   function main() { 
   ?>

<div id="layoutSidenav_content">
   <div class="container-fluid">
      <h2 class="mt-3">District Details</h2>
      <ol class="breadcrumb mb-3">
         <a href="../dashboard.php" class="breadcrumb-item">Home</a>
         <a href="index.php" class="breadcrumb-item active">District Details</a>
      </ol>
      <div class="row">
         <div class="col-md-12">
            <div class="card mb-4">
               <div class="card-header" id="backToDist">
                  <strong style="font-size:2rem;" class="mytextcolor">
                  <?php $param = array('tableName' => TBL_BJP_DISTRICT, 'fields' => array('*'),'condition' => array('id' => $_REQUEST['dist'].'-INT'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                     $district_list = Table::getData($param);
                     echo $district_list->district_name_ta;
                     echo ' (';
                     echo $district_list->district_name;
                     echo ')';
                     ?>   
                  </strong>
                  <button type="button" class="btn btn-warning btn-sm float-right" style="color:#FFF" id="getvalue" data-toggle="modal" data-target="#myModal">
                  <i class="fa fa-plus" aria-hidden="true"></i> ADD NEW MANDAL
                  </button>
               </div>
               <div class="card-body">
                  <div class="row">
                     <!-- <div class="col-md-2">
                        <input type="inputvalue" style="margin-bottom: 10px;" id="inputvalue" class="form-control card-margin" onkeypress="searchKey(this.id)" placeholder="Search Here.." />
                        <span id="mandaltable"></span>
                     </div> -->
                     <div class="col-md-12 ">
                        <input type="inputvalue" style="margin-bottom: 10px;" id="inputvalue" class="form-control card-margin form-control-lg" onkeypress="searchMandal(this.id)" placeholder="Search Mandal Here..!" />
                        <br>
                        <div id="mandaldetails"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="myModal" role="dialog">
         <div class="modal-dialog">
            <span id="modelview">
         </div>
      </div>
   </div>
</div>
<input type="hidden" id="getDistrictid" value="<?php echo $_REQUEST['dist']; ?>">
<script type="text/javascript">
   $(document).ready(function(){
    var getDistrictid = $('#getDistrictid').val();
    paramData = {'act':'getMandalData','filter_by': getDistrictid}; 
    ajax({
         a:"districtajax",
         b:paramData,
         c:function(){},
         d:function(data){
            $('#mandaltable').html(data);
         }
    });
   
     var id = $('#getDistrictid').val();
      paramData = {'dist_ID':id,'action':'districtCard'}; 
      ajax({
            a:"districtmodel",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#mandaldetails').html(data);
            }
      });

   //  $('#inputvalue').keyup(function() {
   //         var filter_by = $(this).val();
   //         var getDistrictid = $('#getDistrictid').val();
   //           paramData = {'act':'searchMandal','filter_by':filter_by,'district_id':getDistrictid }; 
   //             ajax({
   //                a:"districtajax",
   //                b:paramData,
   //                c:function(){},
   //                d:function(data){
   //                   $('#mandaltable').html(data);
   //               }
   //          });
   //    });
   
      $('#getvalue').click(function() {
         var id = $('#getDistrictid').val();
           paramData = {'dist_ID':id,'action':'addnewmandal'}
            ajax({
                  a:"districtmodel",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                     $('#modelview').html(data);
                  }
            });        
      });
   });

   function searchMandal(id_attr) { 
         $( "#"+id_attr).autocomplete({
         source: function( request, response ) {
            $('#update_response_'+id_attr).html('processing...'); 
            var district_id = $('#getDistrictid').val();
            // Fetch data
            $.ajax({
            url: "districtajax.php",
            type: 'post',
            dataType: "json",
            data: {
               searchMandal: request.term,district_id,

            },
            success: function( data ) { 
               response( data );
            }
            });
         },
         select: function (event, ui) {
            $('#submit').prop('disabled', false);
            $('#'+id_attr).val(ui.item.label); 
            $('.'+id_attr).val(ui.item.value);      
            paramData = {'action':'mandalCard','mandal_ID':ui.item.value }; 
                  ajax({
                     a: "districtmodel",
                     b: paramData,
                     c:function(){},
                     d:function(data){
                        $('#mandaldetails').html(data);
                     }
               });
            return false;
         }
         });
    }


</script>
<?php } include "template.php"; ?>