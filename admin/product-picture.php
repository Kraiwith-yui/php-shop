<?php
include_once('../functions/picture-function.php');

$pictureFn = new pictureFunction();

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($actual_link);
parse_str($parts['query'], $query);
$pId = $query['pId'];

$Pictures = $pictureFn->pictureGetByProductId($pId);
$AllPicture = array();

$fields = array();
$count = 1;
while ($picture = $Pictures->fetch_assoc()) {
    array_push($fields, array('file' . $count => $picture['Picture_name']));
    $count += 1;
    echo json_encode($picture) . "<br>";
    $AllPicture[] = $picture;
}

while (count($fields) < 4) {
    array_push($fields, array('file' . (count($fields) + 1) => ""));
}

if (isset($_POST["submit"])) {


    foreach ($AllPicture as $picture) {
        echo "<br> " . json_encode($picture);
    }
    foreach ($fields as $key => $value) {
        if ($_FILES[$key]['name']) {
            echo "<br>" . $_FILES[$key]['name'];
            //         $file = $_FILES[$key];
            //         $fileName = $file['name'];
            //         $tmpName = $file['tmp_name'];

            //         $fileExt = explode('.', $fileName);
            //         $fileActualExt = strtolower(end($fileExt));
            //         $fileNewName = uniqid('', true) . "." . $fileActualExt;
            //         $fileDestination = "../uploads/" . $fileNewName;
            //         move_uploaded_file($tmpName, $fileDestination);

            //         $picResult = $pictureFn->pictureCreate($fileNewName, $newProduct['Product_id']);
            //         if ($picResult) {
            //         }
        }
    }
    // header("location: ./");
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
    <div class="container mt-3">
        <div class="form-inline">
            <h5> <i class="fas fa-images"></i> แก้ไขรูปสินค้า</h5>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">รูปสินค้า</label>
                <div class="row">
                    <?php
                    $c = 1;
                    foreach ($fields as $field => $value) {
                    ?>
                        <div class="col-6 mb-3">
                            <div class="custom-file mb-2">
                                <input type="file" <?php echo "name='$field' id='$field'"; ?> class="custom-file-input" accept=".jpg, .png" onchange="readURL(this)">
                                <label class="custom-file-label" <?php echo "for='$field' id='label-$field'"; ?>> Choose File </label>
                            </div>
                            <div class="text-center" <?php echo "id='show-$field'"; ?>>
                                <?php if ($value['file' . $c]) { ?>
                                    <img class="show-image" <?php echo "src='../uploads/" . $value['file' . $c] . "'"; ?> alt="">
                                <?php  } ?>
                            </div>
                        </div>
                    <?php
                        $c += 1;
                    }
                    ?>
                    <div class="col-12 mb-3">
                        <div id="image-error"> </div>
                    </div>
                </div>
            </div>
            <div class="form-group form-inline">
                <a href="./">
                    <button type="button" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i> ยกเลิก </button> </a>
                <button type="submit" name="submit" class="btn btn-warning ml-auto"> <i class="fas fa-images"></i> แก้ไข </button>
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