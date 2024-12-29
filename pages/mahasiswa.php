<?php include('../config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Mahasiswa</title>
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
        <h2>Form Input Mahasiswa</h2>

        <?php
        // Menangani aksi submit
        if (isset($_POST['submit'])) {
            $nim = $_POST['nim'];
            $nama = $_POST['nama'];
            $tanggal_lahir = $_POST['tanggal_lahir'];
            $alamat = $_POST['alamat'];
            $program_studi = $_POST['program_studi'];

            // Query untuk menambah data mahasiswa
            $sql = "INSERT INTO mahasiswa (nim, nama, tanggal_lahir, alamat, program_studi) 
                    VALUES ('$nim', '$nama', '$tanggal_lahir', '$alamat', '$program_studi')";
            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>Data mahasiswa berhasil ditambahkan!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        }

        // Menghapus data mahasiswa
        if (isset($_GET['delete'])) {
            $id_mahasiswa = $_GET['delete'];
            $sql = "DELETE FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";
            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-danger'>Data mahasiswa berhasil dihapus!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        }
        ?>

        <form action="mahasiswa.php" method="POST">
            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat"></textarea>
            </div>
            <div class="form-group">
                <label for="program_studi">Program Studi</label>
                <input type="text" class="form-control" id="program_studi" name="program_studi">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Tambah Data</button>
        </form>

        <h2 class="mt-5">Daftar Mahasiswa</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Mahasiswa</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Program Studi</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan data mahasiswa
                $sql = "SELECT * FROM mahasiswa";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id_mahasiswa'] . "</td>
                                <td>" . $row['nim'] . "</td>
                                <td>" . $row['nama'] . "</td>
                                <td>" . $row['tanggal_lahir'] . "</td>
                                <td>" . $row['alamat'] . "</td>
                                <td>" . $row['program_studi'] . "</td>
                                <td>
                                    <a href='mahasiswa.php?delete=" . $row['id_mahasiswa'] . "' class='btn btn-danger btn-sm'>Hapus</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada data mahasiswa.</td></tr>";
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
