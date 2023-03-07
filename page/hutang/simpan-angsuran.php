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

    if (isset($_POST['buat_transaksi_angsuran'])) {

        //Memulai transaksi
        mysqli_query($kon,"START TRANSACTION");

        //Mengambil kiriman form
        $no_invoice=input($_POST['no_invoice']);
        $tanggal=date("Y-m-d H:i");
        $nominal=input($_POST['nominal']);
        $id_kasir=input($_POST['id_kasir']);

        $query = mysqli_query($kon, "SELECT cicilan_ke FROM pembayaran_hutang WHERE no_invoice ='$no_invoice'");        
        $count=mysqli_num_rows($query);

        $sql="SELECT cicilan_ke FROM pembayaran_hutang where no_invoice='$no_invoice' ORDER BY tanggal_pembayaran DESC LIMIT 1";
        $maxbulan=mysqli_query($kon,$sql);
        $cicilbulan = 0;
        $cicilan_ke = 0;
        while($ambil = mysqli_fetch_array($maxbulan)){
            $cicilbulan = $ambil['cicilan_ke'];
        }
        if($count>0){
            $cicilan_ke = $cicilbulan + 1;
        }else{
            $cicilan_ke = 1;
        }

        $sql_hutang="SELECT pembayaran_hutang FROM hutang_pelanggan where no_invoice='$no_invoice'";
        $pembayaran=mysqli_query($kon,$sql_hutang);

        $pmb_hutang = 0;
        while($pmb = mysqli_fetch_array($pembayaran)){
            $pmb_hutang = $pmb['pembayaran_hutang'];
        }

        $upd_pembayaran = $pmb_hutang + $nominal;
        
        $waktu=date("Y-m-d H:i");
        $log_aktivitas="Input angsuran pembayaran No Invoice #$no_invoice ";

        //Insert data ke tabel pembayaran_hutang
        $simpan_angsuran=mysqli_query($kon,"INSERT INTO pembayaran_hutang (no_invoice,nominal,cicilan_ke,tanggal_pembayaran) values ('$no_invoice','$nominal','$cicilan_ke','$tanggal')");
        
        //Insert data ke tabel hutang_pelanggan
        $edit_angsuran=mysqli_query($kon,"UPDATE hutang_pelanggan SET pembayaran_hutang = '$upd_pembayaran' WHERE no_invoice = '$no_invoice'");
        echo $edit_angsuran;

        //Menyiman aktivitas
        $simpan_aktivitas=mysqli_query($kon,"INSERT INTO log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_kasir)");
 

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi beberapa query diatas
        if ($simpan_angsuran and $edit_angsuran and $simpan_aktivitas) {

            //Jika semua query berhasil, lakukan commit
            mysqli_query($kon,"COMMIT");

            header("Location: ../../index.php?page=rincian_hutang&no_invoice=$no_invoice&add=berhasil");
        }
        else {
            //Jika ada query yang gagal, lakukan rollback
            mysqli_query($kon,"ROLLBACK");

            header("Location:../../index.php?page=rincian_hutang&no_invoice=$no_invoice&add=gagal");
        }
    }else {
       
        header("Location:../../index.php?page=rincian_hutang&no_invoice=$no_invoice&add=nominal_belum_diinput");
    }

?>
