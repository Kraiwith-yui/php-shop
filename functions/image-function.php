<?php

include_once("db.php");

class imageFunction extends connectDB
{
    public function imageCreate($name, $product_id)
    {
        $sql = "INSERT INTO tb_image(Image_name, Product_id) VALUES ('$name', '$product_id')";
        return $this->conn->query($sql);
    }

    public function imageGetAll()
    {
        $sql = "SELECT * FROM tb_image ORDER BY Image_id ASC";
        // $result = $this->conn->query($sql);
        // $images = [];
        // while ($image = $result->fetch_assoc()) {
        //     array_push($images, $image);
        // }

        return $this->conn->query($sql);
    }

    public function imageGetByProuctId($product_id)
    {
        $sql = "SELECT * FROM tb_image WHERE Product_id = '$product_id' ORDER BY Image_id ASC";
        return $this->conn->query($sql);
    }
}
