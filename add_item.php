<?php
include 'db.php';
include 'templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $satuan_barang = $_POST['satuan_barang'];
    $harga_beli = $_POST['harga_beli'];
    $status_barang = isset($_POST['status_barang']) ? 1 : 0;

    $sql = "INSERT INTO barang (kode_barang, nama_barang, jumlah_barang, satuan_barang, harga_beli, status_barang)
            VALUES ('$kode_barang', '$nama_barang', $jumlah_barang, '$satuan_barang', $harga_beli, $status_barang)";
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<h2>Tambah Barang</h2>
<form method="POST">
    <div class="form-group">
        <label>Kode Barang</label>
        <input type="text" name="kode_barang" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Jumlah Barang</label>
        <input type="number" name="jumlah_barang" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Satuan Barang</label>
        <select name="satuan_barang" class="form-control" required>
            <option value="kg">kg</option>
            <option value="pcs">pcs</option>
            <option value="liter">liter</option>
            <option value="meter">meter</option>
        </select>
    </div>
    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" step="0.01" name="harga_beli" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Status Barang</label>
        <input type="checkbox" name="status_barang"> Available
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
</form>


<?php

include 'templates/footer.php';
?>
