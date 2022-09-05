<div class="modal-body" style="background:#FFF;">

<table width="100%" class="table table-striped   mt-0 "  >
    <thead>
    <tr class="item_header">
    <th width="10%"   class="text-left">DATE</th>
    <th width="18%"  class="text-left">DESINGING</th>
    <th width="18%"  class="text-left">PRINTING</th>
    <th width="18%"  class="text-left">FUSING</th>
    <th width="18%"  class="text-left">BUNDLING</th>
    <th width="18%"  class="text-left">STICHING</th>

    </tr>
    </thead>
    
    <tbody>
    <?php if($dates){ ?>
    <?php foreach($dates as $SH){?>
		
    <tr>
    <td valign="top"><?php echo date('M d, Y', strtotime($SH['DSD']));?></td>
    
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
	if($value1['item_unit_qty_input']!=0){
	?>
    <li style="color:<?php echo $value1['priority_color_code'];?>;" >
	<?php echo ucwords($value1['orderno']);?> : <?php echo ucwords($value1['product_type']);?> [ <?php echo ucwords($value1['item_unit_qty_input']);?> ]
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
		if($value2['item_unit_qty_input']!=0){
	?>
     <li  style="color:<?php echo $value2['priority_color_code'];?>;" >
	<?php echo ucwords($value2['orderno']);?> : <?php echo ucwords($value2['product_type']);?> [ <?php echo ucwords($value2['item_unit_qty_input']);?> ]</li>
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
		if($value3['item_unit_qty_input']!=0){
	?>
     <li  style="color:<?php echo $value3['priority_color_code'];?>;">
	 <?php echo ucwords($value3['orderno']);?> : <?php echo ucwords($value3['product_type']);?> [ <?php echo ucwords($value3['item_unit_qty_input']);?> ]</li>
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
		if($value4['item_unit_qty_input']!=0){
	?>
     <li  style="color:<?php echo $value4['priority_color_code'];?>;" ><?php echo ucwords($value4['orderno']);?> : <?php echo ucwords($value4['product_type']);?> [ <?php echo ucwords($value4['item_unit_qty_input']);?> ]</li>
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
		if($value5['item_unit_qty_input']!=0){
	?>
     <li style="color:<?php echo $value5['priority_color_code'];?>;" ><?php echo ucwords($value5['orderno']);?> : <?php echo ucwords($value5['product_type']);?> [ <?php echo ucwords($value5['item_unit_qty_input']);?> ]</li>
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