<?php

include_once("db.php");

class productFunction extends connectDB
{
    public function productCreate($name, $desc, $price)
    {
        $sql = "INSERT INTO tb_product(Product_name, Product_description, Product_price) VALUES ('$name', '$desc', '$price')";
        return $this->conn->query($sql);
    }

    public function productGetAll()
    {
        $sql = "SELECT * FROM tb_product ORDER BY Product_id ASC";
        return $this->conn->query($sql);
    }

    public function productGetById($id)
    {
        $sql = "SELECT * FROM tb_product WHERE Product_id = '$id'";
        return $this->conn->query($sql);
    }

    public function productUpdate($id, $name, $desc, $price)
    {
        $sql = "UPDATE tb_product SET Product_name='$name',Product_description='$desc',Product_price='$price' WHERE Product_id='$id'";
        return $this->conn->query($sql);
    }

    public function productGetLast()
    {
        $sql = "SELECT * FROM tb_product ORDER BY Product_id DESC";
        return $this->conn->query($sql)->fetch_assoc();
    }
}
