<td>
    <?php

	$srow=$this->common_model->get_schedule_numbers_wo(4,$row['order_id']);
    $scheduleArray1=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],4);
	if($scheduleArray1){ ?>
    <ol>
    <?php 
	$tschedules=1;
	$thisSchedule=1;
	foreach($scheduleArray1 as $sArray1){ 
		$array1 = json_decode($sArray1['sh_order_json'],true);
		foreach($array1 as $key1 => $value1){
		if($value1['item_unit_qty_input']!=0 && $value1['orderno']==$row['orderform_number']){
			if(isset($srow)){
				$TOTAL_SCHEDULES_ARRAY=explode(',',$srow['TOTAL_SCHEDULES']);
				$tschedules=count($TOTAL_SCHEDULES_ARRAY);
				$thisSchedule = array_search($sArray1['schedule_department_id'], $TOTAL_SCHEDULES_ARRAY);
				$thisSchedule+=1;
			}
			$rejectionRow1=$this->common_model->get_any_rejection_now($sArray1['schedule_id'],$value1['summary_id'],4);
			if(!$rejectionRow1){ 
				$lastRow=$this->common_model->get_last_department_updation_row($sArray1['schedule_id'],$value1['summary_id']);
				if($lastRow['rs_design_id']!="" && $lastRow['schedule_department_id']== $sArray1['schedule_department_id']){ ?>

						<?php if($lastRow['from_department']=="design"){?>
						<?php if($lastRow['verify_status']==1){?>
						<li><?php echo ucwords($value1['product_type']);?> [ <?php echo ucwords($value1['item_unit_qty_input']);?> ][S<?php echo $thisSchedule;?>]</li>
						<?php }else if($lastRow['verify_status']==-1){?>
						<li><strong class="text-danger"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value1['product_type']);?> [ <?php echo ucwords($value1['item_unit_qty_input']);?> ][S<?php echo $thisSchedule;?>]</strong></li>
						<?php }else{ ?>
						<li><strong class="text-warning"><i class="fa fa-arrow-circle-right mr-1"></i><?php echo ucwords($value1['product_type']);?> [ <?php echo ucwords($value1['item_unit_qty_input']);?> ][S<?php echo $thisSchedule;?>]</strong></li>
						<?php } ?>
						<?php } ?>

				<?php }else{ ?>
				<li ><font ><?php echo ucwords($value1['product_type']);?> [ <?php echo ucwords($value1['item_unit_qty_input']);?> ][S<?php echo $thisSchedule;?>]</font></li>
				<?php } ?>

			<?php }else{ ?>
				<li><strong class="text-danger" title="Rejected By : <?php echo ucwords($rejectionRow1['rejected_from_departments']);?>"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value1['product_type']);?> [ <?php echo ucwords($rejectionRow1['rejected_qty']);?>/<?php echo ucwords($value1['item_unit_qty_input']);?> ][S<?php echo $thisSchedule;?>]</strong></li>
			<?php } ?>


    	<?php }} ?>
    <?php } ?>
    </ol>
    <?php } ?>
    </td>