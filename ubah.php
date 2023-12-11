<?php
include 'koneksi.php';
include 'form_handler.php';

// Buat objek dari class Database
$database = new Database();

// Buat objek dari class FormHandler dengan menyertakan objek Database
$formHandler = new FormHandler($database);

// Jika ada form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $formData = array(
        'nama' => $_POST['nama'],
        'kategori' => $_POST['kategori'],
        'harga_jual'=> $_POST['harga_jual'],
        'harga_beli'=> $_POST['harga_beli'],
        'stok'=> $_POST['stok'],
    );

    // Ambil ID data jika ada (untuk operasi mengubah)
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    // Upload gambar dan ambil pathnya
    $imagePath = $formHandler->uploadImage('image', 'uploads/'); // 'image' adalah name dari input file pada form

    // Tambahkan path gambar ke dalam data form
    $formData['image'] = $imagePath;

    // Panggil metode untuk memasukkan atau mengubah data di database
    $formHandler->processFormData('latihan1', $formData, $id);

    // Redirect kembali ke halaman utama setelah data diubah atau dimasukkan
    header("Location: index.php"); // Ganti "index.php" dengan halaman yang sesuai
    exit();
}

// Ambil ID data yang akan diubah dari URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Ambil data yang akan diubah dari database
$dataToEdit = $id ? $formHandler->getDataById('data_barang', $id) : null;
?>
<?php require('header.php') ?>
    <h1>Ubah Barang</h1>
    <div class="main">
        <form method="post" action="ubah.php"
enctype="multipart/form-data">
            <div class="input">
                <label>Nama Barang</label>
                <input type="text" name="nama"  />
            </div>
            <div class="input">
                <label>Kategori</label>
                <select name="kategori">
                <option  value="Komputer">Komputer</option>
                <option  value="Elektronik">Elektronik</option>
                <option  value="Hand Phone">Hand Phone</option>
            </select>
        </div>
            <div class="input">
                <label>Harga Jual</label>
                <input type="text" name="harga_jual"/>
            </div>
        <div class="input">
                <label>Harga Beli</label>
                <input type="text" name="harga_beli" />
            </div>
        <div class="input">
            <label>Stok</label>
            <input type="text" name="stok"/>
            </div>
        <div class="input">
            <label for="image">File Gambar</label>
            <input type="file" name="image" />
        </div>
        <?php if ($id):?>
            <input type="hidden" name="id" value="<?php echo $id;?>">
        <?php endif;?>
        <div class="submit">
        <input type="submit" name="submit" value="Simpan" />
        </div>
    </form>
</div>
</div>
</body>
</html>