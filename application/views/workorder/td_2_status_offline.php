<td>
<?php
$srow2=$this->common_model->get_schedule_numbers_wo(11,$row['order_id']);
$thisSchedule2=1;
$scheduleArray2=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],11);
if($scheduleArray2){ ?>
<ol>
<?php 

foreach($scheduleArray2 as $sArray2){ 
$array2 = json_decode($sArray2['sh_order_json'],true);
//echo count($array1)."__<br/>";
	foreach($array2 as $key2 => $value2){
    if($value2['item_unit_qty_input']!=0  && $value2['orderno']==$row['orderform_number']){
		if(isset($srow2)){
			$TOTAL_SCHEDULES_ARRAY2=explode(',',$srow2['TOTAL_SCHEDULES']);
			$thisSchedule2 = array_search($sArray2['schedule_department_id'], $TOTAL_SCHEDULES_ARRAY2);
			$thisSchedule2+=1;
		}
		$rejectionRow2=$this->common_model->get_any_rejection_now($sArray1['schedule_id'],$value2['summary_id'],11);
			if(!$rejectionRow2){ 
			$lastRow2=$this->common_model->get_last_department_updation_row($sArray2['schedule_id'],$value2['summary_id']);
			?>
			<?php if($lastRow2['rs_design_id']!="" && $lastRow2['schedule_department_id']== $sArray2['schedule_department_id']){ ?>
				<?php if($lastRow2['to_department']=="design_qc"){ ?>

					<!---------------------------------------------------------------------------------------------------------------------------------------->
 					<?php if($lastRow2['verify_status']==1){?>
    				<li><strong class="text-warning"><i class="fa fa-arrow-circle-right mr-1"></i><?php echo ucwords($value2['product_type']);?> [ <?php echo ucwords($value2['item_unit_qty_input']);?> ][S<?php echo $thisSchedule2;?>]</strong></li>
					<?php }else if($lastRow2['verify_status']==-1){?>
    				<li><strong class="text-warning"><i class="fa fa-arrow-circle-left mr-1"></i><?php echo ucwords($value2['product_type']);?> [ <?php echo ucwords($value2['item_unit_qty_input']);?> ][S<?php echo $thisSchedule2;?>]</strong></li>
					<?php }else{ ?>
					<li><strong class="text-success"><i class="fa fa-minus mr-1"></i><?php echo ucwords($value2['product_type']);?> [ <?php echo ucwords($value2['item_unit_qty_input']);?> ][S<?php echo $thisSchedule2;?>]</strong></li>
					<?php } ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->

				<?php }else{ ?>
					<li><?php echo ucwords($value2['product_type']);?> [ <?php echo ucwords($value2['item_unit_qty_input']);?> ][S<?php echo $thisSchedule2;?>]</li>
				<?php } ?>
			<?php }else{ ?>
				<li><?php echo ucwords($value2['product_type']);?> [ <?php echo ucwords($value2['item_unit_qty_input']);?> ][S<?php echo $thisSchedule2;?>]</li>
			<?php } ?>
			<?php }else{ ?>
				<li><strong class="text-danger" title="Rejected By : <?php echo ucwords($rejectionRow2['rejected_from_departments']);?>"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value2['product_type']);?> [ <?php echo ucwords($rejectionRow2['rejected_qty']);?>/<?php echo ucwords($value2['item_unit_qty_input']);?> ][S<?php echo $thisSchedule2;?>]</strong></li>
			<?php } ?>

		<?php }} ?>
<?php } ?>
</ol>
<?php } ?>
</td>