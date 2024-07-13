<?php
$koneksi->query("DELETE FROM pengguna WHERE id='$_GET[id]'");
echo "<script>alert('Data Berhasil Di Hapus');</script>";
echo "<script>location='index.php?halaman=pegawaidaftar';</script>";
