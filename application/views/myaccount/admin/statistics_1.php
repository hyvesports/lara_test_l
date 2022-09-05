<style>
.fs-30 {
  font-size: 30px;
}
</style>
<div class="row">
<div class="col-md-12 grid-margin transparent">
    <div class="row">
		 <div class="col-md-2 mb-2 stretch-card transparent">
        <div class="card card-tale">
        <div class="card-body">
        <p class="mb-1">REVENUE</p>
		<?php
		$gTotal=0;
		$aTotal=0;
		 if($orderArray['wo_gross_total']!=""){$gTotal=$orderArray['wo_gross_total'];}
                if($orderArray['wo_advance_total']!=""){$aTotal=$orderArray['wo_advance_total'];}

		$REVENUE=$gTotal+$aTotal;
		?>
        <p class="fs-30 mb-2"><?php echo $REVENUE;?></p>
        <p>From <strong><?php echo $orderArray['order_total'];?></strong> Orders</p>
        </div>
        </div>
        </div>
        <div class="col-md-2 mb-2 stretch-card transparent">
        <div class="card card-tale">
        <div class="card-body">
        <p class="mb-1">INBOUND</p>
        <p class="fs-30 mb-2"><?php echo $leadArray['inbound_total'];?></p>
        <p>From <strong><?php echo $leadArray['total_leads'];?></strong> Leads</p>
        </div>
        </div>
        </div>

        <div class="col-md-2 mb-2 stretch-card transparent">
        <div class="card card-tale">
        <div class="card-body">
        <p class="mb-1">OUTBOUND</p>
        <p class="fs-30 mb-2"><?php echo $leadArray['outbound_total'];?></p>
        <p>From <strong><?php echo $leadArray['total_leads'];?></strong> Leads</p>
        </div>
        </div>
        </div>
		<div class="col-md-2 mb-2 stretch-card transparent">
        <div class="card card-tale">
        <div class="card-body">
        <p class="mb-1">ORDERS</p>
        <p class="fs-30 mb-2"><?php if($orderArray['order_total']!=""){ echo $orderArray['order_total']; }  else { echo'0'; } ?></p>
         <p>From <strong><?php echo $leadArray['total_leads'];?></strong> Leads</p>
        </div>
        </div>
        </div>

        <div class="col-md-2 mb-2 stretch-card transparent">
        <div class="card card-tale">
        <div class="card-body">
        <p class="mb-1">PIPELINE</p>
        <p class="fs-30 mb-2"><?php if($leadArray['pipline_total']!=""){ echo $leadArray['pipline_total']; }else { echo '0';}?></p>
        <p>From <strong><?php echo $leadArray['total_leads'];?></strong> Leads</p>
        </div>
        </div>
        </div>

        <div class="col-md-2 mb-2 stretch-card transparent">
        <div class="card card-tale">
        <div class="card-body">
        <p class="mb-1">AMOUNT TO BE RECEIVED</p>
        <p class="fs-30 mb-2"><?php if($leadArray['amount_to_be_rec']!="" && $leadArray['amount_to_be_rec'] != 0){ echo $leadArray['amount_to_be_rec']; }else { echo '0';}?></p>
        <p>From <strong><?php echo $orderRecArray['total_orders'];?></strong> Leads</p>
        </div>
        </div>
        </div>


		
    </div>
</div>
</div>