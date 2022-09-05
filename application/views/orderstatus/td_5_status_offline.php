<td>
<?php
$srow5=$this->common_model->get_schedule_numbers_wo(12,$row['order_id']);
$thisSchedule5=1;
$scheduleArray5=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],12);
if($scheduleArray5){ ?>
<ol>
<?php 
foreach($scheduleArray5 as $sArray5){ 
$array5 = json_decode($sArray5['sh_order_json'],true);
//echo count($array1)."__<br/>";
	foreach($array5 as $key5 => $value5){
    if($value5['item_unit_qty_input']!=0  && $value5['orderno']==$row['orderform_number']){
		if(isset($srow5)){
			$TOTAL_SCHEDULES_ARRAY5=explode(',',$srow5['TOTAL_SCHEDULES']);
			$thisSchedule5 = array_search($sArray5['schedule_department_id'], $TOTAL_SCHEDULES_ARRAY5);
			$thisSchedule5+=1;
		}
		$rejectionRow5=$this->common_model->get_any_rejection_now($sArray5['schedule_id'],$value5['summary_id'],12);
		if(!$rejectionRow5){
			$lastRow5=$this->common_model->get_last_department_updation_row($sArray5['schedule_id'],$value5['summary_id']);
			//echo $lastRow5['schedule_department_id']."==".$sArray5['schedule_department_id'];
			?>
			<?php if($lastRow5['rs_design_id']!="" ){ ?>
				<?php if($lastRow5['schedule_department_id']==$sArray5['schedule_department_id']){  ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
 					<?php if($lastRow5['verify_status']==1){?>
    				<li><strong class="text-warning"><i class="fa fa-arrow-circle-right mr-1"></i><?php echo ucwords($value5['product_type']);?> [<?php echo ucwords($value5['item_unit_qty_input']);?>][S<?php echo $thisSchedule5;?>] <br><?php echo $value5['online_ref_number'];?></strong></li>
					<?php }else if($lastRow5['verify_status']==-1){?>
    				<li><strong class="text-warning"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value5['product_type']);?> [<?php echo ucwords($value5['item_unit_qty_input']);?>][S<?php echo $thisSchedule5;?>] <br><?php echo $value5['online_ref_number'];?></strong></li>
					<?php }else{ ?>
					<li><strong class="text-warning"><i class="fa fa-arrow-circle-right mr-1"></i><?php echo ucwords($value5['product_type']);?> [<?php echo ucwords($value5['item_unit_qty_input']);?>][S<?php echo $thisSchedule5;?>] <br><?php echo $value5['online_ref_number'];?></strong></li>
					<?php } ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
				<?php }else if($lastRow5['schedule_department_id']!= $sArray5['schedule_department_id']){ ?>
					<?php if($lastRow5['to_department']=="bundling"){ ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
 					<?php if($lastRow5['verify_status']==1){?>
    				<li><strong class="text-warning"><i class="fa fa-arrow-circle-right mr-1"></i><?php echo ucwords($value5['product_type']);?> [<?php echo ucwords($value5['item_unit_qty_input']);?>][S<?php echo $thisSchedule5;?>] <br><?php echo $value5['online_ref_number'];?></strong></li>
					<?php }else if($lastRow5['verify_status']==-1){?>
    				<li><strong class="text-warning"><i class="fa fa-arrow-circle-left mr-1"></i><?php echo ucwords($value5['product_type']);?> [<?php echo ucwords($value5['item_unit_qty_input']);?>][S<?php echo $thisSchedule5;?>] <br><?php echo $value5['online_ref_number'];?></strong></li>
					<?php }else{ ?>
					<li><strong class="text-success"><i class="fa fa-minus mr-1"></i><?php echo ucwords($value5['product_type']);?> [<?php echo ucwords($value5['item_unit_qty_input']);?>][S<?php echo $thisSchedule5;?>]<br><?php echo $value5['online_ref_number'];?></strong></li>
					<?php } ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->

					<?php }else{ ?>
					<li><?php echo ucwords($value5['product_type']);?> [<?php echo ucwords($value5['item_unit_qty_input']);?>][S<?php echo $thisSchedule5;?>]<br><?php echo $value5['online_ref_number'];?></li>
					<?php } ?>

				<?php }else{ ?>
					<li><?php echo ucwords($value5['product_type']);?> [<?php echo ucwords($value5['item_unit_qty_input']);?>][S<?php echo $thisSchedule5;?>] <br><?php echo $value5['online_ref_number'];?></li>
				<?php } ?>

			<?php }else{ ?>
			<li><?php echo ucwords($value5['product_type']);?> [<?php echo ucwords($value5['item_unit_qty_input']);?>][S<?php echo $thisSchedule5;?>] <br><?php echo $value5['online_ref_number'];?></li>
			<?php } ?>
		<?php }else{ ?>
			<li><strong class="text-danger" title="Rejected By : <?php echo ucwords($rejectionRow5['rejected_from_departments']);?>"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value5['product_type']);?> [ <?php echo ucwords($rejectionRow5['rejected_qty']);?>/<?php echo ucwords($value5['item_unit_qty_input']);?> ][S<?php echo $thisSchedule5;?>] <br><?php echo $value5['online_ref_number'];?></strong></li>
		<?php } ?>
	<?php }} ?>
<?php } ?>
</ol>
<?php } ?>
</td>