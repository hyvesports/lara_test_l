<script>



$(document).ready(function() { 
//--------------------------------------------------------------------	

	$('#summaryModel').on('show.bs.modal', function (event) {
	
	
	var button = $(event.relatedTarget);
	var ps=button.data('ps');
	var pe=button.data('pe');
	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&ps="+ps+"&pe="+pe;
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("orders/schedule_summary/");?>",  
	data: formData,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-cog fa-spin"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 
	});
						   
//--------------------------------------------------------------------						   
$("#scheduleForm").validate({
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
submitHandler: function() {//

$(".submitSheduleData").attr("disabled", "disabled");
$('#submitSheduleData').html("Please Wait ...");
$('#formResp').html('<div class="alert alert-warning alert-dismissible text-center mt-2" style="width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Saving...</div>');

$.post('<?= base_url("orders/save_schedule/");?>', $("#scheduleForm").serialize(), function(data) {
	var dataRs = jQuery.parseJSON(data);
	
	if(dataRs.responseCode=="F"){
		$('#formResp').html(dataRs.responseMsg);
		return false;
	}else{
		if(dataRs.nxtForm=="no"){
			setTimeout(function() {
			  window.location.href ="<?php echo base_url();?>orders/online";
			}, 1000);
		}else{
			
			$("#schedule_id").val(dataRs.schedule_id);
			$("#production_start_date").val(dataRs.schedule_date);
			$("#unit_id").val(dataRs.unit_id);
			
			$.toast({
			  heading: 'Success',
			  text: 'Please wait...Redirecting to next auto scheduling form...!!.',
			  showHideTransition: 'slide',
			  icon: 'success',
			  loaderBg: '#f96868',
			  position: 'top-center'
			});
			
			$('#formResp').html('<div class="alert alert-success alert-dismissible text-center mt-1" style="width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Please wait...Redirecting to next auto scheduling form...!!</div>');
			
			setTimeout(
			function() 
			{
				$('#scheduleContent').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
				$.post('<?= base_url("orders/online_schedule_timeline/");?>', $("#scheduleInputForm").serialize(), function(data) {
					$("#scheduleContent").html(data);
				});	
				
			}, 5000);
		}
	}
	$("#submitSheduleData").delay("slow").fadeIn();
	$('#submitSheduleData').html("Save");
	//$('#submitSheduleData').removeAttr("disabled");
	
	
	
});	
}
});
});



