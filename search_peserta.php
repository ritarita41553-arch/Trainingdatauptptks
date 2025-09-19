<?php
$conn = new mysqli("localhost", "root", "", "trainingdata_uptptks");

$search = isset($_GET['q']) ? $_GET['q'] : "";

$sql = "SELECT * FROM peserta WHERE 
        nik LIKE '%$search%' 
        OR nama LIKE '%$search%' 
        OR instansi LIKE '%$search%' 
        OR jabatan LIKE '%$search%' 
        OR pelatihan LIKE '%$search%' 
        OR kab_kota LIKE '%$search%'";

$result = $conn->query($sql);
?>

<h2>Pencarian Data Peserta</h2>
<form method="GET">
    <input type="text" name="q" placeholder="Cari NIK, Nama, Instansi, Jabatan, Pelatihan, Kab/Kota..." value="<?php echo $search; ?>">
    <button type="submit">Cari</button>
</form>

<table border="1" cellpadding="5">
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
    </tr>
    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['nik']; ?></td>
        <td><?php echo $row['nama']; ?></td>
        <td><?php echo $row['jenis_kelamin']; ?></td>
        <td><?php echo $row['tanggal_lahir']; ?></td>
        <td><?php echo $row['tempat_lahir']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td><?php echo $row['agama']; ?></td>
        <td><?php echo $row['alamat_peserta']; ?></td>
        <td><?php echo $row['nomer_telepon']; ?></td>
        <td><?php echo $row['instansi']; ?></td>
        <td><?php echo $row['alamat_instansi']; ?></td>
        <td><?php echo $row['jabatan']; ?></td>
        <td><?php echo $row['tanggal']; ?></td>
        <td><?php echo $row['pelatihan']; ?></td>
        <td><?php echo $row['kab_kota']; ?></td>
    </tr>
    <?php } ?>
</table>