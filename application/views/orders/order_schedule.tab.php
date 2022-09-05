<?php
//echo $row['order_id'];
$dates=$this->schedule_model->get_dates_from_scheduled_dptmt_by_order_view($row['order_id']);
//print_r($dates);
?>

<div class="tab-pane fade show active pr-3" id="schedule" role="tabpanel" aria-labelledby="schedule">
	<table width="100%" class="table table-hover table-bordered   mt-0 "  >
    <thead>
    <tr class="item_header">
    <th width="5%"   class="text-left">DATE</th>
    <th width="18%"  class="text-left">DESIGNING</th>
    <th width="18%"  class="text-left">PRINTING</th>
    <th width="18%"  class="text-left">FUSING</th>
    <th width="18%"  class="text-left">BUNDLING</th>
    <th width="18%"  class="text-left">STITCHING</th>
	<th width="18%"  class="text-left">FINAL QC</th>
    <th width="18%"  class="text-left">DISPATCH</th>
    </tr>
    </thead>
	<tbody>
    <?php if($dates){ ?>
    <?php foreach($dates as $SH){?>
    <tr>
    <td valign="top"><?php echo date('d/m/y', strtotime($SH['DSD']));?></td>
    <td>
    <?php
    $scheduleArray1=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],4);
	if($scheduleArray1){ ?>
    <ol>
    <?php 
	foreach($scheduleArray1 as $sArray1){ 
	$array1 = json_decode($sArray1['sh_order_json'],true);
	//echo count($array1)."__<br/>";
	foreach($array1 as $key1 => $value1){
		// echo $value1['priority_color_code'];
	if($value1['item_unit_qty_input']!=0 && $value1['orderno']==$row['orderform_number']){
	?>
    <li style="color:<?php echo $value1['priority_color_code'];?>;" >
	<?php //echo ucwords($value1['orderno']);?> <?php echo ucwords($value1['product_type']);?> [ <?php echo ucwords($value1['item_unit_qty_input']);?> ]
    </li>
    <?php }} ?>
    <?php } ?>
    </ol>
    <?php } ?>
    </td>

    <td>
    <?php
    $scheduleArray2=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],5);
	if($scheduleArray2){ ?>
    <ol>
    <?php 
	foreach($scheduleArray2 as $sArray2){ 
	$array2 = json_decode($sArray2['sh_order_json'],true);
	//echo count($array1)."__<br/>";
	foreach($array2 as $key2 => $value2){
		if($value2['item_unit_qty_input']!=0  && $value2['orderno']==$row['orderform_number']){
	?>
     <li  style="color:<?php echo $value2['priority_color_code'];?>;" >
	<?php //echo ucwords($value2['orderno']);?><?php echo ucwords($value2['product_type']);?> [ <?php echo ucwords($value2['item_unit_qty_input']);?> ]</li>
    <?php }} ?>
    <?php } ?>
    </ol>
    <?php } ?>
    </td>

    <td>
    <?php
    $scheduleArray3=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],6);
	if($scheduleArray3){ ?>
    <ol>
    <?php 
	foreach($scheduleArray3 as $sArray3){ 
	$array3 = json_decode($sArray3['sh_order_json'],true);
	//echo count($array1)."__<br/>";
	foreach($array3 as $key3 => $value3){
		if($value3['item_unit_qty_input']!=0  && $value3['orderno']==$row['orderform_number']){
	?>

     <li  style="color:<?php echo $value3['priority_color_code'];?>;">
	 <?php //echo ucwords($value3['orderno']);?><?php echo ucwords($value3['product_type']);?> [ <?php echo ucwords($value3['item_unit_qty_input']);?> ]</li>
    <?php } } ?>
    <?php } ?>
    </ol>
    <?php } ?>
    </td>

    <td>
    <?php
    $scheduleArray4=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],12);
	if($scheduleArray4){ ?>
    <ol>
    <?php 
	foreach($scheduleArray4 as $sArray4){ 
	$array4 = json_decode($sArray4['sh_order_json'],true);
	//echo count($array1)."__<br/>";
	foreach($array4 as $key4 => $value4){
		if($value4['item_unit_qty_input']!=0  && $value4['orderno']==$row['orderform_number']){
	?>
     <li  style="color:<?php echo $value4['priority_color_code'];?>;" ><?php //echo ucwords($value4['orderno']);?><?php echo ucwords($value4['product_type']);?> [ <?php echo ucwords($value4['item_unit_qty_input']);?> ]</li>
    <?php }}?>
    <?php } ?>
    </ol>
    <?php } ?>
    </td>

    <td>
    <?php
    $scheduleArray5=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],8);
	if($scheduleArray5){ ?>
    <ol>
    <?php 
	foreach($scheduleArray5 as $sArray5){ 
	$array5 = json_decode($sArray5['sh_order_json'],true);
	//echo count($array1)."__<br/>";
	foreach($array5 as $key5 => $value5){
		if($value5['item_unit_qty_input']!=0  && $value5['orderno']==$row['orderform_number']){
	?>
     <li style="color:<?php echo $value5['priority_color_code'];?>;" ><?php //echo ucwords($value5['orderno']);?><?php echo ucwords($value5['product_type']);?> [ <?php echo ucwords($value5['item_unit_qty_input']);?> ]</li>
    <?php }} ?>
    <?php } ?>
    </ol>
    <?php } ?>
    </td>

	<td>
    <?php
    $scheduleArray6=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],13);
	if($scheduleArray6){ ?>
    <ol>
    <?php 
	foreach($scheduleArray6 as $sArray6){ 
	$array6 = json_decode($sArray6['sh_order_json'],true);
	//echo count($array1)."__<br/>";
	foreach($array6 as $key6 => $value6){
		if($value6['item_unit_qty_input']!=0  && $value6['orderno']==$row['orderform_number']){
	?>
     <li style="color:<?php echo $value6['priority_color_code'];?>;" ><?php //echo ucwords($value6['orderno']);?><?php echo ucwords($value6['product_type']);?> [ <?php echo ucwords($value6['item_unit_qty_input']);?> ]</li>
    <?php }} ?>
    <?php } ?>
    </ol>
    <?php } ?>
    </td>

	<td>
    <?php
    $scheduleArray7=$this->schedule_model->get_each_date_and_deptmt($SH['DSD'],10);
	if($scheduleArray7){ ?>
    <ol>
    <?php 
	foreach($scheduleArray7 as $sArray7){ 
	$array7 = json_decode($sArray7['sh_order_json'],true);
	//echo count($array1)."__<br/>";
	foreach($array7 as $key7 => $value7){
		if($value7['item_unit_qty_input']!=0  && $value7['orderno']==$row['orderform_number']){
	?>
     <li style="color:<?php echo $value7['priority_color_code'];?>;" ><?php //echo ucwords($value7['orderno']);?><?php echo ucwords($value7['product_type']);?> [ <?php echo ucwords($value7['item_unit_qty_input']);?> ]</li>
    <?php }} ?>
    <?php } ?>
    </ol>
    <?php } ?>
    </td>



    

    

   

    

    

    </tr>

    

    

    

    

    <?php } ?>

    <?php } ?>

    



    </tbody>

    </table>

</div>

