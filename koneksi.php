<?php
$host = "localhost";
$user = "root";
$pass = ""; // Kosongkan jika menggunakan XAMPP standar
$db   = "data_api";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    header("Content-Type: application/json; charset=UTF-8");
    http_response_code(500);
    echo json_encode(["status" => false, "message" => "Koneksi database gagal: " . $conn->connect_error]);
    exit;
}
?>