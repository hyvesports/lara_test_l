<div class="content-wrapper">
<div class="row grid-margin">
<div class="col-12">
<div class="card">
<div class="card-body">
<?php if(isset($msg) || validation_errors() !== ''): ?>
<div class="alert alert-warning alert-dismissible" style="width:100%;">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h4><i class="icon fa fa-warning"></i> Alert!</h4>
<?php echo validation_errors();?>
</div>
<?php endif; ?>
<?php if($this->session->flashdata('error1')): ?>
<div class="alert alert-danger" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
<?=$this->session->flashdata('error1')?>
</div>
<?php endif; ?>
<?php if($this->session->flashdata('success1')): ?>
<div class="alert alert-success" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
<?=$this->session->flashdata('success1')?>
</div>
<?php endif; ?>
<h4 class="card-title"><?php echo $title_head;?>
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('leads/index');?>">All Leads</a>
<a title="Tasks" class="btn btn-warning " target="_blank" href="<?php echo base_url('leads/task/'.$row['lead_uuid']);?>"><i class="fa fa-tasks"></i> Tasks</a>
</span> 
</h4>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Lead Customer / Company Details</strong></p>
<?php echo form_open_multipart(base_url('leads/edit/'.$row['lead_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden" name="lead_id" id="lead_id"  value="<?php echo $row['lead_id'];?>" />
<input type="hidden" name="customer_id" id="customer_id"  value="<?php echo $row['customer_id'];?>" />
<?php //print_r($row);?>
<div class="row">
<div class="col-md-12">
<div class="form-group row">

<label class="col-md-2 col-form-label">Name *</label>

<div class="col-md-10">

<input type="text" class="form-control required" name="from_name" id="from_name" maxlength="100"  placeholder="Client / Company Name" value="<?php echo $row['customer_name'];?>">

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 col-form-label">Email*</label>

<div class="col-md-8">

<input type="text" class="form-control required email" name="from_email" id="from_email" maxlength="100" value="<?php echo $row['customer_email'];?>" >

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 col-form-label">Phone*</label>

<div class="col-md-8">

<input type="text" class="form-control required" name="from_phone" id="from_phone" maxlength="50"  minlength="10" onkeyup="chkphonenumber(this.value,'<?php echo $row['customer_id'];?>');" value="<?php echo $row['customer_mobile_no'];?>">

<span id="pnoresponse"></span>

</div>

</div>

</div>



<div class="col-md-12">

<div class="form-group row">

<label class="col-md-2 col-form-label">Website</label>

<div class="col-md-10">

<input type="text" class="form-control" name="from_website" id="from_website" value="<?php echo $row['customer_website'];?>"  >

</div>

</div>

</div>







<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 col-form-label">Country</label>

<div class="col-md-8">

<input type="text" class="form-control" name="from_country" id="from_country" maxlength="100" value="<?php echo $row['country'];?>" >

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 col-form-label">State</label>

<div class="col-md-8">

<input type="text" class="form-control" name="from_state" id="from_state" maxlength="100" value="<?php echo $row['state'];?>" >

</div>

</div>

</div>





<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 col-form-label">City</label>

<div class="col-md-8">

<input type="text" class="form-control " name="from_city" id="from_city" maxlength="100" value="<?php echo $row['city'];?>"  >

</div>

</div>

</div>





<div class="col-md-12">

<div class="form-group row">



<table class="table table-striped mb-0" width="100%">

<thead>



<tr class="item_header">

<th width="30%" class="text-center">Customer / Company Social media platform</th>

<th width="60%" class="text-center">Social media  platform Url </th>

<th></th>

</tr>

</thead>

<tbody id="invDataTableRow">

<?php 

$customer_social_media_links=1;

if($row['customer_social_media_links']=="") {?>

<tr >

<td><input type="text" class="form-control text-center " id="platforms0" name="socialmedia[0][platform]" placeholder="Enter Social media platform"></td>

<td><input type="text" class="form-control text-center " id="link0" name="socialmedia[0][link]" placeholder="Enter Social media platform url"></td>

<td></td>

</tr>

<?php }else{

	 $json_decode=json_decode($row['customer_social_media_links'],true);

	 $customer_social_media_links=count($json_decode);;

		if($json_decode){

			//$

			$crow=0;

	 	foreach($json_decode as  $key => $value){ ?>

        

        <tr id="inv-row<?php echo $crow;?>">

        <td><input type="text" class="form-control text-center " id="platforms<?php echo $crow;?>" name="socialmedia[<?php echo $crow;?>][platform]" placeholder="Enter Social media platform" value="<?php echo ($key); ?>"></td>

        <td><input type="text" class="form-control text-center" id="link<?php echo $crow;?>" name="socialmedia[<?php echo $crow;?>][link]" placeholder="Enter Social media platform url" value="<?php echo ($value);?>"></td>

        <td><a href="javascript:void(0);" onclick="removeRow(<?php echo $crow;?>);">Remove</a></td>

        </tr>



		<?php

			$crow++;

		}

	}

}

?>

</tbody>

<tfoot>



<tr class="last-item-row">

<td class="add-row" align="right" colspan="9">

<button type="button" class="btn btn-success" aria-label="Left Align"  onclick="addFilterRow();"><i class="icon-plus-square"></i> Add Row <?php // echo $customer_social_media_links;?></button>

</td>

</tr>

<tr>





</tr>

</tfoot>

</table>





</div>

</div>

</div>



<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong> Lead Details</strong></p>

<div class="row">

<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 col-form-label">Date (dd/mm/yyyy)*</label>

<div class="col-md-8">

<input type="text" class="form-control required" name="lead_date" id="lead_date" maxlength="100" data-inputmask="'alias': 'date'" 

value="<?php echo $row['lead_date'];?>" readonly="readonly">

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 col-form-label">Lead Source *</label>

<div class="col-md-8">

<select class="form-control required" id="lead_source_id" name="lead_source_id"> 

<option value="">--- Select ---</option>

<?php if($lead_sources){ ?>

<?php foreach($lead_sources as $LS){ ?>

<option value="<?php echo $LS['lead_source_id'];?>" <?php if($LS['lead_source_id']==$row['lead_source_id']) { echo ' selected="selected"';} ?>><?php echo $LS['lead_source_name'];?></option>

<?php } ?>

<?php } ?>

</select>

</div>

</div>

</div>





<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 col-form-label">Lead Type *</label>

<div class="col-md-8">

<select class="form-control required" id="lead_type_id" name="lead_type_id"> 

<option value="">--- Select ---</option>

<?php if($lead_types){ ?>

<?php foreach($lead_types as $LTS){ ?>

<option value="<?php echo $LTS['lead_type_id'];?>" <?php if($LTS['lead_type_id']==$row['lead_type_id']) { echo ' selected="selected"';} ?> ><?php echo $LTS['lead_type_name'];?></option>

<?php } ?>

<?php } ?>

</select>

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 col-form-label">Lead Category *</label>

<div class="col-md-8">

<select class="form-control required" id="lead_cat_id" name="lead_cat_id"> 

<option value="">--- Select ---</option>

<?php if($categories){ ?>

<?php foreach($categories as $LC){ ?>

<option value="<?php echo $LC['lead_cat_id'];?>" <?php if($LC['lead_cat_id']==$row['lead_cat_id']) { echo ' selected="selected"';} ?> ><?php echo $LC['lead_cat_name'];?></option>

<?php } ?>

<?php } ?>

</select>

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 col-form-label">Lead Stage *</label>

<div class="col-md-8">

<select class="form-control required" id="lead_stage_id" name="lead_stage_id"> 

<option value="">--- Select ---</option>

<?php if($lead_stages){ ?>

<?php foreach($lead_stages as $LST){ ?>

<option value="<?php echo $LST['lead_stage_id'];?>" <?php if($LST['lead_stage_id']==$row['lead_stage_id']) { echo ' selected="selected"';} ?>><?php echo ucwords($LST['lead_stage_name']);?></option>

<?php } ?>

<?php } ?>

</select>

</div>

</div>

</div>



<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 col-form-label">Estimate order value</label>

<div class="col-md-8">

<input type="text" class="form-control number" name="lead_info" id="lead_info" value="<?php echo $row['lead_info'];?>"  >

</div>

</div>

</div>





<?php $lead_sports_types_array=explode(',',$row['lead_sports_types']); ?>

<div class="col-md-12">

<div class="form-group row">

<label class="col-md-2 col-form-label">Sports Types *</label>

<div class="col-md-10">

<select class="js-example-basic-multiple w-100 required" multiple="multiple" name="sports_type_id[]"  id="sports_type_id">

<?php if($sports_types){ ?>

<?php foreach($sports_types as $ST){ ?>

<option value="<?php echo $ST['sports_type_id'];?>" <?php if (in_array($ST['sports_type_id'], $lead_sports_types_array)){ echo ' selected="selected"'; } ?>><?php echo $ST['sports_type_name'];?></option>

<?php } ?>

<?php } ?>

</select>

</div>

</div>

</div>







<div class="col-md-12">

<div class="form-group row">

<label class="col-md-2 col-form-label">Description *</label>

<div class="col-md-10">

<textarea class="form-control required" id="lead_desc" name="lead_desc" rows="4"><?php echo $row['lead_desc'];?></textarea>

</div>

</div>

</div>



<div class="col-md-12">

<div class="form-group row">

<label class="col-md-2 col-form-label">Lead remark *</label>

<div class="col-md-10">

<textarea class="form-control required" id="lead_desc" name="lead_remark" rows="4"><?php echo $row['lead_remark'];?></textarea>

</div>

</div>

</div>





<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Lead attachment *</label>
<div class="col-md-10">
<input type="file" name="lead_attachment" class="" id="lead_attachment">
<input type="hidden" name="lead_attachment_old" class="" id="lead_attachment_old" value="<?php echo $row['lead_attachment'];?>"><br />
<label class="mt-1">Attached File : <a href="<?php echo base_url();?>uploads/leads/<?php echo $row['lead_attachment'];?>" target="_blank"><?php echo $row['lead_attachment'];?></a></label>
</div>
</div>
</div>
</div>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Lead Owner</strong></p>
<div class="row">
<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Staff Code*</label>
<div class="col-md-4">
<select class="js-example-basic-multiple w-100 required"  name="lead_owner_id"  id="lead_owner_id">
<?php if($lead_staffs){ ?>

<option value="">--- Select ---</option>

<?php foreach($lead_staffs as $LS){ ?>

<option value="<?php echo $LS['staff_id'];?>" <?php if($LS['staff_id']==$row['lead_owner_id']){ echo 'selected="selected"'; }?> ><?php echo $LS['staff_code'];?>-<?php echo $LS['staff_name'];?></option>

<?php } ?>

<?php } ?>

</select>

<span id="coderesponse"></span>

</div>

</div>

</div>

</div>









<input class="btn btn-primary float-right" type="submit" value="Submit" id="submit" name="submit">

<?php echo form_close(); ?>

</div>

</div>

</div>

</div>

</div>

<script language="javascript">



function chkstaffcode(code){

	

	var post_data = {

	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'

	};

	$('#coderesponse').html("<p style='text-align:center; color:#030;'>Checking... </p>");

	$.ajax({

	type: "POST",

	 dataType: 'json',

	url: "<?= base_url("staff/chk_staff_code/");?>"+code,

	data: post_data

	}).done(function(reply) {

		

		

		if(reply.responseCode=="invalid"){

			$("#submit").attr("disabled", "disabled");

			$('#coderesponse').html("<p style='text-align:center; color:#F00;'>"+reply.responseMsg+"</p>");

		}else{

			$("#submit").removeAttr("disabled");

			$('#coderesponse').html("");

		}

		//$('#loadClientData').html(reply);

	});

}



var filter_row = <?php echo $customer_social_media_links;?>;

function addFilterRow(){

	

	html='<tr id="inv-row'+filter_row +'">';

	html+='<td><input type="text" class="form-control text-center required "   id="platform'+filter_row+'" name="socialmedia['+filter_row+'][platform]" placeholder="Enter Social media platform"></td>';

	html+='<td><input type="text" class="form-control text-center required"   id="link'+filter_row+'" name="socialmedia['+filter_row+'][link]"  placeholder="Enter Social media platform url"></td>';

	html+='<td><a href="javascript:void(0);" onclick="removeRow('+filter_row+');">Remove</a></td>';

	html+='</tr>';

	$('#invDataTableRow').append(html);

	filter_row++;

	

}

function removeRow(filter_row){

	$('#inv-row'+filter_row).remove();



}

function chkphonenumber(pno,customer_id){

	var post_data = {

	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'

	};

	$('#pnoresponse').html("<p style='text-align:center; color:#030;'>Checking... </p>");

	$.ajax({

	type: "POST",

	 dataType: 'json',

	url: "<?= base_url("leads/customer_mob_ajax/");?>"+pno+"/"+customer_id,

	data: post_data

	}).done(function(reply) {

		

		

		if(reply.responseCode=="notavailable"){

			$("#submit").attr("disabled", "disabled");

			$('#pnoresponse').html("<p style='text-align:center; color:#F00;'>"+reply.responseMsg+"</p>");

		}else{

			$("#submit").removeAttr("disabled");

			$('#pnoresponse').html("<p style='text-align:center; color:#030;'>"+reply.responseMsg+"</p>");

		}

		//$('#loadClientData').html(reply);

	});

}





$(function() {

$(".js-example-basic-single").select2();		   

if ($(".js-example-basic-multiple").length) {

    $(".js-example-basic-multiple").select2();

 }	

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