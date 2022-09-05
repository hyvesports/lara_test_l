<?php $unit_id=$this->input->post('unit_id');?>
<td valign="top" style="vertical-align:bottom;">
    <?php $scheduleArray5=$this->schedule_model->get_each_date_and_deptmt_not_dispatched_new($SH['DSD'],8,$unit_id); ?>
	<?php if($scheduleArray5){ ?>
    
    <?php  //print_r($scheduleArray5);?>
    <ol>
    
    <?php
	$toolTipContent5="";
	$anyItemExist5=0;
	$all_total_time_sec=0;
	foreach($scheduleArray5 as $A5){ ?>
            <?php
			$rej_items_array5=explode(',',$A5['rej_items']);
			if($A5['scheduled_order_info']!=""){
				$arrayJson5= json_decode($A5['scheduled_order_info'],true);
				$toolTipContent5="";
				foreach($arrayJson5 as $jKey5 => $jValue5){
					if($jValue5['item_unit_qty_input']!=0){
						//$rejectedArray5=$this->common_model->check_is_rejected($A5['order_id'],$jValue5['summary_id']);
						//if(!isset($rejectedArray5)){
						if(!in_array($jValue5['summary_id'], $rej_items_array5)){
							$dispatchArray5=$this->common_model->check_is_dispatched($A5['order_id'],$jValue5['summary_id']);
							if(!isset($dispatchArray5)){
								$toolTipContent5.=$jValue5['product_type']." (".$jValue5['item_unit_qty_input']."),";
								$anyItemExist5=$anyItemExist5+1;
								$all_total_time_sec+=$jValue5['item_order_sec']*$jValue5['item_unit_qty_input'];
								
							}
						}
					}
				}
			}
			$rej_items_array5="";
			?>
            <?php if($anyItemExist5!=0) { ?>
            <?php $rejectedArray51=$this->common_model->check_is_rejected_new($A5['schedule_department_id'],$jValue5['summary_id']); ?>
            <?php if(!isset($rejectedArray51)){?>
            <?php $dispatchArray51=$this->common_model->check_is_dispatched($A5['order_id'],$jValue5['summary_id']); ?>
        	<?php if(!isset($dispatchArray51)){?>
            <li style="color:<?php //echo $A5['priority_color_code'];?>;" class="mb-1 text-right" >
            <div data-toggle="tooltip" data-placement="bottom" class="badge   contentAjax" style="background-color:<?php echo $A5['priority_color_code'];?>;color:#000;" title="<?php echo substr($toolTipContent5,0,-1);?>">
        	<strong><?php echo ucwords($A5['orderform_number']);?> 
             <?php if($A5['is_re_scheduled']>0){ echo "[R]";}?> </strong>
        	</div>
            
            <?php if($accessArray){if(in_array("re_schedule",$accessArray)){?>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#changeDate" data-sdid="<?php echo $A5['schedule_department_id'];?>" data-did="8" data-sumid="0" data-sd="<?php echo $this->input->post('start_date');?>" data-ed="<?php echo $this->input->post('end_date');?>" data-uid="<?php echo $this->input->post('unit_id');?>" data-cd="<?php echo $SH['DSD'];?>">
        	<div class="badge badge-info" data-toggle="tooltip" data-placement="bottom" title="Change Date"><i class="fa fa-calendar"></i></div>
        	</a>
            <?php } } ?>
        	</li>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            
    <?php
		$toolTipContent5="";
		$anyItemExist5=0;
	} ?>
    </ol>
    <?php
	$allocationArray5=$this->schedule_model->get_allocated_count($SH['DSD'],$unit_id);
	 $t = round($allocationArray5['unit_working_capacity_in_sec']);
 	 $atime=sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
	 
	 $t2 = round($all_total_time_sec);
 	 $utime=sprintf('%02d:%02d:%02d', ($t2/3600),($t2/60%60),$t2%60);
	 
	$diffTime=$t-$t2;
	if($diffTime<0){
		$txtClr="text-danger";
	}else{
		$txtClr="text-success";
	}
	//echo $diffTime;
	 $t3 = round($diffTime);
 	 $btime=sprintf('%02d:%02d:%02d', ($t3/3600),($t3/60%60),$t3%60);
  ?>
    <div class="container-fluid mt-1 "> <hr>
	<p class="text-right mb-2 text-info"><strong><?php echo $atime;?></strong></p>
	<p class="text-right text-warning"><?php echo $utime;?></p>
     <hr>
	<h4 class="text-right <?php echo $txtClr;?>  mb-1"><?php echo $btime;?></h4>
	</div>
    
	<?php }  ?>
</td>