<?php
include("../TONGQUAN/config.php");
session_start();

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $msnv = $_GET["msnv"];
    $ten = $_POST["ten"];
    $diachi = $_POST["diachi"];
    $sdt = $_POST["sdt"];
    $chucvu = $_POST["chucvu"];

    $sql = "select MSNV from nhanvien where SoDienThoai='$sdt' and not(MSNV='$msnv')";
    $data = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
    if(count($data)>0) $_SESSION["err_sua_nv"] = "Số điện thoại đã tồn tại";
    else{
        $sql = "update nhanvien set HoTenNV='$ten', DiaChi='$diachi', SoDienThoai='$sdt', ChucVu='$chucvu' where MSNV='$msnv' ";
        mysqli_query($conn, $sql);
        
        $_SESSION["err_sua_nv"] = "Sửa nhân viên thành công";
    }
}
if(isset($_GET["msnv"])){
    $msnv = $_GET["msnv"];
    $sql = "select * from nhanvien where MSNV='$msnv'";
    $data = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC)[0];
}
if(isset($_SESSION["MSAD"])){
    $msad = $_SESSION["MSAD"];
}else{
    $_SESSION["err"] = "Bạn hãy đăng nhập vào hệ thống";
    $_SESSION["dieuhuong"] = "sua_nv.php?msnv=".$msnv;
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

        <div class="mx-auto" style="min-height: 80vh; width: 80%; padding:50px;">
            <h5 class="text-center mx-auto bg-success text-white" style="width:70%; padding:10px;">
                Thêm nhân viên mới
            </h5>
            <br>
            <div class="text-center">
                <span class="text-danger">
                    <?php
                        if(isset($_SESSION["err_sua_nv"])){
                            echo $_SESSION["err_sua_nv"];
                            unset($_SESSION["err_sua_nv"]);
                        }
                    ?>
                </span>
            </div>
            <br>
            <div class="table-responsive mx-auto" style="width:70%;">
                <form action="" method="post" enctype="multipart/form-data">
                <table class="table table-bordered text-end">
                    <tr>
                        <th>
                            Họ tên
                        </th>
                        <td>
                            <input value="<?php echo $data["HoTenNV"] ?>" required placeholder="Nhập họ tên" type="text" class="form-control" name="ten">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Địa chỉ
                        </th>
                        <td>
                            <textarea class="form-control" placeholder="Nhập địa chỉ" required name="diachi" cols="50" rows="3"><?php echo $data["DiaChi"] ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Chức vụ
                        </th>
                        <td>
                            <select name="chucvu" class="form-select">
                                <option value="NV" <?php if($data["ChucVu"]=="NV") echo "selected"; ?>>Nhân viên</option>
                                <option value="AD" <?php if($data["ChucVu"]=="AD") echo "selected"; ?>>Admin</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Số điện thoại
                        </th>
                        <td>
                            <input value="<?php echo $data["SoDienThoai"] ?>" required placeholder="Nhập số điện thoại" type="text" class="form-control" name="sdt">
                        </td>
                    </tr>
                </table>
                <div class="text-center">
                    <a href="ql_nhanvien.php" class="btn btn-primary">Trở về</a>
                    <button type="submit" class="btn btn-danger">Sửa</button>
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