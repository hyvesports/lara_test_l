<div class="content-wrapper">
<div class="row grid-margin">
<div class="col-12">
<div class="card">
<div class="card-body">



<h4 class="card-title"><?php echo $title_head;?>
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('calendar/index');?>">List</a></span> 
</h4>

<h4 class="card-title"><?php echo $month_and_year;?> <?php //print_r($non_working_days);?></h4>
<form action="post" id="calenderData" name="calenderData">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="row">
    <div class="col-md-12">
    <span id="dateContent"></span>

	<table class="table table-responsive mb-0" width="100%">
    <thead>
    <tr class="item_header">
    <th width="15%"  class="text-left">Date</th>
    <th width="15%"  class="text-left">Day Name</th>
    <th width="15%"  class="text-left">Working</th>
    <?php if($production_units) { $k=0; $production_unit_ids;?>
    <?php foreach($production_units as $PU) { if($k==0){ $production_unit_ids=$PU['production_unit_id']; }else{ $production_unit_ids.=",".$PU['production_unit_id'];} $k++;?>
    <th width="10%"  class="text-left"><?php echo $PU['production_unit_name'];?> %</th>
    <?php } ?>
    <?php } ?>
    <th width="18%"  class="text-left">Production Capacity %</th>
    <th width="38%"  class="text-left">Remark</th>
   
    </tr>
    </thead>
    
    <tbody>
    <?php if($allDates){ $i=0;?>
    <?php foreach($allDates as $row){ 
	
		$day_number=$i;
		if($i<=9){
			$day_number='0'.$i;
		}
		
		$second_saturday_number=date('d', strtotime('second saturday of '.$month_and_year));
		$dayname=date("l", strtotime($row['calendar_date']));
		$colour_class='badge-success';
		$text_class='text-success';
		
		$working=ucwords($row['working_type']);
		
		$capacity=$row['working_capacity'];
		$remark=$row['day_remark'];
		
		if($day_number==$second_saturday_number){
			$nonworkingRow=$this->calendar_model->get_non_working_days('Second Saturday');
			if($nonworkingRow['non_working_id']!=""){
				$colour_class='badge-danger';
				$text_class='text-danger';
				//$working='no';
				//$capacity='0';
			}
		}else{
			$nonworkingRow=$this->calendar_model->get_non_working_days($dayname);
			if($nonworkingRow['non_working_id']!=""){
				$colour_class='badge-danger';
				$text_class='text-danger';
				//$working='no';
				//$capacity='0';
			}
		}
		


		?>
    
    	<tr>
        <td>

        <label class="badge <?php echo $colour_class;?>"><?php echo date("d-m-Y", strtotime($row['calendar_date']));?></label>
        </td>
        
        <td >
        <label class="badge <?php echo $colour_class;?>"><?php echo $dayname; ?></label>
        </td>
        
        <td class="<?php echo $text_class;?>">
        <?php echo $working; ?>
        </td>
        
           <?php if($production_units) {?>
    <?php foreach($production_units as $PU) {
		
		$cuRow=$this->calendar_model->get_production_unit_calendar($PU['production_unit_id'],$row['calendar_id']);
		
		?>
    <td>
    <?php echo $cuRow['unit_work'];?>
    </td>
    	
    <?php } } ?>
        
        <td class="text-center <?php echo $text_class;?>"><?php echo $capacity;?>%</td>
        
        <td class="<?php echo $text_class;?>">
        <?php echo $remark;?>
        </td>    
         
        <td>
        </td>
        </tr>
    
    <?php $i++; } ?>
    <?php } ?>
    </tbody>
    
    </table>
    </div>
    
    
    </div>
    </form>
</div>
</div>


</div>
</div>



</div>
