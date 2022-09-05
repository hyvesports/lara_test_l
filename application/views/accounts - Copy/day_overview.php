<?php //print_r($calender_date_info);?>
<div class="card-body">
<div class="d-flex align-items-center">

<div class="mb-1">
<h4>Day Overview</h4>
<div class="badge badge-info"><i class="fa fa-calendar"></i> <?php echo date('d-m-Y', strtotime($calender_date_info['unit_calendar_date']));?></div>
<?php if($calender_date_info){?>
	<?php if($calender_date_info['unit_is_working']=='no'){?>
	<div class="badge badge-danger"> <i class="fa fa-ban"></i> Non Working Day</div>
    <?php }else{ ?>
    <div class="badge badge-success"><i class="fa fa-check"></i> Working Day</div>
    <?php } ?>
<?php }else{ ?>
<div class="badge badge-danger">Calender Not Updated!!!</div>
<?php } ?>
</div>
</div>
	
    <div class="border-top pt-3">
    <div class="row">
    <?php if($day_overview){?>
    	<?php
		$design_orders_count=0;
		foreach($day_overview as $sArray1){ 
			//$array1 = json_decode($sArray1['sh_order_json'],true);
			$array1 = json_decode($sArray1['scheduled_order_info'],true);
			
			if($array1) {
				foreach($array1 as $key1 => $value1){
					if($value1['item_unit_qty_input']!=0){
						$design_orders_count=$design_orders_count+$value1['item_unit_qty_input'];
					}
				}
			}
		}
		//calender_date_info
		?>
        <div class="col-md-4 text-center">
        <h6><?php echo $calender_date_info['allocated_to_design'];?></h6>
        <p>Per Day Count</p>
        </div>
        <div class="col-md-4 text-center">
        <h6><?php echo $design_orders_count;?></h6>
        <p>Order Count</p>
        </div>
        <?php 
		$remaining=$calender_date_info['allocated_to_design']-$design_orders_count;
		?>
        
        <div class="col-md-4 text-center">
        <?php if($remaining>=0){ ?>
        <h6><?php echo $remaining;?></h6>
        <p>Remaining Count</p>
        <?php }else{ ?>
        <?php $overLimit=$design_orders_count-$calender_date_info['allocated_to_design']; ?>
        <h6><?php echo $overLimit;?></h6>
        <p>Over Limit Count</p>
        <?php }?>
        </div>
	<?php }?>
    </div>
    </div>
</div>