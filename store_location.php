<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Store the coordinates in PHP variables
    $_SESSION['user_latitude'] = $latitude;
    $_SESSION['user_longitude'] = $longitude;

    echo "Location stored successfully.";
} else {
    $_SESSION['user_latitude'] = '';
    $_SESSION['user_longitude'] = '';
}
