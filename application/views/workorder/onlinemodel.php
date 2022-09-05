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
if($pORc!=0) {
$refData = $this->workorder_model->get_summary_draft_data($pORc);
$wo_ref_no=$refData['wo_ref_no'];
$readonly='readonly="readonly"';
} 
?>
<form action="post" id="mform">
<input type="hidden" id="customer_id" name="customer_id" />
<input type="hidden" id="online_draft_parent_id" name="online_draft_parent_id" value="<?php echo $pORc;?>" />
<input type="hidden" class="form-control text-center required number" id="wo_qty" name="wo_qty"  min='1' value="1" >
<div class="modal-body">
<span id="response"></span>
<?php if($pORc==0) {?>
<h5 class="card-title">Customer Details</h5>

<div class="form-group">
<div class="row">
	<div class="col-md-4">
    <label>Mobile Number</label>
    <div class="form-group">
    <input type="text" class="form-control" id="customer_mobile_no" name="customer_mobile_no" placeholder="Mobile Number" maxlength="20" minlength="10" onkeyup="chkphonenumber_cust(this.value);">
    </div>
    </div>
    
    <div class="col-md-4">
    <label>Name</label>
    <div class="form-group">
    <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Name">
    </div>
    </div>

    <div class="col-md-4">
    <label>Email</label>
    <div class="form-group">
    <input type="text" class="form-control email" id="customer_email" name="customer_email" placeholder="Email">
    </div>
    </div>
</div>
</div>
<?php } ?>
<h5 class="card-title">Order Details</h5>  
<div class="form-group">
<div class="row">
	<div class="col-md-2">
    <label>Reference Number*</label>
    <div class="form-group">
    <input type="text" class="form-control required" id="wo_ref_no" name="wo_ref_no" placeholder="Reference Number" maxlength="50" minlength="1" value="<?php echo $wo_ref_no;?>"  <?php echo $readonly;?>>
    </div>
    </div>
    
    <div class="col-md-2">
    <label>Product*</label>
    <div class="form-group">
    <select class="form-control required js-example-basic-single " id="wo_product_type_id" name="wo_product_type_id" style="width:100%" > 
   
    <?php if($product_types){ ?>
    <?php foreach($product_types as $PT){ ?>
    <option value="<?php echo $PT['product_type_id'];?>" ptvalue='<?php echo $PT['product_type_amount'];?>' ><?php echo $PT['product_type_name'];?> (<?php echo $PT['product_type_amount'];?>)</option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>

    <div class="col-md-2">
    <label>Collar</label>
    <div class="form-group">
    <select class="form-control required js-example-basic-single"  id="wo_collar_type_id" name="wo_collar_type_id"  style="width:100%" > 
    
    <?php if($collar_types){ ?>
    <?php foreach($collar_types as $CT){ ?>
    <option value="<?php echo $CT['collar_type_id'];?>" ctvalue='<?php echo $CT['collar_amount'];?>'><?php echo $CT['collar_type_name'];?> (<?php echo $CT['collar_amount'];?>)</option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>
    
    <div class="col-md-2">
    <label>Sleeve</label>
    <div class="form-group">
    <select class="form-control required js-example-basic-single" id="wo_sleeve_type_id" name="wo_sleeve_type_id"  style="width:100%"> 
   
    <?php if($sleeve_types){ ?>
    <?php foreach($sleeve_types as $ST){ ?>
    <option value="<?php echo $ST['sleeve_type_id'];?>" stvalue='<?php echo $ST['sleeve_type_amount'];?>' ><?php echo $ST['sleeve_type_name'];?> (<?php echo $ST['sleeve_type_amount'];?>)</option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>
    
    <div class="col-md-2">
    <label>Fabric</label>
    <div class="form-group">
    <select class="form-control required js-example-basic-single"  id="wo_fabric_type_id" name="wo_fabric_type_id"  style="width:100%" > 
    
    <?php if($fabric_types){ ?>
    <?php foreach($fabric_types as $FT){ ?>
    <option value="<?php echo $FT['fabric_type_id'];?>" ftvalue='<?php echo $FT['fabric_amount'];?>'><?php echo $FT['fabric_type_name'];?> (<?php echo $FT['fabric_amount'];?>)</option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>
    
    <div class="col-md-2">
    <label>Add-ons</label>
    <div class="form-group">
<input type="hidden" name="wo_addon_id" id="wo_addon_id" value="0" />
    <!--<select class="form-control"  id="wo_addon_id" name="wo_addon_id" > 
    <option value="" advalue='0'>--- Select ---</option>
    <?php //if($addons){ ?>
    <?php //foreach($addons as $AD){ ?>
    <option value="<?php //echo $AD['addon_id'];?>" advalue='<?php //echo $AD['addon_amount'];?>'><?php //echo $AD['addon_name'];?> (<?php //echo $AD['addon_amount'];?>)</option>
    <?php //} ?>
    <?php //} ?>
    </select>-->
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
    <option value="<?php echo $AD['addon_id'];?>"><?php echo $AD['addon_name'];?> (<?php echo $AD['addon_amount'];?>)</option>
    <?php //} ?></option>
 	<?php }} ?>
    </select>
    </div>
    </div>
</div>
</div>  

<div class="form-group">
<div class="row">
	<!--<div class="col-md-2">
    <label>Quantity</label>
    <div class="form-group">
    <input type="text" class="form-control text-center required number" id="wo_qty" name="wo_qty"  min='1' >
    </div>
    </div>-->
    
    
    <div class="col-md-4">
    <label>Image Back Url</label>
    <div class="form-group">
    <input type="text" class="form-control" id="wo_img_back" name="wo_img_back"  >
    </div>
    </div>
    
    <div class="col-md-4">
    <label>Image Front Url</label>
    <div class="form-group">
    <input type="text" class="form-control" id="wo_img_front" name="wo_img_front"  >
    </div>
    </div>

  
  <div class="col-md-4">
    <label>Remark</label>
    <div class="form-group">
    <input type="text" class="form-control" id="wo_remark" name="wo_remark" placeholder="Remark" >
    </div>
    </div>
   
</div>
</div>

<?php include('order_option_add.php');?>
<?php if($pORc==0) {?>
<h5 class="card-title">Shipping Details</h5> 
    <div class="form-group">
    <div class="row">
    <?php if($pORc==0) {?>
    <div class="col-md-4">
    <label>Shipping Type</label>
    <div class="form-group">
    <select class="form-control required"  id="wo_shipping_type_id" name="wo_shipping_type_id" > 
    <option value="" advalue='0'>--- Select ---</option>
    <?php if($shipping_types){ ?>
    <?php foreach($shipping_types as $SHT){ ?>
    <option value="<?php echo $SHT['shipping_type_id'];?>" ><?php echo $SHT['shipping_type_name'];?></option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>
    <?php } ?>
    <?php if($pORc==0) {?>
    <div class="col-md-8">
    <label>Shipping Address</label>
    <div class="form-group">
    <textarea type="text" class="form-control required" id="wo_shipping_address" name="wo_shipping_address" placeholder="Shipping Address"></textarea>
    </div>
    </div>
    <?php } ?>
    </div>
    </div>
<?php } ?>


</div>
<div class="modal-footer">
<input type="hidden" name="current_woid" id="current_woid" value="<?php echo $_POST['cid'];?>" />
<input type="hidden" name="current_s_id" id="current_s_id" value="<?php echo $this->session->userdata('log_session_id');?>" />
<input type="hidden" name="current_l_id" id="current_l_id" value="<?php echo $this->session->userdata('loginid');;?>" />

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
<button type="submit" class="btn btn-success" id="submit" name="submit">Save</button>
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



$('#addNewRefNo').on('hidden.bs.modal', function () { 
    //location.reload();
	//alert("hhh");
	$('#contentDiv').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
	var post_data = {
	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
	'<?php echo 'current_id'; ?>' : '<?php echo $_POST['cid']; ?>'
	};
	//$('#pnoresponse').html("<p style='text-align:center; color:#030;'>Checking... </p>");
	$.ajax({
	type: "POST",
	
	url: "<?= base_url("workorder/draft_data/");?>",
	data: post_data
	}).done(function(reply) {
		
		//alert("Yesss");
		$('#contentDiv').html(reply);
	});
});

$("#mform").validate({
submitHandler: function() {
//$("#submit").attr("disabled", "disabled");
//$("#response").html('Data Saving...');
$('#submit').html('<i class="fa fa-asterisk fa-spin  text-warning"></i> Please wait..!');
$.post('<?= base_url("workorder/online_ajax_post/");?>', $("#mform").serialize(), function(data) {
//$("#response").html('Checking...');
	//$("#submitButton").removeAttr("disabled");
	var dataRs = jQuery.parseJSON(data);
	//$('#submitButton').html('Submit');
	//$("#response").html(dataRs.responseCode);
	if(dataRs.responseCode=="success"){ 
		//location.reload();
		 $('#addNewRefNo').modal('toggle');
		 
		$('#contentDiv').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
		var post_data = {
		'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
		'<?php echo 'current_id'; ?>' : '<?php echo $_POST['cid']; ?>'
		};
		//$('#pnoresponse').html("<p style='text-align:center; color:#030;'>Checking... </p>");
		$.ajax({
		type: "POST",
		
		url: "<?= base_url("workorder/draft_data/");?>",
		data: post_data
		}).done(function(reply) {
			
			//alert("Yesss");
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
