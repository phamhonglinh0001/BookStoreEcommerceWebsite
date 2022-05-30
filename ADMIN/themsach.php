<?php
include("../TONGQUAN/config.php");
session_start();
if(isset($_SESSION["MSNV"])){
    $msnv = $_SESSION["MSNV"];
}else{
    $_SESSION["err"] = "Bạn hãy đăng nhập vào hệ thống";
    $_SESSION["dieuhuong"] = "them_sach.php";
    header("location:index.php");
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $ten = $_POST["ten"];
    $mota = $_POST["mota"];
    $gia = $_POST["gia"];
    $soluong = $_POST["soluong"];
    
    if (isset($_FILES["anh"])&&$_FILES["anh"]["error"]!=4) {
        $tenfile = $_FILES["anh"]["name"];
        $arr = explode(".", $tenfile);
        $temp = end($arr);
        if ($temp != "jpg" && $temp != "png" && $temp != "jpeg" && $temp != "gif") {
            $_SESSION["err_themsach"] = "Chỉ chấp nhận tệp jpg/png/jpeg/gif";
        } else {
            $sql = "insert into hanghoa(TenHH, MoTaHH, Gia, SoLuongHang) values ('$ten','$mota','$gia','$soluong')";
            mysqli_query($conn, $sql);

            $sql = "select max(MSHH) from hanghoa";
            $maxid = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC)[0]["max(MSHH)"];

            $dir = "../TONGQUAN/anh-sach/" . $maxid . "." . $temp;
            $tenhinh = $maxid . "." . $temp;
            if(file_exists($dir)) unlink($dir);
            move_uploaded_file($_FILES["anh"]["tmp_name"], $dir);

            $sql = "insert into hinhhh(TenHinh, MSHH) values ('$tenhinh','$maxid')";
            mysqli_query($conn, $sql);

            $_SESSION["err_themsach"] = "Thêm thành công";
            
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhà sách HL</title>
    <link rel="stylesheet" href="../TONGQUAN/bootstrap/css/bootstrap.min.css">
    <script src="../TONGQUAN/bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="../TONGQUAN/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <div class="root">
        <div class="container-fluid tophead text-white" style="background-color: black;">
            <p class="float-end">
                <i class="fa-solid fa-phone"></i>
                &nbsp;
                (+84)986611387
            </p>
            <p>
                <i class="fa-solid fa-envelope"></i>
                &nbsp;
                linhb1805885@student.ctu.edu.vn
            </p>

        </div>
        <nav class="navbar navbar-expand-sm navbar-dark bg-danger">
            <div class="container-fluid">
                <a class="navbar-brand" href=""><i class="fas fa-book-reader"></i>&nbsp;&nbsp;Nhà sách HL</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="quanlysach.php">
                                Sách</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="donhang.php">
                                Đơn hàng</a>
                        </li>
                        <?php
                            if(isset($_SESSION["MSNV"])){
                                echo
                                '
                                <li class="nav-item">
                                <a class="nav-link" href="taikhoan_nv.php">Tài khoản</a>
                                </li>
                                ';
                                echo
                                '
                                <li class="nav-item">
                                <a class="nav-link" href="dangxuat_nv.php">Đăng xuất</a>
                                </li>
                                ';
                            }else{
                                echo
                                '
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">
                                    Đăng nhập</a>
                                </li>
                                ';
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="mx-auto" style="min-height: 80vh; width: 80%; padding:50px;">
            <h5 class="text-center mx-auto bg-primary text-white" style="width:70%; padding:10px;">
                Thêm sách mới
            </h5>
            <br>
            <div class="text-center">
                <span class="text-danger">
                    <?php
                        if(isset($_SESSION["err_themsach"])){
                            echo $_SESSION["err_themsach"];
                            unset($_SESSION["err_themsach"]);
                        }
                    ?>
                </span>
            </div>
            <br>
            <div class="table-responsive mx-auto" style="width:70%;">
                <form action="" method="post" enctype="multipart/form-data">
                <table class="table table-bordered text-center">
                    <tr>
                        <th>
                            Chọn ảnh
                        </th>
                        <td>
                            <input required type="file" class="form-control" name="anh">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Tên sách
                        </th>
                        <td>
                            <input required placeholder="Nhập tên sách" type="text" class="form-control" name="ten">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Mô tả
                        </th>
                        <td>
                            <textarea class="form-control" placeholder="Nhập mô tả" required name="mota" cols="50" rows="10"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Giá
                        </th>
                        <td>
                            <input required placeholder="Nhập giá" type="number" class="form-control" name="gia">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Số lượng
                        </th>
                        <td>
                            <input required placeholder="Nhập số lượng" type="number" class="form-control" name="soluong">
                        </td>
                    </tr>
                </table>
                <div class="text-center">
                    <a href="quanlysach.php" class="btn btn-danger">Trở về</a>
                    <button type="submit" class="btn btn-danger">Thêm</button>
                </div>
                </form>
            </div>
        </div>

        <div class="container-fluid footer bg-dark text-white m-0">
            <div class="row p-3">
                <div class="d-flex p-3 justify-content-around">
                    <div class="">

                        <i class="fas fa-map-marker-alt"></i>
                        3/2 Ninh Kiều Cần Thơ

                    </div>
                    <div class="">

                        <i class="fas fa-fax"></i>
                        (+84)986611387

                    </div>
                    <div class="">

                        <i class="fas fa-envelope"></i>
                        linhb1805885@student.ctu.edu.vn

                    </div>
                </div>
            </div>
            <hr>
            <div class="row text-center">
                <div class="py-2">
                    <i class="fas fa-copyright"></i>
                    copyright by <span class="badges bg-primary rounded p-1">Linh</span>
                </div>

            </div>
        </div>
    </div>
</body>

</html>