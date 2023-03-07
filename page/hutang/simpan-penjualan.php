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

    if (isset($_POST['buat_transaksi_hutang'])) {

        //Memulai transaksi
        mysqli_query($kon,"START TRANSACTION");

        //Mengambil kiriman form
        $no_invoice=input($_POST['no_invoice']);
        $id_kasir=input($_POST['id_kasir']);
        $tanggal=date("Y-m-d H:i");
        $kode_pelanggan=input($_POST['kode_pelanggan']);
        $total_bayar=input($_POST['total_bayar']);
        $uang_muka=input($_POST['uang_muka']);
        $kekurangan=input($_POST['kekurangan']);
        $kekurangan=abs($kekurangan);
        $tipe_pembayaran=input($_POST['tipe_pembayaran']);

        $cicilan_bulan=input($_POST['cicilan_bulan']);
        $pembayaran_hutang= 0;

        $diskon=input($_POST['diskon']);
        $total_bayar_diskon=input($_POST['total_bayar_diskon']);

        $waktu=date("Y-m-d H:i");
        $log_aktivitas="Input hutang penjualan No Invoice #$no_invoice ";

        //Insert data ke tabel hutang
        $simpan_penjualan=mysqli_query($kon,"insert into penjualan (no_invoice,id_kasir,tanggal,kode_pelanggan,total_bayar,bayar,kembali,diskon,total_bayar_diskon,tipe_pembayaran) values ('$no_invoice','$id_kasir','$tanggal','$kode_pelanggan','$total_bayar','$uang_muka','$kekurangan','$diskon','$total_bayar_diskon','$tipe_pembayaran')");
        //Insert data ke tabel hutang_pelanggan
        $simpan_penjualan=mysqli_query($kon,"insert into hutang_pelanggan (no_invoice,cicilan_bulan,pembayaran_hutang) values ('$no_invoice','$cicilan_bulan','$pembayaran_hutang')");
       
        //Menyiman aktivitas
        $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_kasir)");


        $produk_dibeli=$_POST['produk_dibeli'];
        $qty=$_POST['qty'];
        $harga=$_POST['harga'];

        for ($i=0; $i < count($produk_dibeli) ; $i++){
         
            //Insert data ke detail penjualan
            $simpan_detail_penjualan=mysqli_query($kon,"insert into detail_penjualan (no_invoice,kode_produk,harga,qty) values ('$no_invoice','$produk_dibeli[$i]','$harga[$i]','$qty[$i]')");

            $ambil_produk= mysqli_query($kon, "SELECT * FROM produk where kode_produk='$produk_dibeli[$i]'");
            $data = mysqli_fetch_array($ambil_produk); 
            $stok_produk=$data['stok_produk'];
            $stok=$stok_produk-$qty[$i];

            //Update stok produk
            $update_stok=mysqli_query($kon,"update produk set stok_produk=$stok where kode_produk='$produk_dibeli[$i]'");
        }


        //Kondisi apakah berhasil atau tidak dalam mengeksekusi beberapa query diatas
        if ($simpan_penjualan and $simpan_detail_penjualan and $update_stok  and $simpan_aktivitas) {

            //Jika semua query berhasil, lakukan commit
            mysqli_query($kon,"COMMIT");

            //Kosongkan kerangjang belanja
            unset($_SESSION["cart_item_hutang"]);
            header("Location:../../index.php?page=detail_penjualan_hutang&no_invoice=$no_invoice&add=berhasil");
        }
        else {
            //Jika ada query yang gagal, lakukan rollback
            mysqli_query($kon,"ROLLBACK");

            //Kosongkan kerangjang belanja
            unset($_SESSION["cart_item_hutang"]);
            header("Location:../../index.php?page=input_hutang&add=gagal");
        }
    }else {
       
        header("Location:../../index.php?page=input_hutang&add=produk_belum_dipilih");
    }

?>
