<?php //print_r($_POST);?>
<?php //echo $this->security->get_csrf_hash();?>
<style>
.error{
	color:#F00;
}
</style>
<?php
$wo_ref_no='';
$readonly='';
$refData = $this->workorder_model->get_summary_item_data($order_summary_id);
//print_r($refData);
//$wo_ref_no=$refData['wo_ref_no'];
if($refData['summary_parent']!=0) {
$readonly='readonly="readonly"';
}
 $product_fit = $this->workorder_model->get_product_fit();
?>
<?php $options = $this->workorder_model->get_all_order_options_latest($order_summary_id,$refData['wo_option_session_id']); ?>
<form action="post" id="mform">
<input type="hidden" id="order_summary_id" name="order_summary_id" value="<?php echo $refData['order_summary_id'];?>" />
<input type="hidden" id="summary_client_id" name="summary_client_id" value="<?php echo $refData['summary_client_id'];?>" />
<input type="hidden" id="summary_parent" name="summary_parent" value="<?php echo $refData['summary_parent'];?>" />
<input type="hidden" id="wo_qty" name="wo_qty" value="1" />
<input type="hidden" id="wo_order_id" name="wo_order_id" value="<?php echo $refData['wo_order_id'];?>" />


<div class="modal-body">
<span id="responseModel"></span>
<?php if($refData['summary_parent']==0) {?>
<h5 class="card-title">Customer Details</h5>

<div class="form-group">
<div class="row">
	<div class="col-md-4">
    <label>Mobile Number</label>
    <div class="form-group">
    <input type="text" class="form-control" id="customer_mobile_no" name="customer_mobile_no" placeholder="Mobile Number" maxlength="10" minlength="10" onkeyup="chkphonenumber_cust(this.value);" value="<?php echo $refData['summary_client_mobile'];?>">
    </div>
    </div>
    
    <div class="col-md-4">
    <label>Name</label>
    <div class="form-group">
    <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Name" value="<?php echo $refData['summary_client_name_only'];?>">
    </div>
    </div>

    <div class="col-md-4">
    <label>Email</label>
    <div class="form-group">
    <input type="text" class="form-control" id="customer_email" name="customer_email" placeholder="Email" value="<?php echo $refData['summary_client_email'];?>">
    </div>
    </div>
</div>
</div>
<?php } ?>
<h5 class="card-title">Order Details</h5>  
<div class="form-group">
<div class="row">
	<div class="col-md-2">
    <label>Reference Number</label>
    <div class="form-group">
    <input type="text" class="form-control" id="wo_ref_no" name="wo_ref_no" placeholder="Reference Number" maxlength="50" minlength="1" value="<?php echo $refData['wo_ref_no'];?>"  <?php echo $readonly;?>>
    </div>
    </div>
    
    <div class="col-md-2">
    <label>Product</label>
    <div class="form-group">
    <select class="form-control required js-example-basic-single" id="wo_product_type_id" name="wo_product_type_id" style="width:100%" > 

    <?php if($product_types){ ?>
    <?php foreach($product_types as $PT){ ?>
    <option value="<?php echo $PT['product_type_id'];?>" <?php if($PT['product_type_id']==$refData['wo_product_type_id']){ echo 'selected="selected"';}?>  ><?php echo $PT['product_type_name'];?> (<?php echo $PT['product_type_amount'];?>)</option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>

    <div class="col-md-2">
    <label>Collar</label>
    <div class="form-group">
    <select class="form-control required js-example-basic-single"  id="wo_collar_type_id" name="wo_collar_type_id" style="width:100%">
    <?php if($collar_types){ ?>
    <?php foreach($collar_types as $CT){ ?>
    <option value="<?php echo $CT['collar_type_id'];?>" <?php if($CT['collar_type_id']==$refData['wo_collar_type_id']){ echo 'selected="selected"';}?>><?php echo $CT['collar_type_name'];?> (<?php echo $CT['collar_amount'];?>)</option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>
    
    <div class="col-md-2">
    <label>Sleeve</label>
    <div class="form-group">
    <select class="form-control required js-example-basic-single" id="wo_sleeve_type_id" name="wo_sleeve_type_id" style="width:100%" > 
    <option value="" stvalue="0">--- Select ---</option>
    <?php if($sleeve_types){ ?>
    <?php foreach($sleeve_types as $ST){ ?>
    <option value="<?php echo $ST['sleeve_type_id'];?>" <?php if($ST['sleeve_type_id']==$refData['wo_sleeve_type_id']){ echo 'selected="selected"';}?> ><?php echo $ST['sleeve_type_name'];?> (<?php echo $ST['sleeve_type_amount'];?>)</option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>
    
    <div class="col-md-2">
    <label>Fabric</label>
    <div class="form-group">
    <select class="form-control required js-example-basic-single"  id="wo_fabric_type_id" name="wo_fabric_type_id" style="width:100%"  > 

    <?php if($fabric_types){ ?>
    <?php foreach($fabric_types as $FT){ ?>
    <option value="<?php echo $FT['fabric_type_id'];?>" <?php if($FT['fabric_type_id']==$refData['wo_fabric_type_id']){ echo 'selected="selected"';}?>><?php echo $FT['fabric_type_name'];?> (<?php echo $FT['fabric_amount'];?>)</option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>
    
    <div class="col-md-2">
    <label>Add-ons</label>
    <div class="form-group">
	<link rel="stylesheet" href="<?php echo base_url()?>public/dist/css/bootstrap-multiselect.css" type="text/css">
    <script type="text/javascript" src="<?php echo base_url()?>public/dist/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
 	 $(".js-example-basic-single").select2();
    $('#addons_ids').multiselect({
    numberDisplayed: 1
    });
    });
    </script>
	<?php
	$wo_item_addons="";
	if($refData['wo_item_addons']!=""){
		$wo_item_addons=explode(",",$refData['wo_item_addons']);
	}
	?>
<input type="hidden" name="wo_addon_id" id="wo_addon_id" value="0" />
    <select id="addons_ids" class="form-control" multiple="multiple" name="addons_ids[]">
    <?php if($addons){ ?>
    <?php foreach($addons as $AD){ ?>
    <option value="<?php echo $AD['addon_id'];?>" <?php if(in_array($AD['addon_id'],$wo_item_addons)){ echo 'selected="selected"';}?>><?php echo $AD['addon_name'];?> (<?php echo $AD['addon_amount'];?>)</option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>
    
    <div class="col-md-4">
    <label>Image Back Url</label>
    <div class="form-group">
    <input type="text" class="form-control" id="wo_img_back" name="wo_img_back" value="<?php echo $refData['wo_img_back'];?>" >
    </div>
    </div>
    
    <div class="col-md-4">
    <label>Image Front Url</label>
    <div class="form-group">
    <input type="text" class="form-control" id="wo_img_front" name="wo_img_front"  value="<?php echo $refData['wo_img_front'];?>" >
    </div>
    </div>
    <div class="col-md-4">
    <label>Remark</label>
    <div class="form-group">
    <input type="text" class="form-control" id="wo_remark" name="wo_remark" placeholder="Remark" value="<?php echo $refData['wo_remark'];?>" >
    </div>
    </div>
</div>
</div>  
<?php include("order_option_edit.php");?>
<?php if($refData['summary_parent']==0) {?>
<h5 class="card-title">Order Details</h5> 
<div class="form-group">
<div class="row">
	
    <?php if($refData['summary_parent']==0) {?>
    <div class="col-md-4">
    <label>Shipping Type</label>
    <div class="form-group">
    <select class="form-control required"  id="wo_shipping_type_id" name="wo_shipping_type_id" > 
    <option value="" advalue='0'>--- Select ---</option>
    <?php if($shipping_types){ ?>
    <?php foreach($shipping_types as $SHT){ ?>
    <option value="<?php echo $SHT['shipping_type_id'];?>" <?php if($SHT['shipping_type_id']==$refData['wo_shipping_type_id']){ echo 'selected="selected"';}?> ><?php echo $SHT['shipping_type_name'];?></option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>
    <?php } ?>
    
    
    
    
<?php if($refData['summary_parent']==0) {?>
    <div class="col-md-8">
    <label>Shipping Address</label>
    <div class="form-group">
    <textarea type="text" class="form-control required" id="wo_shipping_address" name="wo_shipping_address" placeholder="Shipping Address"><?php echo $refData['wo_shipping_address'];?></textarea>
    </div>
    </div>
  <?php } ?>
  
  
   
</div>
</div>
<?php } ?>

</div>
<div class="modal-footer">

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

<input type="hidden" name="wo_option_session_id" value="<?php echo $refData['wo_option_session_id'];?>">
<button type="submit" class="btn btn-success" id="submit" name="submit">Update</button>
<button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
</div>

</form>
<script type="text/javascript">
function chkphonenumber_cust(pno){
	//alert(pno);
	var post_data = {
	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
	};
	$('#pnoresponse').html("<p style='text-align:center; color:#030;'>Checking... </p>");
	$.ajax({
	type: "POST",
	 dataType: 'json',
	url: "<?= base_url("workorder/customermobajax/");?>"+pno+"/0",
	data: post_data
	}).done(function(reply) {
		
		if(reply.responseCode=="yes"){
			$('#summary_client_id').val(reply.customer_id);
			$('#customer_name').val(reply.customer_name);
			$('#customer_name').attr('readonly', true);
			$('#customer_email').val(reply.customer_email);
			$('#customer_email').attr('readonly', true);
		}else{
			$('#summary_client_id').val("");
			$('#customer_name').val("");
			$('#customer_name').attr('readonly', false);
			$('#customer_email').val("");
			$('#customer_email').attr('readonly', false);
		}
		//$('#loadClientData').html(reply);
	});
}
$(document).ready(function() {



$('#editRefNo').on('hidden.bs.modal', function () { 
    //location.reload();
	$('#contentDiv').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
	var post_data = {
	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
	'<?php echo 'wo_order_id'; ?>' : '<?php echo $refData['wo_order_id'];?>'
	};
	$.ajax({
	type: "POST",
	url: "<?= base_url("workorder/summary_items_ajax_data/");?>",
	data: post_data
	}).done(function(reply) {
		$('#contentDiv').html(reply);
	});
});

$("#mform").validate({
submitHandler: function() {
//$("#submit").attr("disabled", "disabled");
//$("#response").html('Data Saving...');
$('#submit').html('<i class="fa fa-asterisk fa-spin  text-warning"></i> Please wait..!');
$.post('<?= base_url("workorder/update_order_summary_in_detail_online/");?>', $("#mform").serialize(), function(data) {
	var dataRs = jQuery.parseJSON(data);
	//$('#submitButton').html('Submit');
	$(window).scrollTop(0);
	$('#submit').html("Update");
	$("#responseModel").html(dataRs.responseMsg);
	//return false;
});	
}
});	

});
</script>

