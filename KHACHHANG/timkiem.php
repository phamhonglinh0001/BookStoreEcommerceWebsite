<?php
include("../TONGQUAN/config.php");
session_start();

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
            <div style="width: 60%;" class="mx-auto">
                <form action="" method="post">
                    <input class="form-control" type="text" name="ten" placeholder="Nhập tên sách">
                    <br>
                    <div class="text-center">
                    <button class="btn btn-danger">
                        Tìm kiếm
                    </button>
                    </div>
                </form>
            </div>
            <div>
            <div class="d-flex text-center justify-content-start flex-wrap align-content-around p-3" style="margin-top:50px; padding:10px;">
            <?php
                if(isset($_POST["ten"])){
                    $ten = $_POST["ten"];
                    $sql = "select * from hanghoa where TenHH LIKE '%$ten%'";
                    $data = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
                    if(!is_null($data)&&count($data)>0){
                        foreach($data as $x){
                            $sql = 'select TenHinh from HinhHH where MSHH='.$x["MSHH"];
                            $hinh = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC)[0]["TenHinh"];
                            echo
                            '
                            <div class="card" style="width:200px;padding:10px;margin:10px;">
                                <img class="card-img-top mx-auto" src="../TONGQUAN/anh-sach/'.$hinh.'" alt="Card image" style="height: 150px; width: 100px; display:block;">
                                <div class="card-body">
                                    <div class="text-center" style="height: 80px; margin: 10px 0; overflow:hidden;">
                                        <h6 class="card-title">'.$x["TenHH"].'</h6>
                                    </div>
                                    <div class="text-center">
                                        <a href="chitiet.php?mshh='.$x["MSHH"].'" class="btn btn-danger">Xem ngay</a>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                    }else{
                        echo
                        '
                        <div class="text-center" style="width:100%;">
                        <span class="text-danger">Không có kết quả phù hợp</span>
                        </div>
                        ';
                    }
                }else{
                    echo
                    '
                    <div class="text-center" style="width:100%;">
                    <span class="text-danger">Hãy nhập tên để tìm kiếm quyển sách bạn cần</span>
                    </div>
                    ';
                }
            ?>
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