function calculateProduction(current_row,unit_id){
	//alert("In"+current_row);
	//$('#submitData').removeAttr("disabled");
	var item_order_qty_row=$("#item_order_qty"+current_row).val();
	var qty=$("#item_unit_qty_"+unit_id+'_'+current_row).val();
	var intRegex = /^\d+$/;
	var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
	if(intRegex.test(qty) ) {
	}else{
		//alert("Invalid Number");
		$("#item_unit_qty_"+unit_id+'_'+current_row).val(0);
		swal({
		text: 'Enter a valid number',
		button: {
		text: "OK",
		value: true,
		visible: true,
		className: "btn btn-primary"
		}
		});
		return false;
	}
	var line_total_qty=0;
	$(".current_row_"+current_row).each(function(){
		//alert($(this).val());
		if(intRegex.test($(this).val()) ) {
			// It is a number
			line_total_qty += parseInt( $(this).val() );
		}
	});
	//alert(total_unit_capacity);
	if(line_total_qty>item_order_qty_row){
		
		swal({
		text: 'Enter a valid quantity',
		button: {
		text: "OK",
		value: true,
		visible: true,
		className: "btn btn-primary"
		}
		});

		$("#item_unit_qty_"+unit_id+'_'+current_row).css("background", "red");
		$("#item_unit_qty_"+unit_id+'_'+current_row).val("");
		//$("#submitData").attr("disabled", "disabled"); //$('#submitDataa').removeAttr("disabled");
		return false;
	}
	//$('#submitDataa').removeAttr("disabled");
	$("#item_unit_qty_"+unit_id+'_'+current_row).css("background", "white");
	var unit_capacity=$("#day_avilabile_unit_capaciy_sec_"+unit_id).val();
	var unit_sec=$("#item_order_sec"+current_row).val();
	
	
	
	var total_req_capacity=parseInt(unit_sec)*parseInt(qty);
	//alert(total_req_capacity);
	if(total_req_capacity>unit_capacity){
		//alert("Production capacity reached maximum... please change item quantity!!!");
		$("#item_unit_qty_"+unit_id+'_'+current_row).val(0);
		swal({
		text: 'Production capacity reached maximum... please change item quantity!!!',
		button: {
		text: "OK",
		value: true,
		visible: true,
		className: "btn btn-primary"
		}
		});
		return false;
	}
	//
	var total_unit_capacity=0;
	var inc=0;
	$(".unit_class_"+unit_id).each(function(){	
			var item_unit_qty=parseInt($("#item_unit_qty_"+unit_id+"_"+inc).val());
			if(item_unit_qty>0){
				var item_order_sec=parseInt($("#item_order_sec"+inc).val());
				total_unit_capacity+=parseInt(item_order_sec)*parseInt(item_unit_qty);
			}
		inc++;
		
	});
	var day_unit_pe;
	var day_avilabil_capcity_sec=parseInt($("#day_avilabil_capcity_sec").val());
	total_unit_capacity_division=parseInt(total_unit_capacity, 10)*100;
	day_unit_per=parseInt(total_unit_capacity_division, 10) / parseInt(day_avilabil_capcity_sec, 10);
	day_unit_per=Math.round(day_unit_per);
	$("#unit_per_span_"+unit_id).html(day_unit_per+"%");
	
	//alert(total_unit_capacity);
	$("#total_order_seconds").val(total_unit_capacity);
	if(parseInt(total_unit_capacity)>unit_capacity){
		//alert("Production capacity reached maximum... please change item quantity!!!");
		$("#item_unit_qty_"+unit_id+'_'+current_row).val(0);
		swal({
		text: 'Production capacity reached maximum... please change item quantity!!!',
		button: {
		text: "OK",
		value: true,
		visible: true,
		className: "btn btn-primary"
		}
		});
		return false;
	}
	// 
	var incc=0;
	var all_item_unit_qty;
	
	var grad_total_unit_capacity=0;
	var order_total_qty=0;
	var order_input_qty=0;
	$(".all_items_class").each(function(){	
		var cid=$(this).attr("cid");
		var oqty=$(this).attr("oqty");
		order_total_qty+=parseInt(oqty);
		
		all_item_unit_qty= parseInt( $(this).val());
		//alert(cid);
		if(intRegex.test(all_item_unit_qty) ) {
			//alert(all_item_unit_qty);
			 order_input_qty+=parseInt(all_item_unit_qty);
			var all_item_order_sec=parseInt($("#item_order_sec"+cid).val());
			grad_total_unit_capacity+=all_item_order_sec*all_item_unit_qty;
		}
		incc++;
	});
	//alert(order_total_qty+":"+order_input_qty);
	var qty_balance;
	qty_balance=parseInt(order_total_qty)-parseInt(order_input_qty);
	
	//alert(qty_balance);
	$("#order_total_qty").val(order_total_qty);
	$("#order_total_submitted_qty").val(order_input_qty);
	$("#order_balance_qty").val(qty_balance);	
	
	grad_total_unit_capacity1=parseInt(grad_total_unit_capacity, 10)*100;
	var all_capacity=parseInt(grad_total_unit_capacity1, 10) / parseInt(day_avilabil_capcity_sec, 10);
	all_capacity=Math.round(all_capacity);
	$("#all_capacity_span").html(all_capacity+"%");	
	
	if(parseInt(grad_total_unit_capacity)>day_avilabil_capcity_sec){
		$("#item_unit_qty_"+unit_id+'_'+current_row).val(0);
		swal({
		text: 'Production capacity reached maximum... please change item quantity!!!',
		button: {
		text: "OK",
		value: true,
		visible: true,
		className: "btn btn-primary"
		}
		});
		return false;
	}
	
	var total_order_sec=<?php echo $total_order_sec;?>;
	var blnce=parseInt(total_order_sec)-parseInt(grad_total_unit_capacity);
	blnce1=parseInt(blnce, 10)*100;
	var blnce_per=parseInt(blnce1, 10) / parseInt(day_avilabil_capcity_sec, 10);
	blnce_per=Math.round(blnce_per);
	//alert(blnce_per);
	$("#blnce_capacity_span").html(blnce_per+"%");
	if(parseInt(grad_total_unit_capacity)==0)
	{
		//alert('ts');
		$('.submitSheduleData').prop("disabled", true);
	}else{
		$('.submitSheduleData').prop("disabled", false);
	}
	
}


</script>