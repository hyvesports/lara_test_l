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



<?php if($this->session->flashdata('error')): ?>

<div class="alert alert-danger" style="width:100%;">

<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>

<?=$this->session->flashdata('error')?>

</div>

<?php endif; ?>



<?php if($this->session->flashdata('success')): ?>

<div class="alert alert-success" style="width:100%;">

<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>

<?=$this->session->flashdata('success')?>

</div>

<?php endif; ?>





<h4 class="card-title"><?php echo $title_head;?>

<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('leads/index');?>">All Leads</a></span> 

</h4>



<?php echo form_open_multipart(base_url('leads/add'), 'class="cmxform"  id="dataform" method="post"'); ?>



<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Lead Customer / Company Details</strong></p>





<div class="row">

    <div class="col-md-12">

    <div class="form-group row">

    <label class="col-md-2 col-form-label">Client / Company *</label>

    <div class="col-md-10">

    <select class="js-example-basic-single w-100 required" onchange="loadCustForm(this.value);"  id="customer_id" name="customer_id" >

    <option value="">--- Select ---</option>

    <option value="0">Add New Client / Company</option>

    <?php if($customers){ ?>

    <?php foreach($customers as $cus){ ?>

    <option value="<?php echo $cus['customer_id'];?>"><?php echo $cus['customer_code'];?>-<?php echo $cus['customer_name'];?></option>

    <?php } ?>

    <?php } ?>

    

    </select>

    </div>

    </div>

    </div>

 </div>   

<div class="row" id="loadClientData"></div>







<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong> Lead Details</strong></p>

<div class="row">

<div class="col-md-6">

<div class="form-group row">

<label class="col-md-4 col-form-label">Date (dd/mm/yyyy)*</label>

<div class="col-md-8">

<input type="text" class="form-control required" name="lead_date" id="lead_date" maxlength="100" data-inputmask="'alias': 'date'" value="<?php echo date('d/m/Y');?>">

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

<option value="<?php echo $LS['lead_source_id'];?>"><?php echo $LS['lead_source_name'];?></option>

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

<option value="<?php echo $LTS['lead_type_id'];?>"><?php echo $LTS['lead_type_name'];?></option>

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

<option value="<?php echo $LC['lead_cat_id'];?>"><?php echo $LC['lead_cat_name'];?></option>

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

<option value="<?php echo $LST['lead_stage_id'];?>"><?php echo ucwords($LST['lead_stage_name']);?></option>

<?php } ?>

<?php } ?>

</select>

</div>

</div>

</div>



<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Estimate order value </label>
<div class="col-md-8">
<input type="text" class="form-control number" name="lead_info" id="lead_info"  >
</div>

</div>

</div>





<div class="col-md-12">

<div class="form-group row">

<label class="col-md-2 col-form-label">Sports Types *</label>

<div class="col-md-10">

<select class="js-example-basic-multiple w-100 required" multiple="multiple" name="sports_type_id[]"  id="sports_type_id">

<?php if($sports_types){ ?>

<?php foreach($sports_types as $ST){ ?>

<option value="<?php echo $ST['sports_type_id'];?>"><?php echo $ST['sports_type_name'];?></option>

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

<textarea class="form-control required" id="lead_desc" name="lead_desc" rows="4"><?php echo $this->input->post('lead_desc');?></textarea>

</div>

</div>

</div>



<div class="col-md-12">

<div class="form-group row">

<label class="col-md-2 col-form-label">Lead remark *</label>

<div class="col-md-10">

<textarea class="form-control required" id="lead_desc" name="lead_remark" rows="4"><?php echo $this->input->post('lead_remark');?></textarea>

</div>

</div>

</div>





<div class="col-md-12">

<div class="form-group row">

<label class="col-md-2 col-form-label">Lead attachment *</label>

<div class="col-md-10">

<input type="file" name="lead_attachment" class="" id="lead_attachment">

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

<!--<input type="text" class="form-control required" name="staff_code" id="staff_code" maxlength="100" onkeyup="chkstaffcode(this.value);">

-->



<select class="js-example-basic-multiple w-100 required"  name="lead_owner_id"  id="lead_owner_id">

<?php if($lead_staffs){ ?>

<option value="">--- Select ---</option>

<?php foreach($lead_staffs as $LS){ ?>

<option value="<?php echo $LS['staff_id'];?>"><?php echo $LS['staff_code'];?>-<?php echo $LS['staff_name'];?></option>

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





function chkphonenumber(pno){

	var post_data = {

	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'

	};

	$('#pnoresponse').html("<p style='text-align:center; color:#030;'>Checking... </p>");

	$.ajax({

	type: "POST",

	 dataType: 'json',

	url: "<?= base_url("leads/customer_mob_ajax/");?>"+pno+"/0",

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



function loadCustForm(cid){

var post_data = {

'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'

};



$('#loadClientData').html("<p style='text-align:center'>Loading... </p>");

//alert(cid);

$.ajax({

type: "POST",

url: "<?= base_url("leads/customer_ajax/");?>"+cid,

data: post_data

}).done(function(reply) {

	//$('#loadClientData').html("");

	$('#loadClientData').html(reply);

});

}

</script>

<script language="javascript">



var filter_row = 1;

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