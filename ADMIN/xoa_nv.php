<?php
    include("../TONGQUAN/config.php");
    session_start();

    if(isset($_GET["msnv"])){
        $msnv = $_GET["msnv"];
        $sql = "delete from nhanvien where MSNV='$msnv'";
        mysqli_query($conn, $sql);
        header("location:ql_nhanvien.php");
    }
?>