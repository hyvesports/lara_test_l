<?php $unit_id=$this->input->post('unit_id');?>
<td valign="top" style="vertical-align:bottom;">
    <?php $scheduleArray7=$this->schedule_model->get_each_date_and_deptmt_not_dispatched_new($SH['DSD'],10,$unit_id); ?>
	<?php if($scheduleArray7){ ?>
    
    <?php  //print_r($scheduleArray7);?>
    <ol>
    <?php
	$toolTipContent7="";
	$anyItemExist7=0;
	$totalItemsCount7=0;
	foreach($scheduleArray7 as $A7){ ?>
            <?php
			$rej_items_array7=explode(',',$A7['rej_items']);
			if($A7['scheduled_order_info']!=""){
				$arrayJson7= json_decode($A7['scheduled_order_info'],true);
				$toolTipContent7="";
				foreach($arrayJson7 as $jKey7 => $jValue7){
					if($jValue7['item_unit_qty_input']!=0){
						//$rejectedArray7=$this->common_model->check_is_rejected($A7['order_id'],$jValue7['summary_id']);
						//if(!isset($rejectedArray7)){
						if(!in_array($jValue7['summary_id'], $rej_items_array7)){
							$dispatchArray7=$this->common_model->check_is_dispatched($A7['order_id'],$jValue7['summary_id']);
							if(!isset($dispatchArray7)){
								$toolTipContent7.=$jValue7['product_type']." (".$jValue7['item_unit_qty_input']."),";
								$anyItemExist7=$anyItemExist7+1;
								$totalItemsCount7=$totalItemsCount7+$jValue7['item_unit_qty_input'];
							}
						}
					}
				}
			}
			$rej_items_array7="";
			?>
            <?php if($anyItemExist7!=0) { ?>
            <?php $rejectedArray71=$this->common_model->check_is_rejected_new($A7['schedule_department_id'],$jValue7['summary_id']); ?>
            <?php if(!isset($rejectedArray71)){?>
            <?php $dispatchArray71=$this->common_model->check_is_dispatched($A7['order_id'],$jValue7['summary_id']); ?>
        	<?php if(!isset($dispatchArray71)){?>
            <li style="color:<?php //echo $A7['priority_color_code'];?>;" class="mb-1 text-right" >
            <div data-toggle="tooltip" data-placement="bottom" class="badge contentAjax" style="background-color:<?php echo $A7['priority_color_code'];?>;color:#000;" title="<?php echo substr($toolTipContent7,0,-1);?>">
        	<strong><?php echo ucwords($A7['orderform_number']);?> 
             <?php if($A7['is_re_scheduled']>0){ echo "[R]";}?> </strong>
        	</div>
            
            <?php if($accessArray){if(in_array("re_schedule",$accessArray)){?>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#changeDate" data-sdid="<?php echo $A7['schedule_department_id'];?>" data-did="10" data-sumid="0" data-sd="<?php echo $this->input->post('start_date');?>" data-ed="<?php echo $this->input->post('end_date');?>" data-uid="<?php echo $this->input->post('unit_id');?>" data-cd="<?php echo $SH['DSD'];?>">
        	<div class="badge badge-info" data-toggle="tooltip" data-placement="bottom" title="Change Date"><i class="fa fa-calendar"></i></div>
        	</a>
            <?php } }?>
        	</li>
            <?php } ?>
            <?php } ?>
            <?php } ?>
    <?php 
		$toolTipContent7="";
		$anyItemExist7=0;
	} ?>
    </ol>
    <?php
	$allocationArray7=$this->schedule_model->get_allocated_count($SH['DSD'],$unit_id);
	//print_r($allocationArray);
	?>
    <div class="container-fluid mt-1 "> <hr>
	<p class="text-right mb-2 text-info"><strong><?php echo $allocationArray7['allocated_to_dispatch'];?></strong></p>
	<p class="text-right text-warning"><?php echo $totalItemsCount7;?></p>
     <hr>
     <?php
	 $countDiff7=$allocationArray7['allocated_to_dispatch']-$totalItemsCount7;
	 if($countDiff7<0){
		$txtClr7="text-danger";
	}else{
		$txtClr7="text-success";
	}
	?>
	<h4 class="text-right <?php echo $txtClr7;?> mb-1"><?php echo $countDiff7;?></h4>
	</div>
    
    
	<?php }  ?>
</td>