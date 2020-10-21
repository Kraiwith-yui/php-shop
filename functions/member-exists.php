<?php

include_once('member-function.php');

$memberFn = new memberFunction();

$username = $_POST['username'];
$members = $memberFn->memberExists($username);

if ($members->num_rows > 0) {
    echo "Already exists.";
} else {
    echo "";
}
