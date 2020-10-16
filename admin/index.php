<?php
include_once("../functions/product-function.php");
include_once("../functions/image-function.php");

$productFn = new productFunction();
$imageFn = new imageFunction();

$products = $productFn->productGetAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namploy Shop</title>

    <?php include_once('../assets/styles.html'); ?>
    <style>
        .img-product {
            width: 100px;
            margin: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <h5>รายการสินค้า</h5>

        <div class="form-inline mb-3">
            <a href="./product-create.php" class="ml-auto">
                <button type="button" class="btn btn-primary"> <i class="fas fa-plus"></i> Create </button> </a>
        </div>

        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Images</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th width="300px"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($product = $products->fetch_assoc()) {
                    $images = $imageFn->imageGetByProuctId($product['Product_id']);
                ?>
                    <tr>
                        <td> <?php echo $product["Product_id"]; ?> </td>
                        <td class="text-center">
                            <?php
                            while ($image = $images->fetch_assoc()) {
                            ?>
                                <img class="img-product" <?php echo "src='../uploads/" . $image['Image_name'] . "'"; ?> alt="">
                            <?php
                            }
                            ?>
                        </td>
                        <td> <?php echo $product["Product_name"]; ?> </td>
                        <td> <?php echo $product["Product_desc"]; ?> </td>
                        <td class="text-right"> <?php echo $product["Product_price"]; ?> </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a <?php echo "href='./product-update.php?pId=" . $product["Product_id"] . "'" ?>>
                                    <button type="button" class="btn btn-warning"> <i class="fas fa-edit"></i> Update Info</button> </a>
                                <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                                    <div class="sr-only">Dropdown</div>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item text-warning" <?php echo "href='./product-update.php?pId=" . $product["Product_id"] . "'" ?>>
                                        <i class="fas fa-edit"></i> Update Info </a>
                                    <a class="dropdown-item text-warning" <?php echo "href='./product-image.php?pId=" . $product["Product_id"] . "'" ?>>
                                        <i class="fas fa-edit"></i> Update Image </a>
                                </div>
                            </div>
                            <a class="ml-3" <?php echo "href='./product-delete.php?pId=" . $product["Product_id"] . "'" ?>>
                                <button class="btn btn-danger"> <i class="fas fa-times"></i> Delete </button> </a>
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