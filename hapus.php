<?php
include 'koneksi.php';
include 'form_handler.php';

// Buat objek dari class Database
$database = new Database();

// Buat objek dari class FormHandler dengan menyertakan objek Database
$formHandler = new FormHandler($database);

// Ambil ID data yang akan dihapus dari URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Panggil metode untuk menghapus data dari database
$formHandler->deleteDataById('data_barang', $id);

// Redirect kembali ke halaman utama setelah data dihapus
header("Location: index.php"); // Ganti "index.php" dengan halaman yang sesuai
exit();
?>
