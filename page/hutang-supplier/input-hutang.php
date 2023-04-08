<div class="container-fluid">
<!--Bagian heading -->
<h1 class="h3 mb-2 text-gray-800">Input Hutang Supplier</h1>

<?php
    include 'config/database.php';

?>

 <!--form -->
 <form action="page/hutang-supplier/simpan-hutang-supplier.php" method="post">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
          <div class="row">
              <div class="col-sm-6">
              </div>
              <div class="col-sm-6">
                <h5 style="text-align:right">Tanggal : <?php echo date("d/m/Y");?></h5>
              </div>
        
          </div>
      </div>

    <?php
    //Validasi untuk menampilkan pesan pemberitahuan saat user menambah penjualan
    if (isset($_GET['add'])) {
        if ($_GET['add']=='berhasil'){
            echo"<div class='alert alert-success'>Input Berhasil</div>";
        }else if ($_GET['add']=='gagal'){
            echo"<div class='alert alert-danger'><strong>Gagal!</strong> Input gagal! Silahkan cek kembali kolom yang perlu diisi!</div>";
        }    
    }

    ?>
      <div class="card-body">
          <!-- rows -->
            <div class="row">
              <div class="col-sm-12">
                  <!-- Overflow Hidden -->
                  <div class="card mb-4">
                      <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Tambah Hutang Supplier</h5>
                      </div>
                      <div class="card-body">
                        <!-- rows -->
                          <div class="row">
                              <div class="col-sm-12">
                                  <div class="form-group">
                                    <button type="button" data-toggle="modal" data-target="#modal" class="btn btn-primary"><span class="text"><i class="fas fa-shopping-bag fa-sm"></i> Pilih Supplier</span></button>
                                  </div>
                              </div>
                            </div>
                          <!-- rows -->
                          <div class="row">
                              <div class="col-sm-12">
                                <div id="tampil_deskripsi_supplier">
                                </div>
                                  <input type="hidden" name="id_admin" value="<?php echo $_SESSION["id_pengguna"]; ?>" id="id_admin" />
                                  <div class="form-group">
                                        <label>Kode Supplier:</label>
                                        <input name="kode_supplier" id="kode_supplier" type="text" class="form-control" readonly>
                                  </div>
                                  <div class="form-group">
                                        <label>Nama Supplier:</label>
                                        <input name="nama_supplier" id="nama_supplier" type="text" class="form-control" readonly>
                                  </div>
                                  <div class="form-group">
                                        <label>Tanggal Nota :</label>
                                        <input name="tanggal_nota" type="date" class="form-control">
                                  </div>
                                  <div class="form-group">
                                        <label>Jenis Transaksi :</label>
                                        <select name="jenis_transaksi" id="jenis_transaksi" class="form-control">
                                          <option selected="true" disabled="disabled">Pilih Transaksi</option>
                                          <option value="Debit">Debit</option>
                                          <option value="Kredit">Kredit</option>
                                        </select>
                                  </div>
                                  <div class="form-group">
                                        <label>Nominal :</label>
                                        <input name="nominal" id="nominal" type="number" class="form-control">
                                  </div>
                                  <div class="form-group">
                                        <button type="submit" name="buat_hutang_supplier" id="buat_hutang_supplier" aksi="buat_hutang_supplier" disabled class="btn btn-primary btn-block"><span class="text"><i class="fas fa-shopping-cart fa-sm"></i> Submit Hutang Supplier</span></button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        <!-- rows -->
        </div>
    </div>
   <!--form -->
  </form>
</div>


<!-- Modal -->
<div class="modal fade" id="modal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- Bagian header -->
      <div class="modal-header">
        <h4 class="modal-title" id="judul"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Bagian body -->
      <div class="modal-body">
        <!-- Tabel daftar supplier -->
        <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Supplier</th>
                    <th>Telpon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                        // include database
                        include 'config/database.php';
                        // perintah sql untuk menampilkan daftar supplier yang berelasi dengan tabel kategori supplier
                        $sql="select * from supplier where status = 1 order by kode_supplier asc";
                        $hasil=mysqli_query($kon,$sql);
                        $no=0;
                        //Menampilkan data dengan perulangan while
                        while ($data = mysqli_fetch_array($hasil)):
                        $no++;
                    ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $data['kode_supplier']; ?></td>
                        <td><?php echo $data['nama_supplier']; ?></td>
                        <td><?php echo $data['no_telp']; ?></td>
                        <td><?php echo $data['alamat_supplier']; ?></td>
                        <td>
                        <button type="button" class="btn-pilih-supplier btn btn-primary btn-block" kode_supplier="<?php echo $data['kode_supplier']; ?>" data-dismiss="modal" ><span class="text"><i class="fas fa-paper-plane fa-sm"></i> Pilih</span></button>
                        </td>
                    </tr>
                    <!-- bagian akhir (penutup) while -->
                    <?php endwhile; ?>
                </tbody>
              </table>
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
  //Event saat pengguna memilih supplier yang ingin dibeli
  $('.btn-pilih-supplier').on('click',function(){
      var kode_supplier = $(this).attr("kode_supplier");
      $.ajax({
          url: 'page/hutang-supplier/ambil-supplier.php',
          method: 'post',
          data: {kode_supplier:kode_supplier},
          success:function(data){
              $('#tampil_deskripsi_supplier').html(data);
          }
      }); 
  });

  //Event saat pengguna memasukan jumlah Nominal
  $("#nominal").bind('keyup', function () {
      var nominal = $('#nominal').val();

      if (nominal!=0){
          document.getElementById("buat_hutang_supplier").disabled = false;
      }else {
          document.getElementById("buat_hutang_supplier").disabled = true;
      }      
  });
  
</script>