<td>
<?php
$srow8=$this->common_model->get_schedule_numbers_wo(10,$row['order_id']);
$thisSchedule8=1;
$scheduleArray8=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],10);
if($scheduleArray8){ ?>
<ol>
<?php 
foreach($scheduleArray8 as $sArray8){ 
$array8 = json_decode($sArray8['sh_order_json'],true);
//echo count($array1)."__<br/>";
	foreach($array8 as $key8 => $value8){
    if($value8['item_unit_qty_input']!=0  && $value8['orderno']==$row['orderform_number']){
		$rejectionRow8=$this->common_model->get_any_rejection_now($sArray8['schedule_id'],$value8['summary_id'],13);
		if(!$rejectionRow8){
			if(isset($srow8)){
			$TOTAL_SCHEDULES_ARRAY8=explode(',',$srow8['TOTAL_SCHEDULES']);
			$thisSchedule8 = array_search($sArray8['schedule_department_id'], $TOTAL_SCHEDULES_ARRAY8);
			$thisSchedule8+=1;
			}
			$lastRow8=$this->common_model->get_last_department_updation_row($sArray8['schedule_id'],$value8['summary_id']);
			//echo $lastRow8['schedule_department_id']."==".$sArray8['schedule_department_id']."& status:".$lastRow8['verify_status'];
			?>
			<?php if($lastRow8['rs_design_id']!="" ){ ?>
				<?php if($lastRow8['schedule_department_id']==$sArray8['schedule_department_id']){  ?>
					<!---------------------------------------------------------------------------------------------------------------------------------------->
					<?php if($lastRow8['submitted_to_accounts']==1 && $lastRow8['accounts_status']==0){?>
						<?php if($lastRow8['verify_status']==1){?>
                        	<li><strong class="text-warning"><i class="fa fa-minus mr-1"></i><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></strong></li>
                        <?php }else if($lastRow8['verify_status']==-1){?>
                        	<li><strong class="text-warning"><i class="fa fa-thumbs-down mr-1"></i><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></strong></li>
                        <?php }else{ ?>
                        	<li><strong class="text-warning"><i class="fa fa-arrow-circle-right mr-1"></i><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></strong></li>
                        <?php } ?>
					<?php }else if($lastRow8['submitted_to_accounts']==1 && $lastRow8['accounts_status']==1){ ?>
							<?php $anyDispatch=$this->common_model->get_any_dispatch_row($value8['summary_id']);?>  
							<?php if($anyDispatch['dispatch_counts']=="0"){ ?>
								<li><strong class="text-warning"><i class="fa fa-thumbs-up mr-1"></i><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></strong></li>
							<?php }else{ ?>
								<li><strong class="text-success"><i class="fa fa-thumbs-up mr-1"></i><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></strong></li>
							<?php } ?> 							
						 	
					<?php }else{ ?>
							<li><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></li>
					<?php } ?>

					<!---------------------------------------------------------------------------------------------------------------------------------------->
				<?php }else if($lastRow8['schedule_department_id']!= $sArray8['schedule_department_id']){ ?>
					<?php if($lastRow8['to_department']=="final_qc"){ ?>
						<?php if($lastRow8['submitted_to_accounts']==1 && $lastRow8['accounts_status']==0){?>
                        <!---------------------------------------------------------------------------------------------------------------------------------------->
                        <?php if($lastRow8['verify_status']==1){?>
                        <li><strong class="text-success"><i class="fa fa-thumbs-up mr-1"></i><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></strong></li>
                        <?php }else if($lastRow8['verify_status']==-1){?>
                        <li><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></li>
                        <?php }else{ ?>
                        <li><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></li>
                        <?php } ?>
                        <!---------------------------------------------------------------------------------------------------------------------------------------->
						<?php }else if($lastRow8['submitted_to_accounts']==1 && $lastRow8['accounts_status']==1){ ?>
							<?php $anyDispatch=$this->common_model->get_any_dispatch_row($value8['summary_id']);?>  
							<?php if($anyDispatch['dispatch_counts']=="0"){ ?>
								<li><strong class="text-warning"><i class="fa fa-thumbs-up mr-1"></i><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></strong></li>
							<?php }else{ ?>
								<li><strong class="text-success"><i class="fa fa-thumbs-up mr-1"></i><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></strong></li>
							<?php } ?>
						<?php }else{ ?>
                            <li><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></li>
                        <?php } ?>

					<?php }else{ ?>
					<li><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></li>
					<?php } ?>

				<?php }else{ ?>
					<li><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></li>
				<?php } ?>

			<?php }else{ ?>
			<li><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></li>
			<?php } ?>
		<?php }else{ ?>
			<li><?php echo ucwords($value8['product_type']);?> [<?php echo ucwords($value8['item_unit_qty_input']);?>][S<?php echo $thisSchedule8;?>] <br><?php echo $value8['online_ref_number'];?></li>
		<?php } ?>
	<?php }} ?>
<?php } ?>
</ol>
<?php } ?>
</td>