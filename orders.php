<?php
$db = new dienthoai();
$userInfo = $db->LayThongTinKH($_SESSION['email']);
$idUser = $userInfo['idUser'] ?? 0;

$status = $_GET['status'] ?? 'Tất cả';
$orders = $db->LayTatCaDonHangUser($idUser);
if ($status !== 'Tất cả') {
    $orders = array_filter($orders, fn($o) => ($o['trangThai'] ?? '') === $status);
}

$tabs = ['Tất cả', 'Chờ xác nhận', 'Đang giao', 'Hoàn thành', 'Đã hủy'];

?>
<h2 class="orders-title">Lịch sử mua hàng</h2>
<div class="order-tabs">
  <?php foreach ($tabs as $tab): ?>
    <a href="index.php?page=users&tab=orders&status=<?= urlencode($tab) ?>" 
       class="tab-link <?= ($tab === $status) ? 'active' : '' ?>">
      <?= $tab ?>
    </a>
  <?php endforeach; ?>
</div>
<?php if (!empty($_SESSION['msg'])): ?>
  <div class="alert-box">
    <?= htmlspecialchars($_SESSION['msg']) ?>
  </div>
  <?php unset($_SESSION['msg']);?>
<?php endif; ?>

<div class="orders-container">
<?php if (empty($orders)): ?>
  <div class="empty">Bạn chưa có đơn hàng nào trong trạng thái này.</div>
<?php else: ?>
  <?php foreach ($orders as $order): ?>
    <div class="order-card">
      <div class="order-header">
        <div>
          <strong>Đơn hàng #<?= $order['idDH'] ?></strong>
          <span class="date">• <?= htmlspecialchars($order['ngayDat'] ?? '') ?></span>
        </div>
        <?php
          $statusClass = match (strtolower(trim($order['trangThai']))) {
              'đang giao', 'hoàn thành' => 'status-green',
              'chờ xác nhận' => 'status-orange',
              'đã hủy' => 'status-red',
              default => 'status-gray'
          };
        ?>
        <span class="status <?= $statusClass ?>"><?= htmlspecialchars($order['trangThai']) ?></span>
      </div>

      <div class="order-body">
        <?php
          $items = $db->LayChiTietDonHang($order['idDH']);
          foreach ($items as $it):
        ?>
          <div class="order-item">
            <img src="HINH/<?= htmlspecialchars($it['hinhAnh']) ?>" alt="">
            <div class="order-item-info">
              <div class="item-name"><?= htmlspecialchars($it['tenSP']) ?></div>
              <div class="item-qty">x<?= $it['soLuong'] ?></div>
            </div>
            <div class="item-price"><?= number_format($it['donGia'], 0, ',', '.') ?> ₫</div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="order-footer">
        <div class="total">Tổng thanh toán: <strong><?= number_format($order['tongTien'], 0, ',', '.') ?> ₫</strong></div>
        <div class="order-actions">
          <?php if ($order['trangThai'] === 'Hoàn thành'): ?>
            <a href="index.php?page=users&tab=review&idDH=<?= $order['idDH'] ?>" class="btn btn-review">Đánh giá</a>
          <?php endif; ?>
          <a href="index.php?page=users&tab=orders_detail&idDH=<?= $order['idDH'] ?>" class="btn btn-detail">Xem chi tiết</a>
          <?php if ($order['trangThai'] === 'Chờ xác nhận'): ?>
          <form method="post" action="process.php?action=cancel_order" style="display:inline;">
            <input type="hidden" name="idDH" value="<?= $order['idDH'] ?>">
            <button type="submit" class="btn btn-cancel">Hủy đơn</button>
          </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
</div>
