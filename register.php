<?php

session_start();
include_once('functions/member-function.php');
$memberFn = new memberFunction();

if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $result = $memberFn->memberRegister($username, $password, $fullname, $email);
    echo "<br> =>" . $result;
    if ($result) {
        $_SESSION['register'] = 'registered success';
        header('location: login.php');
    } else {
        echo "<script>window.alert('Failed to Register!');</script>";
    }
}

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

    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-6">
                <form method="POST">
                    <div class="card">
                        <h3 class="card-header text-center"> สมัครสมาชิก </h3>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="fullname"> ชื่อ-สกุล </label>
                                <input type="text" id="fullname" name="fullname" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email"> อีเมล </label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group mb-1">
                                <label for="username"> ชื่อผู้ใช้ </label>
                                <div class="input-group">
                                    <input type="text" id="username" name="username" class="form-control" required onblur="onCheckUsername()">
                                    <span class="input-group-append">
                                        <a class="input-group-text text-secondary" onclick="onCheckUsername()"> <i class="fas fa-sync"></i> </a>
                                    </span>
                                </div>
                                <span id="uname-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="password"> รหัสผ่าน </label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-inline">
                                <button type="submit" id="submit" name="submit" class="btn btn-block btn-primary" disabled> สมัครสมาชิก </button>
                                <span>มีบัญชีอยู่แล้ว? <a href="./login.php" class=""> เข้าสู่ระบบ </a></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once('./assets/scripts.html'); ?>
    <script>
        function onCheckUsername() {
            const uNameValue = document.getElementById('username').value.trim();
            const uNameErrEl = document.getElementById('uname-error');
            const btnSubmit = document.getElementById('submit');

            if (uNameValue) {
                $.ajax({
                    method: 'post',
                    url: 'functions/member-exists.php',
                    data: 'username=' + uNameValue,
                    success: function(data) {
                        if (data) {
                            uNameErrEl.className = 'alert-danger px-3 py-1';
                            uNameErrEl.innerHTML = '<i class="fas fa-times"></i> ' + 'มีผู้ใช้ชื่อบัญชีนี้อยู่แล้ว';
                            btnSubmit.setAttribute('disabled');
                        } else {
                            uNameErrEl.className = 'alert-success px-3 py-1';
                            uNameErrEl.innerHTML = '<i class="fas fa-check"></i> ' + 'สามารถใช้ชื่อบัญชีนี้ได้';
                            btnSubmit.removeAttribute('disabled');
                        }
                    }
                });
            } else {
                uNameErrEl.className = 'alert-danger px-3 py-1';
                uNameErrEl.innerHTML = '<i class="fas fa-times"></i> ' + 'ไม่สามาถใช้ชื่อบัญชีนี้ได้';
                btnSubmit.setAttribute('disabled');
            }
        }
    </script>
</body>

</html>