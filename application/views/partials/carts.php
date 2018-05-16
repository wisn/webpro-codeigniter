<div class="carts">
  <h3>Shopping Cart</h3>
  <?php if ($this->session->userdata('carts') == NULL): ?>
    <span>There is no item.</span>
  <?php else: ?>
    <div class="card">
      <ul class="list-group list-group-flush">
        <?php foreach ($this->session->userdata('carts') as $cart): ?>
          <li class="list-group-item">
            <?php echo $cart['title']; ?>
            <div style="font-size: 10pt">
              Rp. <?php echo $cart['price']; ?>
              by <?php echo $cart['fullname']; ?>
            </div>
            <div align="right">
              <a href="<?php echo base_url(); ?>cart/remove_book/<?php echo $cart['book_id']; ?>">(remove)</a>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div style="margin: 1em 0 0; padding: 0 .25em">
      <a class="btn btn-outline-success btn-block">Order</a>
    </div>
  <?php endif; ?>
</div>