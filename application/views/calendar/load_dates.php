<div class="content-wrapper">
<div class="row grid-margin">
<div class="col-12">
<div class="card">
<div class="card-body">
<?php 

?>


<h4 class="card-title"><?php echo $month_and_year=date("F Y", strtotime($created_date));?> <?php //print_r($non_working_days);?></h4>
	<form action="post" id="calenderData" name="calenderData">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="system_working_capacity_sec" id="system_working_capacity_sec" value="<?php echo $systemRow1['calculation_value'];?>" />
    <div class="row">
    <div class="col-md-12">
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
    <?php if($production_unit_ids==""){?>
    <div class="alert alert-warning" role="alert">Required atleast one production unit!!!</div>
	<?php } ?>
    <input type="hidden" name="production_unit_ids" id="production_unit_ids" value="<?php echo $production_unit_ids;?>" />
    <?php 
	$row_current='';
	$total_pro=0;
	for($i=1;$i<=$no_of_days;$i++){ 
		$day_number=$i;
		if($i<=9){
			$day_number='0'.$i;
		}
		$colour_class='badge-success';
		$working='yes';
		$capacity='100';
		
		$new_created_date=$posted_year.'-'.$posted_month.'-'.$day_number;
		$second_saturday_number=date('d', strtotime('second saturday of '.$month_and_year));
		$dayname=date("l", strtotime($new_created_date));
		
		//echo $day_number."==".$second_saturday_number;
		if($day_number==$second_saturday_number){
			$nonworkingRow=$this->calendar_model->get_non_working_days('Second Saturday');
			if($nonworkingRow['non_working_id']!=""){
				$colour_class='badge-danger';
				$working='no';
				$capacity='0';
			}
		}else{
			$nonworkingRow=$this->calendar_model->get_non_working_days($dayname);
			if($nonworkingRow['non_working_id']!=""){
				$colour_class='badge-danger';
				$working='no';
				$capacity='0';
			}
		}
		
		
		
	?>
    <tr>
    <td>
    <input type="text" class="form-control text-center " id="date<?php echo $i;?>" name="dates[<?php echo $i;?>][date]" value="<?php echo date("d-m-Y", strtotime($new_created_date));?>" readonly="readonly">
    </td>
    
    <td >
    <label class="badge <?php echo $colour_class;?> row_class_<?php echo $i;?>"><?php echo $dayname; ?></label>
    </td>
    
    <td>
    <select class="form-control required "  id="working<?php echo $i;?>" name="dates[<?php echo $i;?>][working]"  onchange="setRowStatus(this.value,<?php echo $i;?>);"  > 
<option value="yes"  <?php if($working=='yes'){ echo 'selected="selected"';} ?> >Yes</option>
<option value="no" <?php if($working=='no'){ echo 'selected="selected"';} ?> >No</option>
</select>
    </td>
    
    
    <input type="hidden" class="form-control text-center" id="Design<?php echo $i;?>" name="dates[<?php echo $i;?>][Design]" value="200" >
    <input type="hidden" class="form-control text-center" id="Printing<?php echo $i;?>" name="dates[<?php echo $i;?>][Printing]" value="200" >
    <input type="hidden" class="form-control text-center" id="Fusing<?php echo $i;?>" name="dates[<?php echo $i;?>][Fusing]" value="200" >
    <input type="hidden" class="form-control text-center" id="Bundling<?php echo $i;?>" name="dates[<?php echo $i;?>][Bundling]" value="200" >
    <input type="hidden" class="form-control text-center" id="FinalQc<?php echo $i;?>" name="dates[<?php echo $i;?>][FinalQc]" value="200" >
    <input type="hidden" class="form-control text-center" id="Dispatch<?php echo $i;?>" name="dates[<?php echo $i;?>][Dispatch]" value="200" >
    
    
    <?php if($production_units) {?>
    <?php foreach($production_units as $PU) { $total_pro=$total_pro+$PU['production_unit_capacity'];?>
    <td>
    <input type="number" class="form-control text-center required digits untClass<?php echo $i;?> row_class_<?php echo $i;?>" 
		id="unit_<?php echo $PU['production_unit_id'];?><?php echo $i;?>" 
        name="dates[<?php echo $i;?>][unit_<?php echo $PU['production_unit_id'];?>_<?php echo $i;?>]"
		maxlength="3" minlength="1" min='0' max='300' value="<?php echo $PU['production_unit_capacity'];?>"
		onkeyup="calculateCapacity(<?php echo $PU['production_unit_id'];?>,<?php echo $i;?>);"
		onchange="calculateCapacity(<?php echo $PU['production_unit_id'];?>,<?php echo $i;?>);">
    </td>
    	
    <?php } } ?>
    
    <td>
    <input type="text" class="form-control text-center required digits" id="capacity<?php echo $i;?>" name="dates[<?php echo $i;?>][capacity]"
     maxlength="3" minlength="1" min='0'  value="<?php echo $total_pro;?>" readonly="readonly">
     <?php $total_pro=0;?>
   </td>
    
    <td>
    <input type="text" class="form-control text-center" id="remark<?php echo $i;?>" name="dates[<?php echo $i;?>][remark]" maxlength="100" >
    </td>    
     
    <td>
    </td>
    </tr>
    
    <?php } ?>
    </tbody>
    </table>
    <?php if($production_unit_ids!=""){?>
    <input class="btn btn-primary float-right" type="submit" value="Save" id="submitDataa" name="submitDataa">
    <?php }?>
    </div>
    
    
    </div>
    </form>
</div>
</div>


</div>
</div>




</div>
<script type="text/javascript">
function setRowStatus(value,current){
	if(value=="yes"){
		
		$(".row_class_"+current).css("background", "#7ed321");
		//$(".row_class_"+current).val(0);
	}else{
		$(".row_class_"+current).css("background", "red");
		$(".row_class_"+current).val(0);
	}
	return false;
}

function calculateCapacity(unit_id,current_row){
	//alert(unit_id);
	//alert(current_row);
	var total=0;
	$(".untClass"+current_row).each(function(){
        // Test if the div element is empty
		//alert("Okk"+$(this).val());
		total += parseInt( $(this).val() );
		//alert(total);
		
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
//$("#submitDataa").attr("disabled", "disabled");
$('#submitDataa').html("Please Wait ...");
//$('#response').html('<font class="text-yellow">Checking.Please wait..</font>');
$('#dateContent2').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Saving...</p>');
$.post('<?= base_url("calendar/save_calender_dates/");?>', $("#calenderData").serialize(), function(data) {
		$('#dateContent2').html("");																							
	var dataRs = jQuery.parseJSON(data);
	$("#submitDataa").delay("slow").fadeIn();
	$('#submitDataa').html("Save");
	$('#submitDataa').removeAttr("disabled");
	$('#dateContent').html(dataRs.responseMsg);
	$( '#calenderData' ).each(function(){this.reset();});
	$( '#dateInputForm' ).each(function(){this.reset();});
	
	
});	
}
});
});
</script>
