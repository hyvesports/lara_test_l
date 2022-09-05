<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Order Item Status</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">
<?php if($fromdep=="finalqc"){ 
						if($row['BUNDLING_REJECTED_COUNT']!=""){ 
				$rejCount=$row['BUNDLING_REJECTED_COUNT'];
				//$appCount=$row['TOTAL_COUNT']-$row['BUNDLING_REJECTED_COUNT'];
				//$appCount=$row['APPROVED_COUNT'];
			}else{
				$rejCount=$row['REJECTED_COUNT'];
				//$appCount=$row['APPROVED_COUNT'];
			};
			$appCount=$row['APPROVED_COUNT'];
		echo 	$st='
			<div class="badge  badge-primary" title=""><i class="fa fa-exclamation-circle"></i> Total Item : '.$row['TOTAL_COUNT'].'</div>
			
			<div class="badge  badge-success mt-1" title=""><i class="fa fa-thumbs-up"></i> Order Approved: '.$appCount.'</div>
			<div class="badge  badge-danger" title=""><i class="fa fa-thumbs-down"></i> Order Rejected :'.$rejCount.'</div>
			';
 }?>
<?php if($fromdep=="stitching"){ 
			if($row['BUNDLING_REJECTED_COUNT']!=""){ 
				$rejCount=$row['BUNDLING_REJECTED_COUNT'];
				//$appCount=$row['TOTAL_COUNT']-$row['BUNDLING_REJECTED_COUNT'];
				//$appCount=$row['APPROVED_COUNT'];
			}else{
				$rejCount=$row['REJECTED_COUNT'];
				//$appCount=$row['APPROVED_COUNT'];
			};
			$appCount=$row['APPROVED_COUNT'];
			echo $st='<td>
			<div class="badge  badge-primary" ><i class="fa fa-exclamation-circle"></i> Total Item : '.$row['TOTAL_COUNT'].'</div>
			<div class="badge  badge-warning" title="Order Submitted"><i class="fa fa-exchange"></i> Order Submitted : '.$row['SUBMITTED_COUNT'].'</div>
			<div class="badge  badge-success mt-1" title="Order Approved"><i class="fa fa-thumbs-up"></i> Order Approved : '.$appCount.'</div>
			<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> Order Rejected : '.$rejCount.'</div>
			</td>';
 }?>
<?php if($fromdep=="bundling"){ ?>
			<?php 
			if($row['BUNDLING_REJECTED_COUNT']!=""){ 
				$rejCount=$row['BUNDLING_REJECTED_COUNT'];
				//$appCount=$row['TOTAL_COUNT']-$row['BUNDLING_REJECTED_COUNT'];
				//$appCount=$row['APPROVED_COUNT'];
			}else{
				$rejCount=$row['REJECTED_COUNT'];
				//$appCount=$row['APPROVED_COUNT'];
			};
			$appCount=$row['APPROVED_COUNT'];
			echo $st='
			<div class="badge  badge-primary" ><i class="fa fa-exclamation-circle"></i> Total Item : '.$row['TOTAL_COUNT'].'</div>
			
			<div class="badge  badge-success mt-1" title="Order Approved"><i class="fa fa-thumbs-up"></i> Order Approved : '.$appCount.'</div>
			<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> Order Rejected : '.$rejCount.'</div>
			';
			?>

<?php } ?>
<?php if($fromdep=="fusing"){ ?>
			<?php 
			if($row['BUNDLING_REJECTED_COUNT']!=""){ 
				$rejCount=$row['BUNDLING_REJECTED_COUNT'];
				//$appCount=$row['TOTAL_COUNT']-$row['BUNDLING_REJECTED_COUNT'];
				//$appCount=$row['APPROVED_COUNT'];
			}else{
				$rejCount=$row['REJECTED_COUNT'];
				//$appCount=$row['APPROVED_COUNT'];
			};
			$appCount=$row['APPROVED_COUNT'];
			?>
			<div class="badge  badge-primary" title=""><i class="fa fa-exclamation-circle"></i> Total Item :  <?php echo $row['TOTAL_COUNT'];?></div>
			<div class="badge  badge-warning" title="Order Submitted"><i class="fa fa-exchange"></i> Order Submitted : <?php echo $row['SUBMITTED_COUNT'];?></div>
			<div class="badge  badge-success mt-1" title="Order Approved"><i class="fa fa-thumbs-up"></i> Order Approved : <?php echo $appCount;?></div>
			<div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> Order Rejected : <?php echo $rejCount;?></div>

<?php } ?>


