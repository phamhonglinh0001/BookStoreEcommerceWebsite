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
    }else if($_GET["cn"]=="xacnhan"){
        $id = $_GET["id"];
        $msnv = $_SESSION["MSNV"];
        if(isset($_POST["giamgia"])){
            $sql = "select GiaDatHang from chitietdathang where SoDonDH='$id'";
            $giadathang = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC)[0]["GiaDatHang"];
            $giamgia = $_POST["giamgia"];
            $sql = "update chitietdathang set GiamGia='$giamgia' where SoDonDH='$id'";
            mysqli_query($conn, $sql);
            $giadathang = $giadathang-$giamgia;
            $sql = "update chitietdathang set GiaDatHang='$giadathang' where SoDonDH='$id'";
            mysqli_query($conn, $sql);
        }else{
            
            $sql = "update chitietdathang set GiamGia=0 where SoDonDH='$id'";
            mysqli_query($conn, $sql);
        }  
        $sql = "update dathang set TrangThaiDH='Đang đóng gói' where SoDonDH='$id'";
        mysqli_query($conn, $sql);

        $sql = "update dathang set MSNV='$msnv' where SoDonDH='$id'";
        mysqli_query($conn, $sql);
        header("location:donhang.php");
    }else if($_GET["cn"]=="danggiaohang"){
        $id=$_GET["id"];
        $sql = "update dathang set TrangThaiDH='Đang giao hàng' where SoDonDH='$id'";
        mysqli_query($conn, $sql);
        header("location:donhang.php");
    }else if($_GET["cn"]=="dagiaohang"){
        $id=$_GET["id"];
        $sql = "update dathang set TrangThaiDH='Đã giao hàng', NgayGH=NOW() where SoDonDH='$id'";
        mysqli_query($conn, $sql);
        header("location:donhang.php");
    }
    
?>