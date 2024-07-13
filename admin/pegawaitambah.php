<?php
if ($_SESSION['admin']['level'] != "Admin") {
    echo "<script> alert('Anda Tidak Mempunyai Hak Untuk Mengakses Halaman Ini');</script>";
    echo "<script> location ='index.php';</script>";
}
if (!empty($_POST['level'])) {
    $level = $_POST['level'];
} else {
    $level = "";
}
?>
<h3>Tambah Pegawai</h3>
<br>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>NIP</label>
        <input type="number" class="form-control" value="<?php if (!empty($_POST['nip'])) echo $_POST['nip']; ?>" name="nip">
    </div>
    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" value="<?php if (!empty($_POST['nama'])) echo $_POST['nama']; ?>" name="nama">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" value="<?php if (!empty($_POST['email'])) echo $_POST['email']; ?>" name="email">
    </div>
    <div class="form-group">
        <label>Jabatan</label>
        <select type="jabatan" class="form-control" name="jabatan">
            <option value="Pegawai">Pegawai</option>
            <option value="Teknisi">Teknisi</option>
            <option value="HRD">HRD</option>
        </select>
    </div>
    <div class="form-group">
        <label>Telepon</label>
        <input type="number" class="form-control" value="<?php if (!empty($_POST['telepon'])) echo $_POST['telepon']; ?>" name="telepon">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="text" class="form-control" value="<?php if (!empty($_POST['password'])) echo $_POST['password']; ?>" name="password">
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <textarea class="form-control" name="alamat" id="alamat" rows="10"><?php if (!empty($_POST['alamat'])) echo $_POST['alamat']; ?></textarea>
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
    <button class="btn btn-primary" name="save"><i class="glyphicon glyphicon-saved"></i>Simpan</button>
</form>
<br><br>

<?php
if (isset($_POST['save'])) {
    $password = $_POST["password"];
    $ambil = $koneksi->query("SELECT * FROM pengguna WHERE email='$_POST[email]' LIMIT 1") or die(mysqli_error($koneksi));
    $akunyangcocok = $ambil->num_rows;
    if ($akunyangcocok == 1) {
        echo "<script>alert('Email Sudah Terdaftar');</script>";
    } else {
        $namafoto = empty($_FILES['foto']['name']) ? 'Untitled.png' : $_FILES['foto']['name'];
        $lokasifoto = empty($_FILES['foto']['tmp_name']) ? '' : $_FILES['foto']['tmp_name'];
        
        if (!empty($lokasifoto)) {
            move_uploaded_file($lokasifoto, "../foto/" . $namafoto);
        }
        
        $nip = $_POST['nip'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $jabatan = $_POST['jabatan'];
        $telepon = $_POST['telepon'];
        $password = $_POST['password'];
        $alamat = $_POST['alamat'];
        
        // Insert into database
        $koneksi->query("INSERT INTO pengguna (nip, nama, email, jabatan, telepon, password, alamat, fotoprofil, level)
            VALUES ('$nip', '$nama', '$email', '$jabatan', '$telepon', '$password', '$alamat', '$namafoto', 'Pegawai')") or die(mysqli_error($koneksi));

        // Generate QR Code
        require('phpqrcode/qrlib.php'); 
        $qrvalue = $_POST['nip'];


$text = $_POST['nip'];     
$filename = $qrvalue . '.png';

   QRcode::png($text, $filename);
echo '<img src="' . $filename . '" />';

       
 // Include library PHP QR Code

        // Directory where QR Code will be saved
        $tempDir = 'pdfqrcodes/';

        // Create QR Code instance
        QRcode::png($nip, $tempDir . $nip . '.png');

        // Menampilkan QR Code yang sudah digenerate
        echo "<h4>QR Code:</h4>";
        echo "<img src='$tempDir$nip.png' alt='QR Code'>";

        echo "<script>alert('Pegawai Berhasil Di Simpan');</script>";
        echo "<script>location='index.php?halaman=pegawaidaftar';</script>";
    }
}
?>
