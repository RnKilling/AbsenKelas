<?php
session_start();
include '../koneksi.php';
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Anda Harus Login');</script>";
    echo "<script>location='login.php';</script>";
    header('location:login.php');
    exit();
}
$id = $_SESSION["admin"]['id'];
function rupiah($angka)
{
    $hasilrupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasilrupiah;
}
function tanggal($tgl)
{
    $tanggal = substr($tgl, 8, 2);
    $bulan = getBulan(substr($tgl, 5, 2));
    $tahun = substr($tgl, 0, 4);
    return $tanggal . ' ' . $bulan . ' ' . $tahun;
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
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/x-icon" href="../foto/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - E - Absensi Kelurahan Sekip Kecamatan Medan Petisah</title>
    <link href="assets/css/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="assets/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <script src="assets/ckeditor/ckeditor.js"></script>
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.css' rel='stylesheet' />
</head>

<body id="page-top">
    <div id="wrapper">
        <?php
        if ($_SESSION['admin']['level'] == "Admin") {
            $warna = "bg-gradient-warning";
            $tulisan = "Administrator";
        }
        ?>
        <ul class="navbar-nav <?= $warna ?> sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3 mt-3">E-Absensi</sup></div>
            </a>
            <br>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link collapsed text-white" href="index.php?halaman=beranda" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-tachometer-alt text-white"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link collapsed text-white" href="#" data-toggle="collapse" data-target="#pegawai" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-users text-white"></i>
                    <span>Pegawai</span>
                </a>
                <div id="pegawai" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="index.php?halaman=pegawaitambah">Tambah Pegawai</a>
                        <a class="collapse-item" href="index.php?halaman=mahasiswadaftar">Daftar Pegawai</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link collapsed text-white" href="index.php?halaman=absensirekap">
                    <i class="fa fa-fw fa-book text-white"></i>
                    <span>Rekap Absensi</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link collapsed text-white" href="index.php?halaman=laporan">
                    <i class="fa fa-fw fa-list text-white"></i>
                    <span>Laporan</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link collapsed text-white" href="index.php?halaman=QRpegawai">
                    <i class="fa fa-fw fa-list text-white"></i>
                    <span>QR Pegawai</span></a>
            </li>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['admin']['nama'] ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="index.php?halaman=profiledit">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Profil
                                </a>
                                <a class="dropdown-item" onclick="return confirm('Apakah Anda Yakin Ingin Keluar ?');" href="index.php?halaman=logout">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Keluar
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">
                    <div id="page-inner">
                        <?php
                        if (isset($_GET['halaman'])) {
                            if ($_GET['halaman'] == "beranda") {
                                include 'beranda.php';
                            } elseif ($_GET['halaman'] == "mahasiswadaftar") {
                                include 'mahasiswadaftar.php';
                            } elseif ($_GET['halaman'] == "pegawaitambah") {
                                include 'pegawaitambah.php';
                            } elseif ($_GET['halaman'] == "pegawaiedit") {
                                include 'pegawaiedit.php';
                            } elseif ($_GET['halaman'] == "pegawaidetail") {
                                include 'pegawaidetail.php';
                            } elseif ($_GET['halaman'] == "pegawaihapus") {
                                include 'pegawaihapus.php';
                            } elseif ($_GET['halaman'] == "logout") {
                                include 'logout.php';
                            } elseif ($_GET['halaman'] == "absensirekap") {
                                include 'absensirekap.php';
                            } elseif ($_GET['halaman'] == "absensirekapcari") {
                                include 'absensirekapcari.php';
                            } elseif ($_GET['halaman'] == "profiledit") {
                                include 'profiledit.php';
                            } elseif ($_GET['halaman'] == "laporan") {
                                include 'laporan.php';
                            }
                        } else {
                            include 'beranda.php';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="assets/js/sb-admin-2.min.js"></script>
<script src="assets/vendor/chart.js/Chart.min.js"></script>
<script src="assets/js/demo/chart-area-demo.js"></script>
<script src="assets/js/demo/chart-pie-demo.js"></script>
<script src="assets/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="assets/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/DataTables/JSZip-2.5.0/jszip.min.js"></script>
<script src="assets/DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="assets/DataTables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="assets/DataTables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
<script src="assets/DataTables/Buttons-1.5.6/js/buttons.print.min.js"></script>
<script src="assets/DataTables/Buttons-1.5.6/js/buttons.colvis.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#table').DataTable({
            buttons: ['csv', 'print', 'excel', 'pdf'],
            dom: "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-5'i><'col-md-7'p>>",
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "ALL"]
            ]
        });

        table.buttons().container()
            .appendTo('#table_wrapper .col-md-5:eq(0)');
    });
</script>

</html>