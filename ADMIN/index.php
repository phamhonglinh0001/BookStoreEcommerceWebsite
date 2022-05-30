<?php
include("../TONGQUAN/config.php");
session_start();
if(isset($_POST["sdt"])&&isset($_POST["mk"])){
    $sdt = $_POST["sdt"];
    $mk = md5($_POST["mk"]);
    $sql = "select MSNV, ChucVu from nhanvien where SoDienThoai='$sdt' and Password='$mk'";
    $data = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
    if(
        count($data) == 0
    ) $_SESSION["err"] = "Tên tài khoản hoặc mật khẩu sai";
    else{
        if($data[0]["ChucVu"]=="AD"){
            $_SESSION["MSAD"] = $data[0]["MSNV"];
            if(isset($_SESSION["dieuhuong"])){
                $dh = $_SESSION["dieuhuong"];
                unset($_SESSION["dieuhuong"]);
                header("location:".$dh);
            }else{
                header("location:trangchu_ad.php");
            }
        }else{
            $_SESSION["MSNV"] = $data[0]["MSNV"];
            if(isset($_SESSION["dieuhuong"])){
                $dh = $_SESSION["dieuhuong"];
                unset($_SESSION["dieuhuong"]);
                header("location:".$dh);
            }else{
                header("location:quanlysach.php");
            }
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
            </div>
        </nav>

        <div class="mx-auto" style="min-height: 80vh; width: 80%; padding:50px;">
        <div class="mx-auto" style="width: 500px; border-radius: 5px; background-color: white; padding: 20px 40px;">
                        <form action="" method="post">
                            <div style="height: 100px; text-align: center;">
                                <h3 style="line-height: 150px;">
                                    <b class="text-danger" style="font-size: 30px;">
                                        QUẢN TRỊ
                                    </b>
                                </h3>
                            </div>
                            <span class="text-danger">
                                <?php if(isset($_SESSION["err"])) {echo $_SESSION["err"]; unset($_SESSION["err"]);} ?> 
                            </span>
                            <br><br>
                            <input required name="sdt" type="text" class="form-control" placeholder="Số điện thoại">
                            <br>
                            <input required name="mk" type="password" class="form-control" placeholder="Mật khẩu">
                            <br>
                            <input class="bg-danger" type="submit" value="Đăng nhập" style="border: none; width: 100%;color: white; padding: 7px;">
                        </form>
                        <br>
                        <div class="text-end">
                            <a href="../KHACHHANG/dangnhap.php">Đến trang khách hàng</a>
                        </div>
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