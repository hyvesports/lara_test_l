<?php
$system_working_capacity_sec=0;
$unit_working_capacity_in_sec=0;
$production_end_date="";
$unit_id=$this->input->post('unit_id');
$schedule_id=$this->input->post('schedule_id');
$production_start_date=$this->input->post('production_start_date');
$production_start_date=date("Y-m-d", strtotime($production_start_date));
$production_start_date_strtotime= strtotime($production_start_date);
//$dayLimit=7;
$systemRow=$this->schedule_model->get_system_production_days('OFPD');
$allocation=json_decode($systemRow['allocation']);

$dayOfStitching=$systemRow['stitching_day'];
$dayOfStitchingArrayElement=$dayOfStitching-1;
//echo count($allocation);
$dayLimit=$systemRow['calculation_value'];
$datesRows=$this->schedule_model->get_productions_available_days_with_unit($production_start_date,$dayLimit,$unit_id);
//print_r($datesRows);
$datesRowsCount=count($datesRows);
$isAvailable='Available';
$uuid=$this->schedule_model->get_schedule_uuid();
if($datesRowsCount==$dayLimit) {
	$dateLastRow=$datesRowsCount-1;
	$dateLastRowStitching=$dayOfStitchingArrayElement;
	//print_r($datesRows[$dateLastRow]);
	$calendar_id=$datesRows[$dateLastRowStitching]['calendar_id'];
	//echo $calendar_id."<br/>";
	$calendar_date=$datesRows[$dateLastRowStitching]['calendar_date'];
	$production_stitching_date=$calendar_date;
	
	$production_end_date=$datesRows[$dateLastRow]['calendar_date'];
	$calendar_date_dispatch=$datesRows[$dateLastRow]['calendar_date'];
	
	
	$unit_total_work_per=$datesRows[$dateLastRowStitching]['unit_work'];
	
	$unit_working_capacity_in_sec=$datesRows[$dateLastRowStitching]['unit_working_capacity_in_sec'];
	$system_working_capacity_sec=$datesRows[$dateLastRowStitching]['system_working_capacity_sec'];
	$schedule_unit_percentage_sec=0;

	//echo $avUnitCapacity=$unit_working_capacity_in_sec-$schedule_unit_percentage_sec."<br/>";
	
	$total_allocated_capacity=$unit_working_capacity_in_sec/$system_working_capacity_sec;
	$total_allocated_capacity_percentage=round( number_format( $total_allocated_capacity*100, 2 ));
	//echo $schedule_unit_percentage_sec;
	//echo gmdate("H:i:s", $unit_working_capacity_in_sec);
	//--------------------------- new updates--------------
	$suid=$unit_id;
	$unit_calendar_date=$datesRows[$dateLastRowStitching]['unit_calendar_date'];
	$sumRow=$this->schedule_model->get_sum_of_scheduled_order($unit_calendar_date,$suid);
	//echo $sumRow['SOS'];
	$scheduled_row_sec=$sumRow['SOS'];
	//-----------------------------------------------------
	
	$schedule_unit_percentage=$datesRows[$dateLastRowStitching]['schedule_unit_percentage'];
	$schedule_unit_percentage_sec=$datesRows[$dateLastRowStitching]['schedule_unit_percentage_sec'];
	//echo $schedule_unit_percentage_sec=$scheduled_row_sec;
	$schedule_unit_percentage_sec=$schedule_unit_percentage_sec;
	//echo '<br/>';
	if($schedule_unit_percentage_sec==""){
		$schedule_unit_percentage_sec=0;
	}

	$expected_dispatch_date=strtotime($calendar_date_dispatch);
	$blnce_scnd=$unit_working_capacity_in_sec-$schedule_unit_percentage_sec;
	//echo $blnce_scnd."::".$system_working_capacity_sec."<br/>";
	$AvailableCapacity1=$blnce_scnd/$system_working_capacity_sec;
	//echo '<br/>';
	$AvailableCapacity=round( number_format( $AvailableCapacity1*100, 2 ));
	if($AvailableCapacity==0){
		$isAvailable='ScheduleCompleted';
	}else{
		$x=0;
		$qty=0;
		$total_x=0;
		$q=0;
		$line_qty=0;
		if($summary){
			foreach($summary as $umm){
				$sumArrayQty=$this->schedule_model->get_item_total_qty($umm['order_summary_id']);
				if($sumArrayQty==""){
					$saved_qty=0;
				}else{
					$saved_qty=$sumArrayQty['TQ'];
					//$saved_qty=$umm['wo_qty'];
				}
				$itemm_qty=$umm['wo_qty']-$saved_qty;
				//$itemm_qty=$umm['wo_qty'];
				if($umm['wo_product_making_time']!=""){ $x+=$umm['wo_product_making_time']; }		//echo $umm['wo_product_making_time']."<br/>";
				if($umm['wo_collar_making_min']!=""){ $x+=$umm['wo_collar_making_min']; }			//echo $umm['wo_collar_making_min']."<br/>"; 		
				if($umm['wo_sleeve_making_time']!=""){ $x+=$umm['wo_sleeve_making_time']; }			//echo $umm['wo_sleeve_making_time']."<br/>";
				if($umm['wo_fabric_making_min']!=""){ $x+=$umm['wo_fabric_making_min']; }			//echo $umm['wo_fabric_making_min']."<br/>";
				if($umm['wo_item_addons_mk_time']!=""){ $x+=$umm['wo_item_addons_mk_time']; }		//echo $umm['wo_item_addons_mk_time']."<br/>";
				//echo $x."<br/>";
				$y=$x*60;
				//echo $y."<br/>";
				$z=$y*$itemm_qty;
				//echo $z."<br/>";
				$line_qty+=$itemm_qty;
				$total_x+=$z;
				$x=0;
			}
			
		}
		//echo $total_x.":".$system_working_capacity_sec."<br/>";
		$percent = $total_x/$system_working_capacity_sec;
		$order_percent=round( number_format( $percent * 100, 2 )) . '%'; 
		$summary_info=$this->schedule_model->get_order_summary_in_detail_info($row['order_id']);
		$production_units=$this->schedule_model->get_all_production_active_units($unit_id);
	}
	//echo $percent;
	if($order_percent<0){
		//$isAvailable='OrderCompleted';
		$isAvailable='InvalidOrderCapacity';
	}
	
}else{
	$isAvailable='ScheduleCalender';
}

