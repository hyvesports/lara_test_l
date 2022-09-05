<?php $unit_id=$this->input->post('unit_id');?>
<td valign="top" style="vertical-align:bottom;">
    <?php $scheduleArray4=$this->schedule_model->get_each_date_and_deptmt_not_dispatched_new($SH['DSD'],12,$unit_id); ?>
	<?php if($scheduleArray4){ ?>
    
    <?php  //print_r($scheduleArray4);?>
    <ol>
    <?php 
	$toolTipContent4="";
	$anyItemExist4=0;
	$totalItemsCount4=0;
	foreach($scheduleArray4 as $A4){ ?>
        
        	<?php
			$rej_items_array4=explode(',',$A4['rej_items']);
			if($A4['scheduled_order_info']!=""){
				$arrayJson4= json_decode($A4['scheduled_order_info'],true);
				$toolTipContent4="";
				foreach($arrayJson4 as $jKey4 => $jValue4){
					if($jValue4['item_unit_qty_input']!=0){
						//$rejectedArray4=$this->common_model->check_is_rejected($A4['order_id'],$jValue4['summary_id']);
						//if(!isset($rejectedArray4)){
						if(!in_array($jValue4['summary_id'], $rej_items_array4)){	
							$dispatchArray4=$this->common_model->check_is_dispatched($A4['order_id'],$jValue4['summary_id']);
							if(!isset($dispatchArray4)){
								$toolTipContent4.=$jValue4['product_type']." (".$jValue4['item_unit_qty_input']."),";
								$anyItemExist4=$anyItemExist4+1;
								$totalItemsCount4=$totalItemsCount4+$jValue4['item_unit_qty_input'];
							}
						}
					}
				}
			}
			$rej_items_array4="";
			?>
            <?php if($anyItemExist4!=0) { ?>
            <?php $rejectedArray41=$this->common_model->check_is_rejected_new($A4['schedule_department_id'],$jValue4['summary_id']); ?>
            <?php if(!isset($rejectedArray41)){?>
            <?php $dispatchArray41=$this->common_model->check_is_dispatched($A4['order_id'],$jValue4['summary_id']); ?>
        	<?php if(!isset($dispatchArray41)){?>
            <li style="color:<?php //echo $A4['priority_color_code'];?>;" class="mb-1 text-right" >
            <div data-toggle="tooltip" data-placement="bottom"  class="badge   contentAjax" style="background-color:<?php echo $A4['priority_color_code'];?>;color:#000;" title="<?php echo substr($toolTipContent4,0,-1);?>" >
        	<strong><?php echo ucwords($A4['orderform_number']);?> 
             <?php if($A4['is_re_scheduled']>0){ echo "[R]";}?></strong> 
        	</div>
            <?php if($accessArray){if(in_array("re_schedule",$accessArray)){?>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#changeDate" data-sdid="<?php echo $A4['schedule_department_id'];?>" data-did="12" data-sumid="0" data-sd="<?php echo $this->input->post('start_date');?>" data-ed="<?php echo $this->input->post('end_date');?>" data-uid="<?php echo $this->input->post('unit_id');?>" data-cd="<?php echo $SH['DSD'];?>">
        	<div class="badge badge-info" data-toggle="tooltip" data-placement="bottom" title="Change Date"><i class="fa fa-calendar"></i></div>
        	</a>
            <?php }} ?>
        	</li>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            
    <?php
		$toolTipContent4="";
		$anyItemExist4=0;
	} 
	?>
    </ol>
    <?php
	$allocationArray4=$this->schedule_model->get_allocated_count($SH['DSD'],$unit_id);
	//print_r($allocationArray);
	?>
    <div class="container-fluid mt-1 "> <hr>
	<p class="text-right mb-2 text-info"><strong><?php echo $allocationArray4['allocated_to_bundling'];?></strong></p>
	<p class="text-right text-warning"><?php echo $totalItemsCount4;?></p>
    <hr>
     <?php
	 $countDiff4=$allocationArray4['allocated_to_bundling']-$totalItemsCount4;
	 if($countDiff4<0){
		$txtClr4="text-danger";
	}else{
		$txtClr4="text-success";
	}
	?>
	<h4 class="text-right <?php echo $txtClr4;?> mb-1"><?php echo $countDiff4;?></h4>
	</div>
    
    
	<?php }  ?>
</td>