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
        header("location: ./");
    } else {
        echo "<script>window.alert('Update Data Failed!!!. Try again later.');</script>";
        echo "<script>window.location.href='./';</script>";
    }
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
    <div class="container mt-3">
        <div class="form-inline">
            <h5> <i class="fas fa-edit"></i> แก้ไขข้อมูลสินค้า</h5>
        </div>
        <form method="POST">
            <div class="form-group sr-only" hidden>
                <label for="">รหัสสินค้า</label>
                <input type="text" name="id" class="form-control" placeholder="" required <?php echo "value='" . $product["Product_id"] . "'"; ?>>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">ชื่อสินค้า</label>
                        <input type="text" name="name" class="form-control" placeholder="" required <?php echo "value='" . $product["Product_name"] . "'"; ?>>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">ราคาสินค้า</label>
                        <div class="input-group">
                            <input type="number" name="price" class="form-control" placeholder="0" min="0" max="9999999" required <?php echo "value='" . $product["Product_price"] . "'"; ?>>
                            <div class="input-group-append">
                                <div class="input-group-text">บาท</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">รายละเอียดสินค้า</label>
                <textarea name="desc" id="" rows="3" class="form-control"><?php echo $product["Product_description"]; ?></textarea>
            </div>
            <div class="form-group form-inline">
                <a href="./" class="mr-auto">
                    <button type="button" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i> ย้อนกลับ </button> </a>

                <button type="submit" name="submit" class="btn btn-warning"> <i class="fas fa-save"></i> แก้ไข </button>
            </div>
        </form>
    </div>

    <?php include_once('../assets/scripts.html'); ?>
</body>

</html>