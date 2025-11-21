<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$idDon = $_SESSION['idDH'] ?? null;
$total_amount = $_SESSION['tongTien'] ?? 0;
?>
<main class="payment-page">
  <div class="payment-container">
    <div class="loading-box">
      <div class="circle-loader"></div>
      <h2>Đang xử lý thanh toán...</h2>
      <p>Vui lòng không tắt trang này</p>
      <p class="secure"><i class='bx bx-lock'></i> Giao dịch được bảo mật</p>
    </div>

    <div class="success-box">
      <div class="checkmark"></div>
      <h2>Đặt hàng thành công!</h2>
      <p>Đơn hàng của bạn đã được xác nhận và sẽ được giao trong 2-3 ngày</p>
      <div class="order-details">
        <p><strong>Mã đơn hàng:</strong> #<?= $idDon ?? '12345' ?></p>
        <p><strong>Tổng tiền:</strong> <?= number_format($total_amount, 0, ',', '.') ?> ₫</p>
        <p><strong>Phương thức:</strong> Thanh toán khi nhận hàng (COD)</p>
      </div>
      <a href="index.php?page=users&tab=orders" class="btn-view">Xem đơn hàng</a>
    </div>
  </div>
</main>
