<?php 


    
if($_POST['wo_ref_no']==""){
echo '<div class="alert alert-fill-danger" role="alert"><i class="icon-exclamation"></i>Sorry...Not find any dispatch item</div>.';
exit;
}
$summary=$this->common_model->get_order_summary_by_refno($_POST['order_id'],$_POST['wo_ref_no']);
$order_info=$this->dispatch_model->get_order_data_by_order_id($_POST['order_id']);
//print_r($order_info);

$sql="SELECT * FROM wo_order_summary WHERE wo_order_id='".$order_info['order_id']."' and wo_ref_no='".$_POST['wo_ref_no']."' GROUP BY wo_ref_no ";      
$query = $this->db->query($sql);					 
$itemInfo= $query->row_array();

$shipping_type_id=$itemInfo['wo_shipping_type_id'];
$dispatch_address=$itemInfo['wo_shipping_address'];
$dispatch_customer_id=$itemInfo['summary_client_id'];
$dispatch_client_name=$itemInfo['summary_client_name_only'];
$summary_client_mobile=$itemInfo['summary_client_mobile'];
$summary_client_email=$itemInfo['summary_client_email'];

?>
<div class="card">
<div class="card-body">
<form name="updateDispatch" id="updateDispatch">
<h4 class="card-title">Order Details</h4>
<table class="table w-100">
    <thead>
    <th>Item</th>
    <th>Quantity</th>
    <th>Dispatch Qty</th>
    </thead>
    <tbody>
    	<?php if($summary) { $inc=0; $count_item=count($summary);?>
		<?php foreach($summary as $item) { 
		$inc++;
		$completedRow=$this->common_model->get_item_from_completed_without_schedule($order_info['order_id'],$item['order_summary_id']); 
		$dispatchedRow=$this->common_model->get_dispatched_data($order_info['order_id'],$item['order_summary_id']); 
		if($completedRow['completed_id']!=""){
		
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
		$avlQty=$completedRow['QC_APPROVED_QTY']-$DISPATCH_QTY;
		?>
		<label class="badge badge-info" title="Total Qty"><?php echo $item['wo_qty'];?></label>
		<label class="badge badge-success" title="Qc Approved Qty"><?php echo $completedRow['qc_approved_qty'];?></label>
		<label class="badge badge-warning" title="Dispatched Qty"><?php echo $DISPATCH_QTY;?></label>
		</td>
       <td width="20%">
		<?php if($avlQty>0){ ?>
       <input maxlength="5" type="text" name="dispatchPost[<?php echo $inc;?>][dispatch_qty]" class="form-control text-center required number"  max='<?php echo $avlQty;?>' value="<?php echo $avlQty;?>" min='0'/>
		<?php }else{ ?>
		<label class="badge badge-danger w-100" title="Dispatched Qty"><?php echo $avlQty;?></label>
		<?php } ?>


		<input type="hidden" name="dispatchPost[<?php echo $inc;?>][completed_id]" value="<?php echo $completedRow['completed_id'];?>" />
		<input type="hidden" name="dispatchPost[<?php echo $inc;?>][order_summary_id]" value="<?php echo $item['order_summary_id'];?>" />

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
    </table>


<h4 class="card-title">Customer Dispatch Details</h4>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<input type="hidden" name="actn" value="insert">
<input type="hidden" name="dispatch_order_id" value="<?php echo $_POST['order_id'];?>">
<input type="hidden" name="rs_design_id" value="<?php echo $_POST['rs_design_id'];?>">
<input type="hidden" name="orderform_type_id" value="<?php echo $_POST['orderform_type_id'];?>">
<input type="hidden" name="wo_ref_no" value="<?php echo $_POST['wo_ref_no'];?>">
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
<option value="<?php echo $SM['shipping_mode_id'];?>" <?php if($SM['shipping_mode_id']==$shipping_mode_id){ echo 'selected="selected"'; } ?>><?php echo $SM['shipping_mode_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>


<div class="form-group">
<label for="exampleInputEmail1">Traking Info</label>
<textarea type="text" class="form-control" id="tracking_info"  name="tracking_info"  rows="4"></textarea>
</div>
<div class="form-group">
<div class="col md-3 sm-4">
<label>Customer Mobile No:</label>
<input class="form-control" type="text" name="mobile_number" value="<?php echo $summary_client_mobile;?>">
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
			//return false;
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
