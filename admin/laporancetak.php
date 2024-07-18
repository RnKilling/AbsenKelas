<html>
<title>Laporan Absensi - POLTEK GT</title>
<link rel="icon" type="image/x-icon" href="Poltek_GT.png">
<style type="text/css">
    body {
        -webkit-print-color-adjust: exact;
        padding: 50px;
    }

    #table {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #table td,
    #table th {
        border: 1px solid black;
    }

    #table tr:hover {
        background-color: #ddd;
    }

    #table th {
        text-align: left;
        background-color: #b30404;
        color: white;
    }

    @page {
        size: auto;
        margin: 0;
    }

    hr {
        display: block;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
        margin-left: auto;
        margin-right: auto;
        border-style: inset;
        border-width: 1px;
    }
</style>
<?php
include('../koneksi.php');
$idpegawai = $_GET['pegawai'];
$tahun = $_GET['tahun'];
$bulan = $_GET['bulan'];
function tanggal($tgl)
{
    $tanggal = substr($tgl, 8, 2);
    $bulan = bulan(substr($tgl, 5, 2));
    $tahun = substr($tgl, 0, 4);
    return $tanggal . ' ' . $bulan . ' ' . $tahun;
}
function bulan($bln)
{
    switch ($bln) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}
?>

<body>
    <table>
        <tr>
            <td align="left" style="align-items: left!important;">
                <img src="Poltek_GT.png" width="100px">
            </td>
            <td style="padding-left: 25px;">
                <font size="4"><b>ABSENSI KELAS</b></font>
                <br>
                <span>POLITEKNIK GAJAH TUNGGAL,TANGERANG,BANTEN, INDONESIA</span>
            </td>
        </tr>
    </table>
    <br>
    <center>
        -------------------------------------------------------------------------------------------------------------------------------
        <h2>
            LAPORAN ABSENSI
            <br>
            <?= $tahun ?>
            <?php
            if ($bulan != "") {
                echo bulan($bulan);
            }
            ?>
        </h2>
    </center>
    <br>
    <table class="table table-bordered table-striped" id="table" width="670px">
        <thead class="bg-info">
            <tr>
                <th scope="col" width="50px">No</th>
                <th scope="col">NIM</th>
                <th scope="col">Mahasiswa</th>
                <th scope="col">Absen Masuk</th>
                <th scope="col">Absen Keluar</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = 1;
            if ($bulan != "") {
                $ambil = $koneksi->query("SELECT * FROM absensi JOIN pengguna ON absensi.idpengguna=pengguna.id WHERE idpengguna = '$idpegawai' and year(tanggal) = '$tahun' and month(tanggal) = '$bulan' order by tanggal desc");
            } else {
                $ambil = $koneksi->query("SELECT * FROM absensi JOIN pengguna ON absensi.idpengguna=pengguna.id WHERE idpengguna = '$idpegawai' and year(tanggal) = '$tahun' order by tanggal desc");
            }
            while ($row = $ambil->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $row['nip'] ?></td>
                    <td><?php echo $row['nama'] ?></td>
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
    <br><br>
    <table cellspacing='0' cellpadding='0' style='width:670px; font-size:11pt; font-family:calibri; border-collapse: collapse;'>
        <tr>
            <td align="center" style="padding-left:450px">
                <?= tanggal(date('Y-m-d')) ?>
                <br><br><br><br><br>
                MAHASISWA
                <br>
                POLITEKNIK GAJAH TUNGGAL
            </td>
        </tr>
    </table>
</body>
<script>
    window.print();
</script>

</html>