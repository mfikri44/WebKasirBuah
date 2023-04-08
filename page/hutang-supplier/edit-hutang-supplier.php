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

    if (isset($_POST['edit_hutang_supplier'])) {

        //Memulai transaksi
        mysqli_query($kon,"START TRANSACTION");

        //Mengambil kiriman form
        $id_hutang_supplier=input($_POST['id_hutang_supplier']);
        $id_admin=input($_POST['id_admin']);
        $kode_supplier=input($_POST['kode_supplier']);
        $tanggal_nota=input($_POST['tanggal_nota']);
        $tanggal_input=date("Y-m-d H:i");
        $jenis_transaksi=input($_POST['jenis_transaksi']);
        $nominal=input($_POST['nominal']);

        $waktu=date("Y-m-d H:i");
        $log_aktivitas="Edit hutang supplier kode supplier #$kode_supplier ";

        
        //Query input menginput data kedalam tabel pelanggan
        $sql="update hutang_supplier set
        kode_supplier='$kode_supplier',
        tanggal_nota='$tanggal_nota',
        tanggal_input='$tanggal_input',
        jenis_transaksi='$jenis_transaksi',
        nominal='$nominal'
        where id_hutang_supplier=$id_hutang_supplier";

        //Mengeksekusi query 
        $update_pelanggan=mysqli_query($kon,$sql);

        //Menyiman aktivitas
        $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_admin)");

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi beberapa query diatas
        if ($update_pelanggan and $simpan_aktivitas) {

            //Jika semua query berhasil, lakukan commit
            mysqli_query($kon,"COMMIT");

            header("Location:../../index.php?page=data_hutang_supplier&kode_supplier=$kode_supplier&edit=berhasil");
        }
        else {
            //Jika ada query yang gagal, lakukan rollback
            mysqli_query($kon,"ROLLBACK");

            header("Location:../../index.php?page=edit_hutang_supplier&edit=gagal");
        }
    }
    else {
       
        header("Location:../../index.php?page=edit_hutang_supplier&edit=produk_belum_dipilih");
    }

?>
