<?php
include 'db.php';
include 'templates/header.php';

// Default values for pagination
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Count total records
$total_sql = "SELECT COUNT(*) FROM barang WHERE nama_barang LIKE '%$search%' OR kode_barang LIKE '%$search%'";
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_row()[0];
$total_pages = ceil($total_rows / $limit);

// Fetch limited records
$sql = "SELECT * FROM barang WHERE nama_barang LIKE '%$search%' OR kode_barang LIKE '%$search%' LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<h2>Daftar Barang</h2>
<div class="mb-3">
    <a href="add_item.php" class="btn btn-primary">Tambah Barang</a>
    <div class="float-right">
        <form method="GET" action="index.php" class="form-inline" id="search-form">
            <div class="input-group mr-2">
                <input type="text" name="search" class="form-control" placeholder="Cari barang..." value="<?php echo htmlspecialchars($search); ?>" id="search-input">
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary" onclick="clearSearch()">X</button>
                </div>
            </div>
            <button type="submit" class="btn btn-secondary mr-2">Cari</button>
            <label for="limit" class="mr-2">Tampilkan</label>
            <select name="limit" id="limit" class="form-control" onchange="this.form.submit()">
                <option value="10" <?php if ($limit == 10) echo 'selected'; ?>>10</option>
                <option value="20" <?php if ($limit == 20) echo 'selected'; ?>>20</option>
                <option value="50" <?php if ($limit == 50) echo 'selected'; ?>>50</option>
            </select>
            <input type="hidden" name="page" value="1">
        </form>
    </div>
</div>

<p>Total Barang: <?php echo $total_rows; ?></p>

<table class="table table-bordered">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Harga Beli</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id_barang']; ?></td>
                <td><?php echo $row['kode_barang']; ?></td>
                <td><?php echo $row['nama_barang']; ?></td>
                <td><?php echo $row['jumlah_barang']; ?></td>
                <td><?php echo $row['satuan_barang']; ?></td>
                <td><?php echo $row['harga_beli']; ?></td>
                <td><?php echo $row['status_barang'] ? 'Available' : 'Not Available'; ?></td>
                <td>
                    <a href="update_item.php?id=<?php echo $row['id_barang']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_item.php?id=<?php echo $row['id_barang']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    <a href="use_item.php?id=<?php echo $row['id_barang']; ?>" class="btn btn-secondary btn-sm">Use</a>
                    <a href="increase_item.php?id=<?php echo $row['id_barang']; ?>" class="btn btn-success btn-sm">Increase</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<nav aria-label="Page navigation example" class="mt-3">
    <ul class="pagination justify-content-center">
        <?php if($page > 1): ?>
            <li class="page-item"><a class="page-link" href="index.php?limit=<?php echo $limit; ?>&page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">Previous</a></li>
        <?php endif; ?>
        <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php if($i == $page) echo 'active'; ?>"><a class="page-link" href="index.php?limit=<?php echo $limit; ?>&page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>
        <?php if($page < $total_pages): ?>
            <li class="page-item"><a class="page-link" href="index.php?limit=<?php echo $limit; ?>&page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next</a></li>
        <?php endif; ?>
    </ul>
</nav>

<?php include 'templates/footer.php'; ?>

<script>
function clearSearch() {
    document.getElementById('search-input').value = '';
    document.getElementById('search-form').submit();
}

document.getElementById('search-input').addEventListener('input', function() {
    if (this.value.length >= 2 || this.value === '') {
        document.getElementById('search-form').submit();
    }
});
</script>

