<?php
$pegawai = $koneksi->query("SELECT * FROM pengguna where level = 'Pegawai'");
$jumlahpegawai = $pegawai->num_rows;
?>
<div class="row ">
    <div class="col-md-12">
        <center>
            <img src="../foto/welcome.png" width="70%" height="350px">
        </center>
    </div>
</div>
<br>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card border-left-warning warning h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Jumlah Pegawai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlahpegawai ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list fa-2x text-gray-300"></i>
                    </div>
                </div>
                <a href="index.php?halaman=pengguna" class="btn btn-warning mt-3 btn-sm">Lihat Selengkapnya</a>
            </div>
        </div>
    </div>
</div>