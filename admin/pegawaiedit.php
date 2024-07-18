<?php
if ($_SESSION['admin']['level'] != "Admin") {
    echo "<script> alert('Anda Tidak Mempunyai Hak Untuk Mengakses Halaman Ini');</script>";
    echo "<script> location ='index.php';</script>";
}
?>
<h3>Edit Mahasiswa</h3>
<br>
<?php
$id = addslashes($_GET['id']);
$ambil = $koneksi->query("SELECT * FROM pengguna WHERE id='$id'");
$row = $ambil->fetch_assoc();
?>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>NIM</label>
        <input value="<?php echo htmlspecialchars($row['nip']); ?>" type="number" class="form-control" name="nip">
    </div>
    <div class="form-group">
        <label>Nama</label>
        <input value="<?php echo htmlspecialchars($row['nama']); ?>" type="text" class="form-control" name="nama">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input value="<?php echo htmlspecialchars($row['email']); ?>" type="email" class="form-control" name="email">
    </div>
    <div class="form-group">
        <label>Tingkat</label>
        <select type="jabatan" class="form-control" name="jabatan">
            <option <?php if ($row['jabatan'] == 'Pegawai') echo 'selected'; ?> value="Pegawai">Mahasiswa</option>
            <option <?php if ($row['jabatan'] == 'Teknisi') echo 'selected'; ?> value="Teknisi">Mahasiswa</option>
            <option <?php if ($row['jabatan'] == 'HRD') echo 'selected'; ?> value="HRD">dosen pengampu</option>
        </select>
    </div>
    <div class="form-group">
        <label>Telepon</label>
        <input value="<?php echo htmlspecialchars($row['telepon']); ?>" type="number" class="form-control" name="telepon">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="text" class="form-control" name="password">
        <span class="text-danger">Kosongkan Password jika tidak ingin mengganti</span>
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <textarea class="form-control" name="alamat" id="alamat" rows="10"><?php echo htmlspecialchars($row['alamat']); ?></textarea>
        <script>
            CKEDITOR.replace('alamat');
        </script>
    </div>
    <div class="form-group">
        <label>Foto</label>
        <div class="letak-input" style="margin-bottom: 10px;">
            <input type="file" class="form-control" name="foto">
        </div>
    </div>
    <button class="btn btn-primary" name="ubah"><i class="glyphicon glyphicon-saved"></i>Simpan</a></button>
</form>
<br><br>
<?php

if (isset($_POST['ubah'])) {
    $nip = addslashes($_POST['nip']);
    $nama = addslashes($_POST['nama']);
    $email = addslashes($_POST['email']);
    $jabatan = addslashes($_POST['jabatan']);
    $telepon = addslashes($_POST['telepon']);
    $alamat = addslashes($_POST['alamat']);
    
    if ($_POST['password'] == "") {
        $password = $row['password'];
    } else {
        $password = addslashes($_POST['password']);
    }

    $namafoto = $_FILES['foto']['name'];
    $lokasifoto = $_FILES['foto']['tmp_name'];
    
    if (!empty($lokasifoto)) {
        move_uploaded_file($lokasifoto, "../foto/$namafoto");
        $koneksi->query("UPDATE pengguna SET password='$password', nip='$nip', nama='$nama', email='$email', jabatan='$jabatan', fotoprofil='$namafoto', telepon='$telepon', alamat='$alamat' WHERE id='$id'") or die(mysqli_error($koneksi));
    } else {
        $koneksi->query("UPDATE pengguna SET password='$password', nip='$nip', nama='$nama', email='$email', jabatan='$jabatan', telepon='$telepon', alamat='$alamat' WHERE id='$id'") or die(mysqli_error($koneksi));
    }
    echo "<script>alert('Data Pegawai Berhasil Di Ubah');</script>";
    echo "<script>location='index.php?halaman=mahasiswadaftar';</script>";
}
?>
