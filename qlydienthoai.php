<?php
include_once 'function.php';
$admin = new admin();

if (isset($_GET['delete_id'])) {
    $idSP = intval($_GET['delete_id']);
    $sp = $admin->LaySanPhamTheoID($idSP);

    if (!$sp) {
        echo "<p style='color:red'>Sản phẩm không tồn tại.</p>";
    } else {
        $res = $admin->XoaDienThoai($idSP);
        if ($res === true) {
            echo "<p style='color:green'>Đã xóa sản phẩm: {$sp['tenSP']}</p>";
        } else {
            echo "<p style='color:red'>Lỗi khi xóa sản phẩm: $res</p>";
        }
    }
}
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$listDT = $admin->LayTatCaDienThoaiAdmin($keyword);
?>
<div class="content">
    <h1>Quản lý Điện thoại</h1>
    <div class="actions">
        <form method="get" class="search-form">
            <input type="hidden" name="page" value="dienthoai">
            <input type="text" name="keyword" placeholder="Tìm kiếm..." value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit">Tìm</button>
        </form>
        <a href="admin.php?page=themsp" class="btn-add">+ Thêm sản phẩm mới</a>
    </div>
    <table>
        <tr>
            <th>ID</th>
            <th>Tên điện thoại</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Hình ảnh</th>
            <th>Mô tả</th>
            <th>Hãng</th>
            <th>Thao tác</th>
        </tr>
        <?php if (!empty($listDT)): ?>
            <?php foreach ($listDT as $sp): ?>
                <tr>
                    <td><?= $sp['idSP'] ?></td>
                    <td><?= htmlspecialchars($sp['tenSP']) ?></td>
                    <td><?= number_format($sp['gia']) ?> ₫</td>
                    <td><?= $sp['soLuong'] ?></td>
                    <td><img src="HINH/<?= htmlspecialchars($sp['hinhAnh']) ?>" width="70"></td>
                    <td><?= htmlspecialchars($sp['moTa']) ?></td>
                    <td><?= htmlspecialchars($sp['tenHang']) ?></td>
                    <td>
                        <a href="admin.php?page=suasp&idSP=<?= $sp['idSP'] ?>" class="btn-edit">Sửa</a>
                        <a href="admin.php?page=dienthoai&delete_id=<?= $sp['idSP'] ?>"class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
       </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">Không có dữ liệu.</td></tr>
        <?php endif; ?>
    </table>
</div>