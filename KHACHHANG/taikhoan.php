<?php
include("../TONGQUAN/config.php");
session_start();
if(isset($_SESSION["MSKH"])){
    $mskh = $_SESSION["MSKH"];
    if(isset($_POST["hoten"])&&isset($_POST["diachi"])&&isset($_POST["sdt"])){
        $hoten = $_POST["hoten"];
        $diachi = $_POST["diachi"];
        $sdt = $_POST["sdt"];
        $sql = "update khachhang set HoTenKH='$hoten', DiaChi='$diachi', SoDienThoai='$sdt' where MSKH='$mskh'";
        mysqli_query($conn, $sql);
        $_SESSION["err_tk"] = "Cập nhật thành công";
    }
    $sql = "select * from khachhang where MSKH='$mskh'";
    $data = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
}else{
    $_SESSION["err"] = "Đăng nhập để vào Tài Khoản";
    $_SESSION["dieuhuong"] = "taikhoan.php";
    header("location:dangnhap.php");
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
                <a class="navbar-brand" href="index.php"><i class="fas fa-book-reader"></i>&nbsp;&nbsp;Nhà sách HL</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="timkiem.php">
                                Tìm kiếm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="donhang.php">
                                Đơn hàng</a>
                        </li>
                        <?php
                            if(isset($_SESSION["MSKH"])){
                                echo
                                '
                                <li class="nav-item">
                                <a class="nav-link" href="taikhoan.php">Tài khoản</a>
                                </li>
                                ';
                                echo
                                '
                                <li class="nav-item">
                                <a class="nav-link" href="dangxuat.php">Đăng xuất</a>
                                </li>
                                ';
                            }else{
                                echo
                                '
                                <li class="nav-item">
                                    <a class="nav-link" href="dangnhap.php">
                                    Đăng nhập</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="dangky.php">
                                    Đăng ký</a>
                                </li>
                                ';
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="mx-auto" style="min-height: 80vh; width: 80%; padding:50px;">
            <h4 class="text-center">
                Thông tin tài khoản
            </h4>
            <br>
            <form method="post" action="../TONGQUAN/doi_mk.php" class="text-end">
                    <button name="submit" type="submit" value="KH-<?php echo $mskh;?>" class="btn text-primary text-decoration-underline">Đổi mật khẩu</button>
            </form>
            <br>
            <div class="text-center">
            <span class="text-danger">
                <?php
                    if(isset($_SESSION["err_tk"])){
                        echo $_SESSION["err_tk"];
                        unset($_SESSION["err_tk"]);
                    }
                ?>
            </span>
            </div>
            <br>
            <div class="table-responsive mx-auto" style="width: 500px;">
            <form action="" method="post">
                <table class="table">
                    <tr>
                        <th>
                            Họ tên Khách hàng
                        </th>
                        <td>
                            <input name="hoten" type="text" class="form-control" value="<?php echo (count($data)>0) ? $data[0]["HoTenKH"] : ""; ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Địa chỉ
                        </th>
                        <td>
                            <textarea required class="form-control" name="diachi" id="" cols="30" rows="5"><?php echo (count($data)>0) ? $data[0]["DiaChi"] : ""; ?></textarea>
                            
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Số điện thoại
                        </th>
                        <td>
                            <input name="sdt" type="text" class="form-control" value="<?php echo (count($data)>0) ? $data[0]["SoDienThoai"] : ""; ?>">
                        </td>
                    </tr>
                </table>
                <div class="text-center">
                    <button class="btn btn-danger">
                        Lưu
                    </button>
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