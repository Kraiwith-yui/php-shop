<?php

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($actual_link);
parse_str($parts['query'], $query);
$orderId = $query['oId'];

include_once('../functions/order-function.php');
$orderFn = new orderFunction();

$result = $orderFn->orderStatusSuccess($orderId);
if ($result) {
    header('location: ./?tab=order');
} else {
    echo "<script>window.alert('Update Status Failed!');</script>";
    echo "<script>window.location.href='./?tab=order';</script>";
}
