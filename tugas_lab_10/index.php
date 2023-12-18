<?php
include 'koneksi.php';
include 'form_handler.php';

// Buat objek dari class Database
$database = new Database();

// Buat objek dari class FormHandler dengan menyertakan objek Database
$formHandler = new FormHandler($database);

// Ambil semua data dari tabel
$data = $formHandler->getAllDataFromTable('data_barang');

?>

?>
<?php require('header.php') ?>
    <div class="container">
        <h1>Data Barang</h1>
        <a href="tambah.php">tambah barang</a>
        <div class="main">
            <table>
            <tr>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Katagori</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($data as $row): ?>
            <tr>
            <td>
                <img src="http://localhost/lab8_php_database/pict/<?= $row['gambar']; ?>" alt="<?= $row['nama']; ?>" width="31px"></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['kategori']; ?></td>
                <td><?php echo $row['harga_jual']; ?></td>
                <td><?php echo $row['harga_beli']; ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td class="actions">
                <a href="ubah.php?id=<?=$row['id_barang'];?>">ubah</a>
                <a href="hapus.php?id= <?=$row['id_barang'];?>">hapus </a>
                <!-- Tambahkan kolom lain sesuai kebutuhan... -->
                
            </tr>
        <?php endforeach; ?>
            
            </table>
        </div>
    </div>
</body>
</html>