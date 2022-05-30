<?php
include("../TONGQUAN/config.php");
session_start();
if(isset($_SESSION["MSKH"])){
    $mskh = $_SESSION["MSKH"];
}else{
    $_SESSION["err"] = "Bạn hãy đăng nhập để vào đơn hàng";
    $_SESSION["dieuhuong"] = "donhang.php";
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

        <div class="mx-auto" style="min-height: 80vh; width: 90%; padding:50px;">
            <h4 class="text-center">
                Thông tin đơn hàng
            </h4>
            <br>
            <div class="table-responsive" style="padding: 20px;">
                <table class="table table-bordered">
                    <tr class="text-center">
                        <th style="width:10%;">
                            Mã đơn hàng
                        </th>
                        <th style="width:25%;">
                            Thông tin khách hàng
                        </th>
                        <th style="width:25%;">
                            Thông tin đặt hàng
                        </th>
                        <th style="width:25%;">
                            Thông tin nhân viên lập đơn hàng
                        </th>
                        <th style="width:15%;">
                            Thao tác
                        </th>
                    </tr>
                    <?php
                        $sql = "select * from dathang join khachhang on dathang.MSKH = khachhang.MSKH 
                        left join chitietdathang on dathang.SoDonDH = chitietdathang.SoDonDH  
                        left join hanghoa on chitietdathang.MSHH = hanghoa.MSHH 
                        left join hinhhh on hanghoa.MSHH = hinhhh.MSHH 
                        where dathang.MSKH='$mskh'
                        ";
                        $thongtin = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
                        
                        if(count($thongtin)>0){
                            foreach($thongtin as $x){
                                echo '<tr>';
                                if($x["TrangThaiDH"]!="Đã hủy")
                                echo '<td class="text-center">'.$x["SoDonDH"].'<br><br><a href="chitiet_donhang.php?SoDonDH='.$x["SoDonDH"].'">Xem chi tiết</a></td>';
                                else echo '<td class="text-center">'.$x["SoDonDH"];
                                echo
                                '
                                <td>
                                    '.$x["HoTenKH"].' <br>
                                    '.$x["SoDienThoai"].' <br>
                                    '.$x["DiaChi"].' <br>
                                </td>
                                ';
                                if($x["TrangThaiDH"]=="Đã hủy")
                                echo
                                '
                                <td>
                                    Ngày đặt: <i>'.date_format(date_create($x["NgayDH"]), "d-m-Y H:i").'</i><br>
                                    Trạng thái: <i><u>'.$x["TrangThaiDH"].'</u></i>
                                </td>
                                ';
                                else{
                                    echo
                                    '
                                    <td>
                                        <a href="../KHACHHANG/chitiet.php?mshh='.$x["MSHH"].'">'.$x["TenHH"].'</a><br>
                                        Số lượng: '.$x["SoLuong"].' <br>
                                        Giảm giá: -'.number_format($x["GiamGia"], 0, ',', '.')."đ".' <br>
                                        Tổng tiền: '.number_format($x["GiaDatHang"], 0, ',', '.')."đ".' <br>
                                        Trạng thái: <i><u>'.$x["TrangThaiDH"].'</u></i><br>
                                        Ngày đặt: <i>'.date_format(date_create($x["NgayDH"]), "d-m-Y H:i").'</i> <br> 
                                    ';
                                    if($x["TrangThaiDH"]=="Đã giao hàng"){
                                        echo
                                        '
                                        Ngày giao: <i>'.date_format(date_create($x["NgayGH"]), "d-m-Y H:i").'</i>
                                        </td>
                                        ';
                                    }else{
                                        echo '
                                        Ngày giao dự kiến: <i>'.date_format(date_create($x["NgayGH"]), "d-m-Y").'</i>
                                        </td>';
                                    }
                                }
                                $msnv = $x["MSNV"];
                                $sql = "select * from nhanvien where MSNV='$msnv'";
                                $thongtinnv = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
                                if(count($thongtinnv)>0) {
                                    $tennv = $thongtinnv[0]["HoTenNV"];
                                    $sdt = $thongtinnv[0]["SoDienThoai"];
                                }else{
                                    $tennv = $sdt = "";
                                }
                                echo
                                '
                                <td class="text-center">
                                    '.$tennv.' <br>
                                    '.$sdt.'
                                </td>
                                ';
                                if($x["TrangThaiDH"]=="Chờ xác nhận"){
                                    echo
                                    '
                                    <td class="text-center">
                                        <a class="btn btn-danger" href="xulydonhang.php?cn=huy&id='.$x["SoDonDH"].'">Hủy đơn hàng</a>
                                    </td>
                                    '; 
                                }else{
                                    echo '<td></td>';
                                }
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