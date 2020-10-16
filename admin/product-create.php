<?php
include_once('../functions/product-function.php');

$productFn = new productFunction();

$fields = array(
    "file1" => "File 1:",
    "file2" => "File 2:",
    "file3" => "File 3:",
    "file4" => "File 4:"
);

if (isset($_POST['submit'])) {
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
        }
    }

    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    print_r($_POST);

    // $result = $productFn->productCreate($name, $desc, $price);
    // if ($result) {
    //     header("location: ../admin/");
    // } else {
    //     echo "<script>window.alert('Create Data Failed!!!. Try again later.');</script>";
    //     echo "<script>window.location.href='../admin/';</script>";
    // }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namploy Shop | Create Product</title>

    <?php include_once('../assets/styles.html'); ?>
    <style>
        img.show-image {
            width: 250px;
            height: 250px;
            object-fit: contain;
            padding: 10px;
            border: 1px solid #cccccc;
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
                <label for="">Product Picture</label>
                <div class="row">
                    <?php
                    foreach ($fields as $field => $value) {
                    ?>
                        <div class="col-6 mb-3">
                            <div class="custom-file mb-2">
                                <input type="file" <?php echo "name='$field' id='$value'"; ?> class="custom-file-input" accept=".jpg, .png" onchange="readURL(this)">
                                <label class="custom-file-label" <?php echo "for='$value' id='label-$value'"; ?>> Choose File </label>
                            </div>
                            <div class="text-center" <?php echo "id='show-$value'"; ?>></div>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="col-12 mb-3">
                        <div id="image-error"> </div>
                    </div>
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

                <button type="submit" name="submit" id="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Create </button>
            </div>
        </form>
    </div>

    <?php include_once('../assets/scripts.html'); ?>
    <script>
        function readURL(input) {
            const imgErrEl = document.getElementById('image-error');
            imgErrEl.innerHTML = '';

            const Element = document.getElementById('show-' + input.id);
            const lebelEl = document.getElementById('label-' + input.id);
            Element.innerHTML = '';
            lebelEl.innerHTML = 'Choose file';

            if (input.files && input.files[0]) {
                const allowType = ['jpg', 'jpeg', 'png'];

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
                    errorEl.className = 'alert-danger p-2';
                    errorEl.innerHTML = 'file type is not correct.';
                    imgErrEl.appendChild(errorEl);
                }
            }
        }
    </script>
</body>

</html>