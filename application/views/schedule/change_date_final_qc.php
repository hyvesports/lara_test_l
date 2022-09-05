<div class="modal-body" >
<?php 
$orderArray=$this->schedule_model->get_orders_under_date_and_depmt_latest($_POST['CD'],$_POST['did'],$_POST['UID'],$sdepartment['schedule_department_id']); ?>
<?php //print_r($orderArray);?>

<?php 
//$arrayItems = json_decode($order_row['sh_order_json'],true);
$is_dispatch=0;
$nextDepatartment="";
if( $_POST['did']==4){ // design

	//echo 'design';
	$nextDepatartment=5;
	$minDate=date('d-m-Y');
	$nextRowArray=$this->schedule_model->get_next_department_and_date($nextDepatartment,$sdepartment['order_id'],$sdepartment['unit_id'],$sdepartment['department_schedule_date']);
	$maxDate=date('d-m-Y', strtotime($sdepartment['department_schedule_date']));
	if(isset($nextRowArray)){
	$maxDate=date('d-m-Y', strtotime($nextRowArray['department_schedule_date']));
	}
}else if($_POST['did']==5){ //printing
	//4
	$pRowArray=$this->schedule_model->get_previous_department_and_date(4,$sdepartment['order_id'],$sdepartment['unit_id'],$sdepartment['department_schedule_date']);
	$minDate=date('d-m-Y');
	if(isset($pRowArray['department_schedule_date'])){
	$minDate=date('d-m-Y', strtotime($pRowArray['department_schedule_date']));
	}
	$nextDepatartment=6;
	$nextRowArray=$this->schedule_model->get_next_department_and_date($nextDepatartment,$sdepartment['order_id'],$sdepartment['unit_id'],$sdepartment['department_schedule_date']);
	$maxDate=date('d-m-Y', strtotime($nextRowArray['department_schedule_date']));
	
}else if($_POST['did']==6){ //fusing

	$pRowArray=$this->schedule_model->get_previous_department_and_date(5,$sdepartment['order_id'],$sdepartment['unit_id'],$sdepartment['department_schedule_date']);
	//$minDate=date('d-m-Y', strtotime($pRowArray['department_schedule_date']));
	
	$minDate=date('d-m-Y');
	if(isset($pRowArray['department_schedule_date'])){
	$minDate=date('d-m-Y', strtotime($pRowArray['department_schedule_date']));
	}
	
	$nextDepatartment=12;
	$nextRowArray=$this->schedule_model->get_next_department_and_date($nextDepatartment,$sdepartment['order_id'],$sdepartment['unit_id'],$sdepartment['department_schedule_date']);
	$maxDate=date('d-m-Y', strtotime($nextRowArray['department_schedule_date']));
}else if($_POST['did']==12){ //bundling
	$pRowArray=$this->schedule_model->get_previous_department_and_date(6,$sdepartment['order_id'],$sdepartment['unit_id'],$sdepartment['department_schedule_date']);
	$minDate=date('d-m-Y', strtotime($pRowArray['department_schedule_date']));
	$nextDepatartment=8;
	$nextRowArray=$this->schedule_model->get_next_department_and_date($nextDepatartment,$sdepartment['order_id'],$sdepartment['unit_id'],$sdepartment['department_schedule_date']);
	$maxDate=date('d-m-Y', strtotime($nextRowArray['department_schedule_date']));
}else if($_POST['did']==8){ //
	//echo 'stitching';
	$pRowArray=$this->schedule_model->get_previous_department_and_date(12,$sdepartment['order_id'],$sdepartment['unit_id'],$sdepartment['department_schedule_date']);
	$minDate=date('d-m-Y', strtotime($pRowArray['department_schedule_date']));
	$nextDepatartment=10;
	
	$nextRowArray=$this->schedule_model->get_next_department_and_date($nextDepatartment,$sdepartment['order_id'],$sdepartment['unit_id'],$sdepartment['department_schedule_date']);
	$maxDate=date('d-m-Y', strtotime($sdepartment['department_schedule_date']));
	if(isset($nextRowArray)){
	$maxDate=date('d-m-Y', strtotime($nextRowArray['department_schedule_date']));
	}
}else if($_POST['did']==10){ //
	//echo 'stitching';
	$pRowArray=$this->schedule_model->get_previous_department_and_date_for_qc(13,$sdepartment['order_id'],$sdepartment['unit_id']);
	$minDate=date('d-m-Y', strtotime($sdepartment['department_schedule_date']));
	if($pRowArray){
	$minDate=date('d-m-Y', strtotime($pRowArray['department_schedule_date']));
	}
	$nextDepatartment=10;
	//$maxDate=
	$is_dispatch=1;
	
	$nextRowArray=$this->schedule_model->get_next_department_and_date($nextDepatartment,$sdepartment['order_id'],$sdepartment['unit_id'],$sdepartment['department_schedule_date']);
	$maxDate=date('d-m-Y', strtotime($sdepartment['department_schedule_date']));
	if(isset($nextRowArray)){
	$maxDate=date('d-m-Y', strtotime($nextRowArray['department_schedule_date']));
	}
	$date = strtotime($maxDate);
	$date = strtotime("+7 day", $date);
	$maxDate=date('d-m-Y', $date);
	
	
}else if($_POST['did']==13){
	$pRowArray=$this->schedule_model->get_previous_department_and_date_for_qc(8,$sdepartment['order_id'],$sdepartment['unit_id']);
	$minDate=date('d-m-Y', strtotime($sdepartment['department_schedule_date']));
	if($pRowArray){
	$minDate=date('d-m-Y', strtotime($pRowArray['department_schedule_date']));
	}
	$nextDepatartment=10;
	//$maxDate=
	$is_dispatch=1;
	
	$nextRowArray=$this->schedule_model->get_next_department_and_date($nextDepatartment,$sdepartment['order_id'],$sdepartment['unit_id'],$sdepartment['department_schedule_date']);
	$maxDate=date('d-m-Y', strtotime($sdepartment['department_schedule_date']));
	if(isset($nextRowArray)){
	$maxDate=date('d-m-Y', strtotime($nextRowArray['department_schedule_date']));
	}
	$date = strtotime($maxDate);
	$date = strtotime("+7 day", $date);
	$maxDate=date('d-m-Y', $date);
}


