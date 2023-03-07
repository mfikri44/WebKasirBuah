<?php
    session_start();
    $id_pengguna=$_SESSION['id_pengguna'];
    $_SESSION['id_pengguna']='';
    $_SESSION['kode_pengguna']='';
    $_SESSION['nama_pengguna']='';
    $_SESSION['username']='';
    $_SESSION['level']='';

   

    unset($_SESSION['id_pengguna']);
    unset($_SESSION['kode_pengguna']);
    unset($_SESSION['nama_pengguna']);
    unset($_SESSION['username']);
    unset($_SESSION['level']);

    session_unset();
    session_destroy();

    $waktu=date("Y-m-d h:i:s");
    $log_aktifitas="Logout";

    include "config/database.php";
    mysqli_query($kon,"insert into log_aktifitas (waktu,aktifitas,id_pengguna) values ('$waktu','$log_aktifitas','$id_pengguna')");

    header('Location:login.php');

?>