<?php
include("config.php");
session_start();
if(isset($_POST["submit"])){
    $arr = explode("-", $_POST["submit"]);
    $chucvu = $arr[0];
    $ms = $arr[1];
}
if(isset($_POST["mk_c"])&&isset($_POST["mk_m"])&&isset($_POST["mk_r"])){
   $mk_c = md5($_POST["mk_c"]);
   $mk_m = md5($_POST["mk_m"]);
   $mk_r = md5($_POST["mk_r"]);

   if($mk_r!=$mk_m){
        $_SESSION["err_doimk"] = "Nhập lại mật khẩu không chính xác";
   }else if($chucvu=="KH"){
        $sql = "select Password from khachhang where MSKH='$ms'";
        $data = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC)[0]["Password"];
        if($mk_c!=$data) $_SESSION["err_doimk"] = "Nhập mật khẩu cũ không chính xác";
        else{
            $sql = "update khachhang set Password='$mk_m' where MSKH='$ms'";
            mysqli_query($conn, $sql);
            $_SESSION["err_doimk"] = "Đổi mật khẩu thành công";
        }

   }else{
        $sql = "select Password from nhanvien where MSNV='$ms'";
        $data = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC)[0]["Password"];
        if($mk_c!=$data) $_SESSION["err_doimk"] = "Nhập mật khẩu cũ không chính xác";
        else{
            $sql = "update nhanvien set Password='$mk_m' where MSNV='$ms'";
            mysqli_query($conn, $sql);
            $_SESSION["err_doimk"] = "Đổi mật khẩu thành công";
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
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <script src="./bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="./fontawesome/css/all.min.css">
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
                                        Đổi mật khẩu
                                    </b>
                                </h3>
                            </div>
                            <span class="text-danger">
                                <?php if(isset($_SESSION["err_doimk"])) {echo $_SESSION["err_doimk"]; unset($_SESSION["err_doimk"]);} ?> 
                            </span>
                            <br><br>
                            <input required name="mk_c" type="password" class="form-control" placeholder="Mật khẩu cũ">
                            <br>
                            <input required name="mk_m" type="password" class="form-control" placeholder="Mật khẩu mới">
                            <br>
                            <input required name="mk_r" type="password" class="form-control" placeholder="Nhập lại mật khẩu">
                            <br>
                            <div class="text-center">
                                <a href="../<?php if($chucvu=="KH") echo "KHACHHANG/taikhoan.php";
                                if($chucvu=="NV") echo "ADMIN/taikhoan_nv.php";
                                if($chucvu=="AD") echo "ADMIN/taikhoan_ad.php"; ?>" class="btn btn-primary" style="width:30%;border-radius:0; transform: translateY(-2px);">Trở về</a>
                                    
                                <button name="submit" value="<?php echo $_POST["submit"] ?>" class="bg-danger" type="submit" style="border: none; width: 30%;color: white; padding: 7px;">Đổi mật khẩu</button>
                
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