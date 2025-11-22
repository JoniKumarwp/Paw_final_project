<?php
// include "header.php";
require 'koneksi.php';
session_start();

if (!isset($_SESSION['role'])) {
    echo "<script>window.location='login.php';</script>";
    exit;
}
if ($_SESSION['role'] !== 'admin') {
    echo "<script>window.location='customer_dashboard.php';</script>";
    exit;
}


if (isset($_GET['delete_room'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_room']);


    $q = mysqli_query($conn, "SELECT image FROM rooms WHERE id='$id'");
    if ($q && mysqli_num_rows($q) > 0) {
        $data = mysqli_fetch_assoc($q);
        if (!empty($data['image'])) {
            $file_path = __DIR__ . "/uploads/" . $data['image'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
    }

    mysqli_query($conn, "DELETE FROM rooms WHERE id='$id'");
    echo "<script>alert('Kamar berhasil dihapus!'); window.location='owner_dashboard.php';</script>";
    exit;
}

if (isset($_GET['action']) && isset($_GET['id_book'])) {
    $status = $_GET['action'] == 'approve' ? 'confirmed' : 'cancelled';
    $id_book = mysqli_real_escape_string($conn, $_GET['id_book']);
    mysqli_query($conn, "UPDATE bookings SET status='$status' WHERE id='$id_book'");
    echo "<script>window.location='owner_dashboard.php?tab=bookings';</script>";
    exit;
}

$edit_mode  = false;
$kamar_edit = [];

if (isset($_GET['edit_room'])) {
    $edit_mode = true;
    $id_edit   = mysqli_real_escape_string($conn, $_GET['edit_room']);
    $res       = mysqli_query($conn, "SELECT * FROM rooms WHERE id='$id_edit'");
    $kamar_edit = mysqli_fetch_assoc($res);
}

if (isset($_POST['save_room'])) {
    $title    = mysqli_real_escape_string($conn, $_POST['title']);
    $city     = mysqli_real_escape_string($conn, $_POST['city']);
    $type     = mysqli_real_escape_string($conn, $_POST['type']);
    $capacity = (int) $_POST['capacity'];
    $price    = (float) $_POST['price_per_night'];
    $desc     = mysqli_real_escape_string($conn, $_POST['description']);

    $image_query = "";
    $img_val     = "";


    if (!empty($_FILES['image']['name'])) {
        $nama_file = time() . '_' . preg_replace('/\s+/', '_', $_FILES['image']['name']);
        $tmp_file  = $_FILES['image']['tmp_name'];
        $upload_dir_fs = __DIR__ . "/uploads/";
        $upload_dir_web = "uploads/";

        if (!is_dir($upload_dir_fs)) {
            mkdir($upload_dir_fs, 0777, true);
        }

        if (move_uploaded_file($tmp_file, $upload_dir_fs . $nama_file)) {
            $image_query = ", image='$nama_file'";
            $img_val     = $nama_file;

            if ($edit_mode && !empty($kamar_edit['image'])) {
                $old_path = $upload_dir_fs . $kamar_edit['image'];
                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            }
        }
    } else if (!$edit_mode) {
        $img_val = "";
    }

    if (!empty($_POST['id_update'])) {
        $limit = 6;
        $page  = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $start = ($page - 1) * $limit;

        $total_rooms_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms");
        $total_rooms_data  = mysqli_fetch_assoc($total_rooms_query);
        $total_rooms       = $total_rooms_data['total'];

$total_pages = ceil($total_rooms / $limit);

        $id_up = mysqli_real_escape_string($conn, $_POST['id_update']);
        $query = "UPDATE rooms 
                    SET title='$title',
                        city='$city',
                        type='$type',
                        capacity='$capacity',
                        price_per_night='$price',
                        description='$desc'
                        $image_query
                  WHERE id='$id_up'";
    } else {
        $query = "INSERT INTO rooms (title, city, type, capacity, price_per_night, description, image)
                  VALUES ('$title', '$city', '$type', '$capacity', '$price', '$desc', '$img_val')";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data kamar berhasil disimpan!'); window.location='owner_dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan: " . mysqli_error($conn) . "');</script>";
    }
}

$total_rooms           = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM rooms"))[0] ?? 0;
$total_bookings        = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM bookings"))[0] ?? 0;
$pending_bookings      = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM bookings WHERE status='pending'"))[0] ?? 0;
$confirmed_bookings    = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM bookings WHERE status='confirmed'"))[0] ?? 0;

?>
<link rel="stylesheet" href="./assets/style.css">
<link rel="stylesheet" href="assets/owner.css">

<?php
$owner_name  = isset($_SESSION['name']) ? $_SESSION['name'] : "Administrator";
$owner_email = isset($_SESSION['email']) ? $_SESSION['email'] : "admin@hotel.com";
$initials    = strtoupper(substr($owner_name, 0, 1));
$active_tab  = isset($_GET['tab']) ? $_GET['tab'] : 'rooms';
?>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="admin-profile">
            <div class="admin-avatar"><?php echo $initials; ?></div>
            <div class="admin-name"><?php echo htmlspecialchars($owner_name); ?></div>
            <div class="admin-role">Owner / Admin</div>
            <div class="admin-email"><?php echo htmlspecialchars($owner_email); ?></div>
        </div>

        <div class="sidebar-section-title">Menu</div>
        <ul class="sidebar-menu">
            <li>
                <a href="owner_dashboard.php?tab=rooms"
                   class="<?php echo ($active_tab == 'rooms' || $active_tab == '') ? 'active' : ''; ?>">
                    <span class="icon">🏨</span> Manage Rooms
                </a>
            </li>
            <li>
                <a href="owner_dashboard.php?tab=bookings"
                   class="<?php echo ($active_tab == 'bookings') ? 'active' : ''; ?>">
                    <span class="icon">📅</span> Bookings
                </a>
            </li>
            <li>
                <a href="index.php">
                    <span class="icon">🏠</span> Front Website
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <span class="icon">🚪</span> Logout
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            Hotel Web Admin Panel<br>
            <span style="opacity:.8;">Logged in as admin</span>
        </div>
    </aside>

    <main class="admin-main">

        <div class="admin-header-top">
            <h2>
                <span class="icon">📊</span>
                Owner Dashboard
            </h2>
            <div class="breadcrumb">
                <?php echo ucfirst($active_tab == 'rooms' ? 'Rooms' : ($active_tab == 'bookings' ? 'Bookings' : 'Add Room')); ?> &nbsp;/&nbsp; Admin
            </div>
        </div>

        <?php if ($active_tab == 'rooms' || $active_tab == 'bookings') : ?>
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-label">Total Rooms</div>
                <div class="stat-value"><?php echo $total_rooms; ?></div>
                <div class="stat-icon">🏨</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Bookings</div>
                <div class="stat-value"><?php echo $total_bookings; ?></div>
                <div class="stat-icon">📦</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Pending</div>
                <div class="stat-value"><?php echo $pending_bookings; ?></div>
                <div class="stat-icon">⏳</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Confirmed</div>
                <div class="stat-value"><?php echo $confirmed_bookings; ?></div>
                <div class="stat-icon">✅</div>
            </div>
        </div>
        <?php endif; ?>

       <?php if (!isset($_GET['tab']) || $_GET['tab'] == 'rooms') : ?>

    <?php
    $limit = 6;
    $page  = isset($_GET['p']) ? (int)$_GET['p'] : 1;
    if ($page < 1) $page = 1;

    $start = ($page - 1) * $limit;

    $total_rooms_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms");
    $total_rooms_data  = mysqli_fetch_assoc($total_rooms_query);
    $total_rooms       = (int) $total_rooms_data['total'];

    $total_pages = $total_rooms > 0 ? ceil($total_rooms / $limit) : 1;

    $rooms = mysqli_query($conn, "
        SELECT *
        FROM rooms
        ORDER BY id DESC
        LIMIT $start, $limit
    ");
    ?>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3 style="margin:0;">Daftar Kamar</h3>
        <button onclick="window.location.href='?tab=add'" class="btn-primary">
            <span>＋</span> Tambah Kamar
        </button>
    </div>

    <div class="room-grid">
        <?php
        if (mysqli_num_rows($rooms) > 0):
            while($row = mysqli_fetch_assoc($rooms)) :
                $img_file = __DIR__ . "/uploads/" . $row['image'];
                $img_src  = "uploads/" . $row['image'];
                $has_image = !empty($row['image']) && file_exists($img_file);
        ?>
        <div class="room-card">
            <?php if($has_image): ?>
                <img src="<?php echo $img_src; ?>" class="card-img-top" alt="Foto">
            <?php else: ?>
                <div class="card-img-top">📷</div>
            <?php endif; ?>

            <div class="card-body">
                <div class="room-title"><?php echo htmlspecialchars($row['title']); ?></div>
                <div class="room-meta">
                    <?php echo htmlspecialchars($row['city']); ?> &middot;
                    <?php echo htmlspecialchars($row['type']); ?> &middot;
                    Kapasitas: <?php echo (int)$row['capacity']; ?>
                </div>
                <div class="room-price">
                    Rp <?php echo number_format($row['price_per_night']); ?> / malam
                </div>

                <div class="card-actions">
                    <a href="?tab=rooms&p=<?php echo $page; ?>&delete_room=<?php echo $row['id']; ?>" class="link-del"
                       onclick="return confirm('Yakin hapus kamar ini?');">Delete</a>
                    <a href="?tab=add&edit_room=<?php echo $row['id']; ?>" class="link-edit">View / Edit</a>
                </div>
            </div>
        </div>
        <?php
            endwhile;
        else:
        ?>
            <p>Tidak ada kamar terdaftar.</p>
        <?php endif; ?>
    </div>

    <?php if ($total_pages > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?tab=rooms&p=<?php echo $page - 1; ?>" class="page-btn">← Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?tab=rooms&p=<?php echo $i; ?>"
               class="page-number <?php echo ($i == $page) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?tab=rooms&p=<?php echo $page + 1; ?>" class="page-btn">Next →</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

<?php elseif (isset($_GET['tab']) && $_GET['tab'] == 'add') : ?>



            <div class="form-panel">
                <h3 style="margin-top:0; border-bottom:1px solid #eee; padding-bottom:10px;">
                    <?php echo $edit_mode ? "Edit Kamar" : "Tambah Kamar Baru"; ?>
                </h3>

                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_update" value="<?php echo $edit_mode ? $kamar_edit['id'] : ''; ?>">

                    <?php if($edit_mode && !empty($kamar_edit['image'])): ?>
                        <div style="text-align:center; margin-bottom:15px;">
                            <img src="uploads/<?php echo $kamar_edit['image']; ?>" style="height:150px; border-radius:8px; object-fit:cover;">
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label>Foto Kamar</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label>Nama Kamar</label>
                        <input type="text" name="title" class="form-control" required
                               value="<?php echo $edit_mode ? htmlspecialchars($kamar_edit['title']) : ''; ?>">
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                        <div class="form-group">
                            <label>Kota</label>
                            <input type="text" name="city" class="form-control" required
                                   value="<?php echo $edit_mode ? htmlspecialchars($kamar_edit['city']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label>Tipe Kamar</label>
                            <select name="type" class="form-control">
                                <?php
                                    $types = ['Standard','Deluxe','Suite','Family','Premium'];
                                    foreach($types as $t){
                                        $selected = ($edit_mode && $kamar_edit['type'] == $t) ? 'selected' : '';
                                        echo "<option value='$t' $selected>$t</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Harga per Malam (Rp)</label>
                        <input type="number" name="price_per_night" class="form-control" required
                               value="<?php echo $edit_mode ? $kamar_edit['price_per_night'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Kapasitas</label>
                        <input type="number" name="capacity" class="form-control" required
                               value="<?php echo $edit_mode ? $kamar_edit['capacity'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3"><?php
                            echo $edit_mode ? htmlspecialchars($kamar_edit['description']) : '';
                        ?></textarea>
                    </div>

                    <button type="submit" name="save_room" class="btn-primary" style="width:100%; justify-content:center;">
                        <?php echo $edit_mode ? "Simpan Perubahan" : "Simpan Kamar"; ?>
                    </button>
                    <a href="?tab=rooms" style="display:block; text-align:center; margin-top:15px; text-decoration:none; color:#777;">
                        Kembali
                    </a>
                </form>
            </div>

        <?php elseif (isset($_GET['tab']) && $_GET['tab'] == 'bookings') : ?>

            <h3 style="margin-bottom:15px;">Daftar Pesanan</h3>
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Tamu</th>
                        <th>Check In / Out</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query_book = "SELECT b.*, u.name as guest_name
                                   FROM bookings b
                                   JOIN users u ON b.user_id = u.id
                                   ORDER BY b.created_at DESC";
                    $books = mysqli_query($conn, $query_book);
                    if(mysqli_num_rows($books) > 0):
                        while($b = mysqli_fetch_assoc($books)) :
                            $status_color = 'bg-pending';
                            if($b['status'] == 'confirmed') $status_color = 'bg-confirmed';
                            if($b['status'] == 'cancelled') $status_color = 'bg-cancelled';
                    ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($b['booking_code']); ?></td>
                        <td><?php echo htmlspecialchars($b['guest_name']); ?></td>
                        <td><?php echo $b['check_in']; ?> - <?php echo $b['check_out']; ?></td>
                        <td><span class="badge <?php echo $status_color; ?>"><?php echo strtoupper($b['status']); ?></span></td>
                        <td>
                            <?php if($b['status'] == 'pending'): ?>
                                <a href="?tab=bookings&action=approve&id_book=<?php echo $b['id']; ?>"
                                   style="color:green; font-weight:bold;">Terima</a> |
                                <a href="?tab=bookings&action=reject&id_book=<?php echo $b['id']; ?>"
                                   style="color:red; font-weight:bold;" onclick="return confirm('Tolak pesanan ini?');">Tolak</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="5" style="text-align:center;">Belum ada pesanan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

        <?php endif; ?>

    </main>
</div>
