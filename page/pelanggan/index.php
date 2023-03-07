<div class="container-fluid">
<!--Bagian heading -->
<h1 class="h3 mb-2 text-gray-800">Pelanggan</h1>
<p class="mb-4">Halaman pelanggan berisi informasi seluruh pelanggan yang dapat di kelolah oleh admin.</p>
<?php
    //Validasi untuk menampilkan pesan pemberitahuan saat user menambah pelanggan
    if (isset($_GET['add'])) {
        if ($_GET['add']=='berhasil'){
            echo"<div class='alert alert-success'><strong>Berhasil!</strong> Pelanggan telah ditambah!</div>";
        }else if ($_GET['add']=='gagal'){
            echo"<div class='alert alert-danger'><strong>Gagal!</strong> Pelanggan gagal ditambahkan!</div>";
        }    
    }

    //Validasi untuk menampilkan pesan pemberitahuan saat user mengubah pelanggan
    if (isset($_GET['edit'])) {
      if ($_GET['edit']=='berhasil'){
          echo"<div class='alert alert-success'><strong>Berhasil!</strong> Pelanggan telah diupdate!</div>";
      }else if ($_GET['edit']=='gagal'){
          echo"<div class='alert alert-danger'><strong>Gagal!</strong> Pelanggan gagal diupdate!</div>";
      }    
    }

    //Validasi untuk menampilkan pesan pemberitahuan saat user mengubah pelanggan
    if (isset($_GET['hapus'])) {
      if ($_GET['hapus']=='berhasil'){
          echo"<div class='alert alert-success'><strong>Berhasil!</strong> Pelanggan telah dihapus!</div>";
      }else if ($_GET['hapus']=='gagal'){
          echo"<div class='alert alert-danger'><strong>Gagal!</strong> Pelanggan gagal dihapus!</div>";
      }    
    }
?>
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <!-- Tombol tambah pelanggan -->
      <button class="btn-tambah btn btn-dark btn-icon-split"><span class="text">Tambah</span></button>
    </div>
    <div class="card-body">
      <!-- Tabel daftar pelanggan -->
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>pelanggan</th>
              <th>Telp</th>
              <th>Alamat</th>
              <th>Jenis Kelamin</th>
              <th>Tanggal Lahir</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
              <?php
                  // include database
                  include 'config/database.php';
                  // perintah sql untuk menampilkan daftar pelanggan
                  $sql="select * from pelanggan order by id_pelanggan desc";
                  $hasil=mysqli_query($kon,$sql);
                  $no=0;
                  //Menampilkan data dengan perulangan while
                  while ($data = mysqli_fetch_array($hasil)):
                  $no++;
              ?>
              <tr>
                  <td><?php echo $no; ?></td>
                  <td><?php echo $data['kode_pelanggan']; ?></td>
                  <td><?php echo $data['nama_pelanggan']; ?></td>
                  <td><?php echo $data['no_telp']; ?></td>
                  <td><?php echo $data['alamat_pelanggan']; ?></td>
                  <td><?php echo $data['jenis_kelamin'] == 1 ? 'Laki-laki' : 'Perempuan';?></td>
                  <td><?php echo date('d/m/Y', strtotime($data["tanggal_lahir"])); ?></td>
                  <td><?php echo $data['status'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?></td>
                  <td>
                      <button class="btn-edit btn btn-warning btn-circle" id_pelanggan="<?php echo $data['id_pelanggan']; ?>" kode_pelanggan="<?php echo $data['kode_pelanggan']; ?>" data-toggle="tooltip" title="Edit pelanggan" data-placement="top"><i class="fas fa-edit"></i></button>
                      <button class="btn-hapus btn btn-danger btn-circle"  id_pelanggan="<?php echo $data['id_pelanggan']; ?>" kode_pelanggan="<?php echo $data['kode_pelanggan']; ?>" data-toggle="tooltip" title="Hapus pelanggan" data-placement="top"><i class="fas fa-trash"></i></button>
                  </td>
              </tr>
              <!-- bagian akhir (penutup) while -->
              <?php endwhile; ?>
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
        <!-- Data akan ditampilkan disini dengan AJAX -->          
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


  // Tambah pelanggan
  $('.btn-tambah').on('click',function(){
    
      $.ajax({
          url: 'page/pelanggan/tambah-pelanggan.php',
          method: 'post',
          success:function(data){
              $('#tampil_data').html(data);  
              document.getElementById("judul").innerHTML='Tambah pelanggan';
          }
      });
      // Membuka modal
      $('#modal').modal('show');
  });


  // Edit pelanggan
  $('.btn-edit').on('click',function(){

      var id_pelanggan = $(this).attr("id_pelanggan");
      var kode_pelanggan = $(this).attr("kode_pelanggan");
      $.ajax({
          url: 'page/pelanggan/edit-pelanggan.php',
          method: 'post',
          data: {id_pelanggan:id_pelanggan},
          success:function(data){
              $('#tampil_data').html(data);  
              document.getElementById("judul").innerHTML='Edit pelanggan #'+kode_pelanggan;
          }
      });
        // Membuka modal
      $('#modal').modal('show');
  });


  // Hapus pelanggan
  $('.btn-hapus').on('click',function(){

      var id_pelanggan = $(this).attr("id_pelanggan");
      var kode_pelanggan = $(this).attr("kode_pelanggan");
      $.ajax({
          url: 'page/pelanggan/hapus-pelanggan.php',
          method: 'post',
          data: {id_pelanggan:id_pelanggan,kode_pelanggan:kode_pelanggan},
          success:function(data){
              $('#tampil_data').html(data);  
              document.getElementById("judul").innerHTML='Hapus pelanggan #'+kode_pelanggan;
          }
      });
        // Membuka modal
      $('#modal').modal('show');
  });
</script>