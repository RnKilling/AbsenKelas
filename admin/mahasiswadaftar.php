<h3>Data Mahasiswa</h3>
<a href="index.php?halaman=mahasiswatambah" class="btn btn-primary">Tambah Mahasiswa</a>
<br>
<br>
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Tingkat</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Foto</th>
                                <th>QR Code</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1; ?>
                            <?php $ambil = $koneksi->query("SELECT * FROM pengguna where level='Pegawai'"); ?>
                            <?php while ($row = $ambil->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td><?php echo $row['nama'] ?></td>
                                    <td><?php echo $row['nip'] ?></td>
                                    <td>
                                        <?php
                                        $jabatan = $row['jabatan'];
                                        if ($jabatan == 'Pegawai') {
                                            echo 'I';
                                        } elseif ($jabatan == 'Teknisi') {
                                            echo 'II';
                                        } elseif ($jabatan == 'HRD') {
                                            echo 'III';
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $row['email'] ?></td>
                                    <td><?php echo $row['telepon'] ?></td>
                                    <td>
                                     <?php
                                      $foto = "photo_siswa/" . $row['nip'] . ".png"; // Path foto berdasarkan NIP
                                      if (file_exists($foto)) {
                                    echo '<img src="' . $foto . '" style="border-radius:10%; max-width: 150px;" width="100%">';
                                        } else {
                                    echo 'Foto tidak tersedia';
                                     }
                                     ?>
                                    </td>

                                    <td>
                                    <a href="QRdetail.php?nip=<?php echo $row['nip']; ?>" target="_blank">
                                        <img src="QRpegawai.php/<?php echo $row['nip']; ?>.png" style="max-width: 100px;" width="100%">

                                    </td>
                                    <td>
                                        <a href="index.php?halaman=mahasiswadetail&id=<?php echo $row['id']; ?>" class="btn btn-info m-1">Detail</a>
                                        <a href="index.php?halaman=mahasiswaedit&id=<?php echo $row['id']; ?>" class="btn btn-warning m-1">Edit</a>
                                        <a onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?');" href="index.php?halaman=mahasiswahapus&id=<?php echo $row['id'] ?>" class="btn btn-danger m-1">Hapus</a>
                                    </td>
                                </tr>
                                <?php $nomor++; ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['upload'])) {
    $id = $_POST['id'];
    $nip = $koneksi->real_escape_string($_POST['nip']);

    $foto = "photo_siswa/" . $nip . ".png"; // Path foto berdasarkan NIP
    if (file_exists($foto)) {
        $koneksi->query("UPDATE pengguna SET fotoprofil='$nip.jpg' WHERE id='$id'") or die(mysqli_error($koneksi));
        echo "<script>alert('Foto berhasil diupdate');</script>";
        echo "<script>location='index.php';</script>";
        exit; // tambahkan exit untuk menghentikan eksekusi script setelah redirect
    } else {
        echo "<script>alert('Foto tidak ditemukan untuk diupdate');</script>";
    }
}

?>
