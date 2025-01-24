<?php
include 'config.php';
$message = [];

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = "Email sudah digunakan, coba gunakan email lain.";
    } else {
        if ($pass !== $cpass) {
            $message[] = "Password tidak sama, coba lagi.";
        } else {
            mysqli_query($conn, "INSERT INTO `users` (name, email, password, user_type) VALUES('$name', '$email', '$pass', 'user')") or die('query failed');
            $message[] = 'Berhasil mendaftar! Silakan login.';
            header('location:login.php');
            exit;
        }
    }
}
?>


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
</head>

<body>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="message"> <span>' . $message . '</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>';
        }
    }
    ?>
    <div class="form-container">
        <form action="" method="post">
            <h3>Daftar Disini</h3>
            <input type="text" name="name" placeholder="Masukan Nama Anda" required class="box">
            <input type="email" name="email" placeholder="Masukan Email Anda" required class="box">
            <input type="password" name="password" placeholder="Masukan Password Anda" required class="box">
            <input type="password" name="cpassword" placeholder="Konfirmasi Password Anda" required class="box">
            <input type="submit" name="submit" value="daftar sekarang" class="btn">
            <p>Sudah memiliki akun? <a href="login.php">Masuk Sekarang</a></p>
        </form>
    </div>
</body>

</html>