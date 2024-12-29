<?php include('../config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Nilai</title>
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
        <h2>Form Input Nilai</h2>
        <form action="nilai.php" method="POST">
            <div class="form-group">
                <label for="id_mahasiswa">Mahasiswa</label>
                <select class="form-control" id="id_mahasiswa" name="id_mahasiswa" required>
                    <?php
                    // Menampilkan daftar mahasiswa untuk dipilih
                    $result_mahasiswa = $conn->query("SELECT id_mahasiswa, nama FROM mahasiswa");
                    while ($row = $result_mahasiswa->fetch_assoc()) {
                        echo "<option value='" . $row['id_mahasiswa'] . "'>" . $row['nama'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_kelas">Kelas</label>
                <select class="form-control" id="id_kelas" name="id_kelas" required>
                    <?php
                    // Menampilkan daftar kelas untuk dipilih
                    $result_kelas = $conn->query("SELECT id_kelas, kode_mk FROM kelas");
                    while ($row = $result_kelas->fetch_assoc()) {
                        echo "<option value='" . $row['id_kelas'] . "'>" . $row['kode_mk'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nilai_uts">Nilai UTS</label>
                <input type="number" class="form-control" id="nilai_uts" name="nilai_uts" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="nilai_uas">Nilai UAS</label>
                <input type="number" class="form-control" id="nilai_uas" name="nilai_uas" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="nilai_akhir">Nilai Akhir</label>
                <input type="number" class="form-control" id="nilai_akhir" name="nilai_akhir" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Tambah Data</button>
        </form>

        <h2 class="mt-5">Daftar Nilai</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Kode Mata Kuliah</th>
                    <th>Nilai UTS</th>
                    <th>Nilai UAS</th>
                    <th>Nilai Akhir</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menambah data nilai
                if (isset($_POST['submit'])) {
                    $id_mahasiswa = $_POST['id_mahasiswa'];
                    $id_kelas = $_POST['id_kelas'];
                    $nilai_uts = $_POST['nilai_uts'];
                    $nilai_uas = $_POST['nilai_uas'];
                    $nilai_akhir = $_POST['nilai_akhir'];

                    $sql = "INSERT INTO nilai (id_mahasiswa, id_kelas, nilai_uts, nilai_uas, nilai_akhir) 
                            VALUES ('$id_mahasiswa', '$id_kelas', '$nilai_uts', '$nilai_uas', '$nilai_akhir')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Data nilai berhasil ditambahkan!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                    }
                }

                // Mengambil dan menampilkan data nilai
                $sql = "SELECT nilai.*, mahasiswa.nama AS mahasiswa_nama, kelas.kode_mk 
                        FROM nilai
                        JOIN mahasiswa ON nilai.id_mahasiswa = mahasiswa.id_mahasiswa
                        JOIN kelas ON nilai.id_kelas = kelas.id_kelas";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['mahasiswa_nama'] . "</td>
                                <td>" . $row['kode_mk'] . "</td>
                                <td>" . $row['nilai_uts'] . "</td>
                                <td>" . $row['nilai_uas'] . "</td>
                                <td>" . $row['nilai_akhir'] . "</td>
                                <td>
                                    <a href='nilai.php?delete=" . $row['id_nilai'] . "' class='btn btn-danger btn-sm'>Hapus</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data nilai.</td></tr>";
                }

                // Proses untuk menghapus data nilai
                if (isset($_GET['delete'])) {
                    $id_nilai = $_GET['delete'];
                    $sql = "DELETE FROM nilai WHERE id_nilai = '$id_nilai'";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Data nilai berhasil dihapus!</div>";
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
