<?php

include_once('./cart-function.php');

$cartFn = new cartFunction();

$cartId = $_POST['cartId'];
$cartAmount = $_POST['amount'];
$result = $cartFn->cartUpdateAmount($cartId, $cartAmount);

if ($result) {
    echo "Cart Amount Updated";
} else {
    echo "";
}
