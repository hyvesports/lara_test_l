<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* MSG91 Library file
* Author: Vivek Murali
* No Licence bullshit! Use it according to your logic!
*/
class Msg91 {

      public function __construct () {
	  $this->ci =& get_instance();
//	  $this->authKey = "370998AGUmvxJKVN625ea5eeP1"; //Auth Key
	  $this->authKey = "370998AGUmvxJKVN625ea5eeP1"; //Auth Key
	  $this->senderID = "HYVECX";   //Sender Id
	  $this->offlineFlowID = "624da915eee1d1419e116a42";  
      $this->onlineFlowID = "624da915eee1d1419e116a42"; //Schedule online order flow id
	 
      $this->offlinePrintingFlowID="62921acc26bc7d268d769665"; // offline printing template flow id
	  $this->offlineStichingFlowID="6292192b83de937f136c5876"; // offline Stiching template flow id
	  $this->offlineDispatchFlowID="62921cd38b01001da3197347"; // offline disptach template flow id
	
      $this->onlinePrintingFlowID="625e7e0ad6fc05422f201c92"; // online printing template flow id
	  $this->onlineStichingFlowID="625ea3e5d6fc0561e0368592"; // online Stiching template flow id
	  $this->onlineDispatchFlowID="62678d715e215450c26f95ad"; // online disptach template flow id
    
    }

    /**
     * This function helps to check the balance using the authentication key provided by MSG91.com
     * Function: checkSMSBalance()
     * Author: Anbuselvan Rocky
     */
    
