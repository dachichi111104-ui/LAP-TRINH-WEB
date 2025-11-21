<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
include_once 'config.php';
$db = new dienthoai();

$cart_items = $cart_items ?? $db->LayGioHang();
if (!is_array($cart_items)) $cart_items = [];

$total_amount = $total_amount ?? $db->TinhTongTienGioHang();
?>

<h1>Giỏ hàng của bạn</h1>

<main class="shopping-cart">
  <div class="cart-main">
    <?php if (empty($cart_items)): ?>
      <p class="empty-message">Giỏ hàng của bạn đang trống.</p>
    <?php else: ?>

      <table class="cart-table">
        <tbody>
          <?php foreach ($cart_items as $item): ?>
          <tr>
            <td class="product-cell">
 
              <img src="HINH/<?= htmlspecialchars($item['hinhAnh']) ?>" alt="<?= htmlspecialchars($item['tenSP']) ?>">
              <div><?= htmlspecialchars($item['tenSP']) ?></div>
            </td>
            <td class="price-cell"><?= number_format($item['gia'], 0, ',', '.') ?>đ</td>
            <td>
              <div class="quantity-control">
                <form method="post" action="process.php?action=update_cart" style="display:inline;">
                  <input type="hidden" name="idSP" value="<?= intval($item['idSP']) ?>">
                  <input type="hidden" name="change" value="-1">
                  <button type="submit">−</button>
                </form>

                <span><?= intval($item['soLuong']) ?></span>

                <form method="post" action="process.php?action=update_cart" style="display:inline;">
                  <input type="hidden" name="idSP" value="<?= intval($item['idSP']) ?>">
                  <input type="hidden" name="change" value="1">
                  <button type="submit">+</button>
                </form>
              </div>
            </td>
            <td class="price-cell"><?= number_format($item['gia'] * $item['soLuong'], 0, ',', '.') ?>đ</td>
            <td>

            <form method="post" action="process.php?action=remove_from_cart" onsubmit="return confirm('Xóa sản phẩm khỏi giỏ hàng?');">
                <input type="hidden" name="idSP" value="<?= intval($item['idSP']) ?>">
                <button type="submit" class="clear-cart">×</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

  <div class="cart-side">
    <h2 class="summary-title">Tóm tắt đơn hàng</h2>
    <div class="summary-row">
      <span>Tổng sản phẩm:</span>
      <span><?= count($cart_items) ?></span>
    </div>
    <div class="summary-row summary-total">
      <span>Tổng cộng:</span>
      <span><?= number_format($total_amount, 0, ',', '.') ?> VND</span>
    </div>

    <?php if (!empty($cart_items)): ?>
      <a href="index.php?page=checkout" class="checkout-btn">Tiến hành thanh toán</a>

      <form method="post" action="process.php?action=clear_cart" onsubmit="return confirm('Xóa tất cả sản phẩm khỏi giỏ hàng?');">
        <button type="submit" class="clear-cart">Xóa giỏ hàng</button>
      </form>
    <?php endif; ?>

    <a href="index.php" class="continue-shopping">← Tiếp tục mua sắm</a>
  </div>
</main>


