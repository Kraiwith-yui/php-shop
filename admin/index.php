<?php

session_start();
if (!isset($_SESSION['Member'])) {
    return header('location: ../login.php');
}
$member = $_SESSION['Member'];
if ($member['Member_role'] != 'Admin') {
    return header('location: ../');
}

include_once("../functions/product-function.php");
include_once("../functions/picture-function.php");
include_once("../functions/order-function.php");
$productFn = new productFunction();
$pictureFn = new pictureFunction();
$orderFn = new orderFunction();

$products = $productFn->productGetAll();
$orders = $orderFn->getOrderAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namploy Shop</title>
    <link rel="icon" href="../assets/logo.ico" type="image/ico">

    <?php include_once('../assets/styles.html'); ?>
    <style>
        .img-product {
            width: 100px;
            height: 100px;
            margin: 0 5px 5px;
            padding: 5px;
            object-fit: contain;
            border: 1px solid #ccc;
        }
        .order-img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            margin: 0 5px 5px;
        }
    </style>
</head>

<body>
    <div class="container my-3">
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link active" id="product-tab" onclick="changeTab(this)">รายการสินค้า</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="order-tab" onclick="changeTab(this)">รายการใบสั่งซื้อ</a>
            </li>
        </ul>

        <div class="d-block" id="product-show">
            <div class="form-inline mb-3">
                <h3>รายการสินค้า</h3>

                <a href="./product-create.php" class="ml-auto">
                    <button type="button" class="btn btn-primary"> <i class="fas fa-plus"></i> สร้างสินค้า </button> </a>
            </div>

            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>รหัสสินค้า</th>
                        <th width="250px">รูป</th>
                        <th>ชื่อสินค้า</th>
                        <th>รายละเอียด</th>
                        <th width="150px">ราคา</th>
                        <th width="150px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($product = $products->fetch_assoc()) {
                        $Pictures = $pictureFn->pictureGetByProductId($product['Product_id']);
                    ?>
                        <tr>
                            <td class="text-center"> <?php echo $product["Product_id"]; ?> </td>
                            <td>
                                <?php
                                while ($picture = $Pictures->fetch_assoc()) {
                                ?>
                                    <img class="img-product" <?php echo "src='../uploads/" . $picture['Picture_name'] . "'"; ?> alt="">
                                <?php
                                }
                                ?>
                            </td>
                            <td> <?php echo $product["Product_name"]; ?> </td>
                            <td> <?php echo $product["Product_description"]; ?> </td>
                            <td class="text-right"> <?php echo number_format($product["Product_price"]); ?> บาท </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a <?php echo "href='./product-update.php?pId=" . $product["Product_id"] . "'" ?> class="btn btn-warning">
                                        <i class="fas fa-edit"></i> แก้ไข </a>
                                    <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                                        <div class="sr-only">Dropdown</div>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item text-warning" <?php echo "href='./product-update.php?pId=" . $product["Product_id"] . "'" ?>>
                                            <i class="fas fa-edit"></i> แก้ไขข้อมูล </a>
                                        <a class="dropdown-item text-warning" <?php echo "href='./product-picture.php?pId=" . $product["Product_id"] . "'" ?>>
                                            <i class="fas fa-images"></i> แก้ไขรูป </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" <?php echo "href='./product-delete.php?pId=" . $product["Product_id"] . "'" ?>>
                                            <i class="fas fa-trash"></i> ลบสินค้า </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="d-none" id="order-show">
            <div class="form-inline mb-3">
                <h3>รายการใบสั่งซื้อ</h3>
            </div>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>รหัสใบสั่งซื้อ</th>
                        <th width="20%">สินค้า</th>
                        <th>ราคารวม</th>
                        <th>จำนวน</th>
                        <th width="30%">ที่อยู่</th>
                        <th>เบอร์โทร</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($order = $orders->fetch_assoc()) {
                        $product = $productFn->productGetById($order['Product_id'])->fetch_assoc();
                        $picture = $pictureFn->pictureGetByProductId($order['Product_id'])->fetch_assoc();
                    ?>
                        <tr>
                            <td class="text-center"> <?php echo $order['Order_id']; ?> </td>
                            <td>
                                <img class="order-img" src="<?php echo "../uploads/" . $picture['Picture_name']; ?>" alt="">
                                <?php echo $product['Product_name']; ?>
                            </td>
                            <td class="text-right"> <?php echo "฿" . number_format($order['Order_price']); ?> </td>
                            <td class="text-right"> <?php echo number_format($order['Order_amount']); ?> </td>
                            <td> <?php echo $order['Order_address']; ?> </td>
                            <td> <?php echo $order['Order_phone']; ?> </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include_once('../assets/scripts.html'); ?>
    <script>
        function changeTab(event) {
            const allNavLink = document.getElementsByClassName('nav-link');
            for (let index = 0; index < allNavLink.length; index++) {
                const element = allNavLink[index];
                element.className = 'nav-link';
            }

            event.className = 'nav-link active';

            const productShow = document.getElementById('product-show');
            const orderShow = document.getElementById('order-show');
            if (event.id == 'product-tab') {
                productShow.className = 'd-block';
                orderShow.className = 'd-none';
            } else {
                productShow.className = 'd-none';
                orderShow.className = 'd-block';
            }
        }
    </script>
</body>

</html>