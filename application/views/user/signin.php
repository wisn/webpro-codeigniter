<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$post = [];

if ($this->session->flashdata('post') != NULL)
  $post = $this->session->flashdata('post');
?>
?>

<?php $this->view('partials/head'); ?>
<body class="login-page">
  <?php $this->view('partials/header'); ?>
  <main>
    <div class="container">
      <?php echo form_open('user/signin'); ?>
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

        <input type="text" name="identifier" placeholder="Identifier" value="<?php if (isset($post['identifier'])) echo $post['identifier']; ?>" required>
        <input type="password" name="password" placeholder="Password" value="<?php if (isset($post['password'])) echo $post['password']; ?>" required>
        <input type="submit" value="Sign In">
      </form>
    </div>
    <?php $this->view('partials/carts'); ?>
  </main>
<?php $this->view('partials/footer'); ?>
