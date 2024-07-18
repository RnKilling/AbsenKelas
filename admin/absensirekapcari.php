<h3>Rekap Absensi</h3>
<?php
if (!empty($_GET['idpengguna'])) {
    $idpengguna = $_GET['idpengguna'];
} else {
    $idpengguna = "";
}
?>
<form method="post">
    <div class="row">
        <div class="col-md-9 my-auto">
            <div class="form-group">
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
<br>
<br>
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div id="calendar"></div>
                <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img id="modalImage" src="" alt="" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateModalLabel">Status Absen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="selectedDate">Tanggal</label>
                        <input type="hidden" name="idpengguna" value="<?= $_GET['idpengguna']; ?>" class="form-control" readonly>
                        <input type="date" id="selectedDate" name="tanggal" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="selectedDate">Status</label>
                        <select name="status" id="statusSelect" class="form-control" onchange="handleStatusChange()">
                            <option value="">Pilih Status</option>
                            <option value="Datang">Datang</option>
                            <option value="Tidak Hadir">Tidak Hadir</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Cuti">Cuti</option>
                        </select>
                    </div>
                    <div class="form-group" id="datangFields" style="display: none;">
                        <label for="datetimeDatang">Jam Datang</label>
                        <input type="time" name="absenmasuk" class="form-control">
                    </div>

                    <div class="form-group" id="pulangFields" style="display: none;">
                        <label for="datetimePulang">Jam Pulang</label>
                        <input type="time" name="absenpulang" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="simpan" value="simpan" class="btn btn-primary" onclick="handleDateSelection()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [
                <?php
                $data = mysqli_query($koneksi, "SELECT * FROM absensi JOIN pengguna ON absensi.idpengguna=pengguna.id WHERE idpengguna = '$idpengguna'") or die(mysqli_error($koneksi));
                while ($d = mysqli_fetch_array($data)) {
                    if ($d['status'] == 'Datang') {
                ?> {
                            title: '(Masuk)',
                            start: '<?php echo $d['absenmasuk']; ?>',
                            end: '<?php echo $d['absenmasuk']; ?>',
                            classNames: ['fc-event-image'], // Add class for event images
                            extendedProps: {
                                imageurl: '../foto/<?php echo $d['fotomasuk']; ?>' // Set the image URL
                            }
                        },
                        {
                            title: '(Pulang)',
                            start: '<?php echo $d['absenpulang']; ?>',
                            end: '<?php echo $d['absenpulang']; ?>',
                            classNames: ['fc-event-image'], // Add class for event images
                            extendedProps: {
                                imageurl: '../foto/<?php echo $d['fotopulang']; ?>' // Set the image URL
                            }
                        },
                    <?php } else { ?> {
                            title: '<?= $d['status'] ?>',
                            start: '<?php echo $d['tanggal']; ?>',
                            classNames: ['fc-event-image'], // Add class for event images
                            extendedProps: {
                                imageurl: '../foto/<?php echo $d['fotopulang']; ?>' // Set the image URL
                            }
                        },
                    <?php } ?>
                <?php } ?>
            ],
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            selectOverlap: function(event) {
                return event.rendering === 'background';
            },
            eventClick: function(info) {
                var imageUrl = info.event.extendedProps.imageurl;
                var modalImage = document.getElementById('modalImage');
                modalImage.src = imageUrl;
                var modal = new bootstrap.Modal(document.getElementById('imageModal'));
                modal.show();
            },
            dateClick: function(info) {
                // Open the date modal
                var dateModal = new bootstrap.Modal(document.getElementById('dateModal'));

                // Set the clicked date in the input field
                document.getElementById('selectedDate').value = info.dateStr;

                dateModal.show();
            }
        });

        calendar.render();
    });

    function handleDateSelection() {
        var selectedDate = document.getElementById('selectedDate').value;
        // Do something with the selected date
        console.log("Selected Date:", selectedDate);

        // Close the date modal
        var dateModal = new bootstrap.Modal(document.getElementById('dateModal'));
        dateModal.hide();
    }

    function handleStatusChange() {
        var statusSelect = document.getElementById('statusSelect');
        var datangFields = document.getElementById('datangFields');
        var pulangFields = document.getElementById('pulangFields');

        if (statusSelect.value === 'Datang') {
            datangFields.style.display = 'block';
            pulangFields.style.display = 'block';
        } else {
            datangFields.style.display = 'none';
            pulangFields.style.display = 'none';
        }
    }
</script>
<?php
// 
if (isset($_POST['simpan'])) {
    $idpengguna = $_POST['idpengguna'];
    $hari = $_POST['tanggal'];
    $status = $_POST['status'];
    $cekmasuk = $koneksi->query("SELECT * FROM absensi
    WHERE idpengguna='$idpengguna' and tanggal = '$hari'") or die(mysqli_error($koneksi));
    $hasilcekmasuk = $cekmasuk->num_rows;
    if ($hasilcekmasuk >= 1) {
        if ($status == 'Datang') {
            $absenmasuk = $hari . ' ' . $_POST['absenmasuk'];
            $absenpulang = $hari . ' ' . $_POST['absenpulang'];
            $koneksi->query("UPDATE absensi SET status='$status',absenmasuk='$absenmasuk',absenpulang='$absenpulang',absenmasukstatus='Masuk',absenpulangstatus='Pulang' WHERE idpengguna='$idpengguna' and tanggal = '$hari'") or die(mysqli_error($koneksi)) or die(mysqli_error($koneksi));
        } else {
            $koneksi->query("UPDATE absensi SET status='$status',absenmasuk='',absenpulang='',absenmasukstatus='',absenpulangstatus='' WHERE idpengguna='$idpengguna' and tanggal = '$hari'") or die(mysqli_error($koneksi)) or die(mysqli_error($koneksi));
        }
        echo "<script> alert('Absensi Berhasil Di Simpan');</script>";
        echo "<script>location='index.php?halaman=absensirekapcari&idpengguna=$idpengguna&cari=cari';</script>";
    } else {
        if ($status == 'Datang') {
            $absenmasuk = $hari . ' ' . $_POST['absenmasuk'];
            $absenpulang = $hari . ' ' . $_POST['absenpulang'];
            $koneksi->query("INSERT INTO absensi (idpengguna, tanggal, status, absenmasuk, absenpulang, absenmasukstatus, absenpulangstatus) VALUES ('$idpengguna', '$hari', '$status', '$absenmasuk', '$absenpulang', 'Masuk', 'Pulang')") or die(mysqli_error($koneksi));
        } else {
            $koneksi->query("INSERT INTO absensi (idpengguna, tanggal, status) VALUES ('$idpengguna', '$hari', '$status')") or die(mysqli_error($koneksi));
        }
        echo "<script> alert('Absensi Berhasil Di Simpan');</script>";
        echo "<script>location='index.php?halaman=absensirekapcari&idpengguna=$idpengguna&cari=cari';</script>";
    }
}
?>