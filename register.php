<?php
include 'db.php'; // Gunakan koneksi dari db.php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']); // Hash password dengan SHA-256
    $cpassword = hash('sha256', $_POST['cpassword']); // Hash confirm password

    if ($password === $cpassword) {
        try {
            // Cek apakah email sudah ada
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);

            if ($stmt->rowCount() === 0) {
                // Insert data baru
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
                $stmt->execute([
                    'username' => $username,
                    'email' => $email,
                    'password' => $password
                ]);

                echo "<script>alert('Selamat, registrasi berhasil!')</script>";
            } else {
                echo "<script>alert('Woops! Email sudah terdaftar.')</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Terjadi kesalahan: {$e->getMessage()}')</script>";
        }
    } else {
        echo "<script>alert('Password tidak sesuai!')</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Register</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('background.jpg'); /* Ganti dengan URL gambar */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
            overflow: hidden;
        }

        .container {
            background: rgba(255, 255, 255, 0.9); /* Transparansi agar gambar tetap terlihat */
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
            width: 400px;
            text-align: center;
            animation: fadeIn 1.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .login-text {
            color: #444;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            color: #555;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #7d93ff;
            box-shadow: 0 0 10px rgba(125, 147, 255, 0.7);
            outline: none;
            background: rgba(245, 245, 255, 0.9);
        }

        .btn {
            width: 100%;
            background: linear-gradient(135deg, #7d93ff, #556cd6);
            color: white;
            border: none;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }

        .btn:hover {
            background: linear-gradient(135deg, #556cd6, #354a9d);
            transform: scale(1.05);
        }

        .login-register-text {
            margin-top: 15px;
            font-size: 1rem;
            color: #555;
        }

        .login-register-text a {
            color: #7d93ff;
            text-decoration: none;
            font-weight: bold;
        }

        .login-register-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 500px) {
            .container {
                width: 90%;
                padding: 30px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <form action="" method="POST" class="login-email">
        <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
        <div class="input-group">
            <input type="text" placeholder="Username" name="username" required>
        </div>
        <div class="input-group">
            <input type="email" placeholder="Email" name="email" required>
        </div>
        <div class="input-group">
            <input type="password" placeholder="Password" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
        </div>
        <div class="input-group">
            <input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo isset($_POST['cpassword']) ? htmlspecialchars($_POST['cpassword']) : ''; ?>" required>
        </div>
        <div class="input-group">
            <button name="submit" class="btn">Register</button>
        </div>
        <p class="login-register-text">Anda sudah punya akun? <a href="index.php">Login</a></p>
    </form>
</div>
</body>
</html>
