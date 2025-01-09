<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    
    $stmt = $pdo->prepare("INSERT INTO notes (title, content, category, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$title, $content, $category]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Catatan</title>
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

    <h1>Tambah Catatan</h1>

    <div class="form-container">
        <form method="POST">
            <label for="title">Judul:</label>
            <input type="text" id="title" name="title" required>

            <label for="content">Isi:</label>
            <textarea id="content" name="content" required></textarea>

            <label for="category">Kategori:</label>
            <select id="category" name="category" required>
                <option value="Penting">Penting</option>
                <option value="Ide">Ide</option>
                <option value="Belajar">Belajar</option>
                <option value="Tugas">Tugas</option>
                <option value="Schedule">Schedule</option>
                <option value="Lainnya">Lainnya</option>
            </select>

            <button type="submit">Simpan</button>

            <a href="index.php" class="back-link">Kembali ke halaman utama</a>
        </form>
    </div>

</body>
</html>