//echo $pRowArray['department_schedule_date'];
//print_r($nextRowArray);

?>
<form name="changeDateForm" id="changeDateForm">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<input type="hidden" name="SD" id="SD" value="<?php echo $this->input->post('SD');?>" />
<input type="hidden" name="ED" id="ED" value="<?php echo $this->input->post('ED');?>" />
<input type="hidden" name="UID" id="UID" value="<?php echo $this->input->post('UID');?>" />
<input type="hidden" name="schedule_department_id" id="schedule_department_id" value="<?php echo $sdepartment['schedule_department_id'];?>" />
<input type="hidden" name="schedule_id" id="schedule_id" value="<?php echo $sdepartment['schedule_id'];?>" />
<input type="hidden" name="order_id" id="order_id" value="<?php echo $sdepartment['order_id'];?>" />
<input type="hidden" name="department_id" id="department_id" value="<?php echo $_POST['did'];?>" />
<input type="hidden" name="batch_number" id="batch_number" value="<?php echo $sdepartment['batch_number'];?>" />
<input type="hidden" name="is_dispatch" id="is_dispatch" value="<?php echo $is_dispatch;?>" />
<input type="hidden" name="is_re_scheduled" id="is_re_scheduled" value="<?php echo $sdepartment['is_re_scheduled'];?>" />
<div class="row">

