<?php
include_once 'function.php';
$admin = new admin();

$idDH = isset($_GET['id']) ? intval($_GET['id']) : 0;
$dh = $admin->LayDonHangTheoID($idDH);
$listCT = $admin->LayChiTietDonHang($idDH);

if (!$dh) {
    echo "<p>Đơn hàng không tồn tại.</p>";
    exit;
}
?>
<div class="content">
    <h1>Chi tiết đơn hàng #<?= $dh['idDH'] ?></h1>
    <p><strong>Tổng tiền:</strong> <?= number_format($dh['tongTien']) ?> ₫</p>
    <p><strong>Trạng thái:</strong> <?= htmlspecialchars($dh['trangThai']) ?></p>

    <h3>Danh sách sản phẩm</h3>
    <table>
        <tr>
            <th>Hình</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
        </tr>
        <?php if (!empty($listCT)): ?>
            <?php foreach ($listCT as $ct): ?>
                <tr>
                    <td><img src="HINH/<?= htmlspecialchars($ct['hinhAnh']) ?>" ></td>
                    <td><?= htmlspecialchars($ct['tenSP']) ?></td>
                    <td><?= $ct['soLuong'] ?></td>
                    <td><?= number_format($ct['donGia']) ?> ₫</td>
                    <td><?= number_format($ct['soLuong'] * $ct['donGia']) ?> ₫</td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">Không có sản phẩm nào trong đơn này.</td></tr>
        <?php endif; ?>
    </table>

    <a href="admin.php?page=donhang" class="btn-back">← Quay lại</a>
</div>
