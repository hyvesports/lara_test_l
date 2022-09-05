<style>
.error{
	color:#F00;
}
</style>

<?php
$wo_ref_no='';
$readonly='';
$refData = $this->workorder_model->get_summary_draft_data($online_draft_id);
//print_r($refData);
$wo_ref_no=$refData['wo_ref_no'];
if($refData['online_draft_parent_id']!=0) {
$readonly='readonly="readonly"';
}

$csession_id=$this->session->userdata('log_session_id');
$current_l_id=$this->session->userdata('loginid');
$options = $this->workorder_model->get_added_order_options_latest($online_draft_id,$csession_id,$current_l_id);
//print_r($options);
?>

<form id="mformEdit" name="mformEdit">

<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $refData['customer_id'];?>" />

<input type="hidden" id="online_draft_parent_id" name="online_draft_parent_id" value="<?php echo $refData['online_draft_parent_id'];?>" />

<input type="hidden" id="online_draft_id" name="online_draft_id" value="<?php echo $refData['online_draft_id'];?>" />

<input type="hidden" id="wo_current_form_no" name="wo_current_form_no" value="<?php echo $refData['current_form_id'];?>" />

<div class="modal-body">

<span id="response"></span>

<?php if($refData['online_draft_parent_id']==0) {?>

<h5 class="card-title">Customer Details</h5>



<div class="form-group">

<div class="row">

	<div class="col-md-4">

    <label>Mobile Number</label>

    <div class="form-group">

    <input type="text" class="form-control" id="customer_mobile_no" name="customer_mobile_no" placeholder="Mobile Number" minlength="20" minlength="20" onkeyup="chkphonenumber_cust(this.value);" value="<?php echo $refData['customer_mobile_no'];?>">

    </div>

    </div>

    

    <div class="col-md-4">

    <label>Name</label>

    <div class="form-group">

    <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Name" value="<?php echo $refData['customer_name'];?>">

    </div>

    </div>



    <div class="col-md-4">

    <label>Email</label>

    <div class="form-group">

    <input type="text" class="form-control" id="customer_email" name="customer_email" placeholder="Email" value="<?php echo $refData['customer_email'];?>">

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
    <select class="form-control required js-example-basic-single" id="wo_product_type_id" name="wo_product_type_id"  style="width:100%" > 
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
    <select class="form-control required js-example-basic-single"  id="wo_collar_type_id" name="wo_collar_type_id"  style="width:100%"> 

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
    <select class="form-control required js-example-basic-single" id="wo_sleeve_type_id" name="wo_sleeve_type_id" style="width:100%"> 
    
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
	<input type="hidden" name="wo_addon_id" id="wo_addon_id" value="0" />
	<?php
	$addonArray=0;
	if($refData['item_addons']==""){
	$addonArray=0;
	}else{
		$addonArray=$refData['item_addons'];
		$addonArray=explode(',',$addonArray);
	}
	?>
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
	
	 
    <select id="addons_ids" class="form-control" multiple="multiple" name="addons_ids[]">
    <?php if($addons){ ?>
    <?php foreach($addons as $AD){ ?>
    <option value="<?php echo $AD['addon_id'];?>" <?php if(in_array($AD['addon_id'],$addonArray)){ echo 'selected="selected"';}?>  ><?php echo $AD['addon_name'];?> (<?php echo $AD['addon_amount'];?>)</option>
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



<?php include('order_option_edit.php');?>

<?php if($refData['online_draft_parent_id']==0) {?>

<h5 class="card-title">Order Details</h5>  

<div class="form-group">

<div class="row">

	

    <?php if($refData['online_draft_parent_id']==0) {?>

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

    

    

    

    

<?php if($refData['online_draft_parent_id']==0) {?>

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
<input type="hidden" name="current_s_id" id="current_s_id" value="<?php echo $this->session->userdata('log_session_id');?>" />
<input type="hidden" name="current_l_id" id="current_l_id" value="<?php echo $this->session->userdata('loginid');;?>" />
<button type="submit" class="btn btn-success" id="submitmformEdit" name="submit">Update</button>
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

			$('#customer_id').val(reply.customer_id);

			$('#customer_name').val(reply.customer_name);

			$('#customer_name').attr('readonly', true);

			$('#customer_email').val(reply.customer_email);

			$('#customer_email').attr('readonly', true);

		}else{

			$('#customer_id').val("");

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
	'<?php echo 'current_id'; ?>' : '<?php echo $refData['current_form_id'];?>'
	};
	$.ajax({
	type: "POST",
	url: "<?= base_url("workorder/draft_data/");?>",
	data: post_data
	}).done(function(reply) {
		$('#contentDiv').html(reply);

	});
});



$("#mformEdit").validate({

submitHandler: function() {

//$("#submit").attr("disabled", "disabled");

//$("#response").html('Data Saving...');

$('#submitmformEdit').html('<i class="fa fa-asterisk fa-spin  text-warning"></i> Please wait..!');

$.post('<?= base_url("workorder/online_ajax_post_edit/");?>', $("#mformEdit").serialize(), function(data) {

	var dataRs = jQuery.parseJSON(data);

	//$('#submitButton').html('Submit');

	//$("#response").html(dataRs.responseCode);

	if(dataRs.responseCode=="success"){ 

		$('#editRefNo').modal('toggle');

		$('#contentDiv').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');

		var post_data = {

		'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',

		'<?php echo 'current_id'; ?>' : '<?php echo $refData['current_form_id'];?>'

		};

		$.ajax({

		type: "POST",

		url: "<?= base_url("workorder/draft_data/");?>",

		data: post_data

		}).done(function(reply) {

			$('#contentDiv').html(reply);

		});

	}else{

		$("#response").html(dataRs.responseMsg);

	}

	

	//return false;

});	

}

});	



});

</script>

