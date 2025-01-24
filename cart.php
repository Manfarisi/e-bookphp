<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}


if (isset($_POST['buy_product'])) {
   $product_id = $_POST['product_id'];
   $product_penulis = $_POST['product_penulis'];
   $quantity = $_POST['quantity'];

   $product_query = mysqli_query($conn, "SELECT stock FROM products WHERE id = '$product_id'") or die('query failed');
   $product_data = mysqli_fetch_assoc($product_query);
   $current_stock = $product_data['stock'];

   if ($quantity > $current_stock) {
       $message[] = 'Jumlah produk melebihi stok yang tersedia!';
   } else {
       // Kurangi stok dari database
       $new_stock = $current_stock - $quantity;
       mysqli_query($conn, "UPDATE products SET stock = '$new_stock' WHERE id = '$product_id'") or die('query failed');
       $message[] = 'Pembelian berhasil!';
   }
}

if (isset($_POST['remove_from_cart'])) {
   $cart_id = $_POST['cart_id'];
   $product_name = $_POST['product_name'];
   $product_penulis = $_POST['product_penulis'];
   $product_quantity = $_POST['product_quantity'];

   // Ambil stok produk saat ini dari tabel `products`
   $select_stock = mysqli_query($conn, "SELECT stock FROM `products` WHERE name = '$product_name'") or die('query failed');
   $fetch_stock = mysqli_fetch_assoc($select_stock);
   $current_stock = $fetch_stock['stock'];

   // Kembalikan stok produk
   $updated_stock = $current_stock + $product_quantity;
   mysqli_query($conn, "UPDATE `products` SET stock = '$updated_stock' WHERE name = '$product_name'") or die('query failed');

   // Hapus produk dari keranjang
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$cart_id'") or die('query failed');
   $message[] = 'Produk berhasil dihapus dari keranjang dan stok dikembalikan!';
}


if (isset($_POST['cancel_order'])) {
   $user_id = $_SESSION['user_id'];

   // Ambil semua produk dalam keranjang
   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

   if (mysqli_num_rows($select_cart) > 0) {
      while ($cart_item = mysqli_fetch_assoc($select_cart)) {
         $product_name = $cart_item['name'];
         $product_quantity = $cart_item['quantity'];

         // Ambil stok produk saat ini dari tabel `products`
         $select_stock = mysqli_query($conn, "SELECT stock FROM `products` WHERE name = '$product_name'") or die('query failed');
         $fetch_stock = mysqli_fetch_assoc($select_stock);
         $current_stock = $fetch_stock['stock'];

         // Kembalikan stok produk
         $updated_stock = $current_stock + $product_quantity;
         mysqli_query($conn, "UPDATE `products` SET stock = '$updated_stock' WHERE name = '$product_name'") or die('query failed');
      }

      // Kosongkan keranjang
      mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      $message[] = 'Pesanan berhasil dibatalkan!';
   } else {
      $message[] = 'Keranjang kosong, tidak ada yang dibatalkan!';
   }
}




if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
   $message[] = 'cart quantity updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>keranjang belanja</h3>
   <p> <a href="home.php">home</a> / cart </p>
</div>

<section class="shopping-cart">

   <h1 class="title">jumlah produk</h1>

   <div class="box-container">
      <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_cart['name']; ?></div>
         <div class="name"><?php echo $fetch_cart['penulis']; ?></div>
         <div class="price">Rp<?php echo number_format($fetch_cart['price'], 0, ',', '.'); ?></div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
            <input type="submit" name="update_cart" value="update" class="option-btn">
            <input type="submit" name="cancel_order" value="Batalkan Pesanan" class="btn">
         </form>
         <div class="sub-total"> Harga Buku : <span>Rp<?php echo number_format($sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']), 0, ',', '.'); ?></span> </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty">Tidak Ada Daftar Belanja</p>';
      }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">Hapus Semua</a>
   </div>

   <div class="cart-total">
      <p>Total Tagihan : <span>Rp<?php echo number_format ($grand_total, 0, ',', '.'); ?></span></p>
      <div class="flex">
         <a href="shop.php" class="option-btn">Tambah Buku Baru</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled';?>">Proses Pembayaran</a>
      </div>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>