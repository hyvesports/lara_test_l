<?php
//echo '123';
$wo_order_id=$order_info['order_id'];
?>
<div class="content-wrapper">
<div class="row">

<div class="col-md-7 grid-margin grid-margin-md-0 ">
<div class="card">
<form action="post" id="dispatchOrder" name="dispatchOrder">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<input type="hidden" name="orderform_type_id" value="<?php echo $order_info['orderform_type_id'];?>">
<input type="hidden" name="order_id" value="<?php echo $wo_order_id;?>">

<input type="hidden" name="rs_design_id" value="<?php echo $rowResponse['rs_design_id'];?>">
<input type="hidden" name="wo_client_id" value="<?php echo $order_info['wo_client_id'];?>">
    <div class="card-body ">
    <h4 class="card-title">Dispatch Details </h4>
    <div class="add-items">
	<label>Order Number</label>
    <input type="text" class="form-control todo-list-input" placeholder="Order Number" value="<?php echo $order_info['orderform_number'];?>" readonly="readonly">
    </div>
	<?php //print_r($schedule_data);?>
	<?php 
	$summary=$this->workorder_model->get_order_summary_in_detail($order_info['order_id']); 
	//print_r($schedule_data);
	?>
    <table class="table w-100">
    <thead>
    <th>Item</th>
    <th>Quantity</th>
    <th>Dispatch Qty</th>
    </thead>
    <tbody>
    	<?php if($summary) { $inc=0; $count_item=count($summary);?>
		<?php foreach($summary as $item) { $inc++;
		$lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($schedule_data['schedule_id'],$item['order_summary_id'],'stitching','final_qc');

		$completedRow=$this->common_model->get_item_from_completed_with_schedule_dep_id($order_info['order_id'],$lastUpdateRow['schedule_department_id'],$item['order_summary_id']); 
		//print_r($completedRow);
		$dispatchedRow=$this->common_model->get_dispatched_data($order_info['order_id'],$item['order_summary_id']); 
		if($completedRow['completed_id']!=""){
		$inc++;
		?>
        <tr>
        <td class="py-1 pl-0" valign="top" width="60%">
        <div class="d-flex align-items-center">
        <div class=" mb-3"><strong class=" mb-3"><?php echo $inc;?>.<?php echo ucwords($item['wo_product_type_name']);?></strong><br/>
        <?php if(isset($item['online_ref_number'])){ if($item['online_ref_number']!=""){?>
        <p class="mb-2 mt-2">Ref: No: <?php echo ucwords($item['online_ref_number']);?></p>
        <?php } }?>
        <span class="align-items-center mt-1">
        <span class="badge badge-primary m-1"><?php echo ucwords($item['wo_collar_type_name']);?></span>
        <span class="badge badge-primary m-1"><?php echo ucwords($item['wo_sleeve_type_name']);?></span>
        <span class="badge badge-primary m-1"><?php echo ucwords($item['wo_fabric_type_name']);?></span>
        <?php if($item['wo_item_addons_names']!=""){ ?>
        <span class="badge badge-primary m-1"><?php echo ucwords($item['wo_item_addons_names']);?></span>
        <?php } ?>
        </span>
        </div>
        </div>
        </td>
        <td width="20%">
		
		<?php 
		$DISPATCH_QTY=0;
		$avlQty=0;
		if($dispatchedRow['DISPATCH_QTY']!=""){
			$DISPATCH_QTY=$dispatchedRow['DISPATCH_QTY'];
		}
		$avlQty=$completedRow['qc_approved_qty']-$DISPATCH_QTY;
		?>
		<label class="badge badge-info" title="Total Qty"><?php echo $item['wo_qty'];?></label>
		<label class="badge badge-success" title="Qc Approved Qty"><?php echo $completedRow['qc_approved_qty'];?></label>
		<label class="badge badge-warning" title="Dispatched Qty"><?php echo $DISPATCH_QTY;?></label>
		</td>
       <td width="20%">
		<?php if($avlQty>0){ ?>
       <input maxlength="5" type="text" name="dispatch[<?php echo $inc;?>][dispatch_qty]" class="form-control text-center required number"  max='<?php echo $avlQty;?>' value="<?php echo $avlQty;?>" min='0'/>
		<?php }else{ ?>
		<label class="badge badge-danger w-100" title="Dispatched Qty"><?php echo $avlQty;?></label>
		<?php } ?>


		<input type="hidden" name="dispatch[<?php echo $inc;?>][completed_id]" value="<?php echo $completedRow['completed_id'];?>" />
		<input type="hidden" name="dispatch[<?php echo $inc;?>][order_summary_id]" value="<?php echo $item['order_summary_id'];?>" />

        </td>
        </tr>
		<?php }else{ ?>
		
		<tr>
        <td class="py-1 pl-0" valign="top" width="60%">
        <div class="d-flex align-items-center">
        <div class=" mb-3"><strong class=" mb-3"><?php echo $inc;?>.<?php echo ucwords($item['wo_product_type_name']);?></strong><br/>
        

        <?php if(isset($item['online_ref_number'])){ if($item['online_ref_number']!=""){?>
        <p class="mb-2 mt-2">Ref: No: <?php echo ucwords($item['online_ref_number']);?></p>
        <?php } }?>
        <span class="align-items-center mt-1">
        <span class="badge badge-primary m-1"><?php echo ucwords($item['wo_collar_type_name']);?></span>
        <span class="badge badge-primary m-1"><?php echo ucwords($item['wo_sleeve_type_name']);?></span>
        <span class="badge badge-primary m-1"><?php echo ucwords($item['wo_fabric_type_name']);?></span>
        <?php if($item['wo_item_addons_names']!=""){ ?>
        <span class="badge badge-primary m-1"><?php echo ucwords($item['wo_item_addons_names']);?></span>
        <?php } ?>
        </span>
        </div>
        </div>
        </td>
        <td width="20%">
		<label class="badge badge-info" title="Total Qty"><?php echo $item['wo_qty'];?></label>
		<label class="badge badge-success" title="Qc Approved Qty">0</label>
		<label class="badge badge-warning" title="Qc Approved Qty">0</label>
		</td>
       <td width="20%"><label class="badge badge-danger w-100" >0</label></td>
        </tr>
		<?php } ?>
		<?php } } ?>
    </tbody>
    </table><div class="col-md-12 "> <button type="submit"  class="btn btn-success w-100" id="submitData" name="submitData">Load Dispatch Details</button></div>
    </div>
  
