<?php include('../config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Mata Kuliah</title>
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
        <h2>Form Input Mata Kuliah</h2>
        <form action="mata_kuliah.php" method="POST">
            <div class="form-group">
                <label for="kode_mk">Kode Mata Kuliah</label>
                <input type="text" class="form-control" id="kode_mk" name="kode_mk" required>
            </div>
            <div class="form-group">
                <label for="nama_mk">Nama Mata Kuliah</label>
                <input type="text" class="form-control" id="nama_mk" name="nama_mk" required>
            </div>
            <div class="form-group">
                <label for="sks">SKS</label>
                <input type="number" class="form-control" id="sks" name="sks" required>
            </div>
            <div class="form-group">
                <label for="semester">Semester</label>
                <input type="number" class="form-control" id="semester" name="semester" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Tambah Data</button>
        </form>

        <h2 class="mt-5">Daftar Mata Kuliah</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Mata Kuliah</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menambah data mata kuliah
                if (isset($_POST['submit'])) {
                    $kode_mk = $_POST['kode_mk'];
                    $nama_mk = $_POST['nama_mk'];
                    $sks = $_POST['sks'];
                    $semester = $_POST['semester'];

                    $sql = "INSERT INTO mata_kuliah (kode_mk, nama_mk, sks, semester) 
                            VALUES ('$kode_mk', '$nama_mk', '$sks', '$semester')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Data mata kuliah berhasil ditambahkan!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                    }
                }

                // Mengambil dan menampilkan data mata kuliah
                $sql = "SELECT * FROM mata_kuliah";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['kode_mk'] . "</td>
                                <td>" . $row['nama_mk'] . "</td>
                                <td>" . $row['sks'] . "</td>
                                <td>" . $row['semester'] . "</td>
                                <td>
                                    <a href='mata_kuliah.php?delete=" . $row['kode_mk'] . "' class='btn btn-danger btn-sm'>Hapus</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data mata kuliah.</td></tr>";
                }

                // Proses untuk menghapus data mata kuliah
                if (isset($_GET['delete'])) {
                    $kode_mk = $_GET['delete'];
                    $sql = "DELETE FROM mata_kuliah WHERE kode_mk = '$kode_mk'";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Data mata kuliah berhasil dihapus!</div>";
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
