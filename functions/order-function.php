<?php

include_once("db.php");

class orderFunction extends connectDB
{
    function create($addr, $phone, $price, $amount,  $memId, $prodId)
    {
        $sql = "INSERT INTO tb_order(Order_address, Order_phone, Order_price, Order_amount, Order_status, Member_id, Product_id) 
            VALUES ('$addr', '$phone', '$price', '$amount', 'waiting', '$memId', '$prodId')";
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

    function orderStatusSuccess($oId)
    {
        $sql = "UPDATE tb_order SET Order_status='success' WHERE Order_id='$oId'";
        return $this->conn->query($sql);
    }
}
