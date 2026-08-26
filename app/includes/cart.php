<?php
$user = current_user();
?>
<button class="cart-fab" id="cartFab" aria-label="Open cart" type="button">
    <i class="fa-solid fa-cart-shopping"></i>
    <span class="fab-count">0</span>
</button>
<div class="cart-overlay" id="cartOverlay"></div>
<aside class="cart-drawer" id="cartDrawer" aria-label="Shopping cart" aria-hidden="true">
    <header class="cart-head">
        <h2><i class="fa-solid fa-basket-shopping"></i> Your cart</h2>
        <button class="icon-btn" id="cartClose" aria-label="Close cart" type="button"><i class="fa-solid fa-xmark"></i></button>
    </header>
    <div class="cart-user">
        <img src="<?= e(asset($user['avatar'])) ?>" alt="Profile picture of <?= e($user['name']) ?>">
        <div>
            <strong><?= e($user['name']) ?></strong>
            <span><?= e($user['city']) ?>, <?= e($user['country']) ?> · ID <?= e($user['id']) ?></span>
        </div>
    </div>
    <div class="cart-items" id="cartItems"></div>
    <div class="cart-empty" id="cartEmpty">
        <i class="fa-solid fa-basket-shopping"></i>
        <p>Your cart is empty</p>
        <span class="small muted">Add some fresh fruit from the harvest!</span>
    </div>
    <footer class="cart-foot" style="display:none">
        <div class="cart-line"><span>Subtotal</span><span id="cartSubtotal">0 XAF</span></div>
        <div class="cart-line"><span>Delivery</span><span id="cartDelivery">—</span></div>
        <div class="cart-line total"><span>Total</span><span id="cartTotal">0 XAF</span></div>
        <button class="btn btn-accent btn-block" id="checkoutBtn" type="button"><i class="fa-solid fa-wallet"></i> Checkout</button>
        <p class="cart-note">Free delivery in Yaoundé on orders over 20,000 XAF</p>
    </footer>
</aside>
