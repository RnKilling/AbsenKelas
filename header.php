<?php
include 'koneksi.php';
function rupiah($angka)
{
  $hasilrupiah = "Rp " . number_format($angka, 2, ',', '.');
  return $hasilrupiah;
}
function tanggal($tgl)
{
  if ($tgl != "") {
    $tanggal = substr($tgl, 8, 2);
    $bulan = getBulan(substr($tgl, 5, 2));
    $tahun = substr($tgl, 0, 4);
    return $tanggal . ' ' . $bulan . ' ' . $tahun;
  } else {
    return "";
  }
}
function getBulan($bln)
{
  switch ($bln) {
    case 1:
      return "Januari";
      break;
    case 2:
      return "Februari";
      break;
    case 3:
      return "Maret";
      break;
    case 4:
      return "April";
      break;
    case 5:
      return "Mei";
      break;
    case 6:
      return "Juni";
      break;
    case 7:
      return "Juli";
      break;
    case 8:
      return "Agustus";
      break;
    case 9:
      return "September";
      break;
    case 10:
      return "Oktober";
      break;
    case 11:
      return "November";
      break;
    case 12:
      return "Desember";
      break;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>E - Absensi Kelas Politeknik Gajah Tunggal</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="foto/logo.png">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Saira:wght@500;600;700&display=swap" rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries Stylesheet -->
  <link href="assets_home/home/lib/animate/animate.min.css" rel="stylesheet">
  <link href="assets_home/home/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Customized Bootstrap Stylesheet -->
  <link href="assets_home/home/css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Stylesheet -->
  <link href="assets_home/home/css/style.css" rel="stylesheet">
  <script src="admin/assets/ckeditor/ckeditor.js"></script>
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.css' rel='stylesheet' />
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

  <!-- maps -->
</head>

<body>


  <!-- Navbar Start -->
  <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="top-bar text-white-50 gx-0 align-items-center d-none d-lg-flex">
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
      <a href="index.php" class="navbar-brand ms-4 ms-lg-0">
        <h1 class="fw-bold text-primary m-0"><img src="Poltek_GT.png" style="border-radius:10px;width:100px"><span class="text-white" style="padding-left:25px;">E - Absensi</span></h1>
      </a>
      <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
          <a href="index.php" class="nav-item nav-link">Home</a>
          <?php
          include 'koneksi.php';
          if (isset($_SESSION["pegawai"])) : ?>
            <?php
            $id = $_SESSION["pegawai"]['id'];
            $ambil = $koneksi->query("SELECT *FROM pengguna WHERE id='$id'");
            $row = $ambil->fetch_assoc(); ?>
            <a href="riwayatabsensi.php" class="nav-item nav-link">Riwayat Absensi</a>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Akun</a>
              <div class="dropdown-menu m-0">
                <a href="profil.php" class="dropdown-item">Profil</a>
                <a href="logout.php" onclick="return confirm('Apakah Anda Yakin Ingin Keluar ?');" class="dropdown-item">Keluar</a>
              </div>
            </div>
          <?php endif ?>
          <?php if (!isset($_SESSION["pegawai"])) : ?>
            <a href="login.php" class="nav-item nav-link">Login</a>
          <?php endif ?>
        </div>
      </div>
    </nav>
  </div>