<td>
<?php
$srow3=$this->common_model->get_schedule_numbers_wo(5,$row['order_id']);
$thisSchedule3=1;
$scheduleArray3=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],5);
if($scheduleArray3){ ?>
<ol>
<?php 
foreach($scheduleArray3 as $sArray3){ 
$array3 = json_decode($sArray3['sh_order_json'],true);
//echo count($array1)."__<br/>";
	foreach($array3 as $key3 => $value3){
    if($value3['item_unit_qty_input']!=0  && $value3['orderno']==$row['orderform_number']){
		if(isset($srow3)){
			$TOTAL_SCHEDULES_ARRAY3=explode(',',$srow3['TOTAL_SCHEDULES']);
			$thisSchedule3 = array_search($sArray3['schedule_department_id'], $TOTAL_SCHEDULES_ARRAY3);
			$thisSchedule3+=1;
		}
		$rejectionRow3=$this->common_model->get_any_rejection_now($sArray3['schedule_id'],$value3['summary_id'],5);
			if(!$rejectionRow3){
				$lastRow3=$this->common_model->get_last_department_updation_row($sArray3['schedule_id'],$value3['summary_id']);
				?>
				<?php if($lastRow3['rs_design_id']!="" ){ ?>
				<?php if($lastRow3['schedule_department_id']==$sArray3['schedule_department_id']){  ?>
					<?php if($lastRow3['from_department']=="printing"){ ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
 					<?php if($lastRow3['verify_status']==1){?>
    				<li><strong class="text-warning"><i class="fa fa-arrow-circle-right mr-1"></i><?php echo ucwords($value3['product_type']);?> [<?php echo ucwords($value3['item_unit_qty_input']);?>][S<?php echo $thisSchedule3;?>]</strong></li>
					<?php }else if($lastRow3['verify_status']==-1){?>
    				<li><strong class="text-warning"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value3['product_type']);?> [<?php echo ucwords($value3['item_unit_qty_input']);?>][S<?php echo $thisSchedule3;?>]</strong></li>
					<?php }else{ ?>
					<li><strong class="text-success"><i class="fa fa-minus mr-1"></i><?php echo ucwords($value3['product_type']);?> [<?php echo ucwords($value3['item_unit_qty_input']);?>][S<?php echo $thisSchedule3;?>]</strong></li>
					<?php } ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
					<?php } else{?>
					<li><?php echo ucwords($value3['product_type']);?> [<?php echo ucwords($value3['item_unit_qty_input']);?>][S<?php echo $thisSchedule3;?>]</li>
					<?php } ?>

				<?php }else if($lastRow3['schedule_department_id']!= $sArray3['schedule_department_id']){ ?>
					<?php if($lastRow3['to_department']=="design_qc"){ ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
 					<?php if($lastRow3['verify_status']==1){?>
    				<li><strong class="text-success"><i class="fa fa-minus mr-1"></i><?php echo ucwords($value3['product_type']);?> [<?php echo ucwords($value3['item_unit_qty_input']);?>][S<?php echo $thisSchedule3;?>]</strong></li>
					<?php }else if($lastRow3['verify_status']==-1){?>
    				<li><strong class="text-warning"><i class="fa fa-arrow-circle-left mr-1"></i><?php echo ucwords($value3['product_type']);?> [<?php echo ucwords($value3['item_unit_qty_input']);?>][S<?php echo $thisSchedule3;?>]</strong></li>
					<?php }else{ ?>
					<li><?php echo ucwords($value3['product_type']);?> [<?php echo ucwords($value3['item_unit_qty_input']);?>][S<?php echo $thisSchedule3;?>]</li>
					<?php } ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->

					<?php }else{ ?>
					<li><?php echo ucwords($value3['product_type']);?> [<?php echo ucwords($value3['item_unit_qty_input']);?>][S<?php echo $thisSchedule3;?>]</li>
					<?php } ?>

				<?php }else{ ?>
					<li><?php echo ucwords($value3['product_type']);?> [<?php echo ucwords($value3['item_unit_qty_input']);?>][S<?php echo $thisSchedule3;?>]</li>
				<?php } ?>

			<?php }else{ ?>
				<li><?php echo ucwords($value3['product_type']);?> [<?php echo ucwords($value3['item_unit_qty_input']);?>][S<?php echo $thisSchedule3;?>]</li>
				<?php } ?>
			<?php }else{ ?>
				<li><strong class="text-danger" title="Rejected By : <?php echo ucwords($rejectionRow3['rejected_from_departments']);?>"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value3['product_type']);?> [<?php echo ucwords($rejectionRow3['rejected_qty']);?>/<?php echo ucwords($value3['item_unit_qty_input']);?>][S<?php echo $thisSchedule3;?>]</strong></li>
			<?php } ?>

		<?php }} ?>
<?php } ?>
</ol>
<?php } ?>
</td>