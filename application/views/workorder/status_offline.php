<?php
$dates=$this->schedule_model->get_dates_from_scheduled_dptmt_by_order_view($row['order_id']);
$curDate=date('d/m/y');

?>

<div class="tab-pane fade show active " id="schedule" role="tabpanel" aria-labelledby="schedule">
	<table width="100%" class="table table-hover table-bordered  table-responsive  mt-0 "  >
    <thead>
    <tr class="item_header">
    <th width="4%"   class="text-left">DATE</th>
    <th width="12%"  class="text-left">DESIGNING</th>
	<th width="12%"  class="text-left">DESIGN QC</th>
    <th width="12%"  class="text-left">PRINTING</th>
    <th width="12%"  class="text-left">FUSING</th>
    <th width="12%"  class="text-left">BUNDLING</th>
    <th width="12%"  class="text-left">STITCHING</th>
	<th width="12%"  class="text-left">FINAL QC</th>
    <th width="12%"  class="text-left">DISPATCH</th>
    </tr>
    </thead>
	<tbody>
    <?php if($dates){ ?>
    <?php foreach($dates as $SH){?>
    <tr>
    <td valign="top">
	<?php if(date('d/m/y', strtotime($SH['DSD']))==$curDate){ ?>
	<strong class="text-success"><?php echo date('d/m/y', strtotime($SH['DSD']));?></strong>
	<?php }else{?>
	<?php echo date('d/m/y', strtotime($SH['DSD']));?>
	<?php } ?>
	</td>
    <?php include("td_1_status_offline.php");?>
	<?php include("td_2_status_offline.php");?>
	<?php include("td_3_status_offline.php");?>
    <?php include("td_4_status_offline.php");?>
	<?php include("td_5_status_offline.php");?>
    <?php include("td_6_status_offline.php");?>
	<?php include("td_7_status_offline.php");?>
    <?php include("td_8_status_offline.php");?>
    </tr>
    <?php } ?>
    <?php } ?>
    </tbody>
    </table>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
