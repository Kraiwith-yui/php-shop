<?php

session_start();

$member = null;
if (isset($_SESSION['Member'])) {
    $member = $_SESSION['Member'];
} else {
    header('localtion: login.php');
}

include_once('functions/product-function.php');
include_once('functions/picture-function.php');
include_once('functions/cart-function.php');
$productFn = new productFunction();
$pictureFn = new pictureFunction();
$cartFn = new cartFunction();

$carts = $cartFn->cartGetByMemberId($member['Member_id']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namploy Shop</title>
    <link rel="icon" href="assets/logo.ico" type="image/ico">

    <?php include_once('./assets/styles.html'); ?>
    <style>
        .img-product {
            width: 100px;
            height: 100px;
            margin: 0 5px 5px;
            padding: 5px;
            object-fit: contain;
            border: 1px solid #ccc;
        }

        .total-price {
            font-size: 45px;
            margin: 0 10px;
        }
    </style>
</head>

<body>
    <?php include_once('./components/navbar.php'); ?>

    <div class="container py-5">
        <h3> รายการสินค้าในรถเข็น <?php echo $carts->num_rows; ?> รายการ </h3>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th style="width: 250px"> รูป </th>
                    <th> ชื่อ </th>
                    <th> รายละเอียด </th>
                    <th style="width: 120px"> ราคา </th>
                    <th style="width: 180px"> จำนวน </th>
                    <th style="width: 120px"> รวม </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPrice = 0;
                while ($cart = $carts->fetch_assoc()) {
                    $product = $productFn->productGetById($cart["Product_id"])->fetch_assoc();
                    $pictures = $pictureFn->pictureGetByProductId($cart["Product_id"]);

                    $totalPrice = $totalPrice + ($cart['Cart_amount'] * $product['Product_price']);
                ?>
                    <tr>
                        <td>
                            <?php while ($picture = $pictures->fetch_assoc()) { ?>
                                <img class="img-product" <?php echo "src='uploads/" . $picture['Picture_name'] . "'"; ?> alt="">
                            <?php } ?>
                        </td>
                        <td> <?php echo $product['Product_name']; ?> </td>
                        <td> <?php echo $product['Product_description']; ?> </td>
                        <td class="text-right price"> ฿<span class="product-price"><?php echo number_format($product['Product_price']); ?></span> </td>
                        <td>
                            <div class="input-group">
                                <input type="number" class="form-control text-right cart-amount" min="0" cartId="<?php echo $cart['Cart_id']; ?>" max="<?php echo $product['Product_amount']; ?>" value="<?php echo $cart['Cart_amount']; ?>" onblur="checkProductAmount(this)">
                                <div class="input-group-append">
                                    <span class="input-group-text">ชิ้น</span>
                                </div>
                            </div>
                            <span>สินค้าที่มีอยู่ : <span id="product-<?php echo $count; ?>">
                                    <?php echo number_format($product['Product_amount']); ?></span> ชิ้น </span>
                            <div class="">
                                <a href="cart-delete.php?cartId=<?php echo $cart['Cart_id'] ?>" class="text-secondary" title="ลบจากรถเข็น" data-toggle="tooltip" data-placement="bottom">
                                    <i class="fas fa-trash-alt"></i> </a>
                            </div>
                        </td>
                        <td class="text-right"> ฿<span class="cart-total"> <?php echo number_format($product['Product_price'] * $cart['Cart_amount']); ?></span> </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <div class="form-inline mb-3">
            <a href="./">
                <button type="button" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i> เลือกสินค้าเพิ่ม </button> </a>
            <div class="form-inline align-items-center ml-auto"> รวมทั้งสิ้น : <span class="total-price price">฿<span id="total-price"><?php echo number_format($totalPrice); ?></span></span> </div>

            <?php if ($carts->num_rows > 0) { ?>
                <a href="./order-create.php">
                    <button type="button" class="btn btn-warning ml-3"> สั่งซื้อสินค้า </button> </a>
            <?php } else { ?>
                <button type="button" class="btn btn-warning ml-3" disabled> สั่งซื้อสินค้า </button>
            <?php } ?>


        </div>
    </div>

    <?php include_once('./assets/scripts.html'); ?>
    <script>
        function calculateTotalPrice() {
            const prices = document.getElementsByClassName('product-price');

            let totalPrice = 0;
            for (let i = 0; i < prices.length; i++) {
                const priceElement = prices[i];
                const price = +priceElement.innerHTML.replace(',', '');

                const amounts = document.getElementsByClassName('cart-amount');
                const amountElement = amounts[i];
                const amount = +amountElement.value;

                const totals = document.getElementsByClassName('cart-total');
                const totalElement = totals[i];
                const cartTotal = price * amount;
                totalElement.innerHTML = numberWithCommas(cartTotal);

                totalPrice += cartTotal;
            }

            const totalPriceElement = document.getElementById('total-price');
            totalPriceElement.innerHTML = numberWithCommas(totalPrice);
        }

        function checkProductAmount(input) {
            const amount = +input.value;
            if (amount > +input.max) {
                alert('สินค้าในคลังไม่เพียงพอ');
                input.value = input.max;
            } else if (amount <= 0) {
                input.value = 1;
            }
            const cartId = input.getAttribute('cartid');
            $.ajax({
                method: 'post',
                url: 'functions/cart-update-amount.php',
                data: 'cartId=' + cartId + "&amount=" + input.value,
                success: function(data) {
                    calculateTotalPrice();
                }
            });
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
</body>

</html>