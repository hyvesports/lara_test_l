<div class="content-wrapper">
<div class="row grid-margin">
<div class="col-12">
<div class="card">
<div class="card-body">
<?php if(isset($msg) || validation_errors() !== ''): ?>
<div class="alert alert-warning alert-dismissible" style="width:100%;">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
<h4><i class="icon fa fa-warning"></i> Alert!</h4>
<?php echo validation_errors();?>
</div>
<?php endif; ?>
<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
<?=$this->session->flashdata('error')?>
</div>
<?php endif; ?>
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
<?=$this->session->flashdata('success')?>
</div>
<?php endif; ?>
<h4 class="card-title"><?php echo $title_head;?>
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('workorder/index');?>">List</a></span> 
</h4>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong> Order Details</strong></p>
<?php echo form_open(base_url('formdata/add/'.$lead_info['lead_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden" name="lead_id" id="lead_id" value="<?php echo $lead_info['lead_id'];?>" />
<input type="hidden" name="wo_client_id" id="wo_client_id" value="<?php echo $lead_info['lead_client_id'];?>" />
<input type="hidden" name="wo_owner_id" id="wo_owner_id" value="<?php echo $lead_info['lead_owner_id'];?>" />
<input type="hidden" name="wo_customer_name" id="wo_customer_name" value="<?php echo $lead_info['customer_name'];?>,<?php echo $lead_info['customer_mobile_no'];?>,<?php echo $lead_info['customer_email'];?>" />
<input type="hidden" name="wo_staff_name" id="wo_staff_name" value="<?php echo $lead_info['staff_code'];?>,<?php echo $lead_info['staff_name'];?>" />
<?php $cid=$lead_info['lead_uuid'];?>
<input type="hidden" name="current_wo_id" id="current_wo_id" value="<?php echo $cid;?>" />
<?php 
//print_r($lead_info);?>
<div class="row">
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Order Type *</label>
<div class="col-md-8">
<input type="hidden" name="orderform_type_id" id="orderform_type_id" value="1" />
<input name="orderform_type_name" id="orderform_type_name" type="text" class="form-control required" readonly="readonly" value="Offline" />
</div>
</div>
</div>
<div class="col-md-6"  id="orderno">
<?php
$nxt_id= $this->workorder_model->get_next_autoid('wo_work_orders');
$slno=1000+$nxt_id;
$no_prefix="F".$slno;
?>
<div class="form-group row">
<label class="col-md-4 col-form-label">Order Number*</label>
<div class="col-md-8">
<input type="text" class="form-control required" name="orderform_number" id="orderform_number" value="<?php echo $no_prefix;?>" readonly="readonly" >
<span id="orderform_number_load"></span>
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Order Nature *</label>
<div class="col-md-8">
<select class="form-control required" id="wo_order_nature_id" name="wo_order_nature_id"  > 
<option value="">--- Select ---</option>
<?php if($order_nature){ ?>
<?php foreach($order_nature as $ON){ ?>
<option value="<?php echo $ON['order_nature_id'];?>"><?php echo $ON['order_nature_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Dispatch Date *</label>
<div class="col-md-8">
<input name="wo_dispatch_date" id="wo_dispatch_date" type="text" class="form-control  datepicker required" readonly="readonly" 
value="<?php $date = strtotime("+7 day");echo date('d-m-Y', $date);?>" />
<span id="day_overview"></span>
</div>
</div>
</div>
</div>
<?php 
$disDates=$this->schedule_model->get_all_disabiled_days_d_m_y(date('Y-m-d'));
//print_r($disDates);
?>
<script>
$('.datepicker').datepicker({
autoclose: true,
format: 'dd-mm-yyyy',
startDate: "<?php echo date('d-m-Y');?>",
<?php if($disDates!=""){ ?>
datesDisabled:"<?php echo $disDates['CDATE'];?>"
<?php } ?>
}).on('changeDate', function(e){
	//alert("Hiii");
	var todate = $(this).val();
	var fromdate=<?php echo date('d-m-Y');?>;
var formData="<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&fd="+fromdate+"&td="+todate+"&for=offline";
	//alert(formData);
		$.ajax({  
		type: "POST",
		url: "<?= base_url("common/calculate_date_diff/");?>",  
		data: formData,
		beforeSend: function(){ $('#day_overview').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>'); },
		success: function(response){
		$("#day_overview").html(response);
		}
		});
});
</script>
<span id='product_info' >
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Product Information </strong></p>
<div class="form-group row">
<div class="col-md-12">
<div class="form-group row">
<div class="col-md-12">
<input name="wo_product_info" id="wo_product_info" type="text" class="form-control required" />
</div>
</div>
</div>
<div class="col-md-12">
</div>
</div>
</span>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Order summary </strong></p>
<?php 

$summary_drafts = $this->formdata_model->get_offline_order_draft($cid,$this->session->userdata('loginid'));
?>
<div class="form-group row">
<div class="col-md-12">
<div class="form-group row" id="contentDiv">
<table width="100%" class="table table-striped   mt-0 "  >
    <thead>
    <tr class="item_header">
    <th width="15%"  class="text-left">Product</th>
    <th width="15%"  class="text-left">Collar</th>
    <th width="13%"  class="text-left">Sleeve</th>
    <th width="14%"  class="text-left">Fabric</th>
    <th width="11%"  class="text-left">Add-ons</th>
    <th width="12%"  class="text-left">Qty</th>
    <th width="10%">Action</th>
    </tr>
    </thead>
    <tbody id="invDataTableRow">
    <?php $crow=0; if($summary_drafts){ ?>
    <?php foreach($summary_drafts as $sd){ ?>
    <tr class="draftItems">
   
    <td><?php echo ucwords($sd['product_type_name']);?></td>
    <td><?php echo ucwords($sd['collar_type_name']);?></td>
    <td><?php echo ucwords($sd['sleeve_type_name']);?></td>
    <td><?php echo ucwords($sd['fabric_type_name']);?></td>
    <td><?php echo ucwords($sd['item_addons_names']);?></td>
    <td><?php echo ucwords($sd['wo_qty']);?> <?php //echo base_url('workorder/remove_summary_item/'.$sd['online_draft_id']);?></td>
    <td>
    <a href="javascript:void(0);" title="Edit" style="cursor: pointer;" data-toggle="modal" data-target="#editRefNo" data-afor="<?php echo ucwords($sd['offline_draft_id']);?>" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>
    <a href="javascript:void(0);" onclick="deleteMe(<?php echo $sd['offline_draft_id'];?>);" title="Delete" style="cursor: pointer;" ><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-trash" ></i><?php //echo $sd['offline_draft_id'];?></label></a>
    </td>
    </tr>
    <?php $crow++;} ?>
    <?php } ?>
    </tbody>

    

<tfoot>
<tr>
<td  align="center" colspan="8">
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addNewRefNo" data-afor="0"  ><i class="icon-plus-square"></i><i class="fa fa-plus"></i>Add Order Item</button>
</td>
</tr>
</tfoot>
</table>
</div>
</div>
</div>


<input class="btn btn-primary float-right" type="submit" value="Save and Continue" id="submit" name="submit">
<?php echo form_close(); ?>
</div>
</div>
</div>
</div>
</div>
<script language="javascript">
$(function() {
	$('#editRefNo').on('show.bs.modal', function (event) {
	var post_data = {
	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
	'cid' : '<?php echo $cid;?>',
	};
	var button = $(event.relatedTarget);
	var afor=button.data('afor');
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("formdata/offlinemodeledit/");?>"+afor,  
	data: post_data,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-cog fa-spin"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 
	});

	$('#addNewRefNo').on('show.bs.modal', function (event) {
	var post_data = {
	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
	'cid' : '<?php echo $cid;?>',
	};
	var button = $(event.relatedTarget);
	var afor=button.data('afor');
	//var cid=button.data('cid');
	//alert(afor);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("formdata/offlinemodel/");?>",  
	data: post_data,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-cog fa-spin"></i>');
	},
	success: function(response){
		modal.find('.modal-content').html(response); 
	}
	}); 
	});


$("#dataform").validate({
errorPlacement: function(label, element) {
label.addClass('mt-2 text-danger');
label.insertAfter(element);
},
highlight: function(element, errorClass) {
$(element).parent().addClass('has-danger')
$(element).addClass('form-control-danger')
}
});
});

function deleteMe(rid){
		//alert(rid);
		//$('#addNewRefNo').modal('toggle');
	if(confirm("Are you sure you want to delete.?")){
		var items=0;
		$( ".draftItems" ).each(function( index ) {items++;});
		if(items==1){
			alert("Can't Remove..");
			return false;
		}
		//$('#contentDiv').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
		var post_data = {
		'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
		'<?php echo 'current_id'; ?>' : '<?php echo $cid; ?>'
		};
		//$('#pnoresponse').html("<p style='text-align:center; color:#030;'>Checking... </p>");
		$.ajax({
		type: "POST",
		url: "<?= base_url("formdata/remove_summary_item/");?>"+rid,
		data: post_data
		}).done(function(reply) {
			//alert("Yesss");
			$('#contentDiv').html(reply);
		});
	return false;
	}

}

</script>
<div class="modal fade " id="addNewRefNo">
<div class="modal-dialog modal-lg 0" role="document">
<div class="modal-content"></div>
</div>
</div>
<div class="modal fade " id="editRefNo">
<div class="modal-dialog modal-lg 0" role="document">
<div class="modal-content"></div>
</div>
</div>