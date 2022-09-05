<?php
$year=date("Y", strtotime($this->session->userdata('date_now')));

?>
<div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><?php echo $year;?> Chart</h4>
                  <div class="float-chart-container">
                    <div id="column-chart" class="float-chart"></div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
<?php
$month1=$this->myaccount_model->get_leads_statistics_graph($staff_id,1,$year);
$gTotal_1=0;
$aTotal_1=0;
if($month1['wo_gross_total']!=""){$gTotal_1=$month1['wo_gross_total'];}
if($month1['wo_advance_total']!=""){$aTotal_1=$month1['wo_advance_total'];}
$REVENUE_1=$gTotal_1+$aTotal_1;


$month2=$this->myaccount_model->get_leads_statistics_graph($staff_id,2,$year);
$gTotal_2=0;
$aTotal_2=0;
if($month2['wo_gross_total']!=""){$gTotal_2=$month2['wo_gross_total'];}
if($month2['wo_advance_total']!=""){$aTotal_2=$month2['wo_advance_total'];}
$REVENUE_2=$gTotal_2+$aTotal_2;

$month3=$this->myaccount_model->get_leads_statistics_graph($staff_id,3,$year);
$gTotal_3=0;
$aTotal_3=0;
if($month3['wo_gross_total']!=""){$gTotal_3=$month3['wo_gross_total'];}
if($month3['wo_advance_total']!=""){$aTotal_3=$month3['wo_advance_total'];}
$REVENUE_3=$gTotal_3+$aTotal_3;

$month4=$this->myaccount_model->get_leads_statistics_graph($staff_id,4,$year);
$gTotal_4=0;
$aTotal_4=0;
if($month4['wo_gross_total']!=""){$gTotal_4=$month4['wo_gross_total'];}
if($month4['wo_advance_total']!=""){$aTotal_4=$month4['wo_advance_total'];}
$REVENUE_4=$gTotal_4+$aTotal_4;

$month5=$this->myaccount_model->get_leads_statistics_graph($staff_id,5,$year);
$gTotal_5=0;
$aTotal_5=0;
if($month5['wo_gross_total']!=""){$gTotal_5=$month5['wo_gross_total'];}
if($month5['wo_advance_total']!=""){$aTotal_5=$month5['wo_advance_total'];}
$REVENUE_5=$gTotal_5+$aTotal_5;

$month6=$this->myaccount_model->get_leads_statistics_graph($staff_id,6,$year);
$gTotal_6=0;
$aTotal_6=0;
if($month6['wo_gross_total']!=""){$gTotal_6=$month6['wo_gross_total'];}
if($month6['wo_advance_total']!=""){$aTotal_6=$month6['wo_advance_total'];}
$REVENUE_6=$gTotal_6+$aTotal_6;

$month7=$this->myaccount_model->get_leads_statistics_graph($staff_id,7,$year);
$gTotal_7=0;
$aTotal_7=0;
if($month7['wo_gross_total']!=""){$gTotal_7=$month7['wo_gross_total'];}
if($month7['wo_advance_total']!=""){$aTotal_7=$month7['wo_advance_total'];}
$REVENUE_7=$gTotal_7+$aTotal_7;

$month8=$this->myaccount_model->get_leads_statistics_graph($staff_id,8,$year);
$gTotal_8=0;
$aTotal_8=0;
if($month8['wo_gross_total']!=""){$gTotal_8=$month8['wo_gross_total'];}
if($month8['wo_advance_total']!=""){$aTotal_8=$month8['wo_advance_total'];}
$REVENUE_8=$gTotal_8+$aTotal_8;

$month9=$this->myaccount_model->get_leads_statistics_graph($staff_id,9,$year);
$gTotal_9=0;
$aTotal_9=0;
if($month9['wo_gross_total']!=""){$gTotal_9=$month9['wo_gross_total'];}
if($month9['wo_advance_total']!=""){$aTotal_9=$month9['wo_advance_total'];}
$REVENUE_9=$gTotal_9+$aTotal_9;

$month10=$this->myaccount_model->get_leads_statistics_graph($staff_id,10,$year);
$gTotal_10=0;
$aTotal_10=0;
if($month10['wo_gross_total']!=""){$gTotal_10=$month9['wo_gross_total'];}
if($month10['wo_advance_total']!=""){$aTotal_10=$month10['wo_advance_total'];}
$REVENUE_10=$gTotal_10+$aTotal_10;

$month11=$this->myaccount_model->get_leads_statistics_graph($staff_id,11,$year);
$gTotal_11=0;
$aTotal_11=0;
if($month11['wo_gross_total']!=""){$gTotal_11=$month11['wo_gross_total'];}
if($month11['wo_advance_total']!=""){$aTotal_11=$month11['wo_advance_total'];}
$REVENUE_11=$gTotal_11+$aTotal_11;


$month12=$this->myaccount_model->get_leads_statistics_graph($staff_id,12,$year);
$gTotal_12=0;
$aTotal_12=0;
if($month12['wo_gross_total']!=""){$gTotal_12=$month12['wo_gross_total'];}
if($month12['wo_advance_total']!=""){$aTotal_12=$month12['wo_advance_total'];}
$REVENUE_12=$gTotal_12+$aTotal_12;
//echo $REVENUE_12;
?>
<script>
(function($) {
  'use strict';
  /*---------------------
   ----- COLUMN CHART -----
   ---------------------*/
  $(function() {
    var data = [
      ["Jan<br/><?php echo $REVENUE_1;?>", <?php echo $REVENUE_1;?>],
      ["Feb<br/><?php echo $REVENUE_2;?>", <?php echo $REVENUE_2;?>],
      ["Mar<br/><?php echo $REVENUE_3;?>", <?php echo $REVENUE_3;?>],
      ["Apr<br/><?php echo $REVENUE_4;?>", <?php echo $REVENUE_4;?>],
      ["May<br/><?php echo $REVENUE_5;?>", <?php echo $REVENUE_5;?>],
      ["Jun<br/><?php echo $REVENUE_6;?>", <?php echo $REVENUE_6;?>],
		["Jul<br/><?php echo $REVENUE_7;?>", <?php echo $REVENUE_7;?>],
      ["Aug<br/><?php echo $REVENUE_8;?>", <?php echo $REVENUE_8;?>],
      ["Sep<br/><?php echo $REVENUE_9;?>", <?php echo $REVENUE_9;?>],
      ["Oct<br/><?php echo $REVENUE_10;?>", <?php echo $REVENUE_10;?>],
      ["Nov<br/><?php echo $REVENUE_11;?>", <?php echo $REVENUE_11;?>],
      ["Dec<br/><?php echo $REVENUE_12;?>", <?php echo $REVENUE_12;?>],
    ];
    if ($("#column-chart").length) {
      $.plot("#column-chart", [data], {
        series: {
          bars: {
            show: true,
            barWidth: 0.6,
            align: "center"
          }
        },
        xaxis: {
          mode: "categories",
          tickLength: 0
        },

        grid: {
          borderWidth: 0,
          labelMargin: 10,
          hoverable: true,
          clickable: true,
          mouseActiveRadius: 6,
        }

      });
    }
  });



})(jQuery);

</script>