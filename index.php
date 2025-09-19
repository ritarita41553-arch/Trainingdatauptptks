<?php    
include 'koneksi.php';    
session_start();    

$page = isset($_GET['page']) ? $_GET['page'] : 'beranda';    

// Query untuk halaman data    
if ($page == 'data') {    
    $search = isset($_GET['q']) ? $_GET['q'] : "";    
    $year   = isset($_GET['year']) ? $_GET['year'] : "";    

    $sql = "SELECT * FROM peserta WHERE     
            (nik LIKE '%$search%'     
            OR nama LIKE '%$search%'     
            OR instansi LIKE '%$search%'     
            OR jabatan LIKE '%$search%'     
            OR pelatihan LIKE '%$search%'     
            OR kab_kota LIKE '%$search%')";    
    if (!empty($year)) {    
        $sql .= " AND YEAR(tanggal) = '$year'";    
    }    
    $result = $conn->query($sql);    
}    
?>  

<!DOCTYPE html>  
<html>    
<head>    
    <title>DATA PELATIHAN UPT PTKS MALANG</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">    

    <style>    
        body {    
            margin: 0;    
            font-family: 'Poppins', sans-serif;    
            display: flex;    
            flex-direction: column;    
            min-height: 100vh;    
        }    
        .navbar {    
            background-color: rgb(19, 136, 245) !important;    
        }    
        .navbar-brand img {    
            height: 40px;    
            margin-right: 5px;    
        }    

        /* Sidebar */
        .sidebar {    
            position: fixed;    
            top: 0;    
            left: -230px; /* Lebar sidebar lebih kecil agar hamburger tetap terlihat */    
            height: 100%;    
            width: 230px;    
            background: #1386f5;    
            color: #fff;    
            transition: all 0.3s ease;    
            padding-top: 60px;    
            z-index: 900;    
        }    
        .sidebar a {    
            display: block;    
            padding: 12px 20px;    
            color: white;    
            text-decoration: none;    
        }    
        .sidebar a:hover {    
            background: #0d6efd;    
        }    
        .sidebar.active {    
            left: 0;    
        }    

        /* Hamburger modern */
        .hamburger {
            width: 35px;
            height: 28px;
            position: relative;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 1000; /* agar selalu di atas sidebar */
        }
        .hamburger span {
            display: block;
            height: 4px;
            width: 100%;
            background: white;
            border-radius: 4px;
            transition: 0.3s ease;
        }
        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg);
            position: absolute;
            top: 12px;
        }
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg);
            position: absolute;
            top: 12px;
        }

        .content {    
            margin-left: 0;    
            transition: all 0.3s ease;    
            padding: 20px;    
            flex: 1;    
        }    
        .sidebar.active ~ .content {    
            margin-left: 230px; /* sesuai lebar sidebar */    
        }  

        /* Beranda full background */    
        .beranda-container {    
            position: relative;    
            text-align: center;    
            margin-top: 5px;    
            padding: 230px 200px;    
            color: white;    
            z-index: 1;    
            background: url('backpt.jpeg') no-repeat center center / cover;    
            border-radius: 10px;    
        }    
        .beranda-container::after {    
            content: "";    
            position: absolute;    
            top: 0;    
            left: 0;    
            width: 100%;    
            height: 100%;    
            background-color: rgba(0,0,0,0.3);    
            z-index: -1;    
            border-radius: 10px;    
        }    

        footer {    
            background: #1388f5;    
            color: white;    
            text-align: center;    
            padding: 10px;    
            font-size: 14px;    
            margin-top: auto;    
        }
    </style>  
</head>    

<body class="bg-light">  

<!-- Navbar -->  
<nav class="navbar navbar-expand-lg navbar-dark px-3">    
    <!-- Hamburger modern -->
    <div onclick="toggleSidebar()" class="hamburger me-3" id="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <a class="navbar-brand d-flex align-items-center" href="index.php">    
        <img src="logopt.png" alt="Logo 1">    
        <img src="logodahsyat.png" alt="Logo 2">    
        <img src="logodah.png" alt="Logo 3">    
        <img src="logojaw.png" alt="Logo 4">    
        DATA PELATIHAN UPT PTKS MALANG    
    </a>    
    <div class="ms-auto">    
      <?php if(isset($_SESSION['admin'])) { ?>    
        <span class="text-white me-3">Halo, <?php echo $_SESSION['admin']; ?></span>    
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>    
      <?php } else { ?>    
        <a href="login.php" class="btn btn-outline-light btn-sm">Login Admin</a>    
      <?php } ?>    
    </div>    
</nav>  

<!-- Sidebar -->  
<div class="sidebar" id="sidebar">    
    <a href="index.php?page=beranda"> Beranda</a>    
    <a href="index.php?page=data"> Data Peserta</a>    