<div class="col-md-7 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">Order Items</h4>
    <table class="table">
    <thead>
    <tr>
    <th></th>
    <th>Order</th>
    <th class="text-center">Order Quantity</th>
    <th class="text-center">Change Quantity</th>
    <th class="text-center">Balance Quantity</th>
    </tr>
    </thead>
    <tbody>
    <?php 
	$K=0;
	if($orderArray){ $order_total_qty=0;?>
    <?php foreach($orderArray as $ITEM){?>
    	<?php $rej_items_array=explode(',',$ITEM['rej_items']); ?>
        <?php $arrayJson = json_decode($ITEM['scheduled_order_info'],true); ?>
        <?php foreach($arrayJson as $jKey => $jValue){  //1.start
		$jonline_ref_number='';
		if(isset($jValue['online_ref_number'])){ $jonline_ref_number=$jValue['online_ref_number']; }
		?>
<input type="hidden" name="changeDate[<?php echo $K;?>][summary_id]" value='<?php echo ucwords($jValue['summary_id']);?>' />
<input type="hidden" name="changeDate[<?php echo $K;?>][product_type]" value='<?php echo ucwords($jValue['product_type']);?>' />      
<input type="hidden" name="changeDate[<?php echo $K;?>][collar_type]" value='<?php echo ucwords($jValue['collar_type']);?>' /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][sleeve_type]" value='<?php echo ucwords($jValue['sleeve_type']);?>' /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][fabric_type]" value='<?php echo ucwords($jValue['fabric_type']);?>' /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][addon_name]" value='<?php echo ucwords($jValue['addon_name']);?>' /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][img_back]" value='<?php echo ucwords($jValue['img_back']);?>' /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][img_front]" value='<?php echo ucwords($jValue['img_front']);?>' /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][remark]" value='<?php echo ucwords($jValue['remark']);?>' /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][orderno]" value='<?php echo ucwords($jValue['orderno']);?>' />
<input type="hidden" name="changeDate[<?php echo $K;?>][priority_name]" value='<?php echo ucwords($jValue['priority_name']);?>' /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][priority_color_code]" value='<?php echo ucwords($jValue['priority_color_code']);?>' /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][item_order_sec]" value='<?php echo ucwords($jValue['item_order_sec']);?>' /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][item_order_total_sec]" value='<?php echo ucwords($jValue['item_order_total_sec']);?>' /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][item_order_capacity]" value='<?php echo ucwords($jValue['item_order_capacity']);?>' id="New_item_order_capacity<?php echo $K;?>"  /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][item_order_qty]" value='<?php echo ucwords($jValue['item_order_qty']);?>' id="New_item_order_qty<?php echo $K;?>" /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][online_ref_number]" value='<?php echo ucwords($jonline_ref_number);?>' />

<input type="hidden" name="orginalData[<?php echo $K;?>][summary_id]" value='<?php echo ucwords($jValue['summary_id']);?>' />
<input type="hidden" name="orginalData[<?php echo $K;?>][product_type]" value='<?php echo ucwords($jValue['product_type']);?>' />      
<input type="hidden" name="orginalData[<?php echo $K;?>][collar_type]" value='<?php echo ucwords($jValue['collar_type']);?>' /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][sleeve_type]" value='<?php echo ucwords($jValue['sleeve_type']);?>' /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][fabric_type]" value='<?php echo ucwords($jValue['fabric_type']);?>' /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][addon_name]" value='<?php echo ucwords($jValue['addon_name']);?>' /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][img_back]" value='<?php echo ucwords($jValue['img_back']);?>' /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][img_front]" value='<?php echo ucwords($jValue['img_front']);?>' /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][remark]" value='<?php echo ucwords($jValue['remark']);?>' /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][orderno]" value='<?php echo ucwords($jValue['orderno']);?>' />
<input type="hidden" name="orginalData[<?php echo $K;?>][priority_name]" value='<?php echo ucwords($jValue['priority_name']);?>' /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][priority_color_code]" value='<?php echo ucwords($jValue['priority_color_code']);?>' /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][item_order_sec]" value='<?php echo ucwords($jValue['item_order_sec']);?>' /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][item_order_total_sec]" value='<?php echo ucwords($jValue['item_order_total_sec']);?>' /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][item_order_capacity]" value='<?php echo ucwords($jValue['item_order_capacity']);?>' id="OD_item_order_capacity<?php echo $K;?>"  /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][item_order_qty]" value='<?php echo ucwords($jValue['item_order_qty']);?>'  id="OD_item_order_qty<?php echo $K;?>" /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][online_ref_number]" value='<?php echo ucwords($jonline_ref_number);?>' />         
        <?php
		
		
		if($jValue['item_unit_qty_input']!=0){ //2.start
			if(!in_array($jValue['summary_id'], $rej_items_array)){ // rej start //3.start
				$dispatchArray=$this->common_model->check_is_dispatched($sdepartment['order_id'],$jValue['summary_id']);
				if(!isset($dispatchArray)){ //4.start
				?>
                <tr>
                <td>
                <div class="disc" style="background-color:<?php echo $jValue['priority_color_code'];?>"></div>
                </td>
                <td>
                <h4 class="text-primary font-weight-normal"><?php echo ucwords($jValue['product_type']);?></h4>
                <p class="text-muted mb-0">Ref No: <?php echo ucwords($jonline_ref_number);?></p>
                </td>
                <?php $order_total_qty+=$jValue['item_unit_qty_input'];?>
                <td class="text-center"><?php echo ucwords($jValue['item_unit_qty_input']);?>
<input type="hidden" name="orginalData[<?php echo $K;?>][item_order_capacity]" value='<?php echo ucwords($jValue['item_order_capacity']);?>' id="OD_item_order_capacity<?php echo $K;?>" /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][item_order_qty]" value='<?php echo ucwords($jValue['item_order_qty']);?>' id="OD_item_order_qty<?php echo $K;?>" /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][item_unit_qty_input]" value='<?php echo ucwords($jValue['item_unit_qty_input']);?>' /> 


			
                </td>
                <td>
                
<input type="hidden" name="changeDate[<?php echo $K;?>][item_order_capacity]" value='<?php echo ucwords($jValue['item_order_capacity']);?>' id="New_item_order_capacity<?php echo $K;?>" /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][item_order_qty]" value='<?php echo ucwords($jValue['item_order_qty']);?>' id="New_item_order_qty<?php echo $K;?>" />
                
<input type="number" class="form-control text-center required digits item_unit_qty_input" name="changeDate[<?php echo $K;?>][item_unit_qty_input]" id="item_unit_qty_input<?php echo $K;?>" 
                min='0' max='<?php echo ucwords($jValue['item_unit_qty_input']);?>' onkeyup="get_balance_qty('<?php echo $K;?>',this.value,'<?php echo ucwords($jValue['item_unit_qty_input']);?>');" onchange="get_balance_qty('<?php echo $K;?>',this.value,'<?php echo ucwords($jValue['item_unit_qty_input']);?>');"/>
                
                
                </td>
                <td>
                <input type="text" class="form-control text-center required digits" name="orginalData[<?php echo $K;?>][item_unit_qty_input]" id="item_unit_qty_input1<?php echo $K;?>" readonly min='0' max='<?php echo ucwords($jValue['item_unit_qty_input']);?>'  value="0"/>
                </td>
                </tr>
        		<?php
				} //4.end
			} //3.end
		}else{ //2.end
			?>
<input type="hidden" name="orginalData[<?php echo $K;?>][item_order_capacity]" value='<?php echo ucwords($jValue['item_order_capacity']);?>' id="OD_item_order_capacity<?php echo $K;?>" /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][item_order_qty]" value='<?php echo ucwords($jValue['item_order_qty']);?>' id="OD_item_order_qty<?php echo $K;?>" /> 
<input type="hidden" name="orginalData[<?php echo $K;?>][item_unit_qty_input]" id="item_unit_qty_input1<?php echo $K;?>" readonly min='0' max='<?php echo ucwords($jValue['item_unit_qty_input']);?>'  value="0"/>


