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

<div class="row">
  <div class="col-md-6 mb-4 stretch-card transparent">
    <div class="card card-dark-blue">
      <div class="card-body">
	<canvas id="myChart" width="400" height="400"></canvas>
	<p align="center">Pipeline Gem Wise</p>
      </div>
      
      
      
    </div>
  </div>


  


  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
	<p class="card-title mb-0">Revenue</p>
	<div class="table-responsive ">
	  <table class="table table-striped table-borderless" id="orders">
	    <thead>
	      <tr>
		<th>Order No:</th>
		<th>Name</th>
		<th>Lead Time</th>
		<th>Gross Cost</th>
		<th>Shipping Cost</th>
	      </tr>  
	    </thead>
	    <tbody>
	      <?php if($woArrayGem){ ?>
	      <?php foreach($woArrayGem as $OD){ ?>
	      <tr  class="m-1">
		<td class="font-weight-bold"><div class="badge badge-success"><?php echo $OD['orderform_number'];?></div></td>
		<td><?php echo $OD['wo_customer_name'];?></td>
		<td><?php echo $OD['lead_diff'];?></td>
		<td class="font-weight-medium"><?php echo $OD['wo_gross_cost'];?></td>
		<td class="font-weight-medium"><?php echo $OD['wo_shipping_cost'];?></td> 
	      </tr>
	      <?php } ?>
	      <?php } ?>
	      
	      
	      
	    </tbody>
	  </table>
	</div>
      </div>
    </div>
  </div>
</div>
<?php
   
   function percent($number){
   return $number * 100 . '%';
   }
   
   $piplnArray=$this->myaccount_model->get_leads_pipeline_admin_donut_chart($month,$year);
$totalPipeline=0;
foreach($piplnArray as $pipln)
{
$totalPipeline =$totalPipeline+$pipln['lead_info'];

}

foreach($piplnArray as $pipln)
{
$plNames[]=$pipln['staff_name'];
$plAmnts[]=number_format( (($pipln['lead_info']/$totalPipeline)*100),2);
}
$pipeLnNames=json_encode($plNames,TRUE);
$pipeLnAmount=json_encode($plAmnts,TRUE);

?>

<script>
  var ctx = document.getElementById("myChart");
  var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
labels: <?php echo $pipeLnNames;?>,
datasets: [{
label: '# Pipeline',
data: <?php echo $pipeLnAmount;?>,
backgroundColor: [
'rgba(255, 99, 132, 0.5)',
'rgba(54, 162, 235, 0.2)',
'rgba(255, 206, 86, 0.2)',
'rgba(75, 192, 192, 0.2)'
],
borderColor: [
'rgba(255,99,132,1)',
'rgba(54, 162, 235, 1)',
'rgba(255, 206, 86, 1)',
'rgba(75, 192, 192, 1)'
],
borderWidth: 1
}]
},
options: {
//cutoutPercentage: 40,
responsive: false,

}
});





(function($) {
'use strict';

$(function() {
$('#orders').DataTable({
"aLengthMenu": [
[5, 10, 15, -1],
[5, 10, 15, "All"]
],
"iDisplayLength": 5,
"language": {
search: ""
}
});
$('#order-listing').each(function() {
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

