<?php

include_once("db.php");

class orderFunction extends connectDB
{
    function create($addr, $phone, $price, $amount,  $memId, $prodId)
    {
        $sql = "INSERT INTO tb_order(Order_address, Order_phone, Order_price, Order_amount, Member_id, Product_id) 
            VALUES ('$addr', '$phone', '$price', '$amount', '$memId', '$prodId')";
        return $this->conn->query($sql);
    }

    function getByMemberId($memId)
    {
        $sql = "SELECT * FROM tb_order WHERE Member_id='$memId'";
        return $this->conn->query($sql);
    }
}
