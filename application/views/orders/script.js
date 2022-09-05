// JavaScript Document
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
	$(".all_items_class").each(function(){	
		var cid=$(this).attr("cid");
		all_item_unit_qty= parseInt( $(this).val() );
		//alert(cid);
		if(intRegex.test(all_item_unit_qty) ) {
			//alert(incc);
			 
			var all_item_order_sec=parseInt($("#item_order_sec"+cid).val());
			grad_total_unit_capacity+=all_item_order_sec*all_item_unit_qty;
		}
		incc++;
	});
	//alert(all_item_unit_qty);
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

