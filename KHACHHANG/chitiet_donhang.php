<?php
include("../TONGQUAN/config.php");
session_start();
$id = $_GET["SoDonDH"];

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
                Chi tiết đơn đặt hàng
            </h4>
            <br>
            <div class="mx-auto table-responsive border border-danger" style="width:70%; padding:20px">
                <?php
                    $sql = "select * from dathang join khachhang on dathang.MSKH = khachhang.MSKH  
                    join chitietdathang on dathang.SoDonDH = chitietdathang.SoDonDH 
                    join hanghoa on chitietdathang.MSHH = hanghoa.MSHH 
                    join hinhhh on hanghoa.MSHH = hinhhh.MSHH 
                    where dathang.SoDonDH='$id'";
                    $thongtin = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
                ?>
                <table class="table">
                    <tr>
                        <th colspan="3">
                            Thông tin khách hàng
                        </th>
                    </tr>
                    <tr>
                        <td></td>
                        <th class="text-end">
                            Khách hàng
                        </th>
                        <td class="text-start">
                            <small>
                                <?php echo $thongtin[0]["HoTenKH"]; ?>
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <th class="text-end">
                            Số điện thoại
                        </th>
                        <td class="text-start">
                            <small>
                                <?php echo $thongtin[0]["SoDienThoai"]; ?>
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <th class="text-end">
                            Địa chỉ
                        </th>
                        <td class="text-start">
                            <small>
                                <?php echo $thongtin[0]["DiaChi"]; ?>
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="3">
                            Thông tin đặt hàng
                        </th>
                    </tr>
                    <tr>
                        <td></td>
                        <th class="text-end">
                            Ngày đặt
                        </th>
                        <td class="text-start">
                            <small>
                                <?php echo date_format(date_create($thongtin[0]["NgayDH"]), "d-m-Y H:i"); ?>
                            </small>
                        </td>
                    </tr>
                    <tr>
                    <td></td>
                        <?php
                            if($thongtin[0]["TrangThaiDH"]=="Đã giao hàng"){
                                echo
                                '
                                <th class="text-end">
                                    Ngày giao
                                </th>
                                <td class="text-start">
                                    <small>
                                        '.date_format(date_create($thongtin[0]["NgayGH"]), "d-m-Y H:m").'
                                    </small>
                                </td>
                                ';
                            }else{
                                echo
                                '
                                <th class="text-end">
                                    Ngày giao dự kiến
                                </th>
                                <td class="text-start">
                                    <small>
                                        '.date_format(date_create($thongtin[0]["NgayGH"]), "d-m-Y").'
                                    </small>
                                </td>
                                ';
                            }
                        ?>
                    </tr>
                    <tr>
                        <td></td>
                        <th class="text-end">
                            Trạng thái
                        </th>
                        <td class="text-start">
                            <small>
                                <?php echo $thongtin[0]["TrangThaiDH"]; ?>
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <th class="text-end">
                            Sách
                        </th>
                        <td class="text-center">
                            <div class="text-center">
                                <img src="../TONGQUAN/anh-sach/<?php echo $thongtin[0]["TenHinh"]; ?>" alt="" style="height:100px; width:70px;">
                            </div>
                            <small>
                                <?php echo $thongtin[0]["TenHH"]; ?>
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <th class="text-end">
                            Đơn giá
                        </th>
                        <td class="text-start">
                            <small>
                                <?php echo number_format($thongtin[0]["Gia"], 0, ',', '.')."đ"; ?>
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <th class="text-end">
                            Số lượng
                        </th>
                        <td class="text-start">
                            <small>
                                <?php echo $thongtin[0]["SoLuong"]; ?>
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <th class="text-end">
                            Giảm giá
                        </th>
                        <td class="text-start">
                            <small>
                                <?php echo "-".number_format($thongtin[0]["GiamGia"], 0, ',', '.')."đ"; ?>
                            </small>
                        </td>
                    </tr>
                    <tr class="bg-danger">
                        <td></td>
                        <th class="text-end">
                            Tổng tiền
                        </th>
                        <th class="text-start">
                            <small>
                                <?php echo "<u>".number_format($thongtin[0]["GiaDatHang"], 0, ',', '.')."đ</u>"; ?>
                            </small>
                        </th>
                    </tr>
                    <?php
                        $msnv = $thongtin[0]["MSNV"];
                        $sql = "select * from nhanvien 
                        where MSNV='$msnv'";
        
                        $thongtin = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);

                    ?>
                    <tr>
                        <th colspan="3">
                            Thông tin nhân viên lập đơn hàng
                        </th>
                    </tr>
                    <tr>
                        <td></td>
                        <th class="text-end">
                            Nhân viên
                        </th>
                        <td class="text-start">
                            <small>
                                <?php echo (count($thongtin)>0)?$thongtin[0]["HoTenNV"]:""; ?>
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <th class="text-end">
                            Số điện thoại
                        </th>
                        <td class="text-start">
                            <small>
                                <?php echo (count($thongtin)>0)?$thongtin[0]["SoDienThoai"]:""; ?>
                            </small>
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <div class="text-center">
                <a href="index.php" class="btn btn-danger">Về trang chủ</a>
                <a href="donhang.php" class="btn btn-danger">Tất cả đơn hàng</a>
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