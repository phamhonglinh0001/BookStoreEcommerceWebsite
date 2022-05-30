<?php
include("../TONGQUAN/config.php");
session_start();

if(isset($_SESSION["MSAD"])){
    $msad = $_SESSION["MSAD"];
}else{
    $_SESSION["err"] = "Bạn hãy đăng nhập để vào quản lý nhân viên";
    $_SESSION["dieuhuong"] = "ql_nhanvien.php";
    header("location:index.php");
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
                <a class="navbar-brand" href="trangchu_ad.php"><i class="fas fa-book-reader"></i>&nbsp;&nbsp;Nhà sách HL</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="navbar-nav me-auto">
                                                <li class="nav-item">
                            <a class="nav-link" href="ql_nhanvien.php">
                                Nhân viên</a>
                        </li>
                        <?php
                        if (isset($_SESSION["MSAD"])) {
                            echo
                            '
                                <li class="nav-item">
                                <a class="nav-link" href="taikhoan_ad.php">Tài khoản</a>
                                </li>
                                ';
                            echo
                            '
                                <li class="nav-item">
                                <a class="nav-link" href="dangxuat_ad.php">Đăng xuất</a>
                                </li>
                                ';
                        } else {
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

        <div class="mx-auto" style="min-height: 80vh; width: 70%; padding:50px;">
            <h5 class="text-center mx-auto bg-danger text-white" style="padding:10px;">
                Quản lý nhân viên
            </h5>
            <br>
            <div class="text-center">
                <a href="them_nv.php" class="btn btn-success">
                    Thêm nhân viên
                </a>
            </div>
            <br>
            <div class="table-responsive mx-auto">
                <table class="table table-bordered text-center">
                    <tr class="text-center">
                        <th style="width:10%;">
                            Mã số
                        </th>
                        <th style="width:20%;">
                            Họ tên
                        </th>
                        <th style="width:10%;">
                            Chức vụ
                        </th>
                        <th style="width:30%;">
                            Địa chỉ
                        </th>
                        <th style="width:15%;">
                            Số điện thoại
                        </th>
                        <th style="width:15%;">
                            Thao tác
                        </th>
                    </tr>
                    <?php
                        $sql = "select * from nhanvien where not(MSNV='$msad')";
                        $data = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
                        if(count($data)>0){
                            foreach($data as $x){
                                echo
                                '
                                <tr>
                                    <td>'.$x["MSNV"].'</td>
                                    <td>'.$x["HoTenNV"].'</td>
                                    <td>'.$x["ChucVu"].'</td>
                                    <td>'.$x["DiaChi"].'</td>
                                    <td>'.$x["SoDienThoai"].'</td>
                                    <td>
                                        <a href="sua_nv.php?msnv='.$x["MSNV"].'" class="btn btn-primary">Sửa</a>
                                        <a href="xoa_nv.php?msnv='.$x["MSNV"].'" class="btn btn-danger">Xóa</a>
                                    </td>
                                </tr>
                                ';
                            }
                        }
                    ?>
                </table>
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