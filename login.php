<?php
include 'db.php'; // Gunakan koneksi dari db.php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: berhasil_login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']); // Hash password dengan SHA-256

    try {
        // Siapkan dan eksekusi query
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $stmt->execute(['email' => $email, 'password' => $password]);

        // Cek hasil query
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['username'] = $row['username'];
            header("Location: berhasil_login.php");
            exit();
        } else {
            echo "<script>alert('Email atau password Anda salah. Silakan coba lagi!')</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Terjadi kesalahan: {$e->getMessage()}')</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Pemrograman Web</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('background.jpg'); /* Ganti dengan URL gambar Anda */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff; /* Ubah warna teks jika perlu agar kontras dengan background */
        }

        .container {
            background: rgba(255, 255, 255, 0.9); /* Transparansi untuk menonjolkan konten */
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-text {
            color: #574240;
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            color: #574240;
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
        }

        .input-group input:focus {
            border-color: #ff7b7b;
            outline: none;
            box-shadow: 0 0 10px rgba(255, 123, 123, 0.7);
        }

        .btn {
            width: 100%;
            background: linear-gradient(135deg, #ff7b7b, #ff5050);
            color: white;
            border: none;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.4s ease;
        }

        .btn:hover {
            background: linear-gradient(135deg, #ff5050, #d9534f);
        }

        .login-register-text {
            margin-top: 15px;
            font-size: 0.9rem;
            color: #574240;
        }

        .login-register-text a {
            color: #ff7b7b;
            text-decoration: none;
            font-weight: bold;
        }

        .login-register-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <form action="" method="POST" class="login-email">
        <p class="login-text">Login</p>
        <div class="input-group">
            <input type="email" placeholder="Email" name="email" required>
        </div>
        <div class="input-group">
            <input type="password" placeholder="Password" name="password" required>
        </div>
        <div class="input-group">
            <button name="submit" class="btn">Login</button>
        </div>
        <p class="login-register-text">Anda belum punya akun? <a href="register.php">Register</a></p>
    </form>
</div>
</body>
</html>