    public function checkSMSBalance()
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://control.msg91.com/api/balance.php?type=4&authkey=$this->authKey",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $balance = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return "cURL Error #:" . $err;
        } else {
          return $balance;
        }
    }    


    public function send_online_printing_order_sms($to,$orderform_number) 
    {
        // Check SMS Balance, if it has credit. It will send the message with $to, $message parameters.
	error_log("Offline Printinh Sms",0);
	$dd=0;
        if ($d > 0) {
            return false;   
        }
        else
        {
            //Your message to send, Add URL encoding here.
            $message = urlencode($message);
	    $mobileNo=$to;

	    if(strlen($to) ==10)
		{
		    $mobileNo="91".$to;
		}
	    elseif(strlen($to) ==12 && substr($to,0,1) =="91")
		{
		    $mobileNo=$to;

		}
	    error_log("Sms Mobile No".$mobileNo,0);
	    error_log(strlen($to),0);
            //Define route
            $route = "4";

            //Prepare you post parameters
	    //   {\n  \"flow_id\": \"624da915eee1d1419e116a42\",\n  \"sender\": \"HYVECX\",\n  \"mobiles\": \"918248420402\",\n  \"VAR1\": \"VALUE 1\",\n  \"VA \ R2\": \"VALUE 2\"\n}
            $postData = '{
                "flow_id":"'.$this->onlinePrintingFlowID.'",
                "sender": "'.$this->senderID.'",
                "mobiles":"'.$mobileNo.'",
                "VAR1":"'.$orderform_number.'",
                "VAR2":"HYVECX"
}';        

            //API URL
            $url="https://api.msg91.com/api/v5/flow/";

            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",

            // CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "authkey: $this->authKey",
                "content-type: application/json"),
            ));

            //get response
            $response = curl_exec($ch);
            $err = curl_error($ch);
            
            curl_close($ch);

            if ($err) {
              echo "cURL Error #:" . $err;
            }
            else
            {
                $result = json_decode($response);

                if ($result->type === "success"){
                    return TRUE;
                }
                else{

                    return FALSE;
                }        
            }

        }        
    }


    public function send_online_stiching_order_sms($to,$orderform_number) 
    {
        // Check SMS Balance, if it has credit. It will send the message with $to, $message parameters.
	error_log("Offline Printinh Sms",0);
	$dd=0;
        if ($d > 0) {
            return false;   
        }
        else
        {
            //Your message to send, Add URL encoding here.
            $message = urlencode($message);
	    $mobileNo=$to;

	    if(strlen($to) ==10)
		{
		    $mobileNo="91".$to;
		}
	    elseif(strlen($to) ==12 && substr($to,0,1) =="91")
		{
		    $mobileNo=$to;

		}
	    error_log("Sms Mobile No".$mobileNo,0);
	    error_log(strlen($to),0);
            //Define route
            $route = "4";

            //Prepare you post parameters
	    //   {\n  \"flow_id\": \"624da915eee1d1419e116a42\",\n  \"sender\": \"HYVECX\",\n  \"mobiles\": \"918248420402\",\n  \"VAR1\": \"VALUE 1\",\n  \"VA \ R2\": \"VALUE 2\"\n}
            $postData = '{
                "flow_id":"'.$this->onlineStichingFlowID.'",
                "sender": "'.$this->senderID.'",
                "mobiles":"'.$mobileNo.'",
                "VAR1":"'.$orderform_number.'",
                "VAR2":"HYVECX"
}';        

            //API URL
            $url="https://api.msg91.com/api/v5/flow/";

            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",

            // CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "authkey: $this->authKey",
                "content-type: application/json"),
            ));

            //get response
            $response = curl_exec($ch);
            $err = curl_error($ch);
            
            curl_close($ch);

            if ($err) {
              echo "cURL Error #:" . $err;
            }
            else
            {
                $result = json_decode($response);

                if ($result->type === "success"){
                    return TRUE;
                }
                else{

                    return FALSE;
                }        
            }

        }        
    }

    public function send_online_dispatch_order_sms($to,$orderform_number,$tracking_no,$shiping_mode) 
    {
        // Check SMS Balance, if it has credit. It will send the message with $to, $message parameters.
	error_log("Dispatch Sms",0);
	$dd=0;
        if ($d > 0) {
            return false;   
        }
        else
        {
            //Your message to send, Add URL encoding here.
            $message = urlencode($message);
	    $mobileNo=trim($to);

	    if(strlen($to) ==10)
		{
		    $mobileNo="91".$to;
		}
	    elseif(strlen($to) ==12 && substr($to,0,1) =="91")
		{
		    $mobileNo=$to;

		}
	    error_log("Sms Mobile No".$mobileNo,0);
            //Define route
            $route = "4";

            //Prepare you post parameters
	    //   {\n  \"flow_id\": \"624da915eee1d1419e116a42\",\n  \"sender\": \"HYVECX\",\n  \"mobiles\": \"918248420402\",\n  \"VAR1\": \"VALUE 1\",\n  \"VA \ R2\": \"VALUE 2\"\n}
            $postData = '{
                "flow_id":"'.$this->onlineDispatchFlowID.'",
                "sender": "'.$this->senderID.'",
                "mobiles":"'.$mobileNo.'",
                "VAR1":"'.$orderform_number.'",
                "VAR2":"'.$shiping_mode.'",
                "VAR3":"'.$tracking_no.'"
}';        

            //API URL
            $url="https://api.msg91.com/api/v5/flow/";

            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",

            // CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "authkey: $this->authKey",
                "content-type: application/json"),
            ));

            //get response
            $response = curl_exec($ch);
            $err = curl_error($ch);
            
            curl_close($ch);

            if ($err) {
              echo "cURL Error #:" . $err;
            }
            else
            {
                $result = json_decode($response);

                if ($result->type === "success"){
                    return TRUE;
                }
                else{

                    return FALSE;
                }        
            }

        }        
    }


    public function send_offline_printing_order_sms($to,$orderform_number) 
    {
        // Check SMS Balance, if it has credit. It will send the message with $to, $message parameters.
	error_log("Offline Printinh Sms",0);
	$dd=0;
        if ($d > 0) {
            return false;   
        }
        else
        {
            //Your message to send, Add URL encoding here.
            $message = urlencode($message);
	    $mobileNo=$to;

	    if(strlen($to) ==10)
		{
		    $mobileNo="91".$to;
		}
	    elseif(strlen($to) ==12 && substr($to,0,1) =="91")
		{
		    $mobileNo=$to;

		}
	    error_log("Sms Mobile No".$mobileNo,0);
	    error_log(strlen($to),0);
            //Define route
            $route = "4";

            //Prepare you post parameters
	    //   {\n  \"flow_id\": \"624da915eee1d1419e116a42\",\n  \"sender\": \"HYVECX\",\n  \"mobiles\": \"918248420402\",\n  \"VAR1\": \"VALUE 1\",\n  \"VA \ R2\": \"VALUE 2\"\n}
            $postData = '{
                "flow_id":"'.$this->offlinePrintingFlowID.'",
                "sender": "'.$this->senderID.'",
                "mobiles":"'.$mobileNo.'",
                "VAR1":"'.$orderform_number.'",
                "VAR2":"HYVECX"
}';        

            //API URL
            $url="https://api.msg91.com/api/v5/flow/";

            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",

            // CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "authkey: $this->authKey",
                "content-type: application/json"),
            ));

            //get response
            $response = curl_exec($ch);
            $err = curl_error($ch);
            
            curl_close($ch);

            if ($err) {
              echo "cURL Error #:" . $err;
            }
            else
            {
                $result = json_decode($response);

                if ($result->type === "success"){
                    return TRUE;
                }
                else{

                    return FALSE;
                }        
            }

        }        
    }


    public function send_offline_stiching_order_sms($to,$orderform_number) 
    {
        // Check SMS Balance, if it has credit. It will send the message with $to, $message parameters.
	error_log("Offline Printinh Sms",0);
	$dd=0;
        if ($d > 0) {
            return false;   
        }
        else
        {
            //Your message to send, Add URL encoding here.
            $message = urlencode($message);
	    $mobileNo=$to;

	    if(strlen($to) ==10)
		{
		    $mobileNo="91".$to;
		}
	    elseif(strlen($to) ==12 && substr($to,0,1) =="91")
		{
		    $mobileNo=$to;

		}
	    error_log("Sms Mobile No".$mobileNo,0);
	    error_log(strlen($to),0);
            //Define route
            $route = "4";

            //Prepare you post parameters
	    //   {\n  \"flow_id\": \"624da915eee1d1419e116a42\",\n  \"sender\": \"HYVECX\",\n  \"mobiles\": \"918248420402\",\n  \"VAR1\": \"VALUE 1\",\n  \"VA \ R2\": \"VALUE 2\"\n}
            $postData = '{
                "flow_id":"'.$this->offlineStichingFlowID.'",
                "sender": "'.$this->senderID.'",
                "mobiles":"'.$mobileNo.'",
                "VAR1":"'.$orderform_number.'",
                "VAR2":"HYVECX"
}';        

            //API URL
            $url="https://api.msg91.com/api/v5/flow/";

            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",

            // CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "authkey: $this->authKey",
                "content-type: application/json"),
            ));

            //get response
            $response = curl_exec($ch);
            $err = curl_error($ch);
            
            curl_close($ch);

            if ($err) {
              echo "cURL Error #:" . $err;
            }
            else
            {
                $result = json_decode($response);

                if ($result->type === "success"){
                    return TRUE;
                }
                else{

                    return FALSE;
                }        
            }

        }        
    }

    public function send_dispatch_order_sms($to,$orderform_number,$tracking_no,$shiping_mode) 
    {
        // Check SMS Balance, if it has credit. It will send the message with $to, $message parameters.
	error_log("Dispatch Sms",0);
	$dd=0;
        if ($d > 0) {
            return false;   
        }
        else
        {
            //Your message to send, Add URL encoding here.
            $message = urlencode($message);
	    $mobileNo=trim($to);

	    if(strlen($to) ==10)
		{
		    $mobileNo="91".$to;
		}
	    elseif(strlen($to) ==12 && substr($to,0,1) =="91")
		{
		    $mobileNo=$to;

		}
	    error_log("Sms Mobile No".$mobileNo,0);
            //Define route
            $route = "4";

            //Prepare you post parameters
	    //   {\n  \"flow_id\": \"624da915eee1d1419e116a42\",\n  \"sender\": \"HYVECX\",\n  \"mobiles\": \"918248420402\",\n  \"VAR1\": \"VALUE 1\",\n  \"VA \ R2\": \"VALUE 2\"\n}
            $postData = '{
                "flow_id":"'.$this->offlineDispatchFlowID.'",
                "sender": "'.$this->senderID.'",
                "mobiles":"'.$mobileNo.'",
                "VAR1":"'.$orderform_number.'",
                "VAR2":"'.$shiping_mode.'",
                "VAR3":"'.$tracking_no.'"
}';        

            //API URL
            $url="https://api.msg91.com/api/v5/flow/";

            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",

            // CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "authkey: $this->authKey",
                "content-type: application/json"),
            ));

            //get response
            $response = curl_exec($ch);
            $err = curl_error($ch);
            
            curl_close($ch);

            if ($err) {
              echo "cURL Error #:" . $err;
            }
            else
            {
                $result = json_decode($response);

                if ($result->type === "success"){
                    return TRUE;
                }
                else{

                    return FALSE;
                }        
            }

        }        
    }

    public function send_schedule_order_sms($to) 
    {
        // Check SMS Balance, if it has credit. It will send the message with $to, $message parameters.
	$dd=0;
        if ($d > 0) {
            return false;   
        }
        else
        {
            //Your message to send, Add URL encoding here.
            $message = urlencode($message);
	    $mobileNo=$to;

	    if(strlen($to) ==10)
		{
		    $mobileNo="91".$to;
		}
	    elseif(strlen($to) ==12 && substr($to,0,1) =="91")
		{
		    $mobileNo=$to;

		}
	    error_log("Sms Mobile No".$mobileNo,0);
	    error_log(strlen($to),0);
            //Define route
            $route = "4";

            //Prepare you post parameters
	    //   {\n  \"flow_id\": \"624da915eee1d1419e116a42\",\n  \"sender\": \"HYVECX\",\n  \"mobiles\": \"918248420402\",\n  \"VAR1\": \"VALUE 1\",\n  \"VA \ R2\": \"VALUE 2\"\n}
            $postData = '{
                "flow_id":"'.$this->offlineFlowID.'",
                "sender": "'.$this->senderID.'",
                "mobiles":"'.$mobileNo.'",
                "VAR1":"HYVECX",
                "VAR2":"HYVECX"
}';        

            //API URL
            $url="https://api.msg91.com/api/v5/flow/";

            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",

            // CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "authkey: $this->authKey",
                "content-type: application/json"),
            ));

            //get response
            $response = curl_exec($ch);
            $err = curl_error($ch);
            
            curl_close($ch);

            if ($err) {
              echo "cURL Error #:" . $err;
            }
            else
            {
                $result = json_decode($response);

                if ($result->type === "success"){
                    return TRUE;
                }
                else{

                    return FALSE;
                }        
            }

        }        
    }

    public function send_schedule_online_order_sms($to) 
    {
        // Check SMS Balance, if it has credit. It will send the message with $to, $message parameters.
	$dd=0;
        if ($d > 0) {
            return false;   
        }
        else
        {
            //Your message to send, Add URL encoding here.

            $message = urlencode($message);
	    $cnt=count($to);
	    error_log("count ==".$cnt,0);
	    /*	    $mobileNo=$to;

	    if(strlen($to) ==10)
		{
		    $mobileNo="91".$to;
		}
	    elseif(strlen($to) ==12 && substr($to,0,1) =="91")
		{
		    $mobileNo=$to;

		}
	    error_log("Sms Mobile No".$mobileNo,0);
	    error_log(strlen($to),0);
	    */
            //Define route
            $route = "4";
	    $i=0;
            //Prepare you post parameters
	    //   {\n  \"flow_id\": \"624da915eee1d1419e116a42\",\n  \"sender\": \"HYVECX\",\n  \"mobiles\": \"918248420402\",\n  \"VAR1\": \"VALUE 1\",\n  \"VA \ R2\": \"VALUE 2\"\n}
            $postData = '{
                "flow_id":"'.$this->onlineFlowID.'",
                "sender": "'.$this->senderID.'",
"recipients": [';

	    foreach($to as $m)
		{
		    $i++;
		    $mobileNo=$m;
		    if(strlen($m) ==10)                                                                                                                                        
			{                                                                                                                                                       
			    $mobileNo="91".$m;                                                                                                                                 
			}                                                                                                                                                       
		    elseif(strlen($m) ==12 && substr($m,0,1) =="91")                                                                                                          
			{                                                                                                                                                       
			    $mobileNo=$m;                                                                                                                                      
                                                                                                                                                                        
			}          
    $postData .='{
                "mobiles":"'.$mobileNo.'",
                   "VAR1":"HYVECX",
                   "VAR2":"HYVECX"

}';
    if($i!=$cnt){
	$postData .=',';
    }

		}
 $postData .=']
                   }';



            //API URL
            $url="https://api.msg91.com/api/v5/flow/";

            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",

            // CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "authkey: $this->authKey",
                "content-type: application/json"),
            ));

            //get response
            $response = curl_exec($ch);
            $err = curl_error($ch);
            
            curl_close($ch);

            if ($err) {
              echo "cURL Error #:" . $err;
            }
            else
            {
                $result = json_decode($response);

                if ($result->type === "success"){
                    return TRUE;
                }
                else{

                    return FALSE;
                }        
            }

        }        
    }




}





























?>
