<td>
<?php
$srow6=$this->common_model->get_schedule_numbers_wo(8,$row['order_id']);
$thisSchedule6=1;
$scheduleArray6=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],8);
if($scheduleArray6){ ?>
<ol>
<?php 
foreach($scheduleArray6 as $sArray6){ 
$array6 = json_decode($sArray6['sh_order_json'],true);
//echo count($array1)."__<br/>";
	foreach($array6 as $key6 => $value6){
    if($value6['item_unit_qty_input']!=0  && $value6['orderno']==$row['orderform_number']){
		if(isset($srow6)){
			$TOTAL_SCHEDULES_ARRAY6=explode(',',$srow6['TOTAL_SCHEDULES']);
			$thisSchedule6 = array_search($sArray6['schedule_department_id'], $TOTAL_SCHEDULES_ARRAY6);
			$thisSchedule6+=1;
		}
		$rejectionRow6=$this->common_model->get_any_rejection_now($sArray6['schedule_id'],fusing1,8);
		if(!$rejectionRow6){
			$lastRow6=$this->common_model->get_last_department_updation_row($sArray6['schedule_id'],$value6['summary_id']);
			//echo $lastRow6['schedule_department_id']."==".$sArray6['schedule_department_id'];
			//echo $value6['summary_id'];
			?>
			<?php if($lastRow6['rs_design_id']!="" ){ ?>
				<?php if($lastRow6['schedule_department_id']==$sArray6['schedule_department_id']){  ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
 					<?php if($lastRow6['verify_status']==1){?>
    				<li><?php echo ucwords($value6['product_type']);?> [<?php echo ucwords($value6['item_unit_qty_input']);?>][S<?php echo $thisSchedule6;?>]</li>
					<?php }else if($lastRow6['verify_status']==-1){?>
    				<li><strong class="text-danger"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value6['product_type']);?> [<?php echo ucwords($value6['item_unit_qty_input']);?>][S<?php echo $thisSchedule6;?>]</strong></li>
					<?php }else{ ?>
					<li><strong class="text-warning"><i class="fa fa-arrow-circle-right mr-1"></i><?php echo ucwords($value6['product_type']);?> [<?php echo ucwords($value6['item_unit_qty_input']);?>][S<?php echo $thisSchedule6;?>]</strong></li>
					<?php } ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
				<?php }else if($lastRow6['schedule_department_id']!= $sArray6['schedule_department_id']){ ?>
					<?php if($lastRow6['to_department']=="bundling"){ ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
 					<?php if($lastRow6['verify_status']==1){?>
    				<li><strong class="text-success"><i class="fa fa-minus mr-1"></i><?php echo ucwords($value6['product_type']);?> [<?php echo ucwords($value6['item_unit_qty_input']);?>][S<?php echo $thisSchedule6;?>]</strong></li>
					<?php }else if($lastRow6['verify_status']==-1){?>
    				<li><strong class="text-warning"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value6['product_type']);?> [<?php echo ucwords($value6['item_unit_qty_input']);?>][S<?php echo $thisSchedule6;?>]</strong></li>
					<?php }else{ ?>
					<li><?php echo ucwords($value6['product_type']);?> [<?php echo ucwords($value6['item_unit_qty_input']);?>][S<?php echo $thisSchedule6;?>]</li>
					<?php } ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->

					<?php }else{ ?>
					<li><?php echo ucwords($value6['product_type']);?> [<?php echo ucwords($value6['item_unit_qty_input']);?>][S<?php echo $thisSchedule6;?>]</li>
					<?php } ?>

				<?php }else{ ?>
					<li><?php echo ucwords($value6['product_type']);?> [<?php echo ucwords($value6['item_unit_qty_input']);?>][S<?php echo $thisSchedule6;?>]</li>
				<?php } ?>

			<?php }else{ ?>
			<li><?php echo ucwords($value6['product_type']);?> [<?php echo ucwords($value6['item_unit_qty_input']);?>][S<?php echo $thisSchedule6;?>]</li>
			<?php } ?>
		<?php }else{ ?>
			<li><strong class="text-danger" title="Rejected By : <?php echo ucwords($rejectionRow6['rejected_from_departments']);?>"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value6['product_type']);?> [ <?php echo ucwords($rejectionRow6['rejected_qty']);?>/<?php echo ucwords($value6['item_unit_qty_input']);?> ][S<?php echo $thisSchedule6;?>]</strong></li>
		<?php } ?>
	<?php }} ?>
<?php } ?>
</ol>
<?php } ?>
</td>