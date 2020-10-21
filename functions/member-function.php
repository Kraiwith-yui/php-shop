<?php

include_once('db.php');

class memberFunction extends connectDB
{
    public function memberLogin($uName, $pass)
    {
        $sql = "SELECT * FROM tb_member WHERE Member_username = '$uName' AND Member_password = '$pass'";
        return $this->conn->query($sql);
    }

    public function memberRegister($uName, $pass, $fullname, $email)
    {
        $sql = "INSERT INTO tb_member(Member_username, Member_password, Member_fullname, Member_email) 
            VALUES ('$uName', '$pass', '$fullname', '$email');";
        return $this->conn->query($sql);
    }

    public function memberExists($uName)
    {
        $sql = "SELECT * FROM tb_member WHERE Member_username='$uName'";
        return $this->conn->query($sql);
    }
}
