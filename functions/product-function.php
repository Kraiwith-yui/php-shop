<?php

include_once("db.php");

class productFunction extends connectDB
{
    public function productCreate($name, $desc, $price, $amount)
    {
        $sql = "INSERT INTO tb_product(Product_name, Product_description, Product_price, Product_amount) VALUES ('$name', '$desc', '$price', '$amount')";
        return $this->conn->query($sql);
    }

    public function productGetAll()
    {
        $sql = "SELECT * FROM tb_product ORDER BY Product_id ASC";
        return $this->conn->query($sql);
    }

    public function productGetById($id)
    {
        $sql = "SELECT * FROM tb_product WHERE Product_id='$id'";
        return $this->conn->query($sql);
    }

    public function productUpdate($id, $name, $desc, $price, $amount)
    {
        $sql = "UPDATE tb_product SET Product_name='$name',Product_description='$desc',Product_price='$price', Product_amount='$amount' WHERE Product_id='$id'";
        return $this->conn->query($sql);
    }

    public function productGetLast()
    {
        $sql = "SELECT * FROM tb_product ORDER BY Product_id DESC";
        return $this->conn->query($sql)->fetch_assoc();
    }

    public function productDelete($id)
    {
        $sql = "DELETE FROM tb_product WHERE Product_id='$id'";
        return $this->conn->query($sql);
    }
}
