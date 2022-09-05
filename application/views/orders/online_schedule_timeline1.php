<?php
$unit_id=$this->input->post('unit_id');
$production_start_date=$this->input->post('production_start_date');
$production_start_date_strtotime= strtotime($production_start_date);
//$dayLimit=7;
$systemRow=$this->schedule_model->get_system_production_days('ONPD');
//print_r($systemRow);
//echo $systemRow['allocation'];
$allocation=json_decode($systemRow['allocation']);
//echo count($allocation);
$dayLimit=$systemRow['calculation_value'];
$datesRows=$this->schedule_model->get_productions_available_days($production_start_date,$dayLimit);
//print_r($datesRows);
//echo $dayLimit;
$datesRowsCount=count($datesRows);
$isAvailable='Available';
if($datesRowsCount==$dayLimit) {
	$dateLastRow=$datesRowsCount-1;
	//print_r($datesRows[$dateLastRow]);
	$working_capacity=$datesRows[$dateLastRow]['working_capacity'];
	$schedule_percentage=$datesRows[$dateLastRow]['schedule_percentage'];
	if($schedule_percentage==""){
		$schedule_percentage=0;
	}
	//echo $schedule_percentage."=123";exit;
	$calendar_date=$datesRows[$dateLastRow]['calendar_date'];
	
	$working_capacity_in_sec=$datesRows[$dateLastRow]['working_capacity_in_sec'];
	$schedule_percentage_sec=$datesRows[$dateLastRow]['schedule_percentage_sec'];
	if($schedule_percentage_sec==""){
		$schedule_percentage_sec=0;
	}
	
	$calendar_id=$datesRows[$dateLastRow]['calendar_id'];
	$production_unit_ids=$datesRows[$dateLastRow]['production_unit_ids'];
	//echo $production_unit_ids;
	$expected_dispatch_date=strtotime($calendar_date);
	if($working_capacity==$schedule_percentage){
		$isAvailable='ScheduleCompleted';
	}else{
		$x=0;
		$qty=0;
		$total_x=0;
		$q=0;
		if($summary){
			foreach($summary as $umm){
				if($umm['wo_product_making_time']!=""){ $x+=$umm['wo_product_making_time']; }
				if($umm['wo_collar_making_min']!=""){ $x+=$umm['wo_collar_making_min']; }
				if($umm['wo_sleeve_making_time']!=""){ $x+=$umm['wo_sleeve_making_time']; }
				if($umm['wo_fabric_making_min']!=""){ $x+=$umm['wo_fabric_making_min']; }
				if($umm['wo_addon_making_min']!=""){ $x+=$umm['wo_addon_making_min']; }
				//echo "Qty=60  x".$x."=".$x*60;
				
				$y=$x*60;
				$z=$y*$umm['wo_qty']; //echo "<br/>";
				//echo $z;
				$total_x+=$z;
				//echo "<br/>";
				//$q=$x*$umm['wo_qty'];
				//$qty=$qty+$umm['wo_qty'];
				//$total_x+=$x;
				//echo $q."<br/>";
				$x=0;
			}
			
		}
		//echo $total_x;
		
		//$x=$sumTotal['total_making_time']*$sumTotal['total_making_qty'];
		$systemRow1=$this->schedule_model->get_system_production_days('WH');
		//$x = 1920;
		$y = $systemRow1['calculation_value'];
		
		$x_sec=$total_x;
		$percent = ($x_sec)/$y;
		$order_percent=round( number_format( $percent * 100, 2 )) . '%'; 
		$production_units=$this->schedule_model->get_all_production_active_units($unit_id);
		//$departments=$this->schedule_model->get_production_departments();
		//print_r($departments);
	}
	
}else{
	$isAvailable='ScheduleCalender';
}

