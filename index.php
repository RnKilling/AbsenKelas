<?php
session_start();
include 'koneksi.php';
?>

<?php include 'header.php'; ?>

<div class="container-fluid p-0 mb-5">
	<div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img class="w-100" src="assets_home/home/img/bg.jpg" alt="Image">
				<div class="carousel-caption">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-lg-7 pt-5">
								<h1 class="display-4 text-white mb-3 animated slideInDown">Sistem Absensi Kelas</h1>
								<?php
								include 'koneksi.php';
								if (!isset($_SESSION["pegawai"])) { ?>
									<a class="btn btn-primary py-2 px-3 animated slideInDown" href="login.php">
										Login
										<div class="d-inline-flex btn-sm-square bg-white text-primary rounded-circle ms-2">
											<i class="fa fa-arrow-right"></i>
										</div>
									</a>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="carousel-item">
				<img class="w-100" src="assets_home/home/img/bg.jpg" alt="Image">
				<div class="carousel-caption">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-lg-7 pt-5">
								<h1 class="display-4 text-white mb-3 animated slideInDown">Politeknik Gajah Tunggal</h1>
								<?php
								include 'koneksi.php';
								if (!isset($_SESSION["pegawai"])) { ?>
									<a class="btn btn-primary py-2 px-3 animated slideInDown" href="login.php">
										Login
										<div class="d-inline-flex btn-sm-square bg-white text-primary rounded-circle ms-2">
											<i class="fa fa-arrow-right"></i>
										</div>
									</a>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>
</div>
<?php
// $lokasianda_lat = $_SESSION['user_latitude'];
// $lokasianda_lng = $_SESSION['user_longitude'];
// echo $lokasianda_lat;
// echo '<br><br>';
// echo $lokasianda_lng;
?>
<?php
if (isset($_SESSION["pegawai"])) {
?>
	<div class="container-xxl py-5">
		<div class="container">
			<div class="row g-5">
				<div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
					<div class="h-100">
						<h2>Absensi Hari Ini<br><span class="text-success"><?= tanggal(date('Y-m-d')) ?></span></h2>
						<br>
						<b class="text-danger">
							<div id="clock"></div>
						</b>
						<br>
						<div class="row">
							<div class="col-md-6">
								<?php
								$idpengguna = $_SESSION["pegawai"]["id"];
								$hari = date('Y-m-d');
								$cekmasuk = $koneksi->query("SELECT * FROM absensi
									WHERE idpengguna='$idpengguna' and date(absenmasuk) = '$hari' and absenmasukstatus='Masuk'") or die(mysqli_error($koneksi));
								$hasilcekmasuk = $cekmasuk->num_rows;
								if ($hasilcekmasuk >= 1) {
								?>
									<img src="Masuk.png" width="100%">
									<h3 class="text-center text-success mt-3">Sudah Absen</h3>
								<?php } else { ?>
									<a href="#" data-bs-toggle="modal" data-bs-target="#masuk">
										<img src="Masuk.png" width="100%">
										<h3 class="text-center mt-3">Absen Masuk</h3>
									</a>
								<?php } ?>
								<div class="modal fade" id="masuk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" style="z-index: 99999;">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Absen Masuk</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<form method="post" action="simpanabsen.php" enctype="multipart/form-data">
												<div class="modal-body">
													<div class="form-group">
														<div style="width:100%" id="qr-reader"></div>
														<br>
														<input name="foto" id="foto-input" type="text" required hidden>
														<input name="fotoImage" id="foto-image-input" type="hidden">
														<input name="masuk" value="masuk" type="hidden" required>
													</div>
												</div>
												<div class="modal-footer">
													<button id="start-scanner" type="button" class="btn btn-success" style="background-color: limegreen">Scan QR</button>
													<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<?php
								$idpengguna = $_SESSION["pegawai"]["id"];
								$hari = date('Y-m-d');
								$cekpulang = $koneksi->query("SELECT * FROM absensi
									WHERE idpengguna='$idpengguna' and date(absenpulang) = '$hari' and absenpulangstatus='Pulang'") or die(mysqli_error($koneksi));
								$hasilcekpulang = $cekpulang->num_rows;
								if ($hasilcekpulang >= 1) {
								?>
									<img src="Keluar.png" width="100%">
									<h3 class="text-center text-success mt-3">Sudah Absen</h3>
								<?php } else { ?>
									<a href="#" data-bs-toggle="modal" data-bs-target="#pulang">
										<img src="Keluar.png" width="100%">
										<h3 class="text-center mt-3">Absen Pulang</h3>
									</a>
								<?php } ?>
								<div class="modal fade" id="pulang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" style="z-index: 99999;">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Absen Pulang</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<form method="post" action="simpanabsen.php" id="form2" enctype="multipart/form-data">
												<div class="modal-body">
													<div class="form-group">
														<div style="width:100%" id="qr-reader2"></div>
														<br>
														<input name="foto" id="foto-input2" type="text" required hidden>
														<input name="fotoImage" id="foto-image-input2" type="hidden">
														<input name="pulang" value="pulang" type="hidden" required>
													</div>
												</div>
												<div class="modal-footer">
													<button id="start-scanner2" type="button" class="btn btn-success" style="background-color: limegreen">Scan QR</button>
													<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } else { ?>
	<div class="container-xxl py-5">
		<div class="container">
			<div class="row g-5">
				<div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
					<div class="h-100">
						<h2>Sudahkan anda absen hari ini ?</h2>
						<br>
						<b class="text-danger">
							<div id="clock"></div>
						</b>
						<br>
						<a class="btn btn-primary" href="login.php">Login Sekarang Untuk Absensi</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php
include 'footer.php';
?>
<?php

?>
<script>
	function updateTime() {
		var now = new Date();
		var hours = now.getHours();
		var minutes = now.getMinutes();
		var seconds = now.getSeconds();
		hours = hours < 10 ? "0" + hours : hours;
		minutes = minutes < 10 ? "0" + minutes : minutes;
		seconds = seconds < 10 ? "0" + seconds : seconds;
		var timeString = hours + ":" + minutes + ":" + seconds;
		document.getElementById("clock").innerHTML = 'Waktu : ' + timeString;
	}
	setInterval(updateTime, 1000);
</script>
<script>
	// Get access to the camera stream
	navigator.mediaDevices.getUserMedia({
			video: true
		})
		.then(function(stream) {
			var video = document.getElementById('camera-stream');
			video.srcObject = stream;
			video.play();
		})
		.catch(function(error) {
			console.log('Error accessing camera:', error);
		});

	// Capture button click event
	document.getElementById('capture-btn').addEventListener('click', function() {
		var video = document.getElementById('camera-stream');
		var canvas = document.createElement('canvas');
		canvas.width = video.videoWidth;
		canvas.height = video.videoHeight;
		canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
		var dataURL = canvas.toDataURL('image/jpeg');
		document.getElementById('foto-input').value = dataURL;
	});
</script>
<script>
	// Get access to the camera stream
	navigator.mediaDevices.getUserMedia({
			video: true
		})
		.then(function(stream) {
			var video = document.getElementById('camera-stream2');
			video.srcObject = stream;
			video.play();
		})
		.catch(function(error) {
			console.log('Error accessing camera:', error);
		});

	// Capture button click event
	document.getElementById('capture-btn2').addEventListener('click', function() {
		var video = document.getElementById('camera-stream2');
		var canvas = document.createElement('canvas');
		canvas.width = video.videoWidth;
		canvas.height = video.videoHeight;
		canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
		var dataURL = canvas.toDataURL('image/jpeg');
		document.getElementById('foto-input2').value = dataURL;
	});
</script>
<!-- qr -->
<script>
	document.getElementById('start-scanner').addEventListener('click', function() {
		const qrReaderContainer = document.getElementById('qr-reader');
		qrReaderContainer.innerHTML = ''; // Clear any existing content in the container

		// Initialize the QR code reader
		const html5QrCode = new Html5Qrcode("qr-reader");

		// Function to capture a photo from the video stream
		function capturePhoto(videoElement) {
			const canvas = document.createElement('canvas');
			canvas.width = videoElement.videoWidth;
			canvas.height = videoElement.videoHeight;
			const context = canvas.getContext('2d');
			context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
			return canvas.toDataURL('image/jpeg');
		}

		// Start the camera for scanning
		html5QrCode.start({
				facingMode: "environment"
			}, // Use the back camera
			{
				fps: 10, // Set the frame per second for the scanning
				qrbox: {
					width: 250,
					height: 250
				} // Set scanning box width and height
			},
			qrCodeMessage => {
				// Handle the result of the scan
				document.getElementById('foto-input').value = qrCodeMessage;

				// Capture photo from the video stream
				const videoElement = document.querySelector('#qr-reader video');
				const photoDataUrl = capturePhoto(videoElement);
				document.getElementById('foto-image-input').value = photoDataUrl;

				// Automatically submit the form once the QR code is detected
				document.querySelector('form').submit(); // Stop the scanner once we have a result
				html5QrCode.stop().then(() => {
					console.log("Scanning stopped.");
				}).catch(err => {
					console.error("Unable to stop scanning.", err);
				});
			},
			errorMessage => {
				// Handle errors during scanning
				console.error("QR Code no match.", errorMessage);
			}
		).catch(err => {
			// Handle errors during camera start
			console.error("Unable to start scanning.", err);
		});
	});
</script>
<script>
	document.getElementById('start-scanner2').addEventListener('click', function() {
		const qrReaderContainer = document.getElementById('qr-reader2');
		qrReaderContainer.innerHTML = ''; // Clear any existing content in the container

		// Initialize the QR code reader
		const html5QrCode2 = new Html5Qrcode("qr-reader2");

		// Function to capture a photo from the video stream
		function capturePhoto2(videoElement) {
			const canvas = document.createElement('canvas'); // Corrected: Use createElement('canvas')
			canvas.width = videoElement.videoWidth;
			canvas.height = videoElement.videoHeight;
			const context = canvas.getContext('2d');
			context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
			return canvas.toDataURL('image/jpeg');
		}

		// Start the camera for scanning
		html5QrCode2.start({
				facingMode: "environment"
			}, // Use the back camera
			{
				fps: 10, // Set the frame per second for the scanning
				qrbox: {
					width: 250,
					height: 250
				} // Set scanning box width and height
			},
			qrCodeMessage => {
				// Handle the result of the scan
				document.getElementById('foto-input2').value = qrCodeMessage;

				// Capture photo from the video stream
				const videoElement = document.querySelector('#qr-reader2 video');
				const photoDataUrl = capturePhoto2(videoElement); // Corrected: Call capturePhoto2
				document.getElementById('foto-image-input2').value = photoDataUrl;

				// Automatically submit the form once the QR code is detected
				document.getElementById('form2').submit();
				// Stop the scanner once we have a result
				html5QrCode2.stop().then(() => {
					console.log("Scanning stopped.");
				}).catch(err => {
					console.error("Unable to stop scanning.", err);
				});
			},
			errorMessage => {
				// Handle errors during scanning
				console.error("QR Code no match.", errorMessage);
			}
		).catch(err => {
			// Handle errors during camera start
			console.error("Unable to start scanning.", err);
		});
	});
</script>