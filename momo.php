<?php

session_start();
error_reporting(0);
include('includes/config.php');

//get total price

$pdtid = array();
$sql = "SELECT * FROM products WHERE id IN(";
foreach ($_SESSION['cart'] as $id => $value) {
	$sql .= $id . ",";
}
$sql = substr($sql, 0, -1) . ") ORDER BY id ASC";
$query = mysqli_query($con, $sql);
$totalprice = 0;
$totalqunty = 0;
$total_shipping = 0;
$items = array();
if (!empty($query)) {
	while ($row = mysqli_fetch_array($query)) {
		$quantity = $_SESSION['cart'][$row['id']]['quantity'];
		$subtotal = $_SESSION['cart'][$row['id']]['quantity'] * $row['productPrice'] + $row['shippingCharge'];
		$totalprice += $subtotal;
		$total_shipping += $row['shippingCharge'];
		$_SESSION['qnty'] = $totalqunty += $quantity;
		//Get items list
		$arr = array($row['productName'], $rowz['productDescription'], $quantity, $row['productPrice'], "0", $row['productCompany'], "USD");
		array_push($items, $arr);
		array_push($pdtid, $row['id']);
		//print_r($_SESSION['pid'])=$pdtid;exit;
	}
}

//Lay thong tin dia chi khach hang
$sql = "select * from users where id= " . $_SESSION['id'];
$result = mysqli_query($con, $sql);
$data = mysqli_fetch_array($result, MYSQLI_ASSOC);
//print_r($data);

//Lay orderID
$sql = "select MAX(id) as order_id from  orders where userId= " . $_SESSION['id'];
$result = mysqli_query($con, $sql);
$order_id = mysqli_fetch_array($result, MYSQLI_ASSOC)['order_id'];

header('Content-type: text/html; charset=utf-8');

function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}




$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

$orderInfo = "Thanh toán qua MoMo";
$amount = $totalprice;
$orderId = time() ."";
$redirectUrl = "http://localhost/source/momo.php";
$ipnUrl = "http://localhost/source/momo.php";
$extraData = "";


    $requestId = time() . "";
    $requestType = "payWithATM";
    $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
    //before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    $data = array('partnerCode' => $partnerCode,
        'partnerName' => "Test",
        "storeId" => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature);
    $result = execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);  // decode json

    //Just a example, please check more in there

    header('Location: ' . $jsonResult['payUrl']);

?>