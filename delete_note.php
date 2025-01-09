<?php
// Sertakan file db.php untuk koneksi ke database
require 'db.php';

// Periksa apakah parameter 'id' ada di URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Error: ID tidak valid.");
}

// Tangkap nilai 'id' dari URL
$id = intval($_GET['id']);

try {
    // Persiapkan query SQL untuk menghapus data berdasarkan ID
    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Eksekusi query
    if ($stmt->execute()) {
        // Redirect ke halaman utama setelah berhasil menghapus
        header('Location: index.php?message=note_deleted');
        exit();
    } else {
        // Jika gagal menghapus, tampilkan pesan error
        die("Error: Gagal menghapus catatan dengan ID $id.");
    }
} catch (PDOException $e) {
    // Tampilkan pesan error jika terjadi masalah
    die("Error: " . $e->getMessage());
}
?>