//echo $isAvailable;
?>
<form name="scheduleForm" id="scheduleForm">
<input type="hidden" name="order_id" id="order_id" value="<?php echo $row['order_id'];?>" />
<input type="hidden" name="schedule_date" id="schedule_date" value="<?php echo $production_start_date;?>" />
<input type="hidden" name="schedule_code" id="schedule_code" value="SH<?php echo $row['orderform_number'];?>" />
<input type="hidden" name="schedule_unit_id" id="schedule_unit_id" value="<?php echo $unit_id;?>" />
<input type="hidden" name="schedule_uuid" id="schedule_uuid" value="<?php echo $uuid['uid'];?>" />
<input type="hidden" name="parent_schedule_id" id="parent_schedule_id" value="0" />
<input type="hidden" name="system_working_capacity_sec" id="system_working_capacity_sec" value="<?php echo $system_working_capacity_sec;?>" />
<input type="hidden" name="unit_working_capacity_in_sec" id="unit_working_capacity_in_sec" value="<?php echo $unit_working_capacity_in_sec;?>" />
<input type="hidden" name="production_end_date" id="production_end_date" value="<?php echo $production_end_date;?>" />
<input type="hidden" name="production_stitching_date" id="production_stitching_date" value="<?php echo $production_stitching_date;?>" />
<div class="row">
<div class="col-12 mt-4">


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
    <?php }else if($isAvailable=="OrderCompleted"){ ?>
    <div class="card card-inverse-warning mb-5">
    <div class="row">
        <div class="card-body col-md-12" style="padding: 30px 30px;">
        <div class=" d-flex flex-row align-items-top">
        <i class="fa fa-calendar text-facebook icon-md"></i>
        <div class="ml-3">
        <h6 class="text-facebook">Order completely scheduled</h6>
        
        </div>
        </div>
        </div>
    </div>
    </div>
    <?php }else if($isAvailable=="InvalidOrderCapacity"){ ?>
    <div class="card card-inverse-warning mb-5">
    <div class="row">
        <div class="card-body col-md-12" style="padding: 30px 30px;">
        <div class=" d-flex flex-row align-items-top">
        <i class="fa fa-calendar text-facebook icon-md"></i>
        <div class="ml-3">
        <h6 class="text-facebook">Invalid order capacity</h6>
        
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
		echo $AvailableCapacity;
		?>%</h6>
        <p class="mt-2 text-muted card-text">Available Capacity  in <?php echo date('d/m/Y', strtotime($production_stitching_date));?> </p>
        </div>
        </div>
        </div>
    
        <div class="card-body col-md-3" style="padding: 30px 30px;">
        <div class=" d-flex flex-row align-items-top">
        <i class="fa fa-gavel text-warning icon-md"></i>
        <div class="ml-3">
        <h6 class="text-warning"><?php echo $total_allocated_capacity_percentage;?>%</h6>
        <p class="mt-2 text-muted card-text">Total Capacity in <?php echo date('d/m/Y',strtotime( $production_stitching_date));?></p>
        </div>
        </div>
        </div>
        <?php if($summary_info){ ?>
        <div class="card-body">
        <p class="mb-4">#<?php echo $row['orderform_number'];?> Order Summary</p>
        <?php foreach($summary_info as $SM){ ?>
        <div class="badge badge-warning mr-3"><?php echo ucwords($SM['wo_product_type_name']);?> [ <?php echo $SM['QTY'];?> ]</div>
        <?php } ?>
        <br />
        
        <?php $pastdate=date('Y-m-d', strtotime($production_start_date. ' - 1 month'));?>
        <a href="javascript:void(0);"  data-toggle="modal" data-target="#summaryModel"  data-ps="<?php echo strtotime($production_start_date);?>" data-pe="<?php echo strtotime($pastdate);?>" style="display:none;">
        <div class="badge badge-danger mr-3 mt-3">
        Past 30 Days summary 
        </div>
        </a>
        
        <?php $nextdate=date('Y-m-d', strtotime($production_start_date. ' + 5 days'));?>
        <a href="javascript:void(0);" style="display:none;" data-toggle="modal" data-target="#summaryModel"  data-ps="<?php echo strtotime($production_start_date);?>" data-pe="<?php echo strtotime($nextdate);?>">
        <div class="badge badge-success mr-3 mt-3">5 Days summary</div>
        </a>
        
        <?php $futuredate=date('Y-m-d', strtotime($production_start_date. ' + 1 month'));?>
        <a href="javascript:void(0);" style="display:none;"  data-toggle="modal" data-target="#summaryModel"  data-ps="<?php echo strtotime($production_start_date);?>" data-pe="<?php echo strtotime($futuredate);?>">
        <div class="badge badge-info mr-3 mt-3">Next 30 Days summary </div>
        </a>
        </div>

        <?php }?>
    </div>
    </div>
 </div> 

 	<div class="col-md-6">
    <h5 class="mb-3" >Order Details</h5>
    <label class="badge  w-100" style="background-color:<?php echo ucwords($row['priority_color_code']);?>">Priority : <strong><?php echo ucwords($row['priority_name']);?></strong></label>
    <table class="table">
    <thead>
    <tr>
   
    <th><label class="badge badge-warning mt-1">Product<?php //echo $calendar_date;?></label></th>
    <th> <label class="badge badge-warning mt-1">Quantity <?php echo $line_qty;?></label></th>
    <!--<th>Making Time</th>
    <th>Total Time</th>-->
	<?php if($production_units) { $k=0; $production_unit_ids;?>
    <?php foreach($production_units as $PU) { if($k==0){ 
	$production_unit_ids=$PU['production_unit_id']; }else{ $production_unit_ids.=",".$PU['production_unit_id'];} $k++;
	//echo $calendar_id;
	$cuRow=$this->calendar_model->get_production_unit_calendar($PU['production_unit_id'],$calendar_id);
	//print_r($cuRow);
	?>
    <th width="25%"  class="text-left">
    <br /><label class="badge badge-warning mt-1"><?php echo $PU['production_unit_name'];?> : <?php echo $AvailableCapacity;?>%</label>
    <br/><?php $avilabile_unit_day_capcity_sec=$cuRow['unit_working_capacity_in_sec']-$cuRow['schedule_unit_percentage_sec'];?>
        <input type="hidden"
        name="day_avilabile_unit_capaciy_sec_<?php echo $PU['production_unit_id'];?>"
        id="day_avilabile_unit_capaciy_sec_<?php echo $PU['production_unit_id'];?>"
        value="<?php echo $avilabile_unit_day_capcity_sec;?>" />
    </th>
    <?php } ?>
    <?php } ?>
    
    
    
 
    </tr>
    <?php
	$avilabile_day_capcity_sec=$unit_working_capacity_in_sec-$schedule_unit_percentage_sec;
	?>
    	<input type="hidden"
        name="day_avilabil_capcity_sec"
        id="day_avilabil_capcity_sec"
        value="<?php echo $avilabile_day_capcity_sec;?>" />
    </thead>
    <tbody>
    
    <?php if($summary){ ?>
    <?php 
	$m_min=0;
	$i=0;
	$j=0;
	$total_order_sec=0;
	$countRowspan=count($summary);
$postion=0;
	foreach($summary as $item){
$postion++;
		if($item['wo_product_making_time']!=""){ $m_min=$m_min+$item['wo_product_making_time']; }
		if($item['wo_collar_making_min']!=""){ $m_min=$m_min+$item['wo_collar_making_min']; }
		if($item['wo_sleeve_making_time']!=""){ $m_min=$m_min+$item['wo_sleeve_making_time']; }
		if($item['wo_fabric_making_min']!=""){ $m_min=$m_min+$item['wo_fabric_making_min']; }
		if($item['wo_item_addons_mk_time']!=""){ $m_min=$m_min+$item['wo_item_addons_mk_time']; }
		
		$sumArrayQty=$this->schedule_model->get_item_total_qty($item['order_summary_id']);
		if($sumArrayQty==""){
			$saved_qty=0;
		}else{
			$saved_qty=$sumArrayQty['TQ'];
		}
		$my_line_qty=$item['wo_qty']-$saved_qty;
		
		?>
    <tr>
    <td>
    <h4 class="text-primary font-weight-normal"><?php echo ucwords($item['wo_product_type_name']);?></h4>
    <p class="text-muted mb-1"><?php echo ucwords($item['wo_fabric_type_name']);?>,<?php echo ucwords($item['wo_sleeve_type_name']);?>,<?php echo ucwords($item['wo_collar_type_name']);?></p>
    <?php //echo ucwords($m_min);?> 
    <?php 
	$sec=$m_min*60;
	//echo $sec;
	$t_sec=$sec*$my_line_qty;
	$total_order_sec=$total_order_sec+$t_sec;
	
	$t_per=$t_sec/$unit_working_capacity_in_sec;
	$percent=round( number_format( $t_per * 100, 2 ));
	?>
    <input type="hidden" name="schedule[<?php echo $j;?>][summary_id]" id="summary_id<?php echo $j;?>" value="<?php echo $item['order_summary_id'];?>" />
    <input type="hidden" name="schedule[<?php echo $j;?>][product_type]" id="product_type<?php echo $j;?>" value="<?php echo $item['wo_product_type_name'];?>" />
    <input type="hidden" name="schedule[<?php echo $j;?>][collar_type]" id="collar_type<?php echo $j;?>" value="<?php echo $item['wo_collar_type_name'];?>" />
    <input type="hidden" name="schedule[<?php echo $j;?>][sleeve_type]" id="sleeve_type<?php echo $j;?>" value="<?php echo $item['wo_sleeve_type_name'];?>" />
    <input type="hidden" name="schedule[<?php echo $j;?>][fabric_type]" id="fabric_type<?php echo $j;?>" value="<?php echo $item['wo_fabric_type_name'];?>" />
    <input type="hidden" name="schedule[<?php echo $j;?>][addon_name]" id="addon_name<?php echo $j;?>" value="<?php echo $item['wo_item_addons_names'];?>" />
    <input type="hidden" name="schedule[<?php echo $j;?>][img_back]" id="img_back<?php echo $j;?>" value="<?php echo $item['wo_img_back'];?>" />
    <input type="hidden" name="schedule[<?php echo $j;?>][img_front]" id="img_front<?php echo $j;?>" value="<?php echo $item['wo_img_front'];?>" />
    <input type="hidden" name="schedule[<?php echo $j;?>][remark]" id="remark<?php echo $j;?>" value="<?php echo $item['wo_remark'];?>" />
    <input type="hidden" name="schedule[<?php echo $j;?>][orderno]" id="orderno<?php echo $j;?>" value="<?php echo $row['orderform_number'];?>" />
     <input type="hidden" name="schedule[<?php echo $j;?>][priority_name]" id="priority_name<?php echo $j;?>" value="<?php echo $row['priority_name'];?>" />
    <input type="hidden" name="schedule[<?php echo $j;?>][priority_color_code]" id="priority_color_code<?php echo $j;?>" value="<?php echo $row['priority_color_code'];?>" />
    
    <!--Order Sec--><input type="hidden" name="schedule[<?php echo $j;?>][item_order_sec]" id="item_order_sec<?php echo $j;?>" value="<?php echo $sec;?>" />
    <!-- Order Total Sec-->
    <input type="hidden" name="schedule[<?php echo $j;?>][item_order_total_sec]" id="item_order_total_sec<?php echo $j;?>" value="<?php echo $t_sec;?>" />
  	<!--Order %-->
  	<input type="hidden" name="schedule[<?php echo $j;?>][item_order_capacity]" id="item_order_capacity<?php echo $j;?>" value="<?php echo $percent;?>" />
   <!--Order Qty:-->
   <input type="hidden" name="schedule[<?php echo $j;?>][item_order_qty]" id="item_order_qty<?php echo $j;?>" value="<?php echo $my_line_qty;?>" />
	<input type="hidden" name="schedule[<?php echo $j;?>][item_position]" id="item_position<?php echo $j;?>" value="<?php echo $postion;?>" />
	<input type="hidden" name="schedule[<?php echo $j;?>][item_rejected_qty]" id="item_rejected_qty<?php echo $j;?>" value="0" />
	<input type="hidden" name="schedule[<?php echo $j;?>][item_re_schedule_id]" id="item_re_schedule_id<?php echo $j;?>" value="0" />
    </td>
    <td>
    <label class="badge badge-primary"><?php echo ucwords($my_line_qty);?> <?php //echo $percent;?></label>
    </td>

    <?php if($production_units) {?>
    <?php foreach($production_units as $PU) {
		$cuRow=$this->calendar_model->get_production_unit_calendar($PU['production_unit_id'],$calendar_id);
	?>
    <td>
    <input 
    type="text"  
    class="form-control current_row_<?php echo $j;?> unit_class_<?php echo $PU['production_unit_id'];?> all_items_class text-center required digits" 
    placeholder="Qty" min='0' max="<?php echo $my_line_qty;?>" 
    name="schedule[<?php echo $j;?>][item_unit_qty_input]"
    id="item_unit_qty_<?php echo $PU['production_unit_id'];?>_<?php echo $j;?>" 
    cid='<?php echo $j;?>'
    onkeyup="return calculateProduction(<?php echo $j;?>,<?php echo $PU['production_unit_id'];?>);"
    
    oqty='<?php echo $item['wo_qty'];?>' 
    <?php if($my_line_qty<=0){ ?> readonly="readonly" value="0"  <?php }else{?> value="" <?php } ?> >
    
    </td>
    <?php $i++; } } ?>
    
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
    <th width="18%"  class="text-right">
	<?php echo $PU['production_unit_name'];?> :
    <span id='unit_per_span_<?php echo $PU['production_unit_id'];?>' class="badge badge-success mt-1">0%</span><br />
    <!--Total :-->  <span id='all_capacity_span' class="badge badge-warning mt-1"  style="display:none">0%</span><br/>
   <!-- Balance :-->  <span id='blnce_capacity_span' class="badge badge-info mt-1" style="display:none">0%</span>
    </th>
    <?php } ?>
    <?php } ?>
        </tr>
    </tfoot>
    </table>
    </div>  
    
    <div class="col-md-6">
    <h5 class="mb-3" >Schedule Department & Date</h5>
    <div class="stage-wrapper pl-4">
    <?php if($allocation){ $inc=0; //echo count($allocation); ?>
    <?php foreach($allocation as $day => $department){
		
		$did=explode(',',$department);
		//print_r($did);
		$department1=$this->schedule_model->get_production_department_names($department);
		
		//echo $department;
		//$departmentRows=$this->schedule_model->get_production_department_rows($department);
		?>
    	<input type="hidden" name="departments[<?php echo $inc;?>][department_schedule_date]" id="department_schedule_date<?php echo $inc;?>" value="<?php echo date('Y-m-d',strtotime($datesRows[$inc]['calendar_date']));?>" />
        <input type="hidden" name="departments[<?php echo $inc;?>][department_ids]" id="department_ids<?php echo $inc;?>" value="<?php echo $department;?>" />
        
        
        <div class="stages border-left pl-5 pb-4">
        <div class="btn btn-icons btn-rounded stage-badge btn-inverse-success"><?php echo $day;?></div>
        <div class="d-flex align-items-center mb-2 justify-content-between">
        <h6 class="mb-0"><?php echo $department1['DNAME'];?></h6>
        <small class="text-muted"><label class="badge badge-success"><?php echo date('M d, Y',strtotime($datesRows[$inc]['calendar_date']));?></label></small>
        </div>
        </div>

    <?php $inc++; } ?>
    <?php } ?>
  
    
    <div class="stages pl-5 pb-4">
    <div class="btn btn-icons btn-rounded stage-badge btn-inverse-primary">
    <i class="icon-checkbox-marked-circle-outline"></i>
    </div>
    <div class="d-flex align-items-center mb-2 justify-content-between">
    <h6 class="mb-0">Schedule Completed</h6>
    </div>
    </div>
    <span id="formResp"></span>
    <button type="submit" style="margin-top:30px; width:100%" class="btn btn-success text-center submitSheduleData" id="submitSheduleData" name="submitSheduleData"  value="submitSheduleData" disabled="disabled"><i class="fa fa-save"></i> Save Schedule Details</button>
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="order_total_qty"  id="order_total_qty" value="">
    <input type="hidden" name="order_total_submitted_qty"  id="order_total_submitted_qty" value="">
    <input type="hidden" name="order_balance_qty"  id="order_balance_qty" value="">

    
    </div>
    </div>

<?php } ?>
</div>
</div>
</form>
<?php include("offline.script.php");?>
<div class="modal fade " id="summaryModel" tabindex="-1">
<div class="modal-dialog modal-lg 0" role="document">
<div class="modal-content"></div>
</div>
</div>