<?php
include("../TONGQUAN/config.php");
session_start();
if(isset($_GET["mshh"])&&isset($_GET["sl"])){
    $mshh = $_GET["mshh"];
    $sl = $_GET["sl"];
    if(!isset($_SESSION["MSKH"])){
        $_SESSION["err"] = "Bạn hãy đăng nhập để mua hàng";
        $_SESSION["dieuhuong"] = "chitiet.php?mshh=".$_GET["mshh"];
        header("location:dangnhap.php");
    }else{
        $sql = "select SoLuongHang from hanghoa where MSHH='$mshh'";
        $data = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
        if(count($data)>0){
            if($sl<=$data[0]["SoLuongHang"]){
                header("location:xacnhandathang.php?mshh=$mshh&sl=$sl");
            }else{
                $_SESSION["err_sl"] = "Chỉ còn ".$data[0]["SoLuongHang"]." quyển";
                header("location:chitiet.php?mshh=".$mshh);
            }
        }
    }
}
?>