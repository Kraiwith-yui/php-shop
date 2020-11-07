<?php
include_once('../functions/product-function.php');
include_once('../functions/picture-function.php');

$productFn = new productFunction();
$pictureFn = new pictureFunction();

$fields = array(
    "file1" => "File 1:",
    "file2" => "File 2:",
    "file3" => "File 3:",
    "file4" => "File 4:"
);

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $desc = trim($_POST['desc']);
    $price = $_POST['price'];
    $amount = $_POST['amount'];

    $result = $productFn->productCreate($name, $desc, $price, $amount);
    if ($result) {
        $newProduct = $productFn->productGetLast();

        foreach ($fields as $key => $value) {
            if ($_FILES[$key]['name']) {
                $file = $_FILES[$key];
                $fileName = $file['name'];
                $tmpName = $file['tmp_name'];

                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));
                $fileNewName = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = "../uploads/" . $fileNewName;
                move_uploaded_file($tmpName, $fileDestination);

                $picResult = $pictureFn->pictureCreate($fileNewName, $newProduct['Product_id']);
            }
        }

        header("location: ./product.php");
    } else {
        echo "<script>window.alert('Create Product Failed!!!. Try again later.');</script>";
        echo "<script>window.location.href='./product.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namploy Shop | Create Product</title>
    <link rel="icon" href="../assets/logo.ico" type="image/ico">

    <?php include_once('../assets/styles.html'); ?>
    <style>
        .show-file {
            height: 250px;
        }
        img.show-image {
            width: 100%;
            height: 250px;
            object-fit: contain;
            padding: 10px;
            border: 1px solid #cccccc;
        }
        .custom-file-label {
            padding-right: 80px;
        }
    </style>
</head>

<body>
    <div class="container mt-3 mb-5">
        <div class="form-inline">
            <h5> <i class="fas fa-plus"></i> เพิ่มรายการสินค้า</h5>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">รูปสินค้า</label>
                <div class="row">
                    <?php
                    foreach ($fields as $field => $value) {
                    ?>
                        <div class="col-3 mb-3">
                            <div class="show-file mb-3" <?php echo "id='show-$field'"; ?>>
                                <img class="show-image" src="../assets/no-image.png" alt="">
                            </div>
                            <div class="custom-file mb-2">
                                <input type="file" <?php echo "name='$field' id='$field'"; ?> class="custom-file-input" accept=".jpg, .png" onchange="readURL(this)">
                                <label class="custom-file-label text-ellipsis" <?php echo "for='$field' id='label-$field'"; ?>> Choose file </label>
                            </div>
                            <button type="button" class="btn btn-secondary btn-block" <?php echo "id='btn-$field'"; ?> onclick="deleteImage(this)">ลบรูป</button>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="col-12">
                        <div id="image-error"> </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="">ชื่อสินค้า</label>
                        <input type="text" name="name" class="form-control" placeholder="" required>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="">ราคาสินค้า</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">฿</div>
                            </div>
                            <input type="number" name="price" class="form-control text-right" placeholder="0" min="0" max="9999999" required>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="">จำนวน</label>
                        <div class="input-group">
                            <input type="number" name="amount" class="form-control text-right" placeholder="0" min="0" max="9999" required>
                            <div class="input-group-append">
                                <div class="input-group-text">ชิ้น</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">รายละเอียดสินค้า</label>
                <textarea name="desc" id="" rows="3" class="form-control"></textarea>
            </div>
            <div class="form-group form-inline">
                <a href="./" class="mr-auto">
                    <button type="button" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i> ย้อนกลับ </button> </a>

                <button type="submit" name="submit" id="submit" class="btn btn-primary"> <i class="fas fa-save"></i> สร้าง </button>
            </div>
        </form>
    </div>

    <?php include_once('../assets/scripts.html'); ?>
    <script>
        function readURL(input) {
            const allowType = ['jpg', 'jpeg', 'png'];

            const imgErrEl = document.getElementById('image-error');
            imgErrEl.innerHTML = '';

            const Element = document.getElementById('show-' + input.id);
            const lebelEl = document.getElementById('label-' + input.id);
            Element.innerHTML = '';
            lebelEl.innerHTML = 'Choose file';

            if (input.files && input.files[0]) {

                const file = input.files[0];
                const fileType = file.type;
                if (allowType.find(type => fileType.includes(type))) {
                    lebelEl.innerHTML = file.name;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgEl = document.createElement('img');

                        imgEl.src = e.target.result;
                        imgEl.className = 'show-image';
                        Element.appendChild(imgEl);
                    }
                    reader.readAsDataURL(file);

                } else {
                    const errorEl = document.createElement('div');
                    errorEl.className = 'alert-danger p-2 mb-3';
                    errorEl.innerHTML = 'File type is not correct.';
                    imgErrEl.appendChild(errorEl);
                }
            }
        }

        function deleteImage(btn) {
            const id = btn.id.split('-')[1];

            const inputFile = document.getElementById(id);
            const labelEl = document.getElementById('label-' + id);
            const showImgEl = document.getElementById('show-' + id);
            const imgEl = document.createElement('img');

            inputFile.value = '';
            labelEl.innerHTML = 'Choose file';
            showImgEl.innerHTML = '';
            imgEl.src = "../assets/no-image.png";
            imgEl.className = 'show-image';
            showImgEl.appendChild(imgEl);
        }
    </script>
</body>

</html>