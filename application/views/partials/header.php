<header>
  <nav class="navbar navbar-light navbar-expand-lg fixed-top">
    <div class="container">
      <a href="<?php echo base_url(); ?>" class="navbar-brand">
        <img src="<?php echo base_url(); ?>assets/img/bukube.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Bukube
      </a>
      <button type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
        <span class="fa fa-bars"></span></button>
      <div id="navbarNav" class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item <?php if ($page == '/') echo 'active'; ?>">
            <a href="<?php echo base_url(); ?>" class="nav-link">
              Home
            </a>
          </li>
          <li class="nav-item <?php if ($page == 'shop') echo 'active'; ?>">
            <a href="<?php echo base_url(); ?>shop" class="nav-link">Buy Book</a></li>
          <li class="nav-item <?php if ($page == 'book/submit') echo 'active'; ?>">
            <a href="<?php echo base_url(); ?>book/submit" class="nav-link">Sell Book</a></li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>carts/" class="nav-link">
              <i class="fa fa-shopping-cart"></i></a>
          </li>
          <?php if ($this->session->userdata('user') == NULL): ?>
            <li class="nav-item <?php if ($page == 'user/signup') echo 'active'; ?>">
              <a href="<?php echo base_url(); ?>user/signup" class="nav-link">Sign up</a>
            </li>
            <li class="nav-item <?php if ($page == 'user/signin') echo 'active'; ?>">
              <a href="<?php echo base_url(); ?>user/signin" class="nav-link">Sign in</a>
            </li>
          <?php else: ?>
            <li class="nav-item <?php if ($page == 'user/profile') echo 'active'; ?>">
              <a href="<?php echo base_url(); ?>user/profile" class="nav-link">
                Account
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>user/signout" class="nav-link">
                Sign out
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>