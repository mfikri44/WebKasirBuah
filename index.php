<?php 
  session_start();
  if (!$_SESSION["id_pengguna"]){
        header("Location:login.php");
  }
  include 'config/database.php';
  
  $hasil=mysqli_query($kon,"select * from profil_aplikasi order by nama_aplikasi desc limit 1");
  $data = mysqli_fetch_array($hasil); 
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Aplikasi Kasir (Point of Sale)</title>

  <!-- Custom fonts for this template -->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="assets/font/font.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Chart.js -->
  <script src="assets/plugin/chartjs/chart.js"></script>
  <!-- Custom styles for this page -->
  <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <script src="assets/js/jquery/jquery-3.4.1.js"></script>

<!-- Plugin Datepicker -->
<script src="assets/plugin/datepicker/js/bootstrap-datepicker.js"></script>
  <link rel="stylesheet" href="assets/plugin/datepicker/css/datepicker.css">


</head>

<body>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
          <img src="page/aplikasi/logo/<?php echo $data['logo']; ?>" width="50px" alt="brand"/>
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo $data['nama_aplikasi'];?></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.php?page=dashboard">
        <i class="fas fa-home"></i>
          <span>Dashboard</span></a>
      </li>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transaksi" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-shopping-cart"></i>
          <span>Transaksi</span>
        </a>
        <div id="transaksi" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php if ($_SESSION["level"]=="Kasir"): ?>
            <a class="collapse-item" href="index.php?page=input_penjualan">Input Penjualan</a>
            <!-- <a class="collapse-item" href="index.php?page=input_hutang">Input Hutang Penjualan</a> -->
            <?php endif; ?>
            <a class="collapse-item" href="index.php?page=data_penjualan">Data Penjualan</a>
            <!-- <a class="collapse-item" href="index.php?page=data_penjualan_hutang">Data Hutang Penjualan</a> -->
            <!-- <a class="collapse-item" href="index.php?page=data_akun_kredit">Data Akun Kredit</a> -->
          </div>
        </div>
      </li>
      <?php if ($_SESSION["level"]=="Admin" || $_SESSION["level"]=="Manajer"): ?>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporan" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-book"></i>
          <span>Laporan Penjualan</span>
        </a>
        <div id="laporan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="index.php?page=laporan&isi=item">Berdasarkan Item</a>
            <a class="collapse-item" href="index.php?page=laporan&isi=produk">Berdasarkan Produk</a>
            <a class="collapse-item" href="index.php?page=laporan&isi=kasir">Berdasarkan Kasir</a>
          </div>
        </div>
      </li>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#hutang" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-address-book"></i>
          <span>Hutang Supplier</span>
        </a>
        <div id="hutang" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="index.php?page=data_hutang_supplier">Data Hutang</a>
            <a class="collapse-item" href="index.php?page=input_hutang_supplier">Input Hutang</a>
          </div>
        </div>
      </li>
      <?php endif; ?>

      <?php if ($_SESSION["level"]=="Admin"): ?>
      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pengguna" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-users"></i>
          <span>Pengguna</span>
        </a>
        <div id="pengguna" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="index.php?page=pengguna&pengguna=Admin">Admin</a>
            <a class="collapse-item" href="index.php?page=pengguna&pengguna=Kasir">Kasir</a>
            <!-- <a class="collapse-item" href="index.php?page=pengguna&pengguna=Manajer">Manajer</a> -->
          </div>
        </div>
      </li>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#master_data" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-database"></i>
          <span>Master Data</span>
        </a>
        <div id="master_data" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="index.php?page=produk">Produk</a>
            <a class="collapse-item" href="index.php?page=kategori_produk">Kategori Produk</a>
            <a class="collapse-item" href="index.php?page=pelanggan">Pelanggan</a>
            <a class="collapse-item" href="index.php?page=supplier">Supplier</a>
          </div>
        </div>
      </li>

      <?php endif; ?>

      <?php if ($_SESSION["level"]=="Admin"): ?>
            <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pengaturan" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Pengaturan</span>
        </a>
        <div id="pengaturan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">        
            <a class="collapse-item" href="index.php?page=aplikasi">Aplikasi</a>
       
          </div>
        </div>
      </li>
      <?php endif; ?>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form action="page/pencarian/index.php" method="get" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Masukan kata kunci" aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-dark" type="submit">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>


   
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <?php
              include 'config/database.php';
              $id_pengguna=$_SESSION["id_pengguna"];
              $hasil=mysqli_query($kon,"select nama_pengguna,foto from pengguna where id_pengguna=$id_pengguna");
              $row = mysqli_fetch_array($hasil); 
            ?>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $row["nama_pengguna"]; ?></span>
                <img class="img-profile rounded-circle" src="page/pengguna/foto/<?php echo $row["foto"]; ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="index.php?page=profil">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profil
                </a>
      
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <?php 
          if(isset($_GET['page'])){
            $page = $_GET['page'];
        
            switch ($page) {
              case 'dashboard':
                include "page/dashboard/index.php";
                break;
              case 'produk':
                include "page/produk/index.php";
                break;
              case 'kategori_produk':
                include "page/produk/kategori/index.php";
                break;
              case 'pelanggan':
                include "page/pelanggan/index.php";
                break;
              case 'supplier':
                include "page/supplier/index.php";
                break;
              case 'pengguna':
                include "page/pengguna/index.php";
                break;
              case 'data_penjualan':
                include "page/penjualan/index.php";
                break;
              case 'input_penjualan':
                include "page/penjualan/input-penjualan.php";
                break;
              case 'detail_penjualan':
                include "page/penjualan/detail-penjualan.php";
                break;
              case 'input_hutang':
                include "page/hutang/input-hutang.php";
                break;
              case 'edit_hutang':
                include "page/hutang/edit-hutang.php";
                break;
              case 'data_penjualan_hutang':
                include "page/hutang/index.php";
                break;
              case 'detail_penjualan_hutang':
                include "page/hutang/detail-penjualan.php";
                break;
              case 'rincian_hutang':
                include "page/hutang/detail-angsuran.php";
                break;
              case 'data_akun_kredit':
                include "page/hutang/akun-kredit.php";
                break;
              case 'data_penjualan_kredit':
                include "page/hutang/data-penjualan-kredit.php";
                break;
              case 'data_hutang_supplier':
                include "page/hutang-supplier/index.php";
                break;
              case 'input_hutang_supplier':
                include "page/hutang-supplier/input-hutang.php";
                break;
              case 'edit_hutang_supplier':
                include "page/hutang-supplier/edit-hutang.php";
                break;
              case 'laporan':
                include "page/laporan/index.php";
              break;
              case 'profil':
                include "page/profil/index.php";
                break;
              case 'aplikasi':
                include "page/aplikasi/index.php";
                break;
              default:
                echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
                break;
            }
          }
      ?>
        <!-- /.container-fluid -->
        
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php 
        include 'config/database.php';
        $hasil=mysqli_query($kon,"select * from profil_aplikasi order by nama_aplikasi desc limit 1");
        $data = mysqli_fetch_array($hasil); 
      ?>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; <?php echo $data['nama_aplikasi'];?> <?php echo date('Y');?> </span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Keluar Aplikasi</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Apakah anda yakin ingin keluar?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="assets/js/demo/datatables-demo.js"></script>

    <!-- Plugin select2 -->
  <link href="assets/plugin/select2/select2.min.css" rel="stylesheet" />
  <script src="assets/plugin/select2/select2.min.js"></script>



</body>

</html>
