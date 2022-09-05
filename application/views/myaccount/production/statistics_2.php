<?php 
$makeDate=date("d-m-Y", strtotime($this->session->userdata('date_now')));
$makeDateD=date("Y-m-d", strtotime($this->session->userdata('date_now')));
$designsCount=$this->dashboard_model->get_design_done($makeDate);
//$designsTotalCount=$this->dashboard_model->get_design_total($makeDateD);
$designsTotalCount=$this->dashboard_model->get_design_total($makeDateD);

$qcRejArray=$this->dashboard_model->get_design_qc_rejected($makeDate);
$bundlingRejArray=$this->dashboard_model->get_design_bundling_rejected($makeDate);
$finalqcRejArray=$this->dashboard_model->get_design_final_qc_rejected($makeDate);

$d_count=0;$t_count=0;$qcRejQty=0;$bqcRej=0;$fnlQcRej=0;
$d_count=$designsCount;

//if($designsTotalCount['t_count']!=""){
$t_count=$designsTotalCount;
//}
?>
<div class="row">
  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body" style="height:50vh;overflow-y:scroll;>
	<h4 class="card-title mb-0">Designing</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $d_count;?>  / <?php echo $t_count;?> </h2>
	    </div>
	    <small class="text-gray">Number of pieces done / Total</small>
	  </div>
	  <div class="d-inline-block">
	    <div class="bg-success px-4 py-2 rounded">

	    </div>
