<?php
if (!isset($db)) {
    include_once "config.php";
    $db = new dienthoai();
}

if (!isset($_SESSION)) session_start();
$idUser = $_SESSION['idUser'] ?? 0;
$user = $db->LayThongTinKH($_SESSION['email'] ?? '');
$allOrders = $db->LayTatCaDonHangUser($idUser);
$completedOrders = array_filter($allOrders, function($order) {
    return $order['trangThai'] === 'Hoàn thành';
});

$totalOrders = count($completedOrders);
$totalAmount = 0;
foreach ($completedOrders as $od) {
    $totalAmount += floatval($od['tongTien']);
}
?>

<div class="overview">
  <h2>Xin chào, <?= htmlspecialchars($user['hoTen'] ?? 'Người dùng') ?> </h2>
  <p class="welcome-text">Chào mừng bạn trở lại với <b>PhoneStore</b>! Dưới đây là thống kê tài khoản của bạn.</p>

  <div class="overview-stats">
    <div class="stat-card">
      <h3><?= $totalOrders ?></h3>
      <p>Đơn hàng</p>
    </div>
    <div class="stat-card">
      <h3><?= number_format($totalAmount, 0, ',', '.') ?> ₫</h3>
      <p>Tổng chi tiêu</p>
    </div>
  </div>

  <div class="overview-note">
    <p>Bạn có thể theo dõi đơn hàng, chỉnh sửa thông tin cá nhân và đánh giá sản phẩm đã mua tại các mục bên trái.</p>
  </div>
</div>
