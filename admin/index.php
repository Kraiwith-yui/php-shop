<?php

session_start();
if (!isset($_SESSION['Member'])) {
    return header('location: ../login.php');
}
$member = $_SESSION['Member'];
if ($member['Member_role'] != 'Admin') {
    return header('location: ../');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namploy Shop</title>
    <link rel="icon" href="../assets/logo.ico" type="image/ico">

    <?php include_once('../assets/styles.html'); ?>
</head>

<body>
    <div class="container my-3">
        <h1 class="">หลังบ้านน้ำพลอย</h1>
        <div class="row mt-3">
            <div class="col-12 col-sm-6 col-md-4 mb-3">
                <a href="product.php" class="d-block text-success">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center m-0"> <i class="fab fa-product-hunt"></i> จัดการสินค้า</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 mb-3">
                <a href="order.php" class="d-block text-warning">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center m-0"> <i class="fas fa-file-alt"></i> ใบสั่งซื้อ</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 mb-3">
                <a href="sale-summary.php" class="d-block text-info">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center m-0"> <i class="fas fa-list-alt"></i> สรุปการขาย</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <?php include_once('../assets/scripts.html'); ?>
</body>

</html>