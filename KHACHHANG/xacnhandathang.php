<?php
include("../TONGQUAN/config.php");
session_start();
if(isset($_GET["mshh"])&&isset($_GET["sl"])){
    $mshh = $_GET["mshh"];
    $sl = $_GET["sl"];
    $mskh = $_SESSION["MSKH"];
    $sql = "select * from hanghoa where MSHH='$mshh'";
    $hanghoa = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC)[0];
    $sql = "select TenHinh from HinhHH where MSHH='$mshh'";
    $hinhhanghoa = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC)[0]["TenHinh"];
    $sql = "select * from khachhang where MSKH='$mskh'";
    $khachhang = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC)[0];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "select SoLuongHang from hanghoa where MSHH='$mshh'";
    $data = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
    if(count($data)>0){
        if($sl<=$data[0]["SoLuongHang"]){
            $NgayDH = date("Y-m-d H:i:s");
            $NgayGH = date_modify(date_create($NgayDH), "+5 days");
            $NgayGH = date_format($NgayGH, "Y-m-d H:i:s");

            $sql = "insert into DatHang(MSKH, NgayDH, NgayGH, TrangThaiDH) values 
            ('$mskh','$NgayDH','$NgayGH','Chờ xác nhận')";
            mysqli_query($conn, $sql);

            $sql = "select max(SoDonDH) from DatHang";
            $maxid = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC)[0]["max(SoDonDH)"];

            $gia = $hanghoa["Gia"];
            $giadathang = $gia * $sl;
            $sql = "insert into ChiTietDatHang(SoDonDH, MSHH, SoLuong, GiaDatHang) values 
            ('$maxid','$mshh','$sl','$giadathang')";
            mysqli_query($conn, $sql);

            header("location:chitiet_donhang.php?SoDonDH=".$maxid);

        }else{
            $_SESSION["err_sl"] = "Chỉ còn ".$data[0]["SoLuongHang"]." quyển";
            header("location:chitiet.php?mshh=".$mshh);
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
                Xác nhận thông tin đặt hàng
            </h4>
            <br>
            <form action="" method="post">
            <div class="mx-auto table-responsive border border-danger" style="width:60%;">
                    <table class="table">
                        <tr class="bg-danger text-white">
                            <th colspan="3">Thông tin đơn hàng</th>
                        </tr>
                        <tr>
                            <td></td>
                            <th>
                                Tên sách
                            </th>
                            <td>
                                <div class="text-center">
                                    <img src="../TONGQUAN/anh-sach/<?php echo $hinhhanghoa; ?>" alt="anh sach" style="height:170px; width:110px">
                                </div>
                                <br>
                                <p class="text-center">
                                    <?php echo $hanghoa["TenHH"]; ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <th>
                                Số lượng
                            </th>
                            <td class="text-center">
                                <?php echo $sl; ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <th>
                                Đơn giá
                            </th>
                            <td class="text-center">
                                <?php echo number_format($hanghoa["Gia"], 0, ',', '.')."đ"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <th>
                                Thành tiền
                            </th>
                            <th class="text-center">
                                <?php echo number_format($hanghoa["Gia"]*$sl, 0, ',', '.')."đ"; ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="bg-danger text-white" colspan="3">Thông tin khách hàng</th>
                        </tr>
                        <tr>
                            <td></td>
                            <th>
                                Tên khách hàng
                            </th>
                            <td class="text-center">
                                <small>
                                    <?php echo $khachhang["HoTenKH"]; ?>
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <th>
                                Số điện thoại
                            </th>
                            <td class="text-center">
                                <small>
                                    <?php echo $khachhang["SoDienThoai"]; ?>
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <th>
                                Địa chỉ
                            </th>
                            <td class="text-center">
                                <small>
                                    <?php echo $khachhang["DiaChi"]; ?>
                                </small>
                            </td>
                        </tr>                    
                    </table>
                
            </div>
            <br>
            <div class="text-center">
                            <button class="btn btn-danger">
                                Xác nhận mua hàng
                            </button>
            </div>
            </form>
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