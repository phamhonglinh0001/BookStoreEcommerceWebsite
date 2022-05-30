<?php
    session_start();
    if(isset($_SESSION["MSAD"])){
        unset($_SESSION["MSAD"]);
        header("location:index.php");
    }
?>