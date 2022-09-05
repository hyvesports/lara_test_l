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
<?php $woArrayStitching=$this->dashboard_model->get_wo_form_stitching(2,$selectedDate);?>
<div class="row">
	
    <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
    <div class="card-body">
    <p class="card-title mb-0">ONLINE STITCHING</p>
    <div class="table-responsive ">
        <table class="table table-striped table-borderless ordersu" id="ordersu">
    <thead>
    <tr>
    <th>Order No:</th>
    <th>Product</th>
    <th>Qty</th>
    </tr>  
    </thead>
    <tbody>
    <?php if($woArrayStitching){ ?>
	<?php foreach($woArrayStitching as $ODS){
		$array1 = json_decode($ODS['scheduled_order_info'],true);
		if($array1){
		foreach($array1 as $key1 => $value1){
			if($value1['item_unit_qty_input']!=0){
		?>
        <tr  class="m-1">
        <td class="font-weight-bold"><div class="badge badge-success"><?php echo $ODS['orderform_number'];?></div></td>
        <td><?php echo $value1['product_type'];?></td>
        <td><?php echo $value1['item_unit_qty_input'];?></td>
        </tr>
		<?php } ?>
		<?php } ?>
		<?php } ?>
	<?php } ?>
	<?php } ?>
    
    
    
    </tbody>
    </table>
    </div>
    </div>
    </div>
    </div>

	<div class="col-md-4  grid-margin  stretch-card">
	<?php $woArrayStitchingOffline=$this->dashboard_model->get_wo_form_stitching(1,$selectedDate);?>
    <div class="card">
        <div class="card-body">
        <p class="card-title mb-0">OFFLINE STITCHING</p>
        <div class="table-responsive ">
        <table class="table table-striped table-borderless ordersu" id="ordersu">
        <thead>
        <tr>
        <th>Order No:</th>
        <th>Product</th>
        <th>Qty</th>
        </tr>  
        </thead>
        <tbody>
        <?php if($woArrayStitchingOffline){ ?>
        <?php foreach($woArrayStitchingOffline as $ODSO){
            $array11 = json_decode($ODSO['scheduled_order_info'],true);
            if($array11){
            foreach($array11 as $key11 => $value11){
                if($value11['item_unit_qty_input']!=0){
            ?>
            <tr  class="m-1">
            <td class="font-weight-bold"><div class="badge badge-success"><?php echo $ODSO['orderform_number'];?></div></td>
            <td><?php echo $value11['product_type'];?></td>
            <td><?php echo $value11['item_unit_qty_input'];?></td>
            </tr>
            <?php } ?>
            <?php } ?>
            <?php } ?>
        <?php } ?>
        <?php } ?>
        </tbody>
        </table>
        </div>
    
    
        </div>
    </div>
    </div>

	<div class="col-md-4  grid-margin  stretch-card">
	<?php $woArrayStitchingUnit=$this->dashboard_model->get_wo_form_stitching_unit(3,$selectedDate);?>
    <div class="card">
        <div class="card-body">
        <p class="card-title mb-0">Unit 3 STITCHING</p>
        <div class="table-responsive ">
        <table class="table table-striped table-borderless ordersu" id="ordersu">
        <thead>
        <tr>
        <th>Order No:</th>
        <th>Product</th>
        <th>Qty</th>
        </tr>  
        </thead>
        <tbody>
        <?php if($woArrayStitchingUnit){ ?>
        <?php foreach($woArrayStitchingUnit as $ODSU){
            $array111 = json_decode($ODSU['scheduled_order_info'],true);
            if($array111){
            foreach($array111 as $key11 => $value111){
                if($value111['item_unit_qty_input']!=0){
            ?>
            <tr  class="m-1">
            <td class="font-weight-bold"><div class="badge badge-success"><?php echo $ODSU['orderform_number'];?></div></td>
            <td><?php echo $value111['product_type'];?></td>
            <td><?php echo $value111['item_unit_qty_input'];?></td>
            </tr>
            <?php } ?>
            <?php } ?>
            <?php } ?>
        <?php } ?>
        <?php } ?>
        </tbody>
        </table>
        </div>
    
    
	    </div>
    </div>
    </div>

</div>
<script>
(function($) {
'use strict';
$(function() {
$('.ordersu').DataTable({
"aLengthMenu": [
[5, 10, 15, -1],
[5, 10, 15, "All"]
],
"iDisplayLength": 5,
"language": {
search: ""
}
});
$('.ordersu').each(function() {
var datatable = $(this);
// SEARCH - Add the placeholder for Search and Turn this into in-line form control
var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
search_input.attr('placeholder', 'Search');
search_input.removeClass('form-control-sm');
// LENGTH - Inline-Form control
var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
length_sel.removeClass('form-control-sm');
});
});
})(jQuery);
</script>
