<h3>Data Laporan</h3>
<?php
if (!empty($_POST['idpengguna'])) {
	$idpegawai = $_POST['idpengguna'];
	$tahun = $_POST['tahun'];
	$bulan = $_POST['bulan'];
} else {
	$idpegawai = "";
	$tahun = date('Y');
	$bulan = "";
}
?>
<br>
<br>
<div class="row">
	<div class="col-md-12 mb-4">
		<div class="card shadow mb-4">
			<div class="card-body">
				<form method="post">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Pilih Mahasiswa</label>
								<select name="idpengguna" class="form-control" required>
									<option value="">Pilih Mahasiswa</option>
									<?php
									$ambilpegawai = $koneksi->query("SELECT * FROM pengguna where level='pegawai'");
									while ($pegawai = $ambilpegawai->fetch_assoc()) { ?>
										<option <?php if ($idpegawai == $pegawai['id']) echo 'selected'; ?> value="<?= $pegawai['id'] ?>"><?= $pegawai['nama'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Tahun</label>
								<select class="form-control" name="tahun" required>
									<?php
									$nomor = 1;
									$tahunawal = 2017;
									$tahunakhir = date('Y');
									while ($tahunakhir >= $tahunawal) {
									?>
										<option value="<?= $tahunakhir ?>"><?= $tahunakhir ?></option>
									<?php
										$tahunakhir = $tahunakhir - 1;
									} ?>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Bulan</label>
								<select name="bulan" class="form-control" id="">
									<option value="">Pilih Bulan</option>
									<option <?php if ($bulan == '01') echo 'selected'; ?> value="01">Januari</option>
									<option <?php if ($bulan == '02') echo 'selected'; ?> value="02">Februari</option>
									<option <?php if ($bulan == '03') echo 'selected'; ?> value="03">Maret</option>
									<option <?php if ($bulan == '04') echo 'selected'; ?> value="04">April</option>
									<option <?php if ($bulan == '05') echo 'selected'; ?> value="05">Mei</option>
									<option <?php if ($bulan == '06') echo 'selected'; ?> value="06">Juni</option>
									<option <?php if ($bulan == '07') echo 'selected'; ?> value="07">Juli</option>
									<option <?php if ($bulan == '08') echo 'selected'; ?> value="08">Agustus</option>
									<option <?php if ($bulan == '09') echo 'selected'; ?> value="09">September</option>
									<option <?php if ($bulan == '10') echo 'selected'; ?> value="10">Oktober</option>
									<option <?php if ($bulan == '11') echo 'selected'; ?> value="11">November</option>
									<option <?php if ($bulan == '12') echo 'selected'; ?> value="12">Desember</option>
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<button type="submit" name="cari" value="cari" class="btn btn-primary btn-block" style="margin-top: 32px;">Cari</button>
							</div>
						</div>
						<?php
						if (!empty($_POST['idpengguna'])) { ?>
							<div class="col-md-2">
								<a target="_blank" href="laporancetak.php?pegawai=<?= $idpegawai ?>&tahun=<?= $tahun ?>&bulan=<?= $bulan ?>" class="btn btn-success btn-block" style="margin-top: 32px;">Cetak</a>
							</div>
						<?php } ?>
					</div>
				</form>
				<br>
				<br>
				<?php
				if (!empty($_POST['idpengguna'])) {
					$idpengguna = $_POST['idpengguna'];
				?>
					<div class="table-responsive">
						<table class="table table-bordered" id="table">
							<thead>
								<tr>
									<th scope="col" width="50px">No</th>
									<th scope="col">NIM</th>
									<th scope="col">Nama Pegawai</th>
									<th scope="col">Absen Masuk</th>
									<th scope="col">Absen Keluar</th>
									<th scope="col">Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$nomor = 1;
								if ($bulan != "") {
									$ambil = $koneksi->query("SELECT * FROM absensi JOIN pengguna ON absensi.idpengguna=pengguna.id WHERE idpengguna = '$idpengguna' and year(tanggal) = '$tahun' and month(tanggal) = '$bulan' order by tanggal desc");
								} else {
									$ambil = $koneksi->query("SELECT * FROM absensi JOIN pengguna ON absensi.idpengguna=pengguna.id WHERE idpengguna = '$idpengguna' and year(tanggal) = '$tahun' order by tanggal desc");
								}
								while ($row = $ambil->fetch_assoc()) { ?>
									<tr>
										<td><?php echo $nomor; ?></td>
										<td><?php echo $row['nama'] ?></td>
										<td><?php echo $row['nip'] ?></td>
										<td>
											<?php
											if ($row['absenmasuk'] != "") {
												echo tanggal(date("Y-m-d", strtotime($row['absenmasuk']))) . ' ' . date("H:i", strtotime($row['absenmasuk']));
											} else {
												echo '<span class="text-danger">Belum Absen</span>';
											}
											?>
										</td>
										<td>
											<?php
											if ($row['absenpulang'] != "") {
												echo tanggal(date("Y-m-d", strtotime($row['absenpulang']))) . ' ' . date("H:i", strtotime($row['absenpulang']));
											} else {
												echo '<span class="text-danger">Belum Absen</span>';
											}
											?>
										</td>
										<td><?php echo $row['status'] ?></td>
									</tr>
								<?php
									$nomor = $nomor + 1;
								}
								?>
							</tbody>
						</table>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>