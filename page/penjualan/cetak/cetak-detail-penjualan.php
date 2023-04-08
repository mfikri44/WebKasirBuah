<!DOCTYPE html>
<html>
<head>
  <!-- Custom styles for this template -->
  <link href="../../../assets/css/sb-admin-2.min.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> -->
    <style type="text/css">
    /* Kode CSS Untuk PAGE ini dibuat oleh http://jsfiddle.net/2wk6Q/1/ */
        body {
            width: 100%;
            height: 100%;
            line-spacing: 10px;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font-family: sans-serif;
            letter-spacing: 1.5px;
        }
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }
        .page {
            width: 5.9in;
            min-height: 5.5in;
            /* padding: 20mm; */
            /* margin: 10mm auto; */
            border: 1px #D3D3D3 solid;
            border-radius: 2px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        @page {
        size: 4.75in 5.5in;
        }

        @media  (max-width: 5in){
            @page {
                size: 4.75in 5.5in;/* width height */

            }
        }

        /* @media (max-width: 6in) {
            @page {
                size: letter;
            }
        } */

    </style>
    <!-- <style>
    body {
    font-family: Georgia, serif;
    }
    @media print {
        body{
            width: 10.5cm;
            height: 7cm;
            /* margin: 5mm 0mm 30mm 0mm;  */
            /* change the margins as you want them to be. */
        } 
    }
    .td .th{
        font-size: 9px;
    }
    </style> -->
</head>
    <body onload="window.print();">
    <?php
    include '../../../config/database.php';

    $query = mysqli_query($kon, "select * from profil_aplikasi order by nama_aplikasi desc limit 1");    
    $row = mysqli_fetch_array($query);
    
    $no_invoice=$_GET['no_invoice'];
    $query = mysqli_query($kon, "SELECT * from penjualan left join pelanggan on penjualan.kode_pelanggan=pelanggan.kode_pelanggan inner join pengguna on penjualan.id_kasir=pengguna.id_pengguna where penjualan.no_invoice='$no_invoice'");    

    $data = mysqli_fetch_array($query);
    $no_invoice=$data['no_invoice'];
    ?>       
    <div class="page">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="text-m"><strong><?php echo strtoupper($row['nama_aplikasi']);?></strong></div>
                    <div class="text-s"><?php echo $row['alamat'];?></div>
                    <div class="text-s">(024)6730593 - 081326556213</div>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!--rows -->   
            <div class="row text-s">
                <div class="col-5">
                    <div class="text-left"> </div>
                </div>
                <div class="col">
                    <div class="text-left"><strong>Semarang, <?php echo date('d F Y', strtotime($data["tanggal"]));?> </strong></div>
                </div>
            </div>
            
            <div class="row text-s">
                <div class="col-5">
                    <div class="text-left">Nota No.  <?php echo $data['no_invoice'];?></div>
                </div>
                <div class="col">
                    <div class="text-left">Kepada Yth. <?php echo $data['nama_pelanggan'];?></div>
                </div>
            <div>
            <hr class="">
            <div class="row text-s">
                <div class="col-12">
                    <div class="row font-weight-bolder">
                        <div class="col-4">Produk
                        </div>
                        <div class="col-3">Harga
                        </div>
                        <div class="col-2">QTY
                        </div>
                        <div class="col-3">Sub Total
                        </div>  
                    </div>
                    <?php
                        // perintah sql untuk menampilkan daftar penjualan yang berelasi dengan tabel kategori penjualan
                        $sql1="select * from detail_penjualan inner join produk on produk.kode_produk=detail_penjualan.kode_produk INNER JOIN penjualan on penjualan.no_invoice=detail_penjualan.no_invoice where detail_penjualan.no_invoice='$no_invoice'";
                        $result=mysqli_query($kon,$sql1);
                        $no=0;
                        $total=0;
                        $bayar=0;
                        $kembali=0;
                        //Menampilkan data dengan perulangan while
                        while ($ambil = mysqli_fetch_array($result)):
                        $no++;
                        $tot= $ambil['harga_jual']*$ambil['qty'];
                        $total+=$tot;
                        $bayar=$ambil['bayar'];
                        $kembali=$ambil['kembali'];
                    ?>
                    <div class="row">
                        <div class="col-4"><?php echo $ambil['nama_produk']; ?>
                        </div>
                        <div class="col-3">Rp. <?php echo number_format($ambil['harga'],0,',','.'); ?>
                        </div>
                        <div class="col-2"><?php echo $ambil['qty']; ?>
                        </div>
                        <div class="col-3">Rp. <?php echo number_format($tot,0,',','.'); ?>
                        </div>  
                    </div>
                    <?php endwhile;?>
                    <hr>
                    <!-- Total -->
                    <div class="row pb-1">
                        <div class="col-5">
                        </div>
                        <div class="col-4">Total
                        </div>
                        <div class="col-3">Rp. <?php echo number_format($tot,0,',','.'); ?>
                        </div>  
                    </div>
                    <!-- Diskon -->
                    <div class="row pb-1">
                        <div class="col-5">
                        </div>
                        <div class="col-4">Diskon
                        </div>
                        <div class="col-3">Rp. <?php echo number_format($data['diskon'],0,',','.'); ?>
                        </div>  
                    </div>

                    <div class="row pb-1">
                        <div class="col-5">
                        </div>
                        <div class="col-4">Diskon Total
                        </div>
                        <div class="col-3">Rp. <?php echo number_format($data['total_bayar_diskon'],0,',','.'); ?>
                        </div>  
                    </div>
                    <div class="row pb-1">
                        <div class="col-5">
                        </div>
                        <div class="col-4">Uang Bayar
                        </div>
                        <div class="col-3">Rp. <?php echo number_format($data['bayar'],0,',','.'); ?>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-5">
                        </div>
                        <div class="col-4">Uang Kembali
                        </div>
                        <div class="col-3">Rp. <?php echo number_format($data['kembali'],0,',','.'); ?>
                        </div>  
                    </div>
                </div>
            </div>
            <hr>
            <div class="row text-s pb-5">
                <div class="col-12 text-left">
                    Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.
                </div>
                <div class="col">
                    <div class="text-left">Tanda Terima</div>
                </div>
                <div class="col">
                    <div class="text-left">Hormat Kami</div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>