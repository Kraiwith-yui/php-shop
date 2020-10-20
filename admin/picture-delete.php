<?php

include_once('../functions/picture-function.php');
$pictureFn = new pictureFunction();

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($actual_link);
parse_str($parts['query'], $query);
$pictureId = $query['pictureId'];
$productId = $query['productId'];

$result = $pictureFn->pictureDelete($pictureId);
if ($result) {
    echo "<script>window.location.href='./product-picture.php?pId=$productId'</script>";
} else {
    echo "<script>window.alert('Failed to delete file.')</script>";
    echo "<script>window.location.href='./product-picture.php?pId=$productId'</script>";
}
