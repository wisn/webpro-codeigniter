<div class="carts">
  <h3>Shopping Cart</h3>
  <?php if ($this->session->userdata('cart') == NULL): ?>
    <span>There is no item.</span>
  <?php endif; ?>
</div>