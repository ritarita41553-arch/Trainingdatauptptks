
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    die("Akses ditolak. <a href='login.php'>Login dulu</a>");
}
?><?php
include 'koneksi.php';

$nik = $_GET['nik'];
$sql = "DELETE FROM peserta WHERE nik='$nik'";

if ($conn->query($sql)) {
    header("Location: index.php");
} else {
    echo "Error: " . $conn->error;
}
?>