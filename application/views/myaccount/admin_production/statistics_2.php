<?php 
   //echo $selectedDate;
   $freeOrdersArray=$this->dashboard_model->get_wo_orders_by_nature($selectedDate,5);
$paidOrdersArray=$this->dashboard_model->get_wo_orders_by_nature($selectedDate,4);
$qcRejArray=$this->dashboard_model->get_design_qc_rejected($makeDate);
$bundlingRejArray=$this->dashboard_model->get_design_bundling_rejected($makeDate);
$finalqcRejArray=$this->dashboard_model->get_design_final_qc_rejected($makeDate);
$qcRejQty=0;$bqcRej=0;$fnlQcRej=0;

foreach($qcRejArray as $qcR)
{
    $qcRejQty +=$qcR['qty'];
}
foreach($bundlingRejArray as $qcR)
{
    $bqcRej +=$qcR['qty'];
}
foreach($finalqcRejArray as $qcR)
{
    $fnlQcRej +=$fnlQcRej['qty'];
}


?>


<div class="row">
  <div class="col-md-6 grid-margin transparent">
    <div class="card">
      <div class="card-body">
        <p class="card-title">Rework Orders</p>
	<div class="col-md-6 pl-md-1 pt-4 pt-md-0">
	  
          <ul class="nav nav-tabs tab-basic" role="tablist">
	    <li class="nav-item">
	      <a class="nav-link active" id="profiled-tab" data-toggle="tab" href="#ourgoald" role="tab" aria-controls="ourgoald" aria-selected="true">Free</a>
	    </li>
	    <li class="nav-item">
	      <a class="nav-link" id="contactd-tab" data-toggle="tab" href="#historyd" role="tab" aria-controls="historyd" aria-selected="false">Paid</a>
	    </li>
	    
          </ul>
        </div>
	<div class="tab-content tab-content-basic"  >
	  <div class="tab-pane fade show active" id="ourgoald" role="tabpanel" aria-labelledby="profiled-tab" >
	    
	    
	    <div class="table-responsive ">
	      
	      <table class="table table-striped table-borderless listing" id="listing">
		<thead>
		  <tr>
		    <th>Customer Name</th>
		    <th>Qty</th>
		    <th>Type</th>
		    <th>Sales Owner</th>
		  </tr>  
		  
		</thead>
		<tbody>
		  <?php if($freeOrdersArray){?>
		  <?php foreach($freeOrdersArray as $OR){ 
			?>
		  
		  
		  <tr>
		    <td><?php echo $OR['customer_name'];?></td>
		    
		    <td><?php echo $OR['order_total_qty'];?></td>
		    <td>Free</td>
		    <td><?php echo $OR['staff_name'];?></td>
		    
		  </tr>
		  <?php } ?>
		  <?php } ?>
		    </tbody>
	      </table>
	    </div>
          </div>
	  <div class="tab-pane fade" id="historyd" role="tabpanel" aria-labelledby="contactdtab">
	    <div class="table-responsive ">
	      
	      <table class="table table-striped table-borderless listing" id="listing">
		<thead>
		  <tr>
		    <th>Customer Name</th>
		    <th>Qty</th>
		    <th>Type</th>
		    <th>Sales Owner</th>
		  </tr>  
		  
		</thead>
		<tbody>
		  <?php if($paidOrdersArray){?>
		  <?php foreach($paidOrdersArray as $OR){ 
			?>
		  
		  
		  <tr>
		    <td><?php echo $OR['customer_name'];?></td>
		    
		    <td><?php echo $OR['order_total_qty'];?></td>
		    <td>Paid</td>
		    <td><?php echo $OR['staff_name'];?></td>
		    
		  </tr>
		  <?php } ?>
		  <?php } ?>
		</tbody>
	      </table>
	    </div>
          </div>
	  
	</div>
      </div>
    </div>
    
  </div>

<div class="col-md-6 grid-margin transparent">
  <div class="row">
    <div class="col-md-6 grid-margin">
      <div class="card">
	<div class="card-body">
          <h4 class="card-title mb-0">Design Qc Rejected</h4>
          <div class="d-flex justify-content-between align-items-center">
          <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $qcRejQty;?>  </h2>
	    </div>
          </div>
	  
        </div>
	</div>
      </div>
    </div>
    <div class="col-md-6 grid-margin">
      <div class="card">
	<div class="card-body">
          <h4 class="card-title mb-0">Bundling Qc Rejected</h4>
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $bqcRej;?>  </h2>
	    </div>
          </div>
	  
        </div>
	</div>
      </div>
  </div>
    
    
    <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-0">Final Qc Rejected</h4>
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
    <h2 class="mb-0"><?php echo $fnlQcRej;?>  </h2>
	    </div>
          </div>
	  
        </div>
      </div>
    </div>
  </div>
  </div>
</div>
</div>



      <script>
	
	
</script>
