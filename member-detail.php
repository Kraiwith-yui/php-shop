<?php

session_start();
if (!isset($_SESSION['Member'])) {
    header('location: ./');
}
$member = $_SESSION['Member'];

include_once('functions/member-function.php');
$memberFn = new memberFunction();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namploy Shop</title>
    <link rel="icon" href="./assets/logo.ico" type="image/ico">

    <?php include_once('./assets/styles.html'); ?>
</head>

<body>
    <?php include_once('./components/navbar.php'); ?>

    <div class="container pt-3 pb-5">
        <h2> <i class="fas fa-user-circle"></i> ข้อมูลสมาชิก </h2>
        <div class="card">
            <div class="card-body">
                <div class="container-fluid" id="show-detail">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="text-muted"> ชื่อ-สกุล </label>
                            <p> <?php echo $member['Member_fullname'] ?? '-'; ?> </p>
                            <label for="" class="text-muted"> เลขประจำตัวประชาชน </label>
                            <p> <?php echo $member['Member_idcard'] ?? '-'; ?> </p>
                            <label for="" class="text-muted"> อีเมล </label>
                            <p> <?php echo $member['Member_email'] ?? '-'; ?> </p>
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="text-muted"> เพศ </label>
                                    <p> <?php echo $member['Member_gender'] ?? '-'; ?> </p>
                                </div>
                                <div class="col-6">
                                    <label for="" class="text-muted"> อายุ </label>
                                    <p> <?php echo $member['Member_age'] ?? '-'; ?> </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="" class="text-muted"> เบอร์โทร </label>
                            <p> <?php echo $member['Member_phone'] ?? '-'; ?> </p>
                            <label for="" class="text-muted"> ที่อยู่ </label>
                            <p> <?php echo $member['Member_address'] ?? '-'; ?> </p>

                            <a href="member-update.php" style="position: absolute; bottom: 0; right: 0;">
                                <button type="button" class="btn btn-info"> <i class="fas fa-edit"></i> แก้ไขข้อมูล </button> </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>

    <?php include_once('./assets/scripts.html'); ?>
</body>

</html>