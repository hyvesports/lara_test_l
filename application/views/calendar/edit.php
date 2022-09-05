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
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('calendar/index');?>">List</a></span> 
</h4>

<h4 class="card-title"><?php echo $month_and_year;?> <?php //print_r($non_working_days);?></h4>
<form action="post" id="calenderData" name="calenderData">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="system_working_capacity_sec" id="system_working_capacity_sec" value="<?php echo $systemRow1['calculation_value'];?>" />
    <div class="row">
    <div class="col-md-12">
    <span id="dateContent"></span>

	<table class="table table-responsive mb-0" width="100%">
    <thead>
    <tr class="item_header">
    <th width="12%"  class="text-left">Date</th>
    <th width="10%"  class="text-left">Day Name</th>
    <th width="10%"  class="text-left">Working</th>
    <?php if($production_units) { $k=0; $production_unit_ids;?>
    <?php foreach($production_units as $PU) { if($k==0){ $production_unit_ids=$PU['production_unit_id']; }else{ $production_unit_ids.=",".$PU['production_unit_id'];} $k++;?>
    <th width="10%"  class="text-left"><?php echo $PU['production_unit_name'];?> %</th>
    <?php } ?>
    <?php } ?>
    <th width="18%"  class="text-left">Total Production %</th>
    <th width="38%"  class="text-center">Remark</th>
   
    </tr>
    </thead>
    <tbody>
    <input type="hidden" name="production_unit_ids" id="production_unit_ids" value="<?php echo $production_unit_ids;?>" />
    <?php if($allDates){ $i=0;?>
    <?php foreach($allDates as $row){ 
		
		
		$day_number=$i;
		if($i<=9){
			$day_number='0'.$i;
		}
		
		$second_saturday_number=date('d', strtotime('second saturday of '.$month_and_year));
		$dayname=date("l", strtotime($row['calendar_date']));
		$colour_class='badge-success';
		
		$working=$row['working_type'];
		$capacity=$row['working_capacity'];
		$remark=$row['day_remark'];
		
		if($day_number==$second_saturday_number){
			$nonworkingRow=$this->calendar_model->get_non_working_days('Second Saturday');
			if($nonworkingRow['non_working_id']!=""){
				$colour_class='badge-danger';
				//$working='no';
				//$capacity='0';
			}
		}else{
			$nonworkingRow=$this->calendar_model->get_non_working_days($dayname);
			if($nonworkingRow['non_working_id']!=""){
				$colour_class='badge-danger';
				//$working='no';
				//$capacity='0';
			}
		}
		
		if($working=='no'){
			$colour_class='badge-danger';
		}


		?>
    	<input type="hidden" class="form-control text-center" id="calendar_id<?php echo $i;?>" name="dates[<?php echo $i;?>][calendar_id]" 
        value="<?php echo $row['calendar_id'];?>" readonly="readonly">
        
        
    	<tr>
        <td>
        <input type="text" class="form-control text-center" id="date<?php echo $i;?>" name="dates[<?php echo $i;?>][date]" 
        value="<?php echo date("d-m-Y", strtotime($row['calendar_date']));?>" readonly="readonly">
        </td>
        
        <td >
        <label class="badge <?php echo $colour_class;?>"><?php echo $dayname; ?></label>
        </td>
        
        <td>
        <select class="form-control required"  id="working<?php echo $i;?>" name="dates[<?php echo $i;?>][working]"   > 
    <option value="yes"  <?php if($working=='yes'){ echo 'selected="selected"';} ?> >Yes</option>
    <option value="no" <?php if($working=='no'){ echo 'selected="selected"';} ?> >No</option>
    </select>
        </td>
        
        <?php if($production_units) {?>
    <?php foreach($production_units as $PU) {
		
		$cuRow=$this->calendar_model->get_production_unit_calendar($PU['production_unit_id'],$row['calendar_id']);
		
		?>
    <td>
    <input type="number" class="form-control text-center required digits untClass<?php echo $i;?>" 
		id="unit_<?php echo $PU['production_unit_id'];?><?php echo $i;?>" 
        name="dates[<?php echo $i;?>][unit_<?php echo $PU['production_unit_id'];?>_<?php echo $i;?>]"
		maxlength="3" minlength="1" min='0' max='300' value="<?php echo $cuRow['unit_work'];?>"
		onkeyup="calculateCapacity(<?php echo $PU['production_unit_id'];?>,<?php echo $i;?>);"
		onchange="calculateCapacity(<?php echo $PU['production_unit_id'];?>,<?php echo $i;?>);">
    </td>
    	
    <?php } } ?>
        
        <td>
        <input type="number" class="form-control text-center required digits" id="capacity<?php echo $i;?>" name="dates[<?php echo $i;?>][capacity]"
         maxlength="3" minlength="1" min='0'  value="<?php echo $capacity;?>">
        </td>
        
        <td>
        <input type="text" class="form-control text-center" id="remark<?php echo $i;?>" name="dates[<?php echo $i;?>][remark]" maxlength="100" value="<?php echo $remark;?>">
        </td>    
         
        <td>
        </td>
        </tr>
    
    <?php $i++; } ?>
    <?php } ?>
    </tbody>
    
    </table>
    <input class="btn btn-primary float-right" type="submit" value="Save" id="submitDataa" name="submitDataa">
    </div>
    
    
    </div>
    </form>
</div>
</div>


</div>
</div>



</div>
<script type="text/javascript">

function calculateCapacity(unit_id,current_row){
	//alert(unit_id);
	//alert(current_row);
	var total=0;
	$(".untClass"+current_row).each(function(){
        // Test if the div element is empty
		//alert("Okk"+$(this).val());
		total += parseInt( $(this).val() );
		//alert(total);
		if(total>100){
			$("#capacity"+current_row).css("background", "yellow");

		}else{
			$("#capacity"+current_row).css("background", "white");
		}
		$("#capacity"+current_row).val(total);
        if($(this).is(":empty")){
            $(this).css("background", "yellow");
        }
    });
	
}

$(document).ready(function() {
$("#calenderData").validate({
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
//$('#response').html('<font class="text-yellow">Checking.Please wait..</font>');
$('#dateContent').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Saving...</p>');
$.post('<?= base_url("calendar/update_calender_dates/");?>', $("#calenderData").serialize(), function(data) {
		$('#dateContent').html("");																							
	var dataRs = jQuery.parseJSON(data);
	$("#submitDataa").delay("slow").fadeIn();
	$('#submitDataa').html("Save");
	$('#submitDataa').removeAttr("disabled");
	$('#dateContent').html(dataRs.responseMsg);
	//$( '#calenderData' ).each(function(){this.reset();});
	
});	
}
});
});
</script>
