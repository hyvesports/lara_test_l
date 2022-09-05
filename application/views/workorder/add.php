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
<?php echo form_open(base_url('workorder/add/'.$lead_info['lead_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden" name="lead_id" id="lead_id" value="<?php echo $lead_info['lead_id'];?>" />
<input type="hidden" name="wo_client_id" id="wo_client_id" value="<?php echo $lead_info['lead_client_id'];?>" />
<input type="hidden" name="wo_owner_id" id="wo_owner_id" value="<?php echo $lead_info['lead_owner_id'];?>" />
<input type="hidden" name="wo_customer_name" id="wo_customer_name" value="<?php echo $lead_info['customer_name'];?>,<?php echo $lead_info['customer_mobile_no'];?>,<?php echo $lead_info['customer_email'];?>" />
<input type="hidden" name="wo_staff_name" id="wo_staff_name" value="<?php echo $lead_info['staff_code'];?>,<?php echo $lead_info['staff_name'];?>" />
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
<span id='product_info' style="display:none;">
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
<div class="form-group row">
<div class="col-md-12">
<div class="form-group row">
<table class="table table-striped mb-0" width="100%">
<thead>
<tr class="item_header">
<th width="13%"  class="text-center">Product</th>
<th width="13%"  class="text-center">Collar</th>
<th width="13%"  class="text-center">Sleeve</th>
<th width="13%"  class="text-center">Fabric</th>
<th width="13%"  class="text-center">Add-ons</th>
<th width="11%"  class="text-center">Qty</th>
<th width="11%"  class="text-center">Rate</th>
<th width="13%"  class="text-center">Discount</th>
<th width="0%"></th>
</tr>
</thead>
<tbody id="invDataTableRow">
<tr>
<td>
<select class="form-control required js-example-basic-single" id="wo_product_type_id0" name="wo[0][wo_product_type_id]"  onchange="calculateRow(0);" > 
<?php if($product_types){ ?>
<?php foreach($product_types as $PT){ ?>
<option value="<?php echo $PT['product_type_id'];?>" ptvalue='<?php echo $PT['product_type_amount'];?>' ><?php echo $PT['product_type_name'];?> (<?php echo $PT['product_type_amount'];?>)</option>
<?php } ?>
<?php } ?>
</select>
</td>
<td>
<select class="form-control required js-example-basic-single"  id="wo_collar_type_id0" name="wo[0][wo_collar_type_id]" onchange="calculateRow(0);" > 
<?php if($collar_types){ ?>
<?php foreach($collar_types as $CT){ ?>
<option value="<?php echo $CT['collar_type_id'];?>" ctvalue='<?php echo $CT['collar_amount'];?>'><?php echo $CT['collar_type_name'];?> (<?php echo $CT['collar_amount'];?>)</option>
<?php } ?>
<?php } ?>
</select>
</td>
<td>
<select class="form-control required js-example-basic-single" id="wo_sleeve_type_id0" name="wo[0][wo_sleeve_type_id]" onchange="calculateRow(0);"  > 
<?php if($sleeve_types){ ?>
<?php foreach($sleeve_types as $ST){ ?>
<option value="<?php echo $ST['sleeve_type_id'];?>" stvalue='<?php echo $ST['sleeve_type_amount'];?>' ><?php echo $ST['sleeve_type_name'];?> (<?php echo $ST['sleeve_type_amount'];?>)</option>
<?php } ?>
<?php } ?>
</select>
</td>
<td>
<select class="form-control required js-example-basic-single"  id="wo_fabric_type_id0" name="wo[0][wo_fabric_type_id]" onchange="calculateRow(0);"  >
<?php if($fabric_types){ ?>
<?php foreach($fabric_types as $FT){ ?>
<option value="<?php echo $FT['fabric_type_id'];?>" ftvalue='<?php echo $FT['fabric_amount'];?>'><?php echo $FT['fabric_type_name'];?> (<?php echo $FT['fabric_amount'];?>)</option>
<?php } ?>
<?php } ?>
</select>
</td>
<td>
<input type="hidden" name="wo_addon_id" id="wo_addon_id" value="0" />
<select id="addons_ids" class=" js-example-basic-single" multiple="multiple" name="addons_ids[]" onchange="calculateRow(0);">
<?php if($addons){ ?>
<?php foreach($addons as $AD){ ?>
<option value="<?php echo $AD['addon_id'];?>" advalue='<?php echo $AD['addon_amount'];?>'><?php echo $AD['addon_name'];?> (<?php echo $AD['addon_amount'];?>)</option>
<?php } ?>
<?php } ?>
</select>
</td>
<td><input type="text" class="form-control text-center required number" id="wo_qty0" name="wo[0][wo_qty]" onkeyup="calculateRow(0);" min='1' ></td>
<td><input type="text" class="form-control text-center required number rateClass" id="wo_rate0" name="wo[0][wo_rate]" readonly="readonly"></td>
<td><input type="text" class="form-control text-center number discountClass" id="wo_discount0" name="wo[0][wo_discount]" onkeyup="calculateRow(0);"></td>
<td></td>
</tr>
</tbody>
<tfoot>
<tr class="last-item-row">
<td class="add-row" align="right" colspan="9">
<button type="button" class="btn btn-success" aria-label="Left Align"  onclick="addFilterRow();"><i class="icon-plus-square"></i> Add Row</button>
</td>
</tr>
<tr>
</tr>
</tfoot>
</table>
</div>
</div>
</div>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Cost calculations </strong></p>
<div class="form-group row">
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Shipping Cost*</label>
<div class="col-md-8">
<input name="wo_shipping_cost" id="wo_shipping_cost" type="text" class="form-control  required number" onkeyup="finalData();"  maxlength="10"  />
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Additional Cost  *</label>
<div class="col-md-8">
<input type="text" class="form-control number" name="wo_additional_cost" id="wo_additional_cost" maxlength="8"  value="<?php echo $this->input->post('wo_additional_cost');?>" onkeyup="finalData();" >
</div>
</div>
</div>
<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Additional Cost Description *</label>
<div class="col-md-10">
<input type="text" class="form-control" name="wo_additional_cost_desc" id="wo_additional_cost_desc" maxlength="500"  value="<?php echo $this->input->post('wo_additional_cost_desc');?>">
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Tax *</label>
<div class="col-md-8">
<select class="form-control required" id="wo_tax_id" name="wo_tax_id" onchange="finalData();"> 
<option value="" taxval='0'>--- Select ---</option>
<?php if($taxclass){ ?>
<?php foreach($taxclass as $taxx){ ?>
<option value="<?php echo $taxx['taxclass_id'];?>" taxval='<?php echo $taxx['taxclass_value'];?>' ><?php echo $taxx['taxclass_name'];?> [ Value: <?php echo $taxx['taxclass_value'];?> % ] </option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Adjustment *</label>
<div class="col-md-8">
<input type="text" class="form-control number" name="wo_adjustment" id="wo_adjustment" maxlength="5"  value="<?php echo $this->input->post('wo_adjustment');?>" onkeyup="finalData();" >
</div>
</div>
</div>
<div class="col-md-4" >
<div class="form-group row">
<label class="col-md-6 col-form-label">Gross Cost *</label>
<div class="col-md-6">
<input type="text" class="form-control required number" name="wo_gross_cost" id="wo_gross_cost" maxlength="10"  value="<?php echo $this->input->post('wo_gross_cost');?>" readonly="readonly">
</div>
</div>
</div>
<div class="col-md-4">
<div class="form-group row">
<label class="col-md-6 col-form-label">Advance*</label>
<div class="col-md-6">
<input type="text" class="form-control required number" name="wo_advance" id="wo_advance" maxlength="8"  value="<?php echo $this->input->post('wo_advance');?>" onkeyup="calculateBalance();">
</div>
</div>
</div>
<div class="col-md-4">
<div class="form-group row">
<label class="col-md-6 col-form-label">Balance*</label>
<div class="col-md-6">
<input type="text" class="form-control number" name="wo_balance" id="wo_balance" maxlength="50"  value="<?php echo $this->input->post('wo_balance');?>" readonly="readonly">
</div>
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
	<link rel="stylesheet" href="<?php echo base_url()?>public/dist/css/bootstrap-multiselect.css" type="text/css">
    <script type="text/javascript" src="<?php echo base_url()?>public/dist/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
 	//$(".js-example-basic-single").select2();
    $('#addons_ids').multiselect({
    numberDisplayed: 1
    });
    });
    </script>
<script language="javascript">
$(function() {
$(".js-example-basic-single").select2();
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
</script>
<script>
function calculateBalance(){
	var wo_gross_cost=0;
	var wo_advance=0;
	if($("#wo_gross_cost").val()!=""){
		wo_gross_cost=parseFloat($("#wo_gross_cost").val());
	}
	if($("#wo_advance").val()!=""){
		wo_advance=parseFloat($("#wo_advance").val());
	}
	//alert(wo_gross_cost);
	//alert(wo_balance);
	var balance=0;
	balance=parseFloat(wo_gross_cost)-parseFloat(wo_advance);
	$("#wo_balance").val(balance.toFixed(2));
}
var filter_row = 1;
function addFilterRow(){
	html='<tr id="inv-row'+filter_row +'">';
	html+='<td><select class="form-control required" id="wo_product_type_id'+filter_row+'" name="wo['+filter_row+'][wo_product_type_id]" onchange="calculateRow('+filter_row+');"    ><option value="" ptvalue="0">--- Select ---</option>';
	<?php if($product_types){ ?>
	<?php foreach($product_types as $PT){ ?>
	html+='<option value="<?php echo $PT['product_type_id'];?>" ptvalue="<?php echo $PT['product_type_amount'];?>"><?php echo $PT['product_type_name'];?>(<?php echo $PT['product_type_amount'];?>)</option>';
	<?php } ?>
	<?php } ?>
	html+='</select></td>';
	html+='<td><select class="form-control required"  id="wo_collar_type_id'+filter_row+'" name="wo['+filter_row+'][wo_collar_type_id]" onchange="calculateRow('+filter_row+');"  ><option value="" ctvalue="0">--- Select ---</option>';
	<?php if($collar_types){ ?>
	<?php foreach($collar_types as $CT){ ?>
	html+='<option value="<?php echo $CT['collar_type_id'];?>" ctvalue="<?php echo $CT['collar_amount'];?>"><?php echo $CT['collar_type_name'];?>(<?php echo $CT['collar_amount'];?>)</option>';
	<?php } ?>
	<?php } ?>
	html+='</select></td>';
	html+='<td><select class="form-control required" id="wo_sleeve_type_id'+filter_row+'" name="wo['+filter_row+'][wo_sleeve_type_id]" onchange="calculateRow('+filter_row+');"  ><option value="" stvalue="0">--- Select ---</option>';
	<?php if($sleeve_types){ ?>
	<?php foreach($sleeve_types as $ST){ ?>
	html+='<option value="<?php echo $ST['sleeve_type_id'];?>" stvalue="<?php echo $ST['sleeve_type_amount'];?>"><?php echo $ST['sleeve_type_name'];?>(<?php echo $ST['sleeve_type_amount'];?>)</option>';
	<?php } ?>
	<?php } ?>
	html+='</select></td>';
	html+='<td><select class="form-control required"  id="wo_fabric_type_id'+filter_row+'" name="wo['+filter_row+'][wo_fabric_type_id]" onchange="calculateRow('+filter_row+');" ><option value="" ftvalue="0">--- Select ---</option>';
	<?php if($fabric_types){ ?>
	<?php foreach($fabric_types as $FT){ ?>
	html+='<option value="<?php echo $FT['fabric_type_id'];?>" ftvalue="<?php echo $FT['fabric_amount'];?>"><?php echo $FT['fabric_type_name'];?>(<?php echo $FT['fabric_amount'];?>)</option>';
	<?php } ?>
	<?php } ?>
	html+='</select></td>';
	html+='<td><select class="form-control"  id="wo_addon_id'+filter_row+'" name="wo['+filter_row+'][wo_addon_id]" onchange="calculateRow('+filter_row+');"  ><option value="" advalue="0">--- Select ---</option>';
	<?php if($addons){ ?>
	<?php foreach($addons as $AD){ ?>
	html+='<option value="<?php echo $AD['addon_id'];?>" advalue="<?php echo $AD['addon_amount'];?>" ><?php echo $AD['addon_name'];?>(<?php echo $AD['addon_amount'];?>)</option>';
	<?php } ?>
	<?php } ?>
	html+='</select></td>';
	html+='<td><input type="text" class="form-control text-center required number" id="wo_qty'+filter_row+'" name="wo['+filter_row+'][wo_qty]" onkeyup="calculateRow('+filter_row+');" ></td>';
	html+='<td><input type="text" class="form-control text-center required number rateClass" id="wo_rate'+filter_row+'" name="wo['+filter_row+'][wo_rate]" readonly="readonly" ></td>';
	html+='<td><input type="text" class="form-control text-center  number discountClass" id="wo_discount'+filter_row+'" name="wo['+filter_row+'][wo_discount]" onkeyup="calculateRow('+filter_row+');" ></td>';
	html+='<td><a href="javascript:void(0);" onclick="removeRow('+filter_row+');">Remove</a></td>';
	html+='</tr>';
	$('#invDataTableRow').append(html);
	filter_row++;
}

function removeRow(filter_row){
	$('#inv-row'+filter_row).remove();
}
</script>
<script>
function calculateRow(row){
	//alert(row);
	var pt_value = $('option:selected','#wo_product_type_id'+row).attr('ptvalue');
	var ct_value = $('option:selected','#wo_collar_type_id'+row).attr('ctvalue');
	var st_value = $('option:selected','#wo_sleeve_type_id'+row).attr('stvalue');
	var ft_value = $('option:selected','#wo_fabric_type_id'+row).attr('ftvalue');
	var ad_value = $('option:selected','#wo_addon_id'+row).attr('advalue');
	//alert($("#pt_value").val());
	//alert(pt_value);
	if($("#wo_qty"+row).val()==""){
		var wo_qty=0;
		//alert("null");
	}else{
		var wo_qty=$("#wo_qty"+row).val();
	}
	var sum_item=parseFloat(pt_value)+parseFloat(ct_value)+parseFloat(st_value)+parseFloat(ft_value)+parseFloat(ad_value);
	var rate=parseFloat(wo_qty)*parseFloat(sum_item);
	//alert(rate);
	$("#wo_rate"+row).val(rate.toFixed(2));
	finalData();
}
function finalData(){
	//alert("okkk");
	var rateSum=getRateSum();
	var discountSum=getDiscountSum();
	var addition_total=rateSum;
	var deduction_total=discountSum;
	var totalAmountWithDiscount= parseFloat(rateSum)-parseFloat(discountSum);;
	var wo_shipping_cost=0;
	if($("#wo_shipping_cost").val()!=""){
		wo_shipping_cost=parseFloat($("#wo_shipping_cost").val());
		addition_total += parseFloat(wo_shipping_cost);
	}
	var wo_additional_cost=0;
	if($("#wo_additional_cost").val()!=""){
		wo_additional_cost=parseFloat($("#wo_additional_cost").val());
		addition_total += parseFloat(wo_additional_cost);
	}
	var wo_adjustment=0;
	if($("#wo_adjustment").val()!=""){
		wo_adjustment=parseFloat($("#wo_adjustment").val());
		deduction_total += parseFloat(wo_adjustment);
	}
	var taxTotal;
		var taxPercentage = $('option:selected','#wo_tax_id').attr('taxval');
			if(taxPercentage>0){
				//alert("ysss");
				var AMT=parseFloat(wo_additional_cost)+parseFloat(totalAmountWithDiscount);
				if(AMT>0 ){
					//alert("ysss");
					var main = AMT;
					var disc = taxPercentage;
					var dec = (disc / 100).toFixed(2);
					var mult = main * dec; // gives the value for subtract from main value
					var discont = mult;
					addition_total+= parseFloat(discont);
					//alert(discont);
				   // $('#result').val(discont);
				}
			}
	
 var gross_cost;
	 gross_cost=parseFloat(addition_total)-parseFloat(deduction_total);
	 $("#wo_gross_cost").val(gross_cost.toFixed( 2 ));
}

function getRateSum(){
	var sumTotal=0;
	var inc=0;
	var rate=0;
	$( ".rateClass" ).each(function() {
		if($("#wo_rate"+inc).val()!=""){
			rate=parseFloat($("#wo_rate"+inc).val());
			sumTotal += parseFloat(rate);
		}
		inc++;
	});
	//alert(sumTotal);
	return sumTotal;
}

function getDiscountSum(){
	var discountTotal=0;
	var inc=0;
	var discount=0;
	$( ".discountClass" ).each(function() {
		if($("#wo_discount"+inc).val()!=""){
			discount=parseFloat($("#wo_discount"+inc).val());
			discountTotal += parseFloat(discount);
		}
		inc++;
	});
	//alert(sumTotal);
	return discountTotal;
}
</script>
