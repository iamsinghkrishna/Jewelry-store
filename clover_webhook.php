<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST,REQUEST');
$servername = "localhost";
$username   = "vaskia_dev";
$password   = "vaskia_dev@123#";
$db         = "vaskia_live";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

$output= file_get_contents("php://input");
$output1 = json_decode($output, true);

$itemid  = explode(":", $output1['merchants']['JPPGXW58BE9NC'][0]['objectId']);
if ($output1['merchants']['JPPGXW58BE9NC'][0]['type'] == 'UPDATE') {
    $data   = curlPost('https://api.clover.com:443/v3/merchants/JPPGXW58BE9NC/items/'.$itemid[1].'?expand=itemStock',NULL);
   $data1=json_decode($data,TRUE);
    $update = "update it_products set modifieddate='".date("Y-m-d H:i:s",($data1['modifiedTime']/1000))."', quantity='".$data1['itemStock']['stockCount']."' where product_sku='".$data1['code']."' and clover_id='".$data1['id']."'";
    $conn->query($update);
   
}

//$result = file_get_contents('https://requestb.in/1gv1m381');
//    echo $result;

function curlPost($url, $post_data = NULL)
{
$access_token = "ce23e90a-5083-d6f0-23b0-bb72a20e3de5";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,
        array('Content-Type: application/json', 'Authorization: Bearer '.$access_token
        )
    );
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    if ($post_data != NULL) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    }
    $data      = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return $data;
}
?>
