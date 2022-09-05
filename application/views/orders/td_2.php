<?php $unit_id=$this->input->post('unit_id');?>
<td valign="top" style="vertical-align:bottom;">
    <?php $scheduleArray2=$this->schedule_model->get_each_date_and_deptmt_not_dispatched_new($SH['DSD'],5,$unit_id); ?>
	<?php if($scheduleArray2){ ?>
    <?php  //print_r($scheduleArray2);?>
    <ol>
    <?php
	$toolTipContent2="";
	$anyItemExist2=0;
	$totalItemsCount2=0;
	foreach($scheduleArray2 as $A2){ ?>
        
        
        	<?php
			$rej_items_array2=explode(',',$A2['rej_items']);
			if($A2['scheduled_order_info']!=""){
				$arrayJson2 = json_decode($A2['scheduled_order_info'],true);
				$toolTipContent2="";
				foreach($arrayJson2 as $jKey2 => $jValue2){
					if($jValue2['item_unit_qty_input']!=0){
						//$rejectedArray2=$this->common_model->check_is_rejected($A2['order_id'],$jValue2['summary_id']);
						//if(!isset($rejectedArray2)){
						if(!in_array($jValue2['summary_id'], $rej_items_array2)){	
							$dispatchArray2=$this->common_model->check_is_dispatched($A2['order_id'],$jValue2['summary_id']);
							if(!isset($dispatchArray2)){
								$toolTipContent2.=$jValue2['product_type']." (".$jValue2['item_unit_qty_input']."),";
								$anyItemExist2=$anyItemExist2+1;
								$totalItemsCount2=$totalItemsCount2+$jValue2['item_unit_qty_input'];
							}
						}
						
					}
				}
			}
			$rej_items_array2="";
			?>
            <?php if($anyItemExist2!=0) { ?>
            <?php $rejectedArray21=$this->common_model->check_is_rejected_new($A2['schedule_department_id'],$jValue2['summary_id']); ?>
            <?php if(!isset($rejectedArray21)){?>
            <?php $dispatchArray2=$this->common_model->check_is_dispatched($A2['order_id'],$jValue2['summary_id']); ?>
        	<?php if(!isset($dispatchArray2)){?>
            <li style="color:<?php //echo $A2['priority_color_code'];?>;" class="mb-1 text-right" >
            <div  data-toggle="tooltip" data-placement="bottom" class="badge  contentAjax" style="background-color:<?php echo $A2['priority_color_code'];?>;color:#000;" title="<?php echo substr($toolTipContent2,0,-1);?>" >
        	<strong><?php echo ucwords($A2['orderform_number']);?> 
            <?php if($A2['is_re_scheduled']>0){ echo "[R]";}?> </strong>
        	</div>
            <?php if($accessArray){if(in_array("re_schedule",$accessArray)){?>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#changeDate" data-sdid="<?php echo $A2['schedule_department_id'];?>" data-did="5" data-sumid="0" data-sd="<?php echo $this->input->post('start_date');?>" data-ed="<?php echo $this->input->post('end_date');?>" data-uid="<?php echo $this->input->post('unit_id');?>" data-cd="<?php echo $SH['DSD'];?>">
        	<div class="badge badge-info" data-toggle="tooltip" data-placement="bottom" title="Change Date"><i class="fa fa-calendar"></i></div>
        	</a>
        	</li>
             <?php }} ?>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            
            
    <?php 
		$toolTipContent2="";
		$anyItemExist2=0;
	}
	?>
    </ol>
     <?php
	$allocationArray2=$this->schedule_model->get_allocated_count($SH['DSD'],$unit_id);
	//print_r($allocationArray);
	?>
    <div class="container-fluid mt-1 "> <hr>
	<p class="text-right mb-2 text-info"><strong><?php echo $allocationArray2['allocated_to_printing'];?></strong></p>
	<p class="text-right text-warning"><?php echo $totalItemsCount2;?></p>
    <hr>
     <?php
	 $countDiff2=$allocationArray2['allocated_to_printing']-$totalItemsCount2;
	 if($countDiff2<0){
		$txtClr2="text-danger";
	}else{
		$txtClr2="text-success";
	}
	?>
	<h4 class="text-right <?php echo $txtClr2;?> mb-1"><?php echo $countDiff2;?></h4>
	</div>
    
	<?php  }  ?>
</td>