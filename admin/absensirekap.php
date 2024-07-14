<h3>Rekap Absensi</h3>
<?php
if (!empty($_POST['idpengguna'])) {
    $idpengguna = $_POST['idpengguna'];
} else {
    $idpengguna = "";
}
?>
<form method="get">
    <div class="row">
        <div class="col-md-9 my-auto">
            <div class="form-group">
                <input type="hidden" name="halaman" value="absensirekapcari">
                <select name="idpengguna" class="form-control" required>
                    <option value="">Pilih Mahasiswa</option>
                    <?php
                    $ambilpegawai = $koneksi->query("SELECT * FROM pengguna where level='Pegawai'");
                    while ($pegawai = $ambilpegawai->fetch_assoc()) { ?>
                        <option <?php if ($idpengguna == $pegawai['id']) echo 'selected'; ?> value="<?= $pegawai['id'] ?>"><?= $pegawai['nama'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <button type="submit" name="cari" value="cari" class="btn btn-primary btn-block">Cari</button>
            </div>
        </div>
    </div>
</form>