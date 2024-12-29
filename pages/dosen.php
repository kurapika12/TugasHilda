<?php include('../config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Dosen</title>
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
        <h2>Form Input Dosen</h2>
        <form action="dosen.php" method="POST">
            <div class="form-group">
                <label for="nidn">NIDN</label>
                <input type="text" class="form-control" id="nidn" name="nidn" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="bidang_keahlian">Bidang Keahlian</label>
                <input type="text" class="form-control" id="bidang_keahlian" name="bidang_keahlian">
            </div>
            <div class="form-group">
                <label for="no_telepon">No Telepon</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Tambah Data</button>
        </form>

        <h2 class="mt-5">Daftar Dosen</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Dosen</th>
                    <th>NIDN</th>
                    <th>Nama</th>
                    <th>Bidang Keahlian</th>
                    <th>No Telepon</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menambah data dosen
                if (isset($_POST['submit'])) {
                    $nidn = $_POST['nidn'];
                    $nama = $_POST['nama'];
                    $bidang_keahlian = $_POST['bidang_keahlian'];
                    $no_telepon = $_POST['no_telepon'];
                    
                    $sql = "INSERT INTO dosen (nidn, nama, bidang_keahlian, no_telepon) 
                            VALUES ('$nidn', '$nama', '$bidang_keahlian', '$no_telepon')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Data dosen berhasil ditambahkan!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                    }
                }

                // Mengambil dan menampilkan data dosen
                $sql = "SELECT * FROM dosen";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id_dosen'] . "</td>
                                <td>" . $row['nidn'] . "</td>
                                <td>" . $row['nama'] . "</td>
                                <td>" . $row['bidang_keahlian'] . "</td>
                                <td>" . $row['no_telepon'] . "</td>
                                <td>
                                    <a href='dosen.php?delete=" . $row['id_dosen'] . "' class='btn btn-danger btn-sm'>Hapus</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data dosen.</td></tr>";
                }

                // Proses untuk menghapus data dosen
                if (isset($_GET['delete'])) {
                    $id_dosen = $_GET['delete'];
                    $sql = "DELETE FROM dosen WHERE id_dosen = $id_dosen";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Data dosen berhasil dihapus!</div>";
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
