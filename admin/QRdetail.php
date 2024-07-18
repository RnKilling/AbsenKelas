<!-- QRdetail.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail QR Code</title>
    <style>
        body {
            text-align: center;
            margin-top: 100px;
        }
        .qr-code {
            max-width: 250%; /* Atur lebar maksimum gambar sesuai kebutuhan */
            height: auto; /* Biarkan tinggi otomatis untuk menjaga proporsi */
        }
    </style>
</head>
<body>
    <?php
    // Pastikan NIP diterima dari parameter GET
    if (isset($_GET['nip'])) {
        $nip = $_GET['nip'];
        $qr_path = 'QRpegawai.php/' . $nip . '.png'; // Path QR Code

        // Periksa apakah QR Code ada
        if (file_exists($qr_path)) {
            echo '<img src="' . $qr_path . '" alt="QR Code" class="qr-code"><br><br>';
            echo '<a href="' . $qr_path . '" download="qr_code_' . $nip . '.png" class="btn btn-primary">Simpan QR Code</a>';
        } else {
            echo '<p>QR Code tidak tersedia untuk NIP ini.</p>';
        }
    } else {
        echo '<p>NIP tidak ditemukan.</p>';
    }
    ?>
</body>
</html>
