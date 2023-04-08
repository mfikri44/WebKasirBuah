<?php
    require('../../../assets/plugin/fpdf/fpdf.php');
    $pdf = new FPDF('P','in',array(4.75,5.5));

    include '../../../config/database.php';
    $query = mysqli_query($kon, "select * from profil_aplikasi order by nama_aplikasi desc limit 1");    
    $row = mysqli_fetch_array($query);
    $pdf->SetLeftMargin(0.65);

    $pdf->AddPage();
    $pdf->SetFont('Arial','',14);
    $pdf->Cell(0,0,strtoupper($row['nama_toko']),0,1,'C');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,0.4,$row['alamat'],0,1,'C');
    $pdf->Cell(0,0.01,"(024)6730593 - 081326556213",0,1,'C');

 

    $no_invoice=$_GET['no_invoice'];
    $query = mysqli_query($kon, "SELECT * from penjualan left join pelanggan on penjualan.kode_pelanggan=pelanggan.kode_pelanggan inner join pengguna on penjualan.id_kasir=pengguna.id_pengguna where penjualan.no_invoice='$no_invoice'");
    $data = mysqli_fetch_array($query);

    $no_invoice=$data['no_invoice'];
    $pdf->Ln(0.2);         
    $pdf->Line(20, 45, 210-20, 45); // 20mm from each edge
    $pdf->SetLineWidth(4);

    $pdf->SetFont('Arial','',8);
    $pdf->Cell(2,0,'-----------------------------------------------------------------------------------------------------',0,0,'L');
    $pdf->Cell(0.1,0.01,'',0,0);
    $pdf->Cell(4,0.3,'Semarang, '. date('d F Y', strtotime($data["tanggal"])),0,1,'L');
    $pdf->Cell(0.1,0.01,'',0,0);
    $pdf->Cell(2,0.001,'No Invoice: ' . $data['no_invoice'],0,0,'L');
    $pdf->Cell(0,0.001,'Kepada Yth. '. $data['nama_pelanggan'],0,1,'L');

    $pdf->Ln(0.15);
    $pdf->Cell(2,0,'-----------------------------------------------------------------------------------------------------',0,1,'L');

    $pdf->Cell(0.1,0.01,'',0,0);
    $pdf->Cell(0.4,0.3,'Kode',0,0,'C');
    $pdf->Cell(1.7,0.3,'Produk',0,0,'C');
    $pdf->Cell(0.65,0.3,'Harga',0,0,'C');
    $pdf->Cell(0.15,0.3,'Qty',0,0,'C');
    $pdf->Cell(0.6,0.3,'Sub Total',0,1,'C');


    $pdf->Cell(0,0.01,'',0,1);
    $no=1;
    $total=0;
    //Query untuk mengambil data mahasiswa pada tabel mahasiswa
    $hasil = mysqli_query($kon, "select * from detail_penjualan inner join produk on produk.kode_produk=detail_penjualan.kode_produk INNER JOIN penjualan on penjualan.no_invoice=detail_penjualan.no_invoice where detail_penjualan.no_invoice='$no_invoice'");
    while ($ambil = mysqli_fetch_array($hasil)):
        $harga=$ambil['harga'];
        $sub_total=$harga*$ambil['qty'];
        $bayar=$ambil['bayar'];
        $kembali=$ambil['kembali'];
     
        $total+=$sub_total;

        $pdf->Cell(0.1,0.01,'',0,0);
        $pdf->Cell(0.4,0.01,$ambil['kode_produk'],0,0);
        $pdf->Cell(1.7,0.01,substr($ambil['nama_produk'],0,30),0,0);
        $pdf->Cell(0.65,0.01,'Rp. '.number_format($harga,0,',','.'),0,0);
        $pdf->Cell(0.15,0.01,$ambil['qty'],0,0,'C');
        $pdf->Cell(0.6,0.01,'Rp. '.number_format($sub_total,0,',','.'),0,0);
        $pdf->Cell(1,0.1,'',0,1);
        $pdf->Ln(0.02);

    endwhile;
 
    $pdf->Ln(0.001);
    $pdf->Cell(2,0,'-----------------------------------------------------------------------------------------------------',0,1);
    $pdf->Cell(0.1,0.01,'',0,0);
    $pdf->Cell(2.9,0.3,'Total Bayar',0,0,'R');
    $pdf->Cell(0,0.3,'Rp. '. $data['total_bayar'] ,0,0,'L');
    $pdf->Ln(0.15);
    $pdf->Cell(0.1,0.01,'',0,0);
    $pdf->Cell(2.9,0.3,'Diskon',0,0,'R');
    $pdf->Cell(0,0.3,'Rp. '. $data['diskon'] ,0,0,'L');
    $pdf->Ln(0.15);
    $pdf->Cell(0.1,0.01,'',0,0);
    $pdf->Cell(2.9,0.3,'Diskon Total',0,0,'R');
    $pdf->Cell(0,0.3,'Rp. '. $data['total_bayar_diskon'] ,0,0,'L');
    $pdf->Ln(0.15);
    $pdf->Cell(0.1,0.01,'',0,0);
    $pdf->Cell(2.9,0.3,'Uang Bayar',0,0,'R');
    $pdf->Cell(0,0.3,'Rp. '. $data['bayar'] ,0,0,'L');
    $pdf->Ln(0.15);
    $pdf->Cell(0.1,0.01,'',0,0);
    $pdf->Cell(2.9,0.3,'Kekurangan',0,0,'R');
    $pdf->Cell(0,0.3,'Rp. '. $data['kembali'] ,0,0,'L');
    $pdf->Ln(0.15);
    $pdf->Cell(0.1,0.01,'',0,0);
    $pdf->Cell(2.9,0.3,'Tipe Pembayaran',0,0,'R');
    $pdf->Cell(0,0.3,'Hutang',0,0,'L');
    $pdf->Ln(0.3);
    $pdf->Cell(2,0,'-----------------------------------------------------------------------------------------------------',0,1);
   
    $pdf->Cell(0.1,0.01,'',0,0);
    $pdf->Cell(3,0.3,'Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.',0,1,'L');
    $pdf->Ln(0.05);
    $pdf->Cell(0.1,0.01,'',0,0);
    $pdf->Cell(2,0.001,'Tanda Terima',0,0,'L');
    $pdf->Cell(0,0.001,'Hormat Kami',0,1,'L');


    $pdf->Output();
?>