<?php
session_start();
if (!isset($_SESSION['admin'])) {
    die("Akses ditolak. <a href='login.php'>Login dulu</a>");
}

include 'koneksi.php';

// --- pastikan variabel koneksi tersedia (bisa $conn atau $koneksi)
if (isset($conn) && $conn instanceof mysqli) {
    $db = $conn;
} elseif (isset($koneksi) && $koneksi instanceof mysqli) {
    $db = $koneksi;
} else {
    die("Koneksi database tidak ditemukan. Periksa koneksi.php (harus mendefinisikan \$conn atau \$koneksi).");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ambil dan trim input
    $nik             = trim($_POST['nik'] ?? '');
    $nama            = trim($_POST['nama'] ?? '');
    $jk              = trim($_POST['jenis_kelamin'] ?? '');
    $tgl             = trim($_POST['tanggal_lahir'] ?? '');
    $tmp             = trim($_POST['tempat_lahir'] ?? '');
    $status          = trim($_POST['status'] ?? '');
    $agama           = trim($_POST['agama'] ?? '');
    $alamat_peserta  = trim($_POST['alamat_peserta'] ?? '');
    $telepon         = trim($_POST['nomer_telepon'] ?? '');
    $instansi        = trim($_POST['instansi'] ?? '');
    $alamat_instansi = trim($_POST['alamat_instansi'] ?? '');
    $jabatan         = trim($_POST['jabatan'] ?? '');
    $tanggal         = trim($_POST['tanggal'] ?? ''); // opsional
    $pelatihan       = trim($_POST['pelatihan'] ?? '');
    $kab_kota        = trim($_POST['kab_kota'] ?? '');

    // validasi singkat
    if ($nik === '' || $nama === '' || $pelatihan === '' || $kab_kota === '') {
        $error = "NIK, Nama, Pelatihan, dan Kab/Kota wajib diisi.";
    } else {
        // Prepared statement
        $stmt = $db->prepare("INSERT INTO peserta 
            (nik, nama, jenis_kelamin, tanggal_lahir, tempat_lahir, status, agama, alamat_peserta, nomer_telepon, instansi, alamat_instansi, jabatan, tanggal, pelatihan, kab_kota)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Gagal menyiapkan statement: " . $db->error);
        }

        $bind = $stmt->bind_param(
            "sssssssssssssss",
            $nik, $nama, $jk, $tgl, $tmp, $status, $agama, $alamat_peserta, $telepon, $instansi, $alamat_instansi, $jabatan, $tanggal, $pelatihan, $kab_kota
        );

        if ($bind === false) {
            die("Gagal bind param: " . $stmt->error);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Peserta berhasil ditambahkan!'); window.location='index.php';</script>";
            exit;
        } else {
            echo "Error saat menyimpan: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Peserta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgba(65, 146, 221, 1);
            margin: 0;
            font-family: Arial, sans-serif;
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
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <div class="card p-4">
            <div class="text-center mb-4">
                <img src="logopt.png" alt="Logo UPT PTKS" width="80" class="mb-2">
                <img src="logodahsyat.png" alt="Logo 2" width="80" class="mb-2">
                <img src="logodah.png" alt="Logo 2" width="80" class="mb-2">
                <img src="logojaw.png" alt="Logo 2" width="80" class="mb-2">
                <h4 class="fw-bold">Tambah Data Peserta</h4>
            </div>

            <?php if(!empty($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" autocomplete="off">
                <div class="mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" name="nik" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <input type="text" name="status" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Agama</label>
                    <input type="text" name="agama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat Peserta</label>
                    <textarea name="alamat_peserta" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">No Telepon</label>
                    <input type="text" name="nomer_telepon" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Instansi</label>
                    <input type="text" name="instansi" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat Instansi</label>
                    <textarea name="alamat_instansi" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal (opsional)</label>
                    <input type="date" name="tanggal" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Pelatihan</label>
                    <input type="text" name="pelatihan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kab/Kota</label>
                    <input type="text" name="kab_kota" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Simpan</button>
            </form>
            <a href="index.php" class="btn btn-outline-secondary w-100 mt-2">Kembali ke Index</a>
        </div>
    </div>
</div>
</body>
</html>
