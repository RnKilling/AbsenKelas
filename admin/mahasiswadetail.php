<?php
if ($_SESSION['admin']['level'] != "Admin") {
    echo "<script> alert('Anda Tidak Mempunyai Hak Untuk Mengakses Halaman Ini');</script>";
    echo "<script> location ='index.php';</script>";
}
?>
<h3>Detail Mahasiswa</h3>
<br>
<?php
$ambil = $koneksi->query("SELECT * FROM pengguna WHERE id='$_GET[id]'");
$row = $ambil->fetch_assoc();
?>
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td width="15%">
                                    NIM
                                </td>
                                <td width="5px">
                                    :
                                </td>
                                <td>
                                    <?= $row['nip'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="15%">
                                    Nama
                                </td>
                                <td width="5px">
                                    :
                                </td>
                                <td>
                                    <?= $row['nama'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Email
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <?= $row['email'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Tingkat
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <?= $row['jabatan'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Telepon
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <?= $row['telepon'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Alamat
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <?= $row['alamat'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Foto
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <img src="photo_siswa/<?php echo $row['fotoprofil'] ?>" style="border-radius:10%" width="150px">
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
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
        $koneksi->query("UPDATE pengguna SET password='$password',nip='$_POST[nip]',nama='$_POST[nama]',email='$_POST[email]',jabatan='$_POST[jabatan]',fotoprofil='$namafoto', telepon='$_POST[telepon]', alamat='$_POST[alamat]' WHERE id='$_GET[id]'") or die(mysqli_error($koneksi));
    } else {
        $koneksi->query("UPDATE pengguna SET password='$password',nip='$_POST[nip]',nama='$_POST[nama]', email='$_POST[email]',jabatan='$_POST[jabatan]', telepon='$_POST[telepon]', alamat='$_POST[alamat]' WHERE id='$_GET[id]'") or die(mysqli_error($koneksi));
    }
    echo "<script>alert('Data Pegawai Berhasil Di Ubah');</script>";
    echo "<script>location='index.php?halaman=mahasiswadaftar';</script>";
}
?>