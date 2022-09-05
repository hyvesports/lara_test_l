<?php
//die("Testing");
if($order_info['orderform_type_id']==2){ 
include("dispatch_online.php");
}else{ 
include("dispatch_offline.php");
}
?>

