<?php
session_start();
if(isset($_SESSION["MSKH"])){
    unset($_SESSION["MSKH"]);
    header("location:index.php");
}else{
    header("location:index.php");
}

?>