<?php
include 'koneksi.php';

// Data admin baru
$username = "UPTPTKSMALANG";       // ganti sesuai kebutuhan
$password = "ptks01";       // password asli (nanti otomatis di-hash)

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Simpan ke database
$sql = "INSERT INTO admin (username, password) VALUES ('$username', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "✅ Admin berhasil ditambahkan!<br>";
    echo "Username: " . $username . "<br>";
    echo "Password: " . $password . " (gunakan ini saat login)";
} else {
    echo "❌ Error: " . $conn->error;
}

$conn->close();
?>