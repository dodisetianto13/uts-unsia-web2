<?php
include 'db.php';
include 'templates/header.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jumlah = $_POST['jumlah'];

    $sql = "UPDATE barang SET jumlah_barang = jumlah_barang + $jumlah WHERE id_barang = $id";
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    $sql = "SELECT * FROM barang WHERE id_barang = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

<h2>Tambah Barang</h2>
<form method="POST">
    <div class="form-group">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" class="form-control" value="<?php echo $row['nama_barang']; ?>" disabled>
    </div>
    <div class="form-group">
        <label>Jumlah Barang</label>
        <input type="number" name="jumlah" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Tambah</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
</form>

<?php
include 'templates/footer.php';
?>
