<?php $unit_id=$this->input->post('unit_id');?>
<td valign="top" style="vertical-align:bottom;">
    <?php $scheduleArray1=$this->schedule_model->get_each_date_and_deptmt_not_dispatched_new($SH['DSD'],4,$unit_id); ?>
	<?php if($scheduleArray1){ ?>
    <?php  //print_r($scheduleArray1);?>
    <ol>
    <?php
	$toolTipContent="";
	$dispatch_id="";
	$anyItemExist=0;
	$totalItemsCount=0;
	foreach($scheduleArray1 as $A1){ ?>
        	<?php
			$rej_items_array=explode(',',$A1['rej_items']);
			if($A1['scheduled_order_info']!=""){
				$arrayJson1 = json_decode($A1['scheduled_order_info'],true);
				$toolTipContent="";
				foreach($arrayJson1 as $jKey1 => $jValue1){
					if($jValue1['item_unit_qty_input']!=0){
						if(!in_array($jValue1['summary_id'], $rej_items_array)){
							$dispatchArray=$this->common_model->check_is_dispatched($A1['order_id'],$jValue1['summary_id']);
							if(!isset($dispatchArray)){
							$toolTipContent.=$jValue1['product_type']." (".$jValue1['item_unit_qty_input']."),";
							$anyItemExist=$anyItemExist+1;
							$totalItemsCount=$totalItemsCount+$jValue1['item_unit_qty_input'];
							}
						}
					}
				}
			}
			$rej_items_array="";
			?>
            <?php if($anyItemExist) { ?>
            <?php $rejectedArray1=$this->common_model->check_is_rejected_new($A1['schedule_department_id'],$jValue1['summary_id']); ?>
            <?php if(!isset($rejectedArray1)){?>
            <?php $dispatchArray1=$this->common_model->check_is_dispatched($A1['order_id'],$jValue1['summary_id']); ?>
        	<?php if(!isset($dispatchArray1)){?>
                <li style="color:<?php //echo $A1['priority_color_code'];?>;" class="mb-1 text-right" >
                <div  data-toggle="tooltip" data-placement="bottom" class="badge   contentAjax" style="background-color:<?php echo $A1['priority_color_code'];?>;color:#000;" title="<?php echo substr($toolTipContent,0,-1);?>">
                <strong><?php echo ucwords($A1['orderform_number']);?> 
                <?php if($A1['is_re_scheduled']>0){ echo "[R]";}?> </strong>
                <?php //echo $anyItemExist;?>
                </div>
                
                
               <?php if($accessArray){if(in_array("re_schedule",$accessArray)){?>
                <a href="javascript:void(0);" data-toggle="modal" data-target="#changeDate" data-sdid="<?php echo $A1['schedule_department_id'];?>" data-did="4" data-sumid="0" data-sd="<?php echo $this->input->post('start_date');?>" data-ed="<?php echo $this->input->post('end_date');?>" data-uid="<?php echo $this->input->post('unit_id');?>" data-cd="<?php echo $SH['DSD'];?>">
                <div class="badge badge-info" data-toggle="tooltip" data-placement="bottom" title="Change Date"><?php //echo $A1['schedule_department_id'];?><i class="fa fa-calendar"></i></div>
                </a>
                <?php }} ?>
                 </li>
            <?php } ?>
            <?php } ?>
            <?php } ?>
       
       
    <?php
	$toolTipContent="";
	$anyItemExist=0;
	}
	?>
    </ol>
    <?php
	$allocationArray=$this->schedule_model->get_allocated_count($SH['DSD'],$unit_id);
	//print_r($allocationArray);
	?>
    <div class="container-fluid mt-1 "> <hr>
	<p class="text-right mb-2 text-info"><strong><?php echo $allocationArray['allocated_to_design'];?></strong></p>
	<p class="text-right text-warning"><?php echo $totalItemsCount;?></p>
    <hr>
     <?php
	 $countDiff=$allocationArray['allocated_to_design']-$totalItemsCount;
	 if($countDiff<0){
		$txtClr1="text-danger";
	}else{
		$txtClr1="text-success";
	}
	?>
	<h4 class="text-right <?php echo $txtClr1;?> mb-1"><?php echo $countDiff;?></h4>
	</div>
    
    
	<?php }  ?>
</td>