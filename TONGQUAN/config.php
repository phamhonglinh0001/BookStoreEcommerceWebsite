<?php
    define("HOST", "localhost");
    define("USER", "root");
    define("PASS", "");
    define("DB", "quanlydathang");
    define("ROOT", dirname(__FILE__));
    define("BASE_URL", "http://localhost/");
    $conn = mysqli_connect(HOST, USER, PASS, DB) or die ('Không thể kết nối tới database');
?>