<br><br>
	  </div>
	</div>
      </div>
    </div>
  </div>
  
  
  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body" style="height:50vh;overflow-y:scroll;">
	<h4 class="card-title mb-0">Design QC Rejected</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <div class="table responsive" >
		<table class="table table-striped table-borderless" >
                  <thead>
                    <tr>
                      <th>Order No:</th>
                      <th>Qty</th>
                    </tr>
                  </thead>
                  <tbody>
		    
		    <?php foreach($qcRejArray as $qcR)
			  {
			  ?>
<tr>
		    <td><?php echo $qcR['order_no'];?></td>
		    <td><?php echo $qcR['qty'];?></td>
		    </tr>
		    <?php
		       $qcRejQty +=$qcR['qty'];
		       }
		       ?>
		  </tbody>
		</table>
	      </div>
	    </div>
	    <br>
	    <small class="text-gray">Rejected Qty  <?php echo $qcRejQty;?></small>
	  </div>
	  <div class="d-inline-block">
	  </div>
	</div>
      </div>
    </div>
  </div>
  
  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body" style="height:50vh;overflow-y:scroll;">
	<h4 class="card-title mb-0">Bundling QC Rejected</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <div class="table responsive">
		<table class="table table-striped table-borderless" >
                  <thead>
                    <tr>
                      <th>Order No:</th>
                      <th>Qty</th>
                    </tr>
                  </thead>
                  <tbody>
		    
		    <?php foreach($bundlingRejArray as $qcR)
			  {
			  ?>
		    <td><?php echo $qcR['order_no'];?></td>
		    <td><?php echo $qcR['qty'];?></td>
		    
		    <?php
		       $bqcRej +=$qcR['qty'];
		       }
		       ?>
		  </tbody>
		</table>
	      </div>
	    </div>
	    <br>
	    <small class="text-gray">Rejected Qty  <?php echo $bqcRej;?></small>
	  </div>
	  <div class="d-inline-block">
	  </div>
	</div>
      </div>
    </div>
  </div>
  
  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body" style="height:50vh;overflow-y:scroll;">
	<h4 class="card-title mb-0">Final QC Rejected</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <div class="table responsive">
		<table class="table table-striped table-borderless" >
                  <thead>
                    <tr>
                      <th>Order No:</th>
                      <th>Qty</th>
                    </tr>
                  </thead>
                  <tbody>
		    
		    <?php foreach($finalqcRejArray as $qcR)
			  {
			  ?>
		    <td><?php echo $qcR['order_no'];?></td>
		    <td><?php echo $qcR['qty'];?></td>
		    
		    <?php
		       $fnlQcRej +=$fnlQcRej['qty'];
		       }
		       ?>
		  </tbody>
		</table>
	      </div>
	    </div>
	    <br>
	    <small class="text-gray">Rejected Qty  <?php echo $fnlQcRej;?></small>
	  </div>
	  <div class="d-inline-block">
	  </div>
	</div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 grid-margin">
    <div class="card" style="height:60vh;overflow-y:scroll;">
      
      <div class="card-body">
	<h4 class="card-title mb-0">Dispatch</h4>
	<br><div class="row">
	  <div class="col-md-6 pl-md-1 pt-4 pt-md-0">
	    
	    <ul class="nav nav-tabs tab-basic" role="tablist">
	      <li class="nav-item">
		<a class="nav-link active" id="profile-tab" data-toggle="tab" href="#ourgoal" role="tab" aria-controls="ourgoal" aria-selected="true">Today</a>
	      </li>
	      <li class="nav-item">
		<a class="nav-link" id="contact-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">Yesterday</a>
	      </li>
	      
	    </ul>
	  </div>
	</div>
	
	<div class="tab-content tab-content-basic"  >
	  <div class="tab-pane fade show active" id="ourgoal" role="tabpanel" aria-labelledby="profile-tab" >
	    <?php 
	       $dispatch_date=date("d-m-Y", strtotime($this->session->userdata('date_now')));
	    $dispatch=$this->dashboard_model->get_dispatch_done($dispatch_date); ?>
	    <div class="table-responsive ">
	      <table class="table table-striped table-borderless " id="orders_dispatch">
		<thead>
		  <tr>
		    <th>Order No:</th>
		    <th>Shpping Type</th>
		    <th>Shpping Mode</th>
		  </tr>  
		</thead>
		<tbody>
		  <?php if($dispatch){ ?>
		  <?php foreach($dispatch as $DSP){
			
			?>
		  <tr  class="m-1">
		    <td class="font-weight-bold"><div class="badge badge-success"><?php echo $DSP['orderform_number'];?></div></td>
		    <td><?php echo $DSP['shipping_type_name'];?></td>
		    <td><?php echo $DSP['shipping_mode_name'];?></td>
		  </tr>
		  
		  <?php } ?>
		  <?php } ?>
		</tbody>
	      </table>
	    </div>
	  </div>
	  
	  <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="contact-tab">
	    
	    <?php 
	       $dispatch_date_y=date("d-m-Y", strtotime($this->session->userdata('date_now').'-1 day'));
	    $dispatch_y=$this->dashboard_model->get_dispatch_done($dispatch_date_y); ?>
	    
	    <div class="table-responsive ">
	      <table class="table table-striped table-borderless " id="orders_dispatchy">
		<thead>
		  <tr>
		    <th>Order No:</th>
		    <th>Shpping Type</th>
		    <th>Shpping Mode</th>
		  </tr>  
		</thead>
		<tbody>
		  <?php if($dispatch_y){ ?>
		  <?php foreach($dispatch_y as $DSP){
			
			?>
		  <tr  class="m-1">
		    <td class="font-weight-bold"><div class="badge badge-success"><?php echo $DSP['orderform_number'];?></div></td>
		    <td><?php echo $DSP['shipping_type_name'];?></td>
		    <td><?php echo $DSP['shipping_mode_name'];?></td>
		  </tr>
		  
		  <?php } ?>
		  <?php } ?>
		  
		  
		  
		</tbody>
	      </table>
	      
	    </div>
	  </div>
	</div>
      </div>
    </div>
    
  </div>


  <div class="col-md-3 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <p class="card-title">By Air Delivery</p>
	<div class="col-md-6 pl-md-1 pt-4 pt-md-0">
	  
	  <ul class="nav nav-tabs tab-basic" role="tablist">
	    <li class="nav-item">
	      <a class="nav-link active" id="profiled-tab" data-toggle="tab" href="#ourgoald" role="tab" aria-controls="ourgoald" aria-selected="true">Today</a>
	    </li>
	    <li class="nav-item">
	      <a class="nav-link" id="contactd-tab" data-toggle="tab" href="#historyd" role="tab" aria-controls="historyd" aria-selected="false">Yesterday</a>
	    </li>
	    
	  </ul>
	</div>
	
	<div class="tab-content tab-content-basic"  >
	  <div class="tab-pane fade show active" id="ourgoald" role="tabpanel" aria-labelledby="profiled-tab" >
	    
	    <?php
	       $dispatch_date_bya=date("d-m-Y", strtotime($this->session->userdata('date_now')));
	    $dispatch_bya=$this->dashboard_model->get_dispatch_done_by_mode($dispatch_date_bya,'11'); 
	    if($dispatch_bya)
	    {
	    ?>
	    <div class="table responsive">
	      <table class="table table-striped table-borderless" id="dispatch_by_air">
		<thead>
		  <tr>
		    <th>Order No:</th>
		    <th>Qty</th>
		  </tr>  
		  
		</thead>
		<tbody>
		  <?php
                     foreach($dispatch_bya as $disA){
                     ?>
                  <tr  class="m-1">
                    <td><?php echo $disA['orderform_number'];?></td>
                    <td><?php echo $disA['shipping_qty'];?></td>
		  </tr>
		  <?php
                     }
                     ?>
		  
		</tbody>
              </table>
	    </div>
	    <?php }else{?>
            <div class="alert alert-warning" role="alert">No details found...!</div>
            <?php } ?>
	    
	  </div>
	  <div class="tab-pane fade" id="historyd" role="tabpanel" aria-labelledby="contactdtab">
	    
	    <?php
	       $dispatch_date_bya=date("d-m-Y", strtotime($this->session->userdata('date_now').'-1 day'));
	    $dispatch_bya=$this->dashboard_model->get_dispatch_done_by_mode($dispatch_date_bya,'11'); 
	    if($dispatch_bya)
	    {
	    ?>
	    <div class="table responsive">
	      <table class="table table-striped table-borderless" id="dispatch_by_bus">
		<thead>
		  <tr>
		    <th>Order Nos:</th>
		    <th>Qty</th>
		  </tr>  
		  
		</thead>
		<tbody>
		  <?php
                     foreach($dispatch_bya as $disA){
                     ?>
                  <tr  class="m-1">
                    <td><?php echo $disA['orderform_number'];?></td>
                    <td><?php echo $disA['shipping_qty'];?></td>
		  </tr>
		  <?php
                     }
                     ?>
		  
		</tbody>
              </table>
	    </div>
	    <?php }else{?>
            <div class="alert alert-warning" role="alert">No details found...!</div>
            <?php } ?>
	    
	  </div>
	</div>
      </div>
    </div>
  </div>

	

	<div class="col-md-3 grid-margin stretch-card">
	  <div class="card">
	    <div class="card-body">
              <p class="card-title">By Bus Delivery</p>
	      <div class="col-md-6 pl-md-1 pt-4 pt-md-0">
		
		<ul class="nav nav-tabs tab-basic" role="tablist">
		  <li class="nav-item">
	      <a class="nav-link active" id="profiledb-tab" data-toggle="tab" href="#ourgoaldb" role="tab" aria-controls="ourgoaldb" aria-selected="true">Today</a>
	    </li>
	    <li class="nav-item">
	      <a class="nav-link" id="contactdb-tab" data-toggle="tab" href="#historydb" role="tab" aria-controls="historydb" aria-selected="false">Yesterday</a>
	    </li>
	    
	  </ul>
	</div>
	
	<div class="tab-content tab-content-basic"  >
	  <div class="tab-pane fade show active" id="ourgoaldb" role="tabpanel" aria-labelledby="profiledb-tab" >
	    
	    <?php
	       $dispatch_date_bya=date("d-m-Y", strtotime($this->session->userdata('date_now')));
	    $dispatch_bya=$this->dashboard_model->get_dispatch_done_by_mode($dispatch_date_bya,'12'); 
	    if($dispatch_bya)
	    {
	    ?>
	    <div class="table responsive">
	      <table class="table table-striped table-borderless" id="dispatch_by_air">
		<thead>
		  <tr>
		    <th>Order No:</th>
		    <th>Qty</th>
		  </tr>  
		  
		</thead>
		<tbody>
		  <?php
                     foreach($dispatch_bya as $disA){
                     ?>
                  <tr  class="m-1">
                    <td><?php echo $disA['orderform_number'];?></td>
                    <td><?php echo $disA['shipping_qty'];?></td>
		  </tr>
		  <?php
                     }
                     ?>
		  
		</tbody>
              </table>
	    </div>
	    <?php }else{?>
            <div class="alert alert-warning" role="alert">No details found...!</div>
            <?php } ?>
	    
	  </div>
	  <div class="tab-pane fade" id="historydb" role="tabpanel" aria-labelledby="contactdbtab">
	    
	    <?php
	       $dispatch_date_bya=date("d-m-Y", strtotime($this->session->userdata('date_now').'-1 day'));
	    $dispatch_bya=$this->dashboard_model->get_dispatch_done_by_mode($dispatch_date_bya,'12'); 
	    if($dispatch_bya)
	    {
	    ?>
	    <div class="table responsive">
	      <table class="table table-striped table-borderless" id="dispatch_by_bus">
		<thead>
		  <tr>
		    <th>Order Nos:</th>
		    <th>Qty</th>
		  </tr>  
		  
		</thead>
		<tbody>
		  <?php
                     foreach($dispatch_bya as $disA){
                     ?>
                  <tr  class="m-1">
                    <td><?php echo $disA['orderform_number'];?></td>
                    <td><?php echo $disA['shipping_qty'];?></td>
		  </tr>
		  <?php
                     }
                     ?>
		  
		</tbody>
              </table>
	    </div>
	    <?php }else{?>
            <div class="alert alert-warning" role="alert">No details found...!</div>
            <?php } ?>
	    
	  </div>
	</div>
      
	    </div>
	    
	  </div>
	</div>
      </div>      
    </div>
  </div>
