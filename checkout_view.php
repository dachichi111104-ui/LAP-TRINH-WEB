<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
include_once 'config.php';
$db = new dienthoai();

$cart_items = $cart_items ?? $db->LayGioHang();
if (!is_array($cart_items)) $cart_items = [];

$tongTien = $total_amount ?? $db->TinhTongTienGioHang();
$tongTien = $tongTien ?: 0;

$userInfo = $userInfo ?? [];
if (empty($userInfo) && !empty($_SESSION['email'])) {
    $tmp = $db->LayThongTinKH($_SESSION['email']);
    if (is_array($tmp)) $userInfo = $tmp;
}
?>

</br>
</br> </br>
<h1 class="checkout-title">Thanh toán đơn hàng</h1>
<main class="checkout-page">
  <div class="checkout-left">
<form method="post" action="process.php?action=checkout">
      <input type="hidden" name="action" value="checkout">
      <div class="checkout-section">
        <a href="index.php?page=cart" class="btn-backk">← Quay lại</a>
</br>
        <h3>Thông tin khách hàng</h3>
        <div class="checkout-form">
          <div>
            <label>Họ và tên *</label>
<input type="text" name="hoTen" value="<?= htmlspecialchars($userInfo['hoTen'] ?? '') ?>" readonly>
          </div>
          <div>
            <label>Số điện thoại *</label>
<input type="text" name="soDienThoai" value="<?= htmlspecialchars($userInfo['soDienThoai'] ?? '') ?>" readonly>
          </div>
          <div style="grid-column: 1 / span 2;">
            <label>Email *</label>
<input type="email" name="email" value="<?= htmlspecialchars($userInfo['email'] ?? '') ?>" readonly>
          </div>
          <div style="grid-column: 1 / span 2;">
            <label>Địa chỉ giao hàng *</label>
            <input type="text" name="diachi" value="<?= htmlspecialchars($userInfo['diaChi']??'') ?>" required>
          </div>
          <div style="grid-column: 1 / span 2;">
            <label>Ghi chú (tùy chọn)</label>
            <textarea name="ghichu"></textarea>
          </div>
        </div>
      </div>

      <div class="checkout-section">
        <h3>Phương thức thanh toán</h3>
        <div class="payment-options">
          <label><input type="radio" name="pttt" value="cod" checked> Thanh toán khi nhận hàng (COD)</label>
          <label><input type="radio" name="pttt" value="card"> Thẻ tín dụng / Ghi nợ</label>
        </div>
      </div>
  </div>

  <div class="checkout-right">
    <h3>Đơn hàng của bạn</h3>
    <?php foreach ($cart_items as $item): ?>
      <div class="order-item">
        <img src="HINH/<?= htmlspecialchars($item['hinhAnh']) ?>">
        <div class="order-item-info">
          <div class="order-item-name"><?= htmlspecialchars($item['tenSP']) ?></div>
          <div class="order-item-qty">x<?= $item['soLuong'] ?></div>
        </div>
        <div><?= number_format($item['gia'] * $item['soLuong'], 0, ',', '.') ?> ₫</div>
      </div>
    <?php endforeach; ?>

    <?php
      $tongTien = $db->TinhTongTienGioHang();
      $phiShip = ($tongTien >= 500000) ? 0 : 30000;
      $tongCong = $tongTien + $phiShip;
    ?>
    <div class="summary-line"><span>Tạm tính</span><span><?= number_format($tongTien, 0, ',', '.') ?> ₫</span></div>
    <div class="summary-line"><span>Phí vận chuyển</span><span><?= $phiShip ? number_format($phiShip, 0, ',', '.') . ' ₫' : 'Miễn phí' ?></span></div>
    <div class="summary-total"><span>Tổng cộng</span><span><?= number_format($tongCong, 0, ',', '.') ?> ₫</span></div>

    <button type="submit" name="confirm_order" class="pay-btn">Thanh toán <?= number_format($tongCong, 0, ',', '.') ?> ₫</button>
    <div class="secure-text">Giao dịch được bảo mật SSL 256-bit</div>
  </div>
  </form>
</main>
