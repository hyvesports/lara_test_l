<style>
  .fs-30 {
  font-size: 30px;
  }
  .cardWo {
  height: 100%;
  max-height: 390px;
  overflow: scroll;
  }
</style>

<?php 

if($leadArray['wo_max_gross_total'] =="")
$wo_max_gross_total=0;
else
$wo_max_gross_total=$leadArray['wo_max_gross_total'];
?>
<div class="row">
  <div class="col-md-4 grid-margin transparent">
    <div class="row">
      <div class="col-md-12 mb-4 stretch-card transparent">
	<div class="card card-dark-blue">
	  <div class="card-body">
	    <h4 class="card-title mb-0">Max Deal Size</h4>
	    <div class="d-flex justify-content-between align-items-center">
	      <div class="d-inline-block pt-3">
		<div class="d-md-flex">
		  <h2 class="mb-0"><?php echo $wo_max_gross_total ;?></h2>
		</div>
	      </div>
	    </div>
	  </div>
	  
	</div>
      </div>
    </div>
  </div>

  <div class="col-md-4 grid-margin transparent">
    <div class="row">
      <div class="col-md-12 mb-4 stretch-card transparent">
	<div class="card card-dark-blue">
	  <div class="card-body">
	    <h6 class="card-title mb-0">Average Deal Size</h6>
	    <div class="d-flex justify-content-between align-items-center">
	      <div class="d-inline-block pt-3">
		<div class="d-md-flex">
		  <h2 class="mb-0"><?php echo floor($leadArray['order_total_avg']);?></h2>
	      </div>
	      </div>
	    </div>
	  </div>
	</div>
      </div>
    </div>
  </div>
  
  <div class="col-md-4 grid-margin transparent">
    <div class="row">
      <div class="col-md-12 mb-4 stretch-card transparent">
	<div class="card card-dark-blue">
	  <div class="card-body">
	    <h4 class="card-title mb-0">Average Time Per Lead</h4>
	    <div class="d-flex justify-content-between align-items-center">
	      <div class="d-inline-block pt-3">
	      <div class="d-md-flex">
		<h2 class="mb-0"><?php echo floor($leadArray['order_time_avg']);?></h2>
	      </div>
	      </div>
	    </div>
	  </div>
	</div>
      </div>
    </div>
  </div>



</div>


