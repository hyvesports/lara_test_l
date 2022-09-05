<?php
if(empty($allDates)){
echo $responseMsg='<div class="alert alert-warning" style="width:100%;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>Invalid Unit</div>';
exit;
}
?>
<form action="post" id="calenderData" name="calenderData">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<div class="row">
    <div class="col-md-12">
    <span id="dateContent"></span>

	<table class="table table-responsive mb-0 table-hover" width="100%">
    <thead>
    <tr class="item_header">
    <th width="12%"  class="text-left">Date</th>
    <th width="10%"  class="text-left">Day Name</th>
    <th width="10%"  class="text-left">Working</th>
    <th width="10%"  class="text-left">Design</th>
	<th width="10%"  class="text-left">Printing</th>
  	<th width="10%"  class="text-left">Fusing</th>
   <th width="10%"  class="text-left">Bundling</th>
<th width="10%"  class="text-left">Final QC</th>
<th width="10%"  class="text-left">Dispatch</th>
    </tr>
    </thead>
    <tbody>
    
    <?php if($allDates){ $i=0;?>
    <?php foreach($allDates as $row){ 
		
		
		$day_number=$i;
		if($i<=9){
			$day_number='0'.$i;
		}
		
		$second_saturday_number=date('d', strtotime('second saturday of '.$month_and_year));
		$dayname=date("l", strtotime($row['unit_calendar_date']));
		$colour_class='badge-success';
		
		$colour_class='badge-success';
		$working='yes';
		$remark=$row['day_remark'];
		
		if($day_number==$second_saturday_number){
			$nonworkingRow=$this->calendar_model->get_non_working_days('Second Saturday');
			if($nonworkingRow['non_working_id']!=""){
				$colour_class='badge-danger';
				$working='no';
				//$capacity='0';
			}
		}else{
			$nonworkingRow=$this->calendar_model->get_non_working_days($dayname);
			if($nonworkingRow['non_working_id']!=""){
				$colour_class='badge-danger';
				$working='no';
				//$capacity='0';
			}
		}
		
		if($working=='no'){
			$colour_class='badge-danger';
		}


		?>
    	<input type="hidden" class="form-control text-center" id="unit_calendar_id<?php echo $i;?>" name="dates[<?php echo $i;?>][unit_calendar_id]" 
        value="<?php echo $row['unit_calendar_id'];?>" readonly="readonly">
        
        
    	<tr>
        <td><input type="text" class="form-control text-center" id="date<?php echo $i;?>" name="dates[<?php echo $i;?>][date]" readonly="readonly"  value="<?php echo date("d-m-Y", strtotime($row['unit_calendar_date']));?>"></td>
        <td ><label class="badge <?php echo $colour_class;?>"><?php echo $dayname; ?></label></td>
        <td> <?php if($working=='yes'){ echo 'Yes';}else{ echo 'No';} ?></td>
    	<td>
		<input type="number" class="form-control text-center required digits" id="design_<?php echo $i;?>" name="dates[<?php echo $i;?>][design]" value="<?php echo $row['allocated_to_design'];?>">
		</td>
		<td>
		<input type="number" class="form-control text-center required digits" id="printing_<?php echo $i;?>" name="dates[<?php echo $i;?>][printing]" value="<?php echo $row['allocated_to_printing'];?>">
		</td>
		<td>
		<input type="number" class="form-control text-center required digits" id="fusing_<?php echo $i;?>" name="dates[<?php echo $i;?>][fusing]" value="<?php echo $row['allocated_to_fusing'];?>">
		</td>
		
		<td>
		<input type="number" class="form-control text-center required digits" id="bundling_<?php echo $i;?>" name="dates[<?php echo $i;?>][bundling]" value="<?php echo $row['allocated_to_bundling'];?>">
		</td>
		<td>
		<input type="number" class="form-control text-center required digits" id="finalqc_<?php echo $i;?>" name="dates[<?php echo $i;?>][finalqc]" value="<?php echo $row['allocated_to_finalqc'];?>">
		</td>
		<td>
		<input type="number" class="form-control text-center required digits" id="dispatch_<?php echo $i;?>" name="dates[<?php echo $i;?>][dispatch]" value="<?php echo $row['allocated_to_dispatch'];?>">
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



</div>
</form>
<script type="text/javascript">

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
$.post('<?= base_url("calendar/update_dept_qty/");?>', $("#calenderData").serialize(), function(data) {
		$('#dateContent2').html("");																							
	var dataRs = jQuery.parseJSON(data);
	$("#submitDataa").delay("slow").fadeIn();
	$('#submitDataa').html("Save");
	$('#submitDataa').removeAttr("disabled");
	//$('#dateContent').html(dataRs.responseMsg);

	
	
});	
}
});
});
</script>
