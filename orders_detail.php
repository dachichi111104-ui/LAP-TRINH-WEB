<?php
$user = $db->LayThongTinKH($_SESSION['email']);
$idUser = $user['idUser'] ?? 0;
$idDH = intval($_GET['idDH'] ?? 0);

$orderList = $db->LayDonHangUser($idUser);
$order = null;

foreach ($orderList as $o) {
    if ($o['idDH'] == $idDH) {
        $order = $o;
        break;
    }
}

if (!$order) exit("Không tìm thấy đơn hàng");

$items = $db->LayChiTietDonHang($idDH);
?>

<div class="container2">
  <div class="header2">
    <h2>Đơn hàng #<?= $idDH ?></h2>
    <?php
    $trangThai = strtolower(trim($order['trangThai']));
    if (in_array($trangThai, ['đang giao', 'hoàn thành'])) {
        $statusClass = 'status-green';
    } elseif (in_array($trangThai, ['chờ xác nhận', 'đã hủy'])) {
        $statusClass = 'status-red';
    } else {
        $statusClass = 'status-orange';
    }
    ?>
    <span class="<?= $statusClass ?>"><?= htmlspecialchars($order['trangThai']) ?></span>
  </div>

  <div class="header2">
    <h3>Thông tin giao hàng</h3>
    <p><strong>Tên:</strong> <?= htmlspecialchars($user['hoTen']) ?></p>
    <p><strong>SĐT:</strong> <?= htmlspecialchars($user['soDienThoai']) ?></p>
    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['diaChiNhanHang']) ?></p>
    <p><strong>Phương thức:</strong> <?= $order['pttt'] === 'cod' ? 'Thanh toán khi nhận hàng' : 'Thẻ tín dụng/Ghi nợ' ?></p>
  </div>

  <div class="section2">
    <h3>Sản phẩm</h3>
    <?php foreach ($items as $i): ?>
      <div class="item2">
        <img src="HINH/<?= htmlspecialchars($i['hinhAnh']) ?>" alt="">
        <div class="item2-info">
          <div><?= htmlspecialchars($i['tenSP']) ?></div>
          <div>x<?= $i['soLuong'] ?></div>
        </div>
        <div><?= number_format($i['donGia'] * $i['soLuong'], 0, ',', '.') ?> ₫</div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="total2">
    <strong>Tổng cộng:</strong> <?= number_format($order['tongTien'], 0, ',', '.') ?> ₫
  </div>

  <a href="index.php?page=users&tab=orders" class="btn-backk">← Quay lại</a>

  <?php if (stripos($order['trangThai'], 'Hoàn') !== false): ?>
    <div class="review-section">
      <hr><br>
      <h3>Đánh giá đơn hàng</h3>
      <p>Bạn có hài lòng với sản phẩm không?</p>
      <a href="index.php?page=users&tab=review&idDH=<?= $idDH ?>" class="btn-review">Đánh giá ngay</a>
    </div>
  <?php endif; ?>

  <?php if (stripos($order['trangThai'], 'chờ xác nhận') !== false): ?>
    <form method="post" action="process.php?action=cancel_order" style="display:inline;">
      <input type="hidden" name="idDH" value="<?= $idDH ?>">
      <button type="submit" class="btn btn-cancel">Hủy đơn</button>
    </form>
  <?php endif; ?>
</div>
