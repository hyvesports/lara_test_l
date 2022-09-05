<?php $unit_id=$this->input->post('unit_id');?>
<td valign="top" style="vertical-align:bottom;">
    <?php $scheduleArray6=$this->schedule_model->get_each_date_and_deptmt_not_dispatched_new($SH['DSD'],13,$unit_id); ?>
	<?php if($scheduleArray6){ ?>
    
    <?php  //print_r($scheduleArray6);?>
    <ol>
    <?php
	$toolTipContent6="";
	$anyItemExist6=0;
	$totalItemsCount6=0;
	foreach($scheduleArray6 as $A6){ ?>
        
        	
            <?php
			$rej_items_array6=explode(',',$A6['rej_items']);
			if($A6['scheduled_order_info']!=""){
				$arrayJson6= json_decode($A6['scheduled_order_info'],true);
				$toolTipContent6="";
				foreach($arrayJson6 as $jKey6 => $jValue6){
					if($jValue6['item_unit_qty_input']!=0){
						//$rejectedArray6=$this->common_model->check_is_rejected($A6['order_id'],$jValue6['summary_id']);
						//if(!isset($rejectedArray6)){
						if(!in_array($jValue6['summary_id'], $rej_items_array6)){
							$dispatchArray6=$this->common_model->check_is_dispatched($A6['order_id'],$jValue6['summary_id']);
							if(!isset($dispatchArray6)){
								$toolTipContent6.=$jValue6['product_type']." (".$jValue6['item_unit_qty_input']."),";
								$anyItemExist6=$anyItemExist6+1;
								$totalItemsCount6=$totalItemsCount6+$jValue6['item_unit_qty_input'];
							}
						}
					}
				}
			}
			$rej_items_array6="";
			?>
            <?php if($anyItemExist6!=0) { ?>
            <?php $rejectedArray61=$this->common_model->check_is_rejected_new($A6['schedule_department_id'],$jValue6['summary_id']); ?>
            <?php if(!isset($rejectedArray61)){?>
            <?php $dispatchArray61=$this->common_model->check_is_dispatched($A6['order_id'],$jValue6['summary_id']); ?>
        	<?php if(!isset($dispatchArray61)){?>
            <li style="color:<?php //echo $A6['priority_color_code'];?>;" class="mb-1 text-right" >
            <div data-toggle="tooltip" data-placement="bottom" class="badge contentAjax" style="background-color:<?php echo $A6['priority_color_code'];?>;color:#000;" title="<?php echo substr($toolTipContent6,0,-1);?>">
        	<strong><?php echo ucwords($A6['orderform_number']);?> 
             <?php if($A6['is_re_scheduled']>0){ echo "[R]";}?> </strong>
        	</div>
            
            <?php if($accessArray){if(in_array("re_schedule",$accessArray)){?>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#changeDate" data-sdid="<?php echo $A6['schedule_department_id'];?>" data-did="13" data-sumid="0" data-sd="<?php echo $this->input->post('start_date');?>" data-ed="<?php echo $this->input->post('end_date');?>" data-uid="<?php echo $this->input->post('unit_id');?>" data-cd="<?php echo $SH['DSD'];?>">
        	<div class="badge badge-info" data-toggle="tooltip" data-placement="bottom" title="Change Date"><i class="fa fa-calendar"></i></div>
        	</a>
            <?php } } ?>
        	</li>
            <?php } ?>
            <?php } ?>
            <?php } ?>
    <?php 
		$toolTipContent6="";
		$anyItemExist6=0;
	
	} ?>
    </ol>
    <?php
	$allocationArray6=$this->schedule_model->get_allocated_count($SH['DSD'],$unit_id);
	//print_r($allocationArray);
	?>
    <div class="container-fluid mt-1 "> <hr>
	<p class="text-right mb-2 text-info"><strong><?php echo $allocationArray6['allocated_to_finalqc'];?></strong></p>
	<p class="text-right text-warning"><?php echo $totalItemsCount6;?></p>
    <hr>
     <?php
	 $countDiff6=$allocationArray6['allocated_to_finalqc']-$totalItemsCount6;
	 if($countDiff6<0){
		$txtClr6="text-danger";
	}else{
		$txtClr6="text-success";
	}
	?>
	<h4 class="text-right <?php echo $txtClr6;?> mb-1"><?php echo $countDiff6;?></h4>
	</div>
    
	<?php }  ?>
</td>