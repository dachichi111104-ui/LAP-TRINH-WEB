<?php
include_once 'config.php'; 
$db = new dienthoai();
$hangSX = $db->ListHangSanXuat();
$keyword = trim($_GET['q'] ?? '');
$products = [];

if ($keyword !== '') {
    $products = $db->TimKiemSanPham($keyword); 
}
?>
<aside class="sidebar">
  <h3>Thương Hiệu</h3>
  <ul>
    <li><a href="index.php">Tất cả thương hiệu</a></li>
    <?php
    if (!empty($hangSX)) {
      foreach ($hangSX as $row) {
  ?>
        <li><a href="index.php?page=home&idHang=<?= $row['idHang'] ?>"><?= htmlspecialchars($row['tenHang']) ?></a></li>
  <?php
      }
    } else {
  ?>
        <li>Không có hãng nào</li>
  <?php
    }
    ?>
  </ul>
</aside>
<div class="main-content">
<main class="content">
  <h1>CHÀO MỪNG ĐẾN VỚI PHONESTORE 
    </br> ĐIỆN THOẠI THÔNG MINH CHO CHO CUỘC SỐNG HIỆN ĐẠI </h1>
  <p>Khám phá bộ sưu tập điện thoại thông minh mới nhất từ các thương hiệu hàng đầu thế giới. Tại PHONESTORE, chúng tôi cam kết mang đến cho bạn những sản phẩm chất lượng cao với giá cả hợp lý, cùng dịch vụ chăm sóc khách hàng tận tâm.</p>
</main>
<main class="content3">
  <?php
  $idHang = isset($_GET['idHang']) ? intval($_GET['idHang']) : 0;

    if ($idHang > 0) {
      $tenHang = '';
      foreach ($hangSX as $hsx) {
        if ($hsx['idHang'] == $idHang) {
          $tenHang = $hsx['tenHang'];
          break;
        }
      }
  ?>
    <h2>SẢN PHẨM CỦA THƯƠNG HIỆU <span style='color:#ff9900;'><?= htmlspecialchars($tenHang) ?></span></h2>
  <?php
    } else {
  ?>
    <h2>TẤT CẢ SẢN PHẨM</h2>
  <?php
    }
  ?>

  <div class="product-list">
  <?php
if ($idHang > 0) {
    $list = $db->HienThiSanPhamTheoHang($idHang);
} else {
    $list = $db->LayTatCaDienThoai();
}

if (!empty($list)) {
    foreach ($list as $sp) {
        $idSp = intval($sp['idSP']);
        $tenSp = htmlspecialchars($sp['tenSP']);
        $hinh = htmlspecialchars($sp['hinhAnh']);
        $gia = number_format($sp['gia'], 0, ',', '.');
        $tenHang = htmlspecialchars($sp['tenHang']);
  ?>
        <div class="dienthoai">
          <a href="index.php?page=product&idSP=<?= $idSp ?>" class="product-link">
            <img src="HINH/<?= $hinh ?>" alt="<?= $tenSp ?>" loading="lazy">
            <div class="product-info">
              <h3><?= $tenSp ?></h3>
              <p class="price"><?= $gia ?> ₫</p>
              <p class="brand"><?= $tenHang ?></p>
            </div>
          </a>

          <form method="post" action="process.php?action=add_to_cart">
            <input type="hidden" name="idSP" value="<?= $idSp ?>">
            <input type="hidden" name="tenSP" value="<?= $tenSp ?>">
            <input type="hidden" name="gia" value="<?= intval($sp['gia']); ?>">
            <input type="hidden" name="hinhAnh" value="<?= $hinh ?>">
            <button type="submit" name="add_to_cart" class="add-to-cart">
              <i class='bx bx-cart'></i> Thêm vào giỏ hàng
            </button>
          </form>
        </div>
  <?php
    }
} else {
?>
    <p style='text-align:center;'>Không có sản phẩm nào.</p>
<?php
}
  ?>
</div>