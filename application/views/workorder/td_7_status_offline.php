<td>
<?php
$srow7=$this->common_model->get_schedule_numbers_wo(13,$row['order_id']);
$thisSchedule7=1;
$scheduleArray7=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],13);
if($scheduleArray7){ ?>
<ol>
<?php 
foreach($scheduleArray7 as $sArray7){ 
$array7 = json_decode($sArray7['sh_order_json'],true);
//echo count($array1)."__<br/>";
	foreach($array7 as $key7 => $value7){
    if($value7['item_unit_qty_input']!=0  && $value7['orderno']==$row['orderform_number']){
		$rejectionRow7=$this->common_model->get_any_rejection_now($sArray7['schedule_id'],$value7['summary_id'],13);
		if(!$rejectionRow7){
			if(isset($srow7)){
			$TOTAL_SCHEDULES_ARRAY7=explode(',',$srow7['TOTAL_SCHEDULES']);
			$thisSchedule7 = array_search($sArray7['schedule_department_id'], $TOTAL_SCHEDULES_ARRAY7);
			$thisSchedule7+=1;
			}
			$lastRow7=$this->common_model->get_last_department_updation_row($sArray7['schedule_id'],$value7['summary_id']);
			//echo $lastRow7['schedule_department_id']."==".$sArray7['schedule_department_id']." sta=".$lastRow7['verify_status'];
			?>
			<?php if($lastRow7['rs_design_id']!="" ){ ?>
				<?php if($lastRow7['schedule_department_id']==$sArray7['schedule_department_id']){  ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
 					<?php if($lastRow7['verify_status']==1){?>
    				<li><strong class="text-warning"><i class="fa fa-arrow-circle-right mr-1"></i><?php echo ucwords($value7['product_type']);?> [<?php echo ucwords($value7['item_unit_qty_input']);?>][S<?php echo $thisSchedule7;?>]</strong></li>
					<?php }else if($lastRow7['verify_status']==-1){?>
    				<li><strong class="text-warning"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value7['product_type']);?> [<?php echo ucwords($value7['item_unit_qty_input']);?>][S<?php echo $thisSchedule7;?>]</strong></li>
					<?php }else{ ?>
					<li><strong class="text-success"><i class="fa fa-minus mr-1"></i><?php echo ucwords($value7['product_type']);?> [<?php echo ucwords($value7['item_unit_qty_input']);?>][S<?php echo $thisSchedule7;?>]</strong></li>
					<?php } ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
				<?php }else if($lastRow7['schedule_department_id']!= $sArray7['schedule_department_id']){ ?>
					<?php if($lastRow7['to_department']=="final_qc"){ ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
 					<?php if($lastRow7['verify_status']==1){?>
    				<li><strong class="text-warning"><i class="fa fa-arrow-circle-right mr-1"></i><?php echo ucwords($value7['product_type']);?> [<?php echo ucwords($value7['item_unit_qty_input']);?>][S<?php echo $thisSchedule7;?>]</strong></li>
					<?php }else if($lastRow7['verify_status']==-1){?>
    				<li><strong class="text-warning"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value7['product_type']);?> [<?php echo ucwords($value7['item_unit_qty_input']);?>][S<?php echo $thisSchedule7;?>]</strong></li>
					<?php }else{ ?>
					<li><strong class="text-success"><i class="fa fa-minus mr-1"></i><?php echo ucwords($value7['product_type']);?> [<?php echo ucwords($value7['item_unit_qty_input']);?>][S<?php echo $thisSchedule7;?>]</strong></li>
					<?php } ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->

					<?php }else{ ?>
					<li><?php echo ucwords($value7['product_type']);?> [<?php echo ucwords($value7['item_unit_qty_input']);?>][S<?php echo $thisSchedule7;?>]</li>
					<?php } ?>

				<?php }else{ ?>
					<li><?php echo ucwords($value7['product_type']);?> [<?php echo ucwords($value7['item_unit_qty_input']);?>][S<?php echo $thisSchedule7;?>]</li>
				<?php } ?>

			<?php }else{ ?>
			<li><?php echo ucwords($value7['product_type']);?> [<?php echo ucwords($value7['item_unit_qty_input']);?>][S<?php echo $thisSchedule7;?>]</li>
			<?php } ?>
		<?php }else{ ?>
			<li><strong class="text-danger" title="Rejected By : <?php echo ucwords($rejectionRow7['rejected_from_departments']);?>"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value7['product_type']);?> [ <?php echo ucwords($rejectionRow7['rejected_qty']);?>/<?php echo ucwords($value7['item_unit_qty_input']);?> ][S<?php echo $thisSchedule7;?>]</strong></li>
		<?php } ?>
	<?php }} ?>
<?php } ?>
</ol>
<?php } ?>
</td>