<?php
// Inisialisasi variabel error
$nikErr = $namaErr = $emailErr = $tglLahirErr = $jurusanErr = "";
$nik = $nama = $email = $tgl_lahir = $jurusan = "";

// Cek jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi NIK
    if (empty($_POST["nik"])) {
        $nikErr = "NIK wajib diisi";
    } else {
        $nik = test_input($_POST["nik"]);
        if (!preg_match("/^[0-9]{16}$/",$nik)) {
            $nikErr = "NIK harus berisi 16 digit angka";
        }
    }

    // Validasi Nama
    if (empty($_POST["nama"])) {
        $namaErr = "Nama wajib diisi";
    } else {
        $nama = test_input($_POST["nama"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$nama)) {
            $namaErr = "Hanya huruf dan spasi yang diperbolehkan";
        }
    }

    // Validasi Email
    if (empty($_POST["email"])) {
        $emailErr = "Email wajib diisi";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Format email tidak valid";
        }
    }

    // Validasi Tanggal Lahir
    if (empty($_POST["tgl_lahir"])) {
        $tglLahirErr = "Tanggal lahir wajib diisi";
    } else {
        $tgl_lahir = test_input($_POST["tgl_lahir"]);
    }

    // Validasi Jurusan
    if (empty($_POST["jurusan"])) {
        $jurusanErr = "Jurusan wajib dipilih";
    } else {
        $jurusan = test_input($_POST["jurusan"]);
    }

    // Jika tidak ada error, masukkan data ke database
    if ($nikErr == "" && $namaErr == "" && $emailErr == "" && $tglLahirErr == "" && $jurusanErr == "") {
        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "", "db_mahasiswa");

        // Cek koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Insert data
        $sql = "INSERT INTO mahasiswa (nik, nama, email, tanggal_lahir, jurusan)
                VALUES ('$nik', '$nama', '$email', '$tgl_lahir', '$jurusan')";

        if ($conn->query($sql) === TRUE) {
            echo "Pendaftaran berhasil!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}

// Fungsi untuk membersihkan input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Mahasiswa Baru</title>
</head>
<body>
    <h2>Formulir Pendaftaran Mahasiswa Baru</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        NIK: <input type="text" name="nik" value="<?php echo $nik;?>" maxlength="16" required>
        <span style="color:red">* <?php echo $nikErr;?></span>
        <br><br>
        Nama: <input type="text" name="nama" value="<?php echo $nama;?>" required>
        <span style="color:red">* <?php echo $namaErr;?></span>
        <br><br>
        Email: <input type="email" name="email" value="<?php echo $email;?>" required>
        <span style="color:red">* <?php echo $emailErr;?></span>
        <br><br>
        Tanggal Lahir: <input type="date" name="tgl_lahir" value="<?php echo $tgl_lahir;?>" required>
        <span style="color:red">* <?php echo $tglLahirErr;?></span>
        <br><br>
        Jurusan:
        <select name="jurusan" required>
            <option value="">Pilih Jurusan</option>
            <option value="Teknik Informatika" <?php if($jurusan=="Teknik Informatika") echo "selected";?>>Teknik Informatika</option>
            <option value="Sistem Informasi" <?php if($jurusan=="Sistem Informasi") echo "selected";?>>Sistem Informasi</option>
            <option value="Manajemen" <?php if($jurusan=="Manajemen") echo "selected";?>>Manajemen</option>
        </select>
        <span style="color:red">* <?php echo $jurusanErr;?></span>
        <br><br>
        <input type="submit" name="submit" value="Daftar">
    </form>
</body>
</html>

