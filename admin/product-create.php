<?php
include_once('../functions/product-function.php');

$productFn = new productFunction();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];

    $result = $productFn->productCreate($name, $desc, $price);
    if ($result) {
        header("location: ../admin/");
    } else {
        echo "<script>window.alert('Create Data Failed!!!. Try again later.');</script>";
        echo "<script>window.location.href='../admin/';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namploy Shop | Create Product</title>

    <?php include_once('../assets/styles.html'); ?>
</head>

<body>
    <div class="container mt-3">
        <div class="form-inline">
            <h5> <i class="fas fa-plus"></i> เพิ่มรายการสินค้า</h5>

        </div>
        <form method="POST">
            <div class="form-group">
                <label for="">Product Picture</label>
                <div class="custom-file">
                    <input type="file" name="files" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>

            <div class="form-group">
                <label for="">Product Name</label>
                <input type="text" name="name" class="form-control" placeholder="" require>
            </div>
            <div class="form-group">
                <label for="">Product Description</label>
                <textarea name="desc" id="" rows="3" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="">Product Price</label>
                <input type="number" name="price" class="form-control" placeholder="0" require>
            </div>
            <div class="form-group form-inline">
                <a href="../admin/" class="mr-auto">
                    <button type="button" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i> ย้อนกลับ </button> </a>

                <button type="submit" name="submit" class="btn btn-primary"> <i class="fas fa-save"></i> CREATE </button>
            </div>
        </form>
    </div>

    <?php include_once('../assets/scripts.html'); ?>
</body>

</html>