<?php if($fromdep=="dispatch"){
			if($row['BUNDLING_REJECTED_COUNT']!=""){ 
				$rejCount=$row['BUNDLING_REJECTED_COUNT'];
				//$appCount=$row['TOTAL_COUNT']-$row['BUNDLING_REJECTED_COUNT'];
				//$appCount=$row['APPROVED_COUNT'];
			}else{
				$rejCount=$row['REJECTED_COUNT'];
				//$appCount=$row['APPROVED_COUNT'];
			};
			$appCount=$row['APPROVED_COUNT'];
			?>
			
			<div class="badge  badge-primary" ><i class="fa fa-share-alt"></i>  Total Item : <?php echo $row['TOTAL_COUNT'];?></div>
			<div class="badge  badge-success mt-1" title="Final QC Approved"><i class="fa fa-thumbs-up"></i> Final QC Approved : <?php echo $appCount;?></div>
			<div class="badge  badge-warning" title="Accounts Approved"><i class="fa fa-thumbs-up"></i> Accounts Approved : <?php echo $row['ACCOUNTS_APPROVED_COUNT'];?></div>
			
<?php } ?>
<?php if($fromdep=="printing"){ ?>
  <div class="badge  badge-primary" title=""><i class="fa fa-exclamation-circle"></i> Total Item : <?php echo $row['TOTAL_COUNT'];?></div>
	<div class="badge  badge-warning" title="Order Submitted"><i class="fa fa-exchange"></i> Order Submitted : <?php echo $row['SUBMITTED_COUNT'];?></div>
  <?php
  if($row['BUNDLING_REJECTED_COUNT']!=""){ 
    $rejCount=$row['BUNDLING_REJECTED_COUNT'];
    //$appCount=$row['TOTAL_COUNT']-$row['BUNDLING_REJECTED_COUNT'];
  }else{
    $rejCount=$row['REJECTED_COUNT'];
    //$appCount=$row['APPROVED_COUNT'];
  };
  $appCount=$row['APPROVED_COUNT'];
  ?>
  <div class="badge  badge-success mt-1" title="Order Approved"><i class="fa fa-thumbs-up"></i> Order Approved : <?php echo $appCount;?></div>
  <div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i>Order Rejected : <?php echo $rejCount;?></div>
<?php } ?>

<?php if($fromdep=="designqc"){ ?>
  <div class="badge  badge-primary" title=""><i class="fa fa-exclamation-circle"></i> Total Item : <?php echo $row['TOTAL_COUNT'];?></div>
  <?php
  if($row['BUNDLING_REJECTED_COUNT']!=""){ 
    $rejCount=$row['BUNDLING_REJECTED_COUNT'];
    //$appCount=$row['TOTAL_COUNT']-$row['BUNDLING_REJECTED_COUNT'];
  }else{
    $rejCount=$row['REJECTED_COUNT'];
    //$appCount=$row['APPROVED_COUNT'];
  };
  $appCount=$row['APPROVED_COUNT'];
  ?>
  <div class="badge  badge-success mt-1" title="Order Approved"><i class="fa fa-thumbs-up"></i> Order Approved : <?php echo $appCount;?></div>
  <div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i>Order Rejected : <?php echo $rejCount;?></div>
<?php } ?>

<?php if($fromdep=="design"){
	if($row['BUNDLING_REJECTED_COUNT']!=""){ 
	$rejCount=$row['BUNDLING_REJECTED_COUNT'];
	//$appCount=$row['TOTAL_COUNT']-$row['BUNDLING_REJECTED_COUNT'];
	}else{
	$rejCount=$row['REJECTED_COUNT'];
	//$appCount=$row['APPROVED_COUNT'];
	};
	$appCount=$row['APPROVED_COUNT'];
 ?>
  <div class="badge  badge-primary" title="Order Not Submitted"><i class="fa fa-exclamation-circle"></i> Not Submitted : <?php echo $row['TOTAL_COUNT'];?></div>
  <div class="badge  badge-warning" title="Order Submitted"><i class="fa fa-exchange"></i> Order Submitted: <?php echo $row['SUBMITTED_COUNT'];?></div>
  <div class="badge  badge-success mt-1" title="Order Approved"><i class="fa fa-thumbs-up"></i> Order Approved: <?php echo $appCount;?></div>
  <div class="badge  badge-danger" title="Order Rejected"><i class="fa fa-thumbs-down"></i> Order Rejected : <?php echo $rejCount;?></div>
<?php } ?>

</div>



