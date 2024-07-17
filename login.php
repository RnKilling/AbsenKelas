<?php
session_start();
include 'koneksi.php';

?>
<?php include 'header.php'; ?>
<div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
	<div class="container text-center">
		<h1 class="display-4 text-white animated slideInDown mb-4">Login</h1>
	</div>
</div>
<!-- Page Header End -->


<!-- About Start -->
<div class="container-xxl py-5">
	<div class="container">
		<div class="row g-5">
			<div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
				<div class="h-100">
					<form method="post">
						<div class="form-group mb-3">
							<label class="mb-1">Email</label>
							<input type="text" name="email" class="form-control">
						</div>
						<div class="form-group">
							<label class="mb-1">Password</label>
							<input type="password" class="form-control" name="password">
						</div>
						<br>
						<button class="btn btn-primary w-100" name="simpan">Masuk</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
if (isset($_POST["simpan"])) {
	$email = $_POST["email"];
	$password = $_POST["password"];
	$ambil = $koneksi->query("SELECT * FROM pengguna
		WHERE email='$email' AND password='$password' limit 1");
	$akunyangcocok = $ambil->num_rows;
	if ($akunyangcocok == 1) {
		$akun = $ambil->fetch_assoc();
		if ($akun['level'] == "Pegawai") {
			$_SESSION["pegawai"] = $akun;
			echo "<script> alert('Anda sukses login');</script>";
			echo "<script> location ='index.php';</script>";
		} elseif ($akun['level'] == "Admin") {
			$_SESSION['admin'] = $akun;
			echo "<script> alert('Anda sukses login');</script>";
			echo "<script> location ='admin/index.php';</script>";
		}
	} else {
		echo "<script> alert('Password atau email anda salah!');</script>";
	}
}
?>
<?php
include 'footer.php';
?>
