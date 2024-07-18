<?php
include 'koneksi.php';
session_start();
if (isset($_POST['masuk'])) {
    $fotoqr = $_POST['foto'];
    $idpengguna = $_SESSION["pegawai"]["id"];
    $absenmasuk = date('Y-m-d H:i:s');
    $tanggal = date('Y-m-d');
    $absenmasukstatus = "Masuk";
    // $fotomasuk = $_FILES['foto']['name'];
    // $lokasifoto = $_FILES['foto']['tmp_name'];
    // move_uploaded_file($lokasifoto, "foto/" . $fotomasuk);
    // base64
    $base64Image = $_POST['fotoImage'];
    // echo $base64Image;
    // die();

    // Remove the data URL scheme (e.g., "data:image/jpeg;base64,")
    $base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);

    // Decode the base64 image data
    $imageData = base64_decode($base64Image);

    // Generate a unique filename for the image
    $filename = uniqid() . '.jpg';

    // Specify the path to save the image
    $filepath = 'admin/fotomasuk/' . $filename;

    // Save the image file
    file_put_contents($filepath, $imageData);

    $fotomasuk = $filename;
    // Insert the filename into the database
    // 
    $hari = date('Y-m-d');
    $cekpulang = $koneksi->query("SELECT * FROM absensi
    WHERE idpengguna='$idpengguna' and date(absenpulang) = '$hari'") or die(mysqli_error($koneksi));
    $hasilcekpulang = $cekpulang->num_rows;
    if ($hasilcekpulang >= 1) {
        $koneksi->query("UPDATE absensi SET absenmasuk='$absenmasuk',absenmasukstatus='$absenmasukstatus',fotomasuk='$fotomasuk' WHERE idpengguna='$idpengguna' and date(absenpulang) = '$hari'") or die(mysqli_error($koneksi)) or die(mysqli_error($koneksi));
        echo "<script> alert('Absensi Masuk Berhasil Di Simpan');</script>";
        echo "<script>location='index.php';</script>";
    } else {
        $koneksi->query("INSERT INTO absensi
		(idpengguna,absenmasuk,absenmasukstatus,fotomasuk,status,tanggal)
		VALUES('$idpengguna','$absenmasuk','$absenmasukstatus','$fotomasuk','Datang','$tanggal')") or die(mysqli_error($koneksi));
        echo "<script> alert('Absensi Masuk Berhasil Di Simpan');</script>";
        echo "<script>location='index.php';</script>";
    }
}
if (isset($_POST['pulang'])) {
    $fotoqr = $_POST['foto'];
    $idpengguna = $_SESSION["pegawai"]["id"];
    $absenpulang = date('Y-m-d H:i:s');
    $tanggal = date('Y-m-d');
    $absenpulangstatus = "Pulang";
    // $fotopulang = $_FILES['foto']['name'];
    // $lokasifoto = $_FILES['foto']['tmp_name'];
    // move_uploaded_file($lokasifoto, "foto/" . $fotopulang);
    $base64Image = $_POST['fotoImage'];

    // Remove the data URL scheme (e.g., "data:image/jpeg;base64,")
    $base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);

    // Decode the base64 image data
    $imageData = base64_decode($base64Image);

    // Generate a unique filename for the image
    $filename = uniqid() . '.jpg';

    // Specify the path to save the image
    $filepath = 'admin/fotopulang/' . $filename;

    // Save the image file
    file_put_contents($filepath, $imageData);

    $fotopulang = $filename;
    // Insert the filename into the database
    // 

    $hari = date('Y-m-d');
    $cekmasuk = $koneksi->query("SELECT * FROM absensi
    WHERE idpengguna='$idpengguna' and date(absenmasuk) = '$hari'") or die(mysqli_error($koneksi));
    $hasilcekmasuk = $cekmasuk->num_rows;
    if ($hasilcekmasuk >= 1) {
        $koneksi->query("UPDATE absensi SET absenpulang='$absenpulang',absenpulangstatus='$absenpulangstatus',fotopulang='$fotopulang' WHERE idpengguna='$idpengguna' and date(absenmasuk) = '$hari'") or die(mysqli_error($koneksi)) or die(mysqli_error($koneksi));
        echo "<script> alert('Absensi Pulang Berhasil Di Simpan');</script>";
        echo "<script>location='index.php';</script>";
    } else {
        $koneksi->query("INSERT INTO absensi
		(idpengguna,absenpulang,absenpulangstatus,fotopulang,status,tanggal)
		VALUES('$idpengguna','$absenpulang','$absenpulangstatus','$fotopulang','Datang','$tanggal')") or die(mysqli_error($koneksi));
        echo "<script> alert('Absensi Pulang Berhasil Di Simpan');</script>";
        echo "<script>location='index.php';</script>";
    }
}