</div>





    
    <?php 
       //echo $selectedDate;
       $woArray=$this->dashboard_model->get_wo_edit_request($selectedDate);
?>


<div class="row">
    <div class="col-md-6 grid-margin transparent">
        <div class="card">
            <div class="card-body">
            <p class="card-title">Edit Request</p>
			<table class="table table-striped table-borderless listing" id="listing">
            <thead>
            <tr>
            <th>Order No:</th>
            
            <th>Sales Owner</th>
            <th>Order Date</th>
            <th>Dispatch Date</th>
            <th>Action</th>
            </tr>  
        
            </thead>
            <tbody>
            <?php if($woArray){?>
            <?php foreach($woArray as $OR){ 
$accessArray=$this->rbac->check_operation_access_my_account('workorder');
?>


            <tr>
            <td><?php echo $OR['orderform_number'];?></td>
            
            <td><?php echo $OR['staff_name'];?></td>
            <td><?php  echo substr($OR['wo_date_time'],0,10);?></td>
            <td><?php echo date("d-m-Y", strtotime($OR['wo_dispatch_date']));?></td>
            <td><?php            
if(in_array("edit_approval",$accessArray)){

?>

<a title="Approve Edit Request"  onclick="return  approveEditRow();" href="<?= base_url('work/approve_request_dashboard/'.$OR['order_uuid']); ?>" ><label class="badge badge-outline-warning ml-1" title="Approve Edit Request" >Approve</label></a>
<?php
}

?></td>
            </tr>
            <?php } ?>
            <?php } ?>
            </tbody>
            </table>
            </div>
        </div>



    </div>
