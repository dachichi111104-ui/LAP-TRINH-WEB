<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
include_once("config.php");
$user = null;
if (!isset($db) || !is_object($db)) {
    $db = new dienthoai();
}

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
  exit("Vui lòng đăng nhập để xem đánh giá và đơn hàng.");
}

$user = $db->LayThongTinKH($_SESSION['email']);
$idUser = $user['idUser'] ?? 0;
$idDH = intval($_GET['idDH'] ?? 0);

$order = $db->LayThongTinDonHang($idDH);
if (!$order || $order['idUser'] != $idUser) {
  exit("Không tìm thấy đơn hàng hoặc bạn không có quyền truy cập.");
}

$products = $db->LayChiTietDonHang($idDH);
?>

<div class="user-reviews">
  <h2>Đánh giá sản phẩm trong đơn hàng #<?= $idDH ?></h2>

  <?php if (empty($products)): ?>
    <p>Không có sản phẩm nào trong đơn hàng này.</p>
  <?php else: ?>
    <?php foreach ($products as $p): ?>
      <div class="review-item">
        <img src="HINH/<?= htmlspecialchars($p['hinhAnh']) ?>" alt="<?= htmlspecialchars($p['tenSP']) ?>">
        <div class="review-content">
          <h4><?= htmlspecialchars($p['tenSP']) ?></h4>
          <form method="post" action="process.php?action=save_review">
            <input type="hidden" name="idSP" value="<?= $p['idSP'] ?>">
                <input type="hidden" name="idDH" value="<?= $idDH ?>">
            <label>Chấm sao:</label>
            <select name="soSao">
              <option value="5">★★★★★</option>
              <option value="4">★★★★☆</option>
              <option value="3">★★★☆☆</option>
              <option value="2">★★☆☆☆</option>
              <option value="1">★☆☆☆☆</option>
            </select>
            <textarea name="noiDung" placeholder="Viết cảm nhận của bạn về sản phẩm này..."></textarea>
            <button type="submit">Gửi đánh giá</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
