<?php
session_start();
include 'koneksi.php';
?>

<?php include 'header.php'; ?>

<div class="container-fluid p-0 mb-5">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="Poltek_GT.png" alt="Image">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7 pt-5">
                                <h1 class="display-4 text-white mb-3 animated slideInDown">Sistem Absensi Kelas Dengan QR Code</h1>
                                <?php
                                if (!isset($_SESSION["pegawai"])) { ?>
                                    <a class="btn btn-primary py-2 px-3 animated slideInDown" href="login.php">
                                        Login
                                        <div class="d-inline-flex btn-sm-square bg-white text-primary rounded-circle ms-2">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="Poltek_GT.png" alt="Image">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7 pt-5">
                                <h1 class="display-4 text-white mb-3 animated slideInDown">Absensi Kelas</h1>
                                <?php
                                if (!isset($_SESSION["pegawai"])) { ?>
                                    <a class="btn btn-primary py-2 px-3 animated slideInDown" href="login.php">
                                        Login
                                        <div class="d-inline-flex btn-sm-square bg-white text-primary rounded-circle ms-2">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<?php
if (isset($_SESSION["pegawai"])) {
?>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="h-100">
                        <h2>Absensi Hari Ini<br><span class="text-success"><?= tanggal(date('Y-m-d')) ?></span></h2>
                        <br>
                        <b class="text-danger">
                            <div id="clock"></div>
                        </b>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $idpengguna = $_SESSION["pegawai"]["id"];
                                $hari = date('Y-m-d');
                                $cekmasuk = $koneksi->query("SELECT * FROM absensi
                                    WHERE idpengguna='$idpengguna' and date(absenmasuk) = '$hari' and absenmasukstatus='Masuk'") or die(mysqli_error($koneksi));
                                $hasilcekmasuk = $cekmasuk->num_rows;
                                if ($hasilcekmasuk >= 1) {
                                ?>
                                    <img src="foto/masuk.webp" width="100%">
                                    <h3 class="text-center text-success mt-3">Sudah Absen</h3>
                                <?php } else { ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#masuk">
                                        <img src="Masuk.png" width="100%">
                                        <h3 class="text-center mt-3">Absensi Masuk</h3>
                                    </a>
                                <?php } ?>
                                <div class="modal fade" id="masuk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" style="z-index: 99999;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Absensi Masuk</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="simpanabsen.php" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div style="width:100%" id="qr-reader"></div>
                                                        <br>
                                                        <input name="foto" id="foto-input" type="text" required hidden>
                                                        <input name="fotoImage" id="foto-image-input" type="hidden">
                                                        <input name="masuk" value="masuk" type="hidden" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button id="start-scanner" type="button" class="btn btn-success" style="background-color: limegreen">Scan QR</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $idpengguna = $_SESSION["pegawai"]["id"];
                                $hari = date('Y-m-d');
                                $cekpulang = $koneksi->query("SELECT * FROM absensi
                                    WHERE idpengguna='$idpengguna' and date(absenpulang) = '$hari' and absenpulangstatus='Pulang'") or die(mysqli_error($koneksi));
                                $hasilcekpulang = $cekpulang->num_rows;
                                if ($hasilcekpulang >= 1) {
                                ?>
                                    <img src="foto/keluar.jpg" width="100%">
                                    <h3 class="text-center text-success mt-3">Sudah Absen</h3>
                                <?php } else { ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#pulang">
                                        <img src="Keluar.png" width="100%">
                                        <h3 class="text-center mt-3">Absen Pulang</h3>
                                    </a>
                                <?php } ?>
                                <div class="modal fade" id="pulang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" style="z-index: 99999;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Absen Pulang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="simpanabsen.php" id="form2" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div style="width:100%" id="qr-reader2"></div>
                                                        <br>
                                                        <input name="foto" id="foto-input2" type="text" required hidden>
                                                        <input name="fotoImage" id="foto-image-input2" type="hidden">
                                                        <input name="pulang" value="pulang" type="hidden" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button id="start-scanner2" type="button" class="btn btn-success" style="background-color: limegreen">Scan QR</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="h-100">
                        <h2>Sudahkan anda absen hari ini ?</h2>
                        <br>
                        <b class="text-danger">
                            <div id="clock"></div>
                        </b>
                        <br>
                        <a class="btn btn-primary py-2 px-3 animated slideInDown" href="login.php">
                            Login Untuk Absen
                            <div class="d-inline-flex btn-sm-square bg-white text-primary rounded-circle ms-2">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const qrReader = new Html5Qrcode("qr-reader");
    const qrReader2 = new Html5Qrcode("qr-reader2");

    document.getElementById('start-scanner').addEventListener('click', () => {
        qrReader.start({ facingMode: "environment" }, { fps: 10, qrbox: 250 },
            qrCodeMessage => {
                document.getElementById('foto-input').value = qrCodeMessage;
                qrReader.stop();
                alert("QR Code berhasil dipindai!");
            },
            errorMessage => {
                console.warn(`QR Code scanning error: ${errorMessage}`);
            }
        ).catch(err => {
            console.error(`Unable to start scanning, error: ${err}`);
        });
    });

    document.getElementById('start-scanner2').addEventListener('click', () => {
        qrReader2.start({ facingMode: "environment" }, { fps: 10, qrbox: 250 },
            qrCodeMessage => {
                document.getElementById('foto-input2').value = qrCodeMessage;
                qrReader2.stop();
                alert("QR Code berhasil dipindai!");
            },
            errorMessage => {
                console.warn(`QR Code scanning error: ${errorMessage}`);
            }
        ).catch(err => {
            console.error(`Unable to start scanning, error: ${err}`);
        });
    });
});
</script>

<?php include 'footer.php'; ?>
