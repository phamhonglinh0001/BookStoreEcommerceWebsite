<?php
include("../TONGQUAN/config.php");
session_start();
if(isset($_SESSION["MSNV"])){
    $msnv = $_SESSION["MSNV"];
}else{
    $_SESSION["err"] = "Bạn hãy đăng nhập để vào quản sách";
    $_SESSION["dieuhuong"] = "quanlysach.php";
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

        <div class="mx-auto" style="min-height: 80vh; width: 90%; padding:50px;">
            <h5 class="text-center">
                Quản lý sách
            </h5>
            <br>
            <div class="text-center">
                <a href="themsach.php" class="btn btn-danger">Thêm mới</a>
            </div>
            <br>
            <div class="table-responsive mx-auto">
                <table class="table table-bordered text-center">
                    <tr class="text-center">
                        <th style="width: 15%">Hình ảnh</th>
                        <th style="width: 25%">Tên sách</th>
                        <th style="width: 18%">Mô tả</th>
                        <th style="width: 15%">Giá</th>
                        <th style="width: 7%">Số lượng còn</th>
                        <th style="width: 20%">Thao tác</th>
                    </tr>
                    <?php
                        $sql = "select * from hanghoa join hinhhh on hanghoa.MSHH=hinhhh.MSHH";
                        $data = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
                        if(count($data)>0){
                            foreach($data as $x){
                                echo '<tr>';
                                echo
                                '
                                <td>
                                    <img src="../TONGQUAN/anh-sach/'.$x["TenHinh"].'" style="width:70px;height:100px;">
                                </td>
                                <td>
                                    <h6>'.$x["TenHH"].'</h6>
                                </td>
                                <td>
                                    <a href="xemmota.php?mshh='.$x["MSHH"].'">Xem chi tiết mô tả</a>
                                </td>
                                <td>
                                    '.number_format($x["Gia"], 0, ',', '.')." đ".'
                                </td>
                                <td>
                                    '.$x["SoLuongHang"].'
                                </td>
                                <td>
                                    <a href="suasach.php?mshh='.$x["MSHH"].'" class="btn btn-danger">Sửa</a>
                                    
                                </td>
                                ';
                                echo '</tr>';
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