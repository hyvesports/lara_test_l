<?php //print_r($_POST);?>
<?php //echo $this->security->get_csrf_hash();?>
<style>
.error{
	color:#F00;
}
</style>

<form action="post" id="mform">
<div class="modal-body">
<span id="response"></span>
<h5 class="card-title">Order Details</h5>  
<div class="form-group">
<div class="row">
	
    <div class="col-md-3">
    <label>Product</label>
    <div class="form-group">
    <select class="form-control required js-example-basic-single poptions" id="wo_product_type_id" name="wo_product_type_id" style="width:100%" onchange="calculateRow();"> 
    <?php if($product_types){ ?>
    <?php foreach($product_types as $PT){ ?>
    <option value="<?php echo $PT['product_type_id'];?>" ptvalue='<?php echo $PT['product_type_amount'];?>' ovalue='<?php echo $PT['product_type_amount'];?>' ><?php echo $PT['product_type_name'];?> (<?php echo $PT['product_type_amount'];?>)</option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>

    <div class="col-md-3">
    <label>Collar</label>
    <div class="form-group">
    <select class="form-control required js-example-basic-single poptions"  id="wo_collar_type_id" name="wo_collar_type_id"  style="width:100%" onchange="calculateRow();" > 
    
    <?php if($collar_types){ ?>
    <?php foreach($collar_types as $CT){ ?>
    <option value="<?php echo $CT['collar_type_id'];?>" ctvalue='<?php echo $CT['collar_amount'];?>' ovalue='<?php echo $CT['collar_amount'];?>'><?php echo $CT['collar_type_name'];?> (<?php echo $CT['collar_amount'];?>)</option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>
    
    <div class="col-md-2">
    <label>Sleeve</label>
    <div class="form-group">
    <select class="form-control required js-example-basic-single poptions" id="wo_sleeve_type_id" name="wo_sleeve_type_id"  style="width:100%" onchange="calculateRow();"> 
   
    <?php if($sleeve_types){ ?>
    <?php foreach($sleeve_types as $ST){ ?>
    <option value="<?php echo $ST['sleeve_type_id'];?>" stvalue='<?php echo $ST['sleeve_type_amount'];?>' ovalue='<?php echo $ST['sleeve_type_amount'];?>' ><?php echo $ST['sleeve_type_name'];?> (<?php echo $ST['sleeve_type_amount'];?>)</option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    </div>
    
    <div class="col-md-2">
    <label>Fabric</label>
    <div class="form-group">
    <select class="form-control required js-example-basic-single poptions"  id="wo_fabric_type_id" name="wo_fabric_type_id"  style="width:100%" onchange="calculateRow();"> 
    
    <?php if($fabric_types){ ?>
    <?php foreach($fabric_types as $FT){ ?>
    <option value="<?php echo $FT['fabric_type_id'];?>" ftvalue='<?php echo $FT['fabric_amount'];?>' ovalue='<?php echo $FT['fabric_amount'];?>'><?php echo $FT['fabric_type_name'];?> (<?php echo $FT['fabric_amount'];?>)</option>
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
    <select id="addons_ids" class="form-control w-100 ad_values" multiple="multiple" name="addons_ids[]" onchange="calculateRow();" >
    <?php if($addons){ ?>
	<?php foreach($addons as $AD){ ?>
    <option value="<?php echo $AD['addon_id'];?>" advalue='<?php echo $AD['addon_amount'];?>'><?php echo $AD['addon_name'];?> (<?php echo $AD['addon_amount'];?>)</option>
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
<div class="form-group">
<div class="row">
	<!--<div class="col-md-2">
    <label>Quantity</label>
    <div class="form-group">
    <input type="text" class="form-control text-center required number" id="wo_qty" name="wo_qty"  min='1' >
    </div>
    </div>-->
    
    
    <div class="col-md-6">
    <div class="form-group">
    </div>
    </div>
    
    <div class="col-md-3">
    <label>Rate</label>
    <div class="form-group">
    <input type="text" class="form-control" id="wo_rate_model" name="wo_rate" readonly="readonly"  >
    </div>
    </div>

  
  <div class="col-md-3">
    <label>Discount</label>
    <div class="form-group">
    <input type="text" class="form-control number" id="wo_discount" name="wo_discount"  maxlength="5" value="0" >
    </div>
    </div>
   
</div>
</div>
</div>
<div class="modal-footer">

<input type="hidden" name="wo_qty" id="wo_qty_total" value="" />
<input type="hidden" name="current_woid" id="current_woid" value="<?php echo $_POST['cid'];?>" />
<input type="hidden" name="current_s_id" id="current_s_id" value="<?php echo $_POST['cid'];?>" />
<input type="hidden" name="current_l_id" id="current_l_id" value="<?php echo $this->session->userdata('loginid');;?>" />
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
<button type="submit" class="btn btn-success" id="submit" name="submit" value="submit">Save</button>
<button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
</div>

</form>
<script type="text/javascript">
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
	url: "<?= base_url("formdata/draft_data/");?>",
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
$.post('<?= base_url("formdata/online_ajax_post/");?>', $("#mform").serialize(), function(data) {
//$("#response").html('Checking...');
	//$("#submitButton").removeAttr("disabled");
	var dataRs = jQuery.parseJSON(data);
	//$('#submitButton').html('Submit');
	//$("#response").html(dataRs.responseCode);
	if(dataRs.responseCode=="success"){ 
		//location.reload();
		$( '#mform' ).each(function(){this.reset();});
		$('#addNewRefNo').modal('toggle');
		$('#contentDiv').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
		var post_data = {
		'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
		'<?php echo 'current_id'; ?>' : '<?php echo $_POST['cid']; ?>'
		};
		//$('#pnoresponse').html("<p style='text-align:center; color:#030;'>Checking... </p>");
		$.ajax({
		type: "POST",
		url: "<?= base_url("formdata/draft_data/");?>",
		data: post_data
		}).done(function(reply) {
			//alert("Yesss");
			$('#contentDiv').html("<p style='text-align:center; color:#030;'>Loading.. </p>");
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
function calculateRow(){
	var ad_value=0;
	$( "#addons_ids :selected" ).each(function() {
		ad_value+=parseFloat($(this).attr('advalue'));
		//alert($(this).attr('advalue'));
	});
	var poptions=0;
	$( ".poptions :selected" ).each(function() {
		poptions+=parseFloat($(this).attr('ovalue'));
		//alert($(this).attr('ovalue'));
	});
	var rate = parseFloat(ad_value)+parseFloat(poptions);
	
	//alert(rate);
	var qty=0;
	$(".quantity" ).each(function() {
		qty+=parseFloat($(this).val());
	});
	
	$("#wo_qty_total").val(qty);
	var finalRate=parseFloat(rate)*parseFloat(qty);
	$("#wo_rate_model").val(finalRate.toFixed( 2 ));
}
</script>
