<?php
include_once("../functions/product-function.php");

$productFn = new productFunction();

$products = $productFn->productGetAll();
print_r($products);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namploy Shop</title>

    <?php include_once('../assets/styles.html'); ?>
</head>

<body>
    <div class="container mt-3">
        <h5>รายการสินค้า</h5>

        <div class="form-inline mb-3">
            <a href="./product-create.php" class="ml-auto">
                <button type="button" class="btn btn-primary"> <i class="fas fa-plus"></i> CREATE </button> </a>
        </div>

        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>desc</th>
                    <th>price</th>
                    <th width="200px"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($product = $products->fetch_assoc()) {
                ?>
                    <tr>
                        <td> <?php echo $product["Product_id"]; ?> </td>
                        <td> <?php echo $product["Product_name"]; ?> </td>
                        <td> <?php echo $product["Product_description"]; ?> </td>
                        <td> <?php echo $product["Product_price"]; ?> </td>
                        <td class="text-center">
                            <a class="text-warning mx-2" <?php echo "href='./product-update.php?pId=" . $product["Product_id"] . "'" ?>>
                                <i class="fas fa-edit"></i> Update </a>
                            <a class="text-danger mx-2" href="#">
                                <i class="fas fa-times"></i> Delete </a>
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