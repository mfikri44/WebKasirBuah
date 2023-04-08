<div class="container-fluid">
<!--Bagian heading -->
<h1 class="h3 mb-2 text-gray-800">Hutang Supplier</h1>
<p class="mb-4">Halaman hutang Supplier berisi informasi seluruh hutang supplier yang dilakukan oleh owner yang dapat di kelola oleh admin sebagai pencatatan hutang.</p>
<?php
    //Validasi untuk menampilkan pesan pemberitahuan saat user menambah hutang supplier
    if (isset($_GET['add'])) {
        if ($_GET['add']=='berhasil'){
            echo"<div class='alert alert-success'>Transaksi Berhasil</div>";
        }else if ($_GET['add']=='gagal'){
            echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Hutang Supplier gagal ditambahkan!</div>";
        }else{
          echo"<div class='alert alert-danger'><strong>Gagal!</strong> Pembayaran kurang!</div>";
        }
    }

    //Validasi untuk menampilkan pesan pemberitahuan saat user mengubah supplier
    if (isset($_GET['edit'])) {
      if ($_GET['edit']=='berhasil'){
          echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Hutang Supplier telah diupdate!</div>";
      }else if ($_GET['edit']=='gagal'){
          echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Hutang Supplier gagal diupdate!</div>";
      }    
    }

    //Validasi untuk menampilkan pesan pemberitahuan saat user menghapus supplier
    if (isset($_GET['hapus'])) {
      if ($_GET['hapus']=='berhasil'){
          echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Hutang Supplier telah dihapus!</div>";
      }else if ($_GET['hapus']=='gagal'){
          echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Hutang Supplier gagal dihapus!</div>";
      }    
    }
?>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="index.php?page=input_hutang_supplier" class="btn btn-dark btn-icon-split"><span class="text">Tambah</span></a>
 </div>
  <div class="card-body">
    <!-- Tabel daftar penjualan -->
    <!-- <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Supplier</th>
            <th>Tanggal Nota</th>
            <th>Tanggal Input</th>
            <th>Debit/Kredit</th>
            <th>Nominal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
            <?php
                // Koneksi database
                include 'config/database.php';
                $sql="select * from hutang_supplier order by tanggal_nota desc";
             
             $hasil=mysqli_query($kon,$sql);
                $no=0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)):
                $no++;
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data['kode_supplier']; ?></td>
                <td><?php echo date('d-m-Y', strtotime($data["tanggal_nota"])); ?></td>
                <td><?php echo date('d-m-Y', strtotime($data["tanggal_input"])); ?></td>
                <td><?php echo $data['jenis_transaksi']; ?></td>
                <td>Rp. <?php echo number_format($data['nominal'],0,',','.'); ?></td>
                <td>
                    <a href="index.php?page=edit_hutang_supplier&id_hutang_supplier=<?php echo $data['id_hutang_supplier']; ?>" class="btn btn-primary btn-circle" id_hutang_supplier="<?php echo $data['id_hutang_supplier']; ?>"  data-toggle="tooltip" title="Edit Hutang Supplier" data-placement="top"><i class="fas fa-pencil-alt"></i></a>
                    <button class="btn-hapus btn btn-danger btn-circle" id_hutang_supplier="<?php echo $data['id_hutang_supplier']; ?>"  kode_supplier="<?php echo $data['kode_supplier']; ?>" data-toggle="tooltip" title="Hapus Hutang Supplier" data-placement="top"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
      </table>
    </div> -->
    <div class="table-responsive">
      <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Supplier</th>
            <th>Tanggal Nota</th>
            <th>Tanggal Input</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
            <?php
                // Koneksi database
                include 'config/database.php';
                $sql="select * from hutang_supplier order by id_hutang_supplier desc";
             
                $k_nominal = 0;
                $d_nominal = 0;
                $hasil=mysqli_query($kon,$sql);
                $no=0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)):
                $no++;
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data['kode_supplier']; ?></td>
                <td><?php echo date('d-m-Y', strtotime($data["tanggal_nota"])); ?></td>
                <td><?php echo date('d-m-Y', strtotime($data["tanggal_input"])); ?></td>
                <td>
                  <?php if($data['jenis_transaksi'] == "Debit"){
                      echo number_format($data['nominal'],0,',','.'); 
                      $d_nominal += $data['nominal'];
                  }else{
                      echo "-"; 
                  }?>
                </td>
                <td>
                  <?php if($data['jenis_transaksi'] == "Kredit"){
                      echo number_format($data['nominal'],0,',','.');
                      $k_nominal += $data['nominal'];
                  }else{
                      echo "-"; 
                  }?>
                </td>
                <td><?php echo $data['jenis_transaksi']; ?></td>
                <td>
                    <a href="index.php?page=edit_hutang_supplier&id_hutang_supplier=<?php echo $data['id_hutang_supplier']; ?>" class="btn btn-primary btn-circle" id_hutang_supplier="<?php echo $data['id_hutang_supplier']; ?>"  data-toggle="tooltip" title="Edit Hutang Supplier" data-placement="top"><i class="fas fa-pencil-alt"></i></a>
                    <button class="btn-hapus btn btn-danger btn-circle" id_hutang_supplier="<?php echo $data['id_hutang_supplier']; ?>"  kode_supplier="<?php echo $data['kode_supplier']; ?>" data-toggle="tooltip" title="Hapus Hutang Supplier" data-placement="top"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <!-- bagian akhir (penutup) while -->
            <?php endwhile; ?>
            
            <tr>
                <td colspan="4">Jumlah</td>
                <td><?php echo $d_nominal; ?></td>
                <td><?php echo $k_nominal; ?></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Bagian header -->
      <div class="modal-header">
        <h4 class="modal-title" id="judul"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Bagian body -->
      <div class="modal-body">
        <div id="tampil_data">
            <!-- Data akan ditampilkan disini menggunakan AJAX -->          
        </div>
      </div>
      <!-- Bagian footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  // untuk tooltip (bootstrap)
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });


  // Tambah penjualan
  $('.btn-tambah').on('click',function(){
    
      $.ajax({
          url: 'page/penjualan/tambah-penjualan.php',
          method: 'post',
          success:function(data){
              $('#tampil_data').html(data);  
              document.getElementById("judul").innerHTML='Tambah penjualan';
          }
      });
      // Membuka modal
      $('#modal').modal('show');
  });



  // Hapus penjualan
  $('.btn-hapus').on('click',function(){

      var id_hutang_supplier = $(this).attr("id_hutang_supplier");
      var kode_supplier = $(this).attr("kode_supplier");

      $.ajax({
          url: 'page/hutang-supplier/hapus-hutang.php',
          method: 'post',
          data: {id_hutang_supplier:id_hutang_supplier,kode_supplier:kode_supplier},
          success:function(data){
              $('#tampil_data').html(data);  
              document.getElementById("judul").innerHTML='Hapus hutang supplier #';
          }
      });
        // Membuka modal
      $('#modal').modal('show');
  });
</script>