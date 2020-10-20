<?php
include_once('../functions/picture-function.php');

$pictureFn = new pictureFunction();

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($actual_link);
parse_str($parts['query'], $query);
$pId = $query['pId'];

$Pictures = $pictureFn->pictureGetByProductId($pId);

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
        <div class="form-group">
            <label for="">รูปสินค้า</label>
            <div class="row">
                <?php
                $numRows = $Pictures->num_rows;
                while ($picture = $Pictures->fetch_assoc()) {
                ?>
                    <div class="col-3 mb-3">
                        <div class="show-file mb-3">
                            <img class="show-image" <?php echo "src='../uploads/" . $picture["Picture_name"] . "'"; ?> alt="">
                        </div>
                        <a <?php echo "href='./picture-delete.php?pictureId=" . $picture["Picture_id"] . "&productId=$pId'"; ?> class="d-block">
                            <button type="submit" name="submit" class="btn btn-danger btn-block"> Delete </button> </a>
                    </div>
                <?php
                }
                if ($numRows < 4) {
                ?>
                    <div class="col-3 mb-3">
                        <form method="POST" enctype="multipart/form-data" <?php echo "action='./picture-upload.php?pId=$pId'" ?>>
                            <div class="show-file mb-3">
                                <img class="show-image" id="show-image" src="../assets/no-image.png" alt="">
                            </div>
                            <div class="custom-file mb-2">
                                <input type="file" name="file" id="file" class="custom-file-input" accept=".jpg, .png" onchange="readURL(this)">
                                <label class="custom-file-label text-ellipsis" id="label-file"> Choose file </label>
                            </div>
                            <div class="" id="image-error"></div>
                            <button type="submit" name="submit" class="btn btn-primary btn-block"> Upload </button>
                        </form>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="form-group form-inline">
            <a href="./">
                <button type="button" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i> ยกเลิก/กลับ </button> </a>
        </div>
    </div>

    <?php include_once('../assets/scripts.html'); ?>
    <script>
        function readURL(input) {
            const imgErrEl = document.getElementById('image-error');
            imgErrEl.innerHTML = '';

            const Element = document.getElementById('show-image');
            const lebelEl = document.getElementById('label-file');
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
                        // const imgEl = document.createElement('img');

                        Element.src = e.target.result;
                        // Element.className = 'show-image';
                        // Element.appendChild(imgEl);
                    }
                    reader.readAsDataURL(file);

                } else {
                    const errorEl = document.createElement('div');
                    errorEl.className = 'alert-danger p-2 mb-2';
                    errorEl.innerHTML = 'file type is not correct.';
                    imgErrEl.appendChild(errorEl);
                }
            }
        }
    </script>
</body>

</html>