<input type="hidden" name="changeDate[<?php echo $K;?>][item_order_capacity]" value='<?php echo ucwords($jValue['item_order_capacity']);?>' id="New_item_order_capacity<?php echo $K;?>" /> 
<input type="hidden" name="changeDate[<?php echo $K;?>][item_order_qty]" value='<?php echo ucwords($jValue['item_order_qty']);?>' id="New_item_order_qty<?php echo $K;?>" />
<input type="hidden" name="changeDate[<?php echo $K;?>][item_unit_qty_input]" id="item_unit_qty_input1<?php echo $K;?>" readonly min='0' max='<?php echo ucwords($jValue['item_unit_qty_input']);?>'  value="0"/>
            
            <?php
		}
		$K++;
		} //1.end
		?>
    <?php } ?>
    <?php } ?>
    
    
    
    
    </tbody>
    </table>
</div>
</div>
</div>
<div class="col-md-5 ">



<div class="card">
<div class="card-body ">
<span id="changeDateFormResp"></span>
<h4 class="card-title">Order Dates</h4>
	<div class="form-group row">
    <label for="exampleInputEmail2" class="col-sm-4 col-form-label">Scheduled Date</label>
    <div class="col-sm-8">
    <input type="text" class="form-control required" id="scheduled_date"  name="scheduled_date" placeholder="scheduled_date" value="<?php echo date('d-m-Y', strtotime($sdepartment['department_schedule_date']));?>" readonly="readonly">
    </div>
    </div>
    
    <div class="form-group row">
    <label for="exampleInputMobile" class="col-sm-4 col-form-label">New Date <span class="text-danger">*</span></label>
    <div class="col-sm-8">
    <input type="text" class="form-control required" id="selected_date" name="selected_date" readonly="readonly" >
    </div>
    </div>
    <input type="hidden" name="order_total_qty" id="order_total_qty"  value="<?php echo $order_total_qty;?>"/>
    <input type="hidden" name="input_total_qty" id="input_total_qty" />
    <input class="btn btn-primary float-right" type="submit" value="Submit" id="submit" name="submit">
        <?php //echo $minDate."::". $maxDate;?>
