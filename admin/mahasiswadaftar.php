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
                                <th>Level</th>
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
                                    <td><?php echo $row['level'] ?></td>
                                    <td>
                                        <img src="../foto/<?php echo $row['fotoprofil'] ?>" style="border-radius:10%" width="150px">
                                    </td>
                                    <td>
                                        <img src="QRpegawai.php/<?php echo $row['nip']; ?>.png" width="100px"> <!-- Tampilkan QR Code -->
                                    </td>
                                    <td>
                                        <a href="index.php?halaman=mahasiswadetail&id=<?php echo $row['id']; ?>" class="btn btn-info m-1">Detail</a>
                                        <a href="index.php?halaman=pegawaiedit&id=<?php echo $row['id']; ?>" class="btn btn-warning m-1">Ubah</a>
                                        <a onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?');" href="index.php?halaman=pegawaihapus&id=<?php echo $row['id'] ?>" class="btn btn-danger m-1">Hapus</a>
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