</div>  

<!-- Content -->  
<div class="content">    
    <?php if ($page == 'beranda') { ?>    
        <div class="container beranda-container position-relative">    
            <h2>DATA DIGITAL PESERTA PELATIHAN</h2>    
            <p>    
              UPT PTKS Malang memiliki tugas pokok dan fungsi mencetak dan mengembangkan     
              sumber daya manusia (SDM) pembangunan sosial dan sebagai agen perubahan pembangunan sosial     
              yang memiliki ilmu pengetahuan dan keterampilan tentang berbagai macam teknologi pekerjaan sosial.    
            </p>    
        </div>  

    <?php } elseif ($page == 'data') { ?>    
    <div class="container mt-4">    
        <h2 class="mb-3">Pencarian Data Peserta</h2>    
        <form method="GET" class="mb-3 d-flex flex-wrap gap-2">    
            <input type="hidden" name="page" value="data">    
            <input type="text" name="q" class="form-control flex-grow-1"     
                   placeholder="Cari NIK, Nama, Instansi, Jabatan, Pelatihan, Kab/Kota..."     
                   value="<?php echo htmlspecialchars($search); ?>">    
            <select name="year" class="form-select" style="max-width:150px;">    
                <option value="">Semua Tahun</option>    
                <?php     
                for ($y = 2019; $y <= 2025; $y++) {    
                    $sel = ($year == $y) ? "selected" : "";    
                    echo "<option value='$y' $sel>$y</option>";    
                }    
                ?>    
            </select>    

            <button type="submit" class="btn btn-info text-white">Cari</button>    
            <a href="tambah_peserta.php" class="btn btn-success">+ Tambah Peserta</a>    
        </form>    

        <div class="table-responsive">    
            <table class="table table-bordered table-striped table-hover">    
                <thead class="table-info text-center align-middle">    
                    <tr>    
                        <th>NIK</th>    
                        <th>Nama</th>    
                        <th>Jenis Kelamin</th>    
                        <th>Tanggal Lahir</th>    
                        <th>Tempat Lahir</th>    
                        <th>Status</th>    
                        <th>Agama</th>    
                        <th>Alamat Peserta</th>    
                        <th>No. Telepon</th>    
                        <th>Instansi</th>    
                        <th>Alamat Instansi</th>    
                        <th>Jabatan</th>    
                        <th>Tanggal</th>    
                        <th>Pelatihan</th>    
                        <th>Kab/Kota</th>    
                        <th>Aksi</th>    
                    </tr>    
                </thead>    
                <tbody>    
                <?php while($row = $result->fetch_assoc()) { ?>    
                    <tr>    
                        <td><?= htmlspecialchars($row['nik']); ?></td>    
                        <td><?= htmlspecialchars($row['nama']); ?></td>    
                        <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>    
                        <td><?= htmlspecialchars($row['tanggal_lahir']); ?></td>    
                        <td><?= htmlspecialchars($row['tempat_lahir']); ?></td>    
                        <td><?= htmlspecialchars($row['status']); ?></td>    
                        <td><?= htmlspecialchars($row['agama']); ?></td>    
                        <td><?= htmlspecialchars($row['alamat_peserta']); ?></td>    
                        <td><?= htmlspecialchars($row['nomer_telepon']); ?></td>    
                        <td><?= htmlspecialchars($row['instansi']); ?></td>    
                        <td><?= htmlspecialchars($row['alamat_instansi']); ?></td>    
                        <td><?= htmlspecialchars($row['jabatan']); ?></td>    
                        <td><?= htmlspecialchars($row['tanggal']); ?></td>    
                        <td><?= htmlspecialchars($row['pelatihan']); ?></td>    
                        <td><?= htmlspecialchars($row['kab_kota']); ?></td>    
                        <td class="text-center">    
                            <a href="edit_peserta.php?nik=<?= urlencode($row['nik']); ?>" class="btn btn-warning btn-sm">Edit</a>    
                            <a href="hapus_peserta.php?nik=<?= urlencode($row['nik']); ?>"     
                               class="btn btn-danger btn-sm"     
                               onclick="return confirm('Yakin hapus data ini?')">Hapus</a>    
                        </td>    
                    </tr>    
                <?php } ?>    
                </tbody>    
            </table>    
        </div>    
    </div>
    <?php } ?>  
</div>  

<footer>    
    &copy; SMK NEGERI 2 SINGOSARI. Hak Cipta Dilindungi.    
</footer>  

<script>    
function toggleSidebar() {    
    document.getElementById("sidebar").classList.toggle('active');    
    document.getElementById("hamburger").classList.toggle('active');    
}    
</script>  

</body>    
</html>
