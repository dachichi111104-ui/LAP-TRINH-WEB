<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!$db->KiemTraDangNhap()) {
header("Location: login.php");
exit();
}
include_once 'config.php';
$db = new dienthoai();

$user = $db->LayThongTinKH($_SESSION['email']);
$idUser = $user['idUser'] ?? 0;
$ordersAll = $db->LayTatCaDonHangUser($idUser);
$totalOrders = count($ordersAll);
$totalAmount = 0;
foreach ($ordersAll as $od) $totalAmount += floatval($od['tongCong'] ?? $od['tongTien'] ?? 0);
$tab = $_GET['tab'] ?? 'overview';
$sub = $_GET['sub'] ?? '';
?>
  <div class="user-main">
    <aside class="user-sidebar">
      <ul>
        <li class="<?= $tab==='overview' ? 'active' : '' ?>"><a href="index.php?page=users&tab=overview">Tổng quan</a></li>
        <li class="<?= $tab==='orders' ? 'active' : '' ?>"><a href="index.php?page=users&tab=orders">Lịch sử mua hàng</a></li>
        <li class="<?= $tab==='profile' ? 'active' : '' ?>"><a href="index.php?page=users&tab=profile">Thông tin tài khoản</a></li>
        <li><a href="process.php?action=logout">Đăng xuất</a></li>
      </ul>
    </aside>
    <section class="user-content">
      <?php if (!empty($_SESSION['msg'])): ?>
  <div class="alert success">
      <?= htmlspecialchars($_SESSION['msg']) ?>
  </div>
  <?php unset($_SESSION['msg']); ?>
<?php endif; ?>
      <?php
        if ($tab === 'overview') {
          include 'overview.php'; 
        } elseif ($tab === 'orders') {
          include 'orders.php'; 
        } elseif ($tab === 'orders_detail') {
          include 'orders_detail.php';
        } elseif ($tab === 'profile') {
          include 'profileuser.php'; 
        } elseif ($tab === 'review') {
          include 'review.php';
        } else {
          include 'overview.php';
        }
      ?>
    </section>
  </div>
</div>
