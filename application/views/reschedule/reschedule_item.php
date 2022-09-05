<div class="content-wrapper">
<div class="row profile-page">
    <div class="col-12">
    <div class="card">
    <div class="card-body">
    <span id="respo"></span>
    <?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
<?=$this->session->flashdata('error')?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
<?=$this->session->flashdata('success')?>
</div>
<?php endif; ?>
    
    <h4 class="card-title">RE SCHEDULE<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('reschedule/index');?>">LIST</a></span>
    </h4>
    <div class="profile-body" style="padding-top: 0px;">
    <ul class="nav tab-switch" role="tablist">
    
     <li class="nav-item">
    <a class="nav-link active" id="user-profile-info-tab" data-toggle="pill" href="#schedule" role="tab" aria-controls="schedule" aria-selected="true">Schedule Details</a>
    </li>
    
    <li class="nav-item">
    <a class="nav-link" id="user-profile-info-tab" data-toggle="pill" href="#user-profile-info" role="tab" aria-controls="user-profile-info" aria-selected="true">Order Details</a>
    </li>
   
    </ul>
    <div class="row">
    <div class="col-md-12">
    <div class="tab-content tab-body" id="profile-log-switch">
    	<div class="tab-pane fade show active pr-3" id="schedule" role="tabpanel" aria-labelledby="schedule">
        <?php //print_r($rejection_row);?>
        	<form name="rescheduleForm" id="rescheduleForm">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden"  name="schedule_department_id" id="schedule_department_id" value="<?php echo $rejection_row['schedule_department_id'];?>"/>
            <input type="hidden"  name="schedule_id" id="schedule_id" value="<?php echo $rejection_row['schedule_id'];?>"/>
            <input type="hidden"  name="order_id" id="order_id" value="<?php echo $rejection_row['order_id'];?>"/>
            <input type="hidden"  name="unit_id" id="unit_id" value="<?php echo $rejection_row['unit_id'];?>"/>
            <input type="hidden"  name="rs_design_id" id="rs_design_id" value="<?php echo $response['rs_design_id'];?>"/>
            
            
            <?php $arrayJson = json_decode($response['submitted_item'],true); ?>
            <?php
			$K=0;
			foreach($arrayJson as $jKey => $jValue){ 
				if($rejection_row['rej_summary_item_id']==$jValue['summary_id']){
					$jonline_ref_number='';
					if(isset($jValue['online_ref_number'])){
						$jonline_ref_number=$jValue['online_ref_number'];
					}
					?>
                    
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][summary_id]" value='<?php echo ucwords($jValue['summary_id']);?>' />
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][product_type]" value='<?php echo ucwords($jValue['product_type']);?>' />      
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][collar_type]" value='<?php echo ucwords($jValue['collar_type']);?>' /> 
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][sleeve_type]" value='<?php echo ucwords($jValue['sleeve_type']);?>' /> 
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][fabric_type]" value='<?php echo ucwords($jValue['fabric_type']);?>' /> 
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][addon_name]" value='<?php echo ucwords($jValue['addon_name']);?>' /> 
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][img_back]" value='<?php echo ucwords($jValue['img_back']);?>' /> 
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][img_front]" value='<?php echo ucwords($jValue['img_front']);?>' /> 
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][remark]" value='<?php echo ucwords($jValue['remark']);?>' /> 
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][orderno]" value='<?php echo ucwords($jValue['orderno']);?>' />
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][priority_name]" value='<?php echo ucwords($jValue['priority_name']);?>' /> 
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][priority_color_code]" value='<?php echo ucwords($jValue['priority_color_code']);?>' /> 
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][item_order_sec]" value='<?php echo ucwords($jValue['item_order_sec']);?>' /> 
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][item_order_total_sec]" value='<?php echo ucwords($jValue['item_order_total_sec']);?>' /> 
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][item_order_capacity]" value='<?php echo ucwords($jValue['item_order_capacity']);?>' /> 
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][item_order_qty]" value='<?php echo ucwords($jValue['item_order_qty']);?>' /> 
                     <input type="hidden" name="orderITEM[<?php echo $K;?>][item_unit_qty_input]" value='<?php echo ucwords($jValue['item_unit_qty_input']);?>' />
                    <input type="hidden" name="orderITEM[<?php echo $K;?>][online_ref_number]" value='<?php echo ucwords($jonline_ref_number);?>' />
                
               		<?php
				}
				$K++;
			}
			?>
            
            <table class="table">
            <thead>
            <tr>
            <th>No</th>
            <th>Department</th>
            <th>First Reschedule Date</th>
            <th>Status</th>
            </tr>
            </thead>
            <tbody>
            	
            	<?php
				$dayLimit=count($all_rej_rows);
				$unit_id=$rejection_row['unit_id'];
				//$production_start_date=date('Y-m-d', strtotime(' +1 day'));
				$production_start_date=date('Y-m-d');
				//$production_start_date1=date('d-m-Y', strtotime(' +1 day'));
				$production_start_date1=date('d-m-Y');
				?>
            	<?php 
				$datesRows=$this->schedule_model->get_productions_available_days_with_unit($production_start_date,$dayLimit,$unit_id);
				$datesRowsCount=count($datesRows);
				if($datesRowsCount==$dayLimit){
				?>
					<?php if($all_rej_rows){ $inc=0;$i=0;?>
                    <?php foreach($all_rej_rows as $RROW){ $i++; ?>
                        <?php  $SDROW=$this->reschedule_model->get_schedule_department_row($RROW['schedule_department_id']);?>
                        <?php if($SDROW['department_ids']!=""){ ?>
                        <?php  $depmt=$this->reschedule_model->get_production_department_names($SDROW['department_ids']);?>
                        <?php 
						if($rejection_row['re_schedule_status']==0){ 
							$dd=date('d-m-Y',strtotime($datesRows[$inc]['calendar_date']));
						}else{
							//$sql="SELECT * FROM sh_schedule_departments WHERE schedule_id='".$RROW['new_schedule_id']."' order by department_schedule_date ";   
							//echo $sql;
							//$query = $this->db->query($sql);					 
							//return $query->result_array();
							$dd=date('d-m-Y',strtotime($RROW['reschedule_date']));
						}
						?>
                        <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $depmt['DNAME'];?></td>
                        <td>
                        <?php
						$selected_date="";
						$minDate=date('d-m-Y');
						if($SDROW['department_ids']!=""){
							$department_ids_array=explode(',',$SDROW['department_ids']);
							if(in_array(8,$department_ids_array)){
								$selected_date="selected_date";
								$day_overview8="day_overview8";
							}else{
								$selected_date="datepicker";
								$day_overview8="";
							}
						}
						?>
<input type="text"  class="form-control  required <?php echo $selected_date;?>" value="<?php echo $dd;?>" readonly="readonly"  name="submittedData[<?php echo $i;?>][new_date]" id="new_date<?php echo $i;?>" />
                        
<input type="hidden"  class="form-control" value="<?php echo $SDROW['department_ids'];?>" name="submittedData[<?php echo $i;?>][department_ids]" />
<input type="hidden"  class="form-control" value="<?php echo $RROW['rej_order_id'];?>" name="submittedData[<?php echo $i;?>][rej_order_id]" />                       
<input type="hidden"  class="form-control" value="<?php echo $SDROW['schedule_department_id'];?>" name="submittedData[<?php echo $i;?>][schedule_department_id]" />

                       
                        </td>
                        <td id="<?php echo $day_overview8;?>">
                        <?php if($RROW['re_schedule_status']==1){ ?>
                        <label class="badge badge-success" >ReScheduled</label>
                        <?php }else if($RROW['re_schedule_status']==-1){?>
                        <label class="badge badge-warning" >ReSchedule In Draft</label>
                        <?php }else{ ?>
                        <label class="badge badge-danger" >Not ReScheduled</label>
                        <?php } ?>
                        
                        <?php
						if($SDROW['department_ids']!=""){
							//print_r($RROW); unit_id
							$department_ids_array=explode(',',$SDROW['department_ids']);
							if(in_array(8,$department_ids_array)){
								$choosed_date=date('Y-m-d',strtotime($RROW['reschedule_date']));
								$calender_date_info=$this->schedule_model->get_unit_calender_date_info($choosed_date,$RROW['unit_id']);
								$day_overview=$this->schedule_model->get_orders_under_date_and_depmt($choosed_date,8,$RROW['unit_id']);
								//echo 'ooo';
								if($calender_date_info){
									$system_working_capacity_sec=$calender_date_info['system_working_capacity_sec'];
									$unit_working_capacity_in_sec=$calender_date_info['unit_working_capacity_in_sec'];
									if($calender_date_info['unit_is_working']=='no'){
										echo '<div class="badge badge-danger"> <i class="fa fa-ban"></i> Non Working Day</div>';
									}else{
										echo '<div class="badge badge-success"><i class="fa fa-check"></i> Working Day</div>';
									}
								
								}else{
									echo '<div class="badge badge-danger">Calender Not Updated!!!</div>';
								}
								?>
                                <br />
                                <div class="border-top pt-3">
    <div class="row">
    <?php 
	$all_total=0;
	if($day_overview){?>
    	<?php
		$design_orders_count=0;
		
		foreach($day_overview as $sArray1){ 
			//$array1 = json_decode($sArray1['sh_order_json'],true);
			$array1 = json_decode($sArray1['scheduled_order_info'],true);
			
			if($array1) {
				foreach($array1 as $key1 => $value1){
					if($value1['item_unit_qty_input']!=0){
						$all_total+=$value1['item_order_sec']*$value1['item_unit_qty_input'];
					}
				}
			}
		}
	}else{
		$all_total=0;
	}
		//echo $all_total;
		
		if($calender_date_info['unit_calendar_id']!=""){
			//echo 'ccc';
			
			
			$total_allocated_capacity=$unit_working_capacity_in_sec/$system_working_capacity_sec;
			$total_allocated_capacity_percentage=round( number_format( $total_allocated_capacity*100, 2 ));
			
			
			$work_capacity=$all_total/$system_working_capacity_sec;
			$work_capacity_percentage=round( number_format( $work_capacity*100, 2 ));
			
		?>
        <div class="col-md-6 text-center">
        <h6><?php echo $total_allocated_capacity_percentage;?> %</h6>
        <p> Day Percentage</p>
        </div>
        
        <div class="col-md-6 text-center">
        <h6><?php echo $work_capacity_percentage;?> %</h6>
        <p>Works Percentage</p>
        </div>
        
        
        
        <?php } ?> 
	
    </div>
    </div>
                                <?php
								
							}
						}
						?>
                        
                        
                        
                        
                        
                        </td>
                        </tr>
                    <?php $inc++; }} ?>
                    	<tr>
                        <td></td>
                        <td>Status</td>
                        <td>
                        <select class="form-control required" id="re_schedule_status" name="re_schedule_status"  > 
                        <option value="">--- Select ---</option>
                        <option value="-1" <?php if($rejection_row['re_schedule_status']==-1){ echo 'selected="selected"';} ?>>Save To Draft</option>
                        <option value="1" <?php if($rejection_row['re_schedule_status']==1){ echo 'selected="selected"';} ?> >Publish</option>
                        </select>
						</td>
                        <td></td>
                        </tr>
                        
                        <?php if($rejection_row['re_schedule_status']!=1){ ?>
                    	<tr>
                        <td colspan="4"><button type="submit" style="margin-top:30px; width:100%" class="btn btn-success text-center submitScheduleData" id="submitScheduleData" name="submitScheduleData"  value="submitScheduleData" ><i class="fa fa-save"></i> Save ReSchedule Details</button></td>
                        </tr>
                        <?php } ?>
                    <?php } ?>
                    
                    
						<?php $disDates=$this->schedule_model->get_all_disabiled_days_d_m_y(date('Y-m-d')); ?>
                        <script>
                        $('.datepicker').datepicker({
                        autoclose: true,
                        format: 'dd-mm-yyyy',
                        startDate: "<?php echo $production_start_date1;?>",
                        <?php if($disDates!=""){ ?>
                        datesDisabled:"<?php echo $disDates['CDATE'];?>"
                        <?php } ?>
                        });
						
                        </script>
                    
                 <?php }else{ ?>
                 <tr>
                 <td colspan="4">
                 	<div class="card card-inverse-danger mb-5">
                    <div class="row">
                        <div class="card-body col-md-12" style="padding: 30px 30px;">
                        <div class=" d-flex flex-row align-items-top">
                        <i class="fa fa-calendar text-facebook icon-md"></i>
                        <div class="ml-3">
                        <h6 class="text-facebook">Date Not Available</h6>
                        <p class="mt-2 text-muted card-text">Please Create  Or update Production Calender</p>
                        </div>
                        </div>
                        </div>
                    </div>
                    </div>
                 </td>
                 </tr>
                 <?php } ?>
            	
            </tbody>
            </table></form>
        </div>
        <?php include('details.php');?>
        <?php //print_r($rejection_row);?>
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
$('.selected_date').datepicker({
	autoclose: true,						   
	format: 'dd-mm-yyyy',
	startDate: "<?php echo $minDate;?>",
	<?php if($disDates!=""){ ?>
	datesDisabled:"<?php echo $disDates['CDATE'];?>",
	<?php } ?>
	})
    .on('changeDate', function(e,dateText){
		$("#day_overview8").html("Loading...");					   
    	var date = $(this).val();
   		var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&choosed_date="+date+"&did=<?php echo '8';?>&uid=<?php echo $rejection_row['unit_id'];?>&scheduled_date=<?php echo date('d-m-Y', strtotime($rejection_row['reschedule_date']));?>";
	
		$.ajax({  
		type: "POST",
		url: "<?= base_url("reschedule/day_overview_stiching/");?>",  
		data: formData,
		beforeSend: function(){ $('#day_overview').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>'); },
		success: function(response){
		$("#day_overview8").html(response);
		}
		}); 
});


</script>

<script>
$(document).ready(function() { 
	//$( ".selected_date" ).datepicker();				   
						   

	
						   
	$("#rescheduleForm").validate({
	highlight: function(element) {
	$(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
	},
	unhighlight: function(element) {
	$(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid');
	},
	errorElement: 'p',
	errorClass: 'text-danger',
	errorPlacement: function(error, element) {
	if (element.parent('.input-group').length || element.parent('label').length) {
	error.insertAfter(element.parent());
	} else {
	error.insertAfter(element);
	}
	},
	submitHandler: function() {
	$("#submitScheduleData").attr("disabled", "disabled");
	$('#submitScheduleData').html("Please Wait ...");
	$.post('<?= base_url("reschedule/save_schedule/");?>', $("#rescheduleForm").serialize(), function(data) {
																								
		var dataRs = jQuery.parseJSON(data);
		//$("#submitDataa").delay("slow").fadeIn();
		//$('#submitDataa').html("Save");
		//$('#submitDataa').removeAttr("disabled");
		if(dataRs.responseCode=="success"){
			$('#respo').html(dataRs.responseMsg);
			$('#submitScheduleData').html("Successfully saved");
		}else{
			$('#respo').html(dataRs.responseMsg);
			$('#submitDataa').removeAttr("disabled");
			$('#submitScheduleData').html('<i class="fa fa-save"></i> Save ReSchedule Details');
		}
		//$( '#calenderData' ).each(function(){this.reset();});
		
	});	
	}
	
	});
});
</script>