</form>
</div>
</div>
<?php 
$trackings=$this->dispatch_model->get_my_order_trackings($wo_order_id);
?>
<div class="col-md-5 grid-margin grid-margin-md-0 " id="dispatchContent">

<div class="card">
<div class="card-body">
<h4 class="card-title">Dispatched Orders</h4>

<div class="table-responsive">
<div id="actionResponse"></div>
<table class="table">
<thead>
<tr>
<th class="pt-1 pl-0">Address</th>
<th>Tracking ID</th>
<th class="pt-1">Shipping Type/Mode</th>
<th>Action</th>
</tr>
</thead>
<tbody>
	<?php if($trackings){ $i=0;  $tcount=count($trackings);?>
    <?php foreach($trackings as $track){ $i++; ?>
	<?php $dis=$this->dispatch_model->get_my_order_dispatches_by_wo($wo_order_id,$track['dispatch_tracking_id']); ?>
    <tr id="currentTD<?php echo $track['dispatch_tracking_id'];?>">
    <td class="py-1 pl-0">
    <div class="d-flex align-items-center">
   <div class="ml-0">
    <p class="mb-2"><?php echo $dis['dispatch_client_name'];?></p>
    <p class="mb-0 text-muted text-small"><?php echo nl2br($dis['dispatch_address']);?></p>
    </div>
    </div>
    </td>
	<td><?php echo $track['traking_number'];?></td>
    <td><?php echo $dis['shipping_type_name'];?>/<?php echo $dis['shipping_mode_name'];?></td>
 
    <td>
	
<a href="#" class="badge badge-primary  float-center" title="Update" style="cursor: pointer;"  data-toggle="modal" data-target="#orderDispatch" 
 data-woid="<?php echo $wo_order_id;?>" data-tid="<?php echo $track['dispatch_tracking_id'];?>" data-actn='up'  ><i class="fa fa-search"></i></a>
<?php if($tcount!=0){ ?>
<a href="javascript:void(0);" class="badge badge-danger  float-center delete_button" id="<?php echo $track['dispatch_tracking_id'];?>"><i class="fa fa-trash"></i></a>
<?php } ?>
    </td>
    </tr>
	<?php } } ?>
</tbody>

</table>
<div class="modal" id="orderDispatch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>

</div>
</div>
</div>
</div>

</div>







</div>

<script type="text/javascript">
$(document).ready(function() {
$("#dispatchOrder").validate({
highlight: function(element) {
$(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
},
unhighlight: function(element) {
$(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid');
},
errorElement: 'p',
errorClass: 'text-danger',
errorPlacement: function(error, element) {
if (element.parent('.input-group').length || element.parent('label').length) {
error.insertAfter(element.parent());
} else {
error.insertAfter(element);
}
},
submitHandler: function() {
//$("#loginAccount").attr("disabled", "disabled");
$('#submitData').html("<i class='fa fa-spin fa-spinner'></i> Please Wait ...");
$('#dispatchContent').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
$("#submitData").attr("disabled", "disabled");
$.post('<?= base_url("dispatch/load_dispatch_data/");?>', $("#dispatchOrder").serialize(), function(data) {
	
	$("#dispatchContent").html(data);
	$('#submitData').html("Load Dispatch Details");
	
});	
}
});

$(".delete_button").click(function() {
	var id = $(this).attr("id");
	//var dataString = 'id='+id+"&postaction=remove";
	var dataString = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&id="+id;
	//alert(dataString);
	var parent = $(this).closest("tr");
		if(confirm("Are you want to delete.?")){
			$("#currentTD"+id).fadeOut();
			$('#actionResponse').html('<div style="background:#FFF;text-align:center;"><strong>Please wait...</strong></div>');
			$.ajax({
			type: "POST",
			url: "<?= base_url("dispatch/drop/");?>",
			data: dataString,
			cache: false,
		
			success: function(data)
			{
							
				if(data==1){
					$("#actionResponse").html('<div class="alert alert-success fade in block"><button data-dismiss="alert" class="close" type="button">x</button><i class="icon-checkmark3"></i>Success. Data deleted successfully..!</div>');
					parent.slideUp(300,function() {
						parent.remove();
					});
				}else {
					$("#actionResponse").html(data);
				}
			}
		   
			});
	
		return false;
		}
	});
});
</script>

<script>

$(function() {
$('#orderDispatch').on('hidden.bs.modal', function () {location.reload();});
$('#orderDispatch').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget);
var woid=button.data('woid');
var tid=button.data('tid');
var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&woid="+woid+"&tid="+tid;
//var cid=button.data('cid');
//alert(oid);
var modal = $(this);
//var dataString = "cuid="+cuid;
$.ajax({  
type: "POST",
url: "<?= base_url("dispatch/load_dispatch_model/");?>",  
data: formData,
beforeSend: function(){
modal.find('.modal-content').html('<i class="fa fa-spin fa-refresh"></i>');},
success: function(response){
modal.find('.modal-content').html(response); 
}
}); 
});  
});
</script>

