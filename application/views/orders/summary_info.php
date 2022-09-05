
<div class="modal-body"  >
<?php //print_r($row);?>
<div class="card">
<div class="card-body">
<h4 class="card-title mb-1">Order Number</h4>
<div class="d-flex justify-content-between align-items-center">
<div class="d-inline-block ">
<div class="d-md-flex">
<h2 class="mb-0">#<?php echo $row['orderform_number'];?></h2>
<div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
<i class="fa fa-calendar"></i>
<small class="ml-1 mb-0">Dispatch Date: <?php echo date("d-m-Y", strtotime($row['wo_dispatch_date']));?></small>
</div>

</div>
<br />
<small class="text-gray"></small>
</div>

</div>
<?php if($summary_info){ ?>
<table class="table">
<tbody>
<?php foreach($summary_info as $SM){ ?>
<tr>

<td><?php echo ucwords($SM['wo_product_type_name']);?></td>
<td>
<label class="badge badge-warning"><?php echo $SM['QTY'];?></label>
</td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } ?>
</div>
</div>


</div>   