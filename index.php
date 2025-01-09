<?php
require 'db.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Pencarian
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6; // Catatan per halaman
$offset = ($page - 1) * $limit;

// Query untuk mengambil catatan berdasarkan pencarian
$query = "SELECT * FROM notes WHERE title LIKE :search OR content LIKE :search ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($query);
$stmt->execute(['search' => "%$search%"]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Hitung total catatan untuk pagination
$countQuery = "SELECT COUNT(*) FROM notes WHERE title LIKE :search OR content LIKE :search";
$countStmt = $pdo->prepare($countQuery);
$countStmt->execute(['search' => "%$search%"]);
$totalNotes = $countStmt->fetchColumn();
$totalPages = ceil($totalNotes / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Pribadi</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--bg-color, #fef6e4);
            color: var(--text-color, #574240);
            transition: background-color 0.3s, color 0.3s;
        }

        body.dark {
            --bg-color: #121212;
            --text-color: #e0e0e0;
            --card-bg-color: #1e1e1e;
            --card-title-color: #e0e0e0;
            --card-text-color: #bdbdbd;
            --category-bg-color: #616161;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            color: #9b6a6c;
            margin-bottom: 20px;
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        nav a {
            text-decoration: none;
            background: linear-gradient(90deg, #ff7b7b, #ff9a9a);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background 0.3s;
        }
        nav button {
    text-decoration: none;
    background: linear-gradient(90deg, #ff7b7b, #ff9a9a);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.3s;
    }

    nav button:hover {
    background: linear-gradient(90deg, #d9534f, #f77b7b);
    }

        nav a:hover {
            background: linear-gradient(90deg, #d9534f, #f77b7b);
        }

        .dark-mode-toggle {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .dark-mode-toggle button {
            padding: 10px 20px;
            background-color: #574240;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s, color 0.3s;
        }

        .dark-mode-toggle button:hover {
            background-color: #9b6a6c;
        }

        .note-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .note-card {
            background-color: var(--card-bg-color, #ffffff);
            border-radius: 12px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .note-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .note-card h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--card-title-color, #574240);
        }

        .note-card p {
            margin: 0 0 10px;
            font-size: 0.9rem;
            color: var(--card-text-color, #574240);
        }

        .note-card .date {
            font-size: 0.8rem;
            color: #a5a5a5;
        }

        .note-card .category {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            color: white;
            background-color: var(--category-bg-color, #ffc857);
        }

        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .actions .btn {
            text-decoration: none; /* Menghapus garis bawah default */
            font-size: 0.9rem;
            padding: 8px 15px;
            border-radius: 8px;
            color: orange; /* Warna awal teks */
            border: none;
            text-align: center;
            transition: color 0.3s ease, text-decoration 0.3s ease; /* Transisi halus untuk warna dan garis bawah */
        }

        .actions .btn:hover {
            color: red; /* Warna teks berubah saat hover */
            text-decoration: underline; /* Tambahkan garis bawah saat hover */
        }

        .actions .btn-edit {
            margin-right: 15px; /* Jarak antar tombol */
        }

        .actions .btn-delete {
            margin-left: 15Spx; /* Jarak antar tombol */
        }

        .pagination {
            text-align: center;
            margin: 20px 0;
        }

        .pagination a {
            text-decoration: none;
            color: #574240;
            padding: 10px;
            margin: 0 5px;
            border: 1px solid #ccc;
            border-radius: 50%;
        }

        .pagination a.active {
            background: #ff7b7b;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Note Pribadi</h1>
    <nav>
    <a href="index.php">Halaman Utama</a>
    <a href="add_note.php">Tambah Catatan</a>
    <a href="logout.php">Logout</a>
    <button id="darkModeToggle">Dark Mode</button>
    </nav>
    


    <form method="GET" action="" style="text-align: center; margin-bottom: 20px;">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari catatan..." style="padding: 10px; width: 50%; border: 1px solid #ccc; border-radius: 8px;">
        <button type="submit" style="padding: 10px 20px; background-color: #574240; color: white; border: none; border-radius: 8px; cursor: pointer;">Cari</button>
    </form>

    <div class="note-container">
        <?php if (empty($notes)): ?>
            <p>Tidak ada catatan ditemukan.</p>
        <?php else: ?>
            <?php foreach ($notes as $note): ?>
                <div class="note-card">
                <h2><?= htmlspecialchars($note['title']) ?></h2>
                <p><?= nl2br(htmlspecialchars(mb_strimwidth($note['content'], 0, 100, '...'))) ?></p>
                <p class="date">
                    Dibuat: <?= date('d M Y, H:i', strtotime($note['created_at'])) ?>
                </p>
                
                <?php if (!empty($note['category'])): ?>
                    <div class="category"><?= htmlspecialchars($note['category']) ?></div>
                <?php endif; ?>
                <div class="actions">
                 <a href="edit_note.php?id=<?= $note['id'] ?>" class="btn btn-edit">Edit</a>
                 <a href="delete_note.php?id=<?= $note['id'] ?>" class="btn btn-delete" onclick="return confirm('Hapus catatan ini?');">Hapus</a>
                </div>

            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="<?= $i === $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>

    <script>
        const body = document.body;
        const darkModeToggle = document.getElementById('darkModeToggle');

        // Periksa preferensi pengguna sebelumnya
        if (localStorage.getItem('darkMode') === 'enabled') {
            body.classList.add('dark');
        }

        darkModeToggle.addEventListener('click', () => {
            body.classList.toggle('dark');
            if (body.classList.contains('dark')) {
                localStorage.setItem('darkMode', 'enabled');
            } else {
                localStorage.setItem('darkMode', 'disabled');
            }
        });
    </script>
</body>
</html>
