<?php
include_once('../functions/product-function.php');

$productFn = new productFunction();

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($actual_link);
parse_str($parts['query'], $query);
$pId = $query['pId'];

$product = $productFn->productGetById($pId)->fetch_assoc();

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];

    $result = $productFn->productUpdate($id, $name, $desc, $price);
    echo $result;
    if ($result) {
        header("location: ../admin/");
    } else {
        echo "<script>window.alert('Update Data Failed!!!. Try again later.');</script>";
        echo "<script>window.location.href='../admin/';</script>";
    }
}

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
        <div class="form-inline">
            <h5> <i class="fas fa-edit"></i> แก้ไขรายการสินค้า</h5>
        </div>
        <form method="POST">
            <div class="form-group sr-only" hidden>
                <label for="">Product Id</label>
                <input type="text" name="id" class="form-control" placeholder="" require <?php echo "value='" . $product["Product_id"] . "'"; ?>>
            </div>

            <div class="form-group">
                <label for="">Product Name</label>
                <input type="text" name="name" class="form-control" placeholder="" require <?php echo "value='" . $product["Product_name"] . "'"; ?>>
            </div>
            <div class="form-group">
                <label for="">Product Description</label>
                <textarea name="desc" id="" rows="3" class="form-control"> <?php echo $product["Product_desc"]; ?> </textarea>
            </div>
            <div class="form-group">
                <label for="">Product Price</label>
                <input type="number" name="price" class="form-control" placeholder="0" require <?php echo "value='" . $product["Product_price"] . "'"; ?>>
            </div>
            <div class="form-group form-inline">
                <a href="../admin/" class="mr-auto">
                    <button type="button" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i> ย้อนกลับ </button> </a>

                <button type="submit" name="submit" class="btn btn-warning"> <i class="fas fa-save"></i> UPDATE </button>
            </div>
        </form>
    </div>

    <?php include_once('../assets/scripts.html'); ?>
</body>

</html>