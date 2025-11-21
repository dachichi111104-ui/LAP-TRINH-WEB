<?php
include_once 'config.php';
$db = new dienthoai();
$keyword = trim($_GET['q'] ?? '');
$products = [];
if ($keyword !== '') {
    $products = $db->TimKiemSanPham($keyword);
}
?>
  <main class="content3">
    <h2>KẾT QUẢ TÌM KIẾM</h2>
    <p>Từ khóa: <strong><?= htmlspecialchars($keyword) ?></strong></p>
    <br>
    <div class="product-list">
      <?php if (!empty($products)): ?>
        <?php foreach ($products as $sp): 
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
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align:center;">Không tìm thấy sản phẩm nào phù hợp.</p>
      <?php endif; ?>
    </div>
  </main>
</div>
