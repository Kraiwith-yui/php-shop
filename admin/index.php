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

$productFn = new productFunction();
$pictureFn = new pictureFunction();

$products = $productFn->productGetAll();

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
    </style>
</head>

<body>
    <div class="container-fluid mt-3">
        <h5>รายการสินค้า</h5>

        <div class="form-inline mb-3">
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

    <?php include_once('../assets/scripts.html'); ?>
</body>

</html>