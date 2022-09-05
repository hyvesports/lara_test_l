<div class="modal-header">

<button type="button" class="close" data-dismiss="modal" aria-label="Close">

<span aria-hidden="true">x</span>

</button>

</div>

<div class="modal-body"  >

<div class="card-body">

<h4 class="card-title">Update Dispatch Details</h4>

<span id="action_resp"></span>



<?php 

//echo $_POST['qty'];

$total_Qty=$_POST['qty'];

$shipped_qty=0;

$availbileQty=0;

$selQ="SELECT sum(shipping_qty) as shipped_qty FROM tbl_dispatch WHERE dispatch_id!='".$_POST['dipsid']."' and dispatch_order_id='".$_POST['oid']."' and dispatch_order_item_id='".$_POST['smid']."' ";

$queryQ = $this->db->query($selQ);					 

$qtyRow=$queryQ->row_array();

if(isset($queryQ)){

	$shipped_qty=$qtyRow['shipped_qty'];

}

$availbileQty=$total_Qty-$shipped_qty;

if($availbileQty>0){

?>

<form name="updateDispatch" id="updateDispatch">

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<input type="hidden" name="dispatch_id" value="<?php echo $dispatch_row['dispatch_id'];?>">

<input type="hidden" name="actn" value="<?php echo $_POST['actn'];?>">

<input type="hidden" name="dispatch_order_id" value="<?php echo $_POST['oid'];?>">

<input type="hidden" name="dispatch_order_item_id" value="<?php echo $_POST['smid'];?>">

<input type="hidden" name="rs_design_id" value="<?php echo $_POST['rsid'];?>">



<div class="form-group row">

<div class="col">

<label>Date:</label>

<input type="text" class="form-control required" data-inputmask="'alias': 'date'" name="dispatch_date" id="dispatch_date" value="<?php echo date('d/m/Y');?>">

</div>

<div class="col">

<label>Customer Name:</label>

<input  type="text" class="form-control required"  name="dispatch_client_name" id="dispatch_client_name" value="<?php echo $dispatch_row['dispatch_client_name'];?>">

</div>

</div>



<div class="form-group">

<label for="exampleInputEmail1">Address</label>

<textarea type="text" class="form-control required" id="dispatch_address"  name="dispatch_address"  rows="4"><?php echo $dispatch_row['dispatch_address'];?></textarea>

</div>



<div class="form-group row">

<div class="col">

<label>Quantity:</label>

<input type="number" class="form-control required"  name="shipping_qty" id="shipping_qty" value="<?php echo $dispatch_row['shipping_qty'];?>" min="1" max="<?php echo $availbileQty;?>">

</div>

<div class="col">

<label>Shipping Type:</label>

<select class="form-control required" id="shipping_type_id" name="shipping_type_id">

<?php if($shipping_types){ ?>

<option value="">--- Select ---</option>

<?php foreach($shipping_types as $ST){ ?>

<option value="<?php echo $ST['shipping_type_id'];?>" <?php if($ST['shipping_type_id']==$dispatch_row['shipping_type_id']){ echo 'selected="selected"'; } ?> ><?php echo $ST['shipping_type_name'];?></option>

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

<option value="<?php echo $SM['shipping_mode_id'];?>" <?php if($SM['shipping_mode_id']==$dispatch_row['shipping_mode_id']){ echo 'selected="selected"'; } ?>><?php echo $SM['shipping_mode_name'];?></option>

<?php } ?>

<?php } ?>

</select>

</div>

</div>



<div class="form-group">

<label for="exampleInputEmail1">Traking Info</label>

<textarea type="text" class="form-control" id="tracking_info"  name="tracking_info"  rows="4"></textarea>

</div>



<div class="form-group row">

<div class="col">

<label>Tracking ID:</label>

<input class="form-control"  name="tracking_id" id="tracking_id">

</div>

<div class="col">

<label>Status:</label>

<select class="form-control required" id="dispatch_status" name="dispatch_status">

<option value="">--- Select ---</option>

<option value="1" <?php if(1==$dispatch_row['dispatch_status']){ echo 'selected="selected"'; } ?>>Dispatched</option>

<option value="0" <?php if(0==$dispatch_row['dispatch_status']){ echo 'selected="selected"'; } ?>>Not Dispatched</option>

</select>

</div>

</div>

<button type="submit" class="btn btn-primary mr-2" id="submitData" name="submitData" value="Submit">Submit</button>

</form>

<?php }else{ 

echo '<div class="alert alert-fill-danger" role="alert">

                    <i class="icon-exclamation"></i>

                    Sorry...All quantity allocated to dispatch section

                  </div>.';

}

?>

</div>

</div>  

<script type="text/javascript">

$(function() {

	$('#orderDispatch').on('hidden.bs.modal', function () {

    	location.reload();

		//_________________________________________

	});

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

	//$("#submitData").attr("disabled", "disabled");

	$('#submitData').html("Please Wait ...");

	$.post('<?= base_url("dispatch/save_dispatch/");?>', $("#updateDispatch").serialize(), function(data) {

		var dataRs = jQuery.parseJSON(data);

		if(dataRs.responseCode=="F"){

			$('#submitData').html("Submit");

			$('#action_resp').html(dataRs.responseMsg)

			$('#updateStatusForm' ).each(function(){this.reset();});

		}else{

			window.location.reload();  

		}

		

	});	

	}

	});	



});

</script> 