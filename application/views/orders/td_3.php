<?php $unit_id=$this->input->post('unit_id');?>
<td valign="top" style="vertical-align:bottom;">
    <?php $scheduleArray3=$this->schedule_model->get_each_date_and_deptmt_not_dispatched_new($SH['DSD'],6,$unit_id); ?>
	<?php if($scheduleArray3){ ?>
    
    <?php  //print_r($scheduleArray3);?>
    <ol>
    <?php 
	$toolTipContent3="";
	$anyItemExist3=0;
	$totalItemsCount3=0;
	foreach($scheduleArray3 as $A3){ ?>
       	 
        
        	<?php
			$rej_items_array3=explode(',',$A3['rej_items']);
			if($A3['scheduled_order_info']!=""){
				$arrayJson3= json_decode($A3['scheduled_order_info'],true);
				$toolTipContent3="";
				foreach($arrayJson3 as $jKey3 => $jValue3){
					if($jValue3['item_unit_qty_input']!=0){
						//$rejectedArray3=$this->common_model->check_is_rejected($A3['order_id'],$jValue3['summary_id']);
						//if(!isset($rejectedArray3)){
						if(!in_array($jValue3['summary_id'], $rej_items_array3)){
							$dispatchArray3=$this->common_model->check_is_dispatched($A3['order_id'],$jValue3['summary_id']);
							if(!isset($dispatchArray3)){
							$toolTipContent3.=$jValue3['product_type']." (".$jValue3['item_unit_qty_input']."),";
							$anyItemExist3=$anyItemExist3+1;
							$totalItemsCount3=$totalItemsCount3+$jValue3['item_unit_qty_input'];
							}
						}
					}
				}
			}
			$rej_items_array3="";
			?>
            <?php if($anyItemExist3!=0) { ?>
            <?php $rejectedArray31=$this->common_model->check_is_rejected_new($A3['schedule_department_id'],$jValue3['summary_id']); ?>
            <?php if(!isset($rejectedArray31)){?>
            <?php $dispatchArray3=$this->common_model->check_is_dispatched($A3['order_id'],$jValue3['summary_id']); ?>
        	<?php if(!isset($dispatchArray3)){?>
            <li style="color:<?php //echo $A3['priority_color_code'];?>;" class="mb-1 text-right" >
            <div data-toggle="tooltip" data-placement="bottom" class="badge contentAjax" style="background-color:<?php echo $A3['priority_color_code'];?>;color:#000;" title="<?php echo substr($toolTipContent3,0,-1);?>" >
        	<strong><?php echo ucwords($A3['orderform_number']);?> 
             <?php if($A3['is_re_scheduled']>0){ echo "[R]";}?> </strong>
        	</div>
            <?php if($accessArray){if(in_array("re_schedule",$accessArray)){?>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#changeDate" data-sdid="<?php echo $A3['schedule_department_id'];?>" data-did="6" data-sumid="0" data-sd="<?php echo $this->input->post('start_date');?>" data-ed="<?php echo $this->input->post('end_date');?>" data-uid="<?php echo $this->input->post('unit_id');?>" data-cd="<?php echo $SH['DSD'];?>">
        	<div class="badge badge-info" data-toggle="tooltip" data-placement="bottom" title="Change Date"><i class="fa fa-calendar"></i></div>
        	</a>
            <?php }} ?>
        	</li>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            
    <?php 
		$toolTipContent3="";
		$anyItemExist3=0;
	} 
	?>
    </ol>
    <?php
	$allocationArray3=$this->schedule_model->get_allocated_count($SH['DSD'],$unit_id);
	//print_r($allocationArray);
	?>
    <div class="container-fluid mt-1 "> <hr>
	<p class="text-right mb-2 text-info"><strong><?php echo $allocationArray3['allocated_to_fusing'];?></strong></p>
	<p class="text-right text-warning"><?php echo $totalItemsCount3;?></p>
    <hr>
     <?php
	 $countDiff3=$allocationArray3['allocated_to_fusing']-$totalItemsCount3;
	 if($countDiff3<0){
		$txtClr3="text-danger";
	}else{
		$txtClr3="text-success";
	}
	?>
	<h4 class="text-right <?php echo $txtClr3;?> mb-1"><?php echo $countDiff3;?></h4>
	</div>
    
    
	<?php }  ?>
</td>