<?php
if ($_REQUEST['act']=='iamathome') {
$token = '141552c74b88c81395f0fe00a993b77a847d4359f0f64b141965208ce14c52d06f84a4dc583ac7c2565fe';
$request_params = array(
'message' => "Я дома",
'user_id' => "186088",
'access_token' => $token,
'v' => '5.0'
);
    
$get_params = http_build_query($request_params);
$x=file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);
$x=str_split($x);
if ($x[0].$x[1].$x[2].$x[3].$x[4].$x[5].$x[6].$x[7].$x[8].$x[9].$x[10].$x[11]=='{"response":') die ("ok");
die ("error");
}
if ($_REQUEST['act']=='spam-it') {
   $token = '141552c74b88c81395f0fe00a993b77a847d4359f0f64b141965208ce14c52d06f84a4dc583ac7c2565fe';
$request_params = array(
'message' => "Test.spam.message",
'user_id' => "345283375",
'access_token' => $token,
'v' => '5.0'
);
    while (1) {
$get_params = http_build_query($request_params);
$x=file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);
    }
}
?>
