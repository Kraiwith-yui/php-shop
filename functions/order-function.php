<?php

include_once("db.php");

class orderFunction extends connectDB
{
    function create($addr, $phone, $price, $memId, $products)
    {
        $sql = "INSERT INTO tb_order(Order_address, Order_phone, Order_price, Order_status, Member_id, Order_products) 
            VALUES ('$addr', '$phone', '$price', 'waiting', '$memId', '$products')";
        return $this->conn->query($sql);
    }

    function getOrderByMemberId($memId)
    {
        $sql = "SELECT * FROM tb_order WHERE Member_id='$memId'";
        return $this->conn->query($sql);
    }

    function getOrderAll()
    {
        $sql = "SELECT * FROM tb_order";
        return $this->conn->query($sql);
    }

    function orderStatusSuccess($orderId)
    {
        $sql = "UPDATE tb_order SET Order_status='success' WHERE Order_id='$orderId'";
        return $this->conn->query($sql);
    }
}
