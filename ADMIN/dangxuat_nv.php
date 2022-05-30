<?php
    session_start();
    if(isset($_SESSION["MSNV"])){
        unset($_SESSION["MSNV"]);
        header("location:index.php");
    }
?>