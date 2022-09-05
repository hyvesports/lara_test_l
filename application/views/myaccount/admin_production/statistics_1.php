<?php 
   $makeDate=date("d-m-Y", strtotime($this->session->userdata('date_now')));
$makeDateYesterday=date("d-m-Y", strtotime($this->session->userdata('date_now'))-1);
$makeDateFormatYesterday=date("Y-m-d", strtotime($this->session->userdata('date_now'))-1);
//echo $makeDateYesterday;
$totalOrderCount=$this->dashboard_model->get_wo_total_qty_count($month,$year);
$OfflineOrderCount=$this->dashboard_model->get_wo_total_stitching_orders_by_type($month,$year,1);
$OnlineOrderCount=$this->dashboard_model->get_wo_total_stitching_orders_by_type($month,$year,2);

$totalQtyArray=$this->dashboard_model->get_wo_total_stitching($month,$year);

$t_count = $onlineOrderCnt = $offlineOrderCnt = $total_qty_count = 0 ;
 if($totalOrderCount['cnt']!=""){
$t_count=$totalOrderCount['cnt'];
}
if($OnlineOrderCount['cnt']!=""){
$onlineOrderCnt=$OnlineOrderCount['cnt'];
}
if($OfflineOrderCount['cnt']!=""){

    $offlineOrderCnt=$OfflineOrderCount['cnt'];
}


    $total_qty_count=$totalQtyArray;
$designCompletedCount = $designqcCompletedCount = $printCompletedCount = $fusingCompletedCount = $bundlingCompletedCount = 0 ;
$stitchingCount = $finalQcCount =  $dispatchQtyCount =0;
$designCompletedCount=$this->dashboard_model->get_design_done($makeDateYesterday);
$designqcCompletedCount=$this->dashboard_model->get_design_qc_done($makeDateYesterday);
$printCompletedCount=$this->dashboard_model->get_print_done($makeDateYesterday);
$fusingCompletedCount=$this->dashboard_model->get_fusing_done($makeDateYesterday);
$bundlingCompletedCount=$this->dashboard_model->get_bundling_done($makeDateYesterday);
$stitchingCount=$this->dashboard_model->get_stitching_done($makeDateYesterday);
$finalQcCount=$this->dashboard_model->get_final_qc_done($makeDateYesterday);
$dispatchQtyCount=$this->dashboard_model->get_dispatch_done_total($makeDateYesterday);
if($dispatchQtyCount ==null)
{
$dispatchQtyCount=0;
}

$DesignQtyCount = $DesignQcQtyCount = $PrintingQtyCount = 0;
$BundlingQtyCount = $FusingQtyCount = $StitchingQtyCount =   $FincalQcQtyCount = 0;
$DesignQtyCount=$this->dashboard_model->get_wo_total_counts_by_stage_design($makeDateFormatYesterday,'4');
$DesignQcQtyCount=$this->dashboard_model->get_wo_total_counts_by_stage_design($makeDateFormatYesterday,'11');
$PrintingQtyCount=$this->dashboard_model->get_wo_total_counts_by_stage_design($makeDateFormatYesterday,'5');
$FusingQtyCount=$this->dashboard_model->get_wo_total_counts_by_stage_design($makeDateFormatYesterday,'6');
$BundlingQtyCount  =$this->dashboard_model->get_wo_total_counts_by_stage_design($makeDateFormatYesterday,'12');
$StitchingQtyCount  =$this->dashboard_model->get_wo_total_counts_by_stage_design($makeDateFormatYesterday,'12');
$FincalQcQtyCount  =$this->dashboard_model->get_wo_total_counts_by_stage_design($makeDateFormatYesterday,'12');





/*



$BundlingQtyCount=$this->dashboard_model->get_wo_total_counts_by_stage($makeDate,'6','Fusing');
$FusingQtyCount=$this->dashboard_model->get_wo_total_counts_by_fusing($makeDate,'6','Fusing');
$StitchingQtyCount=$this->dashboard_model->get_wo_total_counts_by_stitching($makeDate,'8','Stitching');
$FincalQcQtyCount=$this->dashboard_model->get_wo_total_counts_by_stage($makeDate,'5','stitching');














*/


?>
<div class="row">
  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body">
	<h4 class="card-title mb-0">Total  Qty</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $total_qty_count;?>  </h2>
	    </div>
	  </div>

	</div>
      </div>
    </div>
  </div>

  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body">
	<h4 class="card-title mb-0">Total Orders</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $t_count;?>   </h2>
	    </div>

	  </div>

	</div>
      </div>
    </div>
  </div>

  <div class="col-md-2 grid-margin">
    <div class="card">
      <div class="card-body">
	<h4 class="card-title mb-0">Offline </h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $offlineOrderCnt;?>  </h2>
	    </div>
	  </div>

	</div>
      </div>
    </div>
  </div>

  <div class="col-md-2 grid-margin">
    <div class="card">
      <div class="card-body">
	<h4 class="card-title mb-0">Online </h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $onlineOrderCnt;?> </h2>
	    </div>
	  </div>

	</div>
      </div>
    </div>
  </div>

  <div class="col-md-2 grid-margin">
    <div class="card">
      <div class="card-body">
	<h4 class="card-title mb-0">Average</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $t_count/2;?>  </h2>
	    </div>
	  </div>
	  
	</div>
      </div>
    </div>
  </div>
</div>


<div class="row">	
  <div class="col-md-12 grid-margin stretch-card">
  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body">
	<h4 class="card-title mb-0">Design</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $DesignQtyCount;?> / <?php echo $designCompletedCount;?></h2>
	    </div>
	  </div>

	</div>
      </div>
    </div>
  </div>

  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body">
	<h4 class="card-title mb-0">Design Qc</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $DesignQcQtyCount;?>  / <?php echo $designqcCompletedCount;?></h2>
	    </div>
	  </div>

	</div>
      </div>
    </div>
  </div>

  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body">
	<h4 class="card-title mb-0">Printing</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $PrintingQtyCount;?> / <?php echo $printCompletedCount;?>   </h2>
	    </div>
	  </div>

	</div>
      </div>
    </div>
  </div>

  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body">
	<h4 class="card-title mb-0">Fusing</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $FusingQtyCount;?> / <?php echo $fusingCompletedCount;?> </h2>
	    </div>
	  </div>

	</div>
      </div>
    </div>
  </div>

  </div>
</div>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body">
	<h4 class="card-title mb-0">Bundling Qc</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $BundlingQtyCount;?> / <?php echo $bundlingCompletedCount ;?></h2>
	    </div>

	  </div>

	</div>
      </div>
    </div>
  </div>

  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body">
	<h4 class="card-title mb-0">Stitching</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"> <?php echo $StitchingQtyCount;?> / <?php echo $stitchingCount ;?> </h2>
	    </div>

	  </div>

	</div>
      </div>
    </div>
  </div>

  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body">
	<h4 class="card-title mb-0">Final Qc</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $FincalQcQtyCount ;?>/ <?php echo $finalQcCount;?></h2>
	    </div>
	  </div>

	</div>
      </div>
    </div>
  </div>

  <div class="col-md-3 grid-margin">
    <div class="card">
      <div class="card-body">
	<h4 class="card-title mb-0">Dispatch</h4>
	<div class="d-flex justify-content-between align-items-center">
	  <div class="d-inline-block pt-3">
	    <div class="d-md-flex">
	      <h2 class="mb-0"><?php echo $dispatchQtyCount;?>   </h2>
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
