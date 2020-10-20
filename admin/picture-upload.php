<?php

include_once('../functions/picture-function.php');
$pictureFn = new pictureFunction();

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($actual_link);
parse_str($parts['query'], $query);
$pId = $query['pId'];

echo "uploading...";
if (isset($_POST['submit'])) {
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $tmpName = $file['tmp_name'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $fileNewName = uniqid('', true) . "." . $fileActualExt;
    $fileDestination = "../uploads/" . $fileNewName;
    move_uploaded_file($tmpName, $fileDestination);

    $result = $pictureFn->pictureCreate($fileNewName, $pId);
    if ($result) {
        echo "<script>window.location.href='./product-picture.php?pId=$pId'</script>";
    } else {
        echo "<script>window.alert('Failed to upload file.')</script>";
        echo "<script>window.location.href='./product-picture.php?pId=$pId'</script>";
    }
}
