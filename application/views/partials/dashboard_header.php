<nav class="nav flex-column nav-pills">
  <a class="nav-link <?php if ($page == 'user/profile') echo 'active'; ?>" href="<?php echo base_url(); ?>user/profile">Profile</a>
  <a class="nav-link <?php if ($page == 'user/books') echo 'active'; ?>" href="<?php echo base_url(); ?>user/books">Books</a>
  <a class="nav-link <?php if ($page == 'user/orders') echo 'active'; ?>" href="<?php echo base_url(); ?>user/orders">Orders</a>
  <a class="nav-link <?php if ($page == 'user/inquiries') echo 'active'; ?>" href="<?php echo base_url(); ?>user/inquiries">Inquiries</a>
</nav>