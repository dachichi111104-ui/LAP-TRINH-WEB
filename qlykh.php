<?php
include_once 'function.php';
$admin = new admin();

if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $kh = $admin->LayKhachHangTheoID($id);

    if (!$kh) {
        echo "<p style='color:red'>Khách hàng không tồn tại.</p>";
    } else {
        $res = $admin->XoaKhachHang($id);
        echo $res === true
            ? "<p style='color:green'>Đã xóa khách hàng: {$kh['hoTen']}</p>"
            : "<p style='color:red'>Lỗi khi xóa khách hàng: $res</p>";
    }
}

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$listKH = $admin->LayTatCaKhachHang($keyword);
?>
<div class="content">
    <h1>Quản lý Khách hàng</h1>

    <div class="actions">
        <form method="get" class="search-form">
            <input type="hidden" name="page" value="khachhang">
            <input type="text" name="keyword" placeholder="Tìm kiếm..." value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit">Tìm</button>
        </form>
        <a href="admin.php?page=themkh" class="btn-add">+ Thêm khách hàng mới</a>
    </div>

    <table>
        <tr>
            <th>ID</th><th>Họ tên</th><th>Email</th><th>SĐT</th><th>Địa chỉ</th><th>Thao tác</th>
        </tr>
        <?php if (!empty($listKH)): ?>
            <?php foreach ($listKH as $kh): ?>
                <tr>
                    <td><?= $kh['idUser'] ?></td>
                    <td><?= htmlspecialchars($kh['hoTen']) ?></td>
                    <td><?= htmlspecialchars($kh['email']) ?></td>
                    <td><?= htmlspecialchars($kh['soDienThoai']) ?></td>
                    <td><?= htmlspecialchars($kh['diaChi']) ?></td>
                    <td>
                        <a href="admin.php?page=suakh&id=<?= $kh['idUser'] ?>" class="btn-edit">Sửa</a>
                        <a href="admin.php?page=khachhang&delete_id=<?= $kh['idUser'] ?>" class="btn-delete" onclick="return confirm('Xóa khách hàng này?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">Không có dữ liệu.</td></tr>
        <?php endif; ?>
    </table>
</div>
