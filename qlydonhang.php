<?php
include_once 'function.php';
$admin = new admin();

if (isset($_GET['delete_id'])) {
    $idDH = intval($_GET['delete_id']);
    $don = $admin->LayDonHangTheoID($idDH);
    if (!$don) {
        echo "<p style='color:red'>Đơn hàng không tồn tại.</p>";
    } else {
        $res = $admin->XoaDonHang($idDH);
        echo $res === true
            ? "<p style='color:green'>Đã xóa đơn hàng #$idDH.</p>"
            : "<p style='color:red'>Lỗi khi xóa: $res</p>";
    }
}

$status = isset($_GET['status']) ? trim($_GET['status']) : '';
if ($status !== '') {
    $allOrders = $admin->LayTatCaDonHang(); 
    $listDH = array_filter($allOrders, function($dh) use ($status) {
        return $dh['trangThai'] === $status;
    });
} else {
    $listDH = $admin->LayTatCaDonHang();
}
?>

<div class="content">
    <h1>Quản lý Đơn hàng</h1>

    <div class="actions">
        <form method="get" class="search-form">
            <input type="hidden" name="page" value="donhang">
            <select name="status">
                <option value="">-- Tất cả trạng thái --</option>
                <option value="Chờ xác nhận" <?= $status=="Chờ xác nhận"?'selected':'' ?>>Chờ xác nhận</option>
                <option value="Đang giao" <?= $status=="Đang giao"?'selected':'' ?>>Đang giao</option>
                <option value="Hoàn thành" <?= $status=="Hoàn thành"?'selected':'' ?>>Hoàn thành</option>
                <option value="Đã hủy" <?= $status=="Đã hủy"?'selected':'' ?>>Đã hủy</option>
            </select>
            <button type="submit">Lọc</button>
        </form>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Ngày đặt</th>
            <th>Ghi chú</th>
            <th>Thao tác</th>
        </tr>
        <?php if (!empty($listDH)): ?>
            <?php foreach ($listDH as $dh): ?>
                <tr>
                    <td><?= $dh['idDH'] ?></td>
                    <td><?= htmlspecialchars($dh['hoTen']) ?></td>
                    <td><?= number_format($dh['tongTien']) ?> ₫</td>
                    <td><?= htmlspecialchars($dh['trangThai']) ?></td>
                    <td><?= htmlspecialchars($dh['ngayDat']) ?></td>
                    <td><?= htmlspecialchars($dh['ghiChu']) ?></td>
                    <td>
                        <a href="admin.php?page=suadonhang&idDH=<?= $dh['idDH'] ?>" class="btn-edit">Sửa</a>
                        <a href="admin.php?page=chitietdonhang&id=<?= $dh['idDH'] ?>" class="btn-edit">Chi tiết</a>
                        <a href="admin.php?page=donhang&delete_id=<?= $dh['idDH'] ?>" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7">Không có đơn hàng nào.</td></tr>
        <?php endif; ?>
    </table>
</div>
