<?php

include_once('./functions/cart-function.php');

$cartFn = new cartFunction();

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($actual_link);
parse_str($parts['query'], $query);
$cartId = $query['cartId'];

$result = $cartFn->cartDelete($cartId);
if ($result) {
    header('location: ./cart.php');
}