<?php 
//echo $selectedDate;
$submitted=date("d-m-Y", strtotime($this->session->userdata('date_now')));
$woArray2=$this->dashboard_model->get_wo_submitted($submitted);
?>
	 <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <p class="card-title">Order Submitted</p>
			<table class="table table-striped table-borderless listing" id="listing">
            <thead>
            <tr>
            <th>Order No:</th>
            
            <th>Sales Owner</th>
            <th>Order Date</th>
            <th>Dispatch Date</th>
            </tr>  
        
            </thead>
            <tbody>
            <?php if($woArray2){?>
            <?php foreach($woArray2 as $OR2){ ?>
            <tr>
            <td><?php echo $OR2['orderform_number'];?></td>
            
            <td><?php echo $OR2['staff_name'];?></td>
            <td><?php  echo substr($OR2['wo_date_time'],0,10);?></td>
            <td><?php echo date("d-m-Y", strtotime($OR2['wo_dispatch_date']));?></td>
            </tr>
            <?php } ?>
            <?php } ?>
            </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<script>
function approveEditRow(){
          if(confirm("Are you sure you want to approve the edit request.?")){
                  return true;
          }
          return false;
}
	
(function($) {
'use strict';
$(function() {
$('.listing').DataTable({
"aLengthMenu": [
[5, 10, 15, -1],
[5, 10, 15, "All"]
],
"iDisplayLength": 5,
"language": {
search: ""
}
});
$('.listing').each(function() {
var datatable = $(this);
// SEARCH - Add the placeholder for Search and Turn this into in-line form control
var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
search_input.attr('placeholder', 'Search');
search_input.removeClass('form-control-sm');
// LENGTH - Inline-Form control
var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
length_sel.removeClass('form-control-sm');
});
});
})(jQuery);
</script>
