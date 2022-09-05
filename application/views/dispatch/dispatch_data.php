<?php 

if($_POST['orderform_type_id']==1){ 
	$wo_order_id=$_POST['order_id'];
	$sel="SELECT * FROM wo_customer_shipping WHERE  wo_order_id='$wo_order_id' LIMIT 1 ";
	$query = $this->db->query($sel);					 
   	$itemInfo=$query->row_array();
	
	$wo_client_id=$_POST['wo_client_id'];
	$sel_cus="SELECT * FROM customer_master WHERE  customer_id='$wo_client_id' LIMIT 1 ";
	$query_cus = $this->db->query($sel_cus);					 
	$custInfo=$query_cus->row_array();

	$dispatch_customer_id=$custInfo['customer_id'];
	$dispatch_client_name=$custInfo['customer_name'];
	$summary_client_mobile=$custInfo['customer_mobile_no'];
	$summary_client_email=$custInfo['customer_email'];

	$shipping_type_id=0;
	$shipping_mode_id=$order_info['wo_shipping_mode_id'];
	$dispatch_address=$itemInfo['shipping_address'];
	
	 $sel_wo="SELECT wo_shipping_mode_id FROM wo_work_orders where  order_id='$wo_order_id' LIMIT 1 ";
        $query_wo = $this->db->query($sel_wo);
        $worInfo=$query_wo->row_array();

        $selected_wo_shipping_mode_id=$worInfo['wo_shipping_mode_id'];

	
}else{
	//$wo_order_id=$_POST['order_id'];
	//$sel="SELECT * FROM wo_order_summary WHERE  wo_order_id='$wo_order_id'  ";
	//$query = $this->db->query($sel);					 
    //$itemInfo=$query->row_array();
	
}

?>

<div class="card">
<div class="card-body">
<form name="updateDispatch" id="updateDispatch">
<?php
//$dispatch_id=$_POST['dispatch_id'];
//$dispatch_row=$this->dispatch_model->get_dispatch_row($dispatch_id);
if($_POST['dispatch']){
	$dispCount=0;
	$inc=0;
	foreach($_POST['dispatch'] as $dRow){
		$dispCount+=$dRow['dispatch_qty'];
		$inc++;
		?>
		<input type="hidden"  name="dispatchPost[<?php echo $inc;?>][dispatch_qty]" value="<?php echo $dRow['dispatch_qty'];?>" />
		<input type="hidden" name="dispatchPost[<?php echo $inc;?>][completed_id]" value="<?php echo $dRow['completed_id'];?>" />
		<input type="hidden" name="dispatchPost[<?php echo $inc;?>][order_summary_id]" value="<?php echo $dRow['order_summary_id'];?>" />
		<?php
	}
	//echo $dispCount;exit;
	if($dispCount==0){
		echo '<div class="alert alert-fill-danger" role="alert"><i class="icon-exclamation"></i>Sorry...Not find any dispatch item count!!!</div>.';
		exit;
	}
}else{
	echo '<div class="alert alert-fill-danger" role="alert"><i class="icon-exclamation"></i>Sorry...Not find any dispatch item</div>.';
	exit;
}
?>
<h4 class="card-title">Customer Dispatch Details</h4>

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<input type="hidden" name="actn" value="insert">
<input type="hidden" name="dispatch_order_id" value="<?php echo $_POST['order_id'];?>">
<input type="hidden" name="rs_design_id" value="<?php echo $_POST['rs_design_id'];?>">
<input type="hidden" name="orderform_type_id" value="<?php echo $_POST['orderform_type_id'];?>">

<input type="hidden" name="dispatch_customer_id" value="<?php echo $dispatch_customer_id;?>">
<input type="hidden" name="summary_client_mobile" value="<?php echo $summary_client_mobile;?>">
<input type="hidden" name="summary_client_email" value="<?php echo $summary_client_email;?>">
<input type="hidden" class="form-control required" data-inputmask="'alias': 'date'" name="dispatch_date" id="dispatch_date" value="<?php echo date('d/m/Y');?>">
<div class="form-group row">

<div class="col">
<label>Customer Name:</label>
<input  type="text" class="form-control required"  name="dispatch_client_name" id="dispatch_client_name" value="<?php echo $dispatch_client_name;?>">
</div>
</div>
<div class="form-group">
<label for="exampleInputEmail1">Address</label>
<textarea type="text" class="form-control required" id="dispatch_address"  name="dispatch_address"  rows="4"><?php echo $dispatch_address;?></textarea>
</div>
<div class="form-group row">
<div class="col">
<label>Shipping Type:</label>
<select class="form-control required" id="shipping_type_id" name="shipping_type_id">
<?php if($shipping_types){ ?>
<option value="">--- Select ---</option>
<?php foreach($shipping_types as $ST){ ?>
<option value="<?php echo $ST['shipping_type_id'];?>" <?php if($ST['shipping_type_id']==$shipping_type_id){ echo 'selected="selected"'; } ?> ><?php echo $ST['shipping_type_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>

<div class="col">
<label>Shipping Mode:</label>
<select class="form-control required" id="shipping_mode_id" name="shipping_mode_id">
<?php if($shipping_modes){ ?>
<option value="">--- Select ---</option>
<?php foreach($shipping_modes as $SM){ ?>
<option value="<?php echo $SM['shipping_mode_id'];?>" <?php if($SM['shipping_mode_id']==$selected_wo_shipping_mode_id){ echo 'selected="selected"'; } ?>><?php echo $SM['shipping_mode_name'];?></option>
<?php } ?>	     
<?php } ?>
</select>
</div>
</div>


<div class="form-group">
<label for="exampleInputEmail1">Traking Info</label	>
<textarea type="text" class="form-control" id="tracking_info"  name="tracking_info"  rows="4"></textarea>
</div>
<div class="form-group row">
<div class="col">
<label>Customer Mobile No:</label>
<input class="form-control"  name="mobile_number" id="mobile_number" value="<?php echo trim($summary_client_mobile);?>">
</div>
</div>
<div class="form-group row">
<div class="col">
<label>Tracking ID:</label>
<input class="form-control"  name="tracking_number" id="tracking_number">
</div>
<div class="col">
<label>Status:</label>
<select class="form-control required" id="dispatch_status" name="dispatch_status">
<option value="">--- Select ---</option>
<option value="Dispatched" <?php if(1==$dispatch_row['dispatch_status']){ echo 'selected="selected"'; } ?>>Dispatched</option>
<option value="Not Dispatched" <?php if(0==$dispatch_row['dispatch_status']){ echo 'selected="selected"'; } ?>>Not Dispatched</option>
</select>
</div>
</div>

<button type="submit" class="btn btn-primary mr-2" id="submitDataa" name="submitData" value="Submit">Submit</button>
<span id="action_resp"></span>
</form>
</div>
</div>

<script type="text/javascript">
$(function() {
	$("#updateDispatch").validate({
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
	$("#submitDataa").attr("disabled", "disabled");
	$('#submitDataa').html("Please Wait ...");
	$.post('<?= base_url("dispatch/save_dispatch/");?>', $("#updateDispatch").serialize(), function(data) {
		var dataRs = jQuery.parseJSON(data);
		if(dataRs.responseCode=="F"){
			$('#submitDataa').html("Submit");
			$('#action_resp').html(dataRs.responseMsg);
			$('#updateStatusForm' ).each(function(){this.reset();});
		}else{
			//window.location.reload();
			$('#action_resp').html(dataRs.responseMsg);
			setTimeout(function() {
			 window.location.reload()
			}, 1000);  
		}
	});	
	}
	});	
});
</script> 