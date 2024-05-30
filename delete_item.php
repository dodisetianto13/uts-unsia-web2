<?php
include 'db.php';

$id = $_GET['id'];
$sql = "DELETE FROM barang WHERE id_barang = $id";
if ($conn->query($sql) === TRUE) {
    header('Location: index.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>

<?php
include 'templates/footer.php';
?>