<?php

    include 'config/database.php';
    if (isset($_GET['id_penjualan'])) {
        $id_penjualan=$_GET['id_penjualan'];
        $query = mysqli_query($kon, "SELECT * from penjualan left join pelanggan on penjualan.kode_pelanggan=pelanggan.kode_pelanggan left join pengguna on pengguna.id_pengguna=penjualan.id_kasir where id_penjualan='$id_penjualan'");    
    }else if (isset($_GET['no_invoice'])){
        $no_invoice=$_GET['no_invoice'];
        $query = mysqli_query($kon, "SELECT * from penjualan left join pelanggan on penjualan.kode_pelanggan=pelanggan.kode_pelanggan left join pengguna on pengguna.id_pengguna=penjualan.id_kasir where no_invoice='$no_invoice'");    
  
    }

    $data = mysqli_fetch_array($query);
    $no_invoice=$data['no_invoice'];
 


?>

<div class="container-fluid">
<!--Bagian heading -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h4 class="m-0 font-weight-bold text-primary">Rincian Angsuran Kredit</h4>
    <p class="mb-2">Halaman Detail Angsuran kredit yang dapat dikelola oleh admin</p>
  </div>
  <div class="card-body">
    <!--rows -->   
        <div class="row">
            <div class="col-sm-4">
                <!-- Waktu Transaksi Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Waktu Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>No Invoice</td>
                                    <td>: <?php echo $data['no_invoice'];?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Transaksi</td>
                                    <td>: <?php echo date('d/m/Y', strtotime($data["tanggal"]));?></td>
                                </tr>
                                <tr>
                                    <td>Jam</td>
                                    <td>: <?php echo date('H:i', strtotime($data["tanggal"]));?> WIB</td>
                                </tr>
                                <tr>
                                    <td>Kasir</td>
                                    <td>: <?php echo $data['nama_pengguna'];?></td>
                                </tr>
                                <tr>
                                    <td>Pelanggan</td>
                                    <td>: <?php echo $data['nama_pelanggan'];?></td>
                                </tr>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <table class="table">
                                <tbody>
                                <?php
                            
                                    // perintah sql untuk menampilkan daftar penjualan
                                    $sql1="select * from detail_penjualan inner join produk on produk.kode_produk=detail_penjualan.kode_produk INNER JOIN penjualan on penjualan.no_invoice=detail_penjualan.no_invoice where detail_penjualan.no_invoice='$no_invoice'";
                                    $result=mysqli_query($kon,$sql1);
                                    $total=0;
                                    $uang_muka=0;
                                    $kekurangan=0;
                                    //Menampilkan data dengan perulangan while
                                    while ($ambil = mysqli_fetch_array($result)){
                                        $tot= $ambil['harga_jual']*$ambil['qty'];
                                        $total+=$tot;
                                        $uang_muka=$ambil['bayar'];
                                        $kekurangan=$ambil['kembali'];
                                        $total_bayar_diskon=$ambil['total_bayar_diskon'];
                                        $diskon=$ambil['diskon'];
                                    }
                                    
                                    //get total cicilan, nominal terbayar pada tbl hutang_pelanggan
                                    $sql2="SELECT * FROM hutang_pelanggan WHERE no_invoice='$no_invoice'";
                                    $result2=mysqli_query($kon,$sql2);
                                    $bulan = 0;
                                    $nominal_terbayar = 0;
                                    while($hutang_pelanggan = mysqli_fetch_array($result2)){
                                        $bulan              = $hutang_pelanggan['cicilan_bulan'];
                                        $nominal_terbayar   = $hutang_pelanggan['pembayaran_hutang'];
                                    }
                                    //get max cicilan terakhir pada tbl pembayaran_hutang
                                    $sql3="SELECT cicilan_ke FROM pembayaran_hutang where no_invoice='$no_invoice' ORDER BY tanggal_pembayaran DESC LIMIT 1";
                                    $maxbulan=mysqli_query($kon,$sql3);
                                    $cicilbulan = 0;
                                    while($max = mysqli_fetch_array($maxbulan)){
                                        $cicilbulan = $max['cicilan_ke'];
                                    }
                                ?>
                                <tr>
                                    <td>Total</td> <td>: Rp. <?php echo number_format($total,0,',','.');  ?></td>
                                </tr>
                                <tr>
                                    <td>Diskon</td> <td>: Rp. <?php echo '-'.number_format($diskon,0,',','.');  ?></td>
                                </tr>
                                <tr>
                                    <td>Total Bayar Setelah Diskon</td> <td>: Rp. <?php echo number_format($total_bayar_diskon,0,',','.');  ?></td>
                                </tr>
                                <tr>
                                    <td>Uang Muka</td> <td>: Rp. <?php echo number_format($uang_muka,0,',','.');  ?></td>
                                </tr>
                                <tr>
                                    <td>Kekurangan</td> <td>: Rp. -<?php echo number_format($kekurangan,0,',','.');  ?></td>
                                </tr>
                                <tr>
                                    <td>Cicilan Perbulan</td> <td>: <?php echo $cicilbulan  ?> dari <?php echo $bulan  ?></td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td> 
                                    <td>:
                                        <?php
                                        if($kekurangan == $nominal_terbayar && $cicilbulan == $bulan ){
                                        echo 'Lunas';
                                        }else{
                                        echo 'Belum Lunas';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--rows -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Angsuran</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>   
                                <tr>
                                    <th>Cicilan ke </th>
                                    <th>Nominal Perbulan</th>
                                    <th>Nominal Terbayar</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql3="select * from pembayaran_hutang where no_invoice='$no_invoice'";
                                    $result3=mysqli_query($kon,$sql3);
                                    $count=mysqli_num_rows($result3);
                                        $perbulan = $kekurangan/$bulan;
                                        if($count>0){
                                            for ($x = 1; $x <= $bulan; $x++) {
                                                while($ambil2 = mysqli_fetch_array($result3)){
                                            ?>
                                            <tr>
                                                <td><?php echo $ambil2['cicilan_ke']; ?></td>
                                                <td>Rp. <?php echo number_format($perbulan,0,',','.'); ?> </td>
                                                <td>Rp. <?php echo number_format($ambil2['nominal'],0,',','.'); ?></td>
                                                <td>
                                                    <?php
                                                    if ($perbulan == $ambil2['nominal'] ){
                                                    echo 'Lunas';
                                                    }else{
                                                    echo 'Belum lunas';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            }
                                        }
                                        else {
                                            for ($x = 1; $x <= $bulan; $x++) {
                                            ?> 
                                            <tr>
                                                <td><?php echo $x; ?></td>
                                                <td><?php echo $perbulan; ?></td>
                                                <td>0</td>
                                                <td>
                                                    Belum Lunas
                                                </td>
                                            </tr>
                                <?php
                                            }
                                        }
                                        
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <?php
            $total_terbayar = 0;
            $total_terbayar += $nominal_terbayar;
            if($kekurangan == $nominal_terbayar && $cicilbulan == $bulan ){
            ?>
            <div class="col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pembayaran Angsuran</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-4">
                            <form action="page/hutang/simpan-angsuran.php" method="post">
                                <div class="form-group">
                                    <label class='font-weight-bold'>Uang Bayar:</label>
                                    <input type="text" class="form-control" value="Rp. <?php echo number_format($total_terbayar,0,',','.'); ?>" readonly>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }else{
            ?>
            <div class="col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pembayaran Angsuran</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-4">
                            <form action="page/hutang/simpan-angsuran.php" method="post">
                                <div class="form-group">
                                    <label class='font-weight-bold'>Nominal Pembayaran:</label>
                                    <input name="nominal" type="number" class="form-control" required>
                                </div>
                                    <input name="no_invoice" type="hidden" value="<?php echo $no_invoice ?>">
                                    <input type="hidden" name="id_kasir" value="<?php echo $_SESSION["id_pengguna"]; ?>" id="id_kasir" />
                                <button id="buat_transaksi_angsuran" name="buat_transaksi_angsuran" class="btn btn-success btn-block">Bayar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        
        </div>
    <!--rows -->
    </div>
</div>
</div>