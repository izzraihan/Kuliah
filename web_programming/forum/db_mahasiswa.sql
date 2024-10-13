CREATE DATABASE db_mahasiswa;

USE db_mahasiswa;

CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nik VARCHAR(16) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(50) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    jurusan VARCHAR(100) NOT NULL
);
