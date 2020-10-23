<?php
session_start();

include_once('functions/product-function.php');
include_once('functions/picture-function.php');

$productFn = new productFunction();
$pictureFn = new pictureFunction();

$products = $productFn->productGetAll();

if (isset($_SESSION['Member'])) {
    $member = $_SESSION['Member'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="./">
    <title>Namploy Shop</title>
    <link rel="icon" href="assets/logo.ico" type="image/ico">

    <?php include_once('assets/styles.html'); ?>
    <style>
        a.card-link {
            color: #000 !important;
            display: block;
        }

        .product-card {
            transition: 0.2s all ease;
            cursor: pointer;
        }

        .product-card:hover {
            transform: scale(1.02);
        }

        .product-img {
            height: 250px;
            border-bottom: 1px solid #eeeeee;
            object-fit: cover;
        }

        .product-card .card-body {
            height: 140px;
        }
    </style>
</head>

<body>
    <?php include_once('components/navbar.php'); ?>

    <div class="container py-5">
        <?php if (isset($_SESSION['newLogin'])) {
            $_SESSION['newLogin'] = null;
        ?>
            <div class="alert-success p-3 mb-3">
                <h3 class="m-0 text-capitalize">Welcome <?php echo $member['Member_fullname'] . "."; ?></h3>
            </div>
        <?php } ?>

        <div class="row">
            <?php
            while ($product = $products->fetch_assoc()) {
                $pictures = $pictureFn->pictureGetByProductId($product['Product_id']);
                $picture = $pictures->fetch_assoc();
            ?>
                <div class="col-12 col-sm-6 col-xl-4 mb-5">
                    <a <?php echo "href='product-detail.php?pId=" . $product['Product_id'] . "'"; ?> class="card-link" title="คลิกดูรายละเอียด" data-toggle="tooltip" data-placement="bottom">
                        <div class="card product-card">
                            <?php if (isset($picture['Picture_name'])) { ?>
                                <img class="product-img" <?php echo "src='uploads/" . $picture['Picture_name'] . "'" ?> alt="" class="card-img-top">
                            <?php } else { ?>
                                <img class="product-img" <?php echo "src='assets/no-image.png'" ?> alt="" class="card-img-top">
                            <?php } ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"> <?php echo $product['Product_name']; ?> </h5>
                                <p class="card-text text-muted text-ellipsis"> <?php echo $product['Product_description']; ?> </p>
                                <h5 class="mt-auto mb-0 text-center price"><?php echo "฿", number_format($product['Product_price']); ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>

    </div>

    <?php include_once('assets/scripts.html'); ?>
</body>

</html>