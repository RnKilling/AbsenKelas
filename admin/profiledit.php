<h3>Edit Profil</h3>
<br>
<?php
$id = $_SESSION['admin']['id'];
$ambil = $koneksi->query("SELECT * FROM pengguna WHERE id='$id'");
$row = $ambil->fetch_assoc();
?>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>NIM</label>
        <input value="<?php echo $row['nip']; ?>" type="number" value="" class="form-control" name="nip" readonly>
    </div>
    <div class="form-group">
        <label>Nama</label>
        <input value="<?php echo $row['nama']; ?>" type="text" value="" class="form-control" name="nama">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input value="<?php echo $row['email']; ?>" type="email" class="form-control" name="email">
    </div>
    <div class="form-group">
        <label>Jabatan</label>
        <!-- <select type="jabatan" class="form-control" name="jabatan">
            <option <?php if ($row['jabatan'] == 'Pegawai') echo 'selected'; ?> value="Pegawai">Pegawai</option>
            <option <?php if ($row['jabatan'] == 'HRD') echo 'selected'; ?> value="HRD">HRD</option>
        </select> -->
        <input value="<?php echo $row['jabatan']; ?>" type="text" class="form-control jabatan" name="jabatan" readonly>
    </div>
    <div class="form-group">
        <label>Telepon</label>
        <input value="<?php echo $row['telepon']; ?>" type="text" class="form-control" name="telepon">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="text" class="form-control" name="password">
        <span class="text-danger">Kosongkan Password jika tidak ingin mengganti</span>
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <textarea value="<?php echo $row['alamat']; ?>" class="form-control" name="alamat" id="alamat" rows="10">
        <?php echo $row['alamat']; ?>
        </textarea>
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
    if ($_POST['password'] == "") {
        $password = $row['password'];
    } else {
        $password = $_POST['password'];
    }
    $namafoto = $_FILES['foto']['name'];
    $lokasifoto = $_FILES['foto']['tmp_name'];
    if (!empty($lokasifoto)) {
        move_uploaded_file($lokasifoto, "../foto/$namafoto");
        $koneksi->query("UPDATE pengguna SET password='$password',nip='$_POST[nip]',nama='$_POST[nama]',email='$_POST[email]',jabatan='$_POST[jabatan]',fotoprofil='$namafoto', telepon='$_POST[telepon]', alamat='$_POST[alamat]' WHERE id='$id'") or die(mysqli_error($koneksi));
    } else {
        $koneksi->query("UPDATE pengguna SET password='$password',nip='$_POST[nip]',nama='$_POST[nama]', email='$_POST[email]',jabatan='$_POST[jabatan]', telepon='$_POST[telepon]', alamat='$_POST[alamat]' WHERE id='$id'") or die(mysqli_error($koneksi));
    }
    echo "<script>alert('Data Profil Akun anda berhasil di ubah');</script>";
    echo "<script>location='index.php?halaman=profiledit';</script>";
}
?>