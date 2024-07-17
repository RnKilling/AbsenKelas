<?php
if ($_SESSION['admin']['level'] != "Admin") {
    echo "<script> alert('Anda Tidak Mempunyai Hak Untuk Mengakses Halaman Ini');</script>";
    echo "<script> location ='index.php';</script>";
}
if (!empty($_POST['level'])) {
    $level = addslashes($_POST['level']);
} else {
    $level = "";
}
?>
<h3>Tambah Mahasiswa</h3>
<br>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>NIM</label>
        <input type="number" class="form-control" value="<?php if (!empty($_POST['nip'])) echo htmlspecialchars($_POST['nip']); ?>" name="nip">
    </div>
    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" value="<?php if (!empty($_POST['nama'])) echo htmlspecialchars($_POST['nama']); ?>" name="nama">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" value="<?php if (!empty($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>" name="email">
    </div>
    <div class="form-group">
        <label>Tingkat</label>
        <select type="jabatan" class="form-control" name="jabatan">
            <option value="Pegawai">I</option>
            <option value="Teknisi">II</option>
            <option value="HRD">III</option>
        </select>
    </div>
    <div class="form-group">
        <label>Telepon</label>
        <input type="number" class="form-control" value="<?php if (!empty($_POST['telepon'])) echo htmlspecialchars($_POST['telepon']); ?>" name="telepon">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="text" class="form-control" value="<?php if (!empty($_POST['password'])) echo htmlspecialchars($_POST['password']); ?>" name="password">
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <textarea class="form-control" name="alamat" id="alamat" rows="5"><?php if (!empty($_POST['alamat'])) echo htmlspecialchars($_POST['alamat']); ?></textarea>
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
    $password = addslashes($_POST["password"]);
    $email = addslashes($_POST['email']);
    $ambil = $koneksi->query("SELECT * FROM pengguna WHERE email='$email' LIMIT 1") or die(mysqli_error($koneksi));
    $akunyangcocok = $ambil->num_rows;
    if ($akunyangcocok == 1) {
        echo "<script>alert('Email Sudah Terdaftar');</script>";
    } else {
        $namafoto = empty($_FILES['foto']['name']) ? 'Untitled.png' : addslashes($_FILES['foto']['name']);
        $lokasifoto = empty($_FILES['foto']['tmp_name']) ? '' : addslashes($_FILES['foto']['tmp_name']);
        
        if (!empty($lokasifoto)) {
            move_uploaded_file($lokasifoto, "../foto/" . $namafoto);
        }
        
        $nip = addslashes($_POST['nip']);
        $nama = addslashes($_POST['nama']);
        $jabatan = addslashes($_POST['jabatan']);
        $telepon = addslashes($_POST['telepon']);
        $alamat = addslashes($_POST['alamat']);
        
        // Insert into database
        $koneksi->query("INSERT INTO pengguna (nip, nama, email, jabatan, telepon, password, alamat, fotoprofil, level)
            VALUES ('$nip', '$nama', '$email', '$jabatan', '$telepon', '$password', '$alamat', '$namafoto', 'Pegawai')") or die(mysqli_error($koneksi));

        // Generate QR Code
        require('phpqrcode/qrlib.php'); 
        $qrvalue = addslashes($_POST['nip']);
        $text = addslashes($_POST['nip']);     
        $filename = $qrvalue . '.png';

        QRcode::png($text, $filename);
        echo '<img src="' . $filename . '" />';

        // Include library PHP QR Code
        // Directory where QR Code will be saved
        $tempDir = 'QRpegawai.php/';

        // Create QR Code instance
        QRcode::png($nip, $tempDir . $nip . '.png');

        // Menampilkan QR Code yang sudah digenerate
        echo "<h4>QR Code:</h4>";
        echo "<img src='$tempDir$nip.png' alt='QR Code'>";

        echo "<script>alert('Mahasiswa Berhasil Di Simpan');</script>";
        echo "<script>location='index.php?halaman=mahasiswadaftar';</script>";
    }
}
?>