//echo $isAvailable;
?>
<form name="scheduleForm" id="scheduleForm">
<div class="row">
<div class="col-12 mt-2">


	<h5 class="mb-3" style="border-bottom: 1px solid #f2f2f2; ">Availability</h5>
	<?php if($isAvailable=="ScheduleCalender") {?>
    <div class="card card-inverse-danger mb-5">
    <div class="row">
        <div class="card-body col-md-12" style="padding: 30px 30px;">
        <div class=" d-flex flex-row align-items-top">
        <i class="fa fa-calendar text-facebook icon-md"></i>
        <div class="ml-3">
        <h6 class="text-facebook">Dispatch Date Not Available</h6>
        <p class="mt-2 text-muted card-text">Please Create  Or update Production Calender</p>
        </div>
        </div>
        </div>
    </div>
    </div>
    <?php }else if($isAvailable=="ScheduleCompleted"){ ?>
    <div class="card card-inverse-warning mb-5">
    <div class="row">
        <div class="card-body col-md-12" style="padding: 30px 30px;">
        <div class=" d-flex flex-row align-items-top">
        <i class="fa fa-calendar text-facebook icon-md"></i>
        <div class="ml-3">
        <h6 class="text-facebook">Production Capacity Reached Maximum On <?php echo date('M d, Y', $expected_dispatch_date);?></h6>
        <p class="mt-2 text-muted card-text">Production Start Date : <?php echo date('M d, Y', $production_start_date_strtotime);?></p>
        <p class="mt-2 text-muted card-text">Expected Dispatch Date : <?php echo date('M d, Y', $expected_dispatch_date);?></p>
        </div>
        </div>
        </div>
    </div>
    </div>
    <?php }else if($isAvailable=="Available"){ ?>
    <div class="card card-inverse-success mb-5">
    <div class="row">
    	
        <div class="card-body col-md-3" style="padding: 30px 30px;">
        <div class=" d-flex flex-row align-items-top">
        <i class="fa fa-calendar text-primary icon-md"></i>
        <div class="ml-3">
        <h6 class="text-primary"><?php echo date('M d, Y', $expected_dispatch_date);?></h6>
        <p class="mt-2 text-muted card-text">Expected Dispatch Date</p>
        </div>
        </div>
        </div>
        
        <div class="card-body col-md-3" style="padding: 30px 30px;">
        <div class=" d-flex flex-row align-items-top">
        <i class="fa fa-shopping-cart text-facebook icon-md"></i>
        <div class="ml-3">
        <h6 class="text-facebook"><?php echo $order_percent;?></h6>
        <p class="mt-2 text-muted card-text">Order Capacity</p>
        </div>
        </div>
        </div>
        
        <div class="card-body col-md-3" style="padding: 30px 30px;">
        <div class=" d-flex flex-row align-items-top">
        <i class="fa fa-thumbs-up text-success icon-md"></i>
        <div class="ml-3">
        <h6 class="text-success"><?php
		//echo $schedule_percentage;
		echo $AvailableCapacity=$working_capacity-$schedule_percentage;?>%</h6>
        <p class="mt-2 text-muted card-text">Available Capacity</p>
        </div>
        </div>
        </div>
    
        <div class="card-body col-md-3" style="padding: 30px 30px;">
        <div class=" d-flex flex-row align-items-top">
        <i class="fa fa-gavel text-warning icon-md"></i>
        <div class="ml-3">
        <h6 class="text-warning"><?php echo $working_capacity;?>%</h6>
        <p class="mt-2 text-muted card-text">Total Capacity</p>
        </div>
        </div>
        </div>
    
        
    </div>
    </div>
 </div> 

 	<div class="col-md-12">
    <h5 class="mb-3" >Order Details</h5>
    <label class="badge  w-100" style="background-color:<?php echo ucwords($row['priority_color_code']);?>">Priority : <strong><?php echo ucwords($row['priority_name']);?></strong></label>
    <table class="table">
    <thead>
    <tr>
   
    <th>Product <br/> <label class="badge badge-warning mt-1">Date : <?php echo $calendar_date;?></label></th>
    <th>Qty <br/> <label class="badge badge-warning mt-1">Total: <?php echo $qty;?></label></th>
    <!--<th>Making Time</th>
    <th>Total Time</th>-->
	<?php if($production_units) { $k=0; $production_unit_ids;?>
    <?php foreach($production_units as $PU) { if($k==0){ 
	$production_unit_ids=$PU['production_unit_id']; }else{ $production_unit_ids.=",".$PU['production_unit_id'];} $k++;
	$cuRow=$this->calendar_model->get_production_unit_calendar($PU['production_unit_id'],$calendar_id);
	//print_r($cuRow);
	?>
    <th width="15%"  class="text-left"><?php echo $PU['production_unit_name'];?>
    <br /><label class="badge badge-warning mt-1">Capacity: <?php echo $cuRow['unit_work']-$cuRow['unit_work_completed'];?>%</label>
    <br/><?php $avilabile_unit_day_capcity_sec=$cuRow['unit_working_capacity_in_sec']-$cuRow['schedule_unit_percentage_sec'];?>
        <input type="hidden"
        name="day_avilabile_unit_capaciy_sec_<?php echo $PU['production_unit_id'];?>"
        id="day_avilabile_unit_capaciy_sec_<?php echo $PU['production_unit_id'];?>"
        value="<?php echo $avilabile_unit_day_capcity_sec;?>" />
    </th>
    <?php } ?>
    <?php } ?>
    
    
    
    <th>Total: <br/> <label class="badge badge-warning mt-1">Capacity: <?php echo $working_capacity-$schedule_percentage;?>%</label>
    <br /><?php
	$avilabile_day_capcity_sec=$working_capacity_in_sec-$schedule_percentage_sec;
	?>
    	<input type="hidden"
        name="day_avilabil_capcity_sec"
        id="day_avilabil_capcity_sec"
        value="<?php echo $avilabile_day_capcity_sec;?>" />
    </th>
    </tr>
    </thead>
    <tbody>
    
    <?php if($summary){ ?>
    <?php 
	$m_min=0;
	$i=0;
	$j=0;
	$total_order_sec=0;
	$countRowspan=count($summary);
	foreach($summary as $item){
		if($item['wo_product_making_time']!=""){ $m_min=$m_min+$item['wo_product_making_time']; }
		if($item['wo_collar_making_min']!=""){ $m_min=$m_min+$item['wo_collar_making_min']; }
		if($item['wo_sleeve_making_time']!=""){ $m_min=$m_min+$item['wo_sleeve_making_time']; }
		if($item['wo_fabric_making_min']!=""){ $m_min=$m_min+$item['wo_fabric_making_min']; }
		if($item['wo_addon_making_min']!=""){ $m_min=$m_min+$item['wo_addon_making_min']; }
		
		?>
    <tr>
    <td>
    <h4 class="text-primary font-weight-normal"><?php echo ucwords($item['wo_product_type_name']);?></h4>
    <p class="text-muted mb-1"><?php echo ucwords($item['wo_fabric_type_name']);?>,<?php echo ucwords($item['wo_sleeve_type_name']);?>,<?php echo ucwords($item['wo_collar_type_name']);?></p>
    <?php echo ucwords($m_min);?> Min
    <?php 
	$sec=$m_min*60;
	//echo $sec;
	$t_sec=$sec*$item['wo_qty'];
	$total_order_sec=$total_order_sec+$t_sec;
	
	$t_per=$t_sec/$y;
	$percent=round( number_format( $t_per * 100, 2 ));
	?>
    <!--Order Sec--><input type="hidden" name="schedule[<?php echo $j;?>][item_order_sec]" id="item_order_sec<?php echo $j;?>" value="<?php echo $sec;?>" />
    <!-- Order Total Sec-->
    <input type="hidden" name="schedule[<?php echo $j;?>][item_order_total_sec]" id="item_order_total_sec<?php echo $j;?>" value="<?php echo $t_sec;?>" />
  	<!--Order %-->
  	<input type="hidden" name="schedule[<?php echo $j;?>][item_order_capacity]" id="item_order_capacity<?php echo $j;?>" value="<?php echo $percent;?>" />
   <!--Order Qty:-->
   <input type="hidden" name="schedule[<?php echo $j;?>][item_order_qty]" id="item_order_qty<?php echo $j;?>" value="<?php echo $item['wo_qty'];?>" />
    </td>
    <td>
    <label class="badge badge-primary"><?php echo ucwords($item['wo_qty']);?> (<?php echo $percent;?> %)</label>
    </td>

    <?php if($production_units) {?>
    <?php foreach($production_units as $PU) {
		$cuRow=$this->calendar_model->get_production_unit_calendar($PU['production_unit_id'],$calendar_id);
	?>
    <td>
    <input 
    type="number"
    class="form-control current_row_<?php echo $j;?> unit_class_<?php echo $PU['production_unit_id'];?> all_items_class" 
    placeholder="Qty" min='0' max="<?php echo $item['wo_qty'];?>" 
    name="schedule[<?php echo $j;?>][item_unit_qty<?php echo $PU['production_unit_id'];?>]"
    id="item_unit_qty_<?php echo $PU['production_unit_id'];?>_<?php echo $j;?>" 
    cid='<?php echo $j;?>'
    onkeyup="return calculateProduction(<?php echo $j;?>,<?php echo $PU['production_unit_id'];?>);" >
    
    </td>
    <?php $i++; } } ?>
    <?php if($j==0) { ?>
    <td rowspan="<?php echo $countRowspan?>" ></td>
    <?php } ?>
    </tr>
    <?php  $m_min=0; $j++;} ?>
    <?php } ?>
    </td>
    </tbody>
    <tfoot>
    <tr>
    <th></th>
    <th></th>
	<?php if($production_units) { $k=0; $production_unit_ids;?>
    <?php foreach($production_units as $PU) { if($k==0){ $production_unit_ids=$PU['production_unit_id']; }else{ $production_unit_ids.=",".$PU['production_unit_id'];} $k++;
	$cuRow=$this->calendar_model->get_production_unit_calendar($PU['production_unit_id'],$calendar_id);
	?>
    <th width="15%"  class="text-left">
    
	<?php echo $PU['production_unit_name'];?> :
    <span id='unit_per_span_<?php echo $PU['production_unit_id'];?>' class="badge badge-success mt-1"></span>
    </th>
    <?php } ?>
    <?php } ?>
    <th>
    Total:  <span id='all_capacity_span' class="badge badge-success mt-1">0%</span>
    Balance:  <span id='blnce_capacity_span' class="badge badge-info mt-1">0%</span>
    </th>
    </tr>
    </tfoot>
    </table>
    </div>  
    
    <div class="col-md-12">
    <h5 class="mb-3" >Schedule Day</h5>
    <div class="stage-wrapper pl-4">
    <?php if($allocation){ $inc=0; ?>
    <?php foreach($allocation as $day => $department){
		
		$did=explode(',',$department);
		//print_r($did);
		$department=$this->schedule_model->get_production_department_names($department);
		//$departmentRows=$this->schedule_model->get_production_department_rows($department);
		?>
    
        <div class="stages border-left pl-5 pb-4">
        <div class="btn btn-icons btn-rounded stage-badge btn-inverse-success"><?php echo $day;?></div>
        
        <div class="d-flex align-items-center mb-2 justify-content-between">
        <h5 class="mb-0"><?php echo $department['DNAME'];?></h5>
        <small class="text-muted"><label class="badge badge-success"><?php echo date('M d, Y',strtotime($datesRows[$inc]['calendar_date']));?></label></small>
        </div>
        
        <?php if($did){ ?>
        <?php foreach($did as $DROW){
			$departmentRow=$this->schedule_model->get_production_department_row($DROW);
			?>
            <div class="col-md-12">
            <p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong><?php echo $departmentRow['department_name'];?></strong></p>
            </div>
            
            <?php $staffArray=$this->schedule_model->get_staff_details_by_department($DROW); ?>
            <?php if($staffArray){ ?>
            <div class="col-md-12">
            <?php foreach($staffArray as $SROW){ ?>
            <div class="col-md-6">
                        <div class="form-check form-check-success">
                        <label class="form-check-label">
                        <input type="checkbox" class="form-check-input tgl_checkbox" id="<?php //echo $SM['menu_master_id'];?>" 
                        data-module='<?php //echo $SM['menu_controller'];?>' data-operation='<?php //echo $operation; ?>' data-main='<?php //echo $MM['menu_master_id'];?>' data-sub='<?php //echo $SM['menu_master_id'];?>' <?php //if($accessRow['staff_permission_id']!=""){ echo 'checked="checked"';} ?>  >
                        <?php echo ucwords($SROW['STAFF']);?> 
                        <i class="input-helper"></i></label>
                        </div>
			</div>
            <?php } ?>
            </div>
            <?php } ?>
            
            
        <?php  } ?>
        <?php  } ?>
        
        </div>
        
    <?php $inc++; } ?>
    <?php } ?>
    
    
    
    <div class="stages pl-5 pb-4">
    <div class="btn btn-icons btn-rounded stage-badge btn-inverse-primary">
    <i class="icon-checkbox-marked-circle-outline"></i>
    </div>
    <div class="d-flex align-items-center mb-2 justify-content-between">
    <h5 class="mb-0">Schedule Completed</h5>
    
    </div>
    
    </div>
    </div>
    </div>

<?php } ?>
</div>
</div>
</form>
<script>
function calculateProduction(current_row,unit_id){
	//alert("In"+current_row);
	
	
	var item_order_qty_row=$("#item_order_qty"+current_row).val();
	var qty=$("#item_unit_qty_"+unit_id+'_'+current_row).val();
	
	var intRegex = /^\d+$/;
	var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
	if(intRegex.test(qty) ) {
	}else{
		//alert("Invalid Number");
		$("#item_unit_qty_"+unit_id+'_'+current_row).val(0);
		swal({
		text: 'Enter a valid number',
		button: {
		text: "OK",
		value: true,
		visible: true,
		className: "btn btn-primary"
		}
		});
		return false;
	}

	
	var line_total_qty=0;
	$(".current_row_"+current_row).each(function(){
		//alert($(this).val());
		if(intRegex.test($(this).val()) ) {
			// It is a number
			line_total_qty += parseInt( $(this).val() );
		}
	});
	//alert(total_unit_capacity);
	if(line_total_qty>item_order_qty_row){
		
		swal({
		text: 'Enter a valid quantity',
		button: {
		text: "OK",
		value: true,
		visible: true,
		className: "btn btn-primary"
		}
		});

		$("#item_unit_qty_"+unit_id+'_'+current_row).css("background", "red");
		$("#item_unit_qty_"+unit_id+'_'+current_row).val("");
		//$("#submitData").attr("disabled", "disabled");
		return false;
	}
	//$('#submitDataa').removeAttr("disabled");
	$("#item_unit_qty_"+unit_id+'_'+current_row).css("background", "white");
	var unit_capacity=$("#day_avilabile_unit_capaciy_sec_"+unit_id).val();
	var unit_sec=$("#item_order_sec"+current_row).val();
	
	
	
	var total_req_capacity=parseInt(unit_sec)*parseInt(qty);
	//alert(total_req_capacity);
	if(total_req_capacity>unit_capacity){
		//alert("Production capacity reached maximum... please change item quantity!!!");
		$("#item_unit_qty_"+unit_id+'_'+current_row).val(0);
		swal({
		text: 'Production capacity reached maximum... please change item quantity!!!',
		button: {
		text: "OK",
		value: true,
		visible: true,
		className: "btn btn-primary"
		}
		});
		return false;
	}
	//
	var total_unit_capacity=0;
	var inc=0;
	$(".unit_class_"+unit_id).each(function(){	
			var item_unit_qty=parseInt($("#item_unit_qty_"+unit_id+"_"+inc).val());
			if(item_unit_qty>0){
				var item_order_sec=parseInt($("#item_order_sec"+inc).val());
				total_unit_capacity+=parseInt(item_order_sec)*parseInt(item_unit_qty);
			}
		inc++;
		
	});
	var day_unit_pe;
	var day_avilabil_capcity_sec=parseInt($("#day_avilabil_capcity_sec").val());
	total_unit_capacity_division=parseInt(total_unit_capacity, 10)*100;
	day_unit_per=parseInt(total_unit_capacity_division, 10) / parseInt(day_avilabil_capcity_sec, 10);
	day_unit_per=Math.round(day_unit_per);
	$("#unit_per_span_"+unit_id).html(day_unit_per+"%");
	if(parseInt(total_unit_capacity)>unit_capacity){
		//alert("Production capacity reached maximum... please change item quantity!!!");
		$("#item_unit_qty_"+unit_id+'_'+current_row).val(0);
		swal({
		text: 'Production capacity reached maximum... please change item quantity!!!',
		button: {
		text: "OK",
		value: true,
		visible: true,
		className: "btn btn-primary"
		}
		});
		return false;
	}
	// 
	var incc=0;
	var all_item_unit_qty;
	
	var grad_total_unit_capacity=0;
	$(".all_items_class").each(function(){	
		var cid=$(this).attr("cid");
		all_item_unit_qty= parseInt( $(this).val() );
		//alert(cid);
		if(intRegex.test(all_item_unit_qty) ) {
			//alert(incc);
			 
			var all_item_order_sec=parseInt($("#item_order_sec"+cid).val());
			grad_total_unit_capacity+=all_item_order_sec*all_item_unit_qty;
		}
		incc++;
	});
	//alert(grad_total_unit_capacity);
	grad_total_unit_capacity1=parseInt(grad_total_unit_capacity, 10)*100;
	var all_capacity=parseInt(grad_total_unit_capacity1, 10) / parseInt(day_avilabil_capcity_sec, 10);
	all_capacity=Math.round(all_capacity);
	$("#all_capacity_span").html(all_capacity+"%");	
	
	if(parseInt(grad_total_unit_capacity)>day_avilabil_capcity_sec){
		$("#item_unit_qty_"+unit_id+'_'+current_row).val(0);
		swal({
		text: 'Production capacity reached maximum... please change item quantity!!!',
		button: {
		text: "OK",
		value: true,
		visible: true,
		className: "btn btn-primary"
		}
		});
		return false;
	}
	
	var total_order_sec=<?php echo $total_order_sec;?>;
	
	
	var blnce=parseInt(total_order_sec)-parseInt(grad_total_unit_capacity);
	blnce1=parseInt(blnce, 10)*100;
	var blnce_per=parseInt(blnce1, 10) / parseInt(day_avilabil_capcity_sec, 10);
	blnce_per=Math.round(blnce_per);
	//alert(blnce_per);
	$("#blnce_capacity_span").html(blnce_per+"%");	
	
}

$(document).ready(function() {
$("#scheduleForm").validate({
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
submitHandler: function() {//
//$("#submitDataa").attr("disabled", "disabled");
//$('#submitDataa').html("Please Wait ...");
////$('#response').html('<font class="text-yellow">Checking.Please wait..</font>');
//$('#dateContent').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Saving...</p>');
//$.post('', $("#calenderData").serialize(), function(data) {
//		$('#dateContent').html("");																							
//	var dataRs = jQuery.parseJSON(data);
//	$("#submitDataa").delay("slow").fadeIn();
//	$('#submitDataa').html("Save");
//	$('#submitDataa').removeAttr("disabled");
//	$('#dateContent').html(dataRs.responseMsg);
//	//$( '#calenderData' ).each(function(){this.reset();});
//	
//});	
}
});
});

</script>