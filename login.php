<?php
session_start();
include_once('functions/member-function.php');

$memberFn = new memberFunction();

if (isset($_POST['submit'])) {
    $uName = $_POST['username'];
    $pass = md5($_POST['password']);

    $result = $memberFn->memberLogin($uName, $pass);
    if ($result->num_rows >= 1) {
        $member = $result->fetch_assoc();
        $_SESSION['Member'] = $member;
        $_SESSION['newLogin'] = 'Welcome.';
        echo "<script> window.location.href = './'; </script>";
    } else {
        echo "<script> window.alert('Username or Password incorrected!'); </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namploy Shop</title>
    <link rel="icon" href="assets/logo.ico" type="image/ico">

    <?php include_once('./assets/styles.html'); ?>
</head>

<body>
    <?php include_once('./components/navbar.php'); ?>

    <div class="container pt-3">
        <div class="row justify-content-center">
            <?php if (isset($_SESSION['register'])) {
                session_destroy();
            ?>
                <div class="col-12 mb-3">
                    <div class="alert-success p-3">
                    <i class="fas fa-check-double"></i> สมัครสมาชิกสำเร็จ เข้าสู่ระบบได้แล้ว
                    </div>
                </div>
            <?php } ?>

            <div class="col-6">
                <form method="POST">
                    <div class="card">
                        <h3 class="card-header text-center"> เข้าสู่ระบบ </h3>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="username"> Username </label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="pass"> Password </label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-inline">
                                <button type="submit" name="submit" class="btn btn-block btn-primary"> เข้าสู่ระบบ </button>
                                <span>ยังไม่มีบัญชี? <a href="./register.php" class=""> สมัครสมาชิก </a></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once('./assets/scripts.html'); ?>
    <script>
        document.getElementById('username').focus();
    </script>
</body>

</html>