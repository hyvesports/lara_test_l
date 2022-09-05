<?php 
//echo $_POST['tid'];exit;

$tData=$this->common_model->get_tracking_row($_POST['tid']); 
	$summary=$this->workorder_model->get_order_summary_in_detail($_POST['woid']); 
	//print_r($summary);
$dis=$this->dispatch_model->get_my_order_dispatches_by_wo($_POST['woid'],$_POST['tid']);
	?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">x</span>
</button>
</div>
<div class="modal-body"  >
<div class="card-body">
<h4 class="card-title"> Dispatch Details</h4>
<span id="action_resp"></span>

<div class="row">
<div class="col-md-6">
<address>
<p class="font-weight-bold">Tracking ID: <?php echo $tData['traking_number'];?></p>
<p><?php echo $tData['traking_info'];?></p>

</address>
</div>

<div class="col-md-6">
<address>
<p class="font-weight-bold"><?php echo $dis['dispatch_client_name'];?></p>
<p><?php echo $dis['dispatch_address'];?></p>

</address>
</div>

</div>
<table class="table w-100">
    <thead>
    <th>Item</th>
    <th>Quantity</th>
    <th>Dispatch Qty</th>
    </thead>
    <tbody>
    	<?php if($summary) { $inc=0; $count_item=count($summary);?>
		<?php foreach($summary as $item) { 
		
		$dispatchedRow=$this->common_model->get_dispatched_data_by_tracking($_POST['tid'],$item['order_summary_id']); 
		if($dispatchedRow['dispatch_order_item_id']==$item['order_summary_id']){
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
		<label class="badge badge-info" title="Total Qty"><?php echo $item['wo_qty'];?></label>
		</td>
       <td width="20%">
		<label class="badge badge-success w-100" title="Dispatched Qty"><?php echo $dispatchedRow['shipping_qty'];?></label>
		

        </td>
        </tr>
		<?php }?>
		<?php } } ?>
    </tbody>
    </table>

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