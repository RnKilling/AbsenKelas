<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["pegawai"])) {
    echo "<script> alert('Harap login terlebih dahulu');</script>";
    echo "<script> location ='login.php';</script>";
}
$id = $_SESSION["pegawai"]["id"];
?>
<?php
$id = $_SESSION["pegawai"]['id'];
$ambil = $koneksi->query("SELECT *FROM pengguna WHERE id='$id'");
$row = $ambil->fetch_assoc(); ?>
<?php include 'header.php'; ?>
<div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center">
        <h1 class="display-4 text-white animated slideInDown mb-4">Profil</h1>
    </div>
</div>
<!-- Page Header End -->


<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="position-relative overflow-hidden h-100" style="min-height: 400px;">
                    <img src="admin/photo_siswa/<?php echo $row['fotoprofil'] ?>" width="100%" style="border-radius:10px;">
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="h-100">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>NIM
                            </label>
                            <input value="<?php echo $row['nip']; ?>" type="text" class="form-control" name="nip" readonly>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Tingkat</label>
                            <input value="<?php 
$jabatan = $row['jabatan'];
if ($jabatan == 'Pegawai') {
    echo 'I';
} elseif ($jabatan == 'Teknisi') {
    echo 'II';
} elseif ($jabatan == 'HRD') {
    echo 'III';
} else {
    echo '-';
} ?>" type="text" class="form-control jabatan" name="jabatan" readonly>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Nama</label>
                            <input value="<?php echo $row['nama']; ?>" type="text" value="" class="form-control" name="nama" readonly>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Email</label>
                            <input value="<?php echo $row['email']; ?>" type="email" class="form-control" name="email">
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input value="<?php echo $row['telepon']; ?>" type="number" class="form-control" name="telepon">
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" name="password">
                            <input type="hidden" class="form-control" name="passwordlama" value="<?php echo $row['password']; ?>">
                            <span class="text-danger">Kosongkan Password jika tidak ingin mengganti</span>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea value="<?php echo $row['alamat']; ?>" class="form-control" name="alamat" id="alamat" rows="10"><?php echo $row['alamat']; ?></textarea>

                        </div>
                        <br>
                        <div class="form-group">
                            <label>Foto</label>
                            <div class="letak-input" style="margin-bottom: 10px;">
                                <input type="file" class="form-control" name="foto">
                            </div>
                        </div>
                        <button class="btn btn-primary float-end pull-right mb-5" name="ubah"><i class="glyphicon glyphicon-saved"></i>Simpan</a></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['ubah'])) {
    if ($_POST['password'] == "") {
        $password = $_POST['passwordlama'];
    } else {
        $password = $_POST['password'];
    }

    $namafoto = $_FILES['foto']['name'];
    $lokasifoto = $_FILES['foto']['tmp_name'];

    if (!empty($lokasifoto)) {
        move_uploaded_file($lokasifoto, "foto/$namafoto");

        $koneksi->query("UPDATE pengguna SET password='$password',nip='$_POST[nip]',nama='$_POST[nama]',email='$_POST[email]',jabatan='$_POST[jabatan]',fotoprofil='$namafoto', telepon='$_POST[telepon]', alamat='$_POST[alamat]' WHERE id='$id'") or die(mysqli_error($koneksi));
    } else {
        $koneksi->query("UPDATE pengguna SET password='$password',nip='$_POST[nip]',nama='$_POST[nama]', email='$_POST[email]',jabatan='$_POST[jabatan]', telepon='$_POST[telepon]', alamat='$_POST[alamat]' WHERE id='$id'") or die(mysqli_error($koneksi));
    }
    echo "<script>alert('Profil Berhasil Di Ubah');</script>";
    echo "<script>location='profil.php';</script>";
}
include 'footer.php';
?>