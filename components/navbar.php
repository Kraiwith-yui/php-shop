<?php

$member = null;
if (isset($_SESSION['Member'])) {
    $member = $_SESSION['Member'];

    include_once('functions/cart-function.php');
    $cartFn = new cartFunction();
    $carts = $cartFn->cartGetByMemberId($member['Member_id']);
    $cartNum = $carts->num_rows;
}



?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container">
        <a class="navbar-brand p-0" href="./"> <img src="assets/logo.png" alt="" width="50px"> </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./">หน้าหลัก <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <?php if (!isset($member)) { ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"> เข้าสู่ระบบ </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php"> สมัครสมาชิก </a>
                    </li>
                </ul>
            <?php } else { ?>
                <a href="cart.php" class="ml-auto" title="รถเข็น" data-toggle="tooltip" data-placement="bottom">
                    <i class="fas fa-shopping-cart text-warning"></i>
                    <?php if ($cartNum > 0) { ?>
                        <span class="badge badge-warning rounded-circle"><?php echo $cartNum; ?></span>
                    <?php } ?>
                </a>
                <div class="btn-group ml-3">
                    <a class="dropdown-toggle text-light text-capitalize" data-toggle="dropdown"> <?php echo $member['Member_fullname'] ?> </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="member-detail.php"> <i class="fas fa-user fa-fw"></i> ข้อมูลสมาชิก </a>
                        <a class="dropdown-item" href="order.php"> <i class="fas fa-clipboard-list fa-fw"></i> คำสั่งซื้อ </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="logout.php"> <i class="fas fa-power-off fa-fw"></i> ออกจากระบบ </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>