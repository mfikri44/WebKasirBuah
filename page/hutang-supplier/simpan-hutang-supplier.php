<?php
    //Memulai session dan koneksi database
    session_start();
    include '../../config/database.php';

    //Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_POST['buat_hutang_supplier'])) {

        //Memulai transaksi
        mysqli_query($kon,"START TRANSACTION");

        //Mengambil kiriman form
        $id_admin=input($_POST['id_admin']);
        $kode_supplier=input($_POST['kode_supplier']);
        $tanggal_nota=input($_POST['tanggal_nota']);
        $tanggal_input=date("Y-m-d H:i");
        $jenis_transaksi=input($_POST['jenis_transaksi']);
        $nominal=input($_POST['nominal']);

        $waktu=date("Y-m-d H:i");
        $log_aktivitas="Input hutang supplier kode supplier #$kode_supplier ";

        //Insert data ke tabel hutang
        $simpan_hutang=mysqli_query($kon,"insert into hutang_supplier (kode_supplier,tanggal_nota,tanggal_input,jenis_transaksi,nominal) values ('$kode_supplier','$tanggal_nota','$tanggal_input','$jenis_transaksi','$nominal')");
       
        //Menyiman aktivitas
        $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_admin)");

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi beberapa query diatas
        if ($simpan_hutang and $simpan_aktivitas) {

            //Jika semua query berhasil, lakukan commit
            mysqli_query($kon,"COMMIT");

            header("Location:../../index.php?page=data_hutang_supplier&kode_supplier=$kode_supplier&add=berhasil");
        }
        else {
            //Jika ada query yang gagal, lakukan rollback
            mysqli_query($kon,"ROLLBACK");

            header("Location:../../index.php?page=input_hutang_supplier&add=gagal");
        }
    }
    else {
       
        header("Location:../../index.php?page=input_hutang_supplier&add=produk_belum_dipilih");
    }

?>
