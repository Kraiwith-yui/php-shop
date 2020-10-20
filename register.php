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
            <div class="col-6">
                <div class="card">
                    <h3 class="card-header text-center"> สมัครสมาชิก </h3>
                    <div class="card-body">
                        <div class="form-group">
                            <label for=""> Username </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for=""> Password </label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for=""> Fullname </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-inline">
                            <button type="submit" class="btn btn-block btn-primary"> สมัครสมาชิก </button>
                            <span>มีบัญชีอยู่แล้ว? <a href="./login.php" class=""> เข้าสู่ระบบ </a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('./assets/scripts.html'); ?>
</body>

</html>