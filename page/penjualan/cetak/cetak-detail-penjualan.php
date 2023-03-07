<!DOCTYPE html>
<html>
<head>
  <!-- Custom styles for this template -->
  <link href="../../../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
    body {
    font-family: Georgia, serif;
    }
    @media print {
        body{
            width: 24,13cm;
            height: 27,94cm;
            margin: 5mm 0mm 30mm 0mm; 
            /* change the margins as you want them to be. */
        } 
    }
    .td .th{
        font-size: 9px;
    }
    </style>
</head>
    <body onload="window.print();">
        <?php
        include '../../../config/database.php';
   
        $query = mysqli_query($kon, "select * from profil_aplikasi order by nama_aplikasi desc limit 1");    
        $row = mysqli_fetch_array($query);
        ?>
        <div class="container">
            <div class="card">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h3><?php echo strtoupper($row['nama_aplikasi']);?></h3>
                        <h6><?php echo $row['alamat'];?></h6>
                        <h6>(024)6730593 - 081326556213</h6>
                    </div>
                </div>
            </div>
            <?php
                $no_invoice=$_GET['no_invoice'];
                $query = mysqli_query($kon, "SELECT * from penjualan left join pelanggan on penjualan.kode_pelanggan=pelanggan.kode_pelanggan inner join pengguna on penjualan.id_kasir=pengguna.id_pengguna where penjualan.no_invoice='$no_invoice'");    

                $data = mysqli_fetch_array($query);
                $no_invoice=$data['no_invoice'];
            ?>
            <div class="card-body">
                <!--rows -->   
                    <div class="row">
                        <div class="col-sm-8 text-left">
                            <h6 class="pb-2 pl-4"></h6>
                        </div>
                        <div class="col-sm-4 text-left">
                            <h6><strong>Semarang, <?php echo date('d F Y', strtotime($data["tanggal"]));?> </strong></h6>
                        </div>
                        <div class="col-sm-8 text-left">
                            <h6 class="pl-4">Nota No. <?php echo $data['no_invoice'];?></h6>
                        </div>
                        <div class="col-sm-4 text-left">
                            <h6>Kepada Yth. <?php echo $data['nama_pelanggan'];?></h6>
                        </div>
                    </div>
                    <hr>
                    <!--rows -->
                    <div>
                        <div class="col-sm-12">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>QTY</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $ambil['kode_produk']; ?></td>
                                        <td><?php echo $ambil['nama_produk']; ?></td>
                                        <td>Rp. <?php echo number_format($ambil['harga'],0,',','.'); ?></td>
                                        <td><?php echo $ambil['qty']; ?></td>
                                        <td>Rp. <?php echo number_format($tot,0,',','.'); ?></td>
                                    </tr>
                                        <?php endwhile;?>
                                    <tr>
                                        <td colspan="5" style="text-align:right"><strong>Total</strong></td> <td><strong>Rp. <?php echo number_format($total,0,',','.');  ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align:right"><strong>Diskon</strong></td> <td><strong>Rp. <?php echo number_format($data['diskon'],0,',','.');  ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align:right"><strong>Bayar</strong></td> <td><strong>Rp. <?php echo number_format($bayar,0,',','.');  ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align:right"><strong>Kembali</strong></td> <td><strong>Rp. <?php echo number_format($kembali,0,',','.');  ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                       
                    <div class="row">
                        <div class="col-sm-9 text-left">
                            <h6 class="pb-2 pl-4">Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan</h6>
                        </div>
                        <div class="col-sm-3 text-left">
                            <h6></h6>
                        </div>
                        <div class="col-sm-8 text-left">
                            <h6 class="pl-4 pb-8">Tanda Terima</h6>
                        </div>
                        <div class="col-sm-4 text-left">
                            <h6>Hormat Kami</h6>
                        </div>
                        <div class="col-sm-8 text-left">
                            <h6>&nbsp;</h6>
                            <h6>&nbsp;</h6>
                            <h6>&nbsp;</h6>
                        </div>
                        <div class="col-sm-4 text-left">
                            <h6>&nbsp;</h6>
                            <h6>&nbsp;</h6>
                            <h6>&nbsp;</h6>
                        </div>
                    </div> 
                    
                </div>
            </div>
        </div>
    </body>
</html>