<div>

</div> 
</div>
</div>


<div class="card" id="day_overview"></div>

</div>
</div>
</form>
</div>
<script type="text/javascript" src="<?php echo base_url() ?>public/moment.min.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url() ?>public/daterangepicker.css" />
<script type="text/javascript" src="<?php echo base_url() ?>public/daterangepicker.js"></script>

<script type="text/javascript">

function get_balance_qty(current_row,row_value,old_value){
	//alert(current_row);
	var intRegex = /^\d+$/;
	var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
	if(intRegex.test(row_value) ) {
		var balaceQty=parseInt(old_value)-parseInt(row_value);
		$("#OD_item_order_capacity"+current_row).val(balaceQty);
		$("#OD_item_order_qty"+current_row).val(balaceQty);
		
		$("#New_item_order_capacity"+current_row).val(row_value);
		$("#New_item_order_qty"+current_row).val(row_value);
		$("#item_unit_qty_input1"+current_row).val(balaceQty);
		var line_total_qty=0;
		$(".item_unit_qty_input").each(function(){
		//alert($(this).val());
			if(intRegex.test($(this).val()) ) {
				// It is a number
				//alert("Ok");
				line_total_qty += parseInt( $(this).val() );
			}
		});
		//alert(line_total_qty);
		$("#input_total_qty").val(line_total_qty);
		var order_total_qty=<?php echo $order_total_qty;?>;
		//alert(order_total_qty);
		
		if(parseInt(line_total_qty)>parseInt(order_total_qty)){
			$('#submit').prop("disabled", true);
		}else if(parseInt(line_total_qty)<1){
			$('#submit').prop("disabled", true);
		}else{
			$('#submit').prop("disabled", false);
		}
	}else{
		alert("Invalid Number");
		return false;
	}
}
   $(function() {
			  $('#submit').prop("disabled", true);
      $('#selected_date').daterangepicker({
         autoApply: true,
		 
		locale: {format: 'DD-MM-YYYY'},
		singleDatePicker: true,
		showDropdowns: false,
		startDate:"<?php echo $minDate;?>",
		minDate: "<?php echo $minDate;?>",
		maxDate: "<?php echo $maxDate;?>"
      }, 
     function() {
        var date = $('#selected_date').data('daterangepicker').startDate.format('YYYY-MM-DD');
		var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&choosed_date="+date+"&did=<?php echo $_POST['did'];?>&uid=<?php echo $_POST['UID'];?>";
		$.ajax({  
		type: "POST",
		url: "<?= base_url("schedule/day_overview/");?>",  
		data: formData,
			
			success: function(response){
			//$("#day_overview").html(response);
			
			}
		}); 
		
    });
  });
</script>

<script type="text/javascript">
$(function() {
	
	
	$('#changeDate').on('hidden.bs.modal', function () {
    	// do somethin
		//alert("okkk");
		//_________________________________________
		
		var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&start_date=<?php echo $this->input->post('SD');?>&end_date=<?php echo $this->input->post('ED');?>&unit_id=<?php echo $this->input->post('UID');?>";
		
		$.ajax({  
		type: "POST",
		url: "<?= base_url("orders/overview_result/");?>",  
		data: formData,
			beforeSend: function(){ $('#scheduleContent').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>'); },
			success: function(response){
			$("#scheduleContent").html(response);
			
			}
		}); 
		
		//_________________________________________
	});
	
	$("#changeDateForm").validate({
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
	//$("#submitDataModel").attr("disabled", "disabled");
	$('#submitDataModel').html("Please Wait ...");
	//$('#response').html('<font class="text-yellow">Checking.Please wait..</font>');
	//$('#modelResp').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Saving...</p>');
	$.post('<?= base_url("schedule/change_date_post_fqc/");?>', $("#changeDateForm").serialize(), function(data) {
																								
		var dataRs = jQuery.parseJSON(data);
		//$("#submitDataa").delay("slow").fadeIn();
		//$('#submitDataa').html("Save");
		//$('#submitDataa').removeAttr("disabled");
		if(dataRs.responseCode=="success"){
		$('#changeDateForm').html(dataRs.responseMsg);
		}else{
			$('#changeDateFormResp').html(dataRs.responseMsg);
		}
		//$( '#calenderData' ).each(function(){this.reset();});
		
	});	
	}
	});	

});
</script>



