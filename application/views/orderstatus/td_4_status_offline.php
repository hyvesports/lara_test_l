<td>
<?php
$srow4=$this->common_model->get_schedule_numbers_wo(6,$row['order_id']);
$thisSchedule4=1;
$scheduleArray4=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],6);
if($scheduleArray4){ ?>
<ol>
<?php 
foreach($scheduleArray4 as $sArray4){ 
$array4 = json_decode($sArray4['sh_order_json'],true);
//echo count($array1)."__<br/>";
	foreach($array4 as $key4 => $value4){
    if($value4['item_unit_qty_input']!=0  && $value4['orderno']==$row['orderform_number']){
		if(isset($srow4)){
			$TOTAL_SCHEDULES_ARRAY4=explode(',',$srow4['TOTAL_SCHEDULES']);
			$thisSchedule4 = array_search($sArray4['schedule_department_id'], $TOTAL_SCHEDULES_ARRAY4);
			$thisSchedule4+=1;
		}
		$rejectionRow4=$this->common_model->get_any_rejection_now($sArray4['schedule_id'],$value4['summary_id'],6);
		if(!$rejectionRow4){
			$lastRow4=$this->common_model->get_last_department_updation_row($sArray4['schedule_id'],$value4['summary_id']);
			//echo $lastRow4['schedule_department_id']."==".$sArray4['schedule_department_id'];
			?>
			<?php if($lastRow4['rs_design_id']!="" ){ ?>
				<?php if($lastRow4['schedule_department_id']==$sArray4['schedule_department_id']){  ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
 					<?php if($lastRow4['verify_status']==1){?>
    				<li><?php echo ucwords($value4['product_type']);?> [<?php echo ucwords($value4['item_unit_qty_input']);?>][S<?php echo $thisSchedule4;?>] <br><?php echo $value4['online_ref_number'];?></li>
					<?php }else if($lastRow4['verify_status']==-1){?>
    				<li><strong class="text-warning"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value4['product_type']);?> [<?php echo ucwords($value4['item_unit_qty_input']);?>][S<?php echo $thisSchedule4;?>] <br><?php echo $value4['online_ref_number'];?></strong></li>
					<?php }else{ ?>
					<li><strong class="text-warning"><i class="fa fa-arrow-circle-right mr-1"></i><?php echo ucwords($value4['product_type']);?> [<?php echo ucwords($value4['item_unit_qty_input']);?>][S<?php echo $thisSchedule4;?>] <br><?php echo $value4['online_ref_number'];?></strong></li>
					<?php } ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
				<?php }else if($lastRow4['schedule_department_id']!= $sArray4['schedule_department_id']){ ?>
					<?php if($lastRow4['to_department']=="fusing"){ ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
 					<?php if($lastRow4['verify_status']==1){?>
    				<li><strong class="text-success"><i class="fa fa-minus mr-1"></i><?php echo ucwords($value4['product_type']);?> [<?php echo ucwords($value4['item_unit_qty_input']);?>][S<?php echo $thisSchedule4;?>] <br><?php echo $value4['online_ref_number'];?></strong></li>
					<?php }else if($lastRow4['verify_status']==-1){?>
    				<li><strong class="text-warning"><i class="fa fa-arrow-circle-left mr-1"></i><?php echo ucwords($value4['product_type']);?> [<?php echo ucwords($value4['item_unit_qty_input']);?>][S<?php echo $thisSchedule4;?>] <br>(<?php echo $value4['online_ref_number'];?></strong></li>
					<?php }else{ ?>
					<li><strong class="text-success"><i class="fa fa-minus mr-1"></i><?php echo ucwords($value4['product_type']);?> [<?php echo ucwords($value4['item_unit_qty_input']);?>][S<?php echo $thisSchedule4;?>] <br><?php echo $value4['online_ref_number'];?></strong></li>
					<?php } ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->

					<?php }else{ ?>
					<li><?php echo ucwords($value4['product_type']);?> [<?php echo ucwords($value4['item_unit_qty_input']);?>][S<?php echo $thisSchedule4;?>] <br><?php echo $value4['online_ref_number'];?></li>
					<?php } ?>

				<?php }else{ ?>
					<li><?php echo ucwords($value4['product_type']);?> [<?php echo ucwords($value4['item_unit_qty_input']);?>][S<?php echo $thisSchedule4;?>] <br><?php echo $value4['online_ref_number'];?></li>
				<?php } ?>

			<?php }else{ ?>
			<li><?php echo ucwords($value4['product_type']);?> [<?php echo ucwords($value4['item_unit_qty_input']);?>][S<?php echo $thisSchedule4;?>]</li>
			<?php } ?>
		<?php }else{ ?>
			<li><strong class="text-danger" title="Rejected By : <?php echo ucwords($rejectionRow4['rejected_from_departments']);?>"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value4['product_type']);?> [<?php echo ucwords($rejectionRow4['rejected_qty']);?>/<?php echo ucwords($value4['item_unit_qty_input']);?>][S<?php echo $thisSchedule4;?>] <br><?php echo $value4['online_ref_number'];?></strong></li>
		<?php } ?>
	<?php }} ?>
<?php } ?>
</ol>
<?php } ?>
</td>