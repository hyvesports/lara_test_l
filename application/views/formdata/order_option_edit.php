<h5 class="card-title">Order Options</h5>
<div class="form-group row">
<div class="col-md-12">
<div class="form-group row">
<table class="table table-striped mb-0" width="100%">
<thead>
<tr class="item_header">
<th width="20%"  class="text-left">Name</th>
<th width="10%"  class="text-left">Number</th>
<th width="10%"  class="text-left">Size</th>
<th width="10%"  class="text-left">Fit Type</th>
<th width="10%"  class="text-center">Qty</th>
<th width="30%"  class="text-center">Customer info </th>
<th width="0%"></th>
</tr>
</thead>
<tbody id="optionRowTr">
<?php //print_r($options);?>
<?php if($options) {  $inc=0; $count_item=count($options); ?>
<?php foreach($options as $OP) {?>
    <tr id="invrow<?php echo $inc;?>" class="optionRows">
    <td><input type="text" class="form-control text-left " id="option_name<?php echo $inc;?>" name="options[<?php echo $inc;?>][option_name]" value="<?php echo $OP['option_name'];?>"  ></td>
    <td><input type="text" class="form-control text-left  " id="option_number<?php echo $inc;?>" name="options[<?php echo $inc;?>][option_number]" value="<?php echo $OP['option_number'];?>"></td>
    <td>
    <select class="form-control required "  id="option_size<?php echo $inc;?>" name="options[<?php echo $inc;?>][option_size]"   > 
    <option value="" >--- Select ---</option>
    <?php if($product_size){ ?>
    <?php foreach($product_size as $PS){ ?>
    <option value="<?php echo $PS['product_size_id'];?>" <?php if($PS['product_size_id']==$OP['option_size_id']) { echo ' selected="selected"';} ?> ><?php echo $PS['product_size_name'];?></option>
    <?php } ?>
    <?php } ?>
    </select>
    </td>

	<td>
    <select class="form-control required"  id="option_fit<?php echo $inc;?>" name="options[<?php echo $inc;?>][option_fit]"   > 
    <option value="" >--- Select ---</option>
    <?php if($product_fit){ ?>
    <?php foreach($product_fit as $PFT){ ?>
    <option value="<?php echo $PFT['fit_type_id'];?>" <?php if($PFT['fit_type_id']==$OP['fit_type_id']) { echo ' selected="selected"';} ?> ><?php echo $PFT['fit_type_name'];?></option>
    <?php } ?>
    <?php } ?>
    </select>
    </td>

    <td><input type="number" class="form-control text-center digits required quantity" id="option_qty<?php echo $inc;?>" name="options[<?php echo $inc;?>][option_qty]" value="<?php echo $OP['option_qty'];?>" onkeyup="calculateRow();" maxlength="4" min="1" onchange="calculateRow();" ></td>
<td><input type="text" class="form-control text-center" id="option_info<?php echo $inc;?>" name="options[<?php echo $inc;?>][option_info]" value="<?php echo $OP['customer_item_info'];?>"  ></td>
    <td><a href="javascript:void(0);" onclick="removeOptionRow(<?php echo $inc;?>);">Remove</a></td>
    </tr>
<?php $inc++; } ?>
<?php } ?>
</tbody>
<tfoot>
<tr class="last-item-row">
<td class="add-row" align="right" colspan="5">
<button type="button" class="btn btn-info" aria-label="Left Align"  onclick="return addFilterOptionRow();"><i class="icon-plus-square"></i> Add New Option Row</button>
</td>
</tr>
<tr>
</tr>
</tfoot>
</table>


</div>
</div>
</div>
<script>
function removeOptionRow(filter_row){
	var items=0;
	$( ".optionRows" ).each(function( index ) {
									  items++;
	   // console.log( index + ": " + $( this ).text() );
	});
	if(items==1){
		alert("Can't Remove..");
		return false;
	}
	$('#invrow'+filter_row).remove();
	calculateRow();

}

var filter_row = <?php echo $count_item;?>;
//alert(filter_row);
function addFilterOptionRow(){
	//alert('ok');
	var html;
	html='<tr id="invrow'+filter_row +'" class="optionRows">';
	html+='<td><input type="text" class="form-control text-left" id="option_name'+filter_row+'" name="options['+filter_row+'][option_name]" ></td>';
	html+='<td><input type="text" class="form-control text-left " id="option_number'+filter_row+'" name="options['+filter_row+'][option_number]"></td>';
	html+='<td><select class="form-control required"  id="option_size'+filter_row+'" name="options['+filter_row+'][option_size]"  >';
	<?php if($product_size){ ?>
	<?php foreach($product_size as $PS){ ?>
	html+='<option value="<?php echo $PS['product_size_id'];?>"><?php echo $PS['product_size_name'];?></option>';
	<?php } ?>
	<?php } ?>
	html+='</select></td>';

	html+='<td><select class="form-control required"  id="option_fit'+filter_row+'" name="options['+filter_row+'][option_fit]"  >';
	<?php if($product_fit){ ?>
	<?php foreach($product_fit as $PFTT){ ?>
	html+='<option value="<?php echo $PFTT['fit_type_id'];?>"><?php echo $PFTT['fit_type_name'];?></option>';
	<?php } ?>
	<?php } ?>
	html+='</select></td>';

	
	
	html+='<td><input type="number" class="form-control text-center  digits quantity" id="option_qty'+filter_row+'" name="options['+filter_row+'][option_qty]" onkeyup="calculateRow();" maxlength="4" min="1" onchange="calculateRow();"  ></td>';
html+='<td><input type="text" class="form-control text-center" id="option_info'+filter_row+'" name="options['+filter_row+'][option_info]"  ></td>';
	
	html+='<td><a href="javascript:void(0);" onclick="removeOptionRow('+filter_row+');">Remove</a></td>';
	html+='</tr>';
	//alert(html);
	$('#optionRowTr').append(html);
	filter_row++;
	return false;
	
}
</script>