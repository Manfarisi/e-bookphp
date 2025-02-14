<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_users.php');
}

if (isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['user_type'];

    mysqli_query($conn, "UPDATE `users` SET user_type = '$new_role' WHERE id = '$user_id'") or die('query failed');
    header('location:admin_users.php');
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'admin_header.php'; ?>

    <section class="orders">

        <h1 class="title"> Akun Pengguna </h1>

        <div class="box-container">
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            while ($fetch_users = mysqli_fetch_assoc($select_users)) {
            ?>
                <div class="box">
                    <p> user id : <span><?php echo $fetch_users['id']; ?></span> </p>
                    <p> username : <span><?php echo $fetch_users['name']; ?></span> </p>
                    <p> email : <span><?php echo $fetch_users['email']; ?></span> </p>
                    <p> tipe user : <span style="color:<?php if ($fetch_users['user_type'] == 'admin') {
                                                            echo 'var(--orange)';
                                                        } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>

                        <form action="" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $fetch_users['id']; ?>">
                        <select name="user_type">
                            <option value="" selected disabled><?php echo $fetch_users['user_type']; ?></option>
                            <option value="admin">admin</option>
                            <option value="user">user</option>
                        </select>
                        <input type="submit" name="update_role" class="option-btn" value="Update">
                        <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Hapus akun ini?');" class="delete-btn">Hapus</a>
                    </form>
                </div>
            <?php
            };
            ?>
        </div>

    </section>

    <script>
        function showForm(userId) {
            document.getElementById('update-form-' + userId).style.display = 'block';
        }

        function hideForm(userId) {
            document.getElementById('update-form-' + userId).style.display = 'none';
        }
    </script>


</body>

</html>