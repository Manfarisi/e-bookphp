<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_penulis = $_POST['product_penulis'];
   $product_stock = $_POST['product_stock'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   // Pastikan stok produk mencukupi
   if ($product_quantity > $product_stock) {
      $message[] = 'Pembelian Gagal, Pesanan Melebihi Stok';
   } else {
      // Cek apakah produk sudah ada di keranjang
      $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

      if (mysqli_num_rows($check_cart_numbers) > 0) {
         // Ambil jumlah produk dalam keranjang
         $cart_data = mysqli_fetch_assoc($check_cart_numbers);
         $total_quantity = $cart_data['quantity'] + $product_quantity;

         if ($total_quantity > $product_stock) {
            $message[] = 'Purchase failed! Total quantity in cart exceeds stock.';
         } else {
            // Update jumlah produk dalam keranjang
            mysqli_query($conn, "UPDATE `cart` SET quantity = '$total_quantity' WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

            // Kurangi stok di tabel products
            $new_stock = $product_stock - $product_quantity;
            mysqli_query($conn, "UPDATE `products` SET stock = '$new_stock' WHERE name = '$product_name'") or die('query failed');

            $message[] = 'Cart updated successfully!';
         }
      } else {
         // Tambahkan produk baru ke keranjang
         mysqli_query($conn, "INSERT INTO `cart`(user_id, name, penulis, price, quantity, image) VALUES('$user_id', '$product_name','$product_penulis', '$product_price', '$product_quantity', '$product_image')") or die('query failed');

         // Kurangi stok di tabel products
         $new_stock = $product_stock - $product_quantity;
         mysqli_query($conn, "UPDATE `products` SET stock = '$new_stock' WHERE name = '$product_name'") or die('query failed');

         $message[] = 'Pembelian Berhasil!, Cek Keranjang Sekarang';
      }
   }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Buku Kami</h3>
      <p> <a href="home.php">home</a> / shop </p>
   </div>

   <section class="products">

      <h1 class="title">E-Book</h1>

      <div class="box-container">

         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
         ?>
               <form action="" method="post" class="box">
                  <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                  <div class="name"><?php echo $fetch_products['name']; ?></div>
                  <div class="name"><?php echo $fetch_products['penulis']; ?></div>
                  <div class="price">Rp<?php echo number_format($fetch_products['price'], 0, ',', '.'); ?>,-</div>
                  <div class="name"><?php echo $fetch_products['stock']; ?></div>
                  <input type="number" min="1" name="product_quantity" value="1" class="qty">
                  <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                  <input type="hidden" name="product_penulis" value="<?php echo $fetch_products['penulis']; ?>">
                  <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                  <input type="hidden" name="product_stock" value="<?php echo $fetch_products['stock']; ?>">
                  <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                  <input type="submit" value="masukan ke keranjang" name="add_to_cart" class="btn">
               </form>
               
         <?php
            }
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
         ?>

      </div>

   </section>








   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>