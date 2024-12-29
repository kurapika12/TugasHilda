<?php include('../config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Kelas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">Website Kampus</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="mahasiswa.php">Data Mahasiswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dosen.php">Data Dosen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mata_kuliah.php">Data Mata Kuliah</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelas.php">Data Kelas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="nilai.php">Data Nilai</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Form Input Kelas</h2>
        <form action="kelas.php" method="POST">
            <div class="form-group">
                <label for="jam">Jam</label>
                <input type="time" class="form-control" id="jam" name="jam" required>
            </div>
            <div class="form-group">
                <label for="hari">Hari</label>
                <input type="text" class="form-control" id="hari" name="hari" required>
            </div>
            
            <!-- Section untuk memilih Dosen -->
            <div class="form-group">
                <label for="id_dosen">Pilih Dosen</label>
                <select class="form-control" id="id_dosen" name="id_dosen" required>
                    <?php
                    // Menampilkan daftar dosen yang ada
                    $result_dosen = $conn->query("SELECT id_dosen, nama FROM dosen");
                    while ($row = $result_dosen->fetch_assoc()) {
                        echo "<option value='" . $row['id_dosen'] . "'>" . $row['nama'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Section untuk memilih Mata Kuliah -->
            <div class="form-group">
                <label for="kode_mk">Pilih Mata Kuliah</label>
                <select class="form-control" id="kode_mk" name="kode_mk" required>
                    <?php
                    // Menampilkan daftar mata kuliah yang ada
                    $result_mk = $conn->query("SELECT kode_mk, nama_mk FROM mata_kuliah");
                    while ($row = $result_mk->fetch_assoc()) {
                        echo "<option value='" . $row['kode_mk'] . "'>" . $row['nama_mk'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Tambah Data</button>
        </form>

        <h2 class="mt-5">Daftar Kelas</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Kelas</th>
                    <th>Jam</th>
                    <th>Hari</th>
                    <th>Dosen</th>
                    <th>Mata Kuliah</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menambah data kelas
                if (isset($_POST['submit'])) {
                    $jam = $_POST['jam'];
                    $hari = $_POST['hari'];
                    $id_dosen = $_POST['id_dosen'];
                    $kode_mk = $_POST['kode_mk'];
                    
                    $sql = "INSERT INTO kelas (jam, hari, id_dosen, kode_mk) 
                            VALUES ('$jam', '$hari', '$id_dosen', '$kode_mk')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Data kelas berhasil ditambahkan!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                    }
                }

                // Mengambil dan menampilkan data kelas
                $sql = "SELECT kelas.*, dosen.nama AS dosen_nama, mata_kuliah.nama_mk 
                        FROM kelas
                        JOIN dosen ON kelas.id_dosen = dosen.id_dosen
                        JOIN mata_kuliah ON kelas.kode_mk = mata_kuliah.kode_mk";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id_kelas'] . "</td>
                                <td>" . $row['jam'] . "</td>
                                <td>" . $row['hari'] . "</td>
                                <td>" . $row['dosen_nama'] . "</td>
                                <td>" . $row['nama_mk'] . "</td>
                                <td>
                                    <a href='kelas.php?delete=" . $row['id_kelas'] . "' class='btn btn-danger btn-sm'>Hapus</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data kelas.</td></tr>";
                }

                // Proses untuk menghapus data kelas
                if (isset($_GET['delete'])) {
                    $id_kelas = $_GET['delete'];
                    $sql = "DELETE FROM kelas WHERE id_kelas = $id_kelas";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Data kelas berhasil dihapus!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS Bundle (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
