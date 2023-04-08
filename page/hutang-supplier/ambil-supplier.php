<?php
    include '../../config/database.php';
    $kode_supplier=$_POST['kode_supplier'];
    $query = mysqli_query($kon, "SELECT * FROM supplier where kode_supplier='$kode_supplier'");
    $data = mysqli_fetch_array($query);     
?>
<input type="hidden" id="ambil_kode" value="<?php echo $data['kode_supplier']?>"/>
<input type="hidden" id="ambil_nama" value="<?php echo $data['nama_supplier']?>"/>
<input type="hidden" id="ambil_nomor" value="<?php echo $data['no_telp']?>"/>
<input type="hidden" id="ambil_alamat" value="<?php echo $data['alamat_supplier']?>"/>
<script>
    var kode =  $('#ambil_kode').val();
    var nama =  $('#ambil_nama').val();
    var nomor =  $('#ambil_nomor').val();
    var alamat =  $('#ambil_alamat').val();

    $('#kode_supplier').val(kode);
    $('#nama_supplier').val(nama);
    $('#harga_nomor').val(nomor);
    $('#alamat_supplier').val(alamat);
</script>
