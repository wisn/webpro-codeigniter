<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$post = [];

if ($this->session->flashdata('post') != NULL)
  $post = $this->session->flashdata('post');
?>

<?php $this->view('partials/head'); ?>
<body class="register-page">
  <?php $this->view('partials/header'); ?>
  <main>
    <div class="container">
      <?php echo form_open('user/signup'); ?>
        <h1><a href="<?php echo base_url(); ?>">Bukube</a></h1>
        <span style="width: 75%" class="unique-underline"></span>

        <?php if (($msg = $this->session->flashdata('msg')) != NULL): ?>
          <div class="alert alert-danger" style="margin-top: 2em">
            Error occurred:
            <ul>
              <?php foreach ($msg as $m): ?>
                <li><?php echo $m; ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <input type="text" name="email" placeholder="Email" value="<?php if (isset($post['email'])) echo $post['email']; ?>" required>
        <input type="text" name="username" placeholder="Username" value="<?php if (isset($post['username'])) echo $post['username']; ?>" required>
        <input type="text" name="fullname" placeholder="Full Name" value="<?php if (isset($post['fullname'])) echo $post['fullname']; ?>">
        <input type="password" name="password" placeholder="Password" />
        <input type="submit" value="Sign Up" />
      </form>
    </div>
    <?php $this->view('partials/carts'); ?>
  </main>
<?php $this->view('partials/footer'); ?>
