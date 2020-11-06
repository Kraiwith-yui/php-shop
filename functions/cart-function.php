<?php

include_once("db.php");

class cartFunction extends connectDB
{
    public function cartCreate($amount, $productId, $memberId)
    {
        $sql = "INSERT INTO tb_cart(Cart_amount, Product_id, Member_id) VALUES ('$amount', '$productId', '$memberId')";
        return $this->conn->query($sql);
    }

    public function cartGetByMemberId($memberId)
    {
        $sql = "SELECT * FROM tb_cart WHERE Member_id='$memberId'";
        return $this->conn->query($sql);
    }

    public function cartUpdateAmount($cartId, $amount)
    {
        $sql = "UPDATE tb_cart SET Cart_amount='$amount' WHERE Cart_id='$cartId'";
        return $this->conn->query($sql);
    }

    public function cartDelete($cartId)
    {
        $sql = "DELETE FROM tb_cart WHERE Cart_id='$cartId'";
        return $this->conn->query($sql);
    }

    public function cartGetMy($productId, $memberId)
    {
        $sql = "SELECT * FROM tb_cart WHERE Product_id='$productId' AND Member_id='$memberId'";
        return $this->conn->query($sql);
    }

    public function cartDeleteAll()
    {
        $sql = "DELETE FROM tb_cart";
        return $this->conn->query($sql);
    }
}
