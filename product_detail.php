<?php
session_start ();
include_once 'config.php';
$db = new dienthoai();

$idSP = isset($_GET['idSP']) ? intval($_GET['idSP']) : 0;
$sp = $db->LayChiTietSanPham($idSP);

if (!$sp) {
    header("Location: index.php?error=product_not_found");
    exit();
}
?>

  <main class="product-detail">
    <div class="product-image">
      <img src="HINH/<?php echo $sp['hinhAnh']; ?>" alt="<?php echo $sp['tenSP']; ?>">
    </div>

    <div class="product-info">
      <h2><?php echo $sp['tenSP']; ?></h2>
      <p><strong>Giá:</strong> <?php echo number_format($sp['gia'], 0, ',', '.'); ?> VND</p>
      <p><strong>Thương hiệu:</strong> <?php echo $sp['tenHang'] ?: 'Không xác định'; ?></p>
      <p><strong>Còn lại:</strong> <?php echo $sp['soLuong']; ?></p>
      <p><strong>Mô tả:</strong> <?php echo nl2br($sp['moTa']); ?></p>

      <form method="post" action="process.php?action=add_to_cart">
        <input type="hidden" name="idSP" value="<?php echo $sp['idSP']; ?>">
        <input type="hidden" name="tenSP" value="<?php echo $sp['tenSP']; ?>">
        <input type="hidden" name="gia" value="<?php echo $sp['gia']; ?>">
        <input type="hidden" name="hinhAnh" value="<?php echo $sp['hinhAnh']; ?>">
            <button type="submit" name="add_to_cart" class="add-to-cart">
              <i class='bx bx-cart'></i>Thêm vào giỏ hàng
            </button>
      </form>

      <a href="index.php" class="btn-backk">← Quay lại</a>
    </div>
  </main>
