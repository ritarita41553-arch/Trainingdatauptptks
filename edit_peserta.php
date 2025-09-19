<?php
session_start();
if (!isset($_SESSION['admin'])) {
    die("Akses ditolak. <a href='login.php'>Login dulu</a>");
}

include 'koneksi.php';

// Ambil NIK dari URL
$nik = $_GET['nik'] ?? '';
if ($nik === '') {
    die("NIK tidak ditemukan.");
}

// Ambil data peserta
$stmt = $conn->prepare("SELECT * FROM peserta WHERE nik = ?");
$stmt->bind_param("s", $nik);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    die("Data peserta tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama            = $_POST['nama'];
    $jk              = $_POST['jenis_kelamin'];
    $tgl             = $_POST['tanggal_lahir'];
    $tmp             = $_POST['tempat_lahir'];
    $status          = $_POST['status'];
    $agama           = $_POST['agama'];
    $alamat_peserta  = $_POST['alamat_peserta'];
    $telepon         = $_POST['nomer_telepon'];
    $instansi        = $_POST['instansi'];
    $alamat_instansi = $_POST['alamat_instansi'];
    $jabatan         = $_POST['jabatan'];
    $tanggal         = $_POST['tanggal'];
    $pelatihan       = $_POST['pelatihan'];
    $kab_kota        = $_POST['kab_kota'];

    $sql_update = "UPDATE peserta SET 
        nama=?, 
        jenis_kelamin=?, 
        tanggal_lahir=?, 
        tempat_lahir=?, 
        status=?, 
        agama=?, 
        alamat_peserta=?, 
        nomer_telepon=?, 
        instansi=?, 
        alamat_instansi=?, 
        jabatan=?, 
        tanggal=?, 
        pelatihan=?, 
        kab_kota=?
        WHERE nik=?";

    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param(
        "sssssssssssssss",
        $nama, $jk, $tgl, $tmp, $status, $agama, $alamat_peserta, 
        $telepon, $instansi, $alamat_instansi, $jabatan, 
        $tanggal, $pelatihan, $kab_kota, $nik
    );

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui'); window.location='index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peserta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4f7abb, #5fa8d3);
            font-family: 'Poppins', sans-serif;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4">
                    <h3 class="text-center mb-4">Edit Data Peserta</h3>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['nik']); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="L" <?php if($data['jenis_kelamin']=='L') echo 'selected'; ?>>Laki-laki</option>
                                <option value="P" <?php if($data['jenis_kelamin']=='P') echo 'selected'; ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" value="<?php echo htmlspecialchars($data['tanggal_lahir']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" name="tempat_lahir" value="<?php echo htmlspecialchars($data['tempat_lahir']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <input type="text" class="form-control" name="status" value="<?php echo htmlspecialchars($data['status']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Agama</label>
                            <input type="text" class="form-control" name="agama" value="<?php echo htmlspecialchars($data['agama']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Peserta</label>
                            <textarea class="form-control" name="alamat_peserta"><?php echo htmlspecialchars($data['alamat_peserta']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No Telepon</label>
                            <input type="text" class="form-control" name="nomer_telepon" value="<?php echo htmlspecialchars($data['nomer_telepon']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Instansi</label>
                            <input type="text" class="form-control" name="instansi" value="<?php echo htmlspecialchars($data['instansi']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Instansi</label>
                            <textarea class="form-control" name="alamat_instansi"><?php echo htmlspecialchars($data['alamat_instansi']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" value="<?php echo htmlspecialchars($data['jabatan']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal (opsional)</label>
                            <input type="date" class="form-control" name="tanggal" value="<?php echo htmlspecialchars($data['tanggal']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pelatihan</label>
                            <input type="text" class="form-control" name="pelatihan" value="<?php echo htmlspecialchars($data['pelatihan']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kab/Kota</label>
                            <input type="text" class="form-control" name="kab_kota" value="<?php echo htmlspecialchars($data['kab_kota']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-2">Update</button>
                        <a href="index.php" class="btn btn-outline-secondary w-100">Kembali ke Index</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
