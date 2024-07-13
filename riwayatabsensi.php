<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["pegawai"])) {
    echo "<script> alert('Harap login terlebih dahulu');</script>";
    echo "<script> location ='login.php';</script>";
}
?>
<?php include 'header.php'; ?>
<style>
    .fc-event-image {
        cursor: pointer;
    }
</style>
<div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center">
        <h1 class="display-4 text-white animated slideInDown mb-4">Riwayat Absensi</h1>
    </div>
</div>
<!-- Page Header End -->


<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
                <div class="h-100">
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
</div>
<?php
include 'footer.php';
?>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [
                <?php
                $idpengguna = $_SESSION["pegawai"]["id"];
                $data = mysqli_query($koneksi, "SELECT * FROM absensi JOIN pengguna ON absensi.idpengguna=pengguna.id WHERE idpengguna = '$idpengguna'") or die(mysqli_error($koneksi));
                while ($d = mysqli_fetch_array($data)) {
                    if ($d['status'] == 'Datang') {
                ?> {
                            title: '(Masuk)',
                            start: '<?php echo $d['absenmasuk']; ?>',
                            end: '<?php echo $d['absenmasuk']; ?>',
                            classNames: ['fc-event-image'], // Add class for event images
                            extendedProps: {
                                imageurl: 'foto/<?php echo $d['fotomasuk']; ?>' // Set the image URL
                            }
                        },
                        {
                            title: '(Pulang)',
                            start: '<?php echo $d['absenpulang']; ?>',
                            end: '<?php echo $d['absenpulang']; ?>',
                            classNames: ['fc-event-image'], // Add class for event images
                            extendedProps: {
                                imageurl: 'foto/<?php echo $d['fotopulang']; ?>' // Set the image URL
                            }
                        },
                    <?php } else { ?> {
                            title: '<?= $d['status'] ?>',
                            start: '<?php echo $d['tanggal']; ?>',
                            classNames: ['fc-event-image'], // Add class for event images
                            extendedProps: {
                                imageurl: 'foto/<?php echo $d['fotopulang']; ?>' // Set the image URL
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
            }
        });

        calendar.render();
    });
</script>