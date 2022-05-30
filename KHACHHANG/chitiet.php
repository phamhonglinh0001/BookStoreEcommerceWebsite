<?php
include("../TONGQUAN/config.php");
session_start();
$mshh = $_GET["mshh"];
$sql = 'select * from hanghoa where MSHH=' . $mshh;
$hanghoa = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC)[0];
$sql = 'select TenHinh from HinhHH where MSHH=' . $mshh . ' limit 1';
$hinh = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC)[0]["TenHinh"];

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

        <div class="mx-auto" style="min-height: 80vh; width: 60%; padding:50px;">
            <div class="row">
                <div class="col-5">
                    <img class="mx-auto" src="../TONGQUAN/anh-sach/<?php echo ($hinh) ? $hinh : ""; ?>" alt="" style="display: block; width:200px;">
                </div>
                <div class="col-6 text-start">
                    <br>
                    <h4>
                        <?php echo ($hanghoa["TenHH"]) ? $hanghoa["TenHH"] : ""; ?>
                    </h4>
                    <p style="font-size: 18px;">
                        <?php echo ($hanghoa["Gia"]) ? number_format($hanghoa["Gia"], 0, ',', '.')." đ" : ""; ?>
                    </p style="font-size: 18px;">
                    <script>
                        function tang() {
                            let x = document.getElementById("sl");
                            let sl = x.innerHTML;
                            x.innerHTML = parseInt(sl) + 1;
                        }

                        function giam() {
                            let x = document.getElementById("sl");
                            let sl = x.innerHTML;
                            if (parseInt(sl) > 1) x.innerHTML = parseInt(sl) - 1;
                        }
                    </script>
                    <br>
                    <span>Chọn số lượng:

                        <button onclick="giam();" class="bg-warning text-white" style="border:none;width: 20px; font-size: 12px; cursor: pointer;">
                            <b>
                                -
                            </b>
                        </button>

                        <span class="badge bg-danger" id="sl">1</span>

                        <button onclick="tang();" class="bg-warning text-white" style="border:none;width: 20px; font-size: 12px; cursor: pointer;">
                            <b>
                                +
                            </b>
                        </button>

                    </span>
                    <br><br>
                    <a id="muangay" <?php echo "mshh=$mshh" ?>><button onclick="kiemtrasoluong()" class="btn btn-danger">Mua ngay</button></a>
                    <script>
                        function kiemtrasoluong() {
                            const lk = document.getElementById("muangay");
                            let mshh = lk.getAttribute("mshh");
                            let sl = document.getElementById("sl").textContent;
                            lk.setAttribute("href", "kiemtrasoluong.php?mshh=" + mshh + "&sl=" + sl);
                        }
                    </script>
                    <br>
                    <div>
                        <br>
                        <span class="text-danger">
                            <?php if(isset($_SESSION["err_sl"])) {echo $_SESSION["err_sl"]; unset($_SESSION["err_sl"]);} ?> 
                        </span>
                    </div>
                </div>
            </div>
            <div class="row" style="padding: 20px;">
                <h5 class="text-center">
                    Về quyển sách
                </h5>
                <p>
                    <?php echo ($hanghoa["MoTaHH"]) ? $hanghoa["MoTaHH"] : ""; ?>
                </p>
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