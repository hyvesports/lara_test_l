<?php //print_r($calender_date_info); ?>
<div class="card-body">
<div class="d-flex align-items-center">

<div class="mb-1">
<h4>Day Overview</h4>
<div class="badge badge-info"><i class="fa fa-calendar"></i> <?php echo date('d-m-Y', strtotime($calender_date_info['unit_calendar_date']));?></div>
<?php if($calender_date_info){ 
	$system_working_capacity_sec=$calender_date_info['system_working_capacity_sec'];
	$unit_working_capacity_in_sec=$calender_date_info['unit_working_capacity_in_sec'];
?>
	<?php if($calender_date_info['unit_is_working']=='no'){?>
	<div class="badge badge-danger"> <i class="fa fa-ban"></i> Non Working Day</div>
    <?php }else{ ?>
    <div class="badge badge-success"><i class="fa fa-check"></i> Working Day</div>
    <?php } ?>
<?php }else{ ?>
<div class="badge badge-danger">Calender Not Updated!!!</div>
<?php } ?>
</div>
</div>
	
    <div class="border-top pt-3">
    <div class="row">
    <?php 
	$all_total=0;
	if($day_overview){?>
    	<?php
		$design_orders_count=0;
		
		foreach($day_overview as $sArray1){ 
			//$array1 = json_decode($sArray1['sh_order_json'],true);
			$array1 = json_decode($sArray1['scheduled_order_info'],true);
			
			if($array1) {
				foreach($array1 as $key1 => $value1){
					if($value1['item_unit_qty_input']!=0){
						$all_total+=$value1['item_order_sec']*$value1['item_unit_qty_input'];
					}
				}
			}
		}
	}else{
		$all_total=$unit_working_capacity_in_sec;
	}
		//echo $all_total;
		
		if($calender_date_info['unit_calendar_id']!=""){
			//echo 'ccc';
			
			
			$total_allocated_capacity=$unit_working_capacity_in_sec/$system_working_capacity_sec;
			$total_allocated_capacity_percentage=round( number_format( $total_allocated_capacity*100, 2 ));
			
			
			$work_capacity=$all_total/$system_working_capacity_sec;
			$work_capacity_percentage=round( number_format( $work_capacity*100, 2 ));
			
		?>
        <div class="col-md-6 text-center">
        <h6><?php echo $total_allocated_capacity_percentage;?> %</h6>
        <p> Day Percentage</p>
        </div>
        
        <div class="col-md-6 text-center">
        <h6><?php echo $work_capacity_percentage;?> %</h6>
        <p>Order Percentage</p>
        </div>
        
        
        
        <?php } ?> 
	
    </div>
    </div>
</div>