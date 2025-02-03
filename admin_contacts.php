<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `message` WHERE id= '$delete_id'") or die('query failed');
    header('location:admin_contacts.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pesan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'admin_header.php'; ?>


    <section class="messages">

        <h1 class="title"> pesan masuk </h1>

        <div class="box-container">
            <?php
            $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
            if (mysqli_num_rows($select_message) > 0) {
                while ($fetch_message = mysqli_fetch_assoc($select_message)) {

            ?>
                    <div class="box">
                        <p> user id : <span><?php echo $fetch_message['user_id']; ?></span> </p>
                        <p> nama : <span><?php echo $fetch_message['name']; ?></span> </p>
                        <p> no HP : <span><?php echo $fetch_message['number']; ?></span> </p>
                        <p> email : <span><?php echo $fetch_message['email']; ?></span> </p>
                        <p> pesan : <span><?php echo $fetch_message['message']; ?></span> </p>
                        <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('hapus pesan ini?');" class="delete-btn">Hapus pesan ini</a>
                    </div>
            <?php
                };
            } else {
                echo '<p class="empty">anda belum memiliki pesan!</p>';
            }
            ?>
        </div>

    </section>

    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>
</body>

</html>