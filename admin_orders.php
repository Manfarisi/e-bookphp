<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['update_order'])) {
    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id ='$order_update_id'") or die('query failed');
    $message[] = 'payment status has been updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_orders.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'admin_header.php'; ?>
    
    <section class="orders">
    <h1 class="title">Pesanan User</h1>

    <div class="box-container">
        <?php
        // Tambahkan ORDER BY placed_on DESC untuk menampilkan pesanan baru di atas
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders` ORDER BY placed_on DESC") or die('query failed');
        if (mysqli_num_rows($select_orders) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
        ?>
                <div class="box">
                    <p> user id : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
                    <p> placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                    <p> nama : <span><?php echo $fetch_orders['name']; ?></span> </p>
                    <p> no HP : <span><?php echo $fetch_orders['number']; ?></span> </p>
                    <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                    <p> alamat : <span><?php echo $fetch_orders['address']; ?></span> </p>
                    <p> total pembelian : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                    <p> total harga : <span>Rp<?php echo number_format($fetch_orders['total_price'], 0, ',', '.');  ?>/-</span> </p>
                    <p> metode pembayaran : <span><?php echo $fetch_orders['method']; ?></span> </p>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                        <select name="update_payment">
                            <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                            <option value="pending">pending</option>
                            <option value="completed">completed</option>
                        </select>
                        <input type="submit" value="update" name="update_order" class="option-btn">
                        <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');" class="delete-btn">delete</a>
                    </form>
                </div>
        <?php
            }
        } else {
            echo '<p class="empty">Belum ada pesanan!</p>';
        }
        ?>
    </div>

</section>

    <script src="js/admin_script.js"></script>

</body>

</html>