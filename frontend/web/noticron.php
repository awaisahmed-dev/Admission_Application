<?php
error_reporting(E_ERROR | E_PARSE);
 ini_set('max_execution_time', 300);        ini_set('memory_limit', '1024M');
$servername = "localhost";
$username = "uschool_admin";
$password = "RfTV?B#1zop}";
$dbname = "schooladmindb";
// /usr/local/bin/php -q /home/deezmedia45/public_html/schooladmin/frontend/web/noticron.php	
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

 $url = 'https://www.hajanaone.com/api/sendsms.php';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec ($ch);

        if (preg_match( "/101/", $result )){
        SendNOtificationFromHajana();
        
        }else {            var_dump($result);}

    function SendNOtificationFromHajana($schoolid = 22){
            //$notificationCount = 0;
        global $conn;
        $sql = "SELECT * FROM notification where school_id='".$schoolid."' AND (STATUS = 1 or STATUS = 101) and created_at > ".strtotime(date('Y-m-d', strtotime( '-2 day') ) )." ORDER BY id DESC LIMIT 15";
        $result = $conn->query($sql);
                
                if ($result->num_rows == 0) { return ;}
               
//        try{
        $mh = curl_multi_init();
        
        $requests = array();
        //$schoolid =Yii::$app->user->school->id;
        //$sett = (json_decode(Yii::$app->keyStorage->get("$schoolid@school.settings")));
        if ($result->num_rows > 0) {
            // output data of each row
            $k=0;
            while($row = $result->fetch_assoc()) {
                
                
                //if($sett->sms_api == 'hajanaone'){            //die("going to hajana");
                    
        
//                  print ">>". $k. 
                   $url = loadHajanaURL($row);
                   $requests[$k]['curl_handle'] = curl_init($url);
                   $requests[$k]['not_id'] = $row['id'];
				   $requests[$k]['not_status'] = $row['status'];
                    curl_setopt($requests[$k]['curl_handle'], CURLOPT_URL,$url);
                    curl_setopt($requests[$k]['curl_handle'], CURLOPT_RETURNTRANSFER,1);
                    curl_setopt($requests[$k]['curl_handle'], CURLOPT_HEADER, 0);


                    curl_multi_add_handle($mh, $requests[$k]['curl_handle']);
//                    if($this->sendFromHajana($noti) == 1){
//                        $notificationCount++;
//                        $noti->status = 5; $noti->save();
//                    
//                    }else{$noti->status = '-10'; $noti->save();}
                //}
                    $k++;
            }
        
        }
//        die;
        //Execute our requests using curl_multi_exec.
        $stillRunning = false;
        do {
            curl_multi_exec($mh, $stillRunning);
            curl_multi_select($mh, 3);
//             sleep(3); // Maybe needed to limit CPU load (See P.S.)
        } while ($stillRunning);
         
         $servername = "localhost";
        $username = "uschool_admin";
        $password = "RfTV?B#1zop}";
        $dbname = "schooladmindb";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        try {
        //Loop through the requests that we executed.
        foreach($requests as $k => $request){
            //Remove the handle from the multi handle.
            curl_multi_remove_handle($mh, $request['curl_handle']);
            //Get the response content and the HTTP status code.
            $requests[$k]['content'] = curl_multi_getcontent($request['curl_handle']);
            $requests[$k]['http_code'] = curl_getinfo($request['curl_handle'], CURLINFO_HTTP_CODE);
            
//            $noti = Notification::findOne($requests[$k]['not_id']);
//            $noti->api_response = $requests[$k]['content'];
            
            $notificationCount++;
            if (preg_match( "/successfully/", $requests[$k]['content'] )){
//            echo $requests[$k]['not_id'].'SMS successfully Sent.<br>';
            
//            $pendingNotifications[$k]->status = 5; $pendingNotifications[$k]->save();
                    
//                    print "<br />".$requests[$k]['not_id'];			

                    $conn->query('update notification set status = 5, api_response = "'.$requests[$k]['content'].'" where id = '.$requests[$k]['not_id'])
                            or print "error".$conn->error;
//            return 1;
            }else{
//                echo $requests[$k]['not_id'].'SMS Sending Failed.';
                    if($requests[$k]['not_status'] == 101)
//                    print "<br />". $requests[$k]['not_id'];
                    $fsql = 'update notification set status = -10, api_response = "'.addslashes($requests[$k]['content']).'" where id = "'.$requests[$k]['not_id'].'";';
                    else
					$fsql = 'update notification set status = 101, api_response = "'.addslashes($requests[$k]['content']).'" where id = "'.$requests[$k]['not_id'].'";';	
					$conn->query($fsql) 
					or print "Error:".$conn->error.'<br /> SQL:'.$fsql;
//                    print_r($noti->getErrors());
//                $pendingNotifications[$k]->status = -10; $pendingNotifications[$k]->save();
//                return  0;
            }
            //Close the handle.
//            curl_close($requests[$k]['curl_handle']);
        }
        } catch (\yii\db\Exception $e) { print "Exception:".$e->getMessage(). $e->getCode();
        
            Yii::$app->db->open();
        }
        //Close the multi handle.
        curl_multi_close($mh);
//        sleep(15);
//        $this->sendMultipleFromHajana($schoolID);

    }

    function loadHajanaURL($row){
        
        $api    =   'PY2M8ZVbEeWJMVGE543D';            //  Hajana One account API
//        $api    =   'AbCdEfGhIJkLmNoPqRsTuVwXyZ';           //  Hajana One account API
        $number =   $row['to_number'];                           //  Mobile Number
        $mask   =   'SmartSMS';                             //  Registered Mask Name
        $mask   =   'Al-Hira Hyd';                             //  Registered Mask Name
        $text   =   $row['contents'];                     //  Message Content
//        $oper   =   1;                                      //  If Number is Ported to telenor
        //if(substr($number, 0, 2) == '03' ) 
		//$number = str_replace('03', '923', $number);
		$pos = strpos($number, '03');
		if ($pos !== false) {
			$number = substr_replace($number, '923', $pos, strlen('03'));
		}
		
		$number = str_replace('-', '', $number);
		
		//print "substr".substr($number, 0, 2);
       //return $url = 'https://www.hajanaone.com/api/zero.php?apikey='.$api.'&phone='.$number.'&sender='.urlencode($mask).'&message='.urlencode($text); //.'&operator='.$oper;
       return $url = 'https://www.hajanaone.com/api/sendsms.php?apikey='.$api.'&phone='.$number.'&sender='.urlencode($mask).'&message='.urlencode($text); //.'&operator='.$oper; 
        
    }    