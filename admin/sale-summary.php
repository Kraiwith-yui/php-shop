<?php

include_once('../functions/order-function.php');
$orderFn = new orderFunction();

if (isset($_GET['search'])) {
    $startDate = $_GET['start'];
    $endDate = $_GET['end'];
} else {
    // last day of month
    $startDate = date("Y-m-01");
    $endDate = date("Y-m-t");
}
$orders = $orderFn->getOrderDateFrom($startDate, $endDate);

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
    <div class="container py-5">
        <div class="form-inline mb-3">
            <a href="./" class="btn btn-outline-secondary mr-3"> <i class="fas fa-arrow-left"></i> Back </a>
            <h2 class="m-0">สรุปการขาย</h2>
        </div>

        <form method="GET">
            <div class="form-inline mb-3 justify-content-end">
                <input type="date" name="start" class="form-control ml-3" value="<?php echo $startDate ?>">
                <input type="date" name="end" class="form-control ml-3" value="<?php echo $endDate ?>">
                <button type="submit" name="search" class="btn btn-success ml-3"> ค้นหา </button>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th> วันที่ </th>
                        <th> รหัสใบสั่งซื้อ </th>
                        <th> จำนวน </th>
                        <th> ยอด </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalPrice = 0;
                    $totalAmount = 0;
                    while ($order = $orders->fetch_assoc()) {
                        $totalPrice += $order['Order_price'];

                        $carts = json_decode($order['Order_products']);
                        $amount = 0;
                        foreach ($carts as $cart) {
                            $amount += $cart->Cart_amount;
                        }
                        $totalAmount += $amount;
                    ?>
                        <tr>
                            <td class="text-center"> <?php echo date('d-m-Y H:i', strtotime($order['Order_date'])); ?> </td>
                            <td class="text-center"> <?php echo $order['Order_id']; ?> </td>
                            <td class="text-right"> <?php echo number_format($amount); ?> ชิ้น </td>
                            <td class=" text-right price"> ฿<?php echo number_format($order['Order_price']); ?> </td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan="100%" class="text-right">
                            ตั้งแต่ <?php echo date('d-m-Y', strtotime($startDate)); ?> ถึง <?php echo date('d-m-Y', strtotime($endDate)); ?>
                            <span style="font-size: 24px;">
                                จำนวนรวม <?php echo number_format($totalAmount); ?> ชิ้น,
                                ยอดรวม <span class="price"> ฿<?php echo number_format($totalPrice); ?> </span>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>


    </div>

    <?php include_once('../assets/scripts.html'); ?>
</body>

</html>