<?php //print_r($_POST);
$unit_id=$this->input->post('unit_id');
$check_date=$this->input->post('check_date');
$production_start_date=date("Y-m-d", strtotime($check_date));
$production_start_date_strtotime= strtotime($production_start_date);

$dayLimit=1;
$datesRows=$this->schedule_model->get_productions_available_days_with_unit($production_start_date,$dayLimit,$unit_id);
//print_r($datesRows);
?>
<div class="row grid-margin">
<div class="col-12">
<div class="card">
<div class="card-body">
<h4 class="card-title"><?php echo $month_and_year=date("d F Y", strtotime($_POST['check_date']));?> <?php //print_r($non_working_days);?></h4>

<h5 class="mb-3" style="border-bottom: 1px solid #f2f2f2; ">Availability</h5>
	<?php if($datesRows){ 
	$dateLastRow=0;
	$calendar_id=$datesRows[$dateLastRow]['calendar_id'];
	$calendar_date=$datesRows[$dateLastRow]['calendar_date'];
	$production_end_date=$calendar_date;
	$unit_total_work_per=$datesRows[$dateLastRow]['unit_work'];
	$unit_working_capacity_in_sec=$datesRows[$dateLastRow]['unit_working_capacity_in_sec'];
	$system_working_capacity_sec=$datesRows[$dateLastRow]['system_working_capacity_sec'];
	
	$total_allocated_capacity=$unit_working_capacity_in_sec/$system_working_capacity_sec;
	$total_allocated_capacity_percentage=round( number_format( $total_allocated_capacity*100, 2 ));
	
	//--------------------------- new updates--------------
	$suid=$unit_id;
	$unit_calendar_date=$datesRows[$dateLastRow]['unit_calendar_date'];
	$sumRow=$this->schedule_model->get_sum_of_scheduled_order($unit_calendar_date,$suid);
	//echo $sumRow['SOS'];
	$scheduled_row_sec=$sumRow['SOS'];
	//-----------------------------------------------------
	$schedule_unit_percentage_sec=$scheduled_row_sec;
	//unit_working_capacity_in_sec
	if($schedule_unit_percentage_sec==""){
		$schedule_unit_percentage_sec=0;
	}
	//$expected_dispatch_date=strtotime($calendar_date);
	$blnce_scnd=$unit_working_capacity_in_sec-$schedule_unit_percentage_sec;
	//echo $unit_working_capacity_in_sec."<br/>";
	//echo $schedule_unit_percentage_sec."<br/>";
	//echo $blnce_scnd."<br/>";
	
	
	$AvailableCapacity1=$blnce_scnd/$system_working_capacity_sec;
	$AvailableCapacity=round( number_format( $AvailableCapacity1*100, 2 )); 
	?>
    
    <div class="card card-inverse-success mb-2">
    <div class="row">
    	
        <div class="card-body col-md-4" style="padding: 30px 30px;">
        <div class=" d-flex flex-row align-items-top">
        <i class="fa fa-calendar text-primary icon-md"></i>
        <div class="ml-3">
        <h6 class="text-primary"><?php echo date('M d, Y', strtotime($check_date));?></h6>
        <p class="mt-2 text-muted card-text"> Date</p>
        </div>
        </div>
        </div>
        
        
        
        <div class="card-body col-md-4" style="padding: 30px 30px;">
        <div class=" d-flex flex-row align-items-top">
        <i class="fa fa-thumbs-up text-success icon-md"></i>
        <div class="ml-3">
        <h6 class="text-success"><?php
		echo $AvailableCapacity;
		?>%</h6>
        <p class="mt-2 text-muted card-text">Available Capacity</p>
        </div>
        </div>
        </div>
    
        <div class="card-body col-md-4" style="padding: 30px 30px;">
        <div class=" d-flex flex-row align-items-top">
        <i class="fa fa-gavel text-warning icon-md"></i>
        <div class="ml-3">
        <h6 class="text-warning"><?php echo $total_allocated_capacity_percentage;?>%</h6>
        <p class="mt-2 text-muted card-text">Total Capacity </p>
        </div>
        </div>
        </div>
       
    </div>
    </div>
    <?php }else{ ?>
    <div class="card card-inverse-danger mb-5">
    <div class="row">
        <div class="card-body col-md-12" style="padding: 30px 30px;">
        <div class=" d-flex flex-row align-items-top">
        <i class="fa fa-calendar text-facebook icon-md"></i>
        <div class="ml-3">
        <h6 class="text-facebook">No records found!!!</h6>
		</div>
        </div>
        </div>
    </div>
    </div>
    <?php } ?>
    
</div>
</div>


</div>
</div>
