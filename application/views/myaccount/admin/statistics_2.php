<style>
.icon-data-list {
    list-style-type: none;
    padding-left: 0;
    position: relative;
    margin-bottom: 0;
    font-family: "Nunito", sans-serif;
}
</style>
<?php
$notifactionDate=date("Y-m-d", strtotime($this->session->userdata('date_now')));
$notifications=$this->dashboard_model->get_my_notifications_admin($notifactionDate);
?>	
<div class="row">
<div class="col-md-6 grid-margin transparent">
<div class="card bg-primary" style="height:75vh;overflow-y:scroll;">
<div class="card-body">


<h4 class="card-title text-white">Notifications</h4>
	<?php if($notifications){ ?>
	<?php foreach($notifications as $MYDATA){ ?>
        <div class="d-flex border-light-white  update-item mt-2">
        <div>
        <h6 class="text-white font-weight-medium d-flex"><?php echo ucwords($MYDATA['log_full_name']);?>
        <span class="small ml-auto"><?php echo $MYDATA['notification_time_stamp'];?></span>
        </h6>
        <p><?php echo $MYDATA['notification_content'];?></p>
        </div>
        </div>
	<?php }?>
	<?php }else{ ?><br><br>
	<div class="alert alert-warning text-white" role="alert">Notifications not found!!!</div>
	<?php } ?>
<div class="row">

<div class="col-md-12 pl-md-1 pt-4 pt-md-0">


<div class="tab-content tab-content-basic" >
    <div class="tab-pane fade " id="whoweare" role="tabpanel" aria-labelledby="home-tab" >

    </div>
</div>
</div>
</div>
</div>
</div>
</div>



<?php
$month1=date("m", strtotime($this->session->userdata('date_now')));
$year1=date("Y", strtotime($this->session->userdata('date_now')));


$chartDetails=$this->myaccount_model->get_leads_statistics_admin_pie_chart($month1,$year1);
?>	

<div class="col-md-6 grid-margin stretch-card">
<div class="card card-update" >
<div class="card-body">	
<pie-chart id="pieChart" style="display:block;height:100%;width:100%;position:relative;">

<?php

function randomColour() {
    // Found here https://css-tricks.com/snippets/php/random-hex-color/
    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
    $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
    return $color;
}

$k=0;
foreach($chartDetails as $cc)
{
$balance=$this->myaccount_model->get_leads_statistics_admin_pie_chart_bal($month1,$year1,$cc['lead_owner_id']);

 $REVENUE1=$cc['advance']+$balance['bal'];
$color = randomColour();

  if($REVENUE1 > 0){     

?>
                <pchart-element name="<?php echo $cc['staff_name'];?>" value="<?php echo $REVENUE1 ;?>" colour="<?php echo $color;?>">
  
<?php
}
}
?>

            </pie-chart>
<p align="center">Gem Wise Revenue</p>
    

</div>
</div>
</div>
</div>
