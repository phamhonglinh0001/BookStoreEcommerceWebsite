<?php
    include("../TONGQUAN/config.php");
    session_start();
    if($_GET["cn"]=="huy"){
        $id = $_GET["id"];
        $sql = "update dathang set TrangThaiDH='Đã hủy' where SoDonDH='$id'";
        mysqli_query($conn, $sql);
        $sql = "delete from chitietdathang where SoDonDH='$id'";
        mysqli_query($conn, $sql);
        header("location:donhang.php");
    }
?>