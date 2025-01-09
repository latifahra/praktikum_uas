<?php
require 'db.php';

// Ambil ID catatan dari URL
$id = $_GET['id'];

// Query untuk mendapatkan catatan berdasarkan ID
$query = $pdo->prepare("SELECT * FROM notes WHERE id = ?");
$query->execute([$id]);
$note = $query->fetch(PDO::FETCH_ASSOC);

if (!$note) {
    die("Catatan tidak ditemukan.");
}

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    // Update data catatan di database
    $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ?, category = ? WHERE id = ?");
    $stmt->execute([$title, $content, $category, $id]);

    // Redirect ke halaman utama setelah berhasil update
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Catatan</title>
    <style>
        /* Styling untuk halaman */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fef6e4;
            color: #574240;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            color: #9b6a6c;
            margin-top: 30px;
        }

        .form-container {
            background-color: #fff;
            border-radius: 12px;
            padding: 40px;
            max-width: 600px;
            margin: 40px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            font-size: 1rem;
            margin-bottom: 10px;
            display: block;
            color: #574240;
        }

        .form-container input, .form-container textarea, .form-container select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
            color: #574240;
        }

        .form-container textarea {
            min-height: 150px;
            resize: vertical;
        }

        .form-container button {
            padding: 12px 20px;
            background-color: #ff7b7b;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #d9534f;
        }

        .form-container .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #9b6a6c;
            font-size: 1rem;
        }

        .form-container .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>Edit Catatan</h1>

    <div class="form-container">
        <form method="POST">
            <label for="title">Judul:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($note['title']) ?>" required>

            <label for="content">Isi:</label>
            <textarea id="content" name="content" required><?= htmlspecialchars($note['content']) ?></textarea>

            <label for="category">Kategori:</label>
            <select id="category" name="category" required>
                <option value="Penting" <?= $note['category'] === 'Penting' ? 'selected' : '' ?>>Penting</option>
                <option value="Ide" <?= $note['category'] === 'Ide' ? 'selected' : '' ?>>Ide</option>
                <option value="Belajar" <?= $note['category'] === 'Belajar' ? 'selected' : '' ?>>Belajar</option>
                <option value="Tugas" <?= $note['category'] === 'Tugas' ? 'selected' : '' ?>>Tugas</option>
                <option value="Schedule" <?= $note['category'] === 'Schedule' ? 'selected' : '' ?>>Schedule</option>
                <option value="Lainnya" <?= $note['category'] === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
            </select>

            <button type="submit">Simpan</button>

            <a href="index.php" class="back-link">Kembali ke halaman utama</a>
        </form>
    </div>

</body